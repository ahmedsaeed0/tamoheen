<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Image;

class Car extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cars';

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
    // protected $fillable = ['name', 'name_arabic', 'name_urdu', 'capacity_of_person', 'capacity_of_bag', 'is_food', 'is_drinks', 'is_wify', 'is_baby', 'is_smoking'];
    protected $fillable = ['name', 'name_arabic', 'capacity_of_person', 'capacity_of_bag', 'is_food', 'is_drinks', 'is_wify', 'is_baby', 'is_smoking'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function trips()
    {
        return $this->hasOne(\App\Models\Trip::class, 'car_id');
    }

    public function carFeatures()
    {
        return $this->belongsToMany(\App\Models\Feature::class, 'car_features', 'car_id', 'feature_id');
    }

    public function features()
    {
        return $this->hasMany(\App\Models\CarFeature::class, 'car_id');
    }
}
