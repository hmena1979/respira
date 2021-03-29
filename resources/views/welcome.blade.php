@extends('master')
@section('title','CNN Respira')


@section('content')

<div class="carro">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @php($contador = 0)
            @foreach($imp as $i)
            @if($contador == 0)
                @php($contador = 1)
                <div class="carousel-item active">
                    <img src="{{ url('/web/'.$i->imagen) }}" class=" w-100" alt="...">
                </div>
            @else
               <div class="carousel-item">
                    <img src="{{ url('/web/'.$i->imagen) }}" class=" w-100" alt="...">
                </div>
            @endif
            @endforeach            
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span><i class="fas fa-chevron-left"></i></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span><i class="fas fa-chevron-right"></i></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>
    <div class="container-fluid">
        <div class="row especilidades">
            <div class="col-md-4 d-flex justify-content-center justify-content-centers especial text-center">                
                <h3 class="mtop16 negrita"><i class="fas fa-hand-holding-medical icoesp mtop30"></i><br/>SERVICIOS</h3>
            </div>
            @php($contador = 1)
            @php($columna1 = 1)
            @php($columna2 = 1)
            <div class="enlesp col-md-4 text-center mbottom10">
            @foreach($esp as $es)            
                @if($contador <= round(count($esp)/2))
                    <a href="{{ url('/'.$es->id.'/especialidades') }}" class="btn btn-link btn-lg btn-block text-left mtop20 d-flex align-items-center"><span class="icoesp mr-4">{!! htmlspecialchars_decode($es->icono) !!}</span>{{ $es->nom_corto }}</a>
                @else
                    @if($columna2 === 1)
                        @php($columna2 = 0)
                        </div>
                        <div class="enlesp col-md-4 text-center mbottom10">
                    @endif
                    <a href="{{ url('/'.$es->id.'/especialidades') }}" class="btn btn-link btn-lg btn-block text-left mtop20 d-flex align-items-center"><span class="icoesp mr-4">{!! htmlspecialchars_decode($es->icono) !!}</span>{{ $es->nom_corto }}</a>
                @endif
                @php($contador = $contador + 1)
            @endforeach
            </div>
        </div>
    </div>
    <div class="container-fluid mtop16">
        <div class="row">
            <img src="{{ url('static/images/sedes1.jpg') }}" class=" w-100" alt="">
        </div>
        <div class="row mtop16 d-flex justify-content-center">
            <div class="card-deck text-center mr-2 ml-2">
                @foreach($sed as $sede)
                <div class="card shadow border-success">
                    <img src="{{ url('web/'.$sede->img_princ) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title sed_titulo">{{ $sede->lugar }}</h5>
                        <p class="sed_contenido">
                            {{ $sede->direccion }}
                        </p>
                        <p class="sed_contenido">
                            {{ $sede->referencia }}
                        </p>
                        <p class="sed_contenido">
                            {{ $sede->ciudad }}
                        </p>
                        <a href="{{ url('/'.$sede->id.'/sede') }}" class="btn btn-success">Visitar</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mtop16">
            <img src="{{ url('static/images/noticias1.jpg') }}" class=" w-100" alt="">
        </div>
        <div class="row mtop16 d-flex justify-content-center">            
            <div class="card-deck text-center mr-2 ml-2">
                @foreach($not as $noticia)
                <div class="card shadow border-success">
                    <img src="{{ url('web/'.$noticia->imagen) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $noticia->titulo }}</h5>
                        <a href="{{ url('/'.$noticia->id.'/vnoticia') }}" class="btn btn-success">Visitar</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection