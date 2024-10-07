<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Country;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::get();
        return response()->json($countries);
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
            'name' => 'required',
            'code' => 'required',
        ]);

        $country              = new Country;
        $country->name        = $request->name;
        $country->name_arabic = $request->name_arabic;
        $country->name_urdu   = $request->name_urdu;
        $country->code        = $request->code;
        $country->code_arabic = $request->code_arabic;
        $country->code_urdu   = $request->code_urdu;
        $country->save();

        return response()->json([
            'message' => 'Country Created.',
            'country' => $country
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
        $country = Country::findOrFail($id);
        return response()->json([
            'country' => $country
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
        $country = Country::findOrFail($id);
        return response()->json([
            'country' => $country
        ]);
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

        $country              = Country::findOrFail($id);
        $country->name        = $request->name;
        $country->name_arabic = $request->name_arabic;
        $country->name_urdu   = $request->name_urdu;
        $country->code        = $request->code;
        $country->code_arabic = $request->code_arabic;
        $country->code_urdu   = $request->code_urdu;
        $country->save();

        return response()->json([
            'message' => 'Country Updated.',
            'country' => $country
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::destroy($id);
        return response()->json([
            'message' => 'Country Deleted.'
        ]);
    }
}
