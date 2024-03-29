<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Session;
use DB;

class UsersController extends Controller
{
	public function index(){
		return User::all();
	}

	public function create(){
		return view('users.createuser');
	}
    public function store(Request $request){
    	$user = User::create($request->all());
    	return "Ye";
    }

    public function sign(Request $request,$course_id, $user_id = NULL){

        if(!$user->hasEqualOrGreaterPermissionLevel(6)){
            echo "not_anymore";
        }
        if($user_id != NULL && Auth::user()->hasEqualOrGreaterPermissionLevel(8)){
            $user = User::find($user_id);
        }else{$user = Auth::user();}

        $input = $request->input();
        $course = DB::table('courses')->where('id',$course_id)->first();
        $max = $course->maxStudentsPerSession;
        $session_id = 0;
        $session_signed = 0;
        $session_number = 0;
        $chosen_session = (isset($_POST['session_number'])) ? intval($input['session_number'])+1 : 0;

        if($course->type == 1){
            $stripes_codes = array("f1"=>$input['f1'],"f2"=>$input['f2'],"f3"=>$input['f3'],"f4"=>$input['f4'],
                "f5"=>$input['f5'],"f6"=>$input['f6'],"f7"=>$input['f7'],"f8"=>$input['f8'],"f9"=>$input['f9']);

            foreach ($stripes_codes as $key => $value) {
                if($value == 0 || $value != $chosen_session){ unset($stripes_codes[$key]); }
            }
            if(count($stripes_codes) <= 0) {echo "empty"; die();}
            foreach ($stripes_codes as $key => $value) {
                $session_sql = DB::table('sessions')->where('course_id',$course_id)->where('sessionNumber',$chosen_session-1)->first();
                $session_id = $session_sql->id;
                $session_signed = $session_sql->signedStudents;
                break;
            }
            if($max <= $session_signed){
                echo "full";
                die();
            }   

            $session_obj = Session::find($session_id);
            foreach ($stripes_codes as $key => $value) {
                if($user->$key != NULL){echo "already_reg"; die();}
                $user->$key = $session_id;
            }
            $session_obj->signedStudents+=1;
            $user->sessions()->attach($session_obj);
            $user->save();
            $session_obj->save();
            DB::table('courses')
                    ->where('id', $course->id)
                    ->increment('signedTot');
            echo "ok";
        }else{
            $stripes_codes = $input;
            $session_ids = array();
            unset($stripes_codes['_token']);
            if(count($stripes_codes) <= 0) {echo "empty"; die();}
            foreach ($stripes_codes as $session_code => $value) {
                $session_number = intval(substr($session_code,1))-1;
                $session_sql = DB::table('sessions')->where('course_id',$course_id)->where('sessionNumber',$session_number)->first();
                $session_id = $session_sql->id;
                $session_signed = $session_sql->signedStudents;
                if($max <= $session_signed){
                    echo "full";
                    die();
                }      
                if($user->$session_code != NULL){ echo "already_reg"; die();}
                $session_ids[] = $session_id;
            }
            foreach ($session_ids as $key => $value) {
                $session_obj = Session::find($value);
                $user->sessions()->attach($session_obj);
                $session_obj->signedStudents += 1;
                $equivalent_session_name = "f".($session_obj->sessionNumber+1);
                $user->$equivalent_session_name = $session_id;
                $session_obj->save();
            DB::table('courses')
                    ->where('id', $course->id)
                    ->increment('signedTot');
            }
            $user->save();
            echo "ok";
        }

    }

    public function unsign(Request $request,$course_id,$session_number,$user_id = NULL){

        if(!$user->hasEqualOrGreaterPermissionLevel(6)){
            echo "not_anymore";
        }
        
        if($user_id != NULL && Auth::user()->hasEqualOrGreaterPermissionLevel(8)){
            $user = User::find($user_id);
        }else{$user = Auth::user();}

        $user_sessions = $user->sessions();

        $course = DB::table('courses')->where('id',$course_id)->first();
        $sessions = $user_sessions->where([['course_id','=',$course_id],['sessionNumber','=',$session_number]])->get();
        foreach ($sessions as $session) {
            $session->signedStudents -= 1;
            if($course->type == 1){
                $stripes_codes = array("f1"=>$session->f1,"f2"=>$session->f2,"f3"=>$session->f3,"f4"=>$session->f4,
                    "f5"=>$session->f5,"f6"=>$session->f6,"f7"=>$session->f7,"f8"=>$session->f8,"f9"=>$session->f9);
                foreach ($stripes_codes as $key => $value) {
                    if($value == NULL || $value != $session_number || $value == 0){ unset($stripes_codes[$key]); }
                    $user->$key = NULL;
                }
            }else{
                $ss = "f".($session_number+1);
                $user->$ss = NULL;
            }
            $session->save();
        }
        if(count($sessions) > 0){
            $user_sessions->detach($sessions);
        }
        $user->save();
        DB::table('courses')
                    ->where('id', $course->id)
                    ->decrement('signedTot');
    }
}
