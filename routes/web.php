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
})->name('home');

Route::get('/courses', function () {
    return view('home.courses');
})->name('courses');

Route::get('/courses/create', function () {
    return view('users.test');
});
Route::post('/storecourse',['uses'=>'CoursesController@store']);

Auth::routes();

Route::get('/home', 'HomeController@index');
