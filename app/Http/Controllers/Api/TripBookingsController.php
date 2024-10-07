<?php

namespace App\Http\Controllers\Api;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingTrip;
use App\Mail\BookingUserTrip;
use App\Mail\ShipmentReceiveUser;
use Illuminate\Http\Request;

use App\Models\Trip;
use App\Models\TripBooking;
use App\Models\ShipmentBooking;
use App\Http\Resources\BookingResource;
use App\Models\User;
use App\Models\Passenger;
use App\Models\PartnerAmount;
use App\Models\ServiceCharge;
use Auth;
use DNS1D;
use DNS2D;
use Carbon\Carbon;
use Storage;
use Hash;
use Illuminate\Support\Facades\Crypt;

use App\classes\Qrcodes;
use QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TripBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        // dd($user->hasrole('user'));

        if($user->hasrole('partner')){
            $trip_bookings = TripBooking::whereHas('trip', function($q){
                $q->where('user_id', Auth::id());
            })->with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->paginate(25);

            // $trip_bookings = Trip::with('user', 'tripBookings')->where('user_id', Auth::id())->get();

        }elseif($user->hasrole('user')){
            // $trip_bookings = TripBooking::whereHas('trip', function($q){
            //     $q->where('user_id', Auth::id());
            // })->with(['trip' => function($qu){
            //     $qu->with('cityFrom', 'cityTo');
            // }])->paginate(25);

            $trip_bookings = TripBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->where('user_id', Auth::id())->paginate(25);

        }else{
            $trip_bookings = TripBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->latest()->paginate(25);
        }
        // return BookingResource::collection($trip_bookings);
        return response()->json([
            'trip_bookings' => $trip_bookings,
            'code' => 201
        ], 201);
    }

    public function indexUserWise()
    {


        // $user = Auth::user();
        // // dd($user->hasrole('user'));

        // if($user->hasrole('partner')){
        //     $trip_bookings = TripBooking::whereHas('trip', function($q){
        //         $q->where('user_id', Auth::id());
        //     })->with(['trip' => function($qu){
        //         $qu->with('cityFrom', 'cityTo');
        //     }])->paginate(25);

        //     // $trip_bookings = Trip::with('user', 'tripBookings')->where('user_id', Auth::id())->get();

        // }elseif($user->hasrole('user')){
        //     // $trip_bookings = TripBooking::whereHas('trip', function($q){
        //     //     $q->where('user_id', Auth::id());
        //     // })->with(['trip' => function($qu){
        //     //     $qu->with('cityFrom', 'cityTo');
        //     // }])->paginate(25);

        //     $trip_bookings = TripBooking::with(['trip' => function($qu){
        //         $qu->with('cityFrom', 'cityTo');
        //     }])->where('user_id', Auth::id())->paginate(25);

        // }else{
        //     $trip_bookings = TripBooking::with(['trip:date'])->latest()->paginate(25);
        // }
        // return response()->json([
        //     'trip_bookings' => $trip_bookings,
        //     'code' => 201
        // ], 201);


        // $trip_booking_data = [];
        // $trip_booking_data["last_page"] = $trip_bookings->lastPage;
        // $trip_booking_data["path"] = $trip_bookings->path;
        // $trip_booking_data["per_page"] = $trip_bookings->perPage;
        // $trip_booking_data["total"] = $trip_bookings->total;
        // $trip_booking_data["current_page"] = $trip_bookings->currentPage;



         $user = Auth::user();
        $trip_booking_data = [];
        if($user->hasrole('partner')){
            $trip_bookings = TripBooking::whereHas('trip', function($q){
                $q->where('user_id', Auth::id());
            })->with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->get();

            foreach($trip_bookings as $trip_booking){
                // dd($trip_booking->trip);
                $temp_array = [];
               $temp_array['date'] = $trip_booking->trip->withTrashed()->date;
               $temp_array['price'] = $trip_booking->price;
               $city_info = [];
               $city_info['en'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name,
                   'cityTo' => $trip_booking->trip->cityTo->name
               ];
               $city_info['ur'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_urdu,
                   'cityTo' => $trip_booking->trip->cityTo->name_urdu
               ];
               $city_info['ar'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_arabic,
                   'cityTo' => $trip_booking->trip->cityTo->name_arabic
               ];
               $temp_array['city_info'] = $city_info;


               array_push($trip_booking_data, $temp_array);
            }

        }elseif($user->hasrole('user')){
            // $trip_bookings = TripBooking::whereHas('trip', function($q){
            //     $q->where('user_id', Auth::id());
            // })->with(['trip' => function($qu){
            //     $qu->with('cityFrom', 'cityTo');
            // }])->paginate(25);

            $trip_bookings = TripBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->where('user_id', Auth::id())->get();
            // dd($trip_bookings);

            foreach($trip_bookings as $trip_booking){
                // dd($trip_booking->trip);
                $temp_array = [];
               $temp_array['date'] = $trip_booking->trip->date;
               $temp_array['price'] = $trip_booking->price;

               $city_info = [];
               $city_info['en'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name,
                   'cityTo' => $trip_booking->trip->cityTo->name
               ];
               $city_info['ur'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_urdu,
                   'cityTo' => $trip_booking->trip->cityTo->name_urdu
               ];
               $city_info['ar'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_arabic,
                   'cityTo' => $trip_booking->trip->cityTo->name_arabic
               ];
               $temp_array['city_info'] = $city_info;


               array_push($trip_booking_data, $temp_array);
            }

        }else{
            $trip_bookings = TripBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->latest()->get();
            foreach($trip_bookings as $trip_booking){
                // dd($trip_booking->trip);
                $temp_array = [];
               $temp_array['date'] = $trip_booking->trip->withTrashed()->date;
               $temp_array['price'] = $trip_booking->price;

               $city_info = [];
               $city_info['en'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name,
                   'cityTo' => $trip_booking->trip->cityTo->name
               ];
               $city_info['ur'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_urdu,
                   'cityTo' => $trip_booking->trip->cityTo->name_urdu
               ];
               $city_info['ar'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_arabic,
                   'cityTo' => $trip_booking->trip->cityTo->name_arabic
               ];
               $temp_array['city_info'] = $city_info;


               array_push($trip_booking_data, $temp_array);
            }
        }

        $myCollectionObj = collect($trip_booking_data);
        $options = [
                'path' => 'http://mobile.forsanway.com/public'
            ];
        $perPage = 25;
        $trip_book_data = $this->paginate($myCollectionObj, $perPage, $page = null, $options);
        // return BookingResource::collection($trip_bookings);
        return response()->json([
            'trip_bookings' => $trip_book_data,
            'code' => 201
        ], 201);

    }

    public function indexUserWiseShip()
    {




        $user = Auth::user();
        $trip_booking_data = [];
        if($user->hasrole('partner')){
            $trip_bookings = ShipmentBooking::whereHas('trip', function($q){
                $q->where('user_id', Auth::id());
            })->with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->get();

            foreach($trip_bookings as $trip_booking){
                // dd($trip_booking->trip);
                $temp_array = [];
               $temp_array['date'] = $trip_booking->trip->date;
               $temp_array['price'] = $trip_booking->price;
               $city_info = [];
               $city_info['en'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name,
                   'cityTo' => $trip_booking->trip->cityTo->name
               ];
               $city_info['ur'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_urdu,
                   'cityTo' => $trip_booking->trip->cityTo->name_urdu
               ];
               $city_info['ar'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_arabic,
                   'cityTo' => $trip_booking->trip->cityTo->name_arabic
               ];
               $temp_array['city_info'] = $city_info;


               array_push($trip_booking_data, $temp_array);
            }

        }elseif($user->hasrole('user')){
            // $trip_bookings = TripBooking::whereHas('trip', function($q){
            //     $q->where('user_id', Auth::id());
            // })->with(['trip' => function($qu){
            //     $qu->with('cityFrom', 'cityTo');
            // }])->paginate(25);

            $trip_bookings = ShipmentBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->where('user_id', Auth::id())->get();

            foreach($trip_bookings as $trip_booking){
                // dd($trip_booking->trip);
                $temp_array = [];
               $temp_array['date'] = $trip_booking->trip->date;
               $temp_array['price'] = $trip_booking->price;

               $city_info = [];
               $city_info['en'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name,
                   'cityTo' => $trip_booking->trip->cityTo->name
               ];
               $city_info['ur'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_urdu,
                   'cityTo' => $trip_booking->trip->cityTo->name_urdu
               ];
               $city_info['ar'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_arabic,
                   'cityTo' => $trip_booking->trip->cityTo->name_arabic
               ];
               $temp_array['city_info'] = $city_info;


               array_push($trip_booking_data, $temp_array);
            }

        }else{
            $trip_bookings = ShipmentBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->latest()->get();
            foreach($trip_bookings as $trip_booking){
                // dd($trip_booking->trip);
                $temp_array = [];
               $temp_array['date'] = $trip_booking->trip->date;
               $temp_array['price'] = $trip_booking->price;

               $city_info = [];
               $city_info['en'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name,
                   'cityTo' => $trip_booking->trip->cityTo->name
               ];
               $city_info['ur'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_urdu,
                   'cityTo' => $trip_booking->trip->cityTo->name_urdu
               ];
               $city_info['ar'] = [
                   'cityFrom' => $trip_booking->trip->cityFrom->name_arabic,
                   'cityTo' => $trip_booking->trip->cityTo->name_arabic
               ];
               $temp_array['city_info'] = $city_info;


               array_push($trip_booking_data, $temp_array);
            }
        }

        $myCollectionObj = collect($trip_booking_data);
        $options = [
                'path' => 'http://mobile.forsanway.com/public'
            ];
        $perPage = 25;
        $trip_book_data = $this->paginate($myCollectionObj, $perPage, $page = null, $options);
        // return BookingResource::collection($trip_bookings);
        return response()->json([
            'ship_bookings' => $trip_book_data,
            'code' => 201
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "DATA";die;
        $validator = Validator::make($request->all(), [
            'trip_id'             => 'required',
            'number_of_passenger' => 'required|integer',
            'name'                => 'required|array',
            'email'               => 'required|array',
            'email.*'           => 'required|email',
            'title'               => 'required|array',
			'title.*'              => 'required|integer',
			'identity_type'       => 'required|array',
			'identity_type.*'      => 'required|integer',
			'identity_number'     => 'required|array',
			'mobile'              => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all(), 'code' => 422], 422);
        }
        $trip = Trip::where('id', $request->trip_id)->first();
        $number_of_passenger = $request->number_of_passenger;
        if($trip->discount > 0){
            $price = $trip->discount*$number_of_passenger;
        }else{
            $price = $trip->price_per_person*$number_of_passenger;
        }

        $wallet_price = 0;
        if(Auth::check()){

            $wallet_amount = PartnerAmount::where('partner_id', Auth::id())->first();
            if($wallet_amount != null){
                if($wallet_amount->total_amount >= $price){

                    $wallet_price += (float)$wallet_amount->total_amount;

                    if($wallet_price != 0){
                        $update_amount = $wallet_price-$price;

                        $wallet_amount->total_amount = $update_amount;
                        $wallet_amount->save();
                    }

                    $charge = ServiceCharge::where('type', 0)->first();
                    $percent_price = ($charge->charge/100)*$price;
                    $partner_price = $price-$percent_price;

                    if($trip->available_of_person >= $number_of_passenger){

                        $user = User::where('email', $request->email[0])->first();

                        if($user){
                            $trip_booking                       = new TripBooking;
                            $trip_booking->user_id              = $user->id;
                            $trip_booking->trip_id              = $request->trip_id;
                            $trip_booking->number_of_passengers = $number_of_passenger;
                            $trip_booking->price                = $price;
                            $trip_booking->partner_price        = $partner_price;
                            $trip_booking->is_payment_complete  = 1;
                            $trip_booking->payment_method       = 'wallet';
                            $trip_booking->status               = 1;
                            $trip_booking->save();

                            foreach($request->name as $key => $value){
                                $passenger                  = new Passenger;
                                $passenger->trip_id         = $request->trip_id;
                                $passenger->booking_user_id = $user->id;
                                $passenger->trip_booking_id = $trip_booking->id;
                                $passenger->title           = $request->title[$key];
                                $passenger->name            = $value;
                                $passenger->identity_type   = $request->identity_type[$key];
                                $passenger->identity_number = $request->identity_number[$key];
                                $passenger->mobile          = $request->mobile[$key];
                                $passenger->email           = $request->email[$key];
                                $passenger->save();
                            }

                            //trip available person update
                            //$trip                       = Trip::where('id', $request->trip_id)->first();
                            //$update_available_of_person = $trip->available_of_person-$number_of_passenger;
                            //$trip->available_of_person  = $update_available_of_person;
                            //$trip->save();

                            $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name[0];
                            $email = $request->email[0];

                            Mail::to($email)->send(new BookingUserTrip($image, $name, $email));
                        }else{
                            $password = Str::random(8);
                            $user           = new User();
                            $user->name     = $request->name[0];
                            $user->email    = $request->email[0];
                            $user->password = Hash::make($password);
                            $user->status   = 1;
                            $user->language = "en";
                            $user->mobile   = $request->mobile[0];
                            $user->title    = $request->title[0];
                            $user->save();


                            $user->syncRoles(['user']);
                            //trip booking
                            $trip_booking                       = new TripBooking;
                            $trip_booking->user_id              = $user->id;
                            $trip_booking->trip_id              = $request->trip_id;
                            $trip_booking->number_of_passengers = $number_of_passenger;
                            $trip_booking->price                = $price;
                            $trip_booking->partner_price        = $partner_price;
                            $trip_booking->is_payment_complete  = 1;
                            $trip_booking->payment_method       = 'wallet';
                            $trip_booking->status               = 1;
                            $trip_booking->save();

                            foreach($request->name as $key => $value){
                                $passenger                  = new Passenger;
                                $passenger->trip_id         = $request->trip_id;
                                $passenger->booking_user_id = $user->id;
                                $passenger->trip_booking_id = $trip_booking->id;
                                $passenger->title           = $request->title[$key];
                                $passenger->name            = $value;
                                $passenger->identity_type   = $request->identity_type[$key];
                                $passenger->identity_number = $request->identity_number[$key];
                                $passenger->mobile          = $request->mobile[$key];
                                $passenger->email           = $request->email[$key];
                                $passenger->save();
                            }

                            //trip available person update
                            //$trip                       = Trip::where('id', $request->trip_id)->first();
                            //$update_available_of_person = $trip->available_of_person-$number_of_passenger;
                            //$trip->available_of_person  = $update_available_of_person;
                            //$trip->save();


                            $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name[0];
                            $email = $request->email[0];

                            Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                        }
                        // return redirect('paytab-payment-success/'.$trip_booking->id);
                        return response()->json([
                            'status' => 'Success',
                            'user_id' => $user->id,
                            'trip_booking_id' => $trip_booking->id,
                            'code' => 201
                        ], 201);
                    }else{
                        return response()->json([
                            'status' => 'Not Available Seat',
                            'trip_id' => $trip->id,
                            'code' => 201
                        ], 201);
                    }

                }else{
                    $charge = ServiceCharge::where('type', 0)->first();
                    $percent_price = ($charge->charge/100)*$price;
                    $partner_price = $price-$percent_price;

                    if($trip->available_of_person >= $number_of_passenger){

                        $user = User::where('email', $request->email[0])->first();

                        if($user){
                            $trip_booking                       = new TripBooking;
                            $trip_booking->user_id              = $user->id;
                            $trip_booking->trip_id              = $request->trip_id;
                            $trip_booking->number_of_passengers = $number_of_passenger;
                            $trip_booking->price                = $price;
                            $trip_booking->partner_price        = $partner_price;
                            $trip_booking->is_payment_complete  = 0;
                            $trip_booking->status               = 1;
                            $trip_booking->save();

                            foreach($request->name as $key => $value){
                                $passenger                  = new Passenger;
                                $passenger->trip_id         = $request->trip_id;
                                $passenger->booking_user_id = $user->id;
                                $passenger->trip_booking_id = $trip_booking->id;
                                $passenger->title           = $request->title[$key];
                                $passenger->name            = $value;
                                $passenger->identity_type   = $request->identity_type[$key];
                                $passenger->identity_number = $request->identity_number[$key];
                                $passenger->mobile          = $request->mobile[$key];
                                $passenger->email           = $request->email[$key];
                                $passenger->save();
                            }

                            //trip available person update
                            //$trip                       = Trip::where('id', $request->trip_id)->first();
                            //$update_available_of_person = $trip->available_of_person-$number_of_passenger;
                            //$trip->available_of_person  = $update_available_of_person;
                           // $trip->save();

                            $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name[0];
                            $email = $request->email[0];

                            Mail::to($email)->send(new BookingUserTrip($image, $name, $email));
                        }else{
                            $password = Str::random(8);
                            $user           = new User();
                            $user->name     = $request->name[0];
                            $user->email    = $request->email[0];
                            $user->password = Hash::make($password);
                            $user->status   = 1;
                            $user->language = "en";
                            $user->mobile   = $request->mobile[0];
                            $user->title    = $request->title[0];
                            $user->save();


                            $user->syncRoles(['user']);
                            //trip booking
                            $trip_booking                       = new TripBooking;
                            $trip_booking->user_id              = $user->id;
                            $trip_booking->trip_id              = $request->trip_id;
                            $trip_booking->number_of_passengers = $number_of_passenger;
                            $trip_booking->price                = $price;
                            $trip_booking->partner_price        = $partner_price;
                            $trip_booking->is_payment_complete  = 0;
                            $trip_booking->status               = 1;
                            $trip_booking->save();

                            foreach($request->name as $key => $value){
                                $passenger                  = new Passenger;
                                $passenger->trip_id         = $request->trip_id;
                                $passenger->booking_user_id = $user->id;
                                $passenger->trip_booking_id = $trip_booking->id;
                                $passenger->title           = $request->title[$key];
                                $passenger->name            = $value;
                                $passenger->identity_type   = $request->identity_type[$key];
                                $passenger->identity_number = $request->identity_number[$key];
                                $passenger->mobile          = $request->mobile[$key];
                                $passenger->email           = $request->email[$key];
                                $passenger->save();
                            }

                            //trip available person update
                            //$trip                       = Trip::where('id', $request->trip_id)->first();
                           // $update_available_of_person = $trip->available_of_person-$number_of_passenger;
                           // $trip->available_of_person  = $update_available_of_person;
                           // $trip->save();


                            $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name[0];
                            $email = $request->email[0];

                            Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                        }

                        return response()->json([
                            'status' => 'Success',
                            'user_id' => $user->id,
                            'trip_booking_id' => $trip_booking->id,
                            'code' => 201
                        ], 201);
                    }else{
                        return response()->json([
                            'status' => 'Not Available Seat',
                            'trip_id' => $trip->id,
                            'code' => 201
                        ], 201);
                    }
                }
            }else{
                $charge = ServiceCharge::where('type', 0)->first();
                $percent_price = ($charge->charge/100)*$price;
                $partner_price = $price-$percent_price;

                if($trip->available_of_person >= $number_of_passenger){

                    $user = User::where('email', $request->email[0])->first();

                    if($user){
                        $trip_booking                       = new TripBooking;
                        $trip_booking->user_id              = $user->id;
                        $trip_booking->trip_id              = $request->trip_id;
                        $trip_booking->number_of_passengers = $number_of_passenger;
                        $trip_booking->price                = $price;
                        $trip_booking->partner_price        = $partner_price;
                        $trip_booking->is_payment_complete  = 0;
                        $trip_booking->status               = 1;
                        $trip_booking->save();

                        foreach($request->name as $key => $value){
                            $passenger                  = new Passenger;
                            $passenger->trip_id         = $request->trip_id;
                            $passenger->booking_user_id = $user->id;
                            $passenger->trip_booking_id = $trip_booking->id;
                            $passenger->title           = $request->title[$key];
                            $passenger->name            = $value;
                            $passenger->identity_type   = $request->identity_type[$key];
                            $passenger->identity_number = $request->identity_number[$key];
                            $passenger->mobile          = $request->mobile[$key];
                            $passenger->email           = $request->email[$key];
                            $passenger->save();
                        }

                        //trip available person update
                       // $trip                       = Trip::where('id', $request->trip_id)->first();
                        //$update_available_of_person = $trip->available_of_person-$number_of_passenger;
                       // $trip->available_of_person  = $update_available_of_person;
                       // $trip->save();

                        $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                        $encrypted = Crypt::encryptString($qr_code);
                        $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                        $image = $path;
                        $name = $request->name[0];
                        $email = $request->email[0];

                        Mail::to($email)->send(new BookingUserTrip($image, $name, $email));
                    }else{
                        $password = Str::random(8);
                        $user           = new User();
                        $user->name     = $request->name[0];
                        $user->email    = $request->email[0];
                        $user->password = Hash::make($password);
                        $user->status   = 1;
                        $user->language = "en";
                        $user->mobile   = $request->mobile[0];
                        $user->title    = $request->title[0];
                        $user->save();


                        $user->syncRoles(['user']);
                        //trip booking
                        $trip_booking                       = new TripBooking;
                        $trip_booking->user_id              = $user->id;
                        $trip_booking->trip_id              = $request->trip_id;
                        $trip_booking->number_of_passengers = $number_of_passenger;
                        $trip_booking->price                = $price;
                        $trip_booking->partner_price        = $partner_price;
                        $trip_booking->is_payment_complete  = 0;
                        $trip_booking->status               = 1;
                        $trip_booking->save();

                        foreach($request->name as $key => $value){
                            $passenger                  = new Passenger;
                            $passenger->trip_id         = $request->trip_id;
                            $passenger->booking_user_id = $user->id;
                            $passenger->trip_booking_id = $trip_booking->id;
                            $passenger->title           = $request->title[$key];
                            $passenger->name            = $value;
                            $passenger->identity_type   = $request->identity_type[$key];
                            $passenger->identity_number = $request->identity_number[$key];
                            $passenger->mobile          = $request->mobile[$key];
                            $passenger->email           = $request->email[$key];
                            $passenger->save();
                        }

                        //trip available person update
                       // $trip                       = Trip::where('id', $request->trip_id)->first();
                      //  $update_available_of_person = $trip->available_of_person-$number_of_passenger;
                       // $trip->available_of_person  = $update_available_of_person;
                        //$trip->save();


                        $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                        $encrypted = Crypt::encryptString($qr_code);
                        $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                        $image = $path;
                        $name = $request->name[0];
                        $email = $request->email[0];

                        Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                    }
                    // return redirect('payment/'.$trip_booking->id.'/'.$user->id);

                    return response()->json([
                        'status' => 'Success',
                        'user_id' => $user->id,
                        'trip_booking_id' => $trip_booking->id,
                        'code' => 201
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 'Not Available Seat',
                        'trip_id' => $trip->id,
                        'code' => 201
                    ], 201);
                }
            }
        }else{
            $charge = ServiceCharge::where('type', 0)->first();
            $percent_price = ($charge->charge/100)*$price;
            $partner_price = $price-$percent_price;

            if($trip->available_of_person >= $number_of_passenger){

                $user = User::where('email', $request->email[0])->first();

                if($user){
                    $trip_booking                       = new TripBooking;
                    $trip_booking->user_id              = $user->id;
                    $trip_booking->trip_id              = $request->trip_id;
                    $trip_booking->number_of_passengers = $number_of_passenger;
                    $trip_booking->price                = $price;
                    $trip_booking->partner_price        = $partner_price;
                    $trip_booking->is_payment_complete  = 0;
                    $trip_booking->status               = 1;
                    $trip_booking->save();

                    foreach($request->name as $key => $value){
                        $passenger                  = new Passenger;
                        $passenger->trip_id         = $request->trip_id;
                        $passenger->booking_user_id = $user->id;
                        $passenger->trip_booking_id = $trip_booking->id;
                        $passenger->title           = $request->title[$key];
                        $passenger->name            = $value;
                        $passenger->identity_type   = $request->identity_type[$key];
                        $passenger->identity_number = $request->identity_number[$key];
                        $passenger->mobile          = $request->mobile[$key];
                        $passenger->email           = $request->email[$key];
                        $passenger->save();
                    }

                    //trip available person update
                    $trip                       = Trip::where('id', $request->trip_id)->first();
                    $update_available_of_person = $trip->available_of_person-$number_of_passenger;
                    $trip->available_of_person  = $update_available_of_person;
                    $trip->save();

                    $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                    $encrypted = Crypt::encryptString($qr_code);
                    $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                    $image = $path;
                    $name = $request->name[0];
                    $email = $request->email[0];

                    Mail::to($email)->send(new BookingUserTrip($image, $name, $email));
                }else{
                    $password = Str::random(8);
                    $user           = new User();
                    $user->name     = $request->name[0];
                    $user->email    = $request->email[0];
                    $user->password = Hash::make($password);
                    $user->status   = 1;
                    $user->language = "en";
                    $user->mobile   = $request->mobile[0];
                    $user->title    = $request->title[0];
                    $user->save();


                    $user->syncRoles(['user']);
                    //trip booking
                    $trip_booking                       = new TripBooking;
                    $trip_booking->user_id              = $user->id;
                    $trip_booking->trip_id              = $request->trip_id;
                    $trip_booking->number_of_passengers = $number_of_passenger;
                    $trip_booking->price                = $price;
                    $trip_booking->partner_price        = $partner_price;
                    $trip_booking->is_payment_complete  = 0;
                    $trip_booking->status               = 1;
                    $trip_booking->save();

                    foreach($request->name as $key => $value){
                        $passenger                  = new Passenger;
                        $passenger->trip_id         = $request->trip_id;
                        $passenger->booking_user_id = $user->id;
                        $passenger->trip_booking_id = $trip_booking->id;
                        $passenger->title           = $request->title[$key];
                        $passenger->name            = $value;
                        $passenger->identity_type   = $request->identity_type[$key];
                        $passenger->identity_number = $request->identity_number[$key];
                        $passenger->mobile          = $request->mobile[$key];
                        $passenger->email           = $request->email[$key];
                        $passenger->save();
                    }

                    //trip available person update
                   // $trip                       = Trip::where('id', $request->trip_id)->first();
                  //  $update_available_of_person = $trip->available_of_person-$number_of_passenger;
                  //  $trip->available_of_person  = $update_available_of_person;
                  //  $trip->save();


                    $qr_code = 'Booking No:'.$trip_booking->id.',Person:'.$trip_booking->number_of_passengers.',Price:'.$trip_booking->price.',Trip id:'.$trip_booking->trip_id;
                    $encrypted = Crypt::encryptString($qr_code);
                    $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                    $image = $path;
                    $name = $request->name[0];
                    $email = $request->email[0];

                    Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                }
                return response()->json([
                    'status' => 'Success',
                    'user_id' => $user->id,
                    'trip_booking_id' => $trip_booking->id,
                    'code' => 201
                ], 201);
            }else{
                return response()->json([
                    'status' => 'Not Available Seat',
                    'trip_id' => $trip->id,
                    'code' => 201
                ], 201);
            }
        }
    }

    public function storeShip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_id'        => 'required',
            'number_of_bag'  => 'required|integer',
            'name'           => 'required',
            'email'          => 'required|email',
            'title'          => 'required|integer',
			'mobile'         => 'required',
			'sender_title'   => 'required|integer',
			'sender_name'    => 'required',
			'sender_email'   => 'required|email',
			'sender_phone'   => 'required',
			'sender_address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all(), 'code' => 422], 422);
        }
        $trip = Trip::where('id', $request->trip_id)->first();
        $number_of_bag = $request->number_of_bag;
        $price = $trip->price_per_bag*$number_of_bag;

        $wallet_price = 0;
        if(Auth::check()){

            $wallet_amount = PartnerAmount::where('partner_id', Auth::id())->first();
            if($wallet_amount != null){
                if($wallet_amount->total_amount >= $price){

                    $wallet_price += (float)$wallet_amount->total_amount;

                    if($wallet_price != 0){
                        $update_amount = $wallet_price-$price;

                        $wallet_amount->total_amount = $update_amount;
                        $wallet_amount->save();
                    }

                    $charge = ServiceCharge::where('type', 1)->first();
                    $percent_price = ($charge->charge/100)*$price;
                    $partner_price = $price-$percent_price;

                    if($trip->available_of_bag >= $number_of_bag){
                        $user = User::where('email', $request->email)->first();

                        if($user){
                            $trip_booking                      = new ShipmentBooking;
                            $trip_booking->user_id             = $user->id;
                            $trip_booking->trip_id             = $request->trip_id;
                            $trip_booking->number_of_bag       = $number_of_bag;
                            $trip_booking->price               = $price;
                            $trip_booking->partner_price       = $partner_price;
                            $trip_booking->is_payment_complete = 1;
                            $trip_booking->payment_method      = 'wallet';
                            $trip_booking->status              = 1;
                            $trip_booking->sender_title        = $request->sender_title;
                            $trip_booking->sender_name         = $request->sender_name;
                            $trip_booking->sender_email        = $request->sender_email;
                            $trip_booking->sender_phone        = $request->sender_phone;
                            $trip_booking->sender_address      = $request->sender_address;
                            $trip_booking->save();

                            //trip available person update
                            $trip                    = Trip::where('id', $request->trip_id)->first();
                            $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                            $trip->available_of_bag  = $update_available_of_bag;
                            $trip->save();

                            $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name;
                            $email = $request->email;

                            Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                        }else{
                            $password = Str::random(8);
                            $user           = new User();
                            $user->name     = $request->name;
                            $user->email    = $request->email;
                            $user->password = Hash::make($password);
                            $user->status   = 1;
                            $user->language = "en";
                            $user->mobile   = $request->mobile;
                            $user->title    = $request->title;
                            $user->save();


                            $user->syncRoles(['user']);
                            //trip booking
                            $trip_booking                      = new ShipmentBooking;
                            $trip_booking->user_id             = $user->id;
                            $trip_booking->trip_id             = $request->trip_id;
                            $trip_booking->number_of_bag       = $number_of_bag;
                            $trip_booking->price               = $price;
                            $trip_booking->partner_price       = $partner_price;
                            $trip_booking->is_payment_complete = 1;
                            $trip_booking->payment_method      = 'wallet';
                            $trip_booking->status              = 1;
                            $trip_booking->sender_title        = $request->sender_title;
                            $trip_booking->sender_name         = $request->sender_name;
                            $trip_booking->sender_email        = $request->sender_email;
                            $trip_booking->sender_phone        = $request->sender_phone;
                            $trip_booking->sender_address      = $request->sender_address;
                            $trip_booking->save();

                            //trip available person update
                            $trip                    = Trip::where('id', $request->trip_id)->first();
                            $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                            $trip->available_of_bag  = $update_available_of_bag;
                            $trip->save();

                            $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name;
                            $email = $request->email;

                            Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                            Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                        }
                        return response()->json([
                            'status' => 'Success',
                            'user_id' => $user->id,
                            'trip_booking_id' => $trip_booking->id,
                            'code' => 201
                        ], 201);

                    }else{
                        return response()->json([
                            'status' => 'Not Available Bag Space',
                            'trip_id' => $trip->id,
                            'code' => 201
                        ]);
                    }

                }else{
                    $charge = ServiceCharge::where('type', 1)->first();
                    $percent_price = ($charge->charge/100)*$price;
                    $partner_price = $price-$percent_price;

                    if($trip->available_of_bag >= $number_of_bag){
                        $user = User::where('email', $request->email)->first();

                        if($user){
                            $trip_booking                      = new ShipmentBooking;
                            $trip_booking->user_id             = $user->id;
                            $trip_booking->trip_id             = $request->trip_id;
                            $trip_booking->number_of_bag       = $number_of_bag;
                            $trip_booking->price               = $price;
                            $trip_booking->partner_price       = $partner_price;
                            $trip_booking->is_payment_complete = 0;
                            $trip_booking->status              = 1;
                            $trip_booking->sender_title        = $request->sender_title;
                            $trip_booking->sender_name         = $request->sender_name;
                            $trip_booking->sender_email        = $request->sender_email;
                            $trip_booking->sender_phone        = $request->sender_phone;
                            $trip_booking->sender_address      = $request->sender_address;
                            $trip_booking->save();

                            //trip available person update
                            $trip                    = Trip::where('id', $request->trip_id)->first();
                            $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                            $trip->available_of_bag  = $update_available_of_bag;
                            $trip->save();

                            $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name;
                            $email = $request->email;

                            Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                        }else{
                            $password = Str::random(8);
                            $user           = new User();
                            $user->name     = $request->name;
                            $user->email    = $request->email;
                            $user->password = Hash::make($password);
                            $user->status   = 1;
                            $user->language = "en";
                            $user->mobile   = $request->mobile;
                            $user->title    = $request->title;
                            $user->save();


                            $user->syncRoles(['user']);
                            //trip booking
                            $trip_booking                      = new ShipmentBooking;
                            $trip_booking->user_id             = $user->id;
                            $trip_booking->trip_id             = $request->trip_id;
                            $trip_booking->number_of_bag       = $number_of_bag;
                            $trip_booking->price               = $price;
                            $trip_booking->partner_price       = $partner_price;
                            $trip_booking->is_payment_complete = 0;
                            $trip_booking->status              = 1;
                            $trip_booking->sender_title        = $request->sender_title;
                            $trip_booking->sender_name         = $request->sender_name;
                            $trip_booking->sender_email        = $request->sender_email;
                            $trip_booking->sender_phone        = $request->sender_phone;
                            $trip_booking->sender_address      = $request->sender_address;
                            $trip_booking->save();

                            //trip available person update
                            $trip                    = Trip::where('id', $request->trip_id)->first();
                            $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                            $trip->available_of_bag  = $update_available_of_bag;
                            $trip->save();

                            $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                            $encrypted = Crypt::encryptString($qr_code);
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            $image = $path;
                            $name = $request->name;
                            $email = $request->email;

                            Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                            Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                        }
                        return response()->json([
                            'status' => 'Success',
                            'user_id' => $user->id,
                            'trip_booking_id' => $trip_booking->id,
                            'code' => 201
                        ], 201);

                    }else{
                        return response()->json([
                            'status' => 'Not Available Bag Space',
                            'trip_id' => $trip->id,
                            'code' => 201
                        ], 201);
                    }
                }
            }else{
                $charge = ServiceCharge::where('type', 1)->first();
                $percent_price = ($charge->charge/100)*$price;
                $partner_price = $price-$percent_price;

                if($trip->available_of_bag >= $number_of_bag){
                    $user = User::where('email', $request->email)->first();

                    if($user){
                        $trip_booking                      = new ShipmentBooking;
                        $trip_booking->user_id             = $user->id;
                        $trip_booking->trip_id             = $request->trip_id;
                        $trip_booking->number_of_bag       = $number_of_bag;
                        $trip_booking->price               = $price;
                        $trip_booking->partner_price       = $partner_price;
                        $trip_booking->is_payment_complete = 0;
                        $trip_booking->status              = 1;
                        $trip_booking->sender_title        = $request->sender_title;
                        $trip_booking->sender_name         = $request->sender_name;
                        $trip_booking->sender_email        = $request->sender_email;
                        $trip_booking->sender_phone        = $request->sender_phone;
                        $trip_booking->sender_address      = $request->sender_address;
                        $trip_booking->save();

                        //trip available person update
                        $trip                    = Trip::where('id', $request->trip_id)->first();
                        $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                        $trip->available_of_bag  = $update_available_of_bag;
                        $trip->save();

                        $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                        $encrypted = Crypt::encryptString($qr_code);
                        $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                        $image = $path;
                        $name = $request->name;
                        $email = $request->email;

                        Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                    }else{
                        $password = Str::random(8);
                        $user           = new User();
                        $user->name     = $request->name;
                        $user->email    = $request->email;
                        $user->password = Hash::make($password);
                        $user->status   = 1;
                        $user->language = "en";
                        $user->mobile   = $request->mobile;
                        $user->title    = $request->title;
                        $user->save();


                        $user->syncRoles(['user']);
                        //trip booking
                        $trip_booking                      = new ShipmentBooking;
                        $trip_booking->user_id             = $user->id;
                        $trip_booking->trip_id             = $request->trip_id;
                        $trip_booking->number_of_bag       = $number_of_bag;
                        $trip_booking->price               = $price;
                        $trip_booking->partner_price       = $partner_price;
                        $trip_booking->is_payment_complete = 0;
                        $trip_booking->status              = 1;
                        $trip_booking->sender_title        = $request->sender_title;
                        $trip_booking->sender_name         = $request->sender_name;
                        $trip_booking->sender_email        = $request->sender_email;
                        $trip_booking->sender_phone        = $request->sender_phone;
                        $trip_booking->sender_address      = $request->sender_address;
                        $trip_booking->save();

                        //trip available person update
                        $trip                    = Trip::where('id', $request->trip_id)->first();
                        $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                        $trip->available_of_bag  = $update_available_of_bag;
                        $trip->save();

                        $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                        $encrypted = Crypt::encryptString($qr_code);
                        $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                        $image = $path;
                        $name = $request->name;
                        $email = $request->email;

                        Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                        Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                    }
                    return response()->json([
                        'status' => 'Success',
                        'user_id' => $user->id,
                        'trip_booking_id' => $trip_booking->id,
                        'code' => 201
                    ], 201);

                }else{
                    return response()->json([
                        'status' => 'Not Available Bag Space',
                        'trip_id' => $trip->id,
                        'code' => 201
                    ], 201);
                }
            }
        }else{
            $charge = ServiceCharge::where('type', 1)->first();
            $percent_price = ($charge->charge/100)*$price;
            $partner_price = $price-$percent_price;

            if($trip->available_of_bag >= $number_of_bag){
                $user = User::where('email', $request->email)->first();

                if($user){
                    $trip_booking                      = new ShipmentBooking;
                    $trip_booking->user_id             = $user->id;
                    $trip_booking->trip_id             = $request->trip_id;
                    $trip_booking->number_of_bag       = $number_of_bag;
                    $trip_booking->price               = $price;
                    $trip_booking->partner_price       = $partner_price;
                    $trip_booking->is_payment_complete = 0;
                    $trip_booking->status              = 1;
                    $trip_booking->sender_title        = $request->sender_title;
                    $trip_booking->sender_name         = $request->sender_name;
                    $trip_booking->sender_email        = $request->sender_email;
                    $trip_booking->sender_phone        = $request->sender_phone;
                    $trip_booking->sender_address      = $request->sender_address;
                    $trip_booking->save();

                    //trip available person update
                    $trip                    = Trip::where('id', $request->trip_id)->first();
                    $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                    $trip->available_of_bag  = $update_available_of_bag;
                    $trip->save();

                    $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                    $encrypted = Crypt::encryptString($qr_code);
                    $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                    $image = $path;
                    $name = $request->name;
                    $email = $request->email;

                    Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                }else{
                    $password = Str::random(8);
                    $user           = new User();
                    $user->name     = $request->name;
                    $user->email    = $request->email;
                    $user->password = Hash::make($password);
                    $user->status   = 1;
                    $user->language = "en";
                    $user->mobile   = $request->mobile;
                    $user->title    = $request->title;
                    $user->save();


                    $user->syncRoles(['user']);
                    //trip booking
                    $trip_booking                      = new ShipmentBooking;
                    $trip_booking->user_id             = $user->id;
                    $trip_booking->trip_id             = $request->trip_id;
                    $trip_booking->number_of_bag       = $number_of_bag;
                    $trip_booking->price               = $price;
                    $trip_booking->partner_price       = $partner_price;
                    $trip_booking->is_payment_complete = 0;
                    $trip_booking->status              = 1;
                    $trip_booking->sender_title        = $request->sender_title;
                    $trip_booking->sender_name         = $request->sender_name;
                    $trip_booking->sender_email        = $request->sender_email;
                    $trip_booking->sender_phone        = $request->sender_phone;
                    $trip_booking->sender_address      = $request->sender_address;
                    $trip_booking->save();

                    //trip available person update
                    $trip                    = Trip::where('id', $request->trip_id)->first();
                    $update_available_of_bag = $trip->available_of_bag-$number_of_bag;
                    $trip->available_of_bag  = $update_available_of_bag;
                    $trip->save();

                    $qr_code = 'Booking No:'.$trip_booking->id.', Bag:'.$trip_booking->number_of_bag.', Price:'.$trip_booking->price.', Trip id:'.$trip_booking->trip_id;
                    $encrypted = Crypt::encryptString($qr_code);
                    $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                    $image = $path;
                    $name = $request->name;
                    $email = $request->email;

                    Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));
                    Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                }
                return response()->json([
                    'status' => 'Success',
                    'user_id' => $user->id,
                    'trip_booking_id' => $trip_booking->id,
                    'code' => 201
                ]);

            }else{
                return response()->json([
                    'status' => 'Not Available Bag Space',
                    'trip_id' => $trip->id,
                    'code' => 201
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip_booking = TripBooking::with(['user', 'passengers', 'trip' => function($qu){
                $qu->with(['cityFrom', 'cityTo', 'user', 'cars']);
            }])->find($id);
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);

        return response()->json([
            'trip_booking' => $trip_booking,
            'code' => 201
        ]);
    }

    public function showShip($id)
    {
        $trip_booking = ShipmentBooking::with(['trip' => function($qu){
                $qu->withTrashed()->with('cityFrom', 'cityTo');
            }])->find($id);
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);
        return response()->json([
            'trip_booking' => $trip_booking,
            'code' => 201
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function checkIn(Request $request)
    {
        $decryipted =  Crypt::decryptString($request->encrypt_data);
        $arr = explode(',', $decryipted);
        $data = [];
        foreach($arr as $sig){
            $ex = explode(':', $sig);
            $data[$ex[0]] = $ex[1];
        }

        $trip_booking = TripBooking::where('trip_id', $data['Trip id'])->where('id', $data['Booking No'])->first();
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);

        if($trip_booking){
            $trip_booking->status = 2;
            $trip_booking->check_in = Carbon::now()->format('Y-m-d H:i');
            $trip_booking->save();

            return response()->json([
                'message' => 'Checked In Success',
                'status' => 1,
                'code' => 201
            ], 201);
        }else{
            return response()->json([
                'message' => 'Checked In Failed',
                'status' => 0,
                'code' => 201
            ], 201);
        }
    }

    public function checkOut(Request $request)
    {
        $decryipted =  Crypt::decryptString($request->encrypt_data);
        $arr = explode(',', $decryipted);
        $data = [];
        foreach ($arr as $sig) {
            $ex = explode(':', $sig);
            $data[$ex[0]] = $ex[1];
        }

        $trip_booking = TripBooking::where('trip_id', $data['Trip id'])->where('id', $data['Booking No'])->first();
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);

        if ($trip_booking) {
            $trip_booking->status = 3;
            $trip_booking->check_out = Carbon::now()->format('Y-m-d H:i');
            $trip_booking->save();

            return response()->json([
                'message' => 'Checked Out Success',
                'status' => 1,
                'code' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Checked Out Failed',
                'status' => 0,
                'code' => 201
            ], 201);
        }
    }

    public function tripBookingComplete($id)
    {
        $trip_booking = TripBooking::find($id);
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);
        $trip_booking->status = 4;
        $trip_booking->save();
        return response()->json([
            'message' => 'Trip Booking Complete',
            'code' => 201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip_booking = TripBooking::find($id);
        if(!$trip_booking)
            return response()->json(['status' => 'Booking Not Found', 'code' => 404], 404);
        $trip_booking->delete();
        return response()->json([
            'message' => 'Trip Booking Deleted!',
            'code' => 201
        ], 201);
    }

    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
