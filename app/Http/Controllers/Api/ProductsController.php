<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Image;
use Auth;
use Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->with('image', 'categories')->get();
        $categories = Category::latest()->get();
        return response()->json([
            'products' => $products,
            'categories' => $categories
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
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
        ]);

        $product                     = new Product;
        $product->user_id            = Auth::id();
        $product->name               = $request->name;
        $product->name_arabic        = $request->name_arabic;
        $product->name_urdu          = $request->name_urdu;
        $product->description        = $request->description;
        $product->description_arabic = $request->description_arabic;
        $product->description_urdu   = $request->description_urdu;
        $product->price              = $request->price;
        $product->category_id        = $request->category_id;
        $product->status             = 1;
        $product->save();

        if($product){
            if($request->hasFile('image')){
                $productImage = new Image;
                $image = $request->file('image');
                $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                $path = $image->storeAs(
                    'products', $name, 'public'
                );
                $productImage->url = $path;
                $productImage->imageable_id = $product->id;
                $productImage->imageable_type = 'App\Models\Product';
                $product->image()->save($productImage);
            }
        }
        $product->image;
        return response()->json([
            'product' => $product
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
        $product = Product::with('image', 'categories')->findOrFail($id);
        return response()->json([
            'product' => $product
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
        $product                     = Product::findOrFail($id);
        $product->name               = $request->name;
        $product->name_arabic        = $request->name_arabic;
        $product->name_urdu          = $request->name_urdu;
        $product->description        = $request->description;
        $product->description_arabic = $request->description_arabic;
        $product->description_urdu   = $request->description_urdu;
        $product->price              = $request->price;
        $product->category_id        = $request->category_id;
        $product->save();

        if($request->image){
            $image = $product->image;
            $exists = Storage::disk('public')->exists($image->url);
            if($exists){
                Storage::disk('public')->delete($image->url);
            }
            $product->image()->delete();

            $productImage = new Image;
            $image = $request->file('image');
            $name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
            $path = $image->storeAs(
                'products', $name, 'public'
            );
            $productImage->url = $path;
            $productImage->imageable_id = $product->id;
            $productImage->imageable_type = 'App\Models\Product';
            $product->image()->save($productImage);
        }
        $product->image;
        return response()->json([
            'product' => $product
        ]);
    }

    public function productActive($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();

        return response()->json([
            'message' => 'Product Activated'
        ]);
    }

    public function productDeactive($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 0;
        $product->save();

        return response()->json([
            'message' => 'Product Deactivated'
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
        $product = Product::findOrFail($id);
        $image = $product->image;
        if($image){
            $exists = Storage::disk('public')->exists($image->url);
        
            if($exists){
                Storage::disk('public')->delete($image->url);
            }
        }
        $product->image()->delete();
        Product::destroy($id);
        return response()->json([
            'message' => 'Product deleted!'
        ]);
    }
}
