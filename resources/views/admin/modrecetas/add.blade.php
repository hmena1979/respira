@extends('admin.master')
@section('title','Modelo de Receta')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/modrecetas') }}"><i class="fas fa-prescription"></i> Modelo de Receta</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/modreceta/add']) !!}
						<div class="row">
							<div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],1,['class'=>'custom-select']) !!}	
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