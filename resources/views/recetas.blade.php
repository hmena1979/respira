@extends('connect.master')
@section('title','Respira')

@section('content')
<div class="box box_login shadow">
	<div class="header">
		<a href="{{ url('/') }}">
			<img src="{{ url('/static/images/logo.png') }}" alt="">
		</a>
	</div>
	<div class="inside">
		{!! Form::open(['url' => '/recetas']) !!}
		<label for="codigo">Código Receta:</label>
		<div class="input-group">
			<div class="input-group-text"><i class="fas fa-prescription"></i></div>
			{!! Form::text('codigo', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
		</div>
		{!! Form::submit('Ingresar',['class'=>'btn btn-success btn-block mtop16']) !!}
		{!! Form::close() !!}

		<div class="footer">
		</div>
	</div>

</div>
@stop