<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use JWTAuth;
use Response;
use Input;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
      $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
          ]);    
        if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
            return response(auth()->user(),200);    
        }
        return response("error",401);                  

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function jwtregister(Request $request)
    {   
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $validator = Validator::make([
            'email'=> $request->email,
            'password'=> $request->password,
            ], [
            'password' => 'required|min:5',
            'email' => 'required|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
           return response($validator->errors(),401);
        }

        try {

            $user = User::create([
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]);

        } catch (Exception $e) {

            return response(["status"=>"error"]);

        }

        $token = JWTAuth::fromUser($user);

        ///return response (compact('token'));
        return ["user" => $user->email,"token"=>$token];



    }

/**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function jwtprotected(Request $request)
    {   
                    $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
    $validator = Validator::make([
            'email'=> $request->email,
            'password'=> $request->password,
            ], [
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
           return response($validator->errors(),401);
        }

             try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                ])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

  $user = JWTAuth::toUser($token);


        ///return response (compact('token'));
        return ["user" => $user->email,"token"=>$token];
    }

  /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function jwtverify(Request $request)
    {   
              
      
    try {

        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

        return response()->json(['token_expired'], $e->getStatusCode());

    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

        return response()->json(['token_invalid'], $e->getStatusCode());

    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

        return response()->json(['token_absent'], $e->getStatusCode());

    }

    // the token is valid and we have found the user via the sub claim
    return response()->json(compact('user'));

    }





}
