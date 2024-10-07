<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
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
        $products = Product::with('image', 'categories')->latest()->paginate(25);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('products.create', compact('categories'));
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
            'category_id' => 'required|exists:categories,id|integer',
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|string',
            'image'       => 'required|mimes:jpg,png,jpeg,gif'
        ]);

        $product                     = new Product;
        $product->user_id            = Auth::id();
        $product->name               = $request->name;
        $product->name_arabic        = $request->name_arabic;
        // $product->name_urdu          = $request->name_urdu;
        $product->description        = $request->description;
        $product->description_arabic = $request->description_arabic;
        // $product->description_urdu   = $request->description_urdu;
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
                $productImage->imageable_type = 'App\Product';
                $product->image()->save($productImage);
            }
        }

        return redirect('products')->with('success', 'Product created');
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
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::pluck('name', 'id');
        $product = Product::with('image', 'categories')->findOrFail($id);
        return view('products.edit', compact('product', 'categories'));
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
        // $product->name_urdu          = $request->name_urdu;
        $product->description        = $request->description;
        $product->description_arabic = $request->description_arabic;
        // $product->description_urdu   = $request->description_urdu;
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
            $productImage->imageable_type = 'App\Product';
            $product->image()->save($productImage);
        }

        return redirect('products')->with('success', 'Product updated');
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
        return redirect('products')->with('success', 'Product deleted');
    }
}
