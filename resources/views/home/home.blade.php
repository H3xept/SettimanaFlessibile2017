@extends('layouts.app')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item disabled">
Profilo
</a>
<a href="{{route('courses')}}" class="list-group-item">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
@endsection


@section('content')
<?php 
$start = microtime(true);

$sessions_courses_id = Auth::user()->sessions()->join('courses','courses.id','=','course_id')->select(array('sessions.*','courses.name'))->get()->toArray();
$courses_name_array = array();

foreach($sessions_courses_id as $key=>$session){
    for ($i_c=0;$i_c<9;$i_c++) { 
        $nd = ("f".($i_c+1));
        if($session["f".($i_c+1)] != "0"){
            $courses_name_array["f".($i_c+1)] = $session['name'];
        }
    }
}
$time_elapsed_secs = microtime(true) - $start;
echo $time_elapsed_secs;
foreach ($sessions_courses_id as $key => $value) {
    $courses_name_array[$value['sessionNumber']] = $value['name'];
}
?>
<div id="list-id" class="jumbotron" align="center" style=" border-color: #CCCCCC;border-width: 1px;border-style:solid;">
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
        @if(isset($courses_name_array['f1']))
        <td><a href="#">{{$courses_name_array['f1']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Lunedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f2']))
        <td><a href="#">{{$courses_name_array['f2']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Martedì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f3']))
        <td><a href="#">{{$courses_name_array['f3']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Martedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f4']))
        <td><a href="#">{{$courses_name_array['f4']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Mercoledì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f5']))
        <td><a href="#">{{$courses_name_array['f5']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Mercoledì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f6']))
        <td><a href="#">{{$courses_name_array['f6']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>1°</td>
        @if(isset($courses_name_array['f7']))
        <td><a href="#">{{$courses_name_array['f7']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f8']))
        <td><a href="#">{{$courses_name_array['f8']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f9']))
        <td><a href="#">{{$courses_name_array['f9']}}</a></td>
        @else
        <td><a href="#">Nessun corso selezionato.</a></td>
        @endif
    </tr>
  </tbody>
</table>
</div>
@endsection