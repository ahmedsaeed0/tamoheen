<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\TripBooking;

use App\Models\ShipmentBooking;

use App\Models\Trip;

use App\Models\User;

use App\Models\Order;

use App\Models\City;

use App\Models\PartnerAmount;

use Auth;

use DB;

use App\classes\Qrcodes;

use QrCode;

use Illuminate\Support\Str;

use DNS1D;

use DNS2D;

use Session;

use Pdf;





class PaytabsController extends Controller

{

	private $merchant_email;

    private $secret_key;



    public function paytabPayment($id)

    {



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



    	$city_to_data = City::with(['states' => function($q){

    		$q->with('countries');

    	}])->where('id', $trip->city_to_id)->first();







    	$url = "https://www.paytabs.com/apiv2/validate_secret_key";

    	$method = "POST";

    	$params = [

    		'merchant_email' => env('MERCHANT_EMAIL'),

    		'secret_key' => env('SECRET_KEY'),

    	];

    	$response = $this->callApi($method, $url, $params, []);



    	if(app()->getLocale() == 'ur'){

    		$return_url = env('MAIN_HOST_URL').'/ur/return-trip-booking';

    		$site_url = env('MAIN_HOST_URL').'/ur';

    	}elseif(app()->getLocale() == 'ar'){

    		$return_url = env('MAIN_HOST_URL')."/ar/return-trip-booking";

    		$site_url = env('MAIN_HOST_URL').'/ar';

    	}else{

    		$return_url = env('MAIN_HOST_URL')."/return-trip-booking";

    		$site_url = env('MAIN_HOST_URL').'/';

    	}





    	if(($response->result == 'valid') && ($response->response_code == 4000)){





    		$result = array(

		        "merchant_email" => env('MERCHANT_EMAIL'),

		        "secret_key" => env('SECRET_KEY'),

		        "site_url" => $site_url,

		        "return_url" => $return_url,

		        "title" => "Bill To ".$name,

		        "cc_first_name" => $first_name,

		        "cc_last_name" => $last_name,

		        "cc_phone_number" => "+966",

		        "phone_number" => $phone,

		        "email" => $email,

		        "products_per_title" => $trip->title,

		        "unit_price" => $tripbooking->price,

		        "quantity" => 1,

		        "other_charges" => "0",

		        "amount" => $tripbooking->price,

		        "discount" => "0",

		        "currency" => "SAR",

		        "reference_no" => Str::random(6),

		        "ip_customer" =>"1.1.1.0",

		        "ip_merchant" =>"1.1.1.0",

		        "billing_address" => $city_from_data->name.' '.$city_from_data->states->name,

		        "city" => $city_from_data->name,

		        "state" => $city_from_data->states->name,

		        "postal_code" => "12345",

		        "country" => "SAU",

		        "shipping_first_name" => $first_name,

		        "shipping_last_name" => $last_name,

		        "address_shipping" => $city_from_data->name.' '.$city_from_data->states->name,

		        "state_shipping" => $city_from_data->name,

		        "city_shipping" => $city_from_data->states->name,

		        "postal_code_shipping" => "1234",

		        "country_shipping" => "SAU",

		        "msg_lang" => "English",

		        "cms_with_version" => "API USING PHP"

		        );

    		$url = "https://www.paytabs.com/apiv2/create_pay_page";

	    	$method = "POST";

	    	$params = $result;

	    	$get_result = $this->callApi($method, $url, $params, []);

	    	// dd($get_result);

	    	if($get_result->response_code == 4012){

	            return redirect($get_result->payment_url);

	        }

	        return $get_result->result;

    	}else{

    		return redirect()->back()->with('error', 'Not Valid Info');

    	}

    }



    public function paytabResponseBooking(Request $request)

    {

    	// dd($request);

    	$url = "https://www.paytabs.com/apiv2/verify_payment";

    	$method = "POST";

    	$params = [

    		'merchant_email' => env('MERCHANT_EMAIL'),

    		'secret_key' => env('SECRET_KEY'),

    		'payment_reference' => $request->payment_reference

    	];

    	$result = $this->callApi($method, $url, $params, []);

    	if($result->response_code == 100){

    		$trip_booking_id = Session::get('trip_booking_id');

    		$user_id = Session::get('user_id');



    		$tripbooking = TripBooking::findOrFail($trip_booking_id);

	        $user = User::findOrFail($user_id);



	        return view('frontend.payment', compact('result', 'tripbooking', 'user'));

	    }

	    return redirect()->back()->with('msg', 'Payment Not Successfull');

    }



    public function paytabPaymentSuccess($id)
    {

    	$tripbooking = TripBooking::with(['trip'=> function($trip){
            $trip->with(['user', 'cars']);
        }, 'user'])->findOrFail($id);

        $trip = Trip::where('id', $tripbooking['trip_id'])->first();
		$partner_amount = 0;
		$partner_id = 0;
		$wallet_balance  = 0;

		if($trip){
			$partner_user_amount = PartnerAmount::where('partner_id', $trip['user_id'])->first();
				if($partner_user_amount){
					$partner_amount  =  $partner_user_amount['total_amount'];
					$partner_id  =  $trip['user_id'];
				}
		}

    	$qr_code = 'Booking No:'.$tripbooking->id.',Person:'.$tripbooking->number_of_passengers.',Price:'.$tripbooking->price.',Trip id:'.$tripbooking->trip_id;

        

        // $encrypted = Crypt::encryptString($qr_code);

        $path = DNS2D::getBarcodePNGPath($qr_code, "QRCODE");
        $user_amount = PartnerAmount::where('partner_id', $tripbooking->user_id)->first();

        if($user_amount != null){
            $wallet_balance  =  $user_amount->total_amount;
        }
		
          $tripbooking->wallet_balance = $wallet_balance;
          $tripbooking->partner_wallet_balance = $partner_amount;
          $tripbooking->partner_id = $partner_id;

          $tripbooking->save();


        $image = stripslashes($path);


        $trip                       = Trip::where('id',$tripbooking->trip_id)->first();

		// $update_available_of_person = $trip->available_of_person-$tripbooking->number_of_passengers;

		// $trip->available_of_person  = $update_available_of_person;

		// $trip->save();

		

        $passengers = DB::table('passengers')->select('*')->where('trip_booking_id', '=', $id)->where('trip_id', '=', $tripbooking->trip_id)->where('booking_user_id', '=', $tripbooking->user_id)->get();

        

    	return view('frontend.trip-booking-success', compact('tripbooking','image','passengers'));

		

    }

    

    public function paytabPaymentSuccessPDF($id)

    {

    	$tripbooking = TripBooking::with(['trip'=> function($trip){

            $trip->with(['user', 'cars']);

        }, 'user'])->findOrFail($id);

        

    	$qr_code = 'Booking No:'.$tripbooking->id.',Person:'.$tripbooking->number_of_passengers.',Price:'.$tripbooking->price.',Trip id:'.$tripbooking->trip_id;

        

        // $encrypted = Crypt::encryptString($qr_code);

        $path = DNS2D::getBarcodePNGPath($qr_code, "QRCODE");

        

        $user_amount = PartnerAmount::where('partner_id', $tripbooking->user_id)->first();

        $wallet_balance  = 0;

        if($user_amount != null){

            $wallet_balance  =  $user_amount->total_amount;

          

        }

          $tripbooking->wallet_balance = $wallet_balance;

          $tripbooking->save();

        

        $image = stripslashes($path);

        $trip                       = Trip::where('id',$tripbooking->trip_id)->first();

		// $update_available_of_person = $trip->available_of_person-$tripbooking->number_of_passengers;

		// $trip->available_of_person  = $update_available_of_person;

		// $trip->save();

		

        $passengers = DB::table('passengers')->select('*')->where('trip_booking_id', '=', $id)->where('trip_id', '=', $tripbooking->trip_id)->where('booking_user_id', '=', $tripbooking->user_id)->get();

       

    	return view('frontend.trip-booking-success-pdf', compact('tripbooking','image','passengers'));

		

		/*view()->share('tripbooking',$tripbooking);

		view()->share('image',$image);

		view()->share('passengers',$passengers);

		set_time_limit(300); 

		$pdf = PDF::loadView('frontend.trip-booking-success-pdf')

				->setOptions([

					'defaultFont' => '',

					'Attachment' => '0',

					'enable_remote' => true,

					'isRemoteEnabled'=>true,

					'isFontSubsettingEnabled'=>'false',

					//'setBasePath'=>'https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap',

					'chroot' =>  public_path('storage/qrcode'),	

				]);

		$pdf->getDomPDF()->setProtocol($_SERVER['DOCUMENT_ROOT']);

		return $pdf->stream('Bording-pass-'.$id.'.pdf');*/

    }



    public function productPaytabPayment($id)

    {



    	Session::put('order_id', $id);

    	Session::put('user_id', Auth::id());

    	$order = Order::with(['address', 'cartOrders' => function($q){

    		$q->with('product');

    	}])->findOrFail($id);

    	$user = User::where('id', $order->user_id)->first();



    	$name = $user->name;

	    $email = $user->email;

	    $phone = $user->mobile;

	    $cc_phone_number = $order->address->countries->code_arabic;



	    $billing_address = $order->address->flat_no.' '.$order->address->location;

	    $city = $order->address->cities->name;

	    $state = $order->address->states->name;

	    $postal_code = $order->address->pin_no;

	    $country = $order->address->countries->code;



    	$product_name = '';

        $product_price = '';

        $product_quantity = '';

        foreach($order->cartOrders as $cart){

          $product_name .=  $cart->product->name.' || ';

          $product_quantity.=  $cart->quantity.' || ';

          $product_price.=  $cart->price.' || ';

        }



    	$product_names = rtrim($product_name,' || ');

	    $product_prices = rtrim($product_price,' || ');

	    $product_quantities = rtrim($product_quantity,' || ');





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





    	$url = "https://www.paytabs.com/apiv2/validate_secret_key";

    	$method = "POST";

    	$params = [

    		'merchant_email' => env('MERCHANT_EMAIL'),

    		'secret_key' => env('SECRET_KEY'),

    	];

    	$response = $this->callApi($method, $url, $params, []);



    	if(app()->getLocale() == 'ur'){

    		$return_url = env('MAIN_HOST_URL')."/ur/return-order";

    		$site_url = env('MAIN_HOST_URL').'/ur';

    	}elseif(app()->getLocale() == 'ar'){

    		$return_url = env('MAIN_HOST_URL')."/ar/return-order";

    		$site_url = env('MAIN_HOST_URL').'/ar';

    	}else{

    		$return_url = env('MAIN_HOST_URL')."/return-order";

    		$site_url = env('MAIN_HOST_URL');

    	}



    	if(($response->result == 'valid') && ($response->response_code == 4000)){





    		$result = array(

		        "merchant_email" => env('MERCHANT_EMAIL'),

		        "secret_key" => env('SECRET_KEY'),

		        "site_url" => $site_url,

		        "return_url" => $return_url,

		        "title" => "Bill To ".$name,

		        "cc_first_name" => $first_name,

		        "cc_last_name" => $last_name,

		        "cc_phone_number" => $cc_phone_number,

		        "phone_number" => $phone,

		        "email" => $email,

		        "products_per_title" => $product_names,

		        "unit_price" => $product_prices,

		        "quantity" => $product_quantities,

		        "other_charges" => "0",

		        "amount" => $order->final_price,

		        "discount" => "0",

		        "currency" => "SAR",

		        "reference_no" => Str::random(6),

		        "ip_customer" =>"1.1.1.0",

		        "ip_merchant" =>"1.1.1.0",

		        "billing_address" => $billing_address,

		        "city" => $city,

		        "state" => $state,

		        "postal_code" => $postal_code,

		        "country" => "SAU",

		        "shipping_first_name" => $first_name,

		        "shipping_last_name" => $last_name,

		        "address_shipping" => $billing_address,

		        "state_shipping" => $city,

		        "city_shipping" => $state,

		        "postal_code_shipping" => $postal_code,

		        "country_shipping" => "SAU",

		        "msg_lang" => "English",

		        "cms_with_version" => "API USING PHP"

		        );

    		$url = "https://www.paytabs.com/apiv2/create_pay_page";

	    	$method = "POST";

	    	$params = $result;

	    	$get_result = $this->callApi($method, $url, $params, []);



	    	if($get_result->response_code == 4012){

	            return redirect($get_result->payment_url);

	        }

	        return $get_result->result;

    	}else{

    		return redirect()->back()->with('error', 'Not Valid Info');

    	}

    }



    public function paytabResponseOrder(Request $request)

    {

    	$url = "https://www.paytabs.com/apiv2/verify_payment";

    	$method = "POST";

    	$params = [

    		'merchant_email' => env('MERCHANT_EMAIL'),

    		'secret_key' => env('SECRET_KEY'),

    		'payment_reference' => $request->payment_reference

    	];

    	$result = $this->callApi($method, $url, $params, []);

    	// dd($result);

    	if($result->response_code == 100){

    		$order_id = Session::get('order_id');

    		$user_id = Session::get('user_id');



    		$order = Order::findOrFail($order_id);

    		$address_id = $order->address_id;

	        $user = User::findOrFail($user_id);



	        return view('frontend.product-payment', compact('order', 'address_id', 'user_id', 'result'));

	    }

	    return redirect()->back()->with('msg', 'Payment Not Successfull');

    }



     public function productPaymentSuccess($id)

    {

    	$order = Order::findOrFail($id);

    	return view('frontend.product-payment-success', compact('order'));

    }



    public function paytabShipPayment($id)

    {

    	Session::put('ship_booking_id', $id);

    	$tripbooking = ShipmentBooking::findOrFail($id);

    	$trip = Trip::where('id', $tripbooking->trip_id)->first();

    	Session::put('user_id', $tripbooking->user_id);



    	$city_from_data = City::with(['states' => function($q){

    		$q->with('countries');

    	}])->where('id', $trip->city_from_id)->first();



    	$city_to_data = City::with(['states' => function($q){

    		$q->with('countries');

    	}])->where('id', $trip->city_to_id)->first();



    	$url = "https://www.paytabs.com/apiv2/validate_secret_key";

    	$method = "POST";

    	$params = [

    		'merchant_email' => env('MERCHANT_EMAIL'),

    		'secret_key' => env('SECRET_KEY'),

    	];

    	$response = $this->callApi($method, $url, $params, []);

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



	    if(app()->getLocale() == 'ur'){

    		$return_url = env('MAIN_HOST_URL')."/ur/return-ship-booking";

    		$site_url = env('MAIN_HOST_URL').'/ur';

    	}elseif(app()->getLocale() == 'ar'){

    		$return_url = env('MAIN_HOST_URL')."/ar/return-ship-booking";

    		$site_url = env('MAIN_HOST_URL').'/ar';

    	}else{

    		$return_url = env('MAIN_HOST_URL')."/return-ship-booking";

    		$site_url = env('MAIN_HOST_URL');

    	}



    	if(($response->result == 'valid') && ($response->response_code == 4000)){





    		$result = array(

		        "merchant_email" => env('MERCHANT_EMAIL'),

		        "secret_key" => env('SECRET_KEY'),

		        "site_url" => $site_url,

		        "return_url" => $return_url,

		        "title" => "Bill To.".$name,

		        "cc_first_name" => $first_name,

		        "cc_last_name" => $last_name,

		        "cc_phone_number" => "+966",

		        "phone_number" => $user->mobile,

		        "email" => $user->email,

		        "products_per_title" => "Bag",

		        "unit_price" => $trip->price_per_bag,

		        "quantity" => $tripbooking->number_of_bag,

		        "other_charges" => "0",

		        "amount" => $tripbooking->price,

		        "discount" => "0",

		        "currency" => "SAR",

		        "ip_customer" =>"1.1.1.0",

		        "ip_merchant" =>"1.1.1.0",

		        "billing_address" => $tripbooking->sender_address,

		        "address_shipping" => $tripbooking->sender_address,

		        "city" => $city_from_data->name,

		        "state" => $city_from_data->states->name,

		        "postal_code" => "12345",

		        "country" => "SAU",

		        "state_shipping" => $city_from_data->name,

		        "city_shipping" => $city_from_data->states->name,

		        "postal_code_shipping" => "12345",

		        "country_shipping" => "SAU",

		        "reference_no" => Str::random(6),

		        "msg_lang" => "en",

		        "cms_with_version" => "API USING PHP"

		        );

    		$url = "https://www.paytabs.com/apiv2/create_pay_page";

	    	$method = "POST";

	    	$params = $result;

	    	$get_result = $this->callApi($method, $url, $params, []);



	    	if($get_result->response_code == 4012){

	            return redirect($get_result->payment_url);

	        }

	        return $get_result->result;

    	}else{

    		return redirect()->back()->with('error', 'Not Valid Info');

    	}

    }



    public function returnShipBooking(Request $request)

    {

    	$url = "https://www.paytabs.com/apiv2/verify_payment";

    	$method = "POST";

    	$params = [

    		'merchant_email' => env('MERCHANT_EMAIL'),

    		'secret_key' => env('SECRET_KEY'),

    		'payment_reference' => $request->payment_reference

    	];

    	$result = $this->callApi($method, $url, $params, []);

    	// dd($result);

    	if($result->response_code == 100){

    		$trip_booking_id = Session::get('ship_booking_id');

    		$user_id = Session::get('user_id');



    		$tripbooking = ShipmentBooking::findOrFail($trip_booking_id);

	        $user = User::findOrFail($user_id);



	        return view('frontend.shipbooking-payment', compact('result', 'tripbooking', 'user'));

	    }

	    return redirect()->back()->with('msg', 'Payment Not Successfull');

    }

}

