@extends('admin.master')
@section('title','Parametros')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/parametros') }}"><i class="fas fa-user-md"></i> Parámetros</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/parametros']) !!}
						<div class="row">					
							<div class="col-md-3">
								<label for="ruc">RUC:</label>
                                {!! Form::text('ruc', $param->ruc, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-9">
								<label for="razsoc">Razón social:</label>
                                {!! Form::text('razsoc', $param->razsoc, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
                        </div>
						<div class="row mtop16">					
							<div class="col-md-2">
								<label for="ubigeo">Ubigeo(Código):</label>
                                {!! Form::text('ubigeo', $param->ubigeo, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<label for="direccion">Dirección:</label>
                                {!! Form::text('direccion', $param->direccion, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<label for="urbanizacion">Urbanización:</label>
                                {!! Form::text('urbanizacion', $param->urbanizacion, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
                        </div>
						<div class="row mtop16">					
							<div class="col-md-3">
								<label for="provincia">Provincia:</label>
                                {!! Form::text('provincia', $param->provincia, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="departamento">Departamento:</label>
                                {!! Form::text('departamento', $param->departamento, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="distrito">Distrito:</label>
                                {!! Form::text('distrito', $param->distrito, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="pais">País(Código):</label>
                                {!! Form::text('pais', $param->pais, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
                        </div>
						<div class="row mtop16">					
							<div class="col-md-3">
								<label for="padmision">Periodo admisión:</label>
                                {!! Form::text('padmision', $param->padmision, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="sadmision">Serie admisión:</label>
                                {!! Form::text('sadmision', $param->sadmision, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="pfarmacia">Periodo farmacia:</label>
                                {!! Form::text('pfarmacia', $param->pfarmacia, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="sfarmacia">Serie farmacia:</label>
                                {!! Form::text('sfarmacia', $param->sfarmacia, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
                        </div>
                        <div class="row mtop16">					
							<div class="col-md-3">
								<label for="por_igv">Porcentaje IGV:</label>
                                {!! Form::text('por_igv', $param->por_igv, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="por_renta">Porcentaje renta:</label>
                                {!! Form::text('por_renta', $param->por_renta, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="monto_renta">Monto Renta:</label>
                                {!! Form::text('monto_renta', $param->monto_renta, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-3">
								<label for="usuario">Usuario(SUNAT - SOL):</label>
                                {!! Form::text('usuario', $param->usuario, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="clave">Clave(SUNAT - SOL):</label>
                                {!! Form::text('clave', $param->clave, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<label for="apitoken">Token API(RENIEC/SUNAT):</label>
                                {!! Form::text('apitoken', $param->apitoken, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-4">
								<label for="servidor">Servidor(SUNAT - Envío comprobantes):</label>
                                {!! Form::text('servidor', $param->servidor, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="dominio">Dominio(www):</label>
                                {!! Form::text('dominio', $param->dominio, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4">
								<label for="cuenta">Cuenta(Detraccíon):</label>
                                {!! Form::text('cuenta', $param->cuenta, ['class'=>'form-control','autocomplete'=>'off']) !!}
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