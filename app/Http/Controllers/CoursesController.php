<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CoursesController extends Controller
{
    public function store(Request $request){
    	$course = new Course($request->all());
    	$course->save();
    	return "YE";
    }
}
