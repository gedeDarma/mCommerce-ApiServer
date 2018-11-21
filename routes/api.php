<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//ROUTE FOR USER
Route::post('user_register', 'AuthController@register');
Route::post('user_login', 'AuthController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('logout', 'AuthController@logout'); 
});

//ROUTE FOR ADMIN
Route::post('admin_register', 'AuthAdminController@register');
Route::post('admin_login', 'AuthAdminController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('logout', 'AuthAdminController@logout'); 
});

//Product Routes
Route::apiResource('products', 'ProductController');
Route::get('products/{id}', 'ProductController@show');
Route::post('products', 'ProductController@store');
Route::put('products/{product}', 'ProductController@update');
Route::delete('products/{product}', 'ProductController@destroy');

//Category Routes
Route::apiResource('categories', 'CategoryController');
Route::get('categories/{category}', 'CategoryController@show');
Route::post('categories', 'CategoryController@store');
Route::put('categories/{category}', 'CategoryController@update');
Route::delete('categories/{category}', 'CategoryController@destroy');