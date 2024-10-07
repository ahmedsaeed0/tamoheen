<?php

namespace App\Exports;

use App\Models\TripBooking;
use Maatwebsite\Excel\Concerns\FromCollection;

class TripBookingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TripBooking::all();
    }
}
