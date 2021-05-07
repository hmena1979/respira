@extends('admin.master')
@section('title','Venta / Consumo')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/salidas/'.session('pfarmacia')) }}"><i class="fas fa-cart-arrow-down"></i> Venta / Consumo</a>
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
                        {!! Form::open(['url'=>'/admin/salida/'.$salida->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="periodo">Periodo:</label>
                                        {!! Form::text('periodo', $salida->periodo, ['class'=>'form-control','id'=>'periodo','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="tipo">Pago:</label>
                                        {!! Form::select('tipo',[1=>'Contado',2=>'Crédito'],$salida->tipo,['class'=>'custom-select','id'=>'tipo']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="lsinmargen" for="dias">Días:</label>
                                        {!! Form::text('dias', $salida->dias, ['class'=>'form-control','id'=>'dias','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::date('fecha', $salida->fecha, ['class'=>'form-control','id'=>'fecha','autocomplete'=>'off']) !!}
                                        {!! Form::time('hora', $salida->hora, ['class'=>'form-control','autocomplete'=>'off','hidden']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="vencimiento">Vencimiento:</label>
                                        {!! Form::date('vencimiento', $salida->vencimiento, ['class'=>'form-control','id'=>'vencimiento','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="cancelacion">Cancelación:</label>
                                        {!! Form::date('cancelacion', $salida->cancelacion, ['class'=>'form-control','id'=>'cancelacion','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="moneda">Moneda:</label>
                                        {!! Form::select('moneda',$moneda,$salida->moneda,['class'=>'custom-select','id'=>'moneda']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="tc">TC:</label>
                                        {!! Form::text('tc', $salida->tc, ['class'=>'form-control','autocomplete'=>'off','disabled','id'=>'tc']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="tipsal">Tipo:</label>
                                        {!! Form::select('tipsal',[1=>'VENTA',2=>'CONSUMO'],$salida->tipsal,['class'=>'custom-select','id'=>'tipsal','disabled']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,$salida->comprobante_id,['class'=>'custom-select', 'id'=>'comprobante_id','disabled']) !!}
                                    </div>
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="num_doc">Número:</label>
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                {!! Form::text('serie', $salida->serie, ['class'=>'form-control','autocomplete'=>'off','id'=>'serie','disabled']) !!}
                                            </div>
                                            <div class="col-md-8">								
                                                {!! Form::text('numero', $salida->numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero','disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ruc">Cliente:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        {!! Form::text('ruc', $salida->ruc, ['class'=>'form-control', 'id'=>'ruc','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::select('razsoc',$clientes,$salida->ruc,['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija Cliente']) !!}
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
                                {!! Form::text('direccion', $salida->direccion, ['class'=>'form-control','autocomplete'=>'off','id'=>'direccion']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="observaciones">Observaciones:</label>
                                {!! Form::textarea('observaciones',$salida->observaciones,['class'=>'form-control', 'rows'=>'2']) !!}			
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fpago_id">F.Pago:</label>
                                {!! Form::select('fpago_id',$fpago,$salida->fpago_id,['class'=>'custom-select','id'=>'fpago_id']) !!}
                            </div>
                            <div class="col-md-3">
                                <div class="row no-gutters">
                                    <div class="col-md-10">
                                        <label class="lsinmargen" for="noperacion">N° Operación:</label>
                                        {!! Form::text('noperacion', $salida->noperacion, ['class'=>'form-control','id'=>'noperacion','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-2 @if($salida->status==1) oculto @endif">
                                        <button type="button" class="btn btn-convertir mtop25" onclick="editFPago('{{ $salida->id }}')" datatoggle="tooltip" data-placement="top" title="Actualizar forma de pago">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 text-right">
                                @if($salida->status==1)
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop20', 'id'=>'guardar']) !!}
                                <a class="btn thead-blue mtop20 mr-3" href="{{ url('/admin/salida/'.$salida->id.'/deta') }}"
                                    datatoggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
                                </a>
                                @if($salida->comprobante_id=='01' || $salida->comprobante_id=='03')
                                <a class="btn thead-blue mtop20" href="{{ url('/admin/sunat/'.$salida->id.'/xmlf') }}"
                                    datatoggle="tooltip" data-placement="top" title="Enviar comprobante">
									<i class="fas fa-globe-americas"></i> 
                                </a>
                                @endif
                                {{-- <a class="btn thead-blue mtop20" href="{{ url('/admin/salida/'.$salida->id.'/end') }}"
                                    datatoggle="tooltip" data-placement="top" title="Finalizar">
                                    <i class="fas fa-check-circle"></i>
                                </a> --}}
                                @else
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop20 oculto', 'id'=>'guardar']) !!}
                                <a class="btn thead-blue mtop20" href="{{ url('/admin/pdf/'.$salida->id.'/farmfact') }}"
                                    target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir comprobante">
									<i class="fas fa-print"></i> 
                                </a>
                                @if($salida->comprobante_id=='01' || $salida->comprobante_id=='03')
                                <a class="btn thead-blue mtop20" href="{{ url('/admin/sunat/'.$salida->id.'/xmlf') }}"
                                    datatoggle="tooltip" data-placement="top" title="Enviar comprobante">
									<i class="fas fa-globe-americas"></i> 
                                </a>
                                @endif
                                @endif
                            </div>
                        </div>
						{!! Form::close() !!}
					</div>				
				</div>
			</div>
        </div>
        <div class="row mtop10">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        <table class="table table-sm table-bordered table-sb">
                            <thead class="thead-blue">
                                <tr>
                                    <th width="40%">Producto</th>
                                    <th width="20%">Presentacion</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="10%">Precio</th>
                                    <th width="10%">SubTotal</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detsalidas as $detsalida)
                                <tr>
                                    <td>{{ $detsalida->prod->nombre}}</td>
                                    <td>{{ $detsalida->prod->umedida->nombre}}</td>
                                    <td class="text-center">{{ round($detsalida->cantidad,2) }}</td>
                                    <td>{{ $detsalida->precio}}</td>
                                    <td>{{ $detsalida->subtotal }}</td>
                                    <td>
                                        <div class="opts">
                                            @if(kvfj(Auth::user()->permissions,'salida_edit') && $salida->status == 1)
                                            {{-- <a href="{{ url('/admin/ingreso/'.$detingreso->id.'/dete') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a> --}}
                                            <a href="{{ url('/admin/salida/'.$detsalida->id.'/detd') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop10">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        {!! Form::open(['url'=>'/admin/salida/'.$salida->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_gravadas">Afecto:</label>
                                {!! Form::text('tot_gravadas', $salida->tot_gravadas, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_inafectas">Inafecto:</label>
                                {!! Form::text('tot_inafectas', $salida->tot_inafectas, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_exoneradas">Exoneradas:</label>
                                {!! Form::text('tot_exoneradas', $salida->tot_exoneradas, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_igv">IGV:</label>
                                {!! Form::text('tot_igv', $salida->tot_igv, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="total">Total:</label>
                                {!! Form::text('total', $salida->total, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop10">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="status">Estado:</label>
                                {!! Form::select('status',$status,$salida->status,['class'=>'custom-select','disabled']) !!}
                            </div>
                            <div class="col-md-9">
                                <label class="lsinmargen" for="cdr">CDR:</label>
                                {!! Form::text('cdr', $salida->cdr, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                        </div>
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
            document.getElementById("tipsal").disabled = false;
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

        document.getElementById('tipsal').addEventListener("change",function(){
            if(this.value == 1){
                var td = '03';
                $.get(url_global+"/admin/salida/"+td+"/numero/",function(valor){
                    document.getElementById('comprobante_id').value = td;
                    document.getElementById('serie').value = valor[0];
                    document.getElementById('numero').value = valor[1];
                    document.getElementById('ruc').value = '';
                    document.getElementById('razsoc').value = '';
                });
            }else{
                var td = '00';
                $.get(url_global+"/admin/salida/"+td+"/numero/",function(valor){
                    document.getElementById('comprobante_id').value = td;
                    document.getElementById('serie').value = valor[0];
                    document.getElementById('numero').value = valor[1];
                    document.getElementById('ruc').value = '20530221548';
                    document.getElementById('razsoc').value = '20530221548';

                });
            }
            
        });

        document.getElementById('comprobante_id').addEventListener("change",function(){
            var td = this.value;
            $.get(url_global+"/admin/salida/"+td+"/numero/",function(valor){
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

        document.getElementById('fpago_id').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("noperacion").disabled = true;
                document.getElementById("noperacion").value = '';
            }else{
                document.getElementById("noperacion").disabled = false;
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
                alert('Número de documento incorrecto, actualice datos del cliente');
                window.open(url_global+"/admin/proveedor/"+response['id']+"/edit");
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

    function editFPago(id){
        var fp = document.getElementById("fpago_id").value
        var numop = document.getElementById("noperacion").value
        if(numop.length == 0){
            numop = '99999999';
        }
        $.get(url_global+"/admin/salida/"+id+"/"+fp+"/"+numop+"/cambiafp/",function(response){
            alert('Registro actualizado');
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