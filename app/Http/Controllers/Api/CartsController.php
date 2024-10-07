<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Cart;
use App\Product;
use App\User;
use Auth;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $carts=Cart::where('user_id', Auth::id())->where('is_cart', '1')->latest()->get();
        foreach ($carts as $cart) {
            $product = Product::where('id', $cart->product_id)->first();

            $single_data = [];
            $single_data['cart_id']                 = $cart->id; 
            $single_data['product_id']              = $cart->product_id; 
            $single_data['name']                    = $product->name; 
            $single_data['name_arabic']             = $product->name_arabic;
            $single_data['name_urdu']               = $product->name_urdu;
            $single_data['image']                   = $product->image()->get();
            $single_data['total_price']             = $cart->quantity*$cart->price; 
            $single_data['quantity']                = $cart->quantity;
            $single_data['price']                   = $cart->price;
            array_push($data, $single_data);
        }
        return response()->json($data);
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
        $user_id        = Auth::id();
        $product_id     = $request->input('product_id');
        $count = Cart::where('user_id', Auth::id())->where('is_cart', '1')->where('product_id', $product_id)->count();
        $current_product = Product::where('id', $request->input('product_id'))->first();
        $product_price = $current_product->price;

        if($count>0) {
            $id = Cart::where('user_id', Auth::id())->where('is_cart', '1')->where('product_id', $product_id)->first()->id;
            $old_quantity = Cart::where('id', $id)->first()->quantity;
            $quantity = 1+$old_quantity;
            $Cart = Cart::find($id);
            $Cart->quantity                  = $quantity;
            $Cart->save();
        }else{

            $Cart = new Cart;
            $Cart->user_id                      = $user_id;
            $Cart->product_id                   = $product_id;
            $Cart->quantity                     = $request->input('quantity');
            $Cart->price                        = $product_price;
            $Cart->is_cart                      = 1;
            $Cart->save();            
        }

        if ($Cart) {
            $data['msg'] = 'Success';
            $data['status'] = 1; 
        }else{
            $data['msg'] = 'Failed';
            $data['status'] = 0; 
        }
        return response()->json([
            'message' =>   $data,
            'cart' => $Cart
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
        //
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
    public function update_quantity_cart(Request $request)
    {
        $id = $request->input('cart_id');

        $quantity = $request->input('new_quantity'); //+$old_quantity;

        $Cart               = Cart::find($id);
        $Cart->quantity     = $quantity;
        $Cart->save();
        $data = [];
        if ($Cart) {
            $data['msg'] = 'Success';
            $data['status'] = 1; 
        }else{
            $data['msg'] = 'Failed';
            $data['status'] = 0; 
        }
        return response()->json($data);
    }  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $request->input('cart_id'))->delete();
        $cart = Cart::where('user_id', Auth::id())->where('id', $request->input('cart_id'))->get();
        
        if(!$cart->isEmpty()){
            $cart->delete();
            return response()->json([
                'message' => 'Successfully deleted.'
            ]);
        } else {
            return response()->json([
                'message' => 'Successfully deleted.'
            ]);
        } 
    }
}
