@extends('layouts.app')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item">Profilo</a>
<a href="{{route('courses')}}" class="list-group-item disabled">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
@endsection

@section('content')
<?php 

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
?>

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
							<td><input type="checkbox"  name="l1" value="1" disabled="true"></td>
							<td><input type="checkbox"  name="m1" value="1" disabled="true"></td>
							<td><input type="checkbox"  name="r1" value="1" disabled="true"></td>
							<td><input type="checkbox"  name="g1" value="1" {{shouldBeDisabled($course->f7)}}></td>
							</tr>
							<tr>
							<td><input type="checkbox" name="l2" value="1" {{shouldBeDisabled($course->f1)}}></td>
							<td><input type="checkbox" name="m2" value="1" {{shouldBeDisabled($course->f3)}}></td>
							<td><input type="checkbox" name="r2" value="1" {{shouldBeDisabled($course->f5)}}></td>
							<td><input type="checkbox" name="g2" value="1" {{shouldBeDisabled($course->f8)}}></td>
							</tr>
							<tr>
							<td><input type="checkbox" name="l3" value="1" {{shouldBeDisabled($course->f2)}}></td>
							<td><input type="checkbox" name="m3" value="1" {{shouldBeDisabled($course->f4)}}></td>
							<td><input type="checkbox" name="r3" value="1" {{shouldBeDisabled($course->f6)}}></td>
							<td><input type="checkbox" name="g3" value="1" {{shouldBeDisabled($course->f9)}}></td>
							</tr>
						@else
							<tr>
							<td><i class="fa fa-ban"></i><input hidden="true" name="pl1" value="0"></label></label></td></td>
							<td><i class="fa fa-ban"></i><input hidden="true" name="pm1" value="0"></label></label></td></td>
							<td><i class="fa fa-ban"></i><input hidden="true" name="pr1" value="0"></label></label></td></td>
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
		      	<button type="button" class="btn btn-success">Registrati</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
		      </div>
		    </div>

		  </div>
		</div>

	</div>
@endforeach
@endsection

