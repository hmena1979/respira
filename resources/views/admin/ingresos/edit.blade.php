@extends('admin.master')
@section('title','Compras')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/ingresos/'.session('pfarmacia')) }}"><i class="fas fa-cart-plus"></i> Compras</a>
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
                        {!! Form::open(['url'=>'/admin/ingreso/'.$ingreso->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="periodo">Periodo:</label>
                                        {!! Form::text('periodo', $ingreso->periodo, ['class'=>'form-control','id'=>'periodo','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="tipo">Tipo:</label>
                                        {!! Form::select('tipo',[1=>'Contado',2=>'Crédito'],$ingreso->tipo,['class'=>'custom-select', 'id' => 'tipo']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="lsinmargen" for="dias">Días:</label>
                                        {!! Form::text('dias', $ingreso->dias, ['class'=>'form-control','id'=>'dias','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::date('fecha', $ingreso->fecha, ['class'=>'form-control','id'=>'fecha','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="vencimiento">Vencimiento:</label>
                                        {!! Form::date('vencimiento', $ingreso->vencimiento, ['class'=>'form-control','id'=>'vencimiento','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="lsinmargen" for="cancelacion">Cancelación:</label>
                                        {!! Form::date('cancelacion', $ingreso->cancelacion, ['class'=>'form-control','id'=>'cancelacion','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="moneda">Moneda:</label>
                                        {!! Form::select('moneda',$moneda,$ingreso->moneda,['class'=>'custom-select','id'=>'moneda']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="tc">TC:</label>
                                        {!! Form::text('tc', $ingreso->tc, ['class'=>'form-control','autocomplete'=>'off','disabled','id'=>'tc']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,$ingreso->comprobante_id,['class'=>'custom-select', 'id'=>'comprobante_id']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="num_doc">Número:</label>
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                {!! Form::text('serie', $ingreso->serie, ['class'=>'form-control','autocomplete'=>'off','id'=>'serie']) !!}
                                            </div>
                                            <div class="col-md-8">								
                                                {!! Form::text('numero', $ingreso->numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="ruc">Proveedor:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            {!! Form::select('proveedor_id',$proveedores,$ingreso->proveedor_id,['class'=>'custom-select', 'id'=>'proveedor_id', 'placeholder'=>'Elija Proveedor']) !!}
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarModal" onclick="limpia()"><i class="fas fa-search"></i></button>
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
                        </div>
                        <div class="row mtop8">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4 text-right">
                                @if($detingresos->count()==0)
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success', 'id'=>'guardar']) !!}
                                @else
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success', 'id'=>'guardar','hidden']) !!}
                                @endif

                                <a class="btn thead-blue" href="{{ url('/admin/ingreso/'.$ingreso->id.'/deta') }}"
                                    datatoggle="tooltip" data-placement="top" title="Agregar detalles">
									<i class="fas fa-plus"></i>
                                </a>
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
                                @foreach($detingresos as $detingreso)
                                <tr>
                                    <td>{{ $detingreso->prod->nombre}}</td>
                                    <td>{{ $detingreso->prod->umedida->nombre}}</td>
                                    <td class="text-center">{{ round($detingreso->cantidad,2) }}</td>
                                    <td>{{ $detingreso->precio}}</td>
                                    <td>{{ $detingreso->subtotal }}</td>
                                    <td>
                                        <div class="opts">
                                            @if(kvfj(Auth::user()->permissions,'ingreso_edit'))
                                            {{-- <a href="{{ url('/admin/ingreso/'.$detingreso->id.'/dete') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a> --}}
                                            <a href="{{ url('/admin/ingreso/'.$detingreso->id.'/detd') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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
                        {!! Form::open(['url'=>'/admin/ingreso/'.$ingreso->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="subtotal">SubTotal:</label>
                                {!! Form::text('subtotal', $ingreso->subtotal, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="igv">IGV:</label>
                                {!! Form::text('igv', $ingreso->igv, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="total">Total:</label>
                                {!! Form::text('total', $ingreso->total, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
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
        });

        document.getElementById('moneda').addEventListener("change",function(){
            if(this.value=='PEN'){
                document.getElementById("tc").value = null;
                document.getElementById("tc").disabled = true;
            }else{
                document.getElementById("tc").disabled = false;
            }
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
                            var valor = response[i].id;
                            html += "<tr><td>"+response[i].numdoc + "</td><td>" + response[i].razsoc+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devId('"+valor+"');><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpom')[0].innerHTML = html;
                });								
            }
        }
    });
    function devId(codigo){
        document.getElementById('proveedor_id').value = codigo;
    }

    function limpia(){
        document.getElementsByClassName('cuerpom')[0].innerHTML = '';
        document.getElementById('buscarm').value = '';
    }

    
</script>
@endsection