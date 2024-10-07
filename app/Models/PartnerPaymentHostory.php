<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerPaymentHostory extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partner_payment_hostories';

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
    protected $fillable = ['price', 'type'];

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function trips()
    {
        return $this->belongsTo(\App\Models\Trip::class, 'user_id');
    }


    public function tripBooking()
    {
        return $this->belongsTo(\App\Models\TripBooking::class, 'booking_id');
    }

    public function shipBooking()
    {
        return $this->belongsTo(\App\Models\ShipmentBooking::class, 'booking_id');
    }


    
}
