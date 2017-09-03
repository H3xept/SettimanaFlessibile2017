<html>
	<head>
	    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap-theme.min.css')}}" rel="stylesheet">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>
	<body style="font-size:12px;">
	<style type="text/css">
		th, td {
		    padding: 15px;
		}
	</style>
	<div class="container-fluid">
		<div class="row-fluid">
		<div class="col-md-12">

<?php 

function val($sessionNumber){
		$arr = ["f1"=>"Lunedì 2° Fascia","f2"=>"Lunedì 3° Fascia",
		"f3"=>"Martedì 2° Fascia", "f4"=>"Martedì 3° Fascia",
		"f5"=>"Mercoledì 2° Fascia","f6"=>"Mercoledì 3° Fascia",
		"f7"=>"Giovedì 1° Fascia","f8"=>"Giovedì 2° Fascia","f9"=>"Giovedì 3° Fascia"];
		return $arr[$sessionNumber];
}
	$sessions = DB::table('sessions')->where('course_id',$course->id)->select('id')->get();
	$values = [];
	foreach ($sessions as $session) {
		$session_obj = App\Session::find($session->id);
		for ($i=0; $i < 9; $i++) { 
			$key = "f".($i+1);
			if($session_obj->$key != 0){
				$users = $session_obj->users()->get()->toArray();
				$values[val($key)] = $users;
			}
		}
	}
?>

@foreach($values as $session_ => $value)
<table border="1">
	<tr style="padding: 10px;">
		<th>{{$course->name}}</th>
		<th>{{$session_}}</th>
	</tr>
	<tr style="padding: 10px;">
	<?php $l = 0; ?>
	@foreach($value as $user)
	<?php $check = 0; foreach (explode(",",$user['refin']) as $refin) {
		if($refin == $course->id){
			$check = 1;
		}
	} ?>
	@if($check != 1)
		@if($l < 9)
			<th>{{$user['name']}} {{$user['surname']}} {{$user['class']}}</th>
			<?php $l++; ?>
		@else
			<th>{{$user['name']}} {{$user['surname']}} {{$user['class']}}</th></tr><tr>
			<?php $l = 0; ?>
		@endif
	@endif
	@endforeach
	</tr>
</table><br>
@endforeach
		</div>
		</div>
	</div>
	</body>
</html>
