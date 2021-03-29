@extends('master')
@section('title','Noticias')


@section('content')

<div class="carro">
    <div class="container-fluid">        
        <div class="panel shadow mtop16">
            <div class="inside">                
                <div class="row mr-3">
                    <div class="col-md-12">
                        <div class="row d-flex justify-content-center">                            
                        @foreach($not as $noticia)
                        <div class="col-md-4 mtop16">
                            <div class="card shadow border-success h-100">
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
                        </div>
                        @endforeach                        
                        </div>
                        <div class="mtop16">
                            {{ $not->links() }}
                        </div>
                    </div>
                </div>                
            </div>        
        </div>
    </div>
</div>


@endsection