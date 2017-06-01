<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Friend;
use App\Notification;
use App\Post;
use DB;
use App\Jobs\SendFriendRequestMail;
use Auth;

class NotificationActionController extends Controller
{


    function updateNotification(Request $request,$id){

        #dd($request->input('action'));
        $not = Notification::find($id);
        $not->is_read = 1;
        $not->save();

        $friendId = Notification::find($id)->item_id;

        $friend = Friend::where(function ($query) use ($friendId) {
            $query->where('f1', '=', Auth::id())
                  ->where('f2', '=', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('f2', '=', Auth::id())
                  ->where('f1', '=', $friendId);
        })->where('is_confirmed',0);
       

        $friend = $friend->get()->first();

        $friendRow = Friend::find($friend->id);    


       if($request->input('action')=="accept"){ 
                
            $friendRow->is_confirmed = 1;
            $friendRow->save();
            Notification::create([
                'user_id'       => $not->item_id    ,
                'item_id'      => Auth::id(),
                'description'   => User::find($not->user_id)->name.' has accepted your Friend Request'
            ]);
    
            return response("ok",200);

        }else{

            $friendRow->delete();
            return response("error",400);

        }

    }


    function getNotification($id){
        
        $friendId = Notification::find($id)->item_id;


        $friend = \App\Friend::where(function ($query) use ($friendId) {
            $query->where('f1', '=', Auth::id())
                  ->where('f2', '=', $friendId)->where('is_confirmed',0);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('f2', '=', Auth::id())
                  ->where('f1', '=', $friendId)->where('is_confirmed',0);
        })->get()->first();

        if(empty($friend)) return response("error",400);

        $friend = User::find(Notification::find($id)->item_id);



        return ['user'=>$friend];


    }


}
