@extends('admin.master')
@section('title','Sedes')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/web/sedes/') }}"><i class="fas fa-city"></i> Sedes</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/web/sede/add', 'files' => true]) !!}
						<div class="row">							
							<div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<label for="lugar">Lugar:</label>
								{!! Form::text('lugar', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-4">
								<label for="direccion">Dirección:</label>
								{!! Form::text('direccion', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="referencia">Referencia:</label>
								{!! Form::text('referencia', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="ciudad">Ciudad:</label>
								{!! Form::text('ciudad', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>

						</div>
						<div class="row mtop16">
							<div class="col-md-6">
								<label for="img_princ" class="mtop16">Imagen Principal:</label>
								<div class="custom-file">
									{!! Form::file('img_princ', ['class'=>'custom-file-input','id'=>'img_princ', 'accept'=>'image/*']) !!}
									<label class="custom-file-label" for="img_princ" data-browse="Buscar">Elegir imagen principal</label>
								</div>								
							</div>
							<div class="col-md-6">
								<label for="img_sede" class="mtop16">Imagen sede:</label>
								<div class="custom-file">
									{!! Form::file('img_sede', ['class'=>'custom-file-input','id'=>'img_sede', 'accept'=>'image/*']) !!}
									<label class="custom-file-label" for="img_sede" data-browse="Buscar">Elegir imagen sede</label>
								</div>								
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-3">
								<label for="telef1">Teléfono:</label>
								{!! Form::text('telef1', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="telef2">Consultas:</label>
								{!! Form::text('telef2', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<label for="email">e-mail:</label>
								{!! Form::text('email', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-6">
								<label for="ubicacion">Ubicación(Google Maps):</label>
								{!! Form::text('ubicacion', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],1,['class'=>'custom-select']) !!}	
							</div>
						</div>
						
						<div class="row mtop10">
							<div class="col">
								{!! Form::submit('Guardar', ['class'=>'btn btn-agregar']) !!}
							</div>
						</div>
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection