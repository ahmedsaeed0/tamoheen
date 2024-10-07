<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\WithdrawRequest;
use App\Models\PartnerPaymentMethod;
use App\Models\PartnerPaymentHostory;
use App\Models\PartnerAmount;
use App\Models\TripBooking;
use Illuminate\Http\Request;
use Auth;

class WithdrawRequestsController extends Controller
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

        if (!empty($keyword)) {
            $withdrawrequests = WithdrawRequest::where('partner_id', 'LIKE', "%$keyword%")
                ->orWhere('payment_method', 'LIKE', "%$keyword%")
                ->orWhere('amount', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            //$withdrawrequests = WithdrawRequest::with('user', 'paymentMethod')->where('status', 1)->latest()->paginate($perPage);
            $withdrawrequests = WithdrawRequest::with(['user' => function ($query) {
                $query->select('id', 'name');
            }, 'paymentMethod'])
                ->join('users', 'withdraw_requests.partner_id', '=', 'users.id')
                ->where('withdraw_requests.status', 1)
                ->orderBy('withdraw_requests.created_at', 'desc')
                ->paginate($perPage);
        }

        return view('withdraw-requests.index', compact('withdrawrequests'));
    }

    public function pendingList(Request $request)
    {
        $perPage = 25;
        //$withdrawrequests = WithdrawRequest::with('user', 'paymentMethod')->where('status', 0)->latest()->paginate($perPage);
        $withdrawrequests = WithdrawRequest::with(['user' => function ($query) {
            $query->select('id', 'name');
        }, 'paymentMethod'])
            ->join('users', 'withdraw_requests.partner_id', '=', 'users.id')
            ->where('withdraw_requests.status', 0)
            ->orderBy('withdraw_requests.created_at', 'desc')
            ->paginate($perPage);

        return view('withdraw-requests.pending-list', compact('withdrawrequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        $partner_amount = TripBooking::whereHas('trip', function($trip){
            $trip->where('user_id', Auth::id());
        })->where('status', 4)->sum('partner_price');
       
        $methods = PartnerPaymentMethod::where('user_id', Auth::id())->pluck('name', 'id');
        
        return view('withdraw-requests.create', compact('methods', 'partner_amount'));
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
        
        $this->validate($request, [
            'payment_method' => 'required|exists:partner_payment_methods,id|integer',
            'amount' => 'required'
        ]);

        $amount = $request->amount;
        $partnerAmount = PartnerAmount::where('partner_id', Auth::id())->first();
    
        if($partnerAmount != null){
            if($partnerAmount->total_amount == 0){
                return redirect('withdraw-requests')->with('danger', 'Insufficient Amount!');
            }else{
                if($partnerAmount->total_amount >= $amount){
                    $withdraw = new WithdrawRequest();
                    $withdraw->partner_id = Auth::id();
                    $withdraw->payment_method = $request->payment_method;
                    $withdraw->amount = $request->amount;
                    $withdraw->status = false;
                    $withdraw->save();

                    $partner_payment_history = new PartnerPaymentHostory();
                    $partner_payment_history->user_id = Auth::id();
                    $partner_payment_history->type = 'Withdraw';
                    $partner_payment_history->price = $amount;
                    $partner_payment_history->save();

                    $update_amount = $partnerAmount->total_amount-$amount;
                    $partnerAmount->total_amount = $update_amount;
                    $partnerAmount->save();

                    return redirect('pending-withdraw-requests')->with('success', trans('withdraw-request-ts.added'));
                }else{
                    return redirect('withdraw-requests')->with('danger', trans('withdraw-request-ts.danger'));
                }
            }

        }else{
            return redirect('withdraw-requests')->with('danger', trans('withdraw-request-ts.danger'));
        }


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
        $withdrawrequest = WithdrawRequest::findOrFail($id);

        return view('withdraw-requests.show', compact('withdrawrequest'));
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
        $withdrawrequest = WithdrawRequest::findOrFail($id);

        return view('withdraw-requests.edit', compact('withdrawrequest'));
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
        $this->validate($request, [
            'payment_method' => 'exists:partner_payment_methods,id',
            'amount' => 'string'
        ]);

        $requestData = $request->all();

        $withdrawrequest = WithdrawRequest::findOrFail($id);
        $withdrawrequest->update($requestData);

        return redirect('withdraw-requests')->with('success', trans('withdraw-request-ts.updated'));
    }

    public function withdrawAccept($id)
    {
        $withdrawrequest = WithdrawRequest::findOrFail($id);
        $withdrawrequest->status = true;
        $withdrawrequest->save();
        return redirect('withdraw-requests')->with('success', trans('withdraw-request-ts.accepted'));
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
        WithdrawRequest::destroy($id);

        return redirect('withdraw-requests')->with('success', trans('withdraw-request-ts.deleted'));
    }
}
