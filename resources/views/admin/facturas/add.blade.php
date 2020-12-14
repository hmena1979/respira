@extends('admin.master')
@section('title','Facturación - Admisión')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/facturas/'.session('padmision')) }}"><i class="fas fa-money-check-alt"></i> Facturación - Admisión</a>
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
                        {!! Form::open(['url'=>'/admin/factura/add']) !!}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="periodo">Periodo:</label>
                                        {!! Form::text('periodo', session('padmision'), ['class'=>'form-control','id'=>'periodo','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="tipo">Tipo:</label>
                                        {!! Form::select('tipo',[1=>'Contado',2=>'Crédito'],1,['class'=>'custom-select','id'=>'tipo']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="lsinmargen" for="dias">Días:</label>
                                        {!! Form::text('dias', '', ['class'=>'form-control','id'=>'dias','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::date('fecha', \Carbon\Carbon::now(), ['class'=>'form-control','id'=>'fecha','autocomplete'=>'off']) !!}
                                        {!! Form::time('hora', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off','hidden']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="vencimiento">Vencimiento:</label>
                                        {!! Form::date('vencimiento', \Carbon\Carbon::now(), ['class'=>'form-control','id'=>'vencimiento','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="cancelacion">Cancelación:</label>
                                        {!! Form::date('cancelacion', \Carbon\Carbon::now(), ['class'=>'form-control','id'=>'cancelacion','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="moneda">Moneda:</label>
                                        {!! Form::select('moneda',$moneda,'PEN',['class'=>'custom-select','id'=>'moneda']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="tc">TC:</label>
                                        {!! Form::text('tc', '', ['class'=>'form-control','autocomplete'=>'off','disabled','id'=>'tc']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,'03',['class'=>'custom-select', 'id'=>'comprobante_id']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="num_doc">Número:</label>
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                {!! Form::text('serie', $serie, ['class'=>'form-control','autocomplete'=>'off','id'=>'serie','disabled']) !!}
                                            </div>
                                            <div class="col-md-8">								
                                                {!! Form::text('numero', $numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero','disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="fpago_id">F.Pago:</label>
                                        {!! Form::select('fpago_id',$fpago,'1',['class'=>'custom-select', 'id'=>'fpago_id']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="noperacion">N° Operación:</label>
                                        {!! Form::text('noperacion', '', ['class'=>'form-control','id'=>'noperacion','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ruc">Cliente:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        {!! Form::text('ruc', null, ['class'=>'form-control', 'id'=>'ruc','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::select('razsoc',$clientes,'',['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija Cliente']) !!}
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarModal" onclick="limpia()"><i class="fas fa-search"></i></button>
                                                <a class="btn btn-outline-info" href="{{ url('/admin/proveedor/add') }}" target="_blank">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="buscarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <input type="text" class='form-control' id= 'buscarm' placeholder = 'Buscar cliente' autocomplete='off' autofocus>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="cuerpom">
                                                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss='modal'>Salir</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Modal -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="lsinmargen" for="direccion">Dirección:</label>
                                {!! Form::text('direccion', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'direccion']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="observaciones">Observaciones:</label>
                                {!! Form::textarea('observaciones',null,['class'=>'form-control', 'rows'=>'2']) !!}			
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="doctor_id">Doctor:</label>
                                {!! Form::select('doctor_id',$doctor,1,['class'=>'custom-select','id'=>'doctor_id']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop20', 'id'=>'guardar']) !!}
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
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        document.getElementById('guardar').addEventListener("click",function(){
            document.getElementById("periodo").disabled = false;
            document.getElementById("dias").disabled = false;
            document.getElementById("vencimiento").disabled = false;
            document.getElementById("cancelacion").disabled = false;
            document.getElementById("tc").disabled = false;
            document.getElementById("serie").disabled = false;
            document.getElementById("numero").disabled = false;
            document.getElementById("noperacion").disabled = false;
        });

        document.getElementById('tipo').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("dias").disabled = true;
                document.getElementById("cancelacion").disabled = true;
                
                document.getElementById("dias").value = null;
                document.getElementById("vencimiento").value = hoy();
                document.getElementById("cancelacion").value = hoy();
            }else{
                document.getElementById("dias").disabled = false;
                document.getElementById("cancelacion").disabled = false;
                document.getElementById("cancelacion").value = null;
            }
        });

        document.getElementById('fpago_id').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("noperacion").disabled = true;
                document.getElementById("noperacion").value = '';
            }else{
                document.getElementById("noperacion").disabled = false;
            }
        });

        document.getElementById('dias').addEventListener("blur",function(){
            var fecha = document.getElementById("fecha").value
            document.getElementById("vencimiento").value = sumarDias(fecha,this.value);
        });

        document.getElementById('fecha').addEventListener("blur",function(){
            if(document.getElementById("tipo").value == 1){
                document.getElementById("vencimiento").value = this.value;
                document.getElementById("cancelacion").value = this.value;
            }else{
                var dias = document.getElementById("dias").value
                document.getElementById("vencimiento").value = sumarDias(this.value,dias);
            }
        });

        document.getElementById('comprobante_id').addEventListener("change",function(){
            var td = this.value;
            $.get(url_global+"/admin/factura/"+td+"/numero/",function(valor){
                document.getElementById('serie').value = valor[0];
                document.getElementById('numero').value = valor[1];
            });
        });

        document.getElementById('razsoc').addEventListener("change",function(){
            document.getElementById('ruc').value = this.value;
            $.get(url_global+"/admin/proveedor/"+this.value+"/busnumdoc/",function(response){
                if (response!=""){
                    document.getElementById("direccion").value = response[0].direccion;
                    document.getElementById("doctor_id").value = response[0].doctor_id;
                }else{
                    alert('Errpr');
                }
            });
        });

        document.getElementById('ruc').addEventListener("blur",function(){
            //var url_global='{{url("/")}}';
            document.getElementById('razsoc').value = this.value;
            $.get(url_global+"/admin/proveedor/"+this.value+"/busnumdoc/",function(response){
                if (response!=""){
                    document.getElementById("direccion").value = response[0].direccion;
                    document.getElementById("doctor_id").value = response[0].doctor_id;
                }
            });
        });

        document.getElementById('moneda').addEventListener("change",function(){
            if(this.value=='PEN'){
                document.getElementById("tc").value = null;
                document.getElementById("tc").disabled = true;
            }else{
                document.getElementById("tc").disabled = false;
            }
        });

        document.getElementById('buscarm').addEventListener("keyup",function(){				
            tabresult(this.value);
            
        });
    
        function tabresult(parbus){
            var html = '';
            //var url_global='{{url("/")}}';
            if(parbus.length >= 1){					
                $.get(url_global+"/admin/proveedor/"+parbus+"/busrazsoc/",function(response){
                    if (response==""){
                        html = 'No se encontraton datos';
                    }else{
                        html += "<table class='table table-resposive table-hover table-sm'>";
                        html += "<thead><tr><th>RUC</th><th>Razón social</th><th></th></tr></thead>";
                        html += "<tbody>";
                        var regMostrar = 0;
                        if(response.length <= 10){
                            regMostrar = response.length;
                        }else{
                            regMostrar = 10;
                        }
                        for (var i = 0; i < regMostrar; i++) {
                            var valor = response[i].numdoc;
                            html += "<tr><td>"+response[i].numdoc + "</td><td>" + response[i].razsoc+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devId('"+valor+"');><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpom')[0].innerHTML = html;
                });								
            }
        }

        document.getElementById('buscars').addEventListener("keyup",function(){
            tabresults(this.value);
            
        });

        function tabresults(parbus){
            var html = '';
            if(parbus.length >= 1){
                $.get(url_global+"/admin/servicio/"+parbus+"/find/",function(response){
                    if (response==""){
                        html = 'No se encontraton datos';
                    }else{
                        html += "<table class='table table-resposive table-hover table-sm'>";
                        html += "<thead><tr><th>Nombre</th><th></th></tr></thead>";
                        html += "<tbody>";
                        var regMostrar = 0;
                        if(response.length <= 10){
                            regMostrar = response.length;
                        }else{
                            regMostrar = 10;
                        }
                        for (var i = 0; i < regMostrar; i++) {
                            var valor = response[i].id;
                            html += "<tr><td>" + response[i].nombre+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devIdS('"+valor+"');><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpos')[0].innerHTML = html;
                });								
            }
        }

        
    });
    function devId(codigo){
        document.getElementById('buscando').style.display = 'block';
        $.get(url_global+"/admin/proveedor/"+codigo+"/busnumdoc/",function(response){
            document.getElementById('buscando').style.display = 'none';
            if (response['estado'] == "0"){
                if(confirm('Número de documento incorrecto, desea actualizar datos del cliente')){
                    window.open(url_global+"/admin/proveedor/"+response['id']+"/edit");
                }else{
                    document.getElementById("ruc").value = codigo;
                    document.getElementById('razsoc').value = codigo;
                    //document.getElementById("direccion").value = response['direccion'];
                    document.getElementById("doctor_id").value = response['doctor_id'];
                }
                
            }else{
                if(confirm('El documento ingresado pertenece a:\n'+response['razsoc']+'\nPresione aceptar si desea modificar el cliente')){
                    window.open(url_global+"/admin/proveedor/"+response['id']+"/edit");
                }else{
                    document.getElementById("ruc").value = codigo;
                    document.getElementById('razsoc').value = codigo;
                    document.getElementById("direccion").value = response['direccion'];
                    document.getElementById("doctor_id").value = response['doctor_id'];
                }
            }
        });
    }

    function devIdS(codigo){
        //var url_global='{{url("/")}}';
        $.get(url_global+"/admin/servicio/"+codigo+"/findid/",function(response){
            if (response!=""){
                document.getElementById("servicio").value = response[0].nombre;
                document.getElementById("precio").value = response[0].precio;
            }else{
                alert('Errpr');
            }
        });
    }

    function limpia(){
        document.getElementsByClassName('cuerpom')[0].innerHTML = '';
        document.getElementById('buscarm').value = '';
    }

</script>
@endsection