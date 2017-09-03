<?php 
use App\User;
function sessionsToName($sessions){
    $courses_name_array = array();
  foreach($sessions as $key=>$session){
      for ($i_c=0;$i_c<9;$i_c++) { 
          $nd = ("f".($i_c+1));
          if($session["f".($i_c+1)] != "0"){
            $courses_name_array["f".($i_c+1)] = $session['pivot']['session_id'];
          }
      }
  }
  return $courses_name_array;
}
 ?>

  <?php $start = microtime(true); ?>
  @foreach($data as $user)
  <?php 
    $sessions = User::find($user->id)->sessions()->join('courses','courses.id','=','course_id')->select(array('sessions.*','courses.name'))->get()->toArray();
    $names = sessionsToName($sessions);
    for ($i=0; $i < 9; $i++) { 
      if(!array_key_exists("f".($i+1),$names)){
        $names["f".($i+1)] = NULL;
      }
    }

    $user_upd = ['f1'=>$names['f1'],'f2'=>$names['f2'],'f3'=>$names['f3'],'f4'=>$names['f4'],'f5'=>$names['f5'],'f6'=>$names['f6'],'f7'=>$names['f7'],'f8'=>$names['f8'],'f9'=>$names['f9']];
    DB::table('users')->where('id',$user->id)->update($user_upd);

   ?>
  @endforeach

  <?php     $time_elapsed_secs = microtime(true) - $start;
    dd($time_elapsed_secs); ?>
</table>