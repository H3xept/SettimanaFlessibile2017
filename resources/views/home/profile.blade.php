@extends('master')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item disabled">
Profilo
</a>
<a href="{{route('info')}}" class="list-group-item">Istruzioni</a>
<a href="#" class="list-group-item">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
@endsection


@section('content')
<div id="list-id" class="jumbotron" align="center" style="	border-color: #CCCCCC;border-width: 1px;border-style:solid;">
	<div align="left"><h3>Programmazione settimana</h3></div><hr>
  <table class="table table-hover">
  <thead>
    <tr>
      <th>Giorno</th>
      <th>Fascia</th>
      <th>Corso</th>
    </tr>
  </thead>
  <tboy>
	<tr>
		<td>Lunedì</td>
		<td>2°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Lunedì</td>
		<td>3°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Martedì</td>
		<td>2°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Martedì</td>
		<td>3°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Mercoledì</td>
		<td>2°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Mercoledì</td>
		<td>3°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Giovedì</td>
		<td>1°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Giovedì</td>
		<td>2°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
	<tr>
		<td>Giovedì</td>
		<td>3°</td>
		<td><a href="#">Nessun corso selezionato.</a></td>
	</tr>
  </tbody>
</table>
</div>
@endsection