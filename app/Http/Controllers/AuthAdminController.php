<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\Admin;

class AuthAdminController extends Controller
{
    //
    public $loginAfterSignUp = false;

    /*
    |-------------------------------------------------------------------------------
    | Register a User Admin
    |-------------------------------------------------------------------------------
    | URL:              /api/register
    | Method:           POST
    | Description:      Adds a new user admin to the application
    | Header:           Accept:application/json
    | Body(Form Data):  Name:Gede Darma, Email:de.darma.damuh@gmail.com, Password:darma@123
    */
	  public function register(RegisterAuthRequest $request)
    {        
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();
 
        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'status' => (['code' => '200','type' => 'Ok']),
            'message' => 'User admin registered successfully',
            'data' => array(['user_admin' => $admin]),
        ], 200);
    }

    /*
    |-------------------------------------------------------------------------------
    | User Admin Login
    |-------------------------------------------------------------------------------
    | URL:              /api/login
    | Method:           POST
    | Description:      Login user admin to the application
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
            'message' => 'User admin logged in successfully',
            'data' => array(['token' => $jwt_token]),
        ], 200);
    }

    /*
    |-------------------------------------------------------------------------------
    | User Admin Logout
    |-------------------------------------------------------------------------------
    | URL:              /api/logout
    | Method:           POST
    | Description:      Logout user admin from the application
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
                'message' => 'User admin logged out successfully',
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
}
