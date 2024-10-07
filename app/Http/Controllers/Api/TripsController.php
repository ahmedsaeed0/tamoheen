<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;

use App\Models\User;
use App\Models\Trip;
use App\Models\TripBooking;
use App\Models\Passenger;
use Auth;
use Carbon\Carbon;

class TripsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('admin')){
            $trips = Trip::with('user', 'cityFrom', 'cityTo', 'cars')->get();
        }else{
            $trips = Trip::with('user', 'cityFrom', 'cityTo', 'cars')->where('user_id', Auth::id())->get();
        }
        // return TripResource::collection($trips);
        return response()->json([
            'trips' => $trips
        ]);
    }
    public function allTrips()
    {
        $trips = Trip::get();
        return TripResource::collection($trips);
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
        $request->validate([
            'city_from_id'     => 'required',
            'city_to_id'       => 'required',
            'car_id'           => 'required',
            'title'            => 'required',
            'description'      => 'required',
            'price_per_person' => 'required',
            'pickup_location'  => 'required',
            'number_of_person' => 'required',
            'date'             => 'required',
            'type'             => 'required',
        ]);

        $trip                      = new Trip;
        $trip->user_id             = Auth::id();
        $trip->city_from_id        = $request->city_from_id;
        $trip->city_to_id          = $request->city_to_id;
        $trip->car_id              = $request->car_id;
        $trip->title               = $request->title;
        $trip->title_arabic        = $request->title_arabic;
        $trip->title_urdu          = $request->title_urdu;
        $trip->description         = $request->description;
        $trip->description_arabic  = $request->description_arabic;
        $trip->description_urdu    = $request->description_urdu;
        $trip->price_per_person    = $request->price_per_person;
        $trip->pickup_location     = $request->pickup_location;
        $trip->number_of_person    = $request->number_of_person;
        $trip->available_of_person = $request->number_of_person;
        $trip->date                = Carbon::parse($request->date)->format('Y-m-d H:i');
        $trip->type                = $request->type;
        $trip->status              = 1;
        $trip->save();
        
        $trip = new TripResource($trip);
        return response()->json([
            'trip'=> $trip,
            'message' => 'Trip created!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::with('user','cityFrom','cityTo')->findOrFail($id);
        $trip->cars->images;
        return response()->json([
            'trip' => $trip,
        ]);
    }

    public function tripCustomers($id)
    {
        $trip_customers = TripBooking::where('trip_id', $id)->with('user')->paginate(10);
        return response()->json($trip_customers);
    }

    public function tripCancel($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->status = 2;
        $trip->save();

        return response()->json([
            'message' => 'Trip Cancel'
        ]);
    }

    public function tripComplete($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->status = 3;
        $trip->save();

        return response()->json([
            'message' => 'Trip Complete'
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

    /**  
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Trip::destroy($id);
        Passenger::where('trip_id', $id)->delete();
        return response()->json([
            'message' => 'Trip deleted!'
        ]);
    }
}
