<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_types';

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
    // protected $fillable = ['name', 'name_arabic', 'name_urdu'];
    protected $fillable = ['name', 'name_arabic'];

    public function tripProductTypes()
    {
        return $this->belongsToMany(\App\Models\ProductType::class, 'trip_product_type', 'product_type_id', 'trip_id');
    }
}
