<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\TripBooking;
use App\Models\Trip;

class Review extends Model
{
   	use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reviews';

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
    protected $fillable = ['trip_booking_id', 'trip_id', 'from_id', 'to_id', 'rating', 'review'];

    public function tripBooking()
    {
    	return $this->belongsTo(TripBooking::class, 'trip_booking_id');
    }
    public function trip()
    {
    	return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function ratingFrom()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function ratingTo()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
