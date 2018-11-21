<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\User;

class AuthController extends Controller
{
    //
    public $loginAfterSignUp = false;

    /*
    |-------------------------------------------------------------------------------
    | Register a User
    |-------------------------------------------------------------------------------
    | URL:              /api/register
    | Method:           POST
    | Description:      Adds a new user to the application
    | Header:           Accept:application/json
    | Body(Form Data):  Name:Gede Darma, Email:de.darma.damuh@gmail.com, Password:darma@123
    */
	  public function register(RegisterAuthRequest $request)
    {        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
 
        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'status' => (['code' => '200','type' => 'Ok']),
            'message' => 'User registered successfully',
            'data' => array(['user' => $user]),
        ], 200);
    }

    /*
    |-------------------------------------------------------------------------------
    | User Login
    |-------------------------------------------------------------------------------
    | URL:              /api/login
    | Method:           POST
    | Description:      Login user to the application
    | Header:           Accept:application/json
    | Body(Form Data):  Email:de.darma.damuh@gmail.com, Password:darma@123
    */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'status' => (['code' => '401','type' => 'Unauthorized']),
                'message' => 'Invalid Email or Password',
                'data' => '',
            ], 200);
        }
 
        return response()->json([
            'status' => (['code' => '200','type' => 'Ok']),
            'message' => 'User logged in successfully',
            'data' => array(['token' => $jwt_token]),
        ], 200);
    }

    /*
    |-------------------------------------------------------------------------------
    | User Logout
    |-------------------------------------------------------------------------------
    | URL:              /api/logout
    | Method:           POST
    | Description:      Logout user from the application
    | Header:           Accept:application/json
    | Param:            Token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9tLWNvbW1lcmNlLnRlc3RcL2FwaVwvbG9naW4iLCJpYXQiOjE1NDI2ODk5MDAsImV4cCI6MTU0MjY5MzUwMCwibmJmIjoxNTQyNjg5OTAwLCJqdGkiOiI4eXU3OE9jQTF6eWx4VEtqIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.l9YC02EwGop_saZK2t5PuBp5bV5i3pgIJZs836-RNWE        
    */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'status' => (['code' => '200','type' => 'Ok']),
                'message' => 'User logged out successfully',
                'data' => '',
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => (['code' => '500','type' => 'Internal server error']),
                'message' => 'Sorry, the user cannot be logged out',
                'data' => '',
            ], 500);
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token); 

        return response()->json([
            'status' => (['code' => '200','type' => 'Ok']),
            'message' => '',
            'data' => array(['user' => $user]),
        ], 200);
    }
}
