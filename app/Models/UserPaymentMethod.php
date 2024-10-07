<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class UserPaymentMethod extends Model

{

    use SoftDeletes;

    /**

     * The database table used by the model.

     *

     * @var string

     */

    protected $table = 'user_payment_methods';



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

    protected $fillable = ['name', 'details'];



    public function users()

    {

        return $this->belongsTo(\App\Models\User::class, 'user_id');

    }



    public function withdraws()

    {

        return $this->hasMany(\App\Models\WithdrawRequest::class, 'payment_method');

    }



    

}