@extends('layouts.app')
<script type="text/javascript" src="{{URL::asset('js/list.min.js')}}"></script>
@section('navigation')
<a href="{{route('home')}}" class="list-group-item">Profilo</a>
<a href="{{route('courses')}}" class="list-group-item">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
<a href="{{route('tickets')}}" class="list-group-item">Aiuto</a><br>
<a href="{{route('admin_panel')}}" class="list-group-item">Admin</a>
@endsection

@section('content')

@endsection