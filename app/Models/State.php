<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    // protected $fillable = ['name', 'name_arabic', 'name_urdu', 'country_id'];
    protected $fillable = ['name', 'name_arabic', 'country_id'];

    public function countries()
    {
    	return $this->belongsTo(\App\Models\Country::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(\App\Models\City::class, 'state_id');
    }

    public function address()
    {
        return $this->hasMany(\App\Models\Address::class, 'state_id');
    }
}
