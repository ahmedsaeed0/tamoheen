<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\PromoCode;
use Auth;

class OrdersController extends Controller
{
    public function place_order(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'city_id' => 'required|integer',
        ]);

        if($validate->fails()){
            return response()->json(['errors' => $validate->errors(), 'code' => 422], 422);
        }

    	$total_price = 0;
        $final_price = 0;
        $time_stamp = time()+(3*24*60*60);
        $estimated_time = date("l", $time_stamp).' '.date('M d,Y', $time_stamp);
        $cart_ids = [];

        $cart=Cart::where('user_id', Auth::id())->where('is_cart', '1')->latest()->get();
        foreach ($cart as $single_cart) {
        	$total_price = $total_price + ($single_cart->quantity*$single_cart->price);
        	array_push($cart_ids, $single_cart->id);
        }

        $promo_code_cnt = PromoCode::where('code', $request->input("promo_code"))->count();
        if (($request->input("promo_code") !== null) && ($promo_code_cnt > 0)) {
            $promo_code       = PromoCode::where('code', $request->input("promo_code"))->first();
            $only_promo_code  = $promo_code->code;
            $discount_type    = $promo_code->type;
            $discount_percent = $promo_code->percent;
            $discount_amount  = $promo_code->amount;

            if ($discount_type == "amount") {
                $final_price = $total_price - $discount_amount;
            } else {
                $final_price = $total_price - (($total_price * $discount_percent) / 100);
            }
        } else {
            $final_price = $total_price;
            $discount_percent = null;
            $discount_amount = null;
            $only_promo_code = null;
        }



        $order                   = new Order;
        $order->user_id          = Auth::id();
        $order->city_id          = $request->input('city_id');
        $order->total_price      = $total_price;
        $order->final_price      = $final_price;
        $order->order_status     = 1;
        $order->estimated_time   = $estimated_time;
        $order->discount_percent = $discount_percent;
        $order->discount_amount  = $discount_amount;
        $order->promo_code       = $only_promo_code;
		$order->save();

        if ($order) {
            foreach ($cart_ids as $cart_id) {
                $order->cartOrders()->attach($cart_id, []);
            }
            Cart::where('user_id', Auth::id())->where('is_cart', '1')->update(['is_cart'=>'0']);

            return response()->json([
                'status' => 'Success',
                'order' => $order,
                'code' => 201
            ], 201);
        }else{
            return response()->json(
                [
                    'message' => "Failed",
                    'code' => 201
                ],
                201
            );
        }
    }

    public function order_detail($order_id)
    {
        $order = Order::where('id', $order_id)->with('user', 'city')->first();
        if(!$order){
            return response()->json(['status' => 'Order Not Found', 'code' => 404], 404);
        }

        $product_ids = $order->cartOrders()->pluck('product_id');

        $products = Product::whereIn('id', $product_ids)->with('image')->get();
        return response()->json(
            [
                'order'    => $order,
                'products' => $products,
                'code' => 201
            ], 201
        );
    }

    public function history()
    {
        $user = Auth::user();
        if($user->hasRole('user')){
            $orders = Order::where('user_id', Auth::id())->with(['city', 'user', 'cartOrders' => function ($query) {
                $query->with('product');
            }])->latest()->get();
        }else{
            $orders = Order::with(['city', 'user', 'cartOrders' => function ($query) {
                $query->with('product');
            }])->latest()->get();
        }
        return response()->json([
            'orders' => $orders,
            'code' => 201
        ], 201);
    }
}
