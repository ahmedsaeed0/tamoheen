<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;


use App\Models\City;

use App\Models\Category;

use App\Models\Product;

use App\Models\Trip;

use App\Models\Address;

use Carbon\Carbon;

use App\Models\Cart;

use App\Models\State;

use App\Models\Country;

use App\Models\ProductType;

use App\Models\ShipmentBooking;

use App\Models\ServiceCharge;

use App\Models\PartnerMeta;

use Auth;

use Session;

use URL;

use App\Models\Car;

use DB;

use Log;

use PDF;





use Illuminate\Support\Facades\Mail;

use App\Mail\tripCancel;

use App\Mail\BookingTrip;

use App\Mail\BookingUserTrip;

use App\Mail\ShipmentReceiveUser;

use App\Mail\NotificationDriver;

use App\Models\TripBooking;

use App\Models\Feature;

use App\Models\User;

use App\Models\Term;

use App\Models\Passenger;

use DNS1D;

use DNS2D;

use Storage;

use Illuminate\Support\Facades\Crypt;

use Hash;

use App\Models\Review;

use App\Models\ShipReview;

use App\Models\Complain;

use App\Models\Order;

use App\Models\Slider;

use App\Models\PartnerPaymentHostory;

use App\Models\PartnerAmount;

use App\Models\PartnerPaymentMethod;

use App\classes\Qrcodes;

use App\Mail\CustomerBoardingPass;

use App\Models\Page;

use QrCode;

use Illuminate\Support\Str;

use App\Traits\WaslTrait;

use App\Traits\AddressTrait;

use Illuminate\Support\Facades\Password;


class FrontendsController extends Controller

{

    use WaslTrait, AddressTrait;

    public function index()

    {
       
        
        $top_cities = City::where('city_order', '!=', null)->where('city_order', '!=', 0)->orderBy('city_order', 'asc')->take(6)->get();
        
        $cities = City::with(['images', 'states'])->latest()->get();
        
        $categories = Category::latest()->get();
        
        $products = Product::with('image')->latest()->get();
        
        $sliders = Slider::get();
        
        $features = Feature::where('is_main', 1)->pluck('name', 'id');
        
        $other_features = Feature::where('is_main', 0)->pluck('name', 'id');
        
        $product_types = ProductType::latest()->get();
        
        $currentDateTime = Carbon::now();

        $newTrips = DB::table('trips')
            ->join('cities as from_city', 'trips.city_from_id', '=', 'from_city.id')
            ->join('cities as to_city', 'trips.city_to_id', '=', 'to_city.id')
            ->select('trips.date', 'from_city.name as from_city_name', 'to_city.name as to_city_name')
            ->where('trips.date', '>', $currentDateTime)
            ->get();

        $arr_image = '';

        foreach ($sliders as $slider) {

            $arr_image .= $slider->image->url ?? ''. ",";
        }

        $arr_images = rtrim($arr_image, ',');

        return view('layouts.front.home', compact('cities', 'categories', 'products', 'sliders', 'features', 'product_types', 'arr_images', 'other_features', 'top_cities', 'newTrips'));
    }

    public function testMail(){
        $email = 'dilip.rising416@gmail.com';
        
         $data = ['cancellationDate' => Carbon::now()->toDateTimeString(),
            'tripStartDate' => "test",
            'canceledBy' => 'Customer',
            'pick_up' => "test",
            'drop'=> "test",
            'brand_name'=> "test",
            'driver_name'=> "test"
            ];

          Mail::to($email)->send(new tripCancel($data));
        echo "Test email sent successfully!"; die;
    }

    public function newtestMail(){
        
        $email = 'dilip.rising416@gmail.com';
        
         $data = ['cancellationDate' => Carbon::now()->toDateTimeString(),
            'tripStartDate' => "test",
            'canceledBy' => 'Customer',
            'pick_up' => "test",
            'drop'=> "test",
            'brand_name'=> "test",
            'driver_name'=> "test"
            ];

          Mail::to($email)->send(new tripCancel($data));
        echo "Test email sent successfully!"; die;
    }

    public function termsList()

    {

        $term = Term::first();

        return view('frontend.term', compact('term'));
    }



    public function singleDynamicPage($slug)

    {
        // dd($slug);

        $page = Page::where('slug', $slug)->first();
        // dd($page);
            // return dd($slug);
        if (isset($page->status) && $page->status == 0) {

            return redirect('/');
        } else {
            
            return view('frontend.single-page', compact('page'));
        }
    }



    public function singleCity($id)

    {
        $city = DB::table('cities')->where('id', $id)->first();

        // Fetch related images for the city
        $images = DB::table('images')->where('imageable_id', operator: $id)->get('url');
        // dd($images);
    
        // Fetch related states for the city
        $states = DB::table('states')->where('country_id', $id)->get();
    
        // Return the view with the city, images, and states data
        return view('frontend.single-city', data: compact('city', 'images', 'states'));
        // dd($id);
        // $city = City::with(['images', 'states'])->findOrFail($id);
        // // dd(vars: $city->images);
        // // $images = DB::table('images');

        // // dd($images);
        // return view('frontend.single-city', compact('city'));
    }



    public function singleTrip($id)

    {

        $trip = Trip::findOrFail($id);

        $car = Car::findOrFail($trip->car_id);

        return view('frontend.single-trip', compact('trip', 'car'));
    }



    public function tripList(Request $request)

    {

        $this->validate($request, [

            'city_to' => 'required',

            'city_from' => 'required',

            'number_of_person' => 'required|numeric',

        ]);

        $cities = City::with('images', 'states')->latest()->get();

        $to_city = City::where('id', $request->city_to)->with('images')->first();

        $city_from = City::where('id', $request->city_from)->with('images')->first();

        //$features = Feature::where('is_main', 1)->pluck('name', 'id');

        $features = Feature::where('is_main', 1)->get();

        $other_features = Feature::where('is_main', 0)->pluck('name', 'id');

        Session::put('to_city', $request->city_to);

        Session::put('from_city', $request->city_from);

        Session::put('number_of_person', $request->number_of_person);

        $date = $request->date;

        $number_of_person = $request->number_of_person;





        $getBeforeDays = $this->getAgoDays($date, 3, 'Y-m-d');

        $getAfterDays = $this->getBeforeDays($date, 3, 'Y-m-d');



        $final_seven_days = array_merge(array_slice($getBeforeDays, 0, 3), array(Carbon::parse($date)->format('Y-m-d')), $getAfterDays);

        $trip = Trip::query();

        if ($request->date) {

            $date_time = Carbon::parse($request->date)->format('Y-m-d');

            $trip->whereDate('date', $date_time);
        }

        if ($request->type) {

            $trip->where('type', $request->type);
        }

        if ($request->city_from) {

            $trip->where('city_from_id', $request->city_from);
        }



        if ($request->city_to) {

            $trip->where('city_to_id', $request->city_to);
        }

        // if ($request->number_of_person) {

        //     $trip->where('available_of_person', '>=', $request->number_of_person);
        // }



        if ($request->main_feature_id) {

            $trip->where('feature_id', $request->main_feature_id);

            $main_feature_id = $request->main_feature_id;
        } else {

            $main_feature_id = null;
        }



       $trip->with(['cars' => function ($query) {

            $query->with('images', 'carFeatures');
        }]);

       



        $trips = $trip->where('status', 1)->get();



        // echo "<pre>";

        // print_r($trips);

        // die;




        return view('frontend.trip-list', compact('trips', 'cities', 'to_city', 'city_from', 'features', 'other_features', 'date', 'number_of_person', 'final_seven_days', 'main_feature_id'));
    }



    public static function getBrandName($id)
    {

        $brandName = PartnerMeta::where("user_id", $id)->select("brand_name")->first();
        if(!empty($brandName->brand_name)){
            return $brandName->brand_name;
        }else{
            return "";
        }

        
    }











    public function shipList(Request $request)

    {

        $trips = Trip::query();

        if ($request->date) {

            $date_time = Carbon::parse($request->date)->format('Y-m-d');

            $trips->whereDate('date', $date_time);
        }

        if ($request->type) {

            $trips->where('type', $request->type);
        }

        if ($request->city_from) {

            $trips->where('city_from_id', $request->city_from);
        }

        if ($request->city_to) {

            $trips->where('city_to_id', $request->city_to);
        }



        if ($request->number_of_bag) {

            $trips->where('available_of_bag', '>=', $request->number_of_bag);
        }



        if ($request->product_type_id) {

            $product_type_id = $request->product_type_id;

            $trips->with(['tripProductTypes' => function ($query) use ($product_type_id) {

                $query->where('product_types.id', $product_type_id);
            }]);
        }



        $trips = $trips->where('status', 1)->get();



        $cities = City::with('images', 'states')->latest()->get();

        $to_city = City::where('id', $request->city_to)->with('images')->first();

        Session::put('to_city', $request->city_to);

        $product_types = ProductType::latest()->get();



        return view('frontend.ship-list', compact('trips', 'cities', 'to_city', 'product_types'));
    }





    public function tripSearchByPriceRange($min_price, $max_price, $to_city)

    {

        $price_min = (int) $min_price;

        $price_max = (int) $max_price;



        $cities = City::with('images', 'states')->latest()->get();

        $trips = Trip::whereBetween('price_per_person', [$price_min, $price_max])->with(['cars' => function ($query) {

            $query->with('images', 'carFeatures');
        }])->where('type', 1)->get();

        $to_city = City::where('id', $to_city)->with('images')->first();

        $features = Feature::where('is_main', 1)->pluck('name', 'id');

        return view('frontend.trip-list', compact('trips', 'cities', 'to_city', 'features'));
    }



    public function shipSearchByPriceRange($min_price, $max_price, $to_city)

    {

        $price_min = (int) $min_price;

        $price_max = (int) $max_price;



        $cities = City::with('images', 'states')->latest()->get();

        $trips = Trip::whereBetween('price_per_bag', [$price_min, $price_max])->with(['cars' => function ($query) {

            $query->with('images', 'carFeatures');
        }])->where('type', 2)->get();

        $to_city = City::where('id', $to_city)->with('images')->first();

        $product_types = ProductType::latest()->get();

        return view('frontend.ship-list', compact('trips', 'cities', 'to_city', 'features', 'product_types'));
    }



    public function tripBookingForm(Request $request)

    {
        $trip = TripBooking::where('trip_id', $request->trip_id)->where('user_id', Auth::id())->first();

        $single_trip = Trip::findOrFail($request->trip_id);
    
        if ($trip) {

            if ($trip->status == 0) {

                return redirect('single-trip/' . $request->trip_id)->with('warning', 'Already you booked that trip.');
            } elseif ($trip->status == 4) {

                return redirect('single-trip/' . $request->trip_id)->with('warning', 'Already finished this trip.');
            } else {
        
                if($single_trip->available_of_person >= $request->number_of_person){
                    $trip = Trip::findOrFail($request->trip_id);
                    $number_of_person = $request->number_of_person;
                    return view('frontend.trip-booking-form', compact('trip', 'number_of_person'));
                }else{
                    return redirect('single-trip/' . $request->trip_id)->with('warning', 'Seat Not Available.');
                }
            }
        } else {

            $trip = Trip::findOrFail($request->trip_id);
            if($trip->available_of_person >= $request->number_of_person){
                $number_of_person = $request->number_of_person;
                return view('frontend.trip-booking-form', compact('trip', 'number_of_person'));
            }else{
                return redirect('single-trip/' . $request->trip_id)->with('warning', 'Seat Not Available.');
            }
        }
    }



    public function shipmentForm(Request $request)

    {

        $trip = TripBooking::where('trip_id', $request->trip_id)->where('user_id', Auth::id())->first();

        if ($trip) {

            return redirect('single-trip/' . $request->trip_id)->with('warning', 'Already you booked that trip.');
        } else {

            $trip = Trip::findOrFail($request->trip_id);

            return view('frontend.shipment-form', compact('trip'));
        }
    }



    public function shipmentFormSubmit(Request $request)

    {

        $trip = Trip::where('id', $request->trip_id)->first();

        $number_of_bag = $request->number_of_bag;

        $price = $trip->price_per_bag * $number_of_bag;



        $wallet_price = 0;

        if (Auth::check()) {



            $wallet_amount = PartnerAmount::where('partner_id', Auth::id())->first();

            if ($wallet_amount != null) {

                if ($wallet_amount->total_amount >= $price) {



                    $wallet_price += (float)$wallet_amount->total_amount;



                    if ($wallet_price != 0) {

                        $update_amount = $wallet_price - $price;



                        $wallet_amount->total_amount = $update_amount;

                        $wallet_amount->save();
                    }



                    $charge = ServiceCharge::where('type', 1)->first();

                    $percent_price = ($charge->charge / 100) * $price;

                    $partner_price = $price - $percent_price;



                    if ($trip->available_of_bag >= $number_of_bag) {

                        $user = User::where('email', $request->email)->first();



                        if ($user) {

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

                            $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                            $trip->available_of_bag  = $update_available_of_bag;

                            $trip->save();



                            $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                            $encrypted = Crypt::encryptString($qr_code);

                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            $image = $path;

                            $name = $request->name;

                            $email = $request->email;



                            Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                        } else {

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

                            $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                            $trip->available_of_bag  = $update_available_of_bag;

                            $trip->save();



                            $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                            $encrypted = Crypt::encryptString($qr_code);

                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            $image = $path;

                            $name = $request->name;

                            $email = $request->email;



                            Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));

                            Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                        }



                        return redirect('shipment-payment-success/' . $trip_booking->id);
                    } else {

                        return redirect('single-trip/' . $trip->id)->with('warning', 'Bag Space Not Available.');
                    }
                } else {

                    $charge = ServiceCharge::where('type', 1)->first();

                    $percent_price = ($charge->charge / 100) * $price;

                    $partner_price = $price - $percent_price;



                    if ($trip->available_of_bag >= $number_of_bag) {

                        $user = User::where('email', $request->email)->first();



                        if ($user) {

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

                            $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                            $trip->available_of_bag  = $update_available_of_bag;

                            $trip->save();



                            $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                            $encrypted = Crypt::encryptString($qr_code);

                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            $image = $path;

                            $name = $request->name;

                            $email = $request->email;



                            Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                        } else {

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

                            $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                            $trip->available_of_bag  = $update_available_of_bag;

                            $trip->save();



                            $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                            $encrypted = Crypt::encryptString($qr_code);

                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            $image = $path;

                            $name = $request->name;

                            $email = $request->email;



                            Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));

                            Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                        }



                        return redirect('ship-payment/' . $trip_booking->id . '/' . $user->id);
                    } else {

                        return redirect('single-trip/' . $trip->id)->with('warning', 'Bag Space Not Available.');
                    }
                }
            } else {

                $charge = ServiceCharge::where('type', 1)->first();

                $percent_price = ($charge->charge / 100) * $price;

                $partner_price = $price - $percent_price;



                if ($trip->available_of_bag >= $number_of_bag) {

                    $user = User::where('email', $request->email)->first();



                    if ($user) {

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

                        $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                        $trip->available_of_bag  = $update_available_of_bag;

                        $trip->save();



                        $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                        $encrypted = Crypt::encryptString($qr_code);

                        $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                        $image = $path;

                        $name = $request->name;

                        $email = $request->email;



                        Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                    } else {

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

                        $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                        $trip->available_of_bag  = $update_available_of_bag;

                        $trip->save();



                        $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                        $encrypted = Crypt::encryptString($qr_code);

                        $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                        $image = $path;

                        $name = $request->name;

                        $email = $request->email;



                        Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));

                        Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                    }



                    return redirect('ship-payment/' . $trip_booking->id . '/' . $user->id);
                } else {

                    return redirect('single-trip/' . $trip->id)->with('warning', 'Bag Space Not Available.');
                }
            }
        } else {

            $charge = ServiceCharge::where('type', 1)->first();

            $percent_price = ($charge->charge / 100) * $price;

            $partner_price = $price - $percent_price;



            if ($trip->available_of_bag >= $number_of_bag) {

                $user = User::where('email', $request->email)->first();



                if ($user) {

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

                    $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                    $trip->available_of_bag  = $update_available_of_bag;

                    $trip->save();



                    $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                    $encrypted = Crypt::encryptString($qr_code);

                    $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                    $image = $path;

                    $name = $request->name;

                    $email = $request->email;



                    Mail::to([$email, $request->sender_email])->send(new BookingUserTrip($image, $name, $email));
                } else {

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

                    $update_available_of_bag = $trip->available_of_bag - $number_of_bag;

                    $trip->available_of_bag  = $update_available_of_bag;

                    $trip->save();



                    $qr_code = 'Booking No:' . $trip_booking->id . ', Bag:' . $trip_booking->number_of_bag . ', Price:' . $trip_booking->price . ', Trip id:' . $trip_booking->trip_id;

                    $encrypted = Crypt::encryptString($qr_code);

                    $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                    $image = $path;

                    $name = $request->name;

                    $email = $request->email;



                    Mail::to($email)->send(new BookingTrip($image, $name, $email, $password));

                    Mail::to($request->sender_email)->send(new ShipmentReceiveUser($image, $name, $email));
                }



                return redirect('ship-payment/' . $trip_booking->id . '/' . $user->id);
            } else {

                return redirect('single-trip/' . $trip->id)->with('warning', 'Bag Space Not Available.');
            }
        }
    }

    public static function updateTripPerson($trip_id,$trip_booking_id){

        $trip = Trip::where('id', $trip_id)->first();
        $tripbooking = TripBooking::where('id', $trip_booking_id)->first();
		$update_available_of_person = $trip->available_of_person-$tripbooking->number_of_passengers;
		$trip->available_of_person  = $update_available_of_person;
		$trip->save();
    }




    public function tripBookingFormSubmit(Request $request)

    {         
                $trip = Trip::where('id', $request->trip_id)->first();
                
                $cars = car::where("id", $trip->car_id)->first();

                $number_of_passenger = $request->number_of_passenger;

                if ($trip) {
                    
            if ($trip->discount > 0) {
                
                $price = $trip->discount * $number_of_passenger;
            } else {

                $price = $trip->price_per_person * $number_of_passenger;
            }
        }

       
        
        $wallet_price = 0;
        
        if (Auth::check()) {
            
            $wallet_amount = PartnerAmount::where('partner_id', Auth::id())->first();
            $auth_user_id = Auth::id();
            if ($wallet_amount != null) {
                
                if ($wallet_amount->total_amount >= $price) {
                     
                    
                    $wallet_price += (float)$wallet_amount->total_amount;
                    
                    
                    
                    
                    if ($wallet_price != 0) {
                        
                        $update_amount = $wallet_price - $price;
                        
                        
                        
                        $wallet_amount->total_amount = $update_amount;
                        
                        $wallet_amount->save();
                    }
                    
                    
                    
                    // $charge = ServiceCharge::where('type', operator: 0)->first();
                    $charge = ServiceCharge::where('type', 0)->withoutGlobalScopes()->first();
                    // $charge = ServiceCharge::where('type', 0)->first();
                    // $charge = ServiceCharge::withTrashed()->where('type', 0)->first('charge');




                    dd($charge);
                  
                    $percent_price = ($charge->charge / 100) * $price;
                    
                    $partner_price = $price - $percent_price;

                    
                    
                    if ($trip->available_of_person >= $number_of_passenger) {
                        
                        
                        
                        //$user = User::where('email', $request->email[0])->first();
                        $user = User::where('id', $auth_user_id)->first();
                        
                        
                        if ($user) {
                            
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
                            
                            
                            
                            foreach ($request->name as $key => $value) {

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

                            
                            
                          
                            
                            
                            
                            $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;
                            
                            $encrypted = Crypt::encryptString($qr_code);
                            
                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");
                            
                            $qr_url = "http://127.0.0.1:8000/public";
                            
                            $image = $path;
                            
                            $name = $request->name[0];
                            
                            $email = $request->email[0];
                            $user = User::where('id', $trip->user_id)->first();
                            $partner_mobile = $user['mobile'];
                            $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                            
                            Mail::to($email)->send(new BookingUserTrip($image, $name, $email));
                            
                            $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data
                            
                            $pdf = PDF::loadView('emails.bordingpass', $data);
                            
                            $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                            session()->put('data', $data);
                            
                            
                            
                            
                            
                            Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {
                                
                                $message->to($email)->subject('Customer Boarding Pass')
                                
                                ->attachData($pdf->output(), $name . '.pdf');
                            });
                            
                            
                            $partner_email = $user->email;        
                            Mail::send('emails.notification_driver', $data, function ($message) use ($partner_email, $name, $image) {
                                
                                $message->to($partner_email)->subject('New Trip Planned for You');
                            });



                        } else {

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



                            foreach ($request->name as $key => $value) {

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

                            // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                            // $trip->available_of_person  = $update_available_of_person;

                            // $trip->save();



                            $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                            $encrypted = Crypt::encryptString($qr_code);

                            $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            $qr_url = "http://127.0.0.1:8000/public";

                            $image = $path;

                            $name = $request->name[0];

                            $email = $request->email[0];


                            $user = User::where('id', $trip->user_id)->first();
                            $partner_mobile = $user['mobile'];
                            $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                            Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                            $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                            $pdf = PDF::loadView('emails.bordingpass', $data);

                            $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                            session()->put('data', $data);



                            Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                                $message->to($email)->subject('Customer Boarding Pass')

                                    ->attachData($pdf->output(), $name . '.pdf');
                            });

                            $partner_email = $user->email;        
                            Mail::send('emails.notification_driver', $data, function ($message) use ($partner_email, $name, $image) {
                                
                                $message->to($partner_email)->subject('New Trip Planned for You');
                            });



                            // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                        }

                        Session::forget('to_city');

                        Session::forget('from_city');

                        Session::forget('number_of_person');

                        return redirect('paytab-payment-success/' . $trip_booking->id);
                    } else {

                        return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                    }
                } else {
                    
                    

                    // $charge = ServiceCharge::where('type', 0)->first();
                    $charge = ServiceCharge::where('type', 0)->withoutGlobalScopes()->first();
                    // dd($charge);
                    $percent_price = ($charge->charge / 100) * $price;

                    $partner_price = $price - $percent_price;



                    if ($trip->available_of_person >= $number_of_passenger) {


                        //$user = User::where('email', $request->email[0])->first();
                        $user = User::where('id', $auth_user_id)->first();


                        if ($user) {

                            $trip_booking                       = new TripBooking;

                            $trip_booking->user_id              = $user->id;

                            $trip_booking->trip_id              = $request->trip_id;

                            $trip_booking->number_of_passengers = $number_of_passenger;

                            $trip_booking->price                = $price;

                            $trip_booking->partner_price        = $partner_price;

                            $trip_booking->is_payment_complete  = 0;

                            $trip_booking->status               = 1;

                            $trip_booking->save();



                            foreach ($request->name as $key => $value) {

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

                            // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                            // $trip->available_of_person  = $update_available_of_person;

                            // $trip->save();
                            
                            



                            // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                            // $encrypted = Crypt::encryptString($qr_code);

                            // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            // $qr_url = "https://tamoheen.com/public";

                            // $image = $path;

                            // $name = $request->name[0];

                            // $email = $request->email[0];


                            // $user = User::where('id', $trip->user_id)->first();
                            // $partner_mobile = $user['mobile'];
                            // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                            // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                            // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                            // $pdf = PDF::loadView('emails.bordingpass', $data);

                            // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                            // session()->put('data', $data);



                            // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                            //     $message->to($email)->subject('Customer Boarding Pass')

                            //         ->attachData($pdf->output(), $name . '.pdf');
                            // });







                            // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                        } else {

                            $password = Str::random(8);

                            $user           = new User();

                            $user->name     = $request->name[0];

                            $user->email    = $request->email[0];

                            $user->password = Hash::make($password);

                            $user->status   = 1;

                            $user->language = "en";

                            $user->mobile   = $request->mobile[0];

                            $user->title    = $request->title[0];

                            $user->identity_type    = $request->identity_type[0];

                            $user->identity_number    = $request->identity_number[0];

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



                            foreach ($request->name as $key => $value) {

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

                            // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                            // $trip->available_of_person  = $update_available_of_person;

                            // $trip->save();



                            // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                            // $encrypted = Crypt::encryptString($qr_code);

                            // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            // $qr_url = "https://tamoheen.com/public";

                            // $image = $path;

                            // $name = $request->name[0];

                            // $email = $request->email[0];


                            // $user = User::where('id', $trip->user_id)->first();
                            // $partner_mobile = $user['mobile'];
                            // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                            // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                            // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                            // $pdf = PDF::loadView('emails.bordingpass', $data);

                            // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                            // session()->put('data', $data);



                            // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                            //     $message->to($email)->subject('Customer Boarding Pass')

                            //         ->attachData($pdf->output(), $name . '.pdf');
                            // });







                            // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                        }

                        Session::forget('to_city');

                        Session::forget('from_city');

                        Session::forget('number_of_person');

                         return redirect('telr-trip-payment/' . $trip_booking->id);

                        // return redirect('payment/'.$trip_booking->id.'/'.$user->id);

                        //return redirect('paytab-payment-success/' . $trip_booking->id);

                    } else {

                        return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                    }
                }
            } else {
                
                $charge = ServiceCharge::where('type', 0)->first();

                $percent_price = ($charge->charge / 100) * $price;

                $partner_price = $price - $percent_price;



                if ($trip->available_of_person >= $number_of_passenger) {



                    //$user = User::where('email', $request->email[0])->first();
                    $user = User::where('id', $auth_user_id)->first();


                    if ($user) {
                        
                        $trip_booking                       = new TripBooking;

                        $trip_booking->user_id              = $user->id;

                        $trip_booking->trip_id              = $request->trip_id;

                        $trip_booking->number_of_passengers = $number_of_passenger;

                        $trip_booking->price                = $price;

                        $trip_booking->partner_price        = $partner_price;

                        $trip_booking->is_payment_complete  = 0;

                        $trip_booking->status               = 1;

                        $trip_booking->save();



                        foreach ($request->name as $key => $value) {

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

                        // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                        // $trip->available_of_person  = $update_available_of_person;

                        // $trip->save();



                        // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                        // $encrypted = Crypt::encryptString($qr_code);

                        // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                        // $qr_url = "https://tamoheen.com/public";

                        // $image = $path;

                        // $name = $request->name[0];

                        // $email = $request->email[0];


                        // $user = User::where('id', $trip->user_id)->first();
                        // $partner_mobile = $user['mobile'];
                        // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                        // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                        // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                        // $pdf = PDF::loadView('emails.bordingpass', $data);

                        // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                        // session()->put('data', $data);



                        // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                        //     $message->to($email)->subject('Customer Boarding Pass')

                        //         ->attachData($pdf->output(), $name . '.pdf');
                        // });

                        // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                    } else {
                        
                        $password = Str::random(8);

                        $user           = new User();

                        $user->name     = $request->name[0];

                        $user->email    = $request->email[0];

                        $user->password = Hash::make($password);

                        $user->status   = 1;

                        $user->language = "en";

                        $user->mobile   = $request->mobile[0];

                        $user->title    = $request->title[0];

                        $user->identity_type    = $request->identity_type[0];

                        $user->identity_number    = $request->identity_number[0];

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



                        foreach ($request->name as $key => $value) {

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

                        // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                        // $trip->available_of_person  = $update_available_of_person;

                        // $trip->save();



                        // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                        // $encrypted = Crypt::encryptString($qr_code);

                        // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                        // $qr_url = "https://tamoheen.com/public";

                        // $image = $path;

                        // $name = $request->name[0];

                        // $email = $request->email[0];


                        // $user = User::where('id', $trip->user_id)->first();
                        // $partner_mobile = $user['mobile'];
                        // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                        // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                        // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                        // $pdf = PDF::loadView('emails.bordingpass', $data);

                        // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                        // session()->put('data', $data);



                        // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                        //     $message->to($email)->subject('Customer Boarding Pass')

                        //         ->attachData($pdf->output(), $name . '.pdf');
                        // });

                        // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                    }

                    Session::forget('to_city');

                    Session::forget('from_city');

                    Session::forget('number_of_person');



                    return redirect('telr-trip-payment/' . $trip_booking->id);

                    //return redirect('paytab-payment-success/' . $trip_booking->id);

                    // return redirect('payment/'.$trip_booking->id.'/'.$user->id);

                } else {

                    return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                }
            }
        } else {
            
            $user = User::where('email', $request->email[0])->first();

            if ($user) {

                $wallet_amount = PartnerAmount::where('partner_id', $user->id)->first();

                if ($wallet_amount != null) {

                    if ($wallet_amount->total_amount >= $price) {



                        $wallet_price += (float)$wallet_amount->total_amount;



                        if ($wallet_price != 0) {

                            $update_amount = $wallet_price - $price;



                            $wallet_amount->total_amount = $update_amount;

                            $wallet_amount->save();
                        }



                        $charge = ServiceCharge::where('type', 0)->first();

                        $percent_price = ($charge->charge / 100) * $price;

                        $partner_price = $price - $percent_price;



                        if ($trip->available_of_person >= $number_of_passenger) {



                            $user = User::where('email', $request->email[0])->first();



                            if ($user) {

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



                                foreach ($request->name as $key => $value) {

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

                                // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                                // $trip->available_of_person  = $update_available_of_person;

                                // $trip->save();



                                $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                                $encrypted = Crypt::encryptString($qr_code);

                                $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                                $qr_url = "http://127.0.0.1:8000/public";

                                $image = $path;

                                $name = $request->name[0];

                                $email = $request->email[0];


                                $user = User::where('id', $trip->user_id)->first();
                                $partner_mobile = $user['mobile'];
                                $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                                Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                                $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                                $pdf = PDF::loadView('emails.bordingpass', $data);

                                $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                                session()->put('data', $data);



                                Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                                    $message->to($email)->subject('Customer Boarding Pass')

                                        ->attachData($pdf->output(), $name . '.pdf');
                                });


                                $partner_email = $user->email;        
                                Mail::send('emails.notification_driver', $data, function ($message) use ($partner_email, $name, $image) {
                                    
                                    $message->to($partner_email)->subject('New Trip Planned for You');
                                });




                                // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                            } else {

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



                                foreach ($request->name as $key => $value) {

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

                                // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                                // $trip->available_of_person  = $update_available_of_person;

                                // $trip->save();



                                $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                                $encrypted = Crypt::encryptString($qr_code);

                                $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                                $qr_url = "http://127.0.0.1:8000/public";

                                $image = $path;

                                $name = $request->name[0];

                                $email = $request->email[0];


                                $user = User::where('id', $trip->user_id)->first();
                                $partner_mobile = $user['mobile'];
                                $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                                Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                                $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                                $pdf = PDF::loadView('emails.bordingpass', $data);

                                $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                                session()->put('data', $data);



                                Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                                    $message->to($email)->subject('Customer Boarding Pass')

                                        ->attachData($pdf->output(), $name . '.pdf');
                                });


                                $partner_email = $user->email;        
                                Mail::send('emails.notification_driver', $data, function ($message) use ($partner_email, $name, $image) {
                                    
                                    $message->to($partner_email)->subject('New Trip Planned for You');
                                });




                                // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                            }

                            Session::forget('to_city');

                            Session::forget('from_city');

                            Session::forget('number_of_person');

                            return redirect('paytab-payment-success/' . $trip_booking->id);
                        } else {

                            return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                        }
                    } else {

                        $charge = ServiceCharge::where('type', 0)->first();

                        $percent_price = ($charge->charge / 100) * $price;

                        $partner_price = $price - $percent_price;



                        if ($trip->available_of_person >= $number_of_passenger) {



                            $user = User::where('email', $request->email[0])->first();



                            if ($user) {

                                $trip_booking                       = new TripBooking;

                                $trip_booking->user_id              = $user->id;

                                $trip_booking->trip_id              = $request->trip_id;

                                $trip_booking->number_of_passengers = $number_of_passenger;

                                $trip_booking->price                = $price;

                                $trip_booking->partner_price        = $partner_price;

                                $trip_booking->is_payment_complete  = 0;

                                $trip_booking->status               = 1;

                                $trip_booking->save();



                                foreach ($request->name as $key => $value) {

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

                                // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                                // $trip->available_of_person  = $update_available_of_person;

                                // $trip->save();



                                // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                                // $encrypted = Crypt::encryptString($qr_code);

                                // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                                // $qr_url = "https://tamoheen.com/public";

                                // $image = $path;

                                // $name = $request->name[0];

                                // $email = $request->email[0];


                                // $user = User::where('id', $trip->user_id)->first();
                                // $partner_mobile = $user['mobile'];
                                // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                                // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                                // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                                // $pdf = PDF::loadView('emails.bordingpass', $data);

                                // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                                // session()->put('data', $data);



                                // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                                //     $message->to($email)->subject('Customer Boarding Pass')

                                //         ->attachData($pdf->output(), $name . '.pdf');
                                // });





                                // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                            } else {

                                $password = Str::random(8);

                                $user           = new User();

                                $user->name     = $request->name[0];

                                $user->email    = $request->email[0];

                                $user->password = Hash::make($password);

                                $user->status   = 1;

                                $user->language = "en";

                                $user->mobile   = $request->mobile[0];

                                $user->title    = $request->title[0];

                                $user->identity_type    = $request->identity_type[0];

                                $user->identity_number    = $request->identity_number[0];

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



                                foreach ($request->name as $key => $value) {

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

                                // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                                // $trip->available_of_person  = $update_available_of_person;

                                // $trip->save();



                                // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                                // $encrypted = Crypt::encryptString($qr_code);

                                // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                                // $qr_url = "https://tamoheen.com/public";

                                // $image = $path;

                                // $name = $request->name[0];

                                // $email = $request->email[0];


                                // $user = User::where('id', $trip->user_id)->first();
                                // $partner_mobile = $user['mobile'];
                                // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                                // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                                // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                                // $pdf = PDF::loadView('emails.bordingpass', $data);

                                // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                                // session()->put('data', $data);



                                // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                                //     $message->to($email)->subject('Customer Boarding Pass')

                                //         ->attachData($pdf->output(), $name . '.pdf');
                                // });



                                // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                            }

                            Session::forget('to_city');

                            Session::forget('from_city');

                            Session::forget('number_of_person');

                             return redirect('telr-trip-payment/' . $trip_booking->id);

                            //return redirect('paytab-payment-success/' . $trip_booking->id);

                            // return redirect('payment/'.$trip_booking->id.'/'.$user->id);

                        } else {

                            return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                        }
                    }
                } else {

                    $charge = ServiceCharge::where('type', 0)->first();

                    $percent_price = ($charge->charge / 100) * $price;

                    $partner_price = $price - $percent_price;



                    if ($trip->available_of_person >= $number_of_passenger) {



                        $user = User::where('email', $request->email[0])->first();



                        if ($user) {

                            $trip_booking                       = new TripBooking;

                            $trip_booking->user_id              = $user->id;

                            $trip_booking->trip_id              = $request->trip_id;

                            $trip_booking->number_of_passengers = $number_of_passenger;

                            $trip_booking->price                = $price;

                            $trip_booking->partner_price        = $partner_price;

                            $trip_booking->is_payment_complete  = 0;

                            $trip_booking->status               = 1;

                            $trip_booking->save();



                            foreach ($request->name as $key => $value) {

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

                            // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                            // $trip->available_of_person  = $update_available_of_person;

                            // $trip->save();



                            // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                            // $encrypted = Crypt::encryptString($qr_code);

                            // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            // $qr_url = "https://tamoheen.com/public";

                            // $image = $path;

                            // $name = $request->name[0];

                            // $email = $request->email[0];


                            // $user = User::where('id', $trip->user_id)->first();
                            // $partner_mobile = $user['mobile'];
                            // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                            // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                            // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                            // $pdf = PDF::loadView('emails.bordingpass', $data);

                            // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                            // session()->put('data', $data);



                            // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                            //     $message->to($email)->subject('Customer Boarding Pass')

                            //         ->attachData($pdf->output(), $name . '.pdf');
                            // });



                            // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                        } else {

                            $password = Str::random(8);

                            $user           = new User();

                            $user->name     = $request->name[0];

                            $user->email    = $request->email[0];

                            $user->password = Hash::make($password);

                            $user->status   = 1;

                            $user->language = "en";

                            $user->mobile   = $request->mobile[0];

                            $user->title    = $request->title[0];

                            $user->identity_type    = $request->identity_type[0];

                            $user->identity_number    = $request->identity_number[0];

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



                            foreach ($request->name as $key => $value) {

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

                            // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                            // $trip->available_of_person  = $update_available_of_person;

                            // $trip->save();



                            // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                            // $encrypted = Crypt::encryptString($qr_code);

                            // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                            // $qr_url = "https://tamoheen.com/public";

                            // $image = $path;

                            // $name = $request->name[0];

                            // $email = $request->email[0];


                            // $user = User::where('id', $trip->user_id)->first();
                            // $partner_mobile = $user['mobile'];
                            // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                            // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                            // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                            // $pdf = PDF::loadView('emails.bordingpass', $data);

                            // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                            // session()->put('data', $data);



                            // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                            //     $message->to($email)->subject('Customer Boarding Pass')

                            //         ->attachData($pdf->output(), $name . '.pdf');
                            // });







                            // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                        }

                        Session::forget('to_city');

                        Session::forget('from_city');

                        Session::forget('number_of_person');



                         return redirect('telr-trip-payment/' . $trip_booking->id);

                        //return redirect('paytab-payment-success/' . $trip_booking->id);

                        // return redirect('payment/'.$trip_booking->id.'/'.$user->id);

                    } else {

                        return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                    }
                }
            } else {

                $charge = ServiceCharge::where('type', 0)->first();

                $percent_price = ($charge->charge / 100) * $price;

                $partner_price = $price - $percent_price;



                if ($trip->available_of_person >= $number_of_passenger) {



                    $user = User::where('email', $request->email[0])->first();



                    if ($user) {

                        $trip_booking                       = new TripBooking;

                        $trip_booking->user_id              = $user->id;

                        $trip_booking->trip_id              = $request->trip_id;

                        $trip_booking->number_of_passengers = $number_of_passenger;

                        $trip_booking->price                = $price;

                        $trip_booking->partner_price        = $partner_price;

                        $trip_booking->is_payment_complete  = 0;

                        $trip_booking->status               = 1;

                        $trip_booking->save();



                        foreach ($request->name as $key => $value) {

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

                        // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                        // $trip->available_of_person  = $update_available_of_person;

                        // $trip->save();



                        // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                        // $encrypted = Crypt::encryptString($qr_code);

                        // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                        // $qr_url = "https://tamoheen.com/public";

                        // $image = $path;

                        // $name = $request->name[0];

                        // $email = $request->email[0];


                        // $user = User::where('id', $trip->user_id)->first();
                        // $partner_mobile = $user['mobile'];
                        // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                        // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                        // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                        // $pdf = PDF::loadView('emails.bordingpass', $data);

                        // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                        // session()->put('data', $data);



                        // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                        //     $message->to($email)->subject('Customer Boarding Pass')

                        //         ->attachData($pdf->output(), $name . '.pdf');
                        // });







                        // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                    } else {

                        $password = Str::random(8);

                        $user           = new User();

                        $user->name     = $request->name[0];

                        $user->email    = $request->email[0];

                        $user->password = Hash::make($password);

                        $user->status   = 1;

                        $user->language = "en";

                        $user->mobile   = $request->mobile[0];

                        $user->title    = $request->title[0];

                        $user->identity_type    = $request->identity_type[0];

                        $user->identity_number    = $request->identity_number[0];

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



                        foreach ($request->name as $key => $value) {

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

                        // $update_available_of_person = $trip->available_of_person - $number_of_passenger;

                        // $trip->available_of_person  = $update_available_of_person;

                        // $trip->save();



                        // $qr_code = 'Booking No:' . $trip_booking->id . ',Person:' . $trip_booking->number_of_passengers . ',Price:' . $trip_booking->price . ',Trip id:' . $trip_booking->trip_id;

                        // $encrypted = Crypt::encryptString($qr_code);

                        // $path = DNS2D::getBarcodePNGPath($encrypted, "QRCODE");

                        // $qr_url = "https://tamoheen.com/public";

                        // $image = $path;

                        // $name = $request->name[0];

                        // $email = $request->email[0];


                        // $user = User::where('id', $trip->user_id)->first();
                        // $partner_mobile = $user['mobile'];
                        // $partner_metas = PartnerMeta::where('user_id', $trip->user_id)->first();
                        // Mail::to($email)->send(new BookingUserTrip($image, $name, $email));



                        // $data = ['name' => $name, "email" => $email, 'image' => $image, 'qr_url' => $qr_url, 'trips' => $trip_booking, 'request' => $trip, 'cars' => $cars, 'mobile' => $partner_mobile, 'trip_id' => $request->trip_id, 'brand_name' => $partner_metas['brand_name']]; // Your email view data

                        // $pdf = PDF::loadView('emails.bordingpass', $data);

                        // $pdf->save($name . '.pdf'); // Save the PDF to a temporary file

                        // session()->put('data', $data);



                        // Mail::send('emails.bordingpass', $data, function ($message) use ($email, $pdf, $name, $image) {

                        //     $message->to($email)->subject('Customer Boarding Pass')

                        //         ->attachData($pdf->output(), $name . '.pdf');
                        // });





                        // Mail::to($email)->send(new CustomerBoardingPass($image, $name, $email));

                    }



                    Session::forget('to_city');

                    Session::forget('from_city');

                    Session::forget('number_of_person');


                    //return redirect('paytab-payment-success/' . $trip_booking->id);
                    // return redirect('payment/' . $trip_booking->id . '/' . $user->id);

                    return redirect('telr-trip-payment/' . $trip_booking->id);
                } else {

                    return redirect('single-trip/' . $trip->id)->with('warning', 'Seat Not Available.');
                }
            }
        }
    }



    public function paymentView($trip_booking_id, $user_id)

    {

        $tripbooking = TripBooking::findOrFail($trip_booking_id);

        $user        = User::findOrFail($user_id);

        $user_amount = PartnerAmount::where('partner_id', $user_id)->first();

        $result      = null;

        return view('frontend.payment', compact('tripbooking', 'user', 'result', 'user_amount'));
    }



    public function paymentShipView($ship_booking_id, $user_id)

    {

        $tripbooking = ShipmentBooking::findOrFail($ship_booking_id);

        $user = User::findOrFail($user_id);

        $result = null;

        return view('frontend.shipbooking-payment', compact('tripbooking', 'user', 'result'));
    }



    public function paytabPaymentSubmit(Request $request)

    {

        if ($request->trx_id != null) {

            $tripbooking = TripBooking::findOrFail($request->booking_id);

            $tripbooking->payment_method = 'Paytab';

            $tripbooking->trx_id = $request->trx_id;

            $tripbooking->is_payment_complete = 1;

            $tripbooking->save();



            return redirect('paytab-payment-success/' . $tripbooking->id)->with('success', 'Payment Completed.');
        } else {

            return redirect()->back()->with('error', 'Please Pay First then press confirm');
        }
    }



    public function paymentStcSubmit(Request $request)

    {

        if ($request->stc_mobile == null) {

            return redirect()->back()->with('error', 'Please Insert Stc Mobile No');
        } else {



            $stc_mobile = $request->stc_mobile;

            $result = substr($stc_mobile, 0, 3);

            if ($result == "966") {

                $mobile = $stc_mobile;
            } else {

                $mobile = "966" . $stc_mobile;
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

                    "MobileNo" => $mobile,

                    "Amount" => $trip_booking->price,

                    "MerchantNote" => "TripBooking ID: $id"

                ]

            ];



            $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];



            $json_content = json_encode($content);



            $client = new \GuzzleHttp\Client();

            $method = "POST";

            try {

                $response = $client->request(
                    $method,
                    $url,
                    [

                        'json' => $content,

                        'headers' => $headers,

                        'cert' => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),

                        'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')

                    ]

                );

                $body = $response->getBody();

                $final_response = json_decode($body->read(1024));



                return view('frontend.trip-stc-payment-step-2', compact('final_response', 'trip_booking'));
            } catch (\Exception $exception) {

                return back()->withError('Customer Not Found.Please register in stc then try.');
            }
        }
    }



    public function getNextTripOrderNumber()

    {

        $lastOrder = TripBooking::orderBy('created_at', 'desc')->first();



        if (!$lastOrder) {



            $number = 0;
        } else {

            $number = substr($lastOrder->order_id, 3);
        }



        return sprintf('%04d', intval($number) + 1);
    }



    public function addCart($id)

    {

        if (!Auth::check()) {

            return redirect('/login');
        } else {

            $user_id        = Auth::id();

            $count = Cart::where('user_id', $user_id)->where('is_cart', '1')->where('product_id', $id)->count();

            $current_product = Product::where('id', $id)->first();

            $product_price = $current_product->price;



            if ($count > 0) {

                $id = Cart::where('user_id', $user_id)->where('is_cart', '1')->where('product_id', $id)->first()->id;

                $old_quantity = Cart::where('id', $id)->first()->quantity;

                $quantity = 1 + $old_quantity;

                $Cart = Cart::find($id);

                $Cart->quantity                  = $quantity;

                $Cart->save();
            } else {



                $Cart = new Cart;

                $Cart->user_id                      = $user_id;

                $Cart->product_id                   = $id;

                $Cart->quantity                     = 1;

                $Cart->price                        = $product_price;

                $Cart->is_cart                      = 1;

                $Cart->save();
            }



            return redirect('/cart-list');
        }
    }



    public function cartList()

    {

        if (!Auth::check()) {

            return redirect('/login');
        } else {

            $user_id = Auth::id();

            $data = [];

            $carts = Cart::where('user_id', $user_id)->where('is_cart', '1')->latest()->get();

            foreach ($carts as $cart) {

                $product = Product::where('id', $cart->product_id)->first();



                $single_data = [];

                $single_data['cart_id']                 = $cart->id;

                $single_data['user_id']                 = $cart->user_id;

                $single_data['product_id']              = $cart->product_id;

                $single_data['name']                    = $product->name;

                $single_data['name_arabic']             = $product->name_arabic;

                $single_data['name_urdu']               = $product->name_urdu;

                $single_data['image']                   = $product->image->url;

                $single_data['total_price']             = $cart->quantity * $cart->price;

                $single_data['quantity']                = $cart->quantity;

                $single_data['price']                   = $cart->price;

                array_push($data, $single_data);
            }

            // dd($data);

            return view('frontend.cart', compact('data'));
        }
    }



    public function deleteCartByAjax(Request $request)

    {

        Cart::where('user_id', Auth::id())->where('id', $request->cart_id)->delete();
    }



    public function updateQunatityCartByAjax(Request $request)

    {

        $id = $request->input('cart_id');



        $quantity = $request->input('new_quantity'); //+$old_quantity;



        $Cart               = Cart::find($id);

        $Cart->quantity     = $quantity;

        $Cart->save();

        $data = [];

        if ($Cart) {

            $data['msg'] = 'Success';

            $data['status'] = 1;
        } else {

            $data['msg'] = 'Failed';

            $data['status'] = 0;
        }

        return response()->json($data);
    }



    public function addressView()

    {

        $address = [];

        $addresses = Address::where('user_id', Auth::id())->latest()->get();

        foreach ($addresses as $addres) {



            $single_data = [];



            $single_data["id"]         = $addres->id;

            $single_data["user_id"]    = $addres->user_id;

            $single_data["flat_no"]    = $addres->flat_no;

            $single_data["location"]   = $addres->location;

            $single_data["pin_code"]   = $addres->pin_code;

            $single_data["phone_no"]   = $addres->phone_no;

            $single_data["created_at"] = $addres->created_at;

            $single_data["updated_at"] = $addres->updated_at;

            $single_data["state_id"]   = $addres->state_id;

            $single_data["state"]      = State::where('id', $addres->state_id)->first();

            $single_data["city_id"]    = $addres->city_id;

            $single_data["city"]       = City::where('id', $addres->city_id)->first();

            $single_data["country_id"] = $addres->country_id;

            $single_data["country"]    = Country::where('id', $addres->country_id)->first();



            array_push($address, $single_data);
        }

        return view('frontend.address', compact('address'));
    }



    public function addAddressView()

    {

        $countries = Country::latest()->get();

        return view('frontend.add-address', compact('countries'));
    }



    public function ajaxStateList(Request $request)

    {

        $states = State::where('country_id', $request->country_id)->get();

        return response()->json($states);
    }



    public function ajaxCityList(Request $request)

    {

        $cities = City::where('state_id', $request->state_id)->get();

        return response()->json($cities);
    }



    public function addressSubmit(Request $request)

    {

        $address             = new Address;

        $address->user_id    = Auth::id();

        $address->flat_no    = $request->flat_no;

        $address->location   = $request->location;

        $address->country_id = $request->country_id;

        $address->state_id   = $request->state_id;

        $address->city_id    = $request->city_id;

        $address->pin_no     = $request->pin_code;

        $address->phone_no   = $request->phone_no;

        $address->save();



        return redirect('/address');
    }



    public function productSummary($address_id)

    {

        Session::put('current_user_address', $address_id);

        if (!Auth::check()) {

            return redirect('/login');
        } else {

            $single_address = Address::with('cities', 'states', 'countries')->where('id', $address_id)->first();

            $current_user = Auth::user();

            $current_user->image;



            $user_id = Auth::id();

            $carts = [];

            $user_carts = Cart::where('user_id', $user_id)->where('is_cart', '1')->latest()->get();

            foreach ($user_carts as $cart) {

                $product = Product::where('id', $cart->product_id)->first();



                $single_data = [];

                $single_data['cart_id']                 = $cart->id;

                $single_data['user_id']                 = $cart->user_id;

                $single_data['product_id']              = $cart->product_id;

                $single_data['name']                    = $product->name;

                $single_data['name_arabic']             = $product->name_arabic;

                $single_data['name_urdu']               = $product->name_urdu;

                $single_data['image']                   = $product->image->url;

                $single_data['total_price']             = $cart->quantity * $cart->price;

                $single_data['quantity']                = $cart->quantity;

                $single_data['price']                   = $cart->price;

                array_push($carts, $single_data);
            }



            return view('frontend.product-summary', compact('single_address', 'current_user', 'carts'));
        }
    }



    public function productPayment($address_id, $user_id)

    {

        $total_price = 0;

        $time_stamp = time() + (3 * 24 * 60 * 60);

        $estimated_time = date("l", $time_stamp) . ' ' . date('M d,Y', $time_stamp);

        $cart_ids = [];



        $address = Address::where('id', $address_id)->first();



        $cart = Cart::where('user_id', Auth::id())->where('is_cart', '1')->latest()->get();

        foreach ($cart as $single_cart) {

            $total_price = $total_price + ($single_cart->quantity * $single_cart->price);

            array_push($cart_ids, $single_cart->id);
        }



        $orderCheck = Order::where('user_id', $user_id)->where('city_id', $address->city_id)->where('order_status', 0)->first();

        if ($orderCheck) {

            $order = Order::where('user_id', $user_id)->where('city_id', $address->city_id)->where('order_status', 0)->first();

            $result = null;
        } else {

            $order                 = new Order;

            $order->user_id        = Auth::id();

            $order->city_id        = $address->city_id;

            $order->total_price    = $total_price;

            $order->final_price    = $total_price;

            $order->order_status   = 0;

            $order->estimated_time = $estimated_time;

            $order->save();

            if ($order) {

                foreach ($cart_ids as $cart_id) {

                    $order->cartOrders()->attach($cart_id, []);
                }

                Cart::where('user_id', Auth::id())->where('is_cart', '1')->update(['is_cart' => '0']);

                $result = null;
            }
        }

        return view('frontend.product-payment', compact('order', 'address_id', 'user_id', 'result'));
    }



    public function productPaytabPaymentSubmit(Request $request)

    {

        if ($request->trx_id != null) {

            $order = Order::findOrFail($request->order_id);

            $order->payment_method = 'Paytab';

            $order->trx_id = $request->trx_id;

            $order->order_status = 1;

            $order->save();

            return redirect('product-payment-success/' . $order->id);
        } else {

            return redirect()->back()->with('error', 'Please Pay First then press confirm');
        }
    }



    public function productStcPaymentSubmit(Request $request)

    {

        if ($request->stc_mobile == null) {

            return redirect()->back()->with('error', 'Please Insert Stc Mobile No');
        } else {



            $stc_mobile = $request->stc_mobile;

            $result = substr($stc_mobile, 0, 3);

            if ($result == "966") {

                $mobile = $stc_mobile;
            } else {

                $mobile = "966" . $stc_mobile;
            }



            $id = Crypt::decrypt($request->ref_id);

            $order = Order::findOrFail($id);

            $address_id = $order->address_id;

            $user_id = $order->user_id;



            $four_digit_serial_number = $this->getNextOrderNumber();

            $url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentAuthorize";



            $content = [

                "DirectPaymentAuthorizeRequestMessage" => [

                    "BranchID" => "1",

                    "TellerID" => "22",

                    "DeviceID" => "500",

                    "RefNum" => $id,

                    "BillNumber" => $four_digit_serial_number,

                    "MobileNo" => $mobile,

                    "Amount" => $order->final_price,

                    "MerchantNote" => "Order ID: $id"

                ]

            ];



            $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];



            $json_content = json_encode($content);



            $client = new \GuzzleHttp\Client();

            $method = "POST";

            try {

                $response = $client->request(
                    $method,
                    $url,
                    [

                        'json' => $content,

                        'headers' => $headers,

                        'cert' => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),

                        'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')

                    ]

                );

                $body = $response->getBody();

                $final_response = json_decode($body->read(1024));

                return view('frontend.product-stc-payment-step-2', compact('final_response', 'order', 'address_id', 'user_id'));
            } catch (\Exception $exception) {

                return back()->withError('Customer Not Found.Please register in stc then try.');
            }
        }
    }



    public function getNextOrderNumber()

    {

        $lastOrder = Order::orderBy('created_at', 'desc')->first();



        if (!$lastOrder) {



            $number = 0;
        } else {

            $number = substr($lastOrder->order_id, 3);
        }



        return sprintf('%04d', intval($number) + 1);
    }



    public function singleProduct($id)

    {

        $product = Product::where('id', $id)->with('image', 'categories')->first();

        return view('frontend.single-product', compact('product'));
    }



    public function login()

    {

        return view('frontend.login');
    }



    public function signup()

    {

        $page = Page::where('slug', 'terms-conditions')->first();

        return view('frontend.signup', compact('page'));
    }



    public function riyadh()

    {

        return view('frontend.riyadh');
    }



    public function jeddah()

    {

        return view('frontend.jeddah');
    }



    public function makkah()

    {

        return view('frontend.makkah');
    }



    public function medina()

    {

        return view('frontend.medina');
    }



    public function dammam()

    {

        return view('frontend.dammam');
    }



    public function tabuk()

    {

        return view('frontend.tabuk');
    }



    public function shop()

    {

        $categories = Category::latest()->get();

        $products = Product::with('image')->latest()->get();

        return view('frontend.shop', compact('products', 'categories'));
    }



    public function userChangePasswordView()

    {
        return view('frontend.change-password');
    }

    public function userPaymentMethodView()
    {
        $id = Auth::id();
        $payment_method = PartnerPaymentMethod::where("user_id", $id)->get();
        //return view('frontend.payment-method', ['payment_method' => $payment_method]);
        return view('frontend.payment-method', compact('payment_method'));
    }


    public function userAddPaymentMethod(Request $request)
    {
        $this->validate($request, [
            'payment_method_name' => 'required|string',
            'payment_method_details' => 'required|string|max:255',
        ]);

        $userpaymentmethod = new PartnerPaymentMethod();
        $userpaymentmethod->user_id = Auth::id();
        $userpaymentmethod->name = $request->payment_method_name;
        $userpaymentmethod->details = $request->payment_method_details;
        $userpaymentmethod->save();

        return redirect('user-payment-method')->with('success', trans('partner-payment-method-ts.added'));
    }

    public function updatePassword(Request $request)

    {

        $this->validate($request, [

            'old_password'      => ['required', 'string', 'min:8'],

            'new_password'      => ['required', 'string', 'min:8'],

            'confirm_password'  => ['required', 'string', 'min:8'],

        ]);



        $old_password       = $request->old_password;

        $new_password       = $request->new_password;

        $confirm_password   = $request->confirm_password;





        if ($new_password == $confirm_password) {

            $current_password = Auth::user()->password;

            if (Hash::check($old_password, $current_password)) {

                $id             = Auth::user()->id;

                $user           = User::findOrFail($id);

                $user->password = Hash::make($new_password);

                $user->save();

                return redirect('/user-change-password')->with('success', 'Passowrd Updated!');
            }
        } else {

            return redirect('/user-change-password')->with('error', 'New Password and Confirm password not matching!');
        }
    }



    public function bookingList()
    { 
        // DB::table('trip_bookings')->where('user_id', Auth::id())->update(array('status' => '0'));
        // $tripbookings = TripBooking::where('user_id', Auth::id())->with(['reviews', 'trip' => function ($q) {
        //     $q->with('complains', 'cityFrom', 'cityTo');
        // }])->get();
        $tripbookings = TripBooking::where('user_id', Auth::id())->with(['reviews', 'trip' => function ($q) {
                $q->with('complains', 'cityFrom', 'cityTo');}, 'passengers']) 
            ->get();
        return view('frontend.booking-list', compact('tripbookings'));
    }



    public function bookingShipList()

    {

        $tripbookings = ShipmentBooking::where('user_id', Auth::id())->with(['reviews', 'trip' => function ($q) {

            $q->with('complains');
        }])->get();

        return view('frontend.ship-booking-list', compact('tripbookings'));
    }



    public function review($id)
    {

        $review = Review::where('trip_booking_id', $id)->where('from_id', Auth::id())->first();

        $tripbooking = TripBooking::with('trip')->findOrFail($id);

        return view('frontend.review', compact('tripbooking', 'review'));
    }



    public function reviewShip($id)

    {

        $review = ShipReview::where('ship_booking_id', $id)->where('from_id', Auth::id())->first();

        if ($review != null) {

            return redirect()->with('error', 'Already Review Given that trip');
        } else {

            $tripbooking = ShipmentBooking::with('trip')->findOrFail($id);



            return view('frontend.ship-review', compact('tripbooking'));
        }
    }



    public function reviewSubmit(Request $request)

    {

       

        $request->validate([

            'rating' => 'required',

            'review' => 'required'

        ]);



        $data = TripBooking::with(['trip' => function ($trip) {

            $trip->with(['user', 'cityFrom', 'cityTo', 'cars']);
        }, 'reviews'])->findOrFail($request->trip_booking_id);



        if ($data->check_in != null && $data->check_out != null) {

            $review                  = new Review();

            $review->trip_booking_id = $request->trip_booking_id;

            $review->trip_id         = $data->trip->id;

            $review->from_id         = Auth::id();

            $review->to_id           = $request->to_id;

            $review->rating          = $request->rating;

            $review->review          = $request->review;
            $review->save();

            $data = TripBooking::with(['trip' => function($trip){
                $trip->with(['user', 'cityFrom', 'cityTo', 'cars']);
            }, 'reviews'])->findOrFail($request->trip_booking_id);

            
    
            $distanceSetData = [
                "lat1" => $data->trip->cityFrom->lat,
                "lng1" => $data->trip->cityFrom->lng,
                "lat2" => $data->trip->cityTo->lat,
                "lng2" => $data->trip->cityTo->lng,
            ];
    
            $distance = $this->getDistanceMeters($distanceSetData);

            if($this->saveTrip($data, $distance)['return'] == "true"){
                return redirect()->back()->with('success', trans('trip-ts.review_submit'));
            }else{
                if($this->saveTrip($data, $distance)['status'] != 'false'){
                    if (strpos($this->saveTrip($data, $distance)['message']->resultCode, 'Driver not found') !== false) {
                        if($request->language == "ar"){
                            app()->setLocale('ar');
                            return redirect()->back()->with('danger', trans('driver.driver_not_found'));
                        }else{
                            app()->setLocale('en');
                            return redirect()->back()->with('danger', trans('driver.driver_not_found'));
                        }
                    } else {
                        if($request->language == "ar"){
                            app()->setLocale('ar');
                            return redirect()->back()->with('danger', trans('driver.driver_not_allowed'));
                        }else{
                            app()->setLocale('en');
                            return redirect()->back()->with('danger', trans('driver.driver_not_allowed'));
                        }
                    } 
                }else{
                    return redirect()->back()->with('danger', trans($this->saveTrip($data, $distance)['message']));
                }             
            }
        } else {

            return redirect('user-trip-booking-list')->with('error', 'Check in and check out not complete!!');
        }
    }



    public function reviewShipSubmit(Request $request)

    {

        $request->validate([

            'rating' => 'required',

            'review' => 'required'

        ]);



        $review                  = new ShipReview;

        $review->ship_booking_id = $request->ship_booking_id;

        $review->from_id         = Auth::id();

        $review->to_id           = $request->to_id;

        $review->rating          = $request->rating;

        $review->review          = $request->review;

        $review->save();

        return redirect('user-ship-booking-list')->with('success', trans('trip-ts.review_submit'));
    }



    public function complain($id, $type)

    {

        if ($type == 'trip') {

            $tripbooking = TripBooking::with('trip')->findOrFail($id);

            $complain = Complain::where('trip_id', $tripbooking->trip->id)->where('complain_from_id', Auth::id())->first();


            $tripbooking = TripBooking::with('trip')->findOrFail($id);

            return view('frontend.complain', compact('tripbooking', 'type', 'complain'));
        } else {

            $tripbooking = ShipmentBooking::with('trip')->findOrFail($id);

            $complain = Complain::where('trip_id', $tripbooking->trip->id)->where('complain_from_id', Auth::id())->first();

            if ($complain != null) {

                return redirect()->back()->with('error', 'Already Complain Given that trip');
            } else {

                $tripbooking = ShipmentBooking::with('trip')->findOrFail($id);

                return view('frontend.complain', compact('tripbooking', 'type'));
            }
        }
    }



    public function complainSubmit(Request $request)

    {

        $request->validate([

            'title' => 'required',

            'description' => 'required',

            'trip_id' => 'required'

        ]);



        $complain                   = new Complain;

        $complain->trip_id          = $request->trip_id;

        $complain->complain_from_id = Auth::id();

        $complain->complain_to_id   = $request->to_id;

        $complain->title            = $request->title;

        $complain->description      = $request->description;

        $complain->save();



        if ($request->type == 'trip') {

            return redirect('user-trip-booking-list')->with('success', trans('trip-ts.complain_submit'));
        } else {

            return redirect('user-ship-booking-list')->with('success', trans('trip-ts.complain_submit'));
        }
    }



    public function orderList()

    {

        $orders = Order::where('user_id', Auth::id())->with('user')->get();

        return view('frontend.order-list', compact('orders'));
    }



    public function shipPaytabPaymentSubmit(Request $request)

    {

        if ($request->trx_id != null) {

            $shipmentbook = ShipmentBooking::findOrFail($request->ship_booking_id);

            $shipmentbook->trx_id = $request->trx_id;

            $shipmentbook->payment_method = "paytab";

            $shipmentbook->is_payment_complete = 1;

            $shipmentbook->save();



            return redirect('shipment-payment-success/' . $shipmentbook->id);
        } else {

            return redirect()->back()->with('error', 'Please Pay First then press confirm');
        }
    }



    public function shipmentPaymentSuccess($id)

    {

        $shipmentbook = ShipmentBooking::with('user', 'trip')->findOrFail($id);

        return view('frontend.shipment-payment-success', compact('shipmentbook'));
    }



    public function stcShipPaymentSubmit(Request $request)

    {

        if ($request->stc_mobile == null) {

            return redirect()->back()->with('error', 'Please Insert Stc Mobile No');
        } else {



            $stc_mobile = $request->stc_mobile;

            $result = substr($stc_mobile, 0, 3);

            if ($result == "966") {

                $mobile = $stc_mobile;
            } else {

                $mobile = "966" . $stc_mobile;
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

                    "MobileNo" => $mobile,

                    "Amount" => $trip_booking->price,

                    "MerchantNote" => "ShipmentBooking ID: $id"

                ]

            ];



            $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];



            $json_content = json_encode($content);



            $client = new \GuzzleHttp\Client();

            $method = "POST";

            try {

                $response = $client->request(
                    $method,
                    $url,
                    [

                        'json' => $content,

                        'headers' => $headers,

                        'cert' => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),

                        'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')

                    ]

                );

                $body = $response->getBody();

                $final_response = json_decode($body->read(1024));



                return view('frontend.ship-stc-payment-step-2', compact('final_response', 'trip_booking'));
            } catch (\Exception $exception) {

                return back()->withError('Customer Not Found.Please register in stc then try.');
            }
        }
    }



    public function getNextShipOrderNumber()

    {

        $lastOrder = ShipmentBooking::orderBy('created_at', 'desc')->first();



        if (!$lastOrder) {



            $number = 0;
        } else {

            $number = substr($lastOrder->order_id, 3);
        }



        return sprintf('%04d', intval($number) + 1);
    }



    public function deleteAddress($id)

    {

        if (!Auth::check()) {

            return redirect('/login');
        } else {

            $address = Address::findOrFail($id);

            $address->delete();

            return redirect('/address')->with('success', trans('trip-ts.address_delete'));
        }
    }



    public function tripBookingCancel($id)
    {
    
        $tripbooking  = TripBooking::findOrFail($id);
        $current_trip  = Trip::findOrFail($tripbooking->trip_id);

    
        if (!Auth::check()) {
            return redirect('/login');
        } else {

            $tripbooking  = TripBooking::findOrFail($id);

            $current_trip  = Trip::findOrFail($tripbooking->trip_id);

            if ($current_trip->status == 3) {

                return redirect('user-trip-booking-list')->with('error',  trans('Your Trip are not cancelled'));
            }

            $tripbooking->status = 0;

            $tripbooking->cancel_date = Carbon::now()->toDateTimeString();

            $tripbooking->save();
    
            $meta = PartnerMeta::where("user_id",$current_trip->user_id)->first();
       

            $data = ['cancellationDate' => Carbon::now()->toDateTimeString(),
            'tripStartDate' => $current_trip->date,
            'canceledBy' => 'Customer',
            'pick_up' => $current_trip->start_point,
            'drop'=> $current_trip->end_point,
            'brand_name'=> $meta->brand_name,
            'driver_name'=> $current_trip->title
            ];
   
            foreach ($this->get_emails($current_trip) as $key => $email) {
                if ($key === 'admin') {
                    Mail::to($email)->cc($email)->send(new tripCancel($data));
                } else {
                    Mail::to($email)->send(new tripCancel($data));
                }
            }

            $user_amount = PartnerAmount::where('partner_id', Auth::id())->first();



            if ($tripbooking->is_payment_complete == '1') {

                $update_available_of_person = $current_trip->available_of_person+$tripbooking->number_of_passengers;
		        $current_trip->available_of_person  = $update_available_of_person;
		        $current_trip->save();

                if ($user_amount != null) {

                    $price = $user_amount->total_amount + $tripbooking->price;

                    $user_amount->total_amount = $price;

                    $user_amount->save();
                } else {

                    $user_amount = new PartnerAmount();

                    $user_amount->partner_id = Auth::id();

                    $user_amount->total_amount = $tripbooking->price;

                    $user_amount->save();
                }
            }

            return redirect('user-trip-booking-list')->with('success',  trans('trip-ts.cancel_alert'));
        }
    }

    public function get_emails($id)
    {
        $current_driver = car::select("user_id")->where("id", $id->car_id)->first();
        $current_driver_email = User::select("email")->where("id", $current_driver->user_id)->first();
        $admin_email = User::select("email")->where("name", "Admin")->first();
        $email_array = array();
        $email_array['driver'] = $current_driver_email->email;
        // $email_array['current_user'] = auth()->user()->email;
        // $email_array['admin'] = $admin_email->email;
        $email_array['admin'] = "info@tamoheen.com";
        return $email_array;
    }



    public function shipBookingCancel($id)

    {

        if (!Auth::check()) {

            return redirect('/login');
        } else {

            $tripbooking = ShipmentBooking::findOrFail($id);

            $tripbooking->status = 0;

            $tripbooking->save();



            $user_amount = PartnerAmount::where('partner_id', Auth::id())->first();



            if ($user_amount != null) {

                $price = $user_amount->total_amount + $tripbooking->price;

                $user_amount->total_amount = $price;

                $user_amount->save();
            } else {

                $user_amount = new PartnerAmount();

                $user_amount->partner_id = Auth::id();

                $user_amount->total_amount = $tripbooking->price;

                $user_amount->save();
            }



            return redirect()->back()->with('success',  trans('trip-ts.cancel_alert'));
        }
    }



    public function ajaxGetFeature(Request $request)

    {

        $feature = Feature::where('id', $request->feature_id)->first();

        return response()->json([

            'feature' => $feature,

            'msg' => 'success'

        ]);
    }



    public function getAgoDays($specDay, $days, $format = 'Y-m-d')
    {

        $d = date('d', strtotime($specDay));

        $m = date('m', strtotime($specDay));

        $y = date('Y', strtotime($specDay));

        $dateArray = array();

        for ($i = 1; $i <= $days; $i++) {

            $dateArray[] = date($format, mktime(0, 0, 0, $m, ($d - $i), $y));
        }

        return array_reverse($dateArray);
    }



    public function getBeforeDays($specDay, $days, $format = 'Y-m-d')
    {

        $d = date('d', strtotime($specDay));

        $m = date('m', strtotime($specDay));

        $y = date('Y', strtotime($specDay));

        $dateArray = array();

        for ($i = 1; $i <= $days; $i++) {

            $dateArray[] = date($format, mktime(0, 0, 0, $m, ($d + $i), $y));
        }

        return $dateArray;
    }
}
