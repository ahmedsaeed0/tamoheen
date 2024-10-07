<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sliders';

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
    // protected $fillable = ['title', 'title_urdu', 'title_arabic', 'description', 'description_urdu', 'description_arabic', 'status'];
    protected $fillable = ['title', 'title_arabic', 'description', 'description_arabic', 'status'];

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

}
