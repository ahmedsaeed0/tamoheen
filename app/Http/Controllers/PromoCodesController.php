<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoCode;
use Illuminate\Support\Str;

class PromoCodesController extends Controller
{
    public function index(){
        $promo_codes = PromoCode::latest()->paginate(25);
        return view('promo-codes.index', compact('promo_codes'));
    }

    public function create()
    {
        $code = Str::random(6);
        return view('promo-codes.create', compact('code'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'code' => 'required|string|unique:promo_codes',
            'type' => 'required|string',
            'amount' => 'nullable|required_if:type,amount|integer',
            'percent' => 'nullable|required_if:type,percent|integer',
        ]);
        $requestData = $request->all();

        PromoCode::create($requestData);

        return redirect('promo-codes')->with('success', 'PromoCode added!');
    }

    public function edit($id)
    {
        
        $promocode = PromoCode::findOrFail($id);
        $code = Str::random(length: 6);
        // dd($code);
        return view('promo-codes.edit', compact('promocode', 'code'));
    }

    public function update(Request $request, $id)
    {
        // dd( $request->all());
        $this->validate($request, [
            'code' => 'string|unique:promo_codes',
            'type' => 'string',
            'amount' => 'nullable|required_if:type,amount|integer',
            'percent' => 'nullable|required_if:type,percent|integer',
        ]);
        $requestData = $request->all();

        $promocode = PromoCode::findOrFail($id);
        $promocode->update($requestData);

        return redirect('promo-codes')->with('success', 'PromoCode updated!');
    }

    public function destroy($id)
    {
        PromoCode::destroy($id);

        return redirect('promo-codes')->with('success', 'PromoCode deleted!');
    }


}
