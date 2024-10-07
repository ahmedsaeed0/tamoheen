<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class Order extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
    protected $fillable = ['user_id', 'total_price', 'final_price', 'payment_method', 'estimated_time', 'order_status'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function cartOrders()
    {
    	return $this->belongsToMany(Cart::class, 'cart_order', 'order_id', 'cart_id');
    }

    public function address()
    {
        return $this->belongsTo(\App\Models\Address::class, 'address_id');
    }
    
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

}
