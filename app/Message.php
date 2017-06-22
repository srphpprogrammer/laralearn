<?php

namespace App;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
   protected $guarded = [];

   /**
    * Get IDs of Friends
    * @return bool Array of IDs
    */
   static function getMessages($friendId){

   		$authId = Auth::id();
   		$result =  DB::table('messages')
                     ->select(DB::raw("messages.*, 
                      u1.name as u1name, 
                      u2.name as u2name,
                      u1.profile_image as u1image,
                      u2.profile_image as u2image
                      "))
                     ->join('users as u1','u1.id','=','messages.user_id')
                     ->join('users as u2','u2.id','=','messages.user_to_id')
                      ->where(function ($query) use ($friendId) {
                        $query->where('messages.user_id', '=', Auth::id())
                              ->where('messages.user_to_id', '=', $friendId);
                      })
                      ->orWhere(function ($query) use ($friendId) {
                        $query->where('messages.user_to_id', '=', Auth::id())
                              ->where('messages.user_id', '=', $friendId);
                      })
                      ->orderBy('messages.id','desc')
                      #->where('is_confirmed',1)
                      ->get();

        $responseArray = [];
        foreach ($result as $r) {
          $r->created_at = \Carbon\Carbon::parse($r->created_at)->diffForHumans();
          $responseArray[] = $r;
        }

        $result = collect($result);
        #$result = $result->pluck('friendid');
       	return $result->toArray();

   }






}
