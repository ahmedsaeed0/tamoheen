<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Address;
use App\Models\City;
use App\Models\State;
use App\Models\Country;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $address = Auth::user()->with(['address' => function($query){
        //     $query->with('cities', 'states', 'countries')
        // }])->get();
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
            'city_id'    => 'required',
            'state_id'   => 'required',
            'country_id' => 'required',
            'flat_no'    => 'required',
            'pin_no'   => 'required',
            'phone_no'   => 'required',
        ]);
        $address = new Address;
        $address->user_id       = Auth::id();  
        $address->city_id       = $request->input('city_id');  
        $address->state_id      = $request->input('state_id');  
        $address->country_id    = $request->input('country_id');  
        $address->flat_no       = $request->input('flat_no');  
        $address->location      = $request->input('location');  
        $address->pin_no      = $request->input('pin_no');  
        $address->phone_no      = $request->input('phone_no');  
        $address->save();

        if($address){
            $address->users;
            $address->cities;
            $address->states;
            $address->countries;
        }  

        return response()->json([
            'message' => 'Address Created',
            'address' => $address
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
        $address = Address::where('id', $id)->where('user_id', Auth::id())->with('cities', 'states', 'countries')->first();
        return response()->json([
            'address' => $address
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
        Address::destroy($id);
        return response()->json([
            'message' => 'Address Deleted'
        ]);
    }
}
