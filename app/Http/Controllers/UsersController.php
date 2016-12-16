<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
	public function index(){
		return User::all();
	}

	public function create(){
		return view('users.createuser');
	}
    public function store(Request $req){
    	User::create($req->all());
    	return "Ye";
    }
}
