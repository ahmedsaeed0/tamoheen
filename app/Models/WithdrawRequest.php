<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawRequest extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'withdraw_requests';

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
    protected $fillable = ['partner_id', 'payment_method', 'amount'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'partner_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(\App\Models\PartnerPaymentMethod::class, 'payment_method');
    }

    
}
