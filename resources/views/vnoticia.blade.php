@extends('master')
@section('title', $noticia->titulo)


@section('content')

<div class="carro">
    <div class="container-fluid">
        
        <div class="panel shadow mtop16">
            <div class="header">
                <h2 class="title">
                    {{ $noticia->titulo }}
                </h2>
            </div>
            <div class="inside">
                <div class="row">
                    <div class="col-md-9 sepder">
                        <div class="row">
                            <p class="tnoticia mtop16 ml-3">
                                {{ $noticia->fecha }}
                            </p>
                            <img src="{{ url('uploads/not/'.$noticia->imagen) }}" class = "w-100 imgsup" alt="">
                        </div>
                        <div class="tnoticia mtop16">
                            {!! htmlspecialchars_decode($noticia->contenido) !!}
                            <p class="negrita cursiva">Fuente:</p>
                            <div class="cursiva">
                                {!! htmlspecialchars_decode($noticia->fuente) !!}
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">                        
                        <div class="titder text-center">Notas de interés</div>
                        @foreach($not as $noticia)
                            <div class="card shadow border-success mr-3 mtop16">
                                <img src="{{ url('web/'.$noticia->imagen) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                                    <div class="text-center">
                                        <a href="{{ url('/'.$noticia->id.'/vnoticia') }}" class="btn btn-success btn-block"><i class="fas fa-eye"></i> Ver contenido</a>
                                    </div>                                    
                                </div>
                                <div class="card-footer text-muted">
                                    {{ $noticia->fecha }}
                                </div>
                            </div>
                        @endforeach 
                    </div>
                </div>                
            </div>        
        </div>
    </div>


</div>


@endsection