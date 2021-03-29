@extends('admin.master')
@section('title','Noticias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/noticias/') }}"><i class="far fa-newspaper"></i> Noticias</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/web/noticia/'.$not->id.'/edit', 'files' => true]) !!}
						<div class="row">
							<a href="{{ url('web/'.$not->imagen) }}" data-fancybox="gallery">
								<img src="{{ url('web/'.$not->imagen) }}" class = "img-fluid" alt="">
							</a>							
						</div>
						<div class="row mtop16">
							<div class="col-md-8">
								<label for="titulo">Título:</label>
								{!! Form::text('titulo', $not->titulo, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="fecha">Fecha:</label>
								{!! Form::text('fecha', $not->fecha, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],$not->activo,['class'=>'custom-select']) !!}	
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-12">
								<label for="contenido">Contenido:</label>
								{!! Form::textarea('contenido',$not->contenido,['class'=>'form-control', 'id'=>'editor']) !!}			
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-12">
								<label for="fuente">Fuente:</label>
								{!! Form::textarea('fuente',$not->fuente,['class'=>'form-control', 'rows'=>'4']) !!}			
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