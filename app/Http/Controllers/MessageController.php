<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Friend;
use App\User;
use App\Message;
use Auth;

class MessageController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'message' => 'required',
        ]);       

        $message = new Message();
        $message->message = $request->input('message');
        $message->user_id = Auth::id();
        $message->user_to_id = $request->input('id');
        $message->save();
/*
        $post = Post::with('user')->find($post->id);
        $pusher = \Illuminate\Support\Facades\App::make('pusher');
        $channels = [];
        $friends    = Friend::getFriends();
        foreach ($friends as $f) {
           $channels[] = 'private-larawall'.$f;
        }
        if(!empty($channels)){
            $pusher->trigger($channels,'newpost',$post);
        }*/


        return $message;
    }




    function get($friendId){
    

        $messages = Message::getMessages($friendId);


        return ['messages'=>$messages];


    }




}
