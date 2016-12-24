@extends('layouts.app')
@section('navigation')
<a href="{{route('home')}}" class="list-group-item">
Profilo
</a>
<a href="{{route('courses')}}" class="list-group-item">Corsi disponibili</a>
<a href="#" class="list-group-item">Istruzioni</a>
<a href="{{route('tickets')}}" class="list-group-item disabled">Aiuto</a>
<br><a href="{{route('admin_panel')}}" class="list-group-item">Admin</a>
@endsection

@section('content')

    <?php
        if(isset($_GET['msg'])){

        $msg = htmlspecialchars($_GET['msg']);
        $class = "alert-success";
        if($msg == "succ"){ $txt = "Ticket creato con successo. Riceverai una risposta al più presto.";}
        else if($msg == "err"){ $txt = "C'è stato un problema interno, contattare <a href='https://www.facebook.com/H3xept'> Leonardo Cascianelli </a> per ulteriori info."; $class = "alert-warning";}

        echo '<div class="alert '.$class.'" id="alert" style="margin-bottom:24px;">
                <button type="button" class="close" data-dismiss="alert">x</button>
                '.$txt.'
                </div>';
        }
    ?>

	  <div class="row">
	  	<div class="col-md-12">
	  		<div class="pull-right"><button class="btn btn-success" data-toggle="modal" data-target="#newTicket">Nuova richiesta di aiuto  <i class="fa fa-plus" aria-hidden="true"></i></button></div>
	  	</div>
	  </div>

	<div id="newTicket" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Problemi? Contattaci qua sotto.</h4>
	      </div>
	      <div class="modal-body">
	      <form action="{{route('new_ticket')}}" method="POST" id="createForm">
	      	{{csrf_field()}}
			<div class="form-group">
			  <label for="usr">Oggetto</label>
			  <input type="text" class="form-control" id="title" name="title" placeholder="Es. Problema con registrazione" required>
			</div>
			<div class="form-group">
			  <label for="comment">Descrivi il tuo problema</label>
			  <textarea class="form-control" rows="6" id="desc" name="desc" required></textarea>
			</div>
			<div class="form-group">
			  <label for="usr">Come possiamo contattarti? (Email, telefono...)</label>
			  <input type="text" class="form-control" id="addr" name="addr" required>
			</div>
			<input type="text" name="username" hidden="true" value="{{Auth::user()->name}}">
	      </div>
	      <div class="modal-footer">
	      	<button id="createButton" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-success">Invia</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
	      </div>
	    </div>
<script type="text/javascript">
    $("#createForm").submit(function(e){ var url = "/tickets/new"; $("#createButton").button('loading'); 
    	$.ajax({type: "POST",url: url,data: $(this).serialize(),success: function(data){window.location = "/tickets?msg=succ"},error: function(){$("#createButton").button('reset'); window.location = "/tickets?msg=err"}}); e.preventDefault();});
</script>
		</form>
	  </div>
	</div>

	  @foreach($tickets->reverse() as $ticket)
		<div class="jumbotron" style="border-color:#CCCCCC;border-width:1px;border-style:solid; padding-top:8px; padding-bottom:8px; margin-top:16px;">
		<h4>{{$ticket->title}} <small>{{$ticket->username}}</small> <small><label class="label label-default pull-right">{{date('D m Y H:i', strtotime($ticket->created_at))}}</label></small></h4><hr>
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#{{$ticket->id}}ticket">Mostra</button>
		<button id="{{$ticket->id}}delButton" data-loading-text="<i class='fa fa-spinner fa-spin'>" class="btn btn-danger">Elimina</button>
		</div>
		<div id="{{$ticket->id}}ticket" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">{{$ticket->title}}</h4>
		      </div>
		      <div class="modal-body">
		        <p>{{$ticket->desc}}</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
		      </div>
		    </div>

		  </div>
		</div>

<script type="text/javascript">
    $("#{{$ticket->id}}delButton").click(function(e) { var url = "/tickets/{{$ticket->id}}/delete"; $(this).button('loading'); $.ajax({type: "GET",url: url,data: $(this).serialize(),success: function(data){location.reload();},error: function(){$("#{{$ticket->id}}delButton").button('reset');}});});
</script>
	  @endforeach
	  @if(count($tickets) <= 0)
		<div id="list-id" class="jumbotron" style="border-color: #CCCCCC;border-width: 1px;border-style:solid; padding-top:8px; padding-bottom:8px; margin-top:16px;">
		<h4 align="center">Nessuna richiesta.</h4>
		</div>
	  @endif

<script>
	window.setTimeout(function() {
	    $("#alert").fadeTo(500, 0).slideUp(500, function(){
	        $(this).remove(); 
	    });
	}, 4000);
</script>
@endsection