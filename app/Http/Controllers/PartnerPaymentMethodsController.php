<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\PartnerPaymentMethod;
use Illuminate\Http\Request;
use Auth;

class PartnerPaymentMethodsController extends Controller
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
            $partnerpaymentmethods = PartnerPaymentMethod::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('details', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $partnerpaymentmethods = PartnerPaymentMethod::where('user_id', Auth::id())->latest()->paginate($perPage);
        }

        return view('partner-payment-methods.index', compact('partnerpaymentmethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $methods = PartnerPaymentMethod::where('user_id', Auth::id())->pluck('name', 'id');
        return view('partner-payment-methods.create',compact('methods'));
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
            'name' => 'required|string',
            'details' => 'required|string|max:255',
        ]);
        $partnerpaymentmethod = new PartnerPaymentMethod();
        $partnerpaymentmethod->user_id = Auth::id();
        $partnerpaymentmethod->name = $request->name;
        $partnerpaymentmethod->details = $request->details;
        $partnerpaymentmethod->save();

        return redirect('partner-payment-methods')->with('success', trans('partner-payment-method-ts.added'));
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
        $partnerpaymentmethod = PartnerPaymentMethod::findOrFail($id);

        return view('partner-payment-methods.show', compact('partnerpaymentmethod'));
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
        $partnerpaymentmethod = PartnerPaymentMethod::findOrFail($id);

        return view('partner-payment-methods.edit', compact('partnerpaymentmethod'));
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
            'name' => 'string',
            'details' => 'string|max:255',
        ]);

        $requestData = $request->all();

        $partnerpaymentmethod = PartnerPaymentMethod::findOrFail($id);
        $partnerpaymentmethod->update($requestData);

        return redirect('partner-payment-methods')->with('success', trans('partner-payment-method-ts.updated'));
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
        PartnerPaymentMethod::destroy($id);

        return redirect('partner-payment-methods')->with('success', trans('partner-payment-method-ts.deleted'));
    }
}
