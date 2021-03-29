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
			<div class="col-md-9">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/web/sede/'.$sed->id.'/edit', 'files' => true]) !!}
						<div class="row">
							<a href="{{ url('web/'.$sed->img_sede) }}" data-fancybox="gallery">
								<img src="{{ url('web/'.$sed->img_sede) }}" class = "img-fluid" alt="">
							</a>	
						</div>
						<div class="row mtop16">							
							<div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', $sed->nombre, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<label for="lugar">Lugar:</label>
								{!! Form::text('lugar', $sed->lugar, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-4">
								<label for="direccion">Dirección:</label>
								{!! Form::text('direccion', $sed->direccion, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="referencia">Referencia:</label>
								{!! Form::text('referencia', $sed->referencia, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="ciudad">Ciudad:</label>
								{!! Form::text('ciudad', $sed->ciudad, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
								{!! Form::text('telef1', $sed->telef1, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="telef2">Consultas:</label>
								{!! Form::text('telef2', $sed->telef2, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<label for="email">e-mail:</label>
								{!! Form::text('email', $sed->email, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-6">
								<label for="ubicacion">Ubicación(Google Maps):</label>
								{!! Form::text('ubicacion', $sed->ubicacion, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],$sed->activo,['class'=>'custom-select']) !!}	
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
			<div class="col-md-3">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="far fa-images"></i> Imagen Principal</h2>
					</div>
					<div class="inside">
						<a href="{{ url('web/'.$sed->img_princ) }}" data-fancybox="gallery">
							<img src="{{ url('web/'.$sed->img_princ) }}" class = "img-fluid" alt="">
						</a>
					</div>
				</div>
				<div class="panel shadow mtop16">
					<div class="headercontent">
						<h2 class="title"><i class="far fa-images"></i> Galería</h2>
					</div>
					<div class="inside sed_galeria">
						{!! Form::open(['url'=>'/admin/web/sede/'.$sed->id.'/galeria/add', 'files' => true, 'id' => 'form_galeria']) !!}
						{!! Form::file('imagen', ['id' => 'img_galeria', 'accept'=>'image/*', 'style'=>'display:none;', 'required']) !!}
						{!! Form::close() !!}
						<div class="btn-submit">
							<a href="#" id="btn_galeria"><i class="fas fa-plus"></i></a>
						</div>
						<div class="tumbs">
							@foreach($sed->getGaleria as $img)
								<div class="tumb">
									<a href="{{ url('/admin/sedes/'.$sed->id.'/galeria/'.$img->id.'/del') }}" datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar la imagen?')"><i class="fas fa-trash-alt"></i></a>
									<img src="{{ url('web/'.$img->imagen) }}" alt="">
								</div>
							@endforeach
						</div>
					</div>
				</div>				
			</div>
		</div>		
	</div>
@endsection
@section('script')
<script>
document.addEventListener('DOMContentLoaded',function(){
	var btn_galeria = document.getElementById('btn_galeria');
	var img_galeria = document.getElementById('img_galeria');
	btn_galeria.addEventListener('click', function(){
		img_galeria.click();
	}, false);

	img_galeria.addEventListener('change', function(){
		document.getElementById('form_galeria').submit();

	});
});
</script>
@endsection