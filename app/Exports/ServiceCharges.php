<?php

namespace App\Exports;

use App\Models\ServiceCharge;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServiceCharges implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceCharge::all();
    }
}
