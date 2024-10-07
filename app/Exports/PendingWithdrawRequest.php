<?php

namespace App\Exports;

use App\Models\WithdrawRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class PendingWithdrawRequest implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WithdrawRequest::with('user', 'paymentMethod')->where('status', 0)->latest()->get();
    }
}
