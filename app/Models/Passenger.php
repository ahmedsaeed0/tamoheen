<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trip;

class Passenger extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'passengers';

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
    protected $fillable = ['trip_id', 'title', 'name', 'identity_type', 'identity_number', 'mobile', 'email'];

    public function trip()
    {
    	return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function tripBooking()
    {
        return $this->belongsTo(TripBooking::class, 'trip_booking_id');
    }
    
}
