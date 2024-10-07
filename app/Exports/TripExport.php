<?php

namespace App\Exports;

use App\Models\Trip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TripExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Trip::all(); // Retrieve data from the Trip model
    }


    public function headings(): array
    {
        // Define the column headers for the Excel file
        return ['user_id', 'city_from_id', 'city_to_id' , 'car_id ','title','title_arabic','title_urdu' , 'description' , 'description_arabic','description_urdu','date','drop_off_time','price_per_person','price_per_bag','pickup_location','number_of_person','number_of_bag','available_of_person','available_of_bag','type','feature_id','status','start_point','end_point','discount','deleted_at','created_at','updated_at','cancel_date']; // Replace with your desired column headers
    }
}
