<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\User;
use App\Models\Image;
use Auth;
use File;
use Storage;

class CarsController extends Controller
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
            $cars = Car::with('images', 'carFeatures')->get();
        }else{
            $cars = Car::where('user_id', Auth::id())->with('images', 'carFeatures')->get();
        }
        // return response()->json([
        //     'cars'=>$cars
        // ]);
         return response()->json($cars);
           
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
            'name'               => 'required',
            'capacity_of_person' => 'required',
            'capacity_of_bag'    => 'required',
        ]);

        $car                     = new Car;
        $car->user_id            = Auth::id();
        $car->name               = $request->name;
        $car->name_arabic        = $request->name_arabic;
        $car->name_urdu          = $request->name_urdu;
        $car->capacity_of_person = $request->capacity_of_person;
        $car->capacity_of_bag    = $request->capacity_of_bag;
        $car->is_food            = $request->is_food;
        $car->is_drinks          = $request->is_drinks;
        $car->is_wify            = $request->is_wify;
        $car->is_baby            = $request->is_baby;
        $car->is_smoking         = $request->is_smoking;
        $car->save();
        // $i = 0;
        if($car){

            foreach($request->feature as $key => $value){
                $car->carFeatures()->attach($value, []);
            }

            if($request->hasFile('image')){
                foreach($request->file('image') as $key => $value){
                    $image = $value;
                    $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                    $path = $image->storeAs(
                        'cars', $name, 'public'
                    );
                    $carImage = new Image;
                    $carImage->url = $path;
                    $carImage->imageable_id = $car->id;
                    $carImage->imageable_type = 'App\Models\Car';
                    $car->images()->save($carImage);
                }
            }
            
        }
        $car->images;
        $car->carFeatures;
        return response()->json([
            'car'=> $car,
            'message' => 'Car created!'
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
        $car = Car::with('images', 'carFeatures')->findOrFail($id);
        return response()->json([
            'car' => $car
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
        $car                     = Car::findOrFail($id);
        if($car->user_id == Auth::id()){
            $car->name               = $request->name;
            $car->name_arabic        = $request->name_arabic;
            $car->name_urdu          = $request->name_urdu;
            $car->capacity_of_person = $request->capacity_of_person;
            $car->capacity_of_bag    = $request->capacity_of_bag;
            $car->is_food            = $request->is_food;
            $car->is_drinks          = $request->is_drinks;
            $car->is_wify            = $request->is_wify;
            $car->is_baby            = $request->is_baby;
            $car->is_smoking         = $request->is_smoking;
            $car->save();

            if($request->feature != null){
                $car->carFeatures()->detach();
                foreach($request->feature as $key => $value){
                    $car->carFeatures()->attach($value, []);
                }
            }

            if($request->hasFile('image')){
                foreach ($car->images as $image) {
                    $exists = Storage::disk('public')->exists($image->url);
                    if($exists){
                        Storage::disk('public')->delete($image->url);
                    }
                }
                $car->images()->delete();

                $images = $request->file('image');
                $i=0;
                foreach($request->file('image') as $key => $value){
                    $image = $value;
                    $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                    $path = $image->storeAs(
                        'cars', $name, 'public'
                    );
                    $carImage = new Image;
                    $carImage->url = $path;
                    $carImage->imageable_id = $car->id;
                    $carImage->imageable_type = 'App\Models\Car';
                    $car->images()->save($carImage);
                }
            }
            $car->images;
            $car->carFeatures;
            
            return response()->json([
                'car'=>$car,
                'message' => 'Successfully Updated.'
            ]);
        }else{
            return response()->json([
                'car'=>$car,
                'message' => 'You are not valid here.'
            ]);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->carFeatures()->detach();
        foreach ($car->images as $image) {
            $exists = Storage::disk('public')->exists($image->url);
            if($exists){
                Storage::disk('public')->delete($image->url);
            }
        }
        $car->images()->delete();
        Car::destroy($id);
        return response()->json([
            'message' => 'Car deleted!'
        ]);
    }
}
