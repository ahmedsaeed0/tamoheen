<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trip;
use App\Models\User;

class Complain extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'complains';

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
    protected $fillable = ['trip_id', 'complain_from_id', 'complain_to_id', 'title', 'title_arabic', 'title_urdu', 'description', 'description_arabic', 'description_urdu'];

    public function complainsFrom()
    {
    	return $this->belongsTo(User::class, 'complain_from_id');
    }

    public function complainsTo()
    {
    	return $this->belongsTo(User::class, 'complain_to_id');
    }

    public function trip()
    {
    	return $this->belongsTo(Trip::class, 'trip_id');
    }
}
