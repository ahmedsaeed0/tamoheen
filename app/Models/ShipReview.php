<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\ShipmentBooking;

class ShipReview extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ship_reviews';

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
    protected $fillable = ['ship_booking_id', 'from_id', 'to_id', 'rating', 'review'];

    public function tripBooking()
    {
    	return $this->belongsTo(ShipmentBooking::class, 'ship_booking_id');
    }

    public function ratingShipFrom()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function ratingShipTo()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
