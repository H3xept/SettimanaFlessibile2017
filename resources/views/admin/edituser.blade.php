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
<?php use App\User; $user = User::find($user_id);
$no_course_selected = '<a href="/courses/?behalf_user='.$user->id.'">Nessun corso selezionato.</a>';

$start = microtime(true);
$sessions = $user->sessions()->join('courses','courses.id','=','course_id')->select(array('sessions.*','courses.name'))->get()->toArray();
$courses_name_array = array();
$courses_id_session_array = array();
$courses_id_array = [];

foreach($sessions as $key=>$session){
    for ($i_c=0;$i_c<9;$i_c++) { 
        $nd = ("f".($i_c+1));
        if($session["f".($i_c+1)] != "0"){
            $courses_id_array["f".($i_c+1)] = array($session['course_id'],$session['sessionNumber']);
            $courses_name_array["f".($i_c+1)] = $session['name'];
        }
    }
}
$time_elapsed_secs = microtime(true) - $start;
echo $time_elapsed_secs;
foreach ($sessions as $key => $value) {
    $courses_name_array[$value['sessionNumber']] = $value['name'];
}
$refin = explode(",",$user->refin);
?>
<div id="list-id" class="jumbotron" align="center" style=" border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:8px;">
<h4>In modifica: <i><b>{{$user->name}}</b> {{$user->class}}</i></h4>
</div>
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
        <td><a href="#">{{$courses_name_array['f1']}}</a>
        @if(!in_array($courses_id_array['f1'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f1Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f1'][0]}}/{{$courses_id_array['f1'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif
<script type="text/javascript">
    $("#f1Button").click(function(e) { var url = "/courses/{{$courses_id_array['f1'][0]}}/{{$courses_id_array['f1'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Lunedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f2']))
        <td><a href="#">{{$courses_name_array['f2']}}</a>
        @if(!in_array($courses_id_array['f2'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f2Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f2'][0]}}/{{$courses_id_array['f2'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif
<script type="text/javascript">
    $("#f2Button").click(function(e) { var url = "/courses/{{$courses_id_array['f2'][0]}}/{{$courses_id_array['f2'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Martedì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f3']))
        <td><a href="#">{{$courses_name_array['f3']}}</a>

        @if(!in_array($courses_id_array['f3'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f3Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f3'][0]}}/{{$courses_id_array['f3'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif

<script type="text/javascript">
    $("#f3Button").click(function(e) { var url = "/courses/{{$courses_id_array['f3'][0]}}/{{$courses_id_array['f3'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Martedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f4']))
        <td><a href="#">{{$courses_name_array['f4']}}</a>

        @if(!in_array($courses_id_array['f4'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button class="btn btn-danger pull-right" id="f4Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" href="/courses/{{$courses_id_array['f4'][0]}}/{{$courses_id_array['f4'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif

<script type="text/javascript">
    $("#f4Button").click(function(e) { var url = "/courses/{{$courses_id_array['f4'][0]}}/{{$courses_id_array['f4'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Mercoledì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f5']))
        <td><a href="#">{{$courses_name_array['f5']}}</a>

        @if(!in_array($courses_id_array['f5'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f5Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f5'][0]}}/{{$courses_id_array['f5'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif

<script type="text/javascript">
    $("#f5Button").click(function(e) { var url = "/courses/{{$courses_id_array['f5'][0]}}/{{$courses_id_array['f5'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Mercoledì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f6']))
        <td><a href="#">{{$courses_name_array['f6']}}</a>

        @if(!in_array($courses_id_array['f6'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f6Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f6'][0]}}/{{$courses_id_array['f6'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif

<script type="text/javascript">
    $("#f6Button").click(function(e) { var url = "/courses/{{$courses_id_array['f6'][0]}}/{{$courses_id_array['f6'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>1°</td>
        @if(isset($courses_name_array['f7']))
        <td><a href="#">{{$courses_name_array['f7']}}</a>

        @if(!in_array($courses_id_array['f7'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f7Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f7'][0]}}/{{$courses_id_array['f7'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif

<script type="text/javascript">
    $("#f7Button").click(function(e) { var url = "/courses/{{$courses_id_array['f7'][0]}}/{{$courses_id_array['f7'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f8']))
        <td><a href="#">{{$courses_name_array['f8']}}</a>

        @if(!in_array($courses_id_array['f8'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f8Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f8'][0]}}/{{$courses_id_array['f8'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif

<script type="text/javascript">
    $("#f8Button").click(function(e) { var url = "/courses/{{$courses_id_array['f8'][0]}}/{{$courses_id_array['f8'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f9']))
        <td><a href="#">{{$courses_name_array['f9']}}</a>

        @if(!in_array($courses_id_array['f9'][0],$refin))
        @if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
        <button id="f9Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f9'][0]}}/{{$courses_id_array['f9'][1]}}/unsign/{{$user_id}}"><i class="fa fa-trash"></i></button></td>
        @endif
        @endif
        
<script type="text/javascript">
    $("#f9Button").click(function(e) { var url = "/courses/{{$courses_id_array['f9'][0]}}/{{$courses_id_array['f9'][1]}}/unsign/{{$user_id}}"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!$no_course_selected!!}</td>
        @endif
    </tr>
  </tbody>
</table>
</div>

@endsection