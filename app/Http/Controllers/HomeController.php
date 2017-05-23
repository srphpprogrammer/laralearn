<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Friend;
use App\Post;
use DB;
use App\Notification;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Larabook HomePage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::loginUsingId(1);

       return view('index');

    	if(Auth::check()){
    		return redirect('wall');
    	} 
    	

        return view('auth.register',[
        	'page'=> 'homepage'
        ]);
    }


    /**
     * User Wall
     * @return \Illuminate\Http\Response
     */
    public function wall(){

    	$friends = Friend::getFriends();
    	$friends[] = Auth::id();
        
	    $posts = Post::with('user')->whereIn('user_id',$friends)   ->orderBy('id','desc')->paginate(3);
        return view('wall',['posts'=>$posts]);
    }

 	/**
     * Post Status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(Request $request){
	    $this->validate($request, [
	        'status' => 'required',
	    ]);       

	    $post = new Post();
	    $post->content = $request->input('status');
	    $post->user_id = Auth::id();
	    $post->save();
	    return back();
    }

    /**
     * User Profile
     * @return \Illuminate\Http\Response
     */
    public function user($id){ 

       $friend = \App\Friend::where(function ($query) use ($id) {
				    $query->where('f1', '=', Auth::id())
				          ->where('f2', '=', $id);
				})
				->orWhere(function ($query) use ($id) {
				    $query->where('f2', '=', Auth::id())
				          ->where('f1', '=', $id);
				})->get()->first();

       $user = User::findorFail($id);
       $rights = explode(',', $user->brights);

       return view('profile',['user'=>$user,'friend'=> $friend,'rights'=>$rights]);

    }

    /**
     * User Edit Page
     * @return \Illuminate\Http\Response
     */
    function edit(){
       return view('useredit',['user'=>User::find(Auth::id())]);
    }

    /**
     * User Edit Update 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    function update(Request $request){
       $user = User::find(Auth::id());
       $user->brights = $request->input('brights');
       $user->name = $request->input('name');
       $user->save();
       return redirect("wall");

    }

    /**
     * Friend Action
     * @return \Illuminate\Http\RedirectResponse
     */
    function friend(Request $request){


    	$id 	= $request->input('userid');

        if($request->input('action') == 'send'){

        	$friend = Friend::where(function ($query) use ($id) {
    					    $query->where('f1', '=', Auth::id())
    					          ->orWhere('f2', '=', $id);
    					})
    					->where(function ($query) use ($id) {
    					    $query->where('f2', '=', Auth::id())
    					          ->orWhere('f1', '=', $id);
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
    		}

        }

        if($request->input('action') == 'unfriend' || $request->input('action') == 'cancel'){

            $friend = \App\Friend::where(function ($query) use ($id) {
                    $query->where('f1', '=', Auth::id())
                          ->where('f2', '=', $id);
                })
                ->orWhere(function ($query) use ($id) {
                    $query->where('f2', '=', Auth::id())
                          ->where('f1', '=', $id);
                })->delete();
                    
        }


		return back();

    }

    function notifications(){
        $notifications = Notification::with('users')->where('user_id',Auth::id())->orderBy('id','desc')->get();
       return view('notifications',['notifications'=>$notifications]);

    }   


    function showNotificationItem($id){

        $friendId = Notification::find($id)->item_id;

        $friend = \App\Friend::where(function ($query) use ($friendId) {
            $query->where('f1', '=', Auth::id())
                  ->where('f2', '=', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('f2', '=', Auth::id())
                  ->where('f1', '=', $friendId);
        })->where('is_confirmed',0)->get()->first();
        #   dd($friend);
        if(empty($friend)) return redirect('/');
        $friend = User::find(Notification::find($id)->item_id);
        return view('accept',['friend'=>$friend]);
    }


    function updateNotificationItem(Request $request,$id){


        $not = Notification::find($id);
       $not->is_read = 1;
       $not->save();
    $friendId = Notification::find($id)->user_id;
              $friend = Friend::where(function ($query) use ($friendId) {
                            $query->where('f1', '=', Auth::id())
                                  ->orWhere('f2', '=', $friendId);
                        })
                        ->where(function ($query) use ($friendId) {
                            $query->where('f2', '=', Auth::id())
                                  ->orWhere('f1', '=', $friendId);
                        })->get()->first();
                       # dd($friend);

        $friendRow = Friend::find($friend->id);      

       if($request->input('action')=="accept"){ 
                
        $friendRow->is_confirmed = 1;
        $friendRow->save();



        Notification::create([
            'user_id'       => $not->item_id    ,
            'item_id'      => Auth::id(),
            'description'   => User::find($not->user_id)->name.' has accepted your Friend Request'
        ]);
    
        }else{

        $friendRow->delete();
       return redirect('/');


        }


       return redirect('/');
    }



}
