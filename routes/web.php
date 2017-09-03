<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\Course;
use Illuminate\Http\Request;
use App\Session;
use App\User;


Route::get('/', function () {
	if(Auth::user()->name == "MissingNo."){
		return view('admin.vito');
	}
	return view('home.home');

})->middleware('auth')->name('home');

Route::get('/home', function () {
	if(Auth::user()->name == "MissingNo."){
		return view('admin.vito');
	}
	return view('home.home');

})->middleware('auth');//Redundant

Route::get('/admin/corr',function(){
	if(!Auth::user()->hasEqualOrGreaterPermissionLevel(10)){
		return view('admin.closed');
	}
	return view("admin.correzioni");
});


Route::get('/admin/tablecorr',function(){
	if(!Auth::user()->hasEqualOrGreaterPermissionLevel(10)){
		return view('admin.closed');
	}
		$data = DB::table('users')->select(['id','name','f1','f2','f3','f4','f5','f6','f7','f8','f9'])->get();

	return view("admin.tablecorrection")->withData($data);
});
Route::get('/admin/max',function(){
	if(!Auth::user()->hasEqualOrGreaterPermissionLevel(10)){
		return view('admin.closed');
	}
	return view("admin.max");
});
Route::get('/missingno',function(){
	if(Auth::user()->name == "MissingNo." || Auth::user()->hasEqualOrGreaterPermissionLevel(10)){
		return view('admin.vito');
	}return route('home');
})->middleware('auth')->name('missingno');

Route::get('/courses', function () {
	if(!Auth::user()->hasEqualOrGreaterPermissionLevel(6)){
		return view('admin.closed');
	}
	if(Auth::user()->name == "MissingNo."){
		return view('admin.vito');
	}
	$courses = DB::table('courses')->get();
    return view('home.courses')->with(['courses'=>$courses]);
})->middleware('auth')->name('courses');

Route::get('/courses/generate/{id}',function($id){
	if(!Auth::user()->hasEqualOrGreaterPermissionLevel(6)){
		return view('admin.closed');
	}
	if(Auth::user()->name == "MissingNo."){
		return view('admin.vito');
	}
	$course = Course::find($id);
	return view('admin.coursescalls')->withCourse($course);
})->middleware('auth')->name('sign');
Route::post('/courses/{course_id}/sign',['uses'=>'UsersController@sign'])->middleware('auth')->name('sign');
Route::post('/courses/{course_id}/sign/{user_id?}',['uses'=>'UsersController@sign'])->middleware('auth')->name('sign');
Route::get('/courses/{course_id}/{session_number}/unsign/{user_id?}',['uses'=>'UsersController@unsign'])->middleware('auth')->name('unsign');


Route::get('/tickets',['uses'=>'TicketsController@index'])->middleware('auth')->name('tickets');
Route::post('/tickets/new',['uses'=>'TicketsController@store'])->middleware('auth')->name('new_ticket');
Route::get('/tickets/{ticket_id}/delete',['uses'=>'TicketsController@delete'])->middleware('auth')->name('del_ticket');

Route::get('/istruzioni',function(){
	if(!Auth::user()->hasEqualOrGreaterPermissionLevel(6)){
		return view('admin.closed');
	}
	if(Auth::user()->name == "MissingNo."){
		return view('admin.vito');
	}
	return view('home.info');
})->name('info');

// ---- Admin ------
Route::get('/admin',function(){
	$user = Auth::user();
	if($user->hasEqualOrGreaterPermissionLevel(6)){
		return view('admin.panel');
	}
	return Redirect::route('home',['msg'=>'rekt']);

})->middleware('auth')->name('admin_panel');

Route::get("/testimage",function(){
	return view('testimage');
});
//Appelli
Route::post('/appeals',function(Request $request){
	$user = Auth::user();
	if($user->hasEqualOrGreaterPermissionLevel(6)){

		$input = $request->input();
		$class = $input['class'];
		$section = $input['section'];
		$class_string = $class.$section;
		$data = DB::table('users')->where('class',$class_string)->select(['id','name','f1','f2','f3','f4','f5','f6','f7','f8','f9'])->get();
		return view('admin.table')->withData($data);
	}
	return Redirect::route('home',['msg'=>'rekt']);
})->middleware('auth')->name('get_classes');

Route::get("/admin/loadRefs",function(){
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		$users = User::all();
		foreach ($users as $user) {
		foreach (explode(",",$user->refin) as $refin_number) {
			$course_ = DB::table('courses')->where('id',$refin_number)->first();
			// $sessions_ = DB::table('sessions')->where('course_id',$refin_number)->get();
			$sessions_ = Session::where('course_id',$refin_number)->get();
			foreach ($sessions_ as $session_) {
				if($session_ != null){
					$user->sessions()->attach($session_);
				}
			}
		}
		}
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
});

Route::get("/admin/loadUsers",function(){
	$user = Auth::user();
	if($user->hasEqualOrGreaterPermissionLevel(10)){
		ini_set('max_execution_time', 500);
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		DB::table('users')->truncate();
		DB::table('role_user')->truncate();
		DB::table('session_user')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
		$users = DB::table('users_installer')->get()->toArray();
		$users_array = array();
		foreach ($users as $user_) {
			$data = ['name'=>$user_->name,
			'surname'=>$user_->surname,
			'username'=>$user_->username,
			'class'=>$user_->class,
			'refin'=>$user_->refin,
			'password'=>bcrypt($user_->password),
			"created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()];
            $users_array[] = $data;
		}
		DB::table('users')->insert($users_array);

       	DB::table('users')->insert(array(
                array(
                	'id'=>1448,
                    'name' => 'Leonardo',
                    'surname' => 'Cascianelli',
                    'username' => "H3xept",
                    'class' => "5L",
                    'password' => "Change me"
                )
            ));
       	$roles = [];
       	for ($i=0; $i < count($users); $i++) { 
       		$roles[] = array('user_id' => $i+1,'role_id' => 3);
       	}
       	DB::table('role_user')->insert($roles);
        DB::table('role_user')->insert(array(
                 array(
                     'user_id'=>1448,
                     'role_id'=>1
                 )
             ));

	$users_ = User::all();
		foreach ($users_ as $user_) {
	    if($user_->refin != null){
	    foreach (explode(",",$user_->refin) as $refin_) {
	    	$course_ = DB::table('courses')->where('id',$refin_)->first();
	    	if($course_){
	    		try {
	    			$where = ['f1'=>$course_->f1,'f2'=>$course_->f2,'f3'=>$course_->f3,'f4'=>$course_->f4,'f5'=>$course_->f5,'f6'=>$course_->f6,'f7'=>$course_->f7,'f8'=>$course_->f8,'f9'=>$course_->f9];
	    		} catch (Exception $e) {
	    			dd($course_);
	    		}

	    	foreach ($where as $key => $value) {
	    		if($value != 0){
	    			$user_->$key = $course_->id;
	    			$user_->save();
	    		}
	    	}}
	    }}
	}


		return Redirect::route('admin_panel',['msg'=>'ok']);
		
	}

	return Redirect::route('home',['msg'=>'rekt']);
})->middleware('auth')->name('loadUsers');

Route::get("/admin/loadCourses",function(){

	$user = Auth::user();
	if($user->hasEqualOrGreaterPermissionLevel(10)){
		ini_set('max_execution_time', 120);
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		DB::table('session_user')->truncate();
		DB::table('sessions')->truncate();
		DB::table('courses')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
		$rows = DB::table('courses_installer')->get();
		foreach ($rows as $request) {

	    	$course = new Course;
	    	$course->name = str_replace('\\','',$request->name);
	    	$course->desc = str_replace('\\','',$request->desc);
	    	$course->ref = $request->ref;
	    	$course->pRef = $request->pRef;
	    	$course->ext = $request->ext;
	    	$course->type = $request->type;
	    	$course->maxStudentsPerSession = $request->maxStudentsPerSession;
	    	
	        if($course->type == 1){//progressive
	            $course->f1 = $request->f1 ?? 0;
	            $course->f2 = $request->f2 ?? 0;
	            $course->f3 = $request->f3 ?? 0;
	            $course->f4 = $request->f4 ?? 0;
	            $course->f5 = $request->f5 ?? 0;
	            $course->f6 = $request->f6 ?? 0;
	            $course->f7 = $request->f7 ?? 0;
	            $course->f8 = $request->f8 ?? 0;
	            $course->f9 = $request->f9 ?? 0;

	            $sessions = array("f1"=>$request->f1,"f2"=>$request->f2,"f3"=>$request->f3,"f4"=>$request->f4,"f5"=>$request->f5,"f6"=>$request->f6,"f7"=>$request->f7,"f8"=>$request->f8,"f9"=>$request->f9);

	            $first = array();
	            $second = array();
	            $third = array();
	            foreach ($sessions as $key=>$session_value) {
	                if($session_value == "1"){
	                    $first[$key] = $session_value;
	                    $course->sessionY = 1;
	                }else if($session_value == "2"){
	                    $second[$key] = $session_value;
	                    $course->sessionG = 1;
	                }else if($session_value == "3"){
	                    $third[$key] = $session_value;
	                    $course->sessionB = 1;
	                }
	            }
	            $cont = array('0'=>$first,'1'=>$second,'2'=>$third);

	            if($course->save()){
	                foreach ($cont as $key=>$sess) {
	                    if(count($sess) > 0){
	                        $session_obj = new Session($sess);
	                        $session_obj->sessionNumber = $key;
	                        $course->sessions()->save($session_obj);
	                    }
	                }
	            }
	        }else{
	            $course->f1 = $request->f1 ?? 0;
	            $course->f2 = $request->f2 ?? 0;
	            $course->f3 = $request->f3 ?? 0;
	            $course->f4 = $request->f4 ?? 0;
	            $course->f5 = $request->f5 ?? 0;
	            $course->f6 = $request->f6 ?? 0;
	            $course->f7 = $request->f7 ?? 0;
	            $course->f8 = $request->f8 ?? 0;
	            $course->f9 = $request->f9 ?? 0;
	            if($course->save()){
	                $sessions = array("f1"=>$request->f1,"f2"=>$request->f2,"f3"=>$request->f3,"f4"=>$request->f4,"f5"=>$request->f5,"f6"=>$request->f6,"f7"=>$request->f7,"f8"=>$request->f8,"f9"=>$request->f9);
	                foreach ($sessions as $key => $session_value) {
	                    if($session_value != "0" && $session_value){
	                        $session_obj = new Session([$key=>$session_value]);
	                        $index = intval(substr($key,1))-1;
	                        $session_obj->sessionNumber = $index;
	                        $course->sessions()->save($session_obj);
	                    }
	                }
	            }
	        }

	       $numberOfSessions = count(DB::table('sessions')->where('course_id',$course->id)->get());
	       $course->maxTot = $numberOfSessions*$course->maxStudentsPerSession;
	       $course->save();
	       
		}return Redirect::route('admin_panel',['msg'=>'ok']);
	}
	return Redirect::route('home',['msg'=>'rekt']);
})->middleware('auth')->name('loadCourses');

Route::get('/admin/edit/{user_id}',function($user_id){
	$user = Auth::user();
	if($user->hasEqualOrGreaterPermissionLevel(6)){
		return view('admin.edituser')->with('user_id',$user_id);
	}
	return Redirect::route('home',['msg'=>'rekt']);

})->middleware('auth')->name('user_edit');
// ---- !Admin ------

Route::get("/testimg",function(){
	return view('testimg');
});
//Temporary ---------
//Temporary ---------

Auth::routes();

