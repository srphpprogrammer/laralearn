<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
Route::get('/mypage', function () {


use App\Friend;
use App\User;
use Auth;
    $user = App\User::all();

    $friends = Friend::getFriends();
    $friends[] = Auth::id();
    $limit      = 8;
    $offset     = 0;
    $users = User::whereNotIn('id',$friends)->limit(30)->offset(0)->orderBy('id','desc');

    return view('home');




});
Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);
Route::get('/getauthinfo', function() {

  return auth()->user();

}); 
*/

//
use Illuminate\Support\Facades\Log;
Route::group(['middleware' => \Barryvdh\Cors\HandleCors::class], function(){

    //Route::post('/api/profile', 'Auth\AuthController@jwtverify');

/*Route::post('/api/profile',function(){
    Log::info('called profile update');

    return response(["status"=>"success"]);


});*/

    Route::post('/api/auth/register', 'Auth\AuthController@jwtregister');
    Route::get('/api/auth/verify', 'Auth\AuthController@jwtverify');
    Route::post('/api/auth/login', 'Auth\AuthController@jwtprotected');
    Route::get('/api/activity', 'WallController@getApiPosts');


    Route::post('/api/auth/xregister', function() {

        //token after register success 
        return ["user" => "Antony","token"=>"randomstring"];

        //username already exists
        return response(["status"=>"error"],500)
        ->header('Content-Type', 'application/json');
        


        return response([],400);
    }); 

}); 

    
Route::group(['middleware' => [\Barryvdh\Cors\HandleCors::class,'jwt.auth']], function(){

    Route::post('/api/auth/profile', 'UserController@apiProfileUpdate');
    Route::get('/api/auth/mobprofile', 'UserController@apiGetProfile');


}); 


Route::get('/', 'HomeController@index');



Route::post('api/posts', 'WallController@getPosts');

Route::get('api/profile/{id}', 'UserController@getProfile');
Route::post('api/posts/create', 'WallController@create');


Route::get('api/validateemail/', 'UserController@validateEmail');

Route::post('api/user/edit/create', 'UserController@updateUser');
Route::get('api/user/edit', 'UserController@getUser');
Route::post('api/user/edit', 'UserController@updateProfile');

Route::post('api/messages/create', 'MessageController@create');
Route::get('api/messages/{id}', 'MessageController@get');


Route::post('api/search/{id}', 'SearchController@index');

Route::post('api/friend/request', 'FriendController@requestAction');
Route::post('api/friends', 'FriendController@friends');



Route::get('api/user/logout', 'UserController@logout');

Route::post('api/user/image' , 'UserController@uploadImage');

Route::post('api/user/create', 'UserController@create');
Route::post('api/user/login', 'Auth\AuthController@login');
Route::get('api/user/auth', 'UserController@getUserDetails');
Route::post('api/notifications', 'HomeController@notifications');
Route::get('api/notification/{id}', 'NotificationActionController@getNotification');
Route::post('api/notification/{id}', 'NotificationActionController@updateNotification');

Route::post('api/authcheck', 'UserController@authcheck');
Route::get('auth/login/twitter', 'UserController@twitterAuth');
Route::get('auth/twittercallback', 'UserController@twitterCallback');

Route::get('terms', function() {

  echo "Twitter Terms here";

});


Route::get('/bridge', function() {

    $pusher = Illuminate\Support\Facades\App::make('pusher');

    $pusher->trigger( 'private-lara',
                      'test-event', 
                      array('text' => 'Preparing the Pusher Laracon.eu workshop!'));

return 1;
});



Route::get('/partials/{category}/', function ($category) {
    return view(join('.', ['partials', $category]));
});

Route::any('{path?}', function()
{
    return view("index");
})->where("path", ".+");




/**



Route::group(['middleware' => ['throttle:5', 'auth:api']], function () {

    Route::get('/user/', function ()    {
       dd(["name"=>'Alan']);
    });

    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });	

});


if(false) {

Route::auth();

Route::get('/angular', function () {
    return view('index');
});
Route::get('/wall', 'HomeController@wall');
Route::get('/user/{id}', 'HomeController@user');
Route::get('/profile/edit', 'HomeController@edit');
Route::post('/profile/edit', 'HomeController@update');

Route::get('/notifications', 'HomeController@notifications');
Route::get('/notification/action/{id}', 'HomeController@showNotificationItem');
Route::post('/notification/action/{id}', 'HomeController@updateNotificationItem');

Route::post('/profile/friend', 'HomeController@friend');
Route::post('status', 'HomeController@status');





Route::get('/search', 'SearchController@index');



}

*/