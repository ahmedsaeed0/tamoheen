<?php

namespace App\Exports;

use App\Models\Feature;
use Maatwebsite\Excel\Concerns\FromCollection;

class features implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Feature::all();
    }
}
