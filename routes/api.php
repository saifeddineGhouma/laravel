<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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




Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');

Route::group(['middleware'=>'auth:api'],function(){
        Route::get('profile','UserController@profile');
        Route::get('logout','AuthController@logout');
        Route::put('update_info','UserController@update_info');
        Route::put('update_password','UserController@update_password');
        Route::post('upload','ProductController@upload');
        Route::apiResource('users','UserController');
        Route::apiResource('roles','RoleController');
        Route::apiResource('products','ProductController');
        Route::apiResource('orders','OrderController')->only('index','show');
        Route::apiResource('permissions','PermissionController')->only('index','show');
        Route::get('export','OrderController@export');
        Route::get('chart','DashboardController@chart');

});





