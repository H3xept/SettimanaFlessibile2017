<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('master');
});

Route::get('user', ['uses'=>'UsersController@index']);
Route::get('user/create', ['uses'=>'UsersController@create']);
Route::post('/user', ['uses'=>'UsersController@store']);
