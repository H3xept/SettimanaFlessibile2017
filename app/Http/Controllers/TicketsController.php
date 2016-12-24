<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Ticket;
use DB;

class TicketsController extends Controller
{
	public function index(){
		$user = Auth::user();
		if($user->hasEqualOrGreaterPermissionLevel(8)){
			$tickets = Ticket::all();
		}else{$tickets = $user->tickets;}
		return view('home.tickets')->withTickets($tickets);
	}

	public function store(Request $request){
		$user = Auth::user();
		$ticket = new Ticket($request->input());
		$user->tickets()->save($ticket);
		return "succ";
	}

	public function delete(Request $request, $ticket_id){
		try {
			$user = Auth::user();
		$ticket = Ticket::find($ticket_id);
			if($ticket->user_id == $user->id){
				$ticket->delete();
				return "succ";
			}else if($user->hasEqualOrGreaterPermissionLevel(8)){
				$ticket->delete();
				return "succ";
			}else{return 'err';}
		} catch (Exception $e) {
			return "err";
		}

	}
}
