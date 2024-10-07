<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TripExport;
use App\Exports\TripBookingExport;
use App\Exports\admins;
use App\Exports\users;
use App\Exports\partner;
use App\Exports\sliders;
use App\Exports\product_type;
use App\Exports\promoCodes;
use App\Exports\countryes;
use App\Exports\states;
use App\Exports\citys;
use App\Exports\features;
use App\Exports\ServiceCharges;
use App\Exports\TripBookings;
use App\Exports\PartnerAmounts;
use App\Exports\pages;
use App\Exports\WithdrawRequests;
use App\Exports\PendingWithdrawRequest;
use App\Exports\PartnerPaymentHistory;
use App\Exports\Reviews;
use App\Exports\Complains;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{

    public function export(Request $request){
        if($request->slug == 'trip'){
            return Excel::download(new TripExport(), $request->slug.'.xlsx');
        }elseif($request->slug == 'trip-booking'){
            return Excel::download(new TripBookingExport(), $request->slug.'.xlsx');
        }elseif($request->slug == "admins"){
            return Excel::download(new admins(), $request->slug.'.xlsx');
        }elseif($request->slug == "user"){
            return Excel::download(new users(), $request->slug.'.xlsx');
        }elseif($request->slug == "partner"){
            return Excel::download(new partner(), $request->slug.'.xlsx');
        }elseif($request->slug == "sliders"){
            return Excel::download(new sliders(), $request->slug.'.xlsx');
        }elseif($request->slug == "product-types"){
            return Excel::download(new product_type(), $request->slug.'.xlsx');
        }elseif($request->slug == "promo-code"){
            return Excel::download(new promoCodes(), $request->slug.'.xlsx');
        }elseif($request->slug == "countries"){
            return Excel::download(new countryes(), $request->slug.'.xlsx');
        }elseif($request->slug == "states"){
            return Excel::download(new states(), $request->slug.'.xlsx');
        }elseif($request->slug == "cities"){
            return Excel::download(new citys(), $request->slug.'.xlsx');
        }elseif($request->slug == "features"){
            return Excel::download(new features(), $request->slug.'.xlsx');
        }elseif($request->slug == "service-charges"){
            return Excel::download(new ServiceCharges(), $request->slug.'.xlsx');
        }elseif($request->slug == "trip-wallets"){
            return Excel::download(new TripBookings(), $request->slug.'.xlsx');
        }elseif($request->slug == "wallets-manage"){
            return Excel::download(new PartnerAmounts(), $request->slug.'.xlsx');
        }elseif($request->slug == "pages"){
            return Excel::download(new pages(), $request->slug.'.xlsx');
        }elseif($request->slug == "withdraw-requests"){
            return Excel::download(new WithdrawRequests(), $request->slug.'.xlsx');
        }elseif($request->slug == "pending-withdraw-requests"){
            return Excel::download(new PendingWithdrawRequest(), $request->slug.'.xlsx');
        }elseif($request->slug == "partner-payment-hostories"){
            return Excel::download(new PartnerPaymentHistory(), $request->slug.'.xlsx');
        }elseif($request->slug == "reviews"){
            return Excel::download(new Reviews(), $request->slug.'.xlsx');
        }elseif($request->slug == "complains"){
            return Excel::download(new Complains(), $request->slug.'.xlsx');
        }

    }
    
}
