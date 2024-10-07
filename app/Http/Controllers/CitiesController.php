<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\State;

use App\Models\City;

use App\Models\Image;

use App\Traits\AddressTrait;

use Auth;

use Storage;



class CitiesController extends Controller

{

    use AddressTrait;

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $cities = City::with('images','states')->latest()->paginate(25);

        return view('cities.index', compact('cities'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $states = State::pluck('name', 'id');

        return view('cities.create', compact('states'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        

        $this->validate($request, [

            'name'               => 'required|string',

            'name_arabic'        => 'required|string',

            'description'        => 'required|string',

            'description_arabic' => 'required|string',

            'state_id'           => 'required|integer',

            // 'order_by'          => 'required|integer|unique:cities,city_order'

        ]);



        



        $response = $this->getLatLngFromAddress($request->name);



        $city                     = new City;

        $city->name               = $request->name;

        $city->name_arabic        = $request->name_arabic;

        // $city->name_urdu          = $request->name_urdu;

        $city->description        = $request->description;

        $city->description_arabic = $request->description_arabic;

        // $city->description_urdu   = $request->description_urdu;

        $city->state_id           = $request->state_id;

        $city->lat                = $response['lat'];

        $city->lng                = $response['lng'];

        $city->city_order         = $request->order_by;

        $city->save();



        if($city){

            if($request->hasFile('image')){

                foreach($request->file('image') as $key => $value){

                    $cityImage = new Image;

                    $image = $request->file('image')[$key];

                    $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                    $public_path = public_path('storage/cities');
                    $image->move($public_path, $name);
                    $image_url = asset('storage/cities/' . $name);

                   

                    $cityImage->url = $image_url;

                    $cityImage->imageable_id = $city->id;

                    $cityImage->imageable_type = 'App\Models\City';

                    $city->images()->save($cityImage);

                }

                $city->images;

            }



        }

        return redirect('cities')->with('success', 'City created');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $city = City::with('images','states')->findOrFail($id);

        return view('cities.show', compact('city'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $states = State::pluck('name', 'id');

        $city = City::with('images','states')->findOrFail($id);

        return view('cities.edit', compact('city', 'states'));

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

        $this->validate($request, [

            'name'               => 'string',

            'name_arabic'        => 'string',

            'description'        => 'string',

            'description_arabic' => 'string',

            'state_id'           => 'integer',

            'order_by'          => 'integer'

        ]);



        $city                     = City::findOrFail($id);

        $city->name               = $request->name;

        $city->name_arabic        = $request->name_arabic;

        // $city->name_urdu          = $request->name_urdu;

        $city->description        = $request->description;

        $city->description_arabic = $request->description_arabic;

        // $city->description_urdu   = $request->description_urdu;

        $city->state_id           = $request->state_id;

        $city->city_order         = $request->order_by;

        if(isset($request->name)){

            $response = $this->getLatLngFromAddress($request->name);

            if(isset($response['lat']) && $response['lat'] != null){

                $city->lat                = $response['lat'];

            }

            

            if(isset($response['lng']) && $response['lng'] != null){

                $city->lng                = $response['lng'];

            }

        }

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
                $public_path = public_path('storage/cities');
                $image->move($public_path, $name);
                $image_url = asset('storage/cities/' . $name);

                $cityImage->url = $image_url;

                $cityImage->imageable_id = $city->id;

                $cityImage->imageable_type = 'App\ModelsCity';

                $city->images()->save($cityImage);

            }



        }



        return redirect('cities')->with('success', 'City updated');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $city  = City::findOrFail($id);

        foreach ($city->images as $image) {

            $exists = Storage::disk('public')->exists($image->url);

            if($exists){

                Storage::disk('public')->delete($image->url);

            }

        }

        $city->images()->delete();

        City::destroy($id);

        return redirect('cities')->with('success', 'City deleted');

    }

}

