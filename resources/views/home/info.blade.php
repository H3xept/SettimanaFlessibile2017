@extends('layouts.app')
@section('navigation')
<a href="{{route('home')}}" class="list-group-item">
Profilo
</a>
<a href="{{route('courses')}}" class="list-group-item">Corsi disponibili</a>
<a href="{{route('info')}}" class="list-group-item disabled">Istruzioni</a>
<a href="{{route('tickets')}}" class="list-group-item">Aiuto</a>
@if(Auth::user()->hasEqualOrGreaterPermissionLevel(8))
<br><a href="{{route('admin_panel')}}" class="list-group-item">Admin</a>
@endif
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="jumbotron" style=" border-color: #CCCCCC;border-width: 1px;border-style:solid;">
<h3>Corsi disponibili</h3>
<p>la prima cosa da fare è scegliere i corsi che vorrai frequentare, facendo attenzione a non scegliere più di un corso per fascia per evitare una sovrapposizione.</p><hr>
<h3>I corsi possono essere: </h3>
<ul>
	<li>A fasce (ogni fascia è da 2 ore e ci si può iscrivere a più di una)
	</li>
	<li>Progressivo (un corso che presuppone la presenza in tutte le fasce del colore scelto)
	</li>
</ul><br>
<div class="alert alert-warning" role="alert"> Ogni colore corrisponde ad un appello, quindi scegliendo un colore ti inscriverai a tutte le fasce (del corso) corrispondenti a quel colore.</div>
<br>
<i><h5>Potrai vedere i corsi ai quali ti sei iscritto cliccando sull’icona “Profilo”</h5></i>
<hr>
<h4>Profilo</h4>
<p>Sulla pagina del profilo troverai l’agenda relativa ai corsi ai quali ti sei iscritto che  potrà essere modificata  in caso di iscrizione errata. Cliccando l’icona del cestino a destra del nome del corso potrai rimuovere l’iscrizione al corso che non vuoi frequentare, cosi da poterti inscrivere (tornando su “corsi disponibili”) ad un nuovo corso.</p>

<div class="alert alert-danger" role="alert">
	<b>ATTENZIONE:</b> la tua iscrizione sarà completa quando nell’agenda del tuo “profilo” risulterai iscritto a tutte le fasce .
</div>
		</div>
	</div>
</div>
@endsection