<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripBooking;
use App\Models\ShipmentBooking;
use App\Models\Trip;
use App\Models\User;
use App\Models\Order;
use App\Models\City;
use Auth;

use App\classes\Qrcodes;
use QrCode;
use Illuminate\Support\Str;
use DNS1D;
use DNS2D;
use Session;

class PaytabsController extends Controller
{
	private $merchant_email;
    private $secret_key;

    public function paytabPayment($id)
    {
        Session::put('trip_booking_id', $id);
    	$tripbooking = TripBooking::findOrFail($id);
    	Session::put('user_id', $tripbooking->user_id);
		
    	$trip = Trip::where('id', $tripbooking->trip_id)->first();
    	$user = User::where('id', $tripbooking->user_id)->first();
		
    	$name = $user->name;
	    $email = $user->email;
	    $phone = $user->mobile;
		
	    $arr_name = explode(" ", $name);
	    $last_word  = $arr_name[count($arr_name)-1];
		$count_name_arr = count($arr_name);
    	// dd($count_name_arr);
		

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

    	// if(app()->getLocale() == 'ur'){
    	// 	$return_url = env('MAIN_HOST_URL').'/ur/return-trip-booking';
    	// 	$site_url = env('MAIN_HOST_URL').'/ur';
    	// }elseif(app()->getLocale() == 'ar'){
    	// 	$return_url = env('MAIN_HOST_URL')."/ar/return-trip-booking";
    	// 	$site_url = env('MAIN_HOST_URL').'/ar';
    	// }else{
    	// 	$return_url = env('MAIN_HOST_URL')."/return-trip-booking";
    	// 	$site_url = env('MAIN_HOST_URL').'/';
        // }
        
        $return_url = env('MAIN_HOST_URL').'/api/return-tripbooking';
    	$site_url = env('MAIN_HOST_URL');

    	
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
                // return redirect($get_result->payment_url);
                return response()->json([
                    'payment_url' => $get_result->payment_url
                ]);
	        }
            // return $get_result->result;
            return response()->json([
                'result' => $get_result->result
            ]);
    	}else{
            return response()->json([
                'result' => 'Not Valid Info'
            ]);
    	}
    }

    public function paytabResponseBooking(Request $request)
    {
    	// dd($request);
    	// $url = "https://www.paytabs.com/apiv2/verify_payment";
    	// $method = "POST";
    	// $params = [
    	// 	'merchant_email' => env('MERCHANT_EMAIL'),
    	// 	'secret_key' => env('SECRET_KEY'),
    	// 	'payment_reference' => $request->payment_reference
    	// ];
        // $result = $this->callApi($method, $url, $params, []);
        
    	// if($result->response_code == 100){
			$trip_booking_id = $request->trip_booking_id;
			// dd($trip_booking_id);
    		$user_id = $request->user_id;
			$tripbooking = TripBooking::findOrFail($trip_booking_id);
            $tripbooking->payment_method = 'Paytab';
            $tripbooking->trx_id = $request->transaction_id;
            $tripbooking->is_payment_complete = 1;
            $tripbooking->save();

            // return redirect('paytab-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
            return response()->json([
                'status' => 'Success',
                'tripbooking_id' => $tripbooking->id
            ]);

	        // return view('frontend.payment', compact('result', 'tripbooking', 'user'));
	    // }
        // return redirect()->back()->with('msg', 'Payment Not Successfull');
        // return response()->json([
        //     'status' => 'Failed'
        // ]);
	}
	
	public function paytabShipPayment($id)
	{
		Session::put('ship_booking_id', $id);
		$tripbooking = ShipmentBooking::findOrFail($id);
		// dd($tripbooking);
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

	    // if(app()->getLocale() == 'ur'){
    	// 	$return_url = env('MAIN_HOST_URL')."/ur/return-ship-booking";
    	// 	$site_url = env('MAIN_HOST_URL').'/ur';
    	// }elseif(app()->getLocale() == 'ar'){
    	// 	$return_url = env('MAIN_HOST_URL')."/ar/return-ship-booking";
    	// 	$site_url = env('MAIN_HOST_URL').'/ar';
    	// }else{
    	// 	$return_url = env('MAIN_HOST_URL')."/return-ship-booking";
    	// 	$site_url = env('MAIN_HOST_URL');
		// }

			$return_url = env('MAIN_HOST_URL')."/api/return-ship-booking";
    		$site_url = env('MAIN_HOST_URL');

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
			// dd($get_result);

	    	if($get_result->response_code == 4012){
	            return response()->json([
                    'payment_url' => $get_result->payment_url
                ]);
	        }
	        return response()->json([
                'result' => $get_result->result
            ]);
    	}else{
    		return response()->json([
				'status' => 'Failed'
			]);
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
    	// dd($result->transaction_id);
    	if($result->response_code == 100){
    		$trip_booking_id = Session::get('ship_booking_id');
    		$user_id = Session::get('user_id');

			$shipmentbook = ShipmentBooking::findOrFail($trip_booking_id);
			// $shipmentbook = ShipmentBooking::findOrFail($request->ship_booking_id);
            $shipmentbook->trx_id = $result->transaction_id;
            $shipmentbook->payment_method = "paytab";
            $shipmentbook->is_payment_complete = 1;
            $shipmentbook->save();

			// return redirect('shipment-payment-success/'.$shipmentbook->id);
			return response()->json([
                'status' => 'Success',
                'tripbooking_id' => $shipmentbook->id
            ]);
	        // $user = User::findOrFail($user_id);

	        // return view('frontend.shipbooking-payment', compact('result', 'tripbooking', 'user'));
	    }
	    return response()->json([
            'status' => 'Failed'
        ]);
	}
}
