@extends('admin.master')
@section('title','Tipo medicamento')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/tipmeds/'.$tipmed->id) }}"><i class="fas fa-tablets"></i> Tipo medicamento: {{$tipmed->nombre}}</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/tipmed/'.$tipmed->id.'/addcomposicion']) !!}
						<div class="row">
                            <div class="col-md-6">
								<label for="nombre">Nombre composición:</label>
								{!! Form::text('nombre', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
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