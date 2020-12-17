@extends('admin.master')
@section('title','Proveedores')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/proveedores') }}"><i class="fas fa-address-card"></i> Proveedores</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
        <div class="alert alert-warning" role="alert" style="display:none" id = 'buscando'>
			Buscando número de documento
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/proveedor/'.$proveedor->id.'/edit']) !!}
						<div class="row">
							<div class="col-md-4">
								<label for="tipdoc_id">Tipo documento:</label>
								{!! Form::select('tipdoc_id',$tipdoc,$proveedor->tipdoc_id,['class'=>'custom-select', 'id'=>'tipdoc_id']) !!}
							</div>
							<div class="col-md-2">
								<label for="numdoc">Número documento:</label>
								{!! Form::text('numdoc', $proveedor->numdoc, ['class'=>'form-control','id'=>'numdoc','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<label for="razsoc">Razón social:</label>
								{!! Form::text('razsoc', $proveedor->razsoc, ['class'=>'form-control','id'=>'razsoc','autocomplete'=>'off','disabled']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-3">
								<label for="ape_pat">Ap Paterno:</label>
								{!! Form::text('ape_pat', $proveedor->ape_pat, ['class'=>'form-control','id'=>'ape_pat','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="ape_mat">Ap Materno:</label>
								{!! Form::text('ape_mat', $proveedor->ape_mat, ['class'=>'form-control','id'=>'ape_mat','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="nombre1">1er Nombre:</label>
								{!! Form::text('nombre1', $proveedor->nombre1, ['class'=>'form-control','id'=>'nombre1','autocomplete'=>'off','disabled']) !!}
							</div>
							<div class="col-md-3">
								<label for="nombre2">2do Nombre:</label>
								{!! Form::text('nombre2', $proveedor->nombre2, ['class'=>'form-control','id'=>'nombre2','autocomplete'=>'off','disabled']) !!}
							</div>
						</div>
						<div class="row mtop16">							
							<div class="col-md-5">
								<label for="direccion">Dirección:</label>
								{!! Form::text('direccion', $proveedor->direccion, ['class'=>'form-control','id'=>'direccion','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<label for="email">e-mail:</label>
								{!! Form::text('email', $proveedor->email, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2">
								<label for="telefono">Celular / Teléfono:</label>
								{!! Form::text('telefono', $proveedor->telefono, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16', 'id'=>'guardar']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
						
					</div>				
				</div>
			</div>

        </div>
        <div class="row mtop16">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
                        <a href="{{ url('admin/paciente/'.$proveedor->id.'/convert') }}" class="btn btn-convertir" datatoggle="tooltip" data-placement="top" title="Convertir en paciente">
                            Convertir en paciente
                        </a> 

                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        desactivaText();
        document.getElementById('guardar').addEventListener("click",function(){
            document.getElementById("razsoc").disabled = false;
            document.getElementById("ape_pat").disabled = false;
            document.getElementById("ape_mat").disabled = false;
            document.getElementById("nombre1").disabled = false;
            document.getElementById("nombre2").disabled = false;

        });
        //============================================================================================================
        document.getElementById('numdoc').addEventListener("blur",function(){
            var url_global='{{url("/")}}';
            var td = document.getElementById("tipdoc_id").value
            var numdoc = document.getElementById("numdoc").value
            var entidad = '';

            if(td == '1'){
                entidad = 'RENIEC';
            }
            if(td == '6'){
                entidad = 'SUNAT';
            }
            
            if(numdoc.length != 0){
                if(td == '1' && numdoc.length != 8){
                    alert('DNI debe contener 8 caracteres');
                    document.getElementById('numdoc').focus();
                    return false;
                }

                if(td == '6' && numdoc.length != 11){
                    alert('RUC debe contener 11 caracteres');
                    document.getElementById('numdoc').focus();
                    return false;
                }
            }
            if((td == '1') || (td == '6')){
                document.getElementById('buscando').style.display = 'block';
                $.get(url_global+"/admin/paciente/"+td+"/"+numdoc+"/busapi/",function(response){
                    document.getElementById('buscando').style.display = 'none';
                    if(response == 0){
                        alert('Documento no existe en la Base de datos de ' + entidad);
                        document.getElementById('numdoc').select();
                        document.getElementById('numdoc').focus();
                        document.getElementById('guardar').style.display = 'none';
                        return false;
                    }else{
                        if(td == '1'){
                            document.getElementById('guardar').style.display = 'block';
                            var nombres = response['nombres'];
                            var espacio = nombres.indexOf(" ");
                            var nombre1 = espacio!=-1?nombres.substr(0,espacio):nombres;
                            var nombre2 = espacio!=-1?nombres.substr(espacio+1):'';
                            
                            document.getElementById("ape_pat").value = response['apellidoPaterno'];
                            document.getElementById("ape_mat").value = response['apellidoMaterno'];
                            document.getElementById("nombre1").value = nombre1;
                            document.getElementById("nombre2").value = nombre2;

                            document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                                + document.getElementById("ape_mat").value + ' '
                                + document.getElementById("nombre1").value + ' '
                                + document.getElementById("nombre2").value;
                        }
                        if(td == '6'){
                            document.getElementById('guardar').style.display = 'block';
                            document.getElementById("razsoc").value = response['razonSocial'];
                            if(numdoc.substr(0,2) == '20'){
                                document.getElementById("direccion").value = response['direccion']+' '+response['distrito']+' '+
                                response['provincia']+' '+response['departamento'];
                            }else{
                                document.getElementById("direccion").value = '';
                                var razsoc = response['razonSocial'];
                                var espacio1 = razsoc.indexOf(" ");
                                var espacio2 = razsoc.indexOf(" ",espacio1+1);
                                document.getElementById("ape_pat").value = razsoc.substr(0,espacio1);
                                document.getElementById("ape_mat").value = razsoc.substr(espacio1+1,espacio2-espacio1);
                                document.getElementById("nombre1").value = razsoc.substr(espacio2+1);
                            }                            
                        }
                    }
                });
            }
        });
        //============================================================================================================

        document.getElementById('ape_pat').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
            document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                + document.getElementById("ape_mat").value + ' '
                + document.getElementById("nombre1").value + ' '
                + document.getElementById("nombre2").value;
            
        });

        document.getElementById('ape_mat').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
            document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                + document.getElementById("ape_mat").value + ' '
                + document.getElementById("nombre1").value + ' '
                + document.getElementById("nombre2").value;
        });

        document.getElementById('nombre1').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
            document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                + document.getElementById("ape_mat").value + ' '
                + document.getElementById("nombre1").value + ' '
                + document.getElementById("nombre2").value;
        });
        
        document.getElementById('nombre2').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
            document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                + document.getElementById("ape_mat").value + ' '
                + document.getElementById("nombre1").value + ' '
                + document.getElementById("nombre2").value;
        });

        function desactivaText(){
            var td = document.getElementById("tipdoc_id").value
            var numdoc = document.getElementById("numdoc").value
            if(td == '6' && numdoc.substr(0,2)=='20'){
                document.getElementById("razsoc").disabled = false;
                document.getElementById("ape_pat").disabled = true;
                document.getElementById("ape_mat").disabled = true;
                document.getElementById("nombre1").disabled = true;
                document.getElementById("nombre2").disabled = true;
                document.getElementById("razsoc").focus();
            }else{
                document.getElementById("razsoc").disabled = true;
                document.getElementById("ape_pat").disabled = false;
                document.getElementById("ape_mat").disabled = false;
                document.getElementById("nombre1").disabled = false;
                document.getElementById("nombre2").disabled = false;
                document.getElementById("ape_pat").focus();
            }
        }
    });
</script>
@endsection