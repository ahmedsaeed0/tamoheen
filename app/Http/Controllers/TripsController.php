<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Trip;
use App\Models\City;
use App\Models\Car;
use App\Models\TripBooking;
use App\Models\Passenger;
use App\Models\ProductType;
use App\Models\Feature;
use Auth;
use App\Models\PartnerMeta;
use Carbon\Carbon;
use App\Traits\AddressTrait;
use App\Traits\WaslTrait;
use App\Mail\tripCancelPartner;

use DB;
class TripsController extends Controller
{
    use AddressTrait, WaslTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('partner')){
            $trips = Trip::where('user_id', $user->id)->paginate(25);
        }elseif($user->hasRole('user'))
        {
            $trips = Trip::where('user_id', $user->id)->paginate(25);
        }else{
            $trips = Trip::latest()->paginate(25);
        }

        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();
        if(Auth::user()->hasrole('partner')){
    
            $cars = Car::where('user_id', Auth::id())->get();
            
        }else{

            $cars = Car::get();
            dd($cars);
        }
        $producttypes = ProductType::get();
        $features = Feature::where('is_main', 1)->get();
        return view('trips.create', compact('cities', 'cars', 'producttypes', 'features'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate(rules: [
            'city_from_id'  => 'required|exists:cities,id',
            'city_to_id'    => 'required|exists:cities,id|different:city_from_id',
            'car_id'        => 'required|exists:cars,id',
            // 'title'      => 'required',
            'description'   => 'required|max:191',
            'start_point'   => 'required',
            'end_point'     => 'required',
            'date'          => 'required|date',
            'drop_off_time' => 'required|date|after:date',
            'type'          => 'required',
            'number_of_person'          => 'required|numeric',
            'price_per_person'          => 'required|numeric',
            'feature_id'    => 'required|exists:features,id'
        ]);

        $trip = Trip::latest()->first();
        if($trip != null){
            $new_id = $trip->id+1;
            $title = Auth::user()->partnerMetas->brand_name.'-'.$new_id;
        }else{
            
            $title = Auth::user()->partnerMetas->brand_name.'-'.'1';
        }
       
        $trip                      = new Trip();
        $trip->user_id             = Auth::id();
        $trip->city_from_id        = $request->city_from_id;
        $trip->city_to_id          = $request->city_to_id;
        $trip->car_id              = $request->car_id;
        $trip->feature_id          = $request->feature_id;
        $trip->title               = $title;
        $trip->title_arabic        = $title;
        $trip->description         = $request->description;
        $trip->description_arabic  = $request->description_arabic;
        $trip->description_urdu    = $request->description_urdu;
        $trip->price_per_person    = $request->price_per_person;
        $trip->price_per_bag       = $request->price_per_bag;
        $trip->start_point         = $request->start_point;
        $trip->end_point           = $request->end_point;
        $trip->number_of_person    = $request->number_of_person;
        $trip->available_of_person = $request->number_of_person;
        $trip->number_of_bag       = $request->number_of_bag;
        $trip->available_of_bag    = $request->number_of_bag;
        $trip->date                = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $trip->drop_off_time       = Carbon::parse($request->drop_off_time)->format('Y-m-d H:i:s');
        $trip->type                = $request->type;
        $trip->status              = 1;
        $trip->save();
        if($trip && $request->type == 2){
            foreach($request->product_type_id as $key => $value){
                $trip->tripProductTypes()->attach($value, []);
            }
        }

        // return redirect('trips')->with('success', 'Trip added');
        return redirect('trips')->with('success', trans('trip-ts.added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::with('user', 'cars', 'cityFrom', 'cityTo', 'tripProductTypes')->findOrFail($id);
        // dd($trip);
        return view('trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = City::get();
        $cars = Car::get();
        $features = Feature::where('is_main', 1)->get();
        $trip = Trip::with('cars', 'cityFrom', 'cityTo')->findOrFail($id);
        $producttypes = ProductType::get();
        return view('trips.edit', compact('trip', 'cities', 'cars', 'producttypes', 'features'));
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
        $request->validate([
            'city_from_id'  => 'integer|exists:cities,id',
            'city_to_id'    => 'integer|exists:cities,id|different:city_from_id',
            'car_id'        => 'integer|exists:cars,id',
            'description'   => 'string|max:191',
            'start_point'   => 'string',
            'end_point'     => 'string',
            'date'          => 'datetime',
            'drop_off_time' => 'datetime',
            'type'          => 'integer',
            'feature_id'    => 'exists:features,id'
        ]);

        $trip                      = Trip::findOrFail($id);
        $trip->user_id             = Auth::id();
        $trip->city_from_id        = $request->city_from_id;
        $trip->city_to_id          = $request->city_to_id;
        $trip->car_id              = $request->car_id;
        $trip->feature_id          = $request->feature_id;
        $trip->description         = $request->description;
        $trip->description_arabic  = $request->description_arabic;
        $trip->price_per_person    = $request->price_per_person;
        $trip->start_point         = $request->start_point;
        $trip->end_point           = $request->end_point;
        $trip->number_of_person    = $request->number_of_person;
        $trip->available_of_person = $request->number_of_person;
        $trip->date                = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $trip->drop_off_time       = Carbon::parse($request->drop_off_time)->format('Y-m-d H:i:s');
        $trip->type                = $request->type;
        $trip->status              = 1;
        $trip->save();

        if($request->type == 2 && $request->product_type_id != null){
            $trip->tripProductTypes()->detach();
            foreach($request->product_type_id as $key => $value){
                $trip->tripProductTypes()->attach($value, []);
            }
        }


        return redirect('trips')->with('success',  trans('trip-ts.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Passenger::where('trip_id', $id)->delete();
        Trip::destroy($id);
        return redirect('trips')->with('success', trans('trip-ts.deleted'));
    }

    public function tripCancel($id)
    {
      
        $trip = Trip::findOrFail($id);
       
        $trip->status = 2;
        $trip->cancel_date = date('Y-m-d H:i:s');
        $trip->save();

        $meta = PartnerMeta::where("user_id",$trip->user_id)->first();
       
        $data = ['cancellationDate' => Carbon::now()->toDateTimeString(),
        'tripStartDate' => $trip->date,
        'canceledBy' => 'Driver',
        'pick_up' => $trip->start_point,
        'drop'=> $trip->end_point,
        'brand_name'=> $meta->brand_name,
        'driver_name'=> $trip->title
        ];


        if(!empty($this->get_emails($id))){

            if(isset($this->get_emails($id)['email'])){
                foreach ($this->get_emails($id)['email'] as $key => $email) {
                    Mail::to($email)->send(new tripCancelPartner($data));
                }
            }

            if(!empty($this->get_emails($id)['admin'])){
                Mail::to($this->get_emails($id)['admin'])->cc($this->get_emails($id)['admin'])->send(new tripCancelPartner($data));
            }

        }else{
            return redirect('trips')->with('error', trans('trip-ts.canceled'));
        }
        $update_tripBooking = ['cancelled_by'=>"DRIVER" , 'cancel_date'=>date('Y-m-d H:i:s') , 'status'=>0 ];
        TripBooking::where("trip_id",$id)->update($update_tripBooking);
        return redirect('trips')->with('success', trans('trip-ts.canceled'));
    }

    public function get_emails($id){
        $current_trip = TripBooking::where("trip_id",$id)->get();
        $emails = array();
        $admin = array();

        if(!empty($current_trip)){
            foreach($current_trip as $key => $data){
                $current_trip_email = User::select("email")->where("id",$data->user_id)->first();
                $emails['email'][$key]  = $current_trip_email->email;
            }
            
            $admin['admin'] = "info@tamoheen.com";
            $merge = array_merge($emails,$admin);
            return $merge;
        }else{
            return  array();
        }
       
        
    }

    public function tripComplete($id)
    {
        $trip = Trip::whereHas('tripBookings', function($q){
            $q->where('status', '=', 1);
        })->find($id);
   
        if($trip){
            return redirect('trips')->with('warning', trans('trip-ts.CanComplete'));
        }else{
            $trip = Trip::with(['tripBookings', 'user', 'cityFrom', 'cityTo', 'cars', 'reviews'])->findOrFail($id);
            
            $distanceSetData = [
                "lat1" => $trip->cityFrom->lat,
                "lng1" => $trip->cityFrom->lng,
                "lat2" => $trip->cityTo->lat,
                "lng2" => $trip->cityTo->lng,
            ];
           
            $distance = $this->getDistanceMeters($distanceSetData);
            $responseData = $this->saveTrip($trip, $distance);

    

            if(isset($responseData->resultCode) && $responseData->resultCode == 'success'){
                $trip->status = 3;
                $trip->save();
                return redirect('trips')->with('success', trans('trip-ts.Completed'));
            }else{
                if(isset($responseData['message'])){
                    return redirect('trips')->with('warning', $responseData['message']);
                }else{
                    return redirect('trips')->with('error', 'something wen,t wrong');
                }
            }
        }
    }

    public function tripCopy(Request $request)
    {
        $this->validate($request, [
            'pickup_date' => 'required|date',
            'drop_off_date' => 'required|date|after:pickup_date',
            'trip_id' => 'required'
        ]);

        $trip = Trip::find($request->trip_id);

        $trip = $trip->replicate();
        $trip->date = Carbon::parse($request->pickup_date)->format('Y-m-d h:i:s');
        $trip->drop_off_time = Carbon::parse($request->drop_off_date)->format('Y-m-d h:i:s');
        $trip->status = 1;
        $trip->cancel_date = null;
        $trip->save();

        return redirect('trips')->with('success', trans('trip-ts.Copied'));
    }

    public function tripDiscount(Request $request)
    {
        $this->validate($request, [
            'discount' => 'required',
            'trip_id' => 'required'
        ]);

        $trip = Trip::find($request->trip_id);
        $trip->discount = $request->discount;
        $trip->save();

        return redirect('trips')->with('success', trans('trip-ts.Discount'));
    }
}
