<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feature;

use App\Models\Car;
use App\Models\User;
use App\Models\Image;
use App\Traits\WaslTrait;
use Auth;
use File;
use Storage;
use DB;


class CarsController extends Controller
{
    use WaslTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        if(Auth::user()->hasrole('partner')){
            //DB::enableQueryLog();
            $cars = Car::where('user_id', Auth::id())->latest()->paginate(25);
          //  dd(DB::getQueryLog());
        }else{
            $cars = Car::latest()->paginate(25);
        }

        return view('cars.index', compact('cars'));
        // return view('cars.index')->with('cars', $cars);

    }
    public function adminCar(){
        $cars = Car::latest()->paginate(25);
        return view('cars.admin_car', compact('cars'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $features = Feature::where('is_main', 0)->get();
        $userid=Auth::id();
        // $car=DB::table('cars')->get();
        $car = Car::with(['user', 'images', 'trips', 'carFeatures'])
        ->where('user_id', $userid)
        ->get();

        // dd($car);
        return view('cars.create', compact('features', 'car'));
    }


public function store(Request $request)
    {
        
        $request->validate([
            'name'                => 'required|string',
            'capacity_of_person'  => 'required|integer',
            'capacity_of_bag'     => 'required|integer',
            'sequence_number'     => 'required|string',
            'plate_letter_right'  => 'required|string',
            'plate_letter_middle' => 'required|string',
            'plate_letter_left'   => 'required|string',
            'plate_number'        => 'required|string',
            'plate_type'          => 'required|integer',
            'feature_id.*'        => 'required|exists:features,id|integer'
        ]);
       
       
        
        try{
            // dd(Auth::user()->identity_number);
             $responseData = $this->checkEligibility(Auth::user()->identity_number);
            // dd($responseData);
                if ($responseData['status'] == 200) {
                    if (isset($responseData['data']->driverEligibility) && ($responseData['data']->driverEligibility  == 'VALID')) {
                        if ($this->get_vehicles($responseData['data'], $request)) {
                            
                            $isSave = $this->addCar($request);
                           
                            if ($isSave['return'] == 'true') {
                                if($request->language == 'ar'){
                                    app()->setLocale('ar');
                                    return redirect('cars')->with('success', trans('driver.success'));
                                }else{
                                    app()->setLocale('en');
                                    return redirect('cars')->with('success', trans('driver.success'));
                                }
                            } else {
                                 
                                if (strpos($isSave['message']->resultMsg, 'driver.mobileNumber') !== false) {
                                    
                                    if($request->language == 'ar'){
                                        app()->setLocale('ar');
                                        return redirect('cars')->with('danger', trans('driver.mobileNumber_format'));
                                    }else{
                                        app()->setLocale('en');
                                        return redirect('cars')->with('danger', trans('driver.mobileNumber_format'));
                                    }
                                } else if (strpos($isSave['message']->resultMsg, 'driver.mobileNumber size') !== false){
                                    
                                    if($request->language == 'ar'){
                                        app()->setLocale('ar');
                                        return redirect('cars')->with('danger', trans('driver.mobileNumber_length'));
                                    }else{
                                        app()->setLocale('en');
                                        return redirect('cars')->with('danger', trans('driver.mobileNumber_length'));
                                    }
                                } else {
                                        return redirect('cars')->with('danger',$isSave['message']->resultMsg);
                                
                                } 
                            }
                        } else {
                            if ($request->language == 'ar') {
                                app()->setLocale('ar');
                                return redirect('cars')->with('danger', trans('driver.sequence_error'));
                            } else {
                                app()->setLocale('en');
                                return redirect('cars')->with('danger', trans('driver.sequence_error'));
                            }
                        }
                    } else {
                        //if (strpos($responseData['data']->rejectionReasons[0], 'DRIVER_VEHICLE_INELIGIBLE') !== false){
                        if (isset($responseData['data']->rejectionReasons[0]) && is_array($responseData['data']->rejectionReasons)) {
                            if($request->language == 'ar'){
                                app()->setLocale('ar');
                                return redirect('cars')->with('danger', trans('driver.driver_vehicle_ineligible'));
                            }else{
                                app()->setLocale('en');
                                return redirect('cars')->with('danger', trans('driver.driver_vehicle_ineligible'));
                            }
                        }
                        if (isset($responseData['data']->driverEligibility) && ($responseData['data']->driverEligibility  == 'PENDING')) {
                            if($request->language == 'ar'){
                                app()->setLocale('ar');
                                return redirect('cars')->with('danger', 'Driver eligibility is pending');
                            }else{
                                app()->setLocale('en');
                                return redirect('cars')->with('danger', 'Driver eligibility is pending');
                            }
                        }
        
                        if (isset($responseData['data']->driverEligibility)) {
                            $driverEligibility = $responseData['data']->driverEligibility;
                            if($driverEligibility == 'INVALID'){
                                if (isset($responseData['data']->rejectionReasons) && is_array($responseData['data']->rejectionReasons)) {
                                    $rejectionReasons = $responseData['data']->rejectionReasons;
                                    $Reason = null;
                                    foreach ($rejectionReasons as $reason) {
                                        $Reason = $reason;
                                        break; 
                                    }
                                    if ($Reason !== null) {
                                        return redirect('cars')->with('danger', 'Driver is not eligible :- '.$Reason);
                                    } else {
                                        return redirect('cars')->with('danger', 'Driver is not eligible');
                                    }
                                }else{
                                    return redirect('cars')->with('danger', 'Driver is not eligible');
                                }
                            }
                        }
                    }
                }else{
                    //return redirect('cars')->with('danger', $responseData['message']);
                    return redirect('cars')->with('danger', trans('عذرا ليس لديك الاهلية من وزارة النقل العام'));
                }
             
        }catch(\Exception $e){
            return redirect('cars')->with('danger', $e->getMessage());
        }
        
       

    } 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::with('images', 'carFeatures', 'user')->findOrFail($id);
        return view('cars.show', compact('car'));
    }

    public function AdminCarshow($id)
    {
        $car = Car::with('images', 'carFeatures', 'user')->findOrFail($id);
        return view('cars.admin_show', compact('car'));
    }

    public function ajaxCarData(Request $request)
    {
        $car = Car::find($request->car_id);
        return response()->json(['car' => $car, 'message' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $features = Feature::where('is_main', 0)->get();
        $car = Car::with('images', 'carFeatures', 'user')->findOrFail($id);
        return view('cars.edit', compact('features', 'car'));
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
            'name'                => 'string',
            'capacity_of_person'  => 'integer',
            'capacity_of_bag'     => 'integer',
            'sequence_number'     => 'string',
            'plate_letter_right'  => 'string',
            'plate_letter_middle' => 'string',
            'plate_letter_left'   => 'string',
            'plate_number'        => 'string',
            'plate_type'          => 'integer',
            'feature_id.*'        => 'exists:features,id|integer'
        ]);
        $responseData = $this->checkEligibility(Auth::user()->identity_number);
        


        if ($responseData['status'] == 200) {
            if (isset($responseData['data']->driverEligibility) && ($responseData['data']->driverEligibility  == 'VALID')) {

                if ($this->get_vehicles($responseData['data'], $request)) {
                    if ($this->updateCar($request , $id)) {
                        if($request->language == 'ar'){
                            app()->setLocale('ar');
                            return redirect('cars')->with('success', trans('driver.success'));
                        }else{
                            app()->setLocale('en');
                            return redirect('cars')->with('success', trans('driver.success'));
                        }
                    } else {
                        return redirect('cars')->with('danger', "something wen,t wrong.");
                    }
                } else {
                    return redirect('cars')->with('danger', "Your Sequence Number Not valid.");
                }
            } else {
                return redirect('cars')->with('danger', $responseData['data']->rejectionReasons[0]);
            }
        }else{
            return redirect('cars')->with('danger', $responseData['message']);
        }

    }

    public function updateCar($request,$id){
        $car                     = Car::findOrFail($id);
        if($car->user_id == Auth::id()){
            $car->name                = $request->name;
            $car->name_arabic         = $request->name;
            // $car->name_urdu           = $request->name_urdu;
            $car->capacity_of_person  = $request->capacity_of_person;
            $car->capacity_of_bag     = $request->capacity_of_bag;
            $car->sequence_number     = $request->sequence_number;
            $car->plate_letter_right  = $request->plate_letter_right;
            $car->plate_letter_middle = $request->plate_letter_middle;
            $car->plate_letter_left   = $request->plate_letter_left;
            $car->plate_number        = $request->plate_number;
            $car->plate_type          = $request->plate_type;
            $car->save();

            if($request->feature_id != null){
                $car->carFeatures()->detach();
                foreach($request->feature_id as $key => $value){
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
                foreach($request->file('image') as $key => $value){
                    $carImage = new Image;
                    $image = $request->file('image')[$key];
                    $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                    $public_path = public_path('storage/sliders');
                    $image->move($public_path, $name);
                    $image_url = asset('storage/sliders/' . $name);

                    $carImage->url = $image_url;
                    $carImage->imageable_id = $car->id;
                    $carImage->imageable_type = 'App\Models\Car';
                    $car->images()->save($carImage);
                }

            }
            return true;
        }else{
            return false;
        }
    }


    public function get_vehicles($vehicles, $request)
    {
        foreach ($vehicles->vehicles as $value) {
            if ($value->sequenceNumber == $request->sequence_number && $value->vehicleEligibility == 'VALID') {
                return true;
            } else {
                return true;
            }
        }
    }


public function addCar($request)
{
    $car                      = new Car();
    $car->user_id             = Auth::id();
    $car->name                = $request->name;
    $car->name_arabic         = $request->name;
    // $car->name_urdu           = $request->name_urdu;
    $car->capacity_of_person  = $request->capacity_of_person;
    $car->capacity_of_bag     = $request->capacity_of_bag;
    $car->sequence_number     = $request->sequence_number;
    $car->plate_letter_right  = $request->plate_letter_right;
    $car->plate_letter_middle = $request->plate_letter_middle;
    $car->plate_letter_left   = $request->plate_letter_left;
    $car->plate_number        = $request->plate_number;
    $car->plate_type          = $request->plate_type;
    $car->save();

    if ($car) {

        foreach ($request->feature_id as $key => $value) {
            $car->carFeatures()->attach($value, []);
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $key => $value) {
                $carImage = new Image;
                $image = $request->file('image')[$key];
                $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                $public_path = public_path('storage/sliders');
                $image->move($public_path, $name);
                $image_url = asset('storage/sliders/' . $name);

                $carImage->url = $image_url;
                $carImage->imageable_id = $car->id;
                $carImage->imageable_type = 'App\Models\Car';
                $car->images()->save($carImage);
            }
        }

        $car = Car::with(['user' => function ($partner) {
            $partner->with('partnerMetas');
        }])->findOrFail($car->id);
       
        $driverSaveResponse = $this->saveDriver($car);

        // التحقق من نجاح عملية حفظ السائق
        if (is_array($driverSaveResponse) && isset($driverSaveResponse['return']) && $driverSaveResponse['return'] == 'true') {
            return ['return' => 'true', 'message' => 'Car added successfully'];
        } else {
            return ['return' => 'false', 'message' => $driverSaveResponse['message'] ?? 'An unexpected error occurred.'];
        }
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

        return redirect('cars')->with('success', trans('car-ts.deleted'));
    }
    
}
