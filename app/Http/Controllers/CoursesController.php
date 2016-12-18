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

        if($type == 1){//progressive
            $course->f1 = $request->pf1 ?? 0;
            $course->f2 = $request->pf2 ?? 0;
            $course->f3 = $request->pf3 ?? 0;
            $course->f4 = $request->pf4 ?? 0;
            $course->f5 = $request->pf5 ?? 0;
            $course->f6 = $request->pf6 ?? 0;
            $course->f7 = $request->pf7 ?? 0;
            $course->f8 = $request->pf8 ?? 0;
            $course->f9 = $request->pf9 ?? 0;
        }else{
            $course->f1 = $request->f1 ?? 0;
            $course->f2 = $request->f2 ?? 0;
            $course->f3 = $request->f3 ?? 0;
            $course->f4 = $request->f4 ?? 0;
            $course->f5 = $request->f5 ?? 0;
            $course->f6 = $request->f6 ?? 0;
            $course->f7 = $request->f7 ?? 0;
            $course->f8 = $request->f8 ?? 0;
            $course->f9 = $request->f9 ?? 0;
        }


    	$course->save();
    	return "YE";
    }
}
