<div class="footer mtop16">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 text-center">
			<img src="{{ url('static/images/logo.png') }}" class="figure-img img-fluid rounded ml-2 mtop16" alt="">
			
			<h3 class="text-center titfoot">NOSOTROS</h3>
			<p class="ml-2 text-justify">{{ $nos->descorta }}</p>

		</div>
		<div class="col-md-3">
			<h3 class="mtop30 titfoot">SERVICIOS</h3>
			<ul class="lisfoot mtop16" style= "list-style-type: none">
				@foreach($esp as $es)
					<a href="{{ url('/'.$es->id.'/especialidades') }}">
						<li class="ml-3">
							{!! htmlspecialchars_decode($es->icono) !!} {{ $es->nom_corto }}
						</li>
					</a>
				@endforeach
			</ul>
		</div>
		<div class="col-md-3">
			<h3 class="mtop30 titfoot">CONTACTO</h3>
			<h3 class="mtop16">Llámanos al:</h3>
			<p class="lisfoot">{{ $nos->telefono }}</p>
			 @foreach($sed as $sede)
				 <h3 class="mtop30">{{ $sede->lugar }} </h3>
				<p>{{ $sede->direccion }}</br>{{ $sede->ciudad }}</p>
			 @endforeach
		</div>
		<div class="col-md-3">
			<h3 class="mtop30 titfoot">SÍGUENOS</h3>
			<a href=""><i class="fab fa-facebook-square icofoot"></i></a>
			<a href=""><i class="fab fa-youtube icofoot"></i></a>
			<a href=""><i class="fab fa-instagram-square icofoot"></i></a>
			<p class="lisfoot mtop30">{{$nos->razsoc}} <br/> RUC: {{$nos->ruc}}</p>
		</div>
	</div>
	</div>
</div>
<nav class="navbar fixed-bottom botinf nav justify-content-center">
	<a class="btn telfinf" href="#"><i class="fas fa-phone-alt"></i> {{ $nos->contacto }}</a>
	<a class="btn telfinf ml-4" href="{{ url('recetas')}}"><i class="fas fa-check-double"></i> Imprime tu receta</a>

</nav>