@extends('master')
@section('title','Quiénes somos')


@section('content')

<div class="carro">
    <div class="container-fluid">
        
        <div class="panel shadow mtop16">
            <div class="row ">
                <img src="{{ url('static/images/quienes.jpg') }}" class = "w-100 imgsup" alt="">
            </div>
            <div class="header">
                <h2 class="title">
                    Quiénes somos
                </h2>
            </div>
            <div class="inside">                
                <div class="row">
                    <div class="col-md-9 sepder">
                        {!! htmlspecialchars_decode($nos->quiesomos) !!}
                    </div>
                    <div class="col-md-3">
                        <div class="titder">Especialidades</div>
                        <ul class="lisder">
                            @foreach($esp as $es)
                                <a href="{{ url('/'.$es->id.'/especialidades') }}">
                                    <li class="ml-1 punteado">
                                        {!! htmlspecialchars_decode($es->icono) !!} {{ $es->nom_corto }}
                                    </li>
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