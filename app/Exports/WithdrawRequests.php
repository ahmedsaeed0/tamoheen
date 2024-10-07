<?php

namespace App\Exports;

use App\Models\WithdrawRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class WithdrawRequests implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WithdrawRequest::with('user', 'paymentMethod')->where('status', 1)->latest()->get();
    }
}
