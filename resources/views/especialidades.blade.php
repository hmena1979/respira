@extends('master')
@section('title', $esp1->nom_corto)


@section('content')

<div class="carro">
    <div class="container-fluid">
        
        <div class="panel shadow mtop16">
            <div class="row ">
                <img src="{{ url('web/'.$esp1->imagen) }}" class = "w-100 imgsup" alt="">
            </div>
            <div class="header">
                <h2 class="title">
                    {{ $esp1->nombre }}
                </h2>
            </div>
            <div class="inside">
                <div class="row">
                    <div class="col-md-9 sepder">
                        {!! htmlspecialchars_decode($esp1->contenido) !!}
                    </div>
                    <div class="col-md-3">                        
                        <div class="titder">Servicios</div>
                        <ul class="lisder">
                            @foreach($esp as $es)
                                <a href="{{ url('/'.$es->id.'/especialidades') }}">
                                    @if($es->id==$esp1->id)
                                        <li class="ml-1 punteado act_sel">
                                            {!! htmlspecialchars_decode($es->icono) !!} {{ $es->nom_corto }}
                                        </li>
                                    @else
                                        <li class="ml-1 punteado ">
                                            {!! htmlspecialchars_decode($es->icono) !!} {{ $es->nom_corto }}
                                        </li>
                                    @endif
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>                
            </div>        
        </div>
    </div>


</div>


@endsection