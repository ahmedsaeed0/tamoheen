<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

use App\Models\Trip;

use App\Models\Review;

use App\Models\Passenger;



class TripBooking extends Model

{

    use SoftDeletes;

    /**

     * The database table used by the model.

     *

     * @var string

     */

    protected $table = 'trip_bookings';



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

    protected $fillable = ['user_id', 'trip_id', 'number_of_passengers', 'price', 'cancel_date','is_payment_complete', 'status', 'payment_method', 'transaction_id', 'check_in', 'check_out'];



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

        return $this->hasMany(Review::class, 'trip_booking_id');

    }



    public function passengers()

    {

        return $this->hasMany(Passenger::class, 'trip_booking_id');

    }



    public function paymentHistory()

    {

        return $this->hasMany(\App\Models\PartnerPaymentHostory::class, 'booking_id');

    }

}

