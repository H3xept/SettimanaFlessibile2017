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
    return view('home.home');
})->middleware('auth')->name('home');
Route::get('/home', function () {
    return view('home.home');
})->middleware('auth');//Redundant

Route::get('/courses', function () {
	$courses = DB::table('courses')->get();
    return view('home.courses')->withCourses($courses);
})->middleware('auth')->name('courses');

//Temporary ---------
Route::get('/courses/create', function () {
    return view('users.test');
})->middleware('auth');

Route::post('/storecourse',['uses'=>'CoursesController@store'])->middleware('auth');
//Temporary ---------

Auth::routes();

