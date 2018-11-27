<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Config;
use App\Admin;

class AuthAdminController extends Controller
{
    //
    public $loginAfterSignUp = false;

    public function __construct()
    {
        Config::set('auth.defaults.guard', 'api_admin');
        Config::set('auth.defaults.passwords', 'admins');
    }
    

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

        // $credentials = $request->only('email', 'password');

        // if ($token = $this->guard()->attempt($credentials)) {
        //     return $this->respondWithToken($token);
        // }

        // return response()->json(['error' => 'Unauthorized'], 401);
    }

    /*
    |-------------------------------------------------------------------------------
    | User Admin Logout
    |-------------------------------------------------------------------------------
    | URL:              /api/logout
    | Method:           POST
    | Description:      Logout user admin from the application
    | Header:           Accept:application/json
    | Authorization:    Bearer Token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9tLWNvbW1lcmNlLnRlc3RcL2FwaVwvbG9naW4iLCJpYXQiOjE1NDI2ODk5MDAsImV4cCI6MTU0MjY5MzUwMCwibmJmIjoxNTQyNjg5OTAwLCJqdGkiOiI4eXU3OE9jQTF6eWx4VEtqIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.l9YC02EwGop_saZK2t5PuBp5bV5i3pgIJZs836-RNWE        
    */
    public function logout(Request $request)
    {
        // $this->validate($request, [
        //     'token' => 'required'
        // ]);

        $token = JWTAuth::getToken();
 
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'status' => (['code' => '200','type' => 'Ok']),
                'message' => 'User admin logged out successfully',
                'data' => '',
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => (['code' => '500','type' => 'Internal server error']),
                'message' => 'Sorry, the user admin cannot be logged out',
                'data' => '',
            ], 500);
        }
    }

    /*
    |-------------------------------------------------------------------------------
    | Get Profile of Authorized User
    |-------------------------------------------------------------------------------
    | URL:              /api/admin_profile
    | Method:           GET
    | Description:      Get profile authorized user
    | Header:           Accept:application/json
    | Authorization:    Bearer Token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9tLWNvbW1lcmNlLnRlc3RcL2FwaVwvbG9naW4iLCJpYXQiOjE1NDI2ODk5MDAsImV4cCI6MTU0MjY5MzUwMCwibmJmIjoxNTQyNjg5OTAwLCJqdGkiOiI4eXU3OE9jQTF6eWx4VEtqIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.l9YC02EwGop_saZK2t5PuBp5bV5i3pgIJZs836-RNWE        
    */
    public function getProfile()
    {
        try {
            $admin = JWTAuth::parseToken()->authenticate();
            return response()->json([
                'status' => (['code' => '200','type' => 'Ok']),
                'message' => '',
                'data' => array(['UserAdmin' => $admin]),
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => (['code' => '500','type' => 'Internal server error']),
                'message' => 'User not found',
                'data' => '',
            ], 500);
        }

        
    }

    public function updateProfile(Request $request)
    {
        try {
            $userAuthorized = JWTAuth::parseToken()->authenticate();
            
            $updated = $userAuthorized->update($request->only(['name', 'phone', 'address', 'photo']));
            
            if ($updated) {
                return response()->json([
                    'status' => (['code' => '200','type' => 'Ok']),
                    'message' => 'Update successfully',
                    'data' => $userAuthorized,
                ], 200);
            } else {
                return response()->json([
                    'status' => (['code' => '500','type' => 'Internal server error']),
                    'message' => 'Update failed',
                    'data' => '',
                ], 500);
            }        
        } catch (JWTException $exception) {
            return response()->json([
                'status' => (['code' => '500','type' => 'Internal server error']),
                'message' => 'User not authorized',
                'data' => '',
            ], 500);
        }

    }
}
