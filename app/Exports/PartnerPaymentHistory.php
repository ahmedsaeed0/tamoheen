<?php

namespace App\Exports;

use App\Models\PartnerPaymentHostory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;

class PartnerPaymentHistory implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        if($user->hasrole('partner')){
            return  PartnerPaymentHostory::where('user_id', $user->id)->with('users')->latest()->get();
        }else{
            return  PartnerPaymentHostory::with('users')->latest()->get();
        }

    }
}
