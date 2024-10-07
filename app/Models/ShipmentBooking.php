<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Trip;

class ShipmentBooking extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipment_bookings';

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
    protected $fillable = ['user_id', 'trip_id', 'number_of_bag', 'sender_title', 'sender_name', 'sender_email', 'sender_phone', 'sender_address', 'sender_address', 'is_payment_complete', 'payment_method', 'trx_id'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function trip()
    {
    	return $this->belongsTo(Trip::class, 'trip_id')->withTrashed();
    }

    public function reviews()
    {
        return $this->hasMany(ShipReview::class, 'ship_booking_id');
    }

    public function paymentHistory()
    {
        return $this->hasMany(\App\Models\PartnerPaymentHostory::class, 'booking_id');
    }
}
