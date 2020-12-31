@extends('admin.master')
@section('title','Notas de Débito/Crédito')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/notadms/'.session('pfarmacia')) }}"><i class="fas fa-window-restore"></i> Notas de Débito/Crédito</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
                        {!! Form::open(['url'=>'/admin/notfar/'.$nota->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::text('fecha', $nota->fecha, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,$nota->comprobante_id,['class'=>'custom-select', 'id'=>'comprobante_id','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="num_doc">Número:</label>							
                                        {!! Form::text('numero', $nota->serie.'-'.$nota->numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero','disabled']) !!}
                                    </div>
                                    <div class="col-md-8">
                                        <label class="lsinmargen" for="ruc">Cliente:</label>
                                        {!! Form::select('razsoc',$clientes,$nota->ruc,['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija Cliente','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
						{!! Form::close() !!}
					</div>				
				</div>
			</div>

        </div>
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        {!! Form::open(['url'=>'/admin/notfar/'.$nota->id.'/deta']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <label class="lsinmargen" for="producto">Producto:</label>
                                    <div class="input-group">
                                        {!! Form::select('producto_id',$productos,null,['class'=>'custom-select', 'id'=>'producto_id', 'placeholder'=>'Elija producto']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarProd" onclick="limpia()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                <!-- Modal -->
                                <div class="modal fade" id="buscarProd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <input type="text" class='form-control' id= 'buscarp' placeholder = 'Buscar producto' autocomplete='off' autofocus>
                                            </div>
                                            <div class="modal-body">
                                                <div class="cuerpop">
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
                            <div class="col-md-3">
                                <label class="lsinmargen" for="umedida_id">Presentación:</label>
                                {!! Form::select('umedida_id',$umedida,null,['class'=>'custom-select','id'=>'umedida_id','placeholder'=>'','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="stock">Stock:</label>
                                {!! Form::text('stock', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'stock','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="stockmin">Stock mínimo:</label>
                                {!! Form::text('stockmin', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'stockmin','disabled']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="afectacion_id">Afectacion:</label>
                                {!! Form::select('afectacion_id',$afectacion,'10',['class'=>'custom-select','id'=>'afectacion_id']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="lote">Lote:</label>
                                            <div class="input-group">
                                                {!! Form::text('lote', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'lote']) !!}
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarLote" onclick="limpia()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="buscarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <input type="text" class='form-control' id= 'buscarl' placeholder = 'Buscar lote' autocomplete='off' autofocus>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="cuerpol">
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
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="vence">Vencimiento:</label>
                                        {!! Form::text('vence', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'vence','disabled']) !!}
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="cantidad">Cantidad:</label>
                                        {!! Form::text('cantidad', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'cantidad']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="precio">Precio:</label>
                                        {!! Form::text('precio', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'precio','disabled']) !!}
                                        {!! Form::text('preprom', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'preprom','hidden']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="subtotal">Subtotal:</label>
                                {!! Form::text('subtotal', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'subtotal','disabled']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-2">
                                {!! Form::submit('Agregar', ['class'=>'btn btn-success', 'id'=>'guardar']) !!}
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
            document.getElementById("umedida_id").disabled = false;
            document.getElementById("stock").disabled = false;
            document.getElementById("stockmin").disabled = false;
            document.getElementById("subtotal").disabled = false;
            document.getElementById("precio").disabled = false;
            document.getElementById("vence").disabled = false;
        });

        document.getElementById('cantidad').addEventListener("blur",function(){
            if(parseInt(this.value) > parseInt(document.getElementById("stock").value)){
                alert("Cantidad excede al stock de producto");
                this.value = '';
            }else{
                document.getElementById("subtotal").value = Redondea(this.value * document.getElementById("precio").value,2);
            }
        });

        document.getElementById('lote').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
        });
        
        document.getElementById('producto_id').addEventListener("blur",function(){
            $.get(url_global+"/admin/producto/"+this.value+"/searchid/",function(response){
                document.getElementById("umedida_id").value = response[0].umedida_id;
                document.getElementById("stock").value = response[0].stock;
                document.getElementById("stockmin").value = response[0].stockmin;
                document.getElementById("preprom").value = response[0].precompra;
                document.getElementById("precio").value = response[0].premerca;
                document.getElementById("afectacion_id").value = response[0].afecto+'0';
            });	
        });

        document.getElementById('buscarp').addEventListener("keyup",function(){
            tabresultp(this.value);
        });

        document.getElementById('buscarl').addEventListener("keyup",function(){
            tabresultl(this.value);
        });

        function tabresultp(parbus){
            var html = '';
            if(parbus.length >= 1){					
                $.get(url_global+"/admin/producto/"+parbus+"/search/",function(response){
                    if (response==""){
                        html = 'No se encontraton datos';
                    }else{
                        html += "<table class='table table-resposive table-hover table-sm'>";
                        html += "<thead><tr><th>NOMBRE</th><th>PRESENTACIÓN</th><th>STOCK</th><th>PRECIO</th><th></th></tr></thead>";
                        html += "<tbody>";
                        var regMostrar = 0;
                        if(response.length <= 10){
                            regMostrar = response.length;
                        }else{
                            regMostrar = 10;
                        }
                        for (var i = 0; i < regMostrar; i++) {
                            valor = response[i].id;
                            stock = Redondea(response[i].stock,2);
                            html += "<tr><td>"+response[i].nombre + "</td><td>" +response[i].umedida.nombre+"</td><td>" +response[i].stock+"</td><td>" +response[i].premerca+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devPr("+valor+");><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpop')[0].innerHTML = html;
                });								
            }
        }

        function tabresultl(parbus){
            var html = '';
            var producto = document.getElementById("producto_id").value;
            if(parbus.length >= 1){					
                $.get(url_global+"/admin/ingreso/"+producto+"/"+parbus+"/findlote/",function(response){
                    if (response==""){
                        html = 'No se encontraton datos';
                    }else{
                        html += "<table class='table table-resposive table-hover table-sm'>";
                        html += "<thead><tr><th>LOTE</th><th>VENCIMIENTO</th><th>STOCK</th><th></th></tr></thead>";
                        html += "<tbody>";
                        var regMostrar = 0;
                        if(response.length <= 10){
                            regMostrar = response.length;
                        }else{
                            regMostrar = 10;
                        }
                        for (var i = 0; i < regMostrar; i++) {
                            valor = response[i].id;
                            stock = Redondea(response[i].stock,2);
                            html += "<tr><td>"+response[i].lote + "</td><td>" +response[i].vencimiento+"</td><td>"+response[i].saldo+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devLot("+valor+");><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpol')[0].innerHTML = html;
                });								
            }
        }        
    });

    function devPr(valor){
        $.get(url_global+"/admin/producto/"+valor+"/searchid/",function(response){
            document.getElementById("umedida_id").value = response[0].umedida_id;
            //document.getElementById("afecto").value = response[0].afecto;
            document.getElementById("producto_id").value = valor;
            document.getElementById("stock").value = response[0].stock;
            document.getElementById("stockmin").value = response[0].stockmin;
            document.getElementById("preprom").value = response[0].precompra;
            document.getElementById("precio").value = response[0].premerca;
            document.getElementById("afectacion_id").value = response[0].afecto+'0';
        });	
    
    }

    function devLot(codigo){
        $.get(url_global+"/admin/ingreso/"+codigo+"/findlotid/",function(response){
            if (response!=""){
                document.getElementById("lote").value = response[0].lote;
                document.getElementById("vence").value = response[0].vencimiento;
            }else{
                alert('Errpr');
            }
        });
    }

    function limpia(){
        document.getElementsByClassName('cuerpop')[0].innerHTML = '';
        document.getElementById('buscarp').value = '';
        document.getElementsByClassName('cuerpol')[0].innerHTML = '';
        document.getElementById('buscarl').value = '';
    }
</script>
@endsection