<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
           return view('wall');
    }


    /**
     * User Wall
     * @return \Illuminate\Http\Response
     */
    public function user(){
       return view('profile');
    }

}
