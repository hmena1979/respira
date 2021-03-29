@extends('admin.master')
@section('title','Imagen Principal')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/web/imgprins/') }}"><i class="fas fa-images"></i> Imagen Principal</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/web/imgprin/add', 'files' => true]) !!}
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