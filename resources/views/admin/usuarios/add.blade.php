@extends('admin.master')
@section('title','Usuarios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/usuario/add']) !!}
						<div class="row">					
							<div class="col-md-2">
								<label for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],1,['class'=>'custom-select']) !!}	
							</div>
							<div class="col-md-5">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<label for="apellido">Apellido:</label>
								{!! Form::text('apellido', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-4">
								<label for="email">e-mail:</label>
								{!! Form::text('email', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="password">Contraseña:</label>
								{!! Form::password('password', ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-4">
								<label for="cpassword">Confirmar Contraseña:</label>
								{!! Form::password('cpassword', ['class'=>'form-control']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-6">
								<label for="doctor_id">Doctor asignado al usuario:</label>
								{!! Form::select('doctor_id',$doctores,1,['class'=>'custom-select']) !!}	
							</div>
						</div>
						{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection