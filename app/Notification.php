<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{	
	protected $guarded = [];

	public function users(){
		return $this->belongsTo('App\User','item_id','id');
	}

}
