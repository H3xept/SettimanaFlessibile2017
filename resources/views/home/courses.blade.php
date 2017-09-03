@extends('layouts.app')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item">Profilo</a>
<a href="{{route('courses')}}" class="list-group-item disabled">Corsi disponibili</a>
<a href="{{route('info')}}" class="list-group-item">Istruzioni</a>
<a href="{{route('tickets')}}" class="list-group-item">Aiuto</a><br>
@if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
<br><a href="{{route('admin_panel')}}" class="list-group-item">Admin</a>
@endif
@endsection

@section('content')
<?php 
use App\User;
$modifiers = array(
	"0"=>'<i class="fa fa-ban">',
    '1'=>'<label id="p" class="label label-warning" style="user-select: none; vertical-align: middle;"><i class="fa fa-close"></i>',
    "2"=>'<label id="p" class="label label-success" style="user-select: none; vertical-align: middle;"><i class="fa fa-close"></i>',
    "3"=>'<label id="p" class="label label-info" style="user-select: none; vertical-align: middle;"><i class="fa fa-close"></i>'
);

function shouldBeDisabled($ret){
	if($ret == 0){
		return "disabled";
	}else {return"";}
}

function counter($signed,$max){
	if(strcmp($signed, "")){
		echo(" ".$signed."/".$max);
	}else echo"";
}

$behalf_user = NULL;
$user_permission = NULL;
$usr = Auth::user()->username;
?>

@if(isset($_GET['behalf_user']))
@if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
<?php $behalf_user = $_GET['behalf_user']; $b_user = User::find($behalf_user); $user_permission = Auth::user()->hasEqualOrGreaterPermissionLevel(8); ?>
<div id="list-id" class="jumbotron" style="  border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:8px;">
<h4>Modificando per conto di: <i><b>{{$b_user->name}}</b> {{$b_user->class}}</i></h4>
</div>
@endif
@endif

    <?php
        if(isset($_GET['msg'])){

        $msg = htmlspecialchars($_GET['msg']);
        $class = "alert-success";
        if($msg == "succ"){ $txt = "Ticket creato con successo. Riceverai una risposta al più presto.";}
        else if($msg == "err"){ $txt = "C'è stato un problema interno, contattare <a href='https://www.facebook.com/H3xept'> Leonardo Cascianelli </a> per ulteriori info."; $class = "alert-warning";}
        else if($msg == "rekt"){$txt = "Ehy cosa pensi di fare?"; $class = "alert-warning";}

        echo '<div class="alert '.$class.'" id="alert" style="margin-bottom:24px;">
                <button type="button" class="close" data-dismiss="alert">x</button>
                '.$txt.'
                </div>';
        }
    ?>

<div id="list-id" class="jumbotron" style="  border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:8px;">
    <div align="left"><p><b style="color:red;">LEGGIMI:</b><b> Per aiuto NON contattate Mila Quacquarelli. Inviate una richiesta di aiuto o chiamate Leonardo Cascianelli al numero 3397208489 (Solo per cose urgenti perfavore)</b></p></div><hr>
<p align="center">Per cercare <b>corsi e referenti</b> utilizzare <code>cltr+f</code>(PC) o <code>cmd+f</code>(Mac) e digitare. Per ragioni di performance non è stato conveniente aggiungere una barra di ricerca</p>
</div>
@foreach($courses as $course)
<?php 
	$sessions_usable = [];
	$maxSession = $course->maxStudentsPerSession;
	if($course->type == 0){
	$sessions = DB::table('sessions')->where('course_id',$course->id)->select('sessionNumber','signedStudents')->get()->toArray();
	foreach ($sessions as $session) {
		$key = $session->sessionNumber;
		$sessions_usable[$key] = $session->signedStudents;
	}
	for ($i=0; $i < 9; $i++) { 
		if(!array_key_exists($i, $sessions_usable)){
			$sessions_usable[$i] = "";
		}
	}
	}
	else{
		$sessions_usable = ["","","","","","","","",""];
		$sessions = DB::table('sessions')->where('course_id',$course->id)->get()->toArray();
		foreach ($sessions as $session) {
			for ($i=0; $i < 9; $i++) { 
				$key = "f".($i+1);
				if($session->$key != 0){
				$sessions_usable[$i] = $session->signedStudents."/".$maxSession;
				}
			}
		}
	}
	// dd($sessions_usable);
?>
@if($course->maxTot > $course->signedTot || Auth::user()->hasEqualOrGreaterPermissionLevel(10))
<?php $form_ref = explode(", ",$course->ref); $ref_names = array(); foreach ($form_ref as $ref ) {
	str_replace(" ", "", $ref);
	$ref = strtolower($ref);
	$ref_names[] = $ref;
}?>

@if(!in_array($usr,$ref_names))
@if(!($course->id == 103))
	<div id="list-id" class="jumbotron" style="  border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:16px;">
		<h3>{{$course->name}} <small>{{$course->ref}}</small></h3>
		<hr>
		@if(Auth::user()->hasEqualOrGreaterPermissionLevel(6))
		<a href="/courses/generate/{{$course->id}}" class="btn btn-warning"><i class="fa fa-gift"></i></a>
		@endif
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#{{$course->id}}info">Help</button>
		<div id="{{$course->id}}info" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Problemi con <i>{{$course->name}}</i> ?</h4>
		      </div>
		      <div class="modal-body">

	      <form action="{{route('new_ticket')}}" method="POST" id="createForm{{$course->id}}">
	      	{{csrf_field()}}
			<div class="form-group">
			  <label for="usr">Oggetto</label>
			  <input type="text" class="form-control" id="title" name="title" value="{{$course->name}}" required readonly>
			</div>
			<div class="form-group">
			  <label for="comment">Descrivi il tuo problema</label>
			  <textarea class="form-control" rows="6" id="desc" name="desc" required></textarea>
			</div>
			<div class="form-group">
			  <label for="usr">Come possiamo contattarti? (Email, telefono...)</label>
			  <input type="text" class="form-control" id="addr" name="addr" required>
			</div>
			<input type="text" name="username" hidden="true" value="{{Auth::user()->name}}">
	     

		      </div>
	      <div class="modal-footer">
	      	<button id="createButton{{$course->id}}" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-success">Invia</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
	      </div>
	       </form>
		    </div>
<script type="text/javascript">
    $("#createForm{{$course->id}}").submit(function(e){ var url = "/tickets/new"; $("#createButton{{$course->id}}").button('loading'); 
    	$.ajax({type: "POST",url: url,data: $(this).serialize(),success: function(data){window.location = "/courses?msg=succ"},error: function(){$("#createButton{{$course->id}}").button('reset'); window.location = "/courses?msg=err"}}); e.preventDefault();});
</script>
		  </div>
		</div>
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#{{$course->id}}register">Registrazione</button>
		<div id="{{$course->id}}register" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title"><b>Registrazione a</b><i> {{$course->name}}</i></h4>
		      </div>
		      <div class="modal-body">
		      	<h4><b>Descrizione</b></h4>
		        <p>{{$course->desc}}</p>
		      	<h4><b>Referenti</b></h4>
		        <p>{{$course->ref}}</p>
		        <hr>

		        <form id="{{$course->id}}form" action="/courses/{{$course->id}}/sign" method="POST">
		        {{csrf_field()}}
		        	@if($course->type == 1)
		        	<div align="center">
		        		@if($course->sessionY)
					    <label class="radio-inline">
					      <input type="radio" name="session_number" value="0" checked="true">Giallo
					    </label>
					    @endif
					    @if($course->sessionG)
					    <label class="radio-inline">
					      <input type="radio" name="session_number" value="1">Verde
					    </label>
					    @endif
					    @if($course->sessionB)
					    <label class="radio-inline">
					      <input type="radio" name="session_number" value="2">Azzurro
					    </label>
					    @endif
		        	</div><br>
		        	@endif
					<div class="table-responsive">
						<table class="table">
						<thead>
							<tr>
							<th>Lunedì</th>
							<th>Martedì</th>
							<th>Mercoledì</th>
							<th>Giovedì</th>
							</tr>
						</thead>
						<tbody>
							@if($course->type == 0)
								<tr>
								<td><input type="checkbox" value="1" disabled="true"></td>
								<td><input type="checkbox" value="1" disabled="true"></td>
								<td><input type="checkbox" value="1" disabled="true"></td>
								<td><input type="checkbox" name="f7" value="1" {{shouldBeDisabled($course->f7)}}>{{counter($sessions_usable[6],$maxSession)}}</td>
								</tr>
								<tr>
								<td><input type="checkbox" name="f1" value="1" {{shouldBeDisabled($course->f1)}}>{{counter($sessions_usable[0],$maxSession)}}</td>
								<td><input type="checkbox" name="f3" value="1" {{shouldBeDisabled($course->f3)}}>{{counter($sessions_usable[2],$maxSession)}}</td>
								<td><input type="checkbox" name="f5" value="1" {{shouldBeDisabled($course->f5)}}>{{counter($sessions_usable[4],$maxSession)}}</td>
								<td><input type="checkbox" name="f8" value="1" {{shouldBeDisabled($course->f8)}}>{{counter($sessions_usable[7],$maxSession)}}</td>
								</tr>
								<tr>
								<td><input type="checkbox" name="f2" value="1" {{shouldBeDisabled($course->f2)}}>{{counter($sessions_usable[1],$maxSession)}}</td>
								<td><input type="checkbox" name="f4" value="1" {{shouldBeDisabled($course->f4)}}>{{counter($sessions_usable[3],$maxSession)}}</td>
								<td><input type="checkbox" name="f6" value="1" {{shouldBeDisabled($course->f6)}}>{{counter($sessions_usable[5],$maxSession)}}</td>
								<td><input type="checkbox" name="f9" value="1" {{shouldBeDisabled($course->f9)}}>{{counter($sessions_usable[8],$maxSession)}}</td>
								</tr>
							@else
								<tr>
								<td><i class="fa fa-ban"></i></label></label></td></td>
								<td><i class="fa fa-ban"></i></label></label></td></td>
								<td><i class="fa fa-ban"></i></label></label></td></td>
								<td>{!!$modifiers[$course->f7]!!}<input hidden="true" name="f7" value='{{$course->f7}}'></label>{{" ".$sessions_usable[6]}}</td>
								</tr>
								<tr>
								<td>{!!$modifiers[$course->f1]!!}<input hidden="true" name="f1" value='{{$course->f1}}'></label>{{" ".$sessions_usable[0]}}</td>
								<td>{!!$modifiers[$course->f3]!!}<input hidden="true" name="f3" value='{{$course->f3}}'></label>{{" ".$sessions_usable[2]}}</td>
								<td>{!!$modifiers[$course->f5]!!}<input hidden="true" name="f5" value='{{$course->f5}}'></label>{{" ".$sessions_usable[4]}}</td>
								<td>{!!$modifiers[$course->f8]!!}<input hidden="true" name="f8" value='{{$course->f8}}'></label>{{" ".$sessions_usable[7]}}</td>
								</tr>
								<tr>
								<td>{!!$modifiers[$course->f2]!!}<input hidden="true" name="f2" value='{{$course->f2}}'></label>{{" ".$sessions_usable[1]}}</td>
								<td>{!!$modifiers[$course->f4]!!}<input hidden="true" name="f4" value='{{$course->f4}}'></label>{{" ".$sessions_usable[3]}}</td>
								<td>{!!$modifiers[$course->f6]!!}<input hidden="true" name="f6" value='{{$course->f6}}'></label>{{" ".$sessions_usable[5]}}</td>
								<td>{!!$modifiers[$course->f9]!!}<input hidden="true" name="f9" value='{{$course->f9}}'></label>{{" ".$sessions_usable[8]}}</td>
								</tr>
							@endif
						</tbody>
						</table>
					</div>

			      </div>
			      <div class="modal-footer">
			      	<button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'>" id="{{$course->id}}button" class="btn btn-success">Registrati</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
			      </div>
		      </form>

<script type="text/javascript">
	$("#{{$course->id}}form").submit(function(e) {
	$button = $("#{{$course->id}}button");
	$button.button('loading');
	$user_permission = <?php if (isset($user_permission)) { echo $user_permission; } else { echo 'undefined'; } ?>;
	$behalf_user = <?php if (isset($behalf_user)) { echo $behalf_user; } else { echo 'undefined'; } ?>;
	var url = "/courses/{{$course->id}}/sign";
	if(($behalf_user != undefined) && $user_permission != undefined){
		console.log(($behalf_user != 'undefined')+"."+$behalf_user);
		var url = "/courses/{{$course->id}}/sign/{{$behalf_user}}";
	}

    $.ajax({
           type: "POST",
           url: url,
           data: $(this).serialize(),
           success: function(data)
           {
           	$string = "";
           	if(data == "ok"){$string = "Registrazione avvenuta."; $("#{{$course->id}}register").modal('hide');}
           	else if(data == "full"){$string = "Il corso è pieno per le fasce selezionate.";}
           	else if(data == "empty"){$string = "Nessuna fascia selezionata!";}
           	else if(data == "already_reg"){$string = "Hai già un corso per una o più fasce selezionate.";}
           	$type = BootstrapDialog.TYPE_SUCCESS;
           	$title = "Tutto ok!";
           	if(data != "ok"){
           		$type = BootstrapDialog.TYPE_DANGER;
           		$title = "Attenzione";
			}
			$button.button('reset');
			var dialog = new BootstrapDialog()
			            .setTitle($title)
			            .setMessage($string)
			            .setType($type)
			            .open();
			window.setTimeout(function(){
				dialog.close();
			},4000);
           },
           error: function(data)
           {
           	$string = data;
           	if(data == "ok"){$string = "Registrazione avvenuta."; $("#{{$course->id}}register").modal('hide');}
           	else if(data == "full"){$string = "Il corso è pieno per le fasce selezionate.";}
           	else if(data == "empty"){$string = "Nessuna fascia selezionata!";}
           	else if(data == "already_reg"){$string = "Hai già un corso per una o più fasce selezionate.";}
           	console.log(url)
			$button.button('reset');
			var dialog = new BootstrapDialog()
			            .setTitle('Attenzione')
			            .setMessage($string)
			            .setType(BootstrapDialog.TYPE_DANGER)
			            .open();
			window.setTimeout(function(){
				dialog.close();
			},4000);
           }
         });

    e.preventDefault();
	});
</script>
		    </div>

		  </div>
		</div>

	</div>
@endif
@endif
@endif
@endforeach
@endsection

