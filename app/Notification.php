<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{	
	protected $guarded = [];

	public function users(){
		return $this->belongsTo('App\User','item_id','id');
	}

    /**
     * Humanize Timestamp
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

}
