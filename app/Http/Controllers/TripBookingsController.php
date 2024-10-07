<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use Illuminate\Support\Facades\Mail;

use App\Mail\BookingTrip;



use App\Models\Trip;

use App\Models\TripBooking;

use App\Models\ShipmentBooking;

use App\Models\PartnerPaymentHostory;

use App\Models\PartnerAmount;

use App\Models\ServiceCharge;

use App\Models\User;

use App\Models\Passenger;

use Auth;

use DNS1D;

use DNS2D;

use Carbon\Carbon;

use Storage;

use Crypt;



class TripBookingsController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {
        $user = Auth::user();

        if($user->hasrole('partner')){
            $tripbookings = TripBooking::with('trip')
            ->whereHas('trip', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->where('status', '!=', 0)
            ->latest('id')
            ->paginate(25);

        }else{
            $tripbookings = TripBooking::with('trip')->latest('id')->paginate(25);

        }

        // echo "<pre>";
        // print_r($tripbookings);die;
        
        return view('trip-bookings.index', compact('tripbookings'));

    }



    public function indexShip()

    {

        $user = Auth::user();

        if($user->hasrole('partner')){

            $tripbookings = ShipmentBooking::whereHas('trip', function($q){

                $q->where('user_id', Auth::id());

            })->where('status', '!=', 0)->paginate(25);

        }else{

            $tripbookings = ShipmentBooking::with('trip')->latest()->paginate(25);

        }

        return view('trip-bookings.index-ship', compact('tripbookings'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

   



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    // public function show($id)

    // {

    //     $tripbooking = TripBooking::with('passengers')->findOrFail($id);

    //     return view('trip-bookings.show', compact('tripbooking'));

    // }

    

    public function show($id)

    {

        $tripbooking = TripBooking::findOrFail($id);

        $passengers = Passenger::where('trip_id', $tripbooking->trip_id)

            ->where('booking_user_id', $tripbooking->user_id)

            ->where('trip_booking_id', $tripbooking->id)

            ->get();;

        return view('trip-bookings.show', compact('tripbooking', 'passengers'));

    }



    public function showShipBooking($id)

    {

        $tripbooking = ShipmentBooking::with('user')->findOrFail($id);

        return view('trip-bookings.show-ship', compact('tripbooking'));

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



    public function checkInView($id)

    {

        $tripbooking = TripBooking::findOrFail($id);

        return view('trip-bookings.check-in', compact('tripbooking'));

    }



    public function checkInShipView($id)

    {

        $tripbooking = ShipmentBooking::findOrFail($id);

        return view('trip-bookings.ship-check-in', compact('tripbooking'));

    }



    public function checkIn(Request $request)

    {

        // $decryipted =  Crypt::decryptString($request->encrypt_data);

        // $decryipted =  base64_decode($request->encrypt_data);

        $decryipted = $request->encrypt_data;

        $arr = explode(',', $decryipted);

        $data = [];

        foreach($arr as $sig){

            $ex = explode(':', $sig);

            $data[$ex[0]] = $ex[1];

        }

        // dd($data);

        

        if($request->request_booking_id != $data['Booking No']){

            return redirect('trip-bookings')->with('warning', 'You scan a wrong QR code');

        }else{



            $trip_booking = TripBooking::where('trip_id', $data['Trip id'])->where('id', $data['Booking No'])->first();

    

            if($trip_booking){

                $trip_booking->status = 2;
                $trip_booking->check_in = Carbon::now()->format('Y-m-d H:i');
                $trip_booking->save();

    

                $trip = Trip::where('id', $trip_booking->trip_id)->first();

    

                $partner_payment_history                = new PartnerPaymentHostory();

                $partner_payment_history->user_id       = $trip->user_id;

                $partner_payment_history->booking_id    = $trip_booking->id;

                $partner_payment_history->price         = $trip_booking->price;

                $partner_payment_history->partner_price = $trip_booking->partner_price;

                $partner_payment_history->type          = 'Cash In';

                $partner_payment_history->trip_type     = 'trip';

                $partner_payment_history->save();

    

                $partner_amount = PartnerAmount::where('partner_id', $trip->user_id)->first();

    

                if($partner_amount != null){

                    $price = $partner_amount->total_amount+$trip_booking->partner_price;
                    $partner_amount->total_amount = $price;
                    $partner_amount->save();

                    $trip_booking->partner_wallet_balance = $price;
                    $trip_booking->save();
                }else{

                    $partner_amount = new PartnerAmount();
                    $partner_amount->partner_id = $trip->user_id;
                    $partner_amount->total_amount = $trip_booking->partner_price;
                    $partner_amount->save();

                    // $trip_booking->partner_wallet_balance = $price;
                    $trip_booking->save();
                }

    

                return redirect('trip-bookings')->with('success', 'Checked In Success');

            }else{

                return redirect('trip-bookings')->with('success', 'Checked In Failed');

            }

        }

    }



    public function checkInShip(Request $request)

    {

        // $decryipted =  Crypt::decryptString($request->check_data);

        $decryipted =  base64_decode($request->check_data);

        // dd($decryipted);

        $arr = explode(',', $decryipted);

        $data = [];

        foreach($arr as $sig){

            $ex = explode(':', $sig);

            $data[$ex[0]] = $ex[1];

        }



        $trip_booking = ShipmentBooking::where('trip_id', $data['Trip id'])->where('id', $data['Booking No'])->first();



        if($trip_booking){



            $trip_booking->status = 2;

            $trip_booking->check_in = Carbon::now()->format('Y-m-d H:i');

            $trip_booking->save();





            $trip = Trip::where('id', $trip_booking->trip_id)->first();



            $partner_payment_history                = new PartnerPaymentHostory();

            $partner_payment_history->user_id       = $trip->user_id;

            $partner_payment_history->booking_id    = $trip_booking->id;

            $partner_payment_history->price         = $trip_booking->price;

            $partner_payment_history->partner_price = $trip_booking->partner_price;

            $partner_payment_history->type          = 'Cash In';

            $partner_payment_history->trip_type     = 'shipment';

            $partner_payment_history->save();



            $partner_amount = PartnerAmount::where('partner_id', $trip->user_id)->first();



            if($partner_amount != null){

                $price = $partner_amount->total_amount+$trip_booking->partner_price;

                $partner_amount->total_amount = $price;

                $partner_amount->save();

            }else{

                $partner_amount = new PartnerAmount();

                $partner_amount->partner_id = $trip->user_id;

                $partner_amount->total_amount = $trip_booking->partner_price;

                $partner_amount->save();

            }



            return redirect('ship-bookings')->with('success', 'Checked In Success');

        }else{

            return redirect('ship-bookings')->with('success', 'Checked In Failed');

        }

    }



    public function checkOutView($id)

    {

        $tripbooking = TripBooking::findOrFail($id);

        return view('trip-bookings.check-out', compact('tripbooking'));

    }



    public function checkOutShipView($id)

    {

        $tripbooking = ShipmentBooking::findOrFail($id);

        return view('trip-bookings.ship-check-out', compact('tripbooking'));

    }



    public function checkOutShip(Request $request)

    {

        $decryipted =  Crypt::decryptString($request->encrypt_data);

        // $decryipted =  base64_decode($request->encrypt_data);

        $arr = explode(',', $decryipted);

        $data = [];

        foreach ($arr as $sig) {

            $ex = explode(':', $sig);

            $data[$ex[0]] = $ex[1];

        }



        $trip_booking = ShipmentBooking::where('trip_id', $data['Trip id'])->where('id', $data['Booking No'])->first();



        if ($trip_booking) {

            $trip_booking->status = 3;

            $trip_booking->check_out = Carbon::now()->format('Y-m-d H:i');

            $trip_booking->save();



            return redirect('ship-bookings')->with('success', 'Checked Out Success');

        }else{

            return redirect('ship-bookings')->with('success', 'Checked Out Failed');

        }

    }



    public function checkOut(Request $request)

    {

        // $decryipted =  Crypt::decryptString($request->encrypt_data);

        // $decryipted =  base64_decode($request->encrypt_data);

        $decryipted = $request->encrypt_data;

        $arr = explode(',', $decryipted);

        $data = [];

        foreach ($arr as $sig) {

            $ex = explode(':', $sig);

            $data[$ex[0]] = $ex[1];

        }

        

        if($request->request_booking_id != $data['Booking No']){

            return redirect('trip-bookings')->with('warning', 'You scan a wrong QR code');

        }else{



            $trip_booking = TripBooking::where('trip_id', $data['Trip id'])->where('id', $data['Booking No'])->first();

    

            if ($trip_booking) {

                $trip_booking->status = 3;

                $trip_booking->check_out = Carbon::now()->format('Y-m-d H:i');

                $trip_booking->save();

    

                return redirect('trip-bookings')->with('success', 'Checked Out Success');

            }else{

                return redirect('trip-bookings')->with('success', 'Checked Out Failed');

            }

        }

    }

    

    public function directCheckIn($id)

    {
    
        $trip_booking = TripBooking::findOrFail($id);



        if ($trip_booking) {

            $trip_booking->status = 2;

            $trip_booking->check_in = Carbon::now()->format('Y-m-d H:i');

            $trip_booking->save();



            $trip = Trip::where('id', $trip_booking->trip_id)->first();



            $partner_payment_history                = new PartnerPaymentHostory();

            $partner_payment_history->user_id       = $trip->user_id;

            $partner_payment_history->booking_id    = $trip_booking->id;

            $partner_payment_history->price         = $trip_booking->price;

            $partner_payment_history->partner_price = $trip_booking->partner_price;

            $partner_payment_history->type          = 'Cash In';

            $partner_payment_history->trip_type     = 'trip';

            $partner_payment_history->save();



            $partner_amount = PartnerAmount::where('partner_id', $trip->user_id)->first();



            if ($partner_amount != null) {

                $price = $partner_amount->total_amount + $trip_booking->partner_price;
                $partner_amount->total_amount = $price;
                $partner_amount->save();

                $trip_booking->partner_wallet_balance = $price;
                $trip_booking->save();
            } else {

                $partner_amount = new PartnerAmount();
                $partner_amount->partner_id = $trip->user_id;
                $partner_amount->total_amount = $trip_booking->partner_price;
                $partner_amount->save();

                $trip_booking->partner_wallet_balance = $trip_booking->partner_price;
                $trip_booking->save();
            }



            return redirect('trip-bookings')->with('success', 'Checked In Success');

        } else {

            return redirect('trip-bookings')->with('success', 'Checked In Failed');

        }

    }



    public function tripBookingComplete($id)

    {

        $trip_booking = TripBooking::findOrFail($id);

        $trip_booking->status = 4;

        $trip_booking->save();

        return redirect('trip-bookings')->with('success', 'Trip Booking Complete');

    }



    public function shipBookingComplete($id)

    {

        $trip_booking = ShipmentBooking::findOrFail($id);

        $trip_booking->status = 4;

        $trip_booking->save();

        return redirect('ship-bookings')->with('success', 'Ship Booking Complete');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        TripBooking::destroy($id);

        return redirect('trip-bookings')->with('success', 'Trip Booking deleted');

    }



    public function shipDestroy($id)

    {

        ShipmentBooking::destroy($id);

        return redirect('ship-bookings')->with('success', 'Shipment Booking deleted');

    }

}

