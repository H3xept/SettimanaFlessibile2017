

<?php 
set_time_limit (300);
function calcSession($courses){
	$sess = DB::table("porcodio")->get();
		$sessions = [];
	foreach ($sess as $session) {
		$course = $courses[$session->course_id -1];
		if($session->signedStudents < ($session->maxStudents + (count(explode(',',$course->ref))+1))){
			$sessions[] = $session;
		}
	}
	return $sessions;	
}

	$counter = 0;
	$courses = DB::table('courses')->select('ref')->get();
	$new_users = [];
	$vals = [];
	$sessions = calcSession($courses);
	$users = DB::table('users')->get()->toArray();


	foreach ($users as $user) {
		for ($i=0; $i < 9; $i++) { 
			$sessions = calcSession($courses);
			$key = "f".($i+1);

			if(!array_key_exists($user->id, $new_users)){
				$temp_user = $user;
				// for ($c=0; $c < 9; $c++) { 
				// 	$k = "f".($c+1);
				// 	if($temp_user->$k != NULL){
				// 		$temp_user->$k = NULL;
				// 	}
				// }
				$new_users[$user->id] = $temp_user;
			}

			if($user->$key == NULL){
				foreach ($sessions as $session) {
					if($session->$key != 0){
						$index = $user->id;
						$course_name_ = DB::table('courses')->where('id',$session->course_id)->select('name')->first()->name;
						$vals[$index][$key] = $course_name_;
						$course_name_ = DB::table('courses')->where('id',$session->course_id)->select('name')->first()->name;
						$new_users[$user->id]->$key = $course_name_;
			            DB::table('porcodio')
			                    ->where('id', $session->id)
			                    ->increment('signedStudents');
			                   $counter++;
						break;
					}
				}
			}else{
				$temp_user = $new_users[$user->id];
				$temp_user->$key = NULL;
				$new_users[$user->id] = $temp_user;
			}
		}
	}

	$class_values = [];
	foreach ($vals as $user_id => $value) {
		$user_class = DB::table('users')->where('id',$user_id)->select('class')->first()->class;
		$class_values[$user_class][$user_id] = $value;
	}
	$vals = [];
	foreach ($new_users as $user) {
		for ($i=0; $i < 9; $i++) { 
			$key = "f".($i+1);
			if($user->$key != NULL){
				$course_name = DB::table("courses")->where("id",$user->$key)->first();
				if($course_name != NULL){
					$vals[$user->$key][$course_name->name][$key][] = $user->name." ".$user->surname." ".$user->class;
				}
			}
		}
	}
dd($vals);
?>

@foreach($class_values as $class => $value)
<table border="1" style="page-break-after: always;">
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
		<th>{{$class}}</th>
	</tr>
@foreach($value as $user_id => $sess_)
<?php $user_ = App\User::find($user_id);?>
	<tr>
	    <th align="left">{{$user_->name}} {{$user_->surname}}</th> 
	    <th>{{$sess_["f1"] or "x"}}</th>
	    <th>{{$sess_["f2"] or "x"}}</th>
	    <th>{{$sess_["f3"] or "x"}}</th>
	    <th>{{$sess_["f4"] or "x"}}</th>
	    <th>{{$sess_["f5"] or "x"}}</th>
	    <th>{{$sess_["f6"] or "x"}}</th>
	    <th>{{$sess_["f7"] or "x"}}</th>
	    <th>{{$sess_["f8"] or "x"}}</th>
	    <th>{{$sess_["f9"] or "x"}}</th>
	</tr>
@endforeach
</table><br>
@endforeach

<?php 
function convertSessionName($session_name){
	$arr = ["f1"=>"Lun 2°","f2"=>"Lun 3°","f3"=>"Mar 2°","f4"=>"Mar 3°","f5"=>"Mer 2°","f6"=>"Mer 3°","f7"=>"Gio 1°","f8"=>"Gio 2°","f9"=>"Gio 3°"];
	return $arr[$session_name];
}

 ?>
@foreach($vals as $course_id => $course)
@foreach($course as $course_name=>$sessions_)
@foreach($sessions_ as $session_name => $users_)
<table border="1">
	<tr>
	    <th>{{$course_name}}</th>
	    <th>{{convertSessionName($session_name)}}</th>
	</tr>
	<tr>
	<?php $l = 0; ?>
	@foreach($users_ as $user)
		@if($l < 9)
			<td>{{$user}}</td>
			<?php $l++;?>
		@else
			<td>{{$user}}</td></tr><tr>
			<?php $l = 0;?>
		@endif
	@endforeach
	</tr>
</table><br>
@endforeach
@endforeach
@endforeach


<?php

	// foreach ($vals as $key => $value) {
	// 	echo "#".$key.":<br>";
	// 	foreach ($value as $key2 => $value2) {
	// 		echo "".$key2."-".$value2."<br>";
	// 	}
	// }
 ?>