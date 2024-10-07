<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ServiceCharge;
use Illuminate\Http\Request;

class ServiceChargesController extends Controller
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
            $servicecharges = ServiceCharge::where('type', 'LIKE', "%$keyword%")
                ->orWhere('charge', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $servicecharges = ServiceCharge::latest()->paginate($perPage);
        }

        return view('service-charges.index', compact('servicecharges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('service-charges.create');
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
            'type'   => 'required|integer|unique:service_charges',
            'charge' => 'string',
        ]);

        $type = $request->type;
        $charge = ServiceCharge::where('type', $type)->first();
        if($charge != null){
            return redirect('service-charges')->with('warning', 'ServiceCharge Already added!');
        }else{
            $servicecharge = new ServiceCharge();
            $servicecharge->type = $type;
            $servicecharge->charge = $request->charge;
            $servicecharge->save();
            return redirect('service-charges')->with('success', 'ServiceCharge added!');
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
        $servicecharge = ServiceCharge::findOrFail($id);

        return view('service-charges.show', compact('servicecharge'));
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
        $servicecharge = ServiceCharge::findOrFail($id);

        return view('service-charges.edit', compact('servicecharge'));
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
            'type'   => 'integer|unique:service_charges,type,'.$id,
            'charge' => 'string',
        ]);
        $servicecharge = ServiceCharge::findOrFail($id);
        $servicecharge->type = $request->type;
        $servicecharge->charge = $request->charge;
        $servicecharge->save();

        return redirect('service-charges')->with('success', 'ServiceCharge updated!');
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
        ServiceCharge::destroy($id);

        return redirect('service-charges')->with('success', 'ServiceCharge deleted!');
    }
}
