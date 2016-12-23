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
use App\Course;

Route::get('/', function () {
    return view('home.home');
})->middleware('auth')->name('home');
Route::get('/home', function () {
    return view('home.home');
})->middleware('auth');//Redundant

Route::get('/courses', function () {
	$start = microtime(true);
	$courses = DB::table('courses')->get();
    $time_elapsed_secs = microtime(true) - $start;
    return view('home.courses')->with(['courses'=>$courses,'time'=>$time_elapsed_secs]);
})->middleware('auth')->name('courses');

Route::post('/courses/{course_id}/sign',['uses'=>'UsersController@sign'])->middleware('auth')->name('sign');
Route::get('/courses/{course_id}/{session_number}/unsign',['uses'=>'UsersController@unsign'])->middleware('auth')->name('unsign');

Route::get('/tickets',['uses'=>'TicketsController@index'])->middleware('auth')->name('tickets');
Route::post('/tickets/new',['uses'=>'TicketsController@store'])->middleware('auth')->name('new_ticket');
Route::get('/tickets/{ticket_id}/delete',['uses'=>'TicketsController@delete'])->middleware('auth')->name('del_ticket');

//Temporary ---------
Route::get('/courses/create', function () {
    return view('users.test');
})->middleware('auth');
Route::post('/storecourse',['uses'=>'CoursesController@store'])->middleware('auth');
//Temporary ---------

Auth::routes();

