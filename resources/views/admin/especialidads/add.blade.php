@extends('admin.master')
@section('title','Servicios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/web/especialidads/') }}"><i class="fas fa-hand-holding-medical"></i> Servicios</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/web/especialidad/add', 'files' => true]) !!}
						<div class="row">
							<div class="col-md-3">
								<label for="icono">Ícono:</label>
								<div class="row no-gutters">
									<div class="col-md-10">
										{!! Form::text('icono', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-2">								
										<a href="https://fontawesome.com/icons?d=gallery&m=free" target="_black" class="btn btn-dark"><i class="fas fa-search"></i></a>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="nom_corto">Nombre corto:</label>
								{!! Form::text('nom_corto', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
								<label for="imagen" class="mtop16">Imagen:</label>
								<div class="custom-file">
									{!! Form::file('imagen', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'image/*']) !!}
									<label class="custom-file-label" for="customFile" data-browse="Buscar">Elegir imagen</label>
								</div>
							</div>
							<div class="col-md-3">
								<label for="activo" class="mtop16">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],1,['class'=>'custom-select']) !!}	
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-12">
								<label for="contenido">Contenido:</label>
								{!! Form::textarea('contenido','',['class'=>'form-control', 'id'=>'editor']) !!}			
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
@section('script')
<script>
$(document).ready(function(){
	editor_init('editor');
})
</script>
@endsection
{{-- @section('script')
<script>
	$(document).ready(function(){
		editor_init('editor');
	})
</script>
@endsection --}}