@extends('admin.master')
@section('title','Servicios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/servicios') }}"><i class="fas fa-hand-holding-medical"></i> Servicios</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/servicio/'.$servicio->id.'/edit']) !!}
						<div class="row">
                            <div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', $servicio->nombre, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
								<label for="precio">precio:</label>
								{!! Form::text('precio', $servicio->precio, ['class'=>'form-control','id'=>'precio','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
								<label for="clinica">Clínica:</label>
								{!! Form::text('clinica', $servicio->clinica, ['class'=>'form-control','id'=>'clinica','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
								<label for="especialista">Especialista:</label>
								{!! Form::text('especialista', $servicio->especialista, ['class'=>'form-control','id'=>'especialista','autocomplete'=>'off']) !!}
							</div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-3">
								<label for="codant">Código anterior:</label>
								{!! Form::text('codant', $servicio->codant, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
@section('script')
<script>
    $(document).ready(function(){
        document.getElementById('precio').addEventListener("blur",function(){
            document.getElementById("clinica").value = NaNToCero(this.value - document.getElementById("especialista").value);
            document.getElementById("especialista").value = NaNToCero(this.value - document.getElementById("clinica").value);
			});
        document.getElementById('clinica').addEventListener("blur",function(){
            document.getElementById("especialista").value = NaNToCero(document.getElementById("precio").value - this.value);
			});
        document.getElementById('especialista').addEventListener("blur",function(){
            document.getElementById("clinica").value = NaNToCero(document.getElementById("precio").value - this.value);
			});
    });
</script>
@endsection