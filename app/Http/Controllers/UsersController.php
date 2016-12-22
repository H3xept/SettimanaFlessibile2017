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
    	User::create($request->all());
    	return "Ye";
    }

    public function sign(Request $request,$course_id){
    	
        $input = $request->input();
        $course = DB::table('courses')->where('id',$course_id)->first();
        $max = $course->maxStudentsPerSession;
        $session_id = 0;
        $session_signed = 0;
        $session_number = 0;
        $chosen_session = (isset($_POST['session_number'])) ? intval($input['session_number'])+1 : 0;
        $user = Auth::user(); 

        if($course->type == 1){
            $stripes_codes = array("f1"=>$input['f1'],"f2"=>$input['f2'],"f3"=>$input['f3'],"f4"=>$input['f4'],
                "f5"=>$input['f5'],"f6"=>$input['f6'],"f7"=>$input['f7'],"f8"=>$input['f8'],"f9"=>$input['f9']);

            foreach ($stripes_codes as $key => $value) {
                if($value == 0 || $value != $chosen_session){ unset($stripes_codes[$key]); }
            }
            foreach ($stripes_codes as $key => $value) {
                $session_sql = DB::table('sessions')->where('course_id',$course_id)->where('sessionNumber',$chosen_session-1)->first();
                $session_id = $session_sql->id;
                $session_signed = $session_sql->signedStudents;
                break;
            }
            if($max <= $session_signed){
                echo "ERROR! TOO MANY PP";
                die();
            }   

            $session_obj = Session::find($session_id);
            foreach ($stripes_codes as $key => $value) {
                if($user->$key != NULL){echo "ERROR, YOU HAVE  A COURSE THERE"; die();}
                $user->$key = $session_id;
            }
            $user->sessions()->attach($session_obj);
            $user->save();
        }else{
            $stripes_codes = $input;
            $session_ids = array();
            unset($stripes_codes['_token']);
            foreach ($stripes_codes as $session_code => $value) {
                $session_number = intval(substr($session_code,1))-1;
                $session_sql = DB::table('sessions')->where('course_id',$course_id)->where('sessionNumber',$session_number)->first();
                $session_id = $session_sql->id;
                $session_signed = $session_sql->signedStudents;
                if($max <= $session_signed){
                    echo "ERROR! TOO MANY PP";
                    die();
                }      
                echo "Checking session code ".$session_code." With result ".$user->$session_code.">.\n";
                if($user->$session_code != NULL){ echo "ERROR, YOU HAVE  A COURSE THERE"; die();}
                $session_ids[] = $session_id;
            }
            foreach ($session_ids as $key => $value) {
                $session_obj = Session::find($value);
                $user->sessions()->attach($session_obj);
                $equivalent_session_name = "f".($session_obj->sessionNumber+1);
                $user->$equivalent_session_name = $session_id;
                $user->save();
            }
        }

    }
}
