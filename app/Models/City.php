<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trip;
use App\Models\Image;
use App\Models\Address;

class City extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

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
    // protected $fillable = ['name', 'name_arabic', 'name_urdu', 'description', 'description_arabic', 'description_urdu', 'state_id'];
    protected $fillable = ['name', 'name_arabic', 'description', 'description_arabic', 'state_id'];

    public function states()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function tripFrom()
    {
        return $this->hasMany(Trip::class, 'city_from_id');
    }

    public function tripTo()
    {
        return $this->hasMany(Trip::class, 'city_to_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'city_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'city_id');
    }


}
