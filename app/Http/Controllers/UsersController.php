<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
	public function index(){
		return User::all();
	}

    public function store(Request $req){
    	User::create($req->all());
    	return "Ye";
    }
}
