<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Friend;
use App\User;
use App\Post;
use Auth;
use JWTAuth;
class WallController extends Controller
{


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApiPosts(Request $request)
    {   
        $friends    = Friend::getFriendsApi();
        $friends[]  = 1;//JWTAuth::parseToken()->toUser()->id;
        //dd($friends);
        $limit      = 5;//$request->input('limit');
        $offset     = 0;//$request->input('offset');
        $posts      = Post::with('user')->whereIn('user_id',$friends)->limit(3)->offset($offset)->orderBy('id','desc')->get();
        return $posts;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPosts(Request $request)
    {   
        $friends    = Friend::getFriends();
        $friends[]  = Auth::id();
        $limit      = $request->input('limit');
        $offset     = $request->input('offset');
        $posts      = Post::with('user')->whereIn('user_id',$friends)->limit(3)->offset($offset)->orderBy('id','desc')->get();
        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);       

        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = Auth::id();
        $post->save();

        $post = Post::with('user')->find($post->id);
        $pusher = \Illuminate\Support\Facades\App::make('pusher');
        $channels = [];
        $friends    = Friend::getFriends();
        foreach ($friends as $f) {
           $channels[] = 'private-larawall'.$f;
        }
        if(!empty($channels)){
            $pusher->trigger($channels,'newpost',$post);
        }


        return $post;
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
}
