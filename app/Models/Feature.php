<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'features';

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
    // protected $fillable = ['name', 'name_arabic', 'name_urdu', 'is_main', 'note', 'icon'];
    protected $fillable = ['name', 'name_arabic', 'is_main', 'note', 'icon'];

    public function carFeatures()
    {
        return $this->belongsToMany(\App\Models\Car::class, 'car_features', 'feature_id', 'car_id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function trip()
    {
        return $this->hasOne(\App\Models\Trip::class, 'feature_id');
    }
}
