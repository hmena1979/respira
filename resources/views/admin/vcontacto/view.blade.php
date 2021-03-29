@extends('admin.master')
@section('title','Contacto')
@section('breadcrumb')

@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/vcontacto/'.$con->id.'/view']) !!}
						<div class="row mtop16">
							<div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', $con->nombre, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="telef">Teléfono/Celular:</label>
								{!! Form::text('telef', $con->telef, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="email">Correo electrónico:</label>
								{!! Form::text('email', $con->email, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
							</div>
						</div>
						<div class="row mtop16">							
							<div class="col-md-7">
								<label for="nombre">Asunto:</label>
								{!! Form::text('asunto', $con->asunto, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-2">
								<label for="fecha">Fecha:</label>
								{!! Form::text('asunto', $con->fecha, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="activo">Pendiente:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],$con->activo,['class'=>'custom-select']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-12">
								<label for="contenido">Contenido:</label>
								{!! Form::textarea('contenido',$con->contenido,['class'=>'form-control', 'rows'=>'6','disabled']) !!}
							</div>
						</div>
						
						{!! Form::submit('Guardar', ['class'=>'btn btn-danger mtop16']) !!}
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection