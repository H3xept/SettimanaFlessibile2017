<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Session;

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

            if($course->save()){
                $sessions = array("f1"=>$request->pf1,"f2"=>$request->pf2,"f3"=>$request->pf3,"f4"=>$request->pf4,"f5"=>$request->pf5,"f6"=>$request->pf6,"f7"=>$request->pf7,"f8"=>$request->pf8,"f9"=>$request->pf9);

                $first = array();
                $second = array();
                $third = array();
                foreach ($sessions as $key=>$session_value) {
                    if($session_value == "1"){
                        $first[$key] = $session_value;
                    }else if($session_value == "2"){
                        $second[$key] = $session_value;
                    }else if($session_value == "3"){
                        $third[$key] = $session_value;
                    }
                }
                $cont = array($first,$second,$third);
                foreach ($cont as $sess) {
                    if(count($sess) > 0){
                        $session_obj = new Session($sess);
                        $course->sessions()->save($session_obj);
                    }
                }
            }
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
            if($course->save()){
                $sessions = array("f1"=>$request->f1,"f2"=>$request->f2,"f3"=>$request->f3,"f4"=>$request->f4,"f5"=>$request->f5,"f6"=>$request->f6,"f7"=>$request->f7,"f8"=>$request->f8,"f9"=>$request->f9);
                foreach ($sessions as $key => $session_value) {
                    if($session_value != "0" && $session_value){
                        $session_obj = new Session([$key=>$session_value]);
                        $course->sessions()->save($session_obj);
                    }
                }
            }
            dd($course);
        }

    	return "YE";
    }
}
