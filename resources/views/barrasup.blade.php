<nav class="navbar navbar-dark bg-dark sticky-top navbar-expand-md botsup">
	<a class="" href=" {{ url('/') }} ">
		<img src="{{ url('static/images/logobar3.png') }}" width="210" height="70" class="d-inline-block align-top" alt="">
	</a>

	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class=""><i class="fas fa-chevron-down drop-down"></i></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<ul class="navbar-nav ml-auto text-center">
			<li class="nav-item dropdown">
				<a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nosotros</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="{{ url('/quienes') }}">Quienes somos</a>
				</div>
			</li>

			{{-- <li class="nav-item dropdown">
				<a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					@foreach($ser as $se)
					<a class="dropdown-item" href="{{ url('/'.$se->id.'/servicio') }}">{!! htmlspecialchars_decode($se->icono) !!} {{ $se->nom_corto }}</a>
					@endforeach
				</div>
			</li> --}}
			<li class="nav-item dropdown">
				<a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					@foreach($esp as $es)
					<a class="dropdown-item" href="{{ url('/'.$es->id.'/especialidades') }}">{!! htmlspecialchars_decode($es->icono) !!} {{ $es->nom_corto }}</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sedes</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					@foreach($sed as $s)
					<a class="dropdown-item" href="{{ url('/'.$s->id.'/sede') }}">{{ $s->lugar }}</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ url('/noticia') }}">Noticias</a>
			</li>
			{{-- <li class="nav-item">
				<a class="nav-link" href="{{ url('/contacto') }}">Contacto</a>
			</li> --}}
			<li class="nav-item">
				<a class="nav-link" href="{{ url('/admin') }}">Corporativo</a>
			</li>
		</ul>
	</div>
</nav>
