@extends('master')
@section('title','Contacto')


@section('content')

<div class="carro">
    <div class="container-fluid">
        
        <div class="panel shadow mtop16">
            <div class="row ">
                <img src="{{ url('static/images/contacto.jpg') }}" class = "w-100 imgsup" alt="">
            </div>
            <div class="header">
                <h2 class="title">
                    Contáctanos
                </h2>
            </div>
            <div class="inside">                
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::open(['url' => '/contacto']) !!}
                        <label for="nombre" class="mtop16">Apellidos y nombre:</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="fas fa-user-edit"></i></div>
                            {!! Form::text('nombre', '', ['class'=>'form-control mr-3','autocomplete'=>'off']) !!}
                        </div>
                        <label for="telef" class="mtop16">Teléfono ó celular:</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="fas fa-tty"></i></i></div>
                            {!! Form::text('telef', '', ['class'=>'form-control mr-3','autocomplete'=>'off']) !!}
                        </div>
                        <label for="email" class="mtop16">Correo Electrónico</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="far fa-envelope-open"></i></div>
                            {!! Form::email('email', null, ['class'=>'form-control mr-3','autocomplete'=>'off']) !!}
                        </div>
                        <label for="asunto" class="mtop16">Asunto:</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="far fa-comment"></i></div>
                            {!! Form::text('asunto', '', ['class'=>'form-control mr-3','autocomplete'=>'off']) !!}
                        </div>
                        <div class="mr-3">
                            <label for="contenido" class="mtop16">Descripción:</label>
                            {!! Form::textarea('contenido','',['class'=>'form-control', 'rows'=>'4']) !!}
                        </div>
                        <div class="mr-3">
                            {!! Form::submit('Enviar',['class'=>'btn btn-danger btn-block mtop16 mbottom10 mr-3']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    
                </div>                
            </div>        
        </div>
    </div>
</div>


@endsection