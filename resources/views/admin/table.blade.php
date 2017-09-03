<?php 
use App\User;
function sessionsToName($sessions){
    $courses_name_array = array();
  foreach($sessions as $key=>$session){
      for ($i_c=0;$i_c<9;$i_c++) { 
          $nd = ("f".($i_c+1));
          if($session["f".($i_c+1)] != "0"){
            // dd($session['pivot']['session_id']);
            $courses_name_array["f".($i_c+1)] = $session['name'];
          }
      }
  }
  return $courses_name_array;
}
 ?>
<table>
  <tr>
    <th>Nome</th>
    <th>Lunedì 1°</th>
    <th>Lunedì 2°</th>
    <th>Martedì 1°</th>
    <th>Martedì 2°</th>
    <th>Mercoledì 1°</th>
    <th>Mercoledì 2°</th>
    <th>Giovedì 1°</th>
    <th>Giovedì 2°</th>
    <th>Giovedì 3°</th>
  </tr>
  <?php $start = microtime(true); ?>
  @foreach($data as $user)
  <?php 
    $sessions = User::find($user->id)->sessions()->join('courses','courses.id','=','course_id')->select(array('sessions.*','courses.name'))->get()->toArray();
    $names = sessionsToName($sessions);
    for ($i=0; $i < 9; $i++) { 
      if(!array_key_exists("f".($i+1),$names)){
        $names["f".($i+1)] = "x";
      }
    }
   ?>
  <tr>
    <td>{{$user->name}}</td> 
    <td>{{$names["f1"]}}</td>
    <td>{{$names["f2"]}}</td>
    <td>{{$names["f3"]}}</td>
    <td>{{$names["f4"]}}</td>
    <td>{{$names["f5"]}}</td>
    <td>{{$names["f6"]}}</td>
    <td>{{$names["f7"]}}</td>
    <td>{{$names["f8"]}}</td>
    <td>{{$names["f9"]}}</td>
  </tr>
  @endforeach

  <?php     $time_elapsed_secs = microtime(true) - $start;
    dd($time_elapsed_secs); ?>
</table>