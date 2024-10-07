<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\TripResource;
use App\Http\Resources\ReviewResource;
use App\Models\Trip;
use App\Models\TripBooking;
use App\Models\Review;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Feature;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Term;
use App\Models\Car;

class FrontendsController extends Controller
{
    public function terms()
    {
        $term = Term::first();
        return response()->json([
                'term' => $term,
                'code' => 201
            ], 201);
    }
    
    public function productListByCategory($id)
    {
        $products = Product::where('category_id', $id)->latest()->with('image', 'categories')->get();
        return response()->json([
            'products' => $products
        ]);
    }
    
    public function searchTrip(Request $request)
    {
    	$trip = Trip::query();
    	
    	if($request->date){
    		$date_time = Carbon::parse($request->date)->format('Y-m-d');
    		$trip->whereDate('date', $request->date);
    	}
    	
    	if($request->type){
    		$trip->where('type', $request->type);
    	}
    	
    	if($request->city_from_id){
    		$trip->where('city_from_id', $request->city_from_id);
    	}
    	
    	if($request->city_to_id){
    		$trip->where('city_to_id', $request->city_to_id);
    	}
    	
    	if($request->number_of_person){
    		$trip->where('available_of_person', '>=', $request->number_of_person);
    	}
    	
    	if($request->main_feature_id){
            $trip->where('feature_id', $request->main_feature_id);
        }
        
        $trip->with(['cars' => function($query){
            $query->with(['images', 'carFeatures' => function($feature){
                $feature->with('image');
            }]);
        }]);
        $trip->with('user');
    	$trip = $trip->with('feature')->where('status', 1)->get();
    	
    	if($request->feature_id){
    	   $trips = [];
            foreach($trip as $get_trip){
                $tmp_feature = [];
                foreach($get_trip->cars->carFeatures as $feature){
                    array_push($tmp_feature, $feature->id);
                }
                
                $feature_ids = explode(',', $request->feature_id);
                if((is_array($feature_ids)) && (count($feature_ids)>0)){
                    $ary_diff=array_diff($feature_ids, $tmp_feature);
                    if(count($ary_diff) == 0){
                        array_push($trips, $get_trip);
                    }
                }else{
                    array_push($trips, $get_trip);
                }
            }  
    	}else{
    	    $trips = $trip;
    	}
    	
    	
        
        return TripResource::collection($trips);
        // return response()->json([
        //     'trips' => $trips
        // ]);
    }

    public function searchShip(Request $request)
    {
        $trips = Trip::query();
    	if($request->date){
    		$date_time = Carbon::parse($request->date)->format('Y-m-d');
    		$trips->whereDate('date', $date_time);
    	}
    	if($request->type){
    		$trips->where('type', $request->type);
    	}
    	if($request->city_from_id){
    		$trips->where('city_from_id', $request->city_from_id);
    	}
    	if($request->city_to_id){
    		$trips->where('city_to_id', $request->city_to_id);
    	}
    	if($request->number_of_bag){
    		$trips->where('available_of_bag', '>=', $request->number_of_bag);
    	}
    	$trips->with(['cars' => function($query){
            $query->with(['images', 'carFeatures' => function($feature){
                $feature->with('image');
            }])->get();
        }]);
        
    	$trips = $trips->with('feature')->where('status', 1)->get();
    	
    	
    	return TripResource::collection($trips);
    // 	return response()->json([
    //         'trips' => $trips,
    //         // 'trips' => $arr_trips
    //     ]);
    }

    public function tripDetail($id)
    {
        $trip = Trip::with(['feature', 'user', 'cityFrom', 'cityTo', 'cars' => function($q){
            $q->with(['images', 'carFeatures' => function($feature){
                $feature->with('image');
            }]);
        }])->find($id);
        if(!$trip)
            return response()->json(['status' => 'Trip not found', 'code' => 404], 404);
        // return new TripResource($trip);
        return response()->json([
            'trip' => $trip,
            'code' => 201
        ], 201);
    }
    
    public function bookingDetails($id)
    {
        $trip_booking = TripBooking::with(['user', 'passengers', 'trip' => function($q){
            $q->with(['cityFrom', 'cityTo', 'user', 'cars', 'feature']);
        }])->find($id);
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);
        return response()->json([
            'trip_booking' => $trip_booking,
            'code' => 201
        ], 201);
    }
    
    public function tripReviews($id)
    {
        $reviews = Review::whereHas('tripBooking', function($query) use($id) {
            $query->where('trip_id', $id);
        })->get();
        // return ReviewResource::collection($reviews);
        return response()->json([
            'reviews' => $reviews,
            'code' => 201
        ], 201);
        
    }

    public function countryList()
    {
        $countries = Country::latest()->get();
        return response()->json(['countries' => $countries, 'code' => 201], 201);
    }

    public function stateList($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json(['states' => $states, 'code' => 201], 201);
    }

    public function cityList($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json(['cities' => $cities, 'code' => 201], 201);
    }

    public function frontFeatures()
    {
        $car_features = Feature::with('image')->where('is_main', 0)->get();
        return response()->json(['car_features' => $car_features, 'code' => 201], 201);
    }

    public function frontMainFeatures()
    {
        $main_features = Feature::with('image')->where('is_main', 1)->get();
        return response()->json(['main_features' => $main_features, 'code' => 201], 201);
    }

    public function paymentStcSubmit(Request $request)
    {
        if($request->stc_mobile == null){
            // return redirect()->back()->with('error', 'Please Insert Stc Mobile No');
            return response()->json([
                'status' => 'Failed',
                'msg' => 'Please Insert Stc Mobile No'
            ]);
        }else{

            $stc_mobile = $request->stc_mobile;
            $result = substr($stc_mobile, 0, 3);
            if($result == "966"){
                $mobile = $stc_mobile;
            }else{
                $mobile = "966".$stc_mobile;
            }

            $id =  Crypt::decrypt($request->trip_booking_id);
            
            $trip_booking = TripBooking::findOrFail($id);
            $four_digit_serial_number = $this->getNextTripOrderNumber();
            $url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentAuthorize";

            $content = [
                "DirectPaymentAuthorizeRequestMessage" => [
                    "BranchID" => "1",
                    "TellerID" => "22",
                    "DeviceID" => "500",
                    "RefNum" => $id,
                    "BillNumber" => $four_digit_serial_number,
                    "MobileNo"=> $mobile,
                    "Amount" => $trip_booking->price,
                    "MerchantNote" => "TripBooking ID: $id"
                ]
            ];

            $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

            $json_content = json_encode($content);

            $client = new \GuzzleHttp\Client();
            $method = "POST";
            try {
                $response = $client->request($method, $url, [
                    'json' => $content,
                    'headers' => $headers,
                    'cert' => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
                    'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
                    ]
                );
                $body = $response->getBody();
                $final_response = json_decode($body->read(1024));

                // return view('frontend.trip-stc-payment-step-2', compact('final_response', 'trip_booking'));
                return response()->json([
                    'status' => 'success',
                    'final_response' => $final_response,
                    'trip_booking' => $trip_booking
                ]);
            } catch (\Exception $exception) {
                // return back()->withError('Customer Not Found.Please register in stc then try.');
                return response()->json([
                    'status' => 'Failed',
                    'msg' => 'Customer Not Found.Please register in stc then try.'
                ]);
            }
            
        }

    }

    public function getNextTripOrderNumber()
    {
        $lastOrder = TripBooking::orderBy('created_at', 'desc')->first();

        if (!$lastOrder){

            $number = 0;
        }else{
            $number = substr($lastOrder->order_id, 3);
        }
     
        return sprintf('%04d', intval($number) + 1);
    }

    public function stcTripPaymentConfirm(Request $request)
    {
        $this->validate($request, [
            'OtpReference'       => 'required',
            'otp_value'          => 'required',
            'StcPayPmtReference' => 'required',
            'token_ref'          => 'required',
        ]);

    	$id= Crypt::decrypt($request->trip_booking_id);
    	$tripbooking = TripBooking::findOrFail($id);
    	

    	$url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentConfirm";
        $content = [
            "DirectPaymentConfirmRequestMessage" => [
                'OtpReference'       => $request->OtpReference,
                'OtpValue'           => $request->otp_value,
                'StcPayPmtReference' => $request->StcPayPmtReference,
                'TokenReference'     => $request->token_ref,
                'TokenizeYn'         => true,
            ]
        ];

        $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

        $json_content = json_encode($content);

        $client = new \GuzzleHttp\Client();
        $method = "POST";
        $response = $client->request($method, $url, [
            'json'    => $content,
            'headers' => $headers,
            'cert'    => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
            'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
            ]
        );
        $body = $response->getBody();
        $final_response = json_decode($body->read(1024));

        $tripbooking->payment_method      = 'STC';
        $tripbooking->trx_id              = $final_response->DirectPaymentConfirmResponseMessage->TokenId;
        $tripbooking->stc_ref_num         = $final_response->DirectPaymentConfirmResponseMessage->RefNum;
        $tripbooking->is_payment_complete = 1;
        $tripbooking->save();

        return response()->json([
            'status' => 'Success',
            'tripbooking_id' => $tripbooking->id
        ]);

        // return redirect('paytab-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
    }
    
    public function stcShipPaymentSubmit(Request $request)
    {
        if($request->stc_mobile == null){
            // return redirect()->back()->with('error', 'Please Insert Stc Mobile No');
            return response()->json([
                'status' => 'Failed'
            ]);
        }else{

            $stc_mobile = $request->stc_mobile;
            $result = substr($stc_mobile, 0, 3);
            if($result == "966"){
                $mobile = $stc_mobile;
            }else{
                $mobile = "966".$stc_mobile;
            }

            $id = Crypt::decrypt($request->shipment_booking_id);
            $trip_booking = ShipmentBooking::findOrFail($id);

            $four_digit_serial_number = $this->getNextShipOrderNumber();
            $url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentAuthorize";
            
            $content = [
                "DirectPaymentAuthorizeRequestMessage" => [
                    "BranchID" => "1",
                    "TellerID" => "22",
                    "DeviceID" => "500",
                    "RefNum" => $id,
                    "BillNumber" => $four_digit_serial_number,
                    "MobileNo"=> $mobile,
                    "Amount" => $trip_booking->price,
                    "MerchantNote" => "ShipmentBooking ID: $id"
                ]
            ];

            $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

            $json_content = json_encode($content);

            $client = new \GuzzleHttp\Client();
            $method = "POST";
            try{
                $response = $client->request($method, $url, [
                    'json' => $content,
                    'headers' => $headers,
                    'cert' => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
                    'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
                    ]
                );
                $body = $response->getBody();
                $final_response = json_decode($body->read(1024));

                return view('frontend.ship-stc-payment-step-2', compact('final_response', 'trip_booking'));
                return response()->json([
                    'final_response' => $final_response,
                    'trip_booking' => $trip_booking
                ]);
            }catch(\Exception $exception){
                // return back()->withError('Customer Not Found.Please register in stc then try.');
                return response()->json([
                    'status' => 'Failed',
                    'msg' => 'Customer Not Found.Please register in stc then try.'
                ]);
            }
        }
    }

    public function stcShipPaymentConfirm(Request $request)
    {
        $this->validate($request, [
            'OtpReference' => 'required',
            'otp_value' => 'required',
            'StcPayPmtReference' => 'required',
            'token_ref' => 'required',
        ]);
        
    	$id= Crypt::decrypt($request->ship_booking_id);
    	$tripbooking = ShipmentBooking::findOrFail($id);
    	

    	$url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentConfirm";
        $content = [
            "DirectPaymentConfirmRequestMessage" => [
                'OtpReference'       => $request->OtpReference,
                'OtpValue'           => $request->otp_value,
                'StcPayPmtReference' => $request->StcPayPmtReference,
                'TokenReference'     => $request->token_ref,
                'TokenizeYn'         => true,
            ]
        ];

        $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

        $json_content = json_encode($content);

        $client = new \GuzzleHttp\Client();
        $method = "POST";
        $response = $client->request($method, $url, [
            'json'    => $content,
            'headers' => $headers,
            'cert'    => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
            'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
            ]
        );
        $body = $response->getBody();
        $final_response = json_decode($body->read(1024));
        
        $tripbooking->payment_method = 'STC';
        $tripbooking->trx_id = $final_response->DirectPaymentConfirmResponseMessage->TokenId;
        $tripbooking->stc_ref_num = $final_response->DirectPaymentConfirmResponseMessage->RefNum;
        $tripbooking->is_payment_complete = 1;
        $tripbooking->save();

        // return redirect('shipment-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
        return response()->json([
            'status' => 'Success',
            'tripbooking' => $tripbooking->id
        ]);
    }
}
