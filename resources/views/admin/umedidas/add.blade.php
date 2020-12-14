@extends('admin.master')
@section('title','Unidad de medida')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/umedidas') }}"><i class="fas fa-ruler-combined"></i> Unidad de medida</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/umedida/add']) !!}
						<div class="row">
                            <div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
								<label for="codant">Código anterior:</label>
								{!! Form::text('codant', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
								<label for="sunat">Código Sunat:</label>
								{!! Form::text('sunat', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
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