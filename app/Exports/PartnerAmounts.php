<?php

namespace App\Exports;

use App\Models\PartnerAmount;
use Maatwebsite\Excel\Concerns\FromCollection;

class PartnerAmounts implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PartnerAmount::join('withdraw_requests', 'partner_amounts.partner_id', '=', 'withdraw_requests.partner_id')->get();
    }
}
