<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Friend;
use App\User;
use Auth;
use Validator;
use App\Notification;
use Illuminate\Support\Facades\Log;
use Abraham\TwitterOAuth\TwitterOAuth;
use Image;
use Illuminate\Support\Facades\Input;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = (array) $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
           return response($validator->errors(),401);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' =>  $request->input('email'),
            'password' => bcrypt( $request->input('password')),
        ]);

        if($user){
            Auth::loginUsingId($user->id);
        }

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
    public function getProfile($id)
    {

            $friend = \App\Friend::where(function ($query) use ($id) {
                    $query->where('f1', '=', Auth::id())
                          ->where('f2', '=', $id);
                })
                ->orWhere(function ($query) use ($id) {
                    $query->where('f2', '=', Auth::id())
                          ->where('f1', '=', $id);
                })->get()->first();

       $user    = User::findorFail($id);
       $rights  = explode(',', $user->brights);

       return ['user'=>$user,'friend'=> $friend,'rights'=>$rights];
    }

    function getUser(){
       return auth()->user();
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
    
    }

    /**
     * Logout 
     *
     * @param  int  $id
     * @return null
     */
    public function logout()
    {
        return Auth::logout();
    }

    /**
     * Validate Email 
     *
     * @param  Request $request
     * @return null
     */
    public function validateEmail(Request $request)
    {   

        $user = User::where("email",$request->input('email'))->count();
        return $user > 0 ? response('Email is already in Use', 401) : "ok";
    }


    /**
     * API login
     * @param  Request $request 
     * @return json
     */
    /*public function login(Request $request){
        
        $data = (array) $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
           return response($validator->errors(),401);
        }


        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);  



    }*/
 /**
  * 
     * Logout 
     *
     * @param  int  $id
     * @return null
     */
    public function getUserDetails()
    {   
       return ['user'=>auth()->user(),'notcount'=>Notification::where('user_id',Auth::id())->count()];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {

        $data = (array) $request->all();

        $validator = Validator::make($data, [
            'brights' => 'required',
            'name' => 'required',
        ]);


        if ($validator->fails()) {
           return response($validator->errors(),401);
        }

        User::where('id',Auth::id())->update([
            'brights' => $request->input('brights'),
            'name' =>  $request->input('name'),
        ]);

     

    }


 /**
  * 
     * Logout 
     *
     * @param  int  $id
     * @return null
     */
    public function authcheck(Request $request)
    {   
       # Log::info($request->all());
        
        if(auth()->user()){
            $pusher = \Illuminate\Support\Facades\App::make('pusher');
            $data =  $pusher->socket_auth($_POST['channel_name'], $_POST['socket_id']);
            #Log::info($data);
            return  $data;
        }

        header('', true, 403);
        echo "Forbidden";
    }

    function twitterAuth(Request $request){
        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'));
        // request token of application
        $request_token = $connection->oauth(
            'oauth/request_token', [
                'oauth_callback' => env('TWITTER_CALLBACK')
            ]
        );

        // throw exception if something gone wrong
        if($connection->getLastHttpCode() != 200) {
            throw new \Exception('There was a problem performing this request');
        }
         

        // save token of application to session
         $request->session()->put('oauth_token', $request_token['oauth_token']);
         $request->session()->put('oauth_token_secret', $request_token['oauth_token_secret']);
         
        // generate the URL to make request to authorize our application
        $url = $connection->url(
            'oauth/authorize', [
                'oauth_token' => $request_token['oauth_token']
            ]
        );

        return redirect($url);

    }

    function twitterCallback(Request $request){

        #dd($_REQUEST);
        $oauth_verifier = $request->input('oauth_verifier');

        if (empty($oauth_verifier) ||
            empty(session('oauth_token')) ||
            empty(session('oauth_token_secret')))
         {
            dd("something's wrong");
        }


       $connection = new TwitterOAuth(
            env('TWITTER_CONSUMER_KEY'),
            env('TWITTER_CONSUMER_SECRET'),
            session('oauth_token'),
            session('oauth_token_secret')
        );
  
        // request user token
        $token = $connection->oauth(
            'oauth/access_token', [
                'oauth_verifier' => $oauth_verifier
            ]
        );

        $twitter = new TwitterOAuth(
            env('TWITTER_CONSUMER_KEY'),
            env('TWITTER_CONSUMER_SECRET'),
            $token['oauth_token'],
            $token['oauth_token_secret']
        );

        $user_info = $twitter->get('account/verify_credentials', array('include_email' => 'true'));

        $user = User::where('email',$user_info->email)->count();
        #print_r($user);
        #dd($user_info);
                    Log::info([
                'name' => $user_info->name,
                'email' =>  $user_info->email,
                'password' => bcrypt(str_random(8)),
                'oauth_provider' => 'twitter',
                'oauth_uid'=> $user_info->id,
                'oauth_secret' => $token['oauth_token_secret'],
                'oauth_token' => $token['oauth_token'],
                'oauth_username' => $user_info->screen_name
            ]);
                  #  exit;
        if($user < 1){

            $user = User::create([
                'name' => $user_info->name,
                'email' =>  $user_info->email,
                'password' => bcrypt(str_random(8)),
                'oauth_provider' => 'twitter',
                'oauth_uid'=> $user_info->id,
                'oauth_secret' => $token['oauth_token_secret'],
                'oauth_token' => $token['oauth_token'],
                'oauth_username' => $user_info->screen_name
            ]);
             # Log::info("+++++++++++++++++++++++++++++++++++++++++++++++++++++++");

    }else{
            #$user = User::where('email',)->get()->first();
            #dd($user);
            $user = User::where('email',$user_info->email)->update([
                'oauth_provider' => 'twitter',
                'oauth_uid'=> $user_info->id,
                'oauth_secret' => $token['oauth_token_secret'],
                'oauth_token' => $token['oauth_token'],
                'oauth_username' => $user_info->screen_name
            ]);
          #Log::info("++++++++++----------------------------------------++++++");
          #Log::info($user);
          #Log::info("++++++++++----------------------------------------++++++");


        }
      #  dd($user);
        Auth::loginUsingId(User::where('email',$user_info->email)->get()->first()->id);
        return redirect('/auth/triggerlogin');
      /*  if($user){
        }


        print_r($user_info);
        $user = User::where("oauth_provider",'twitter')
                    ->where('oauth_uid',$user_info->id)->count();


*/




  
    }



    public function uploadImage(){
        $file = Input::file('file');
        if ($file!=null) {

            $ext = $file->getClientOriginalExtension();
            $image_name = str_random(15).'.'.$ext;
        }

        if (!file_exists(public_path().'/uploads/images')) {
            mkdir(public_path().'/uploads/images');
        }
        
        Image::make(Input::file('file'))->save(public_path().'/uploads/images/'.$image_name);

        #$user = User::where('profile_image',$image_name)->update([

        User::where('id',Auth::id())->update([
            'profile_image' => $image_name,
        ]);

        return ['image'=> $image_name];
    }


  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiProfileUpdate(Request $request)
    {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $validator = Validator::make([
            'brights' =>  $request->about,
            'name' => $request->profname
        ], [
            'brights' => 'required',
            'name' => 'required',
        ]);


        if ($validator->fails()) {
           return response($validator->errors(),401);
        }

        if(User::where('id',Auth::id())->update([
            'brights' => $request->about,
            'name' =>  $request->profname,
        ])){

            return "OK";
        }

     

    }


  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apiGetProfile()
    {



       $user    = User::findorFail(Auth::id());
       $rights  = explode(',', $user->brights);

       return $user;

    }






}
