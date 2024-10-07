<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\Models\Feature;

use Auth;

use App\Models\Image;

use Storage;



class FeaturesController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $features = Feature::with('image')->latest()->paginate(25);

        // dd($features);

        return view('features.index', compact('features'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('features.create');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

     public function store(Request $request)
     {
         $rules = [
             'name' => 'required|string|max:255',
             'name_arabic' => 'required|string|max:255',
             'is_main' => 'required|boolean',
             'note' => 'nullable|string',
             'icon' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
         ];
     
         $request->validate($rules);
     
         try {
             $feature = new Feature();
             $feature->name = $request->name;
             $feature->name_arabic = $request->name_arabic;
             $feature->is_main = $request->is_main;
             $feature->note = $request->note;
             $feature->save();
     
             if ($request->hasFile('icon')) {
                 $featureImage = new Image;
     
                 $image = $request->file('icon');
                 $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                 $public_path = public_path('storage/feature');
                 $image->move($public_path, $name);
                 $image_url = asset('storage/feature/' . $name);
     
                 $featureImage->url = $image_url;
                 $featureImage->imageable_id = $feature->id;
                 $featureImage->imageable_type = 'App\Models\Feature';
                 $feature->image()->save($featureImage);
             }
     
             return redirect('features')->with('success', 'Feature created');
         } catch (\Exception $e) {
             return redirect('features')->with('error', 'Feature creation failed: ' . $e->getMessage());
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

        $feature = Feature::with('image')->findOrFail($id);

        return view('features.show', compact('feature'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $feature = Feature::with('image')->findOrFail($id);

        return view('features.edit', compact('feature'));

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
        $rules = [
            'name' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'is_main' => 'required|boolean',
            'note' => 'nullable|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        $request->validate($rules);
    
        try {
            $feature = Feature::findOrFail($id);
    
            $feature->name = $request->name;
            $feature->name_arabic = $request->name_arabic;
            $feature->is_main = $request->is_main;
            $feature->note = $request->note;
            $feature->save();
    
            if ($request->hasFile('icon')) {
                $image = $feature->image;
                if ($image !== null) {
                    $exists = Storage::disk('public')->exists($image->url);
                    if ($exists) {
                        Storage::disk('public')->delete($image->url);
                    }
                    $feature->image()->delete();
                }
    
                $featureImage = new Image;
                $image = $request->file('icon');
                $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                $public_path = public_path('storage/feature');
                $image->move($public_path, $name);
                $image_url = asset('storage/feature/' . $name);
                $featureImage->url = $image_url;
    
                $featureImage->imageable_id = $feature->id;
                $featureImage->imageable_type = 'App\Models\Feature';
                $feature->image()->save($featureImage);
            }
    
            return redirect('features')->with('success', 'Feature updated');
        } catch (\Exception $e) {
            return redirect('features')->with('error', 'Feature update failed: ' . $e->getMessage());
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

        $feature = Feature::findOrFail($id);

        $image = $feature->image;

        if($image){

            $exists = Storage::disk('public')->exists($image->url);



            if($exists){

                Storage::disk('public')->delete($image->url);

            }

        }

        $feature->image()->delete();

        Feature::destroy($id);

        return redirect('features')->with('success', 'Feature deleted');

    }

}

