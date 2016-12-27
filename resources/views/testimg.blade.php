<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settimana Flessibile Galilei PG</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/bootstrap-theme.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css"/>
    <script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Settimana Flessibile Galilei PG</title>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body style="background-image:url('/img/patt.png'); background-repeat:repeat;">


<style type="text/css">
	.image { 
   position: relative; 
   width: 100%; /* for IE 6 */
   height:100%;
}
p { 
   position: absolute; 
   top: 20px; 
   width: 100%; 
   color: white;
   font-family: Impact;
   letter-spacing: 2px;
   font-size: 38px;
}
.stroke
{
    color: white;
    text-shadow:
    -1px -1px 0 #000,
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;  
}
</style>

<?php $starting_text = "Make me proud."; if(isset($_GET['text'])){$starting_text = htmlspecialchars(pg_escape_string($_GET['text']));} ?>
<div class="container" style="margin-top:16px;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="image" id="img-group">
				
			      <img class="img-rounded image" src="{{ URL::asset('/img/k.gif') }}" alt="" />
			      
			      <div align="center"><br>
			      <p class="stroke" id="txt">{{strtoupper($starting_text)}}</p>
			      </div>
				<div class="form-group">
  				
			      

          <div class="input-group">
            <input type="text" class="form-control" id="msgInput" value="{{$starting_text}}" onKeyUp="document.getElementById('txt').innerHTML=this.value.toUpperCase()">
            <span class="input-group-btn">
              <button class="btn btn-success" type="button" style="color:white;" id="shareBtn">Share me.</button>
            </span>
          </div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
	$('#shareBtn').click(function(){
		var txtValue = document.getElementById('msgInput').value;
		var host = window.location.href;
		host += "?text="+txtValue;
		BootstrapDialog.show({
		            title: 'Share with love please',
		            message: "<div class='input-group'><span class='input-group-addon' id='basic-addon3'>Here's your link: </span><input class='form-control' type='text' value='"+host+"'> </div>"
		        });
	});
</script>
</body>
</html>
