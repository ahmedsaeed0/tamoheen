<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TripBooking;
use App\Models\Trip;
use App\Models\ShipmentBooking;
use App\Models\PartnerAmount;
use App\Models\Order;
use Auth;
use DB;
use Carbon\Carbon;

class DashboardsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->hasrole('partner')){

            $partner_amount = PartnerAmount::where('partner_id', $user->id)->sum('total_amount');

            $total_user = User::role('user')->count();
            $total_partner = User::role('partner')->count();

            $trip_ids = Trip::where('user_id', $user->id)->where('type', 1)->select('id')->get();
            $ship_ids = Trip::where('user_id', $user->id)->where('type', 2)->select('id')->get();

            $trip_booking = TripBooking::whereIn('trip_id', $trip_ids)->where('is_payment_complete', 1)->where('status', 2)->count();
            $ship_booking = ShipmentBooking::whereIn('trip_id', $ship_ids)->where('is_payment_complete', 1)->where('status', 2)->count();

            $total_trip = Trip::where('user_id', $user->id)->count();

            $trip_sales = TripBooking::whereIn('trip_id', $trip_ids)->where('is_payment_complete', 1)->where('status', 2)->sum('price');
            $ship_sales = ShipmentBooking::whereIn('trip_id', $ship_ids)->where('is_payment_complete', 1)->where('status', 2)->sum('price');
            $total_sales = $trip_sales+$ship_sales;
            $total_product_sales = [];

            $seven_days = Carbon::now()->subDays(7)->format('Y-m-d');
            

            $total_trip_sales = TripBooking::select(array(
                DB::raw('sum(price) as total, created_at'),
            ))
            ->whereIn('trip_id', $trip_ids)
            ->where('is_payment_complete',1)
            ->where('created_at', '>', $seven_days)
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->pluck('total', 'created_at');

            $total_ship_sales = ShipmentBooking::select(array(
                DB::raw('sum(price) as total, created_at'),
            ))
            ->whereIn('trip_id', $ship_ids)
            ->where('is_payment_complete',1)
            ->where('created_at', '>', $seven_days)
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->pluck('total', 'created_at');
        }else{

            $total_user = User::role('user')->count();
            $total_partner = User::role('partner')->count();
            $trip_booking = TripBooking::where('is_payment_complete', 1)->count();
            $ship_booking = ShipmentBooking::where('is_payment_complete', 1)->count();

            // $currentDate = Carbon::now()->format('Y-m-d');
            $seven_days = Carbon::now()->subDays(7)->format('Y-m-d');
            $today = Carbon::today()->format('Y-m-d');

            $total_trip_sales = TripBooking::select(array(
                DB::raw('sum(price) as total, created_at'),
            ))
            ->where('created_at', '>', $seven_days)
            ->where('is_payment_complete',1)
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->pluck('total', 'created_at');

            $total_ship_sales = ShipmentBooking::select(array(
                DB::raw('sum(price) as total, created_at'),
            ))
            ->where('created_at', '>', $seven_days)
            ->where('is_payment_complete',1)
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->pluck('total', 'created_at');

            $total_product_sales = Order::select(array(
                DB::raw('sum(final_price) as total, created_at'),
            ))
            ->where('created_at', '>', $seven_days)
            ->where('order_status',1)
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->pluck('total', 'created_at');
            
            // dd($total_product_sales);

            $total_sales = 0;
            $partner_amount = 0;
            $total_trip = Trip::count();

        }

        return response()->json([
            'total_user' => $total_user,
            'total_partner' => $total_partner,
            'trip_booking' => $trip_booking,
            'ship_booking' => $ship_booking,
            'total_trip_sales' => $total_trip_sales,
            'total_ship_sales' => $total_ship_sales,
            'total_product_sales' => $total_product_sales,
            'total_sales' => $total_sales,
            'total_trip' => $total_trip,
            'partner_amount' => $partner_amount,
        ]);
    }
}
