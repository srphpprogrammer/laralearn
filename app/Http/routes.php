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



Route::get('/', 'HomeController@index');
Route::get('/wall', 'HomeController@wall');
Route::get('/user/{id}', 'HomeController@user');

Route::group(['middleware' => ['throttle:5', 'auth:api']], function () {

    Route::get('/user/', function ()    {
       dd(["name"=>'Alan']);
    });

    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });	

});

Route::auth();
