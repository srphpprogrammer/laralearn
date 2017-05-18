<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
class Friend extends Authenticatable
{
   protected $guarded = [];

   /**
    * Get IDs of Friends
    * @return bool Array of IDs
    */
   static function getFriends(){

   		$authId = Auth::id();
   		$result =  DB::table('friends')
                     ->select(DB::raw("IF(f1 = $authId, f2, f1) as friendid"))
                     ->join('users as u1','u1.id','=','f1')
                     ->join('users as u2','u2.id','=','f2')
                     ->where('f1', '=', $authId)
                      ->where('is_confirmed',1)
		          	     ->orWhere('f2', '=', $authId)
                     ->get();

        $result = collect($result);
        $result = $result->pluck('friendid');
       	return $result->toArray();

   }

}
