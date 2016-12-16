@extends('master')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item disabled">
Profilo
</a>
<a href="#" class="list-group-item">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
@endsection


@section('content')
<div id="list-id" class="jumbotron contrast" align="center">
	<div align="left"><h3>Programmazione settimana</h3></div><hr>
  <table class="table table-hover">
  <thead>
    <tr>
      <th>Giorno</th>
      <th>Fascia</th>
      <th>Corso</th>
    </tr>
  </thead>

  </tbody>
</table>
</div>
@endsection