<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

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
    // protected $fillable = ['name', 'name_arabic', 'name_urdu', 'code', 'code_arabic', 'code_urdu'];
    protected $fillable = ['name', 'name_arabic', 'code', 'code_arabic'];

    public function states()
    {
        return $this->hasMany(\App\Models\State::class, 'country_id');
    }

    public function address()
    {
        return $this->hasMany(\App\Models\Address::class, 'country_id');
    }
}
