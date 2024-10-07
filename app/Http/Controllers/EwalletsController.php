<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Order;

use App\Models\TripBooking;

use App\Models\ShipmentBooking;

use App\Models\Trip;

use App\Models\PartnerAmount;

use App\Models\WithdrawRequest; 

use App\Models\PartnerMeta;

class EwalletsController extends Controller

{

    public function indexOrder()

    {

    	$orders = Order::latest()->get();

    	return view('e-wallets.order-index', compact('orders'));

    }



    public function indexTrip()

    {

    	$tripbookings = TripBooking::latest()->get();

    	return view('e-wallets.trip-index', compact('tripbookings'));

    }



    public function indexShipment()

    {

    	$shipmentbookings = ShipmentBooking::latest()->get();

    	return view('e-wallets.shipment-index', compact('shipmentbookings'));

    }



    // public function walletsManage(){
    //     $partnerAmount = PartnerAmount::join('withdraw_requests', 'partner_amounts.partner_id', '=', 'withdraw_requests.partner_id')
    //     ->join('partner_metas', 'partner_amounts.partner_id', '=', 'partner_metas.user_id')
    //     ->select('partner_amounts.*','withdraw_requests.*','partner_metas.*')
    //     ->get();
    //     return view('e-wallets.wallet-index', compact('partnerAmount'));
    // }

    public function walletsManage() {
        $trip_details = TripBooking::latest()
            ->leftJoin('users as user_tb', 'trip_bookings.user_id', '=', 'user_tb.id')
            ->leftJoin('users as partner_tb', 'trip_bookings.partner_id', '=', 'partner_tb.id')
            ->leftjoin('partner_metas as partner_meta', 'trip_bookings.partner_id', '=', 'partner_meta.user_id')
            ->select('trip_bookings.*', 'user_tb.name as username', 'user_tb.id as userid', 'partner_tb.name as partnername', 'partner_meta.brand_name as brand_name')
            ->paginate(10);
            //->get();
        //echo "<pre>"; print_r($trip_details); die;
            return view('e-wallets.wallet', compact('trip_details'));
    }
    
    

    public static function getTrip($id){

        $trip = Trip::where("user_id",$id)->get();

        foreach($trip as $value){

            return  $value->id;

        }

    }

    
    // public function wallets_update(Request $request) {
    //     $partnerid = $request->userid;
    //     $withdrawrequest = PartnerAmount::findOrFail($id);
    //     $total_amount = $request->userWalletInput;
    //     $withdrawrequest->save();

    //     return redirect()->back()->with('success', 'Amount successfully Settled!');

    // }
    public function wallets_update(Request $request) {
    //dd($request);
        $partnerid = $request->userid;
        $tripid = $request->tripid;
        $type = $request->type;

        $walletrequest = PartnerAmount::where('partner_id', $partnerid)->first();
        $Trip = TripBooking::where('id', $tripid)->first();

        if ($walletrequest) {
            $total_amount = $request->userWalletInput;
    
            $walletrequest->total_amount = $total_amount;
            $walletrequest->save();

            if($type == 'user'){
                $Trip->wallet_balance = $total_amount;
                $Trip->save();
            }
            if($type == 'partner'){
                $Trip->partner_wallet_balance = $total_amount;
                $Trip->save();
            }
    
            return redirect()->back()->with('success', 'Amount successfully Updated!');
        }
        return redirect()->back()->with('error', 'Trip record not found.');
    }
    
    // public function revert($id){
    //     $trip = new TripBooking();
    //     $trip = TripBooking::where('id', $id)->first();
        
    //     if($trip){
    //         $revert_amount = $trip['price'];
    //         $user_id = $trip['user_id'];
    //         $wallet = new PartnerAmount();
    //         $wallet->total_amount = 0;
    //         $wallet = PartnerAmount::where('partner_id', $user_id)->first();
            
    //         if ($wallet) {
    //             $amount = $wallet->total_amount + $revert_amount;
    //             $wallet->total_amount = $amount;
    //             $wallet->save();
                
    //             $Trip->wallet_balance = $amount;
    //             $Trip->save();
    //             return redirect()->back()->with('success', 'Amount successfully Revert!');
    //         }
    //     }
    //     return redirect()->back()->with('error', 'Trip record not found.');
    // }

    public function revert($id) {
        $trip = TripBooking::where('id', $id)->first();
    
        if ($trip) {
            $revert_amount = $trip->price;
            $user_id = $trip->user_id;
    
            $wallet = PartnerAmount::where('partner_id', $user_id)->first();
            
            if ($wallet) {
                $amount = $wallet->total_amount + $revert_amount;
                $wallet->total_amount = $amount;
                $wallet->save();
                
                $trip->wallet_balance = $amount;
                $trip->revert = 1;
                $trip->save();
                return redirect()->back()->with('success', 'Amount successfully Revert!');
            }
        }
        return redirect()->back()->with('error', 'Trip record not found.');
    }
    
    public function settleAmount($id){

        $withdrawrequest = WithdrawRequest::findOrFail($id);
        $withdrawrequest->status = true;
        $withdrawrequest->save();
        return redirect()->back()->with('success', 'Amount successfully Settled!');

    }


    
    

}

