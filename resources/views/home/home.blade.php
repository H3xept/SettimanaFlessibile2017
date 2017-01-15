@extends('layouts.app')

@section('navigation')
<a href="{{route('home')}}" class="list-group-item disabled">
Profilo
</a>
<a href="{{route('courses')}}" class="list-group-item">Corsi disponibili</a>
<a href="{{route('info')}}" class="list-group-item">Istruzioni</a>
<a href="{{route('tickets')}}" class="list-group-item">Aiuto</a>
@if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
<br><a href="{{route('admin_panel')}}" class="list-group-item">Admin</a>
@endif
@endsection


@section('content')
<?php 
define('no_course_selected', '<a href="/courses">Nessun corso selezionato.</a>');

$sessions = Auth::user()->sessions()->join('courses','courses.id','=','course_id')->select(array('sessions.*','courses.name'))->get()->toArray();
$courses_name_array = array();
$courses_id_session_array = array();

foreach($sessions as $key=>$session){
    for ($i_c=0;$i_c<9;$i_c++) { 
        $nd = ("f".($i_c+1));
        if($session["f".($i_c+1)] != "0"){
            $courses_id_array["f".($i_c+1)] = array($session['course_id'],$session['sessionNumber']);
            $courses_name_array["f".($i_c+1)] = $session['name'];
        }
    }
}
foreach ($sessions as $key => $value) {
    $courses_name_array[$value['sessionNumber']] = $value['name'];
}
$refin = explode(",",Auth::user()->refin);
?>


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
        <?php $f1Course = DB::table('courses')->where('id',$courses_id_array['f1'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#0register">{{$courses_name_array['f1']}}</a>
        @if(!in_array($courses_id_array['f1'][0],$refin))
        <button id="f1Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f1'][0]}}/{{$courses_id_array['f1'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="0register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f1Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f1Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f1Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>


<script type="text/javascript">
    $("#f1Button").click(function(e) { var url = "/courses/{{$courses_id_array['f1'][0]}}/{{$courses_id_array['f1'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Lunedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f2']))
        <?php $f2Course = DB::table('courses')->where('id',$courses_id_array['f2'][0])->select('name','desc','ref')->first();?>

        <td><a href="#" data-toggle="modal" data-target="#1register">{{$courses_name_array['f2']}}</a>
        @if(!in_array($courses_id_array['f2'][0],$refin))
        <button id="f2Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f2'][0]}}/{{$courses_id_array['f2'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="1register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f2Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f2Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f2Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f2Button").click(function(e) { var url = "/courses/{{$courses_id_array['f2'][0]}}/{{$courses_id_array['f2'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Martedì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f3']))
        <?php $f3Course = DB::table('courses')->where('id',$courses_id_array['f3'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#2register">{{$courses_name_array['f3']}}</a>
        @if(!in_array($courses_id_array['f3'][0],$refin))
        <button id="f3Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f3'][0]}}/{{$courses_id_array['f3'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="2register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f3Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f3Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f3Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f3Button").click(function(e) { var url = "/courses/{{$courses_id_array['f3'][0]}}/{{$courses_id_array['f3'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Martedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f4']))
        <?php $f4Course = DB::table('courses')->where('id',$courses_id_array['f4'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#3register">{{$courses_name_array['f4']}}</a>
        @if(!in_array($courses_id_array['f4'][0],$refin))
        <button class="btn btn-danger pull-right" id="f4Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" href="/courses/{{$courses_id_array['f4'][0]}}/{{$courses_id_array['f4'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="3register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f4Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f4Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f4Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f4Button").click(function(e) { var url = "/courses/{{$courses_id_array['f4'][0]}}/{{$courses_id_array['f4'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Mercoledì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f5']))
        <?php $f5Course = DB::table('courses')->where('id',$courses_id_array['f5'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#4register">{{$courses_name_array['f5']}}</a>
        @if(!in_array($courses_id_array['f5'][0],$refin))
        <button id="f5Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f5'][0]}}/{{$courses_id_array['f5'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="4register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f5Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f5Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f5Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f5Button").click(function(e) { var url = "/courses/{{$courses_id_array['f5'][0]}}/{{$courses_id_array['f5'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Mercoledì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f6']))
        <?php $f6Course = DB::table('courses')->where('id',$courses_id_array['f6'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#5register">{{$courses_name_array['f6']}}</a>
        @if(!in_array($courses_id_array['f6'][0],$refin))
        <button id="f6Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f6'][0]}}/{{$courses_id_array['f6'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="5register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f6Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f6Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f6Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f6Button").click(function(e) { var url = "/courses/{{$courses_id_array['f6'][0]}}/{{$courses_id_array['f6'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>1°</td>
        @if(isset($courses_name_array['f7']))
        <?php $f7Course = DB::table('courses')->where('id',$courses_id_array['f7'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#6register">{{$courses_name_array['f7']}}</a>
        @if(!in_array($courses_id_array['f7'][0],$refin))
        <button id="f7Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f7'][0]}}/{{$courses_id_array['f7'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="6register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f7Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f7Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f7Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f7Button").click(function(e) { var url = "/courses/{{$courses_id_array['f7'][0]}}/{{$courses_id_array['f7'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>2°</td>
        @if(isset($courses_name_array['f8']))
        <?php $f8Course = DB::table('courses')->where('id',$courses_id_array['f8'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#7register">{{$courses_name_array['f8']}}</a>
        @if(!in_array($courses_id_array['f8'][0],$refin))
        <button id="f8Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f8'][0]}}/{{$courses_id_array['f8'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="7register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f8Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f8Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f8Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f8Button").click(function(e) { var url = "/courses/{{$courses_id_array['f8'][0]}}/{{$courses_id_array['f8'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
    <tr>
        <td>Giovedì</td>
        <td>3°</td>
        @if(isset($courses_name_array['f9']))
        <?php $f9Course = DB::table('courses')->where('id',$courses_id_array['f9'][0])->select('name','desc','ref')->first();?>
        <td><a href="#" data-toggle="modal" data-target="#8register">{{$courses_name_array['f9']}}</a>
        @if(!in_array($courses_id_array['f9'][0],$refin))
        <button id="f9Button" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger pull-right" href="/courses/{{$courses_id_array['f9'][0]}}/{{$courses_id_array['f9'][1]}}/unsign"><i class="fa fa-trash"></i></button></td>
        @endif
        <div id="8register" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i>{{$f9Course->name}}</i></h4>
              </div>
              <div class="modal-body">
                <h4 align="left"><b>Descrizione</b></h4>
                <p align="left">{{$f9Course->desc}}</p>
                <h4 align="left"><b>Referenti</b></h4>
                <p align="left">{{$f9Course->ref}}</p>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>

<script type="text/javascript">
    $("#f9Button").click(function(e) { var url = "/courses/{{$courses_id_array['f9'][0]}}/{{$courses_id_array['f9'][1]}}/unsign"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();}});});
</script>

        @else
        <td>{!!no_course_selected!!}</td>
        @endif
    </tr>
  </tbody>
</table>
</div>

<script>
    window.setTimeout(function() {
        $("#alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 4000);
</script>
@endsection