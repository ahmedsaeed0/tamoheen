<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class admins implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::whereHas('roles', function($role){
            // $role->whereNotIn('name', '!=', 'admin');
            $role->whereIn('name',['admin', 'sub_admin']);
        })->latest()->get();
    }
}
