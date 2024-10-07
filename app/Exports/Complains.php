<?php

namespace App\Exports;

use App\Models\Complain;
use Maatwebsite\Excel\Concerns\FromCollection;

class Complains implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Complain::all();
    }
}
