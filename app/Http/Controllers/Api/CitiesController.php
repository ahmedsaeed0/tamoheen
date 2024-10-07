<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Image;
use Storage;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with('images','states')->latest()->get();
        return response()->json([ 
            'cities' => $cities
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
            'name' => 'required'
        ]);
        
        $city              = new City;
        $city->name        = $request->name;
        $city->name_arabic = $request->name_arabic;
        $city->name_urdu   = $request->name_urdu;
        $city->state_id    = $request->state_id;
        $city->save();

        if($city){
            if($request->hasFile('image')){
                foreach($request->file('image') as $key => $value){
                    $cityImage = new Image;
                    $image = $request->file('image')[$key];
                    $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                    $path = $image->storeAs(
                        'cities', $name, 'public'
                    );
                    $cityImage->url = $path;
                    $cityImage->imageable_id = $city->id;
                    $cityImage->imageable_type = 'App\Models\City';
                    $city->images()->save($cityImage);
                }
                $city->images;
            }
            
        }

        return response()->json([
            'city'=>$city,
            'message' => 'Success'
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
        $city = City::with('images', 'states')->findOrFail($id);
        return response()->json([
            'city' => $city
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
        $city = City::with('images', 'states')->findOrFail($id);
        return response()->json([
            'city' => $city
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
        $city              = City::findOrFail($id);
        $city->name        = $request->name;
        $city->name_arabic = $request->name_arabic;
        $city->name_urdu   = $request->name_urdu;
        $city->state_id    = $request->state_id;
        $city->save();
        
        if($request->hasFile('image')){
            foreach ($city->images as $image) {
                $exists = Storage::disk('public')->exists($image->url);
                if($exists){
                    Storage::disk('public')->delete($image->url);
                }
            }
            $city->images()->delete();

            $images = $request->file('image');
            foreach($images as $key => $value){
                $cityImage = new Image;
                $image = $request->file('image')[$key];
                $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                $path = $image->storeAs(
                    'cities', $name, 'public'
                );
                $cityImage->url = $path;
                $cityImage->imageable_id = $city->id;
                $cityImage->imageable_type = 'App\Models\City';
                $city->images()->save($cityImage);
            }
            
        }
        return response()->json([
            'city'=>$city
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
        $city              = City::findOrFail($id);
        foreach ($city->images as $image) {
            $exists = Storage::disk('public')->exists($image->url);
            if($exists){
                Storage::disk('public')->delete($image->url);
            }
        }
        $city->images()->delete();
        City::destroy($id);
        return response()->json([
            'message' => 'City Deleted!'
        ]);
    }
}
