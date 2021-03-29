@extends('master')
@section('title', $sede->nombre)


@section('content')

<div class="carro">
    <div class="container-fluid">        
        <div class="panel shadow mtop16">
            <div class="row ">
                <img src="{{ url('web/'.$sede->img_sede) }}" class = "w-100 imgsup" alt="">
            </div>
            <div class="header mtop16">
                <h2 class="title">
                    {{ $sede->nombre }}
                </h2>
            </div>
            <div class="inside">
                <div class="row mtop16">
                    <div class="col-md-12">
                        <div class="card-deck text-center mr-4">
                        <div class="card border-success">
                            <div class="card-body">
                                <p class="sed_icono">
                                    <i class="fas fa-map-marked-alt"></i>
                                </p>
                                
                                <h5 class="card-title sed_titulo">{{ $sede->lugar }}</h5>
                                <p class="sed_contenido">
                                    {{ $sede->direccion }}
                                </p>
                            </div>
                        </div>
                        <div class="card border-success">
                            <div class="card-body">
                                <p class="sed_icono">
                                    <i class="fas fa-phone"></i>
                                </p>
                                <h5 class="card-title sed_titulo">Área comercial</h5>
                                <p class="card-text sed_contenido">
                                    {{ $sede->telef1 }}
                                </p>
                                <h5 class="card-title sed_titulo">Consultas</h5>
                                <p class="card-text sed_contenido">
                                    {{ $sede->telef2 }}
                                </p>
                            </div>
                        </div>
                        <div class="card border-success">
                            <div class="card-body">
                                <p class="sed_icono">
                                    <i class="fas fa-at"></i>
                                </p>
                                <p class="card-text sed_contenido">
                                    {{ $sede->email }}
                                </p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="row mtop16">
                <div class="card w-100 mr-5 ml-5 mb-3">
                    <div class="embed-responsive embed-responsive-21by9">
                        {!! htmlspecialchars_decode($sede->ubicacion) !!}
                    </div>
                </div>
            </div>

            <div class="row no-gutters text-center d-flex align-items-center mr-4 ml-4">
                @foreach($sede->getGaleria as $img)
                <div class="col-md-3">
                    <div class="mr-2 mb-2">
                        <a href="{{ url('web/'.$img->imagen) }}" data-fancybox="gallery">
                            <img class="img-fluid" src="{{ url('web/'.$img->imagen) }}" alt="">
                        </a>
                    </div>
                </div>
                @endforeach
            </div> 
        </div>
    </div>


</div>


@endsection