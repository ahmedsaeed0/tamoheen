<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShipmentBooking;
use App\Models\TripBooking;
use App\Models\Passengers;
use App\Models\PartnerAmount;
use App\Models\Trip;
use App\Models\User;
use App\Models\City;
use App\Models\Order;
use App\Models\Car;
use App\Models\PartnerMeta;
use PDF;
use App\Mail\BookingUserTrip;
use App\Mail\CustomerBoardingPass;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DNS2D;
use DB;
use Storage;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;


class TelrController extends Controller
{
    public function telrTripPayment($id)
    {
     
        if(app()->getLocale() == 'ar'){
            Config::set('telr.create.return_auth', env('TELR_AR_TRIP_SUCCESS_URL'));
            Config::set('telr.create.return_can', env('TELR_AR_TRIP_CANCEL_URL'));
            Config::set('telr.create.return_decl', env('TELR_AR_TRIP_DECLINE_URL'));
        }else{
            Config::set('telr.create.return_auth', env('TELR_TRIP_SUCCESS_URL'));
            Config::set('telr.create.return_can', env('TELR_TRIP_CANCEL_URL'));
            Config::set('telr.create.return_decl', env('TELR_TRIP_DECLINE_URL'));
        }

        Session::put('trip_booking_id', $id);
        
    	$tripbooking = TripBooking::findOrFail($id);
    	// dd($tripbooking);
        
    	Session::put('user_id', $tripbooking->user_id);

        $trip = Trip::where('id', $tripbooking->trip_id)->first();
    	$user = User::where('id', $tripbooking->user_id)->first();
        
        $name = $user->name;
	    $email = $user->email;
        $phone = $user->mobile;

        $arr_name = explode(" ", $name);
	    $last_word  = $arr_name[count($arr_name)-1];
	    $count_name_arr = count($arr_name);

	    if($count_name_arr > 2){
	        $first_name = $arr_name[0];
	        $last_name = $last_word;

	    }elseif ($count_name_arr == 2) {
	        $first_name = $arr_name[0];
	        $last_name = $arr_name[1];
	    }else{
	        $first_name = $arr_name[0];
	        $last_name = 'ABCD';
	    }

        $city_from_data = City::with(['states' => function($q){
    		$q->with('countries');
    	}])->where('id', $trip->city_from_id)->first();

        $telrManager = new \TelrGateway\TelrManager();
        //echo "<pre>"; print_r($telrManager);die;
        $billingParams = [
            'first_name' => $first_name,
            'sur_name' => $last_name,
            'address_1' => $city_from_data->name.' '.$city_from_data->states->name,
            'city' => $city_from_data->name,
            'region' => $city_from_data->states->name,
            'zip' => '12345',
            'country' => 'SAU',
            'email' => $email,
            'phone' => $phone,
        ];

        //echo "<pre>"; print_r($billingParams);die;
        $user_amount = PartnerAmount::where('partner_id', $tripbooking->user_id)->first();
        $wallet_balance  = 0;
        if($user_amount != null){
            $wallet_balance  =  $user_amount->total_amount;
        }
        $price = (float) $tripbooking->price - $wallet_balance;
        //($price>0)?$price:0;
        // echo $price;die;
        return $telrManager->pay((int) $id, $price, 'Trip Booking', $billingParams)->redirect();


}
      






    public function telrTripResponseBookingSuccess (Request $request, $id = null)
    {
        if ($id == 'declined' || $id == 'cancel') {
            if (!session('payment_failed')) {
                session()->put('payment_failed', true);
            }
            return redirect('/');
        }
        $telrManager = new \TelrGateway\TelrManager();

        $result = $telrManager->handleTransactionResponse($request);
        $trip_booking_id = $result->order_id;
        $tripbooking = TripBooking::findOrFail($trip_booking_id);
        
        $user_amount = PartnerAmount::where('partner_id', $tripbooking->user_id)->first();
        $wallet_balance  = 0;
        if($user_amount != null){
            $wallet_balance  =  $user_amount->total_amount;
            $user_amount->total_amount = (($wallet_balance -  $tripbooking->price)>0) ? ($wallet_balance -  $tripbooking->price):0 ;
             $user_amount->save();
        }
        
        $tripbooking->wallet_balance = $wallet_balance;
        $tripbooking->payment_method = 'Telr';
        $tripbooking->trx_id = $result->trx_reference;
        $tripbooking->is_payment_complete = 1;
        $tripbooking->save();
        
        $trip                       = Trip::where('id',$tripbooking->trip_id)->first();
		// $update_available_of_person = $trip->available_of_person-$tripbooking->number_of_passengers;
		// $trip->available_of_person  = $update_available_of_person;
		// $trip->save();
        $passengers = DB::table('passengers')->select('*')->where('trip_booking_id', '=', $trip_booking_id)->where('trip_id', '=', $tripbooking->trip_id)->where('booking_user_id', '=', $tripbooking->user_id)->get();
        $qr_code = 'Booking No:'.$tripbooking->id.',Person:'.$tripbooking->number_of_passengers.',Price:'.$tripbooking->price.',Trip id:'.$tripbooking->trip_id;
        
        // $encrypted = Crypt::encryptString($qr_code);
        $path = DNS2D::getBarcodePNGPath($qr_code, "QRCODE");
        $cars = car::where("id", $trip->car_id)->first();
        $image = stripslashes($path);
        
        // Boarding Pass
            $user = User::where('id', $trip->user_id)->first();
            $customer = User::where('id', $tripbooking->user_id)->first();

            $encrypted = Crypt::encryptString($qr_code);
            $qr_url = "https://tamoheen.com/public";
            $name = $customer->name;
            $email = $customer->email;

            $partner_mobile = $user['mobile'];
            $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
            
            Mail::to($email)->send(new BookingUserTrip($image, $name, $email));

            $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $tripbooking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $trip->id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data
            $pdf = PDF::loadView('emails.bordingpass', $data);
            $pdf->save($name . '.pdf'); // Save the PDF to a temporary file
            session()->put('data', $data);

            Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {
                $message->to($email)->subject('Customer Boarding Pass')
                    ->attachData($pdf->output(), $name . '.pdf');
            });
        // end Boarding Pass

        // dd($passengers);
        return view('frontend.trip-booking-success', compact('tripbooking', 'image','passengers'));
    }

    public function telrTripResponseBookingCancel(Request $request)
    {
        $telrManager = new \TelrGateway\TelrManager();
        $result = $telrManager->handleTransactionResponse($request);
        $trip_booking_id = Session::get('trip_booking_id');
        $user_id = Session::get('user_id');
        return redirect('payment/'.$trip_booking_id.'/'.$user_id)->with('error', 'Payment Cancel!');
    }

    public function telrTripResponseBookingDecline(Request $request , $id = null)
    {
        //echo "Payment has been failed. Go back and and try again";
        if ($id == 'declined' || $id == 'cancel') {
            if (!session('payment_failed')) {
                session()->put('payment_failed', true);
            }
            return redirect('/');
        }else{
            if (!session('payment_failed')) {
                session()->put('payment_failed', true);
            }
            return redirect('/');
        }
    }

    public function telrTripPaymentSubmit(Request $request)
    {
        if($request->trx_id != null){
            $tripbooking = TripBooking::findOrFail($request->booking_id);
            $tripbooking->payment_method = 'Telr';
            $tripbooking->trx_id = $request->trx_id;
            $tripbooking->is_payment_complete = 1;
            $tripbooking->save();

            return redirect('telr-trip-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
        }else{
            return redirect()->back()->with('error', 'Please Pay First then press confirm');
        }
    }

    public function telrTripPaymentSuccess($id)
    {
    	$tripbooking = TripBooking::with(['trip'=> function($trip){
            $trip->with(['user', 'cars']);
        }, 'user'])->findOrFail($id);
        // dd($tripbooking);
        // $trip                       = Trip::where('id', $id)->first();
		// $update_available_of_person = $trip->available_of_person-$tripbooking->number_of_passengers;
		// $trip->available_of_person  = $update_available_of_person;
		// $trip->save();
    	return view('frontend.trip-booking-success', compact('tripbooking'));
    }


    // Ship Payment Start From Here

    public function telrShipPayment($id)
    {

        Config::set('telr.create.return_auth', env('TELR_SHIP_SUCCESS_URL'));
        Config::set('telr.create.return_can', env('TELR_SHIP_CANCEL_URL'));
        Config::set('telr.create.return_decl', env('TELR_SHIP_DECLINE_URL'));


        Session::put('ship_booking_id', $id);
    	$tripbooking = ShipmentBooking::findOrFail($id);
    	// dd($tripbooking);
    	Session::put('user_id', $tripbooking->user_id);

        $trip = Trip::where('id', $tripbooking->trip_id)->first();
    	$user = User::where('id', $tripbooking->user_id)->first();

        $name = $user->name;
	    $email = $user->email;

        $arr_name = explode(" ", $name);
	    $last_word  = $arr_name[count($arr_name)-1];
	    $count_name_arr = count($arr_name);

	    if($count_name_arr > 2){
	        $first_name = $arr_name[0];
	        $last_name = $last_word;

	    }elseif ($count_name_arr == 2) {
	        $first_name = $arr_name[0];
	        $last_name = $arr_name[1];
	    }else{
	        $first_name = $arr_name[0];
	        $last_name = 'ABCD';
	    }

        $city_from_data = City::with(['states' => function($q){
    		$q->with('countries');
    	}])->where('id', $trip->city_from_id)->first();

        $telrManager = new \TelrGateway\TelrManager();

        $billingParams = [
            'first_name' => $first_name,
            'sur_name' => $last_name,
            'address_1' => $city_from_data->name.' '.$city_from_data->states->name,
            'city' => $city_from_data->name,
            'region' => $city_from_data->states->name,
            'zip' => '12345',
            'country' => 'SAU',
            'email' => $email,
        ];

        $price = (float) $tripbooking->price;

        return $telrManager->pay((int) $id, $price, 'Ship Booking', $billingParams)->redirect();
    }

    public function telrShipResponseBookingSuccess(Request $request)
    {
        $telrManager = new \TelrGateway\TelrManager();
        $result = $telrManager->handleTransactionResponse($request);

        $trip_booking_id = Session::get('ship_booking_id');
        $user_id = Session::get('user_id');

        $tripbooking = ShipmentBooking::findOrFail($trip_booking_id);
        // dd($tripbooking);
        $user = User::findOrFail($user_id);

        return view('frontend.shipbooking-payment', compact('result', 'tripbooking', 'user'));
    }

    public function telrShipResponseBookingCancel(Request $request)
    {
        //
    }

    public function telrShipResponseBookingDecline(Request $request)
    {
        //
    }

    public function telrShipPaymentSubmit(Request $request)
    {
        if($request->trx_id != null){
            $tripbooking = ShipmentBooking::findOrFail($request->ship_booking_id);
            $tripbooking->payment_method = 'Telr';
            $tripbooking->trx_id = $request->trx_id;
            $tripbooking->is_payment_complete = 1;
            $tripbooking->save();

            return redirect('telr-ship-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
        }else{
            return redirect()->back()->with('error', 'Please Pay First then press confirm');
        }
    }

    public function telrShipPaymentSuccess($id)
    {
    	$shipmentbook = ShipmentBooking::with('user', 'trip')->findOrFail($id);
        return view('frontend.shipment-payment-success', compact('shipmentbook'));
    }


    // Product Payment Start From Here

    public function telrProductPayment($id)
    {

        Config::set('telr.create.return_auth', env('TELR_PRODUCT_SUCCESS_URL'));
        Config::set('telr.create.return_can', env('TELR_PRODUCT_CANCEL_URL'));
        Config::set('telr.create.return_decl', env('TELR_PRODUCT_DECLINE_URL'));


        Session::put('order_id', $id);
    	Session::put('user_id', Auth::id());
    	$order = Order::with(['address', 'cartOrders' => function($q){
    		$q->with('product');
    	}])->findOrFail($id);
    	$user = User::where('id', $order->user_id)->first();

        $name = $user->name;
	    $email = $user->email;

        $arr_name = explode(" ", $name);
	    $last_word  = $arr_name[count($arr_name)-1];
	    $count_name_arr = count($arr_name);

	    if($count_name_arr > 2){
	        $first_name = $arr_name[0];
	        $last_name = $last_word;

	    }elseif ($count_name_arr == 2) {
	        $first_name = $arr_name[0];
	        $last_name = $arr_name[1];
	    }else{
	        $first_name = $arr_name[0];
	        $last_name = 'ABCD';
	    }

        $billing_address = $order->city->address[0]->flat_no.' '.$order->city->address[0]->location;
	    $city = $order->city->name;
        $state = $order->city->states->name;

        $telrManager = new \TelrGateway\TelrManager();

        $billingParams = [
            'first_name' => $first_name,
            'sur_name' => $last_name,
            'address_1' => $billing_address,
            'city' => $city,
            'region' => $state,
            'zip' => '12345',
            'country' => 'SAU',
            'email' => $email,
        ];

        $price = (float) $order->final_price;

        return $telrManager->pay((int) $id, $price, 'Product Order', $billingParams)->redirect();
    }

    public function telrProductResponseBookingSuccess(Request $request)
    {
        $telrManager = new \TelrGateway\TelrManager();
        $result = $telrManager->handleTransactionResponse($request);

        $order_id = Session::get('order_id');
        $user_id = Session::get('user_id');

        $order = Order::findOrFail($order_id);
        $address_id = $order->address_id;
        $user = User::findOrFail($user_id);

        return view('frontend.product-payment', compact('order', 'address_id', 'user_id', 'result'));
    }

    public function telrProductResponseBookingCancel(Request $request)
    {
        //
    }

    public function telrProductResponseBookingDecline(Request $request)
    {
        //
    }

    public function telrProductPaymentSubmit(Request $request)
    {
        if($request->trx_id != null){
            $order = Order::findOrFail($request->order_id);
            $order->payment_method = 'Telr';
            $order->trx_id = $request->trx_id;
            $order->order_status = 1;
            $order->save();
            return redirect('telr-product-payment-success/'.$order->id);
        }else{
            return redirect()->back()->with('error', 'Please Pay First then press confirm');
        }
    }

    public function telrProductPaymentSuccess($id)
    {
    	$order = Order::findOrFail($id);
    	return view('frontend.product-payment-success', compact('order'));
    }
}
