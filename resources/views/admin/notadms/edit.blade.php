@extends('admin.master')
@section('title','Notas de Débito/Crédito')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/notadms/'.session('padmision')) }}"><i class="fas fa-window-restore"></i> Notas de Débito/Crédito</a>
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
                        {!! Form::open(['url'=>'/admin/notadm/'.$nota->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="periodo">Periodo:</label>
                                        {!! Form::text('periodo', $nota->periodo, ['class'=>'form-control','id'=>'periodo','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-8">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::date('fecha', $nota->fecha, ['class'=>'form-control','id'=>'fecha','autocomplete'=>'off']) !!}
                                        {!! Form::time('hora', $nota->hora, ['class'=>'form-control','autocomplete'=>'off','hidden']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="moneda">Moneda:</label>
                                        {!! Form::select('moneda',$moneda,$nota->moneda,['class'=>'custom-select','id'=>'moneda']) !!}
                                    </div>
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="tc">TC:</label>
                                        {!! Form::text('tc', $nota->tc, ['class'=>'form-control','autocomplete'=>'off','disabled','id'=>'tc']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,$nota->comprobante_id,['class'=>'custom-select', 'id'=>'comprobante_id','disabled']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="num_doc">Número:</label>
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                {!! Form::text('serie', $nota->serie, ['class'=>'form-control','autocomplete'=>'off','id'=>'serie','disabled']) !!}
                                            </div>
                                            <div class="col-md-8">								
                                                {!! Form::text('numero', $nota->numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero','disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="dmcomprobante_id">Comprobante a modificar:</label>
                                        {!! Form::select('dmcomprobante_id',$dmcomprobante,$nota->dmcomprobante_id,['class'=>'custom-select', 'id'=>'dmcomprobante_id','disabled']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="dmnum_doc">Número que modifica:</label>
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                {!! Form::text('dmserie', $nota->dmserie, ['class'=>'form-control','autocomplete'=>'off','id'=>'dmserie']) !!}
                                            </div>
                                            <div class="col-md-8">								
                                                {!! Form::text('dmnumero', $nota->dmnumero, ['class'=>'form-control','autocomplete'=>'off','id'=>'dmnumero']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="dmtipo_id">Tipo:</label>
                                {!! Form::select('dmtipo_id',$tiponota,$nota->dmtipo_id,['class'=>'custom-select', 'id'=>'dmtipo_id']) !!}                                
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="dmdescripcion">Descripción:</label>
                                {!! Form::text('dmdescripcion', $nota->dmdescripcion, ['class'=>'form-control','autocomplete'=>'off','id'=>'dmdescripcion']) !!}                                
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ruc">Cliente:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        {!! Form::text('ruc', $nota->ruc, ['class'=>'form-control', 'id'=>'ruc','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::select('razsoc',$clientes,$nota->ruc,['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija Cliente']) !!}
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
                                {!! Form::text('direccion', $nota->direccion, ['class'=>'form-control','autocomplete'=>'off','id'=>'direccion']) !!}
                            </div>                            
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="observaciones">Observaciones:</label>
                                {!! Form::textarea('observaciones',$nota->observaciones,['class'=>'form-control', 'rows'=>'2']) !!}			
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">                                
                                <div @if($nota->status<>1)style="display:none"@endif>
                                    {!! Form::submit('Guardar', ['class'=>'btn btn-success', 'id'=>'guardar']) !!}
                                    <a class="btn thead-blue" href="{{ url('/admin/notadm/'.$nota->id.'/deta') }}"
                                        datatoggle="tooltip" data-placement="top" title="Agregar">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    {{-- <a class="btn thead-blue" href="{{ url('/admin/notadm/'.$nota->id.'/end') }}"
                                        datatoggle="tooltip" data-placement="top" title="Finalizar">
                                        <i class="fas fa-check-circle"></i>
                                    </a> --}}
                                    @if($nota->comprobante_id<>'01' || $nota->comprobante_id<>'03')
                                    <a class="btn thead-blue" href="{{ url('/admin/sunat/'.$nota->id.'/notaxmla') }}"
                                        datatoggle="tooltip" data-placement="top" title="Enviar comprobante">
                                        <i class="fas fa-globe-americas"></i> 
                                    </a>
                                    @endif
                                </div>
                                
                                @if($nota->status<>1)
                                <a class="btn thead-blue" href="{{ url('/admin/pdf/'.$nota->id.'/admnota') }}"
                                    target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir comprobante">
									<i class="fas fa-print"></i> 
                                </a>
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
                                    <th width="60%">Servicio</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="10%">Precio</th>
                                    <th width="10%">SubTotal</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detnotas as $detnota)
                                <tr>
                                    <td>
                                        {!! htmlspecialchars_decode(nl2br($detnota->servicio)) !!}

                                    </td>
                                    <td class="text-center">{{ round($detnota->cantidad,2) }}</td>
                                    <td>{{ $detnota->precio}}</td>
                                    <td>{{ $detnota->subtotal }}</td>
                                    <td>
                                        <div class="opts">
                                            @if(kvfj(Auth::user()->permissions,'notadm_edit')&&($nota->status==1))
                                            {{-- <a href="{{ url('/admin/notadm/'.$detnota->id.'/dete') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a> --}}
                                            <a href="{{ url('/admin/notadm/'.$detnota->id.'/detd') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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
                        {!! Form::open(['url'=>'/admin/factura/'.$nota->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_gravadas">Gravado:</label>
                                {!! Form::text('tot_gravadas', $nota->tot_gravadas, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_inafectas">Inafecto:</label>
                                {!! Form::text('tot_inafectas', $nota->tot_inafectas, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="tot_igv">IGV:</label>
                                {!! Form::text('tot_igv', $nota->tot_igv, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="total">Total:</label>
                                {!! Form::text('total', $nota->total, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
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
                                {!! Form::select('status',$status,$nota->status,['class'=>'custom-select','disabled']) !!}
                            </div>
                            <div class="col-md-9">
                                <label class="lsinmargen" for="cdr">CDR:</label>
                                {!! Form::text('cdr', $nota->cdr, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
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
            document.getElementById("tc").disabled = false;
            document.getElementById("comprobante_id").disabled = false;
            document.getElementById("serie").disabled = false;
            document.getElementById("numero").disabled = false;
            document.getElementById("dmcomprobante_id").disabled = false;
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
            document.getElementById('razsoc').value = this.value;
            $.get(url_global+"/admin/proveedor/"+this.value+"/busnumdoc/",function(response){
                if (response!=""){
                    document.getElementById("direccion").value = response[0].direccion;
                    document.getElementById("doctor_id").value = response[0].doctor_id;
                }
            });
        });

        document.getElementById('dmserie').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
        });

        document.getElementById('dmnumero').addEventListener("blur",function(){
            this.value = this.value.padStart(8,0);
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

    function devIdS(codigo){
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