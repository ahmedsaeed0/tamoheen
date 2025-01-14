<?php

namespace App\Exports;

use App\Models\Page;
use Maatwebsite\Excel\Concerns\FromCollection;

class Pages implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Page::all();
    }
}
