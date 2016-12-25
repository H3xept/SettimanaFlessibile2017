@extends('layouts.app')

@section('navigation')
{{$time}}
<a href="{{route('home')}}" class="list-group-item">Profilo</a>
<a href="{{route('courses')}}" class="list-group-item disabled">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
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
$behalf_user = NULL;
$user_permission = NULL;
?>

@if(isset($_GET['behalf_user']))
@if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
<?php $behalf_user = $_GET['behalf_user']; $b_user = User::find($behalf_user); $user_permission = Auth::user()->hasEqualOrGreaterPermissionLevel(8); ?>
<div id="list-id" class="jumbotron" style="  border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:8px;">
<h4>Modificando per conto di: <i><b>{{$b_user->name}}</b> {{$b_user->class}}</i></h4>
</div>
@endif
@endif

@foreach($courses as $course)
	<div id="list-id" class="jumbotron" style="  border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:16px;">
		<h3>{{$course->name}} <small>{{$course->ref}}</small></h3>
		<hr>
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#{{$course->id}}info">Help</button>
		<div id="{{$course->id}}info" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Problemi con <i>{{$course->name}}</i> ?</h4>
		      </div>
		      <div class="modal-body">
		        <p>No help for you.</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
		      </div>
		    </div>

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
								<td><input type="checkbox" name="f7" value="1" {{shouldBeDisabled($course->f7)}}></td>
								</tr>
								<tr>
								<td><input type="checkbox" name="f1" value="1" {{shouldBeDisabled($course->f1)}}></td>
								<td><input type="checkbox" name="f3" value="1" {{shouldBeDisabled($course->f3)}}></td>
								<td><input type="checkbox" name="f5" value="1" {{shouldBeDisabled($course->f5)}}></td>
								<td><input type="checkbox" name="f8" value="1" {{shouldBeDisabled($course->f8)}}></td>
								</tr>
								<tr>
								<td><input type="checkbox" name="f2" value="1" {{shouldBeDisabled($course->f2)}}></td>
								<td><input type="checkbox" name="f4" value="1" {{shouldBeDisabled($course->f4)}}></td>
								<td><input type="checkbox" name="f6" value="1" {{shouldBeDisabled($course->f6)}}></td>
								<td><input type="checkbox" name="f9" value="1" {{shouldBeDisabled($course->f9)}}></td>
								</tr>
							@else
								<tr>
								<td><i class="fa fa-ban"></i></label></label></td></td>
								<td><i class="fa fa-ban"></i></label></label></td></td>
								<td><i class="fa fa-ban"></i></label></label></td></td>
								<td>{!!$modifiers[$course->f7]!!}<input hidden="true" name="f7" value='{{$course->f7}}'></label></td>
								</tr>
								<tr>
								<td>{!!$modifiers[$course->f1]!!}<input hidden="true" name="f1" value='{{$course->f1}}'></label></td>
								<td>{!!$modifiers[$course->f3]!!}<input hidden="true" name="f3" value='{{$course->f3}}'></label></td>
								<td>{!!$modifiers[$course->f5]!!}<input hidden="true" name="f5" value='{{$course->f5}}'></label></td>
								<td>{!!$modifiers[$course->f8]!!}<input hidden="true" name="f8" value='{{$course->f8}}'></label></td>
								</tr>
								<tr>
								<td>{!!$modifiers[$course->f2]!!}<input hidden="true" name="f2" value='{{$course->f2}}'></label></td>
								<td>{!!$modifiers[$course->f4]!!}<input hidden="true" name="f4" value='{{$course->f4}}'></label></td>
								<td>{!!$modifiers[$course->f6]!!}<input hidden="true" name="f6" value='{{$course->f6}}'></label></td>
								<td>{!!$modifiers[$course->f9]!!}<input hidden="true" name="f9" value='{{$course->f9}}'></label></td>
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
	$user_permission = <?php if ($user_permission) { echo $user_permission; } else { echo false; } ?>;
	$behalf_user = <?php if ($behalf_user) { echo $behalf_user; } else { echo false; } ?>;
	console.log($behalf_user);
	if(($behalf_user) && $user_permission){
		var url = "/courses/{{$course->id}}/sign/{{$behalf_user}}";
	}else{
    	var url = "/courses/{{$course->id}}/sign";
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
@endforeach
@endsection

