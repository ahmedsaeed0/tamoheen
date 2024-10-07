<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\City;
use App\Models\Car;
use App\Models\Complain;
use App\Models\Review;
use App\Models\TripBooking;
use App\Models\ShipmentBooking;
use App\Models\Passenger;

class Trip extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trips';

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
    // protected $fillable = ['user_id', 'city_from_id', 'city_to_id', 'title', 'title_arabic', 'title_urdu', 'description', 'description_arabic', 'description_urdu', 'date', 'price_per_person', 'start_point', 'end_point', 'car_id'];
    protected $fillable = ['user_id', 'city_from_id', 'city_to_id', 'title','description', 'description_arabic', 'date', 'price_per_person', 'start_point', 'end_point', 'car_id'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function cityFrom()
    {
    	return $this->belongsTo(City::class, 'city_from_id');
    }

    public function cityTo()
    {
    	return $this->belongsTo(City::class, 'city_to_id');
    }

    public function complains()
    {
        return $this->hasMany(Complain::class, 'trip_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'trip_id');
    }

    public function tripBookings()
    {
        return $this->hasMany(TripBooking::class, 'trip_id');
    }

    public function shipmentBookings()
    {
        return $this->hasMany(ShipmentBooking::class, 'trip_id');
    }

    public function Passengers()
    {
        return $this->hasMany(Passenger::class, 'trip_id');
    }

    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function tripProductTypes()
    {
        return $this->belongsToMany(\App\Models\ProductType::class, 'trip_product_type', 'trip_id', 'product_type_id');
    }

    public function feature()
    {
        return $this->belongsTo(\App\Models\Feature::class, 'feature_id');
    }
}
