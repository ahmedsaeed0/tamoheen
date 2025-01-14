<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('user')){
            $orders = Order::where('user_id', Auth::id())->with(['city', 'user', 'cartOrders' => function($query){
                $query->with('product');
            }])->latest()->paginate(25);
        }else{
            $orders = Order::with(['city', 'user', 'cartOrders' => function($query){
                $query->with('product');
            }])->latest()->paginate(25);
        }
        return view('orders.index', compact('orders'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['city', 'user', 'cartOrders' => function($query){
                $query->with('product');
            }])->findOrFail($id);
        return view('orders.show', compact('order'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderAccept($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = 2;
        $order->save();

        return redirect('orders')->with('success', 'Order accepted');
    }

    public function orderOngoing($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = 3;
        $order->save();

        return redirect('orders')->with('success', 'Order ongoing');
    }

    public function orderDelivery($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = 4;
        $order->save();

        return redirect('orders')->with('success', 'Order delivered');
    }
}
