@extends('admin.master')
@section('title','Pacientes')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/pacientes') }}"><i class="fas fa-user-circle"></i> Pacientes</a>
	</li>
@endsection

@section('content')

	<div class="container-fluid">
		<div class="alert alert-warning" role="alert" style="display:none" id = 'buscando'>
			Buscando en el portal de <strong>RENIEC</strong>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/paciente/'.$paciente->id.'/edit']) !!}
						<div class="row">
							<div class="col-md-4">
								<label for="tipdoc_id">Tipo documento:</label>
								{!! Form::select('tipdoc_id',$tipdoc,$paciente->tipdoc_id,['class'=>'custom-select','id'=>'tipdoc_id']) !!}
							</div>
							<div class="col-md-2">
								<label for="numdoc">Número documento:</label>
								{!! Form::text('numdoc', $paciente->numdoc, ['class'=>'form-control','id'=>'numdoc','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="fecnac">Fecha nacimiento:</label>
								{!! Form::date('fecnac', $paciente->fecnac, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="sexo_id">Sexo:</label>
								{!! Form::select('sexo_id',$sexo,$paciente->sexo_id,['class'=>'custom-select', 'placeholder'=> 'Seleccione sexo']) !!}	
							</div>
						</div>
						
						<div class="row mtop16">
							<div class="col-md-3">
								<label for="ape_pat">Ap Paterno:</label>
								{!! Form::text('ape_pat', $paciente->ape_pat, ['class'=>'form-control','id'=>'ape_pat','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="ape_mat">Ap Materno:</label>
								{!! Form::text('ape_mat', $paciente->ape_mat, ['class'=>'form-control','id'=>'ape_mat','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="nombre1">1er Nombre:</label>
								{!! Form::text('nombre1', $paciente->nombre1, ['class'=>'form-control','id'=>'nombre1','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="nombre2">2do Nombre:</label>
								{!! Form::text('nombre2', $paciente->nombre2, ['class'=>'form-control','id'=>'nombre2','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="estciv_id">Estado civil:</label>
								{!! Form::select('estciv_id',$estciv,$paciente->estciv_id,['class'=>'custom-select', 'placeholder'=> 'Sin asignar']) !!}	
							</div>
						</div>
						<div class="row mtop16">							
							<div class="col-md-5">
								<label for="direccion">Dirección:</label>
								{!! Form::text('direccion', $paciente->direccion, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<label for="email">e-mail:</label>
								{!! Form::text('email', $paciente->email, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="telefono">Celular / Teléfono:</label>
								{!! Form::text('telefono', $paciente->telefono, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						
						<div class="row mtop16">
							<div class="col-md-4">
								<label for="ocupacion">Ocupación:</label>
								{!! Form::text('ocupacion', $paciente->ocupacion, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="lorigen">Lugar origen:</label>
								{!! Form::text('lorigen', $paciente->lorigen, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="lresidencia">Lugar residencia:</label>
								{!! Form::text('lresidencia', $paciente->lresidencia, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="responsable">Responsable:</label>
								{!! Form::text('responsable', $paciente->responsable, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						@if($historia->count() <> 0)
							@php($fecha = $historia[0]->fecha)
							@php($hora = $historia[0]->hora)
						@else
							@php($fecha = \Carbon\Carbon::now())
							@php($hora = \Carbon\Carbon::now())
						@endif
						<div class="row mtop16">
							<div class="col-md-4">
								<label for="doctor_id">Dr asignado:</label>
								{!! Form::select('doctor_id',$doctor,$paciente->doctor_id,['class'=>'custom-select', 'placeholder'=>'Sin asignar']) !!}
							</div>
							<div class="col-md-3">
								<label for="fecha">Primera cita:</label>
								{!! Form::date('fecha', $fecha, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="hora">Hora cita:</label>
								{!! Form::time('hora', $hora, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="tippac_id">Tipo paciente:</label>
								{!! Form::select('tippac_id',$tippac,$paciente->tippac_id,['class'=>'custom-select', 'placeholder'=>'']) !!}
							</div>
						</div>
						{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16', 'id'=>'guardar']) !!}
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
        document.getElementById('numdoc').addEventListener("blur",function(){
			var url_global='{{url("/")}}';
			var tipo = document.getElementById('tipdoc_id').value;
			if(tipo=='1' && this.value.length != 8){
				alert('DNI debe tener 8 caracteres');
				// document.getElementById('numdoc').select();
				// document.getElementById('numdoc').focus();
				// document.getElementById('guardar').style.display = 'none';
				return false;
			}
			if(tipo=='1'){
				document.getElementById('buscando').style.display = 'block';
				$.get(url_global+"/admin/paciente/"+tipo+"/"+this.value+"/busapi/",function(response){
					document.getElementById('buscando').style.display = 'none';
					if(response == 0){
						alert('Documento no existe en la Base de datos de la RENIEC');
						// document.getElementById('numdoc').select();
						// document.getElementById('numdoc').focus();
						// document.getElementById('guardar').style.display = 'none';
						return false;
					}else{
						if(confirm('DNI ingresado pertecena a:\n'+response['apellidoPaterno']+' '+response['apellidoMaterno']+' '+response['nombres']+'\nEs correcto?')){
							// document.getElementById('guardar').style.display = 'block';
							var nombres = response['nombres'];
							var espacio = nombres.indexOf(" ");
							var nombre1 = espacio!=-1?nombres.substr(0,espacio):nombres;
							var nombre2 = espacio!=-1?nombres.substr(espacio+1):'';
							
							document.getElementById("ape_pat").value = response['apellidoPaterno'];
							document.getElementById("ape_mat").value = response['apellidoMaterno'];
							document.getElementById("nombre1").value = nombre1;
							document.getElementById("nombre2").value = nombre2;
						}
						
					}
				});
			}
		});
	});
</script>
@endsection