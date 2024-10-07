<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Cart;

class Product extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
    // protected $fillable = ['name', 'name_arabic', 'name_urdu', 'description', 'description_arabic', 'description_urdu', 'price', 'status', 'user_id', 'category_id'];
    protected $fillable = ['name', 'name_arabic', 'description', 'description_arabic','price', 'status', 'user_id', 'category_id'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function categories()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

}
