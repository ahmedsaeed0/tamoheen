<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PromoCode;

class PromoCodesController extends Controller
{

    public function get_promo_codes()
    {
        $codes = PromoCode::latest()->get();
        return response()->json([
            'status' => 'Success',
            'promo_codes' => $codes,
            'code' => 201
        ], 201);
    }

    public function promo_code_validation(Request $request)
    {
        $count = PromoCode::where('code', $request->input('code'))->count();
        if ($count > 0) {
            $promo_code = PromoCode::where('code', $request->input('code'))->first();
            return response()->json([
                'status' => 'Success',
                'detail' => $promo_code,
                'code' => 201
            ], 201);
        } else {
            return response()->json([
                'status' => 'Failed',
                'code' => 201
            ], 201);
        }
    }
}
