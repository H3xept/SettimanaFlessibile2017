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
    return view('home.profile');
})->name('home');

Route::get('/courses', function () {
    return view('home.courses');
})->name('courses');

//Temporary ---------
Route::get('/courses/create', function () {
    return view('users.test');
});
Route::post('/storecourse',['uses'=>'CoursesController@store']);
//Temporary ---------

Auth::routes();
Route::get('/home', 'HomeController@index');
