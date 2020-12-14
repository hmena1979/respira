@extends('admin.master')
@section('title','Doctores')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-md"></i> Doctores</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/doctor/add']) !!}
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
								<label for="especialidad">Especialidad:</label>
								{!! Form::text('especialidad', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-3">
								<label for="cmp">CMP:</label>
								{!! Form::text('cmp', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
								<label for="rne">RNE:</label>
								{!! Form::text('rne', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
								<label for="celular">Celular:</label>
								{!! Form::text('celular', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
								<label for="telefono">Teléfono:</label>
								{!! Form::text('telefono', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
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