<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\TripBooking;
use App\Models\ShipmentBooking;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends Controller
{
    public function telrGatewayForBooking(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'booking_id'     => 'required|integer',
            'payment_method' => 'required|string',
            'trx_id'         => 'required|string',
            'type'           => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json(['errors' => $validate->errors(), 'code' => 422], 422);
        }

        if($request->type == 'trip'){
            $tripBooking = TripBooking::find($request->booking_id);
        }else{
            $tripBooking = ShipmentBooking::find($request->booking_id);
        }

        
        if(!$tripBooking){
            return response()->json([
                'msg' => 'Booking Not Found', 
                'code' => 404
            ], 404);
        }

        $tripBooking->is_payment_complete = 1;
        $tripBooking->payment_method = $request->payment_method;
        $tripBooking->trx_id = $request->trx_id;
        $tripBooking->save();

        return response()->json([
            'status' => 'Payment Successfully',
            'code' => 200
        ], 200);
    }

    public function telrGatewayForProductOrder(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id'       => 'required|integer',
            'payment_method' => 'required|string',
            'trx_id'         => 'required|string',
        ]);

        if($validate->fails()){
            return response()->json(['errors' => $validate->errors(), 'code' => 422], 422);
        }

        $order = Order::find($request->order_id);
        if(!$order){
            return response()->json([
                'msg' => 'Order Not Found', 
                'code' => 404
            ], 404);
        }

        $order->trx_id = $request->trx_id;
        $order->payment_method = $request->payment_method;
        $order->save();

        return response()->json([
            'order' => $order,
            'status' => 'Payment Successfully',
            'code' => 200
        ], 200);
    }
}
