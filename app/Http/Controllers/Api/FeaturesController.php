<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feature;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    
    public function index()
    {
        $features = Feature::latest()->get();
        return response()->json([
            'features' => $features
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
        $feature              = new Feature();
        $feature->name        = $request->name;
        $feature->name_arabic = $request->name_arabic;
        $feature->name_urdu   = $request->name_urdu;
        $feature->icon        = $request->icon;
        $feature->save();

        return response()->json([
            'messge' => 'Feature created',
            'feature' => $feature
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
        $feature = Feature::findOrFail($id);
        return response()->json([
            'feature' => $feature
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
    public function update(Request $request)
    {
        $feature              = Feature::findOrFail($request->id);
        $feature->name        = $request->name;
        $feature->name_arabic = $request->name_arabic;
        $feature->name_urdu   = $request->name_urdu;
        $feature->icon        = $request->icon;
        $feature->save();

        return response()->json([
            'message' => 'Feature Updated',
            'code' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Feature::destroy($id);
        return response()->json([
            'message' => 'Feature deleted',
            'code' => 200
        ], 200);
    }
}
