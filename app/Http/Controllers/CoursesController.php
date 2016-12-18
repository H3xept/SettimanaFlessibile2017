<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CoursesController extends Controller
{
    public function store(Request $request){

    	$course = new Course;
    	
    	$course->name = $request->name;
    	$course->desc = $request->desc;
    	$course->ref = $request->ref;
    	$course->pRef = $request->pRef;
    	$course->ext = $request->ext;
    	if($request->type == "p") { $type = 1; }else{ $type = 0; }
    	$course->type = $type;
    	$course->f1 = $request->f1;
    	$course->f2 = $request->f2;
    	$course->f3 = $request->f3;
    	$course->f4 = $request->f4;
    	$course->f5 = $request->f5;
    	$course->f6 = $request->f6;
    	$course->f7 = $request->f7;
    	$course->f8 = $request->f8;
    	$course->f9 = $request->f9;

    	$course->save();
    	return "YE";
    }
}
