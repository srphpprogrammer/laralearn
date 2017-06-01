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
class FriendController extends Controller
{


    public function requestAction(Request $request)
    {


        $id     = $request->input('userid');

        if($request->input('action') == 'sfr'){

            $friend = Friend::where(function ($query) use ($id) {
                            $query->where('f1', '=', Auth::id())
                                  ->where('f2', '=', $id);
                        })
                        ->orWhere(function ($query) use ($id) {
                            $query->where('f2', '=', Auth::id())
                                  ->where('f1', '=', $id);
                        })->get()->first();

            if(empty($friend)){

                $friend = new Friend();
                $friend->f1 = Auth::id();
                $friend->f2 = $id;
                $friend->save();

                Notification::create([
                    'user_id'       => $id,
                    'item_id'      => Auth::id(),
                    'description'   => Auth::user()->name.' has sent you a friend request'
                ]);

                $job = (new SendFriendRequestMail([
                    'content'   => 'Hello!, Just want to let you know that '.Auth::user()->name.' has sent you a friend request :)',
                    'to'        => User::find($id)->email,
                    'name'      => User::find($id)->name,
                ]))->delay(\Carbon\Carbon::now()->addSeconds(5));

                dispatch($job);
                return response("ok",200);

            }

        }

        if($request->input('action') == 'unfriend' || $request->input('action') == 'cfr'){

            $friend = \App\Friend::where(function ($query) use ($id) {
                    $query->where('f1', '=', Auth::id())
                          ->where('f2', '=', $id);
                })
                ->orWhere(function ($query) use ($id) {
                    $query->where('f2', '=', Auth::id())
                          ->where('f1', '=', $id);
                })->delete();
            return response("ok",200);
                    
        }

        return response("error",401);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function friends(Request $request)
    {   

        $friends = Friend::getFriends();
        #$friends[] = Auth::id();
       /* $limit      = $request->input('limit');
        $offset     = $request->input('offset');*/
        $limit      = 8;
        $offset     = 0;
     
        $users = User::whereIn('id',$friends)->where('id','<>',Auth::id())->limit($limit)->offset($offset)->orderBy('id','desc')
->get();

 


       return $users;
    }







}
