@extends('layouts.app')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item">Profilo</a>
<a href="{{route('courses')}}" class="list-group-item disabled">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
@endsection

@section('content')
<?php $courses = DB::table('courses')->get(); ?>
@foreach($courses as $course)
	<div id="list-id" class="jumbotron" align="center" style="  border-color: #CCCCCC;border-width: 1px;border-style:solid;">

	</div>
@endforeach
@endsection

