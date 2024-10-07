<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class users implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  User::whereHas('roles', function($role){
            // $role->where('name', '!=', 'admin');
            $role->where('name', '=', 'user');
        })->latest()->get();
    }
}
