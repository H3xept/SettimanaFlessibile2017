<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Ticket;
use DB;

class TicketsController extends Controller
{
	public function index(){
		$tickets = Auth::user()->tickets;
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
		$ticket = Ticket::find($ticket_id);
			if($ticket->user_id == Auth::user()->id){
				$ticket->delete();
				return "succ";
			}else{return 'err';}
		} catch (Exception $e) {
			return "err";
		}

	}
}
