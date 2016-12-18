@extends('layouts.app')

@section('content')

<form action="/storecourse" method="POST">
	{{csrf_field()}}
	<input type="text" name="name" placeholder="name">
	<input type="text" name="desc" placeholder="desc">
	<input type="text" name="ref" placeholder="ref">
	<input type="text" name="pRef" placeholder="pRef">
	<input type="text" name="ext" placeholder="ext">
	<input type="checkbox" name="type" placeholder="type">

	<div align="center">
<label class="radio-inline"><input type="radio" name="type" value="sf" checked="checked" required="">Singola Fascia</label>
<label class="radio-inline"><input type="radio" name="type" value="p">Progressivo</label>
</div>

<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th>Lunedì</th>
<th>Martedì</th>
<th>Mercoledì</th>
<th>Giovedì</th>
</tr>
</thead>
<tbody>
<tr>
<td><input type="checkbox" id="s" value="1" disabled="true"></td>
<td><input type="checkbox" id="s"  value="1" disabled="true"></td>
<td><input type="checkbox" id="s" value="1" disabled="true"></td>
<td><input type="checkbox" id="s" name="f7" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f7" value="1"></label></td>
</tr>
<tr>
<td><input type="checkbox" id="s" name="f1" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f1" value="1"></label></td>
<td><input type="checkbox" id="s" name="f3" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f3" value="1"></label></td>
<td><input type="checkbox" id="s" name="f5" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f5" value="1"></label></td>
<td><input type="checkbox" id="s" name="f8" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f8" value="1"></label></td>
</tr>
<tr>
<td><input type="checkbox" id="s" name="f2" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f2" value="1"></label></td>
<td><input type="checkbox" id="s" name="f4" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f4" value="1"></label></td>
<td><input type="checkbox" id="s" name="f6" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f6" value="1"></label></td>
<td><input type="checkbox" id="s" name="f9" value="1"><label id="p" type="colorSelector" class="label label-warning" style="box-shadow: rgb(196, 141, 62) 0px 3px 0px; user-select: none; vertical-align: middle; display: none;"><i class="fa fa-close"></i><input hidden="true" name="f9" value="1"></label></td>
</tr>
</tbody>
</table>
</div>

	<button type="submit">Submit</button>
</form>

	<script type="text/javascript">
	$(document).ready(function(){
		console.log("Coddio");
		$("input[id='s']").show();
		$("label[id='p']").hide();
	});

	$(document).ready(function(){
	    $('input[type="radio"]').click(function(){
	        if($(this).attr("value")=="sf"){
	            $("label[id='p']").hide();
	            $("input[id='s']").show();
	        }
	        if($(this).attr("value")=="p"){
	            $("input[id='s']").hide();
	            $("label[id='p']").show();
	        }
	    });
	});
	</script>
	
	<script>

		$('label[type="colorSelector"]').click(function(event) {

		event.stopPropagation();
		event.preventDefault();

		var yellow = "rgb(240, 173, 78)";
	  	var green  = "rgb(92, 184, 92)";
	  	var blue   = "rgb(91, 192, 222)";
	  	var white  = "rgb(238, 238, 238)";

	  	var yellowShade = "0px 3px 0px #C48D3E";
	  	var greenShade = "0px 3px 0px #3D7B3D";
	  	var blueShade = "0px 3px 0px #4394AC";
	  	var whiteShade = "0px 0px 0px #EEEEEE";

	  	if($(this).css("background-color") == yellow){
	  	  $(this).children("input").val("2");
	  	  $(this).css("background-color",green);
	  	  $(this).css("box-shadow",greenShade);

	  	} else if($(this).css("background-color") == green){

	  	  $(this).children("input").val("3");
	  	  $(this).css("background-color",blue);
	  	  $(this).css("box-shadow",blueShade);

	  	} else if($(this).css("background-color") == blue){

	  	  $(this).children("input").val("0");
	  	  $(this).css("background-color",white);
	  	  $(this).css("box-shadow",whiteShade);
	  	  $(this).css("color","#000000");
	  	  $(this).children("i").remove();
 		  $(this).append($("<i class='fa fa-ban'></i>"));

	  	} else{

	  	  $(this).children("input").val("1");
	  	  $(this).css("background-color",yellow);
	  	  $(this).css("box-shadow",yellowShade);
	  	  $(this).css("color","#FFFFFF");
	  	  $(this).children("i").remove();
	  	  $(this).append($("<i class='fa fa-close'></i>"));
	  	}  
	  
		});

	</script>

@endsection