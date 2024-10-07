<?php

namespace App\Exports;

use App\Models\PromoCode;
use Maatwebsite\Excel\Concerns\FromCollection;

class promoCodes implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PromoCode::all();
    }
}
