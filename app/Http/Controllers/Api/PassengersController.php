<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Passenger;
use App\Models\Trip;
use Auth;

class PassengersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($trip_id)
    {
        $passengers = Passenger::where('trip_id',$trip_id)->get();
        return response()->json([
            'passengers' => $passengers
        ]);
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
            'title'           => 'required',
            'name'            => 'required',
            'identity_type'   => 'required',
            'identity_number' => 'required',
            'mobile'          => 'required',
            'email'           => 'required',
        ]);

        $trip = Trip::where('id', $request->trip_id)->first();

        $count = count($request->name);
        if($trip->available_of_person >= $count){
            foreach($request->name as $key => $value){
                $passenger                  = new Passenger;
                $passenger->trip_id         = $request->trip_id;
                $passenger->title           = $request->title[$key];
                $passenger->name            = $value;
                $passenger->identity_type   = $request->identity_type[$key];
                $passenger->identity_number = $request->identity_number[$key];
                $passenger->mobile          = $request->mobile[$key];
                $passenger->email           = $request->email[$key];
                $passenger->save();
            }
            return response()->json([
                'message' => 'Passengers Created!',
                'status' => 1,
            ]); 
        }else{
            return response()->json([
                'message' => 'Not Available Sit now!',
                'status' => 0,
            ]); 
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
        //
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
        //
    }
}
