<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Friend;
use App\User;
use Auth;
use Validator;

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

       $user = User::findorFail($id);
       $rights = explode(',', $user->brights);

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


}
