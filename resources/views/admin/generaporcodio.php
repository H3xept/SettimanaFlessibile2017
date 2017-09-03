

<?php

$fakeSessions = [];

$db_sessions = DB::table('sessions')->get();
foreach ($db_sessions as $db_session) {
	$course_type = DB::table('courses')->where('id',$db_session->course_id)->select('type')->first()->type;
	if($course_type == 1){
		
		$iteration = [];
		for ($i=0; $i < 9; $i++) { 
			$key = "f".($i+1);
			if($db_session->$key != 0){
				$iteration[$key] = $db_session->$key;
			}
		}
		foreach ($iteration as $session_name => $value) {

			$newSession = clone $db_session;
			for ($c=0; $c < 9; $c++) { 
				$key2 = "f".($c+1);
				$newSession->$key2 = 0;
			}
			$newSession->$session_name = $value;
			array_push($fakeSessions, $newSession);
		}
	}else{
		$fakeSessions[] = $db_session;
	}
}

$id = 1;
foreach ($fakeSessions as $sess) {
	$sessArray = ['id'=>$id,
	'course_id'=>$sess->course_id,
	'f1'=>$sess->f1,
	'f2'=>$sess->f2,
	'f3'=>$sess->f3,
	'f4'=>$sess->f4,
	'f5'=>$sess->f5,
	'f6'=>$sess->f6,
	'f7'=>$sess->f7,
	'f8'=>$sess->f8,
	'f9'=>$sess->f9,
	'sessionNumber'=>$sess->sessionNumber,
	'maxStudents'=>$sess->maxStudents,
	'signedStudents'=>$sess->signedStudents];

DB::table('porcodio')->insert($sessArray);
$id++;
}


// function calcSessions($fakeSessions,$courses){
// 	$sessions = $fakeSessions;
// 	$sessions_return = [];

// 	foreach ($sessions as $session) {
// 		$course = $courses[$session->course_id -1];
// 		if($session->signedStudents < ($session->maxStudents)){
// 			$sessions[] = $session;
// 		}
// 	}
// 	$fakeSessions = $sessions;
// 	return $sessions;
// }

// $vals = [];
// 	$courses = DB::table('courses')->get();
// 	$users = DB::table('users')->get();

// 	foreach ($users as $user) {
// 		for ($i=0; $i < 9; $i++) { 
// 			$key = "f".($i+1);
// 			if($user->$key == NULL){
// 				//Register!
// 				$purified_sessions = calcSessions($fakeSessions,$courses);
// 				for ($pur=0; $pur < count($fakeSessions); $pur++) { 
// 					$session = $purified_sessions[$pur];
// 					if($session->$key != 0){
// 						$course_id = $session->course_id;
// 						$vals[$user->id][$key] = $course_id; 
// 						$fakeSessions[$pur]->signedStudents+=1;
// 					}
// 				}
// 			}
// 		}
// 	}dd($fakeSessions);


// 	$class_values = [];
// 	foreach ($vals as $user_id => $value) {
// 		$user_class = DB::table('users')->where('id',$user_id)->select('class')->first()->class;
// 		$class_values[$user_class][$user_id] = $value;
// 	}
	



?>