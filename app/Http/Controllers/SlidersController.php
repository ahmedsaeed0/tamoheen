<?php



namespace App\Http\Controllers;



use App\Http\Controllers\Controller;

use App\Http\Requests;



use App\Models\Slider;

use App\Models\Image;

use Illuminate\Http\Request;

use Storage;



class SlidersController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\View\View

     */

    public function index(Request $request)

    {

        $keyword = $request->get('search');

        $perPage = 25;



        if (!empty($keyword)) {

            $sliders = Slider::where('title', 'LIKE', "%$keyword%")

                ->orWhere('title_urdu', 'LIKE', "%$keyword%")

                ->orWhere('title_arabic', 'LIKE', "%$keyword%")

                ->orWhere('description', 'LIKE', "%$keyword%")

                ->orWhere('description_urdu', 'LIKE', "%$keyword%")

                ->orWhere('description_arabic', 'LIKE', "%$keyword%")

                ->orWhere('status', 'LIKE', "%$keyword%")

                ->latest()->paginate($perPage);

        } else {

            $sliders = Slider::with('image')->latest()->paginate($perPage);

        }



        return view('sliders.index', compact('sliders'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\View\View

     */

    public function create()

    {

        return view('sliders.create');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param \Illuminate\Http\Request $request

     *

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     */

     public function store(Request $request)
     {
         $rules = [
             'title' => 'required|string|max:255',
             'title_arabic' => 'required|string|max:255',
             'description' => 'required|string',
             'description_arabic' => 'required|string',
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
         ];
     
         $request->validate($rules);
     
         try {
             $slider = new Slider();
             $slider->title = $request->title;
             $slider->title_arabic = $request->title_arabic;
             $slider->description = $request->description;
             $slider->description_arabic = $request->description_arabic;
             $slider->save();
     
             if ($request->hasFile('image')) {
                 $image = $request->file('image');
                 $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                 $public_path = public_path('storage/sliders');
                 $image->move($public_path, $name);
                 $image_url = asset('storage/sliders/' . $name);
     
                 $sliderImage = new Image();
                 $sliderImage->url = $image_url;
                 $sliderImage->imageable_id = $slider->id;
                 $sliderImage->imageable_type = 'App\Models\Slider';
                 $sliderImage->save();
             }
     
             return redirect('sliders')->with('success', 'Slider added!');
         } catch (\Exception $e) {
             return redirect('sliders')->with('error', 'Slider creation failed: ' . $e->getMessage());
         }
     }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     *

     * @return \Illuminate\View\View

     */

    public function show($id)

    {

        $slider = Slider::with('image')->findOrFail($id);



        return view('sliders.show', compact('slider'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     *

     * @return \Illuminate\View\View

     */

    public function edit($id)

    {

        $slider = Slider::with('image')->findOrFail($id);



        return view('sliders.edit', compact('slider'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param \Illuminate\Http\Request $request

     * @param  int  $id

     *

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     */

     public function update(Request $request, $id)
     {
         $rules = [
             'title' => 'required|string|max:255',
             'title_arabic' => 'required|string|max:255',
             'description' => 'required|string',
             'description_arabic' => 'required|string',
             'image' => 'image|mimes:jpeg,png,jpg,gif', // Optional image upload validation
         ];
     
         $request->validate($rules);
     
         try {
             $slider = Slider::findOrFail($id);
     
             $slider->title = $request->title;
             $slider->title_arabic = $request->title_arabic;
             $slider->description = $request->description;
             $slider->description_arabic = $request->description_arabic;
             $slider->save();
     
             if ($request->hasFile('image')) {
                 $image = $slider->image;
                 if ($image !== null) {
                     $exists = Storage::disk('public')->exists($image->url);
                     if ($exists) {
                         Storage::disk('public')->delete($image->url);
                     }
                     $slider->image()->delete();
                 }
     
                 $sliderImage = new Image;
                 $image = $request->file('image');
                 $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                 $public_path = public_path('storage/sliders');
                 $image->move($public_path, $name);
                 $image_url = asset('storage/sliders/' . $name);
     
                 $sliderImage->url = $image_url;
                 $sliderImage->imageable_id = $slider->id;
                 $sliderImage->imageable_type = 'App\Models\Slider';
                 $slider->image()->save($sliderImage);
             }
     
             return redirect('sliders')->with('success', 'Slider updated!');
         } catch (\Exception $e) {
             return redirect('sliders')->with('error', 'Slider update failed: ' . $e->getMessage());
         }
     }
 



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     *

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     */

    public function destroy($id)

    {

        $slider = Slider::findOrFail($id);

        $image = $slider->image;

        if($image){

            $exists = Storage::disk('public')->exists($image->url);



            if($exists){

                Storage::disk('public')->delete($image->url);

            }

        }

        $slider->image()->delete();

        Slider::destroy($id);



        return redirect('sliders')->with('success', 'Slider deleted!');

    }

}

