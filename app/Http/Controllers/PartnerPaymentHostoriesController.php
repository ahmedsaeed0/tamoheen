<?php



namespace App\Http\Controllers;



use App\Http\Controllers\Controller;

use App\Http\Requests;



use App\Models\PartnerPaymentHostory;

use Illuminate\Http\Request;

use App\Models\TripBooking;

use Auth;



class PartnerPaymentHostoriesController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\View\View

     */

    public function index(Request $request)

    {

        $keyword = $request->get('search');

        $perPage = 25;

        $user = Auth::user();

        if($user->hasrole('partner')){

            $partnerpaymenthostories = PartnerPaymentHostory::where('user_id', $user->id)->with('users')->latest()->paginate($perPage);

        }else{

            $partnerpaymenthostories = PartnerPaymentHostory::with('users','trips','tripBooking')->latest()->paginate($perPage);

        }
        
        return view('partner-payment-hostories.index', compact('partnerpaymenthostories'));

    }







    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\View\View

     */

    public function create()

    {

        return view('partner-payment-hostories.create');

    }





    public static function getTripId($id)

    {

        if($id != null){
            $trip = PartnerPaymentHostory::with('tripBooking')->where("user_id",$id)->first();
            if(isset($trip['tripBooking'])){
                return $trip['tripBooking']['trip_id'];
            }else{
                return false;
            }
        }else{
            return false;
        }

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param \Illuminate\Http\Request $request

     *

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     */

    public function store(Request $request)

    {

        

        $requestData = $request->all();

        

        PartnerPaymentHostory::create($requestData);



        return redirect('partner-payment-hostories')->with('flash_message', 'PartnerPaymentHostory added!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     *

     * @return \Illuminate\View\View

     */

    public function show($id)

    {

        $history = PartnerPaymentHostory::findOrFail($id);

        if($history->type == 'Cash In'){

            if($history->trip_type == 'trip'){

                $partnerpaymenthostory = PartnerPaymentHostory::with(['users', 'tripBooking' => function($q){

                    $q->with('user', 'trip');

                }])->where('trip_type', 'trip')->findOrFail($id);

            }else{

                $partnerpaymenthostory = PartnerPaymentHostory::with(['users', 'shipBooking' => function($q){

                    $q->with('user', 'trip');

                }])->where('trip_type', 'shipment')->findOrFail($id);

            }

        }else{

            $partnerpaymenthostory = PartnerPaymentHostory::findOrFail($id);

        }

        



        // dd($partnerpaymenthostory);



        return view('partner-payment-hostories.show', compact('partnerpaymenthostory'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     *

     * @return \Illuminate\View\View

     */

    public function edit($id)

    {

        $partnerpaymenthostory = PartnerPaymentHostory::findOrFail($id);



        return view('partner-payment-hostories.edit', compact('partnerpaymenthostory'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param \Illuminate\Http\Request $request

     * @param  int  $id

     *

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     */

    public function update(Request $request, $id)

    {

        

        $requestData = $request->all();

        

        $partnerpaymenthostory = PartnerPaymentHostory::findOrFail($id);

        $partnerpaymenthostory->update($requestData);



        return redirect('partner-payment-hostories')->with('flash_message', 'PartnerPaymentHostory updated!');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     *

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     */

    public function destroy($id)

    {

        PartnerPaymentHostory::destroy($id);



        return redirect('partner-payment-hostories')->with('flash_message', 'PartnerPaymentHostory deleted!');

    }

}

