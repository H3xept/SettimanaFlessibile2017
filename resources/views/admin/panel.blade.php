@extends('layouts.app')
<script type="text/javascript" src="{{URL::asset('js/list.min.js')}}"></script>
@section('navigation')
<a href="{{route('home')}}" class="list-group-item">Profilo</a>
<a href="{{route('courses')}}" class="list-group-item">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
<a href="{{route('tickets')}}" class="list-group-item">Aiuto</a><br>
<a href="{{route('admin_panel')}}" class="list-group-item disabled">Admin</a>
@endsection

@section('content')
<div class="jumbotron" style="border-color:#CCCCCC;border-width:1px;border-style:solid; padding-top:8px; padding-bottom:8px;">
<form action="{{route('get_classes')}}" method="POST">
{{csrf_field()}}
<div align="center"><h4>Generazione appelli</h4></div><hr>
	<div class="row">
		<div class="form-group">
		<div class="col-md-6">
			<select name="class" class="form-control" title="Test">
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			</select>
		</div>
		<div class="col-md-6">
			<select name="section" class="form-control">
			  <option value="A">A</option>
			  <option value="B">B</option>
			  <option value="C">C</option>
			  <option value="D">D</option>
			  <option value="E">E</option>
			  <option value="F">F</option>
			  <option value="G">G</option>
			  <option value="H">H</option>
			  <option value="I">I</option>
			  <option value="L">L</option>
			  <option value="M">M</option>
			  <option value="N">N</option>
			  <option value="O">O</option>
			  <option value="P">P</option>
			</select>
		</div>
		</div>
	</div><br><button class="btn btn-success" type="submit">Genera</button>
	</form>
</div>

<div class="jumbotron" style="border-color:#CCCCCC;border-width:1px;border-style:solid; padding-top:8px; padding-bottom:8px;">
<div align="center"><h4>Amministrazione utenti</h4></div><hr>

<?php $users = DB::table('users')->select(array('id','name','class'))->get();?>

<div id="users-list">
<input class="form-control search" type="text" id="search" placeholder="Nome Utente o Classe"><br>
  <ul class="list" style="list-style-type:none; padding:0px;">
@foreach($users as $user)
<li>
	<div class="panel panel-default">
	  <div class="panel-body">
		  <div class="name"><label for="">{{$user->name}}</label>
			  <span class="label label-success class">{{$user->class}}</span>
			  <div class="pull-right">
			  <span><a class="btn btn-primary btn-small" href=""><i class="fa fa-pencil"></i></a></span>
			  </div>
		  </div>
	  </div>
	</div>
</li>
@endforeach
  </ul>
</div>

</div>


<script type="text/javascript">
	var options = {
    valueNames: [ 'name', 'class' ]
};
var users_list = new List('users-list', options);
</script>

@endsection