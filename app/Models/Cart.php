<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

use App\Models\Product;



class Cart extends Model

{

    // use SoftDeletes;

    /**

     * The database table used by the model.

     *

     * @var string

     */

    protected $table = 'carts';



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

    protected $fillable = ['user_id', 'product_id', 'quantity', 'price', 'is_cart'];



    public function user()

    {

    	return $this->belongsTo(User::class, 'user_id');

    }



    public function product()

    {

    	return $this->belongsTo(Product::class, 'product_id');

    }



    public function cartOrders()

    {

        return $this->belongsToMany(Order::class, 'cart_order', 'cart_id', 'order_id');

    }

}

