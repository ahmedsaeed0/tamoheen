<?php



namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Passport\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

use App\Models\PartnerMeta;

use App\Models\Car;

use App\Models\Trip;

use App\Models\Complain;

use App\Models\TripBooking;

use App\Models\ShipmentBooking;

use App\Models\Product;

use App\Models\Cart;

use App\Models\Order;

use App\Models\Address;

use App\Models\ShipReview;



class User extends Authenticatable

{

    use Notifiable, SoftDeletes, HasApiTokens, HasRoles;



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'name', 'email', 'password', 'mobile', 'identity_type', 'identity_number', 'title', 'language', 'status', 'referralcode', 'referralcodefrom'

    ];



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [

        'password', 'remember_token',

    ];



    /**

     * The attributes that should be cast to native types.

     *

     * @var array

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];



    public function partnerMetas()

    {

        return $this->hasOne(PartnerMeta::class, 'user_id');

    }



    public function cars()

    {

        return $this->hasMany(Car::class, 'user_id');

    }



    public function trips()

    {

        return $this->hasMany(Trip::class, 'user_id');

    }



    public function complainFroms()

    {

        return $this->hasMany(Complain::class, 'complain_from_id');

    }



    public function complainTos()

    {

        return $this->hasMany(Complain::class, 'complain_to_id');

    }



    public function tripBookings()

    {

        return $this->hasMany(TripBooking::class, 'user_id');

    }



    public function shipmentBookings()

    {

        return $this->hasMany(ShipmentBooking::class, 'user_id');

    }



    public function ratingFrom()

    {

        return $this->hasMany(Review::class, 'from_id');

    }



    public function ratingTo()

    {

        return $this->hasMany(Review::class, 'to_id');

    }



    public function ratingShipFrom()

    {

        return $this->hasMany(ShipReview::class, 'from_id');

    }



    public function ratingShipTo()

    {

        return $this->hasMany(ShipReview::class, 'to_id');

    }



    public function products()

    {

        return $this->hasMany(Product::class, 'user_id');

    }



    public function carts()

    {

        return $this->hasMany(Cart::class, 'user_id');

    }



    public function orders()

    {

        return $this->hasMany(Order::class, 'user_id');

    }



    public function image()

    {

        return $this->morphOne('App\Models\Image', 'imageable');

    }



    public function address()

    {

        return $this->hasMany(Address::class, 'user_id');

    }



    public function paymentMethods()

    {

        return $this->hasMany(\App\Models\PartnerPaymentMethod::class, 'user_id');

    }



    public function paymentHistory()

    {

        return $this->hasMany(\App\Models\PartnerPaymentHostory::class, 'user_id');

    }



    public function partnerAmount()

    {

        return $this->hasOne(\App\Models\PartnerAmount::class, 'partner_id');

    }



    public function withdraws()

    {

        return $this->hasMany(\App\Models\WithdrawRequest::class, 'partner_id');

    }

}

