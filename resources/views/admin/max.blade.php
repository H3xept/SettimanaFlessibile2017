

<?php 

$courses = App\Course::all();
$sessions = [];
$counter = 0;
foreach ($courses as $course) {
	$sessions[$course->id] = $course->maxStudentsPerSession;
	DB::table('porcodio')->where('course_id',$course->id)->update(['maxStudents'=>$course->maxStudentsPerSession]);
}


// $sessions_ = App\Session::all()->toArray();
// foreach ($sessions_ as $session) {
// 	for ($i=0; $i < 9; $i++) { 
// 		$key = "f".($i+1);
// 		if($session[$key] != 0){
// 			$course = App\Course::find($session['course_id'])->first();
// 			$counter += ($session['maxStudents'] + (count(explode(',',$course->refs))+1)) - $session['signedStudents'];	
// 		}
// 	}
// }
// echo $counter;

?>