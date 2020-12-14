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
						{!! Form::open(['url'=>'/admin/usuario/'.$user->id.'/password']) !!}
						<div class="row">					
							<div class="col-md-2">
								<label for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],$user->activo,['class'=>'custom-select', 'disabled']) !!}	
							</div>
							<div class="col-md-3">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', $user->nombre, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="apellido">Apellido:</label>
								{!! Form::text('apellido', $user->apellido, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-4">
								<label for="email">e-mail:</label>
								{!! Form::text('email', $user->email, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
                        </div>
                        <div class="row mtop16">
							<div class="col-md-4">
								<label for="password">Nueva contraseña:</label>
								{!! Form::password('password', ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-4">
								<label for="cpassword">Confirmar Contraseña:</label>
								{!! Form::password('cpassword', ['class'=>'form-control']) !!}
							</div>
						</div>
						{!! Form::submit('Cambiar', ['class'=>'btn btn-success mtop16']) !!}
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection