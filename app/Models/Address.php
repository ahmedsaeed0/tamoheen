<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Country;

class Address extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

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
    protected $fillable = ['user_id', 'flat_no', 'location', 'pin_no', 'phone_no', 'city_id', 'state_id', 'country_id'];


    public function users()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function cities()
    {
    	return $this->belongsTo(City::class, 'city_id');
    }

    public function states()
    {
    	return $this->belongsTo(State::class, 'state_id');
    }

    public function countries()
    {
    	return $this->belongsTo(Country::class, 'country_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'address_id');
    }
    
}
