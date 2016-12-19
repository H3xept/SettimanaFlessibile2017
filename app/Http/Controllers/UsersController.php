<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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
    	echo print_r($request->input());
    	// $user = Auth::user();
    	// $sessions = DB::table('sessions')->with('course_id',$course_id)->get();
    }
}
