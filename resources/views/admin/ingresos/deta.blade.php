@extends('admin.master')
@section('title','Compras')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/ingresos/'.session('padmision')) }}"><i class="fas fa-cart-plus"></i> Compras</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
                        {!! Form::open(['url'=>'/admin/ingreso/'.$ingreso->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::text('fecha', $ingreso->fecha, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,$ingreso->comprobante_id,['class'=>'custom-select', 'id'=>'comprobante_id','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="num_doc">Número:</label>							
                                        {!! Form::text('numero', $ingreso->serie.'-'.$ingreso->numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero','disabled']) !!}
                                    </div>
                                    <div class="col-md-8">
                                        <label class="lsinmargen" for="ruc">Proveedor:</label>
                                        {!! Form::select('proveedor_id',$proveedores,$ingreso->proveedor_id,['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija Cliente','disabled']) !!}
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
                        {!! Form::open(['url'=>'/admin/ingreso/'.$ingreso->id.'/deta']) !!}
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
                                {!! Form::select('umedida_id',$umedida,null,['class'=>'custom-select','id'=>'umedida_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="afecto">Afecto:</label>
                                {!! Form::select('afecto',[1 => 'Si', 2=>'No'],1,['class'=>'custom-select','id'=>'afecto']) !!}
                            </div>

                            <div class="col-md-2">
                                <label class="lsinmargen" for="cantidad">Cantidad:</label>
                                {!! Form::text('cantidad', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'cantidad']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-2">
                                <label class="lsinmargen" for="pre_ini">Precio inicial:</label>
                                {!! Form::text('pre_ini', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'pre_ini']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="igv">IGV</label>
                                {!! Form::select('igv',[1 => 'Incluído', 2=>'No Incluído'],1,['class'=>'custom-select','id'=>'igv']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="precio">Precio:</label>
                                {!! Form::text('precio', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'precio']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="subtotal">Subtotal:</label>
                                {!! Form::text('subtotal', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'subtotal','disabled']) !!}
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
                                        {!! Form::text('vence', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'vence']) !!}
                                    </div>
                                </div>                                
                            </div>
                            
                            
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-10">
                                <label class="lsinmargen" for="glosa">Observaciones:</label>
                                {!! Form::text('glosa', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'glosa']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::submit('Agregar', ['class'=>'btn btn-success mtop20', 'id'=>'guardar']) !!}
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
            // document.getElementById("precio").disabled = false;
            document.getElementById("subtotal").disabled = false;
        });

        document.getElementById('cantidad').addEventListener("blur",function(){
            document.getElementById("subtotal").value = Redondea(this.value * document.getElementById("precio").value,4);
        });

        document.getElementById('pre_ini').addEventListener("blur",function(){
            var pIGV = (parseInt('{{ session('igv') }}')/100)+1;
            if(document.getElementById("igv").value == 1 && document.getElementById("afecto").value == 1){
                document.getElementById("precio").value = Redondea(this.value / pIGV,4);
            }else{
                document.getElementById("precio").value = this.value
            }
            
            document.getElementById("subtotal").value = Redondea(document.getElementById("cantidad").value * document.getElementById("precio").value,2);
        });

        document.getElementById('igv').addEventListener("blur",function(){
            var pIGV = (parseInt('{{ session('igv') }}')/100)+1;
            if(this.value == 1 && document.getElementById("afecto").value == 1){
                document.getElementById("precio").value = Redondea(document.getElementById("pre_ini").value / pIGV,4);
            }else{
                document.getElementById("precio").value = document.getElementById("pre_ini").value
            }
            
            document.getElementById("subtotal").value = Redondea(document.getElementById("cantidad").value * document.getElementById("precio").value,2);
        });



        document.getElementById('precio').addEventListener("blur",function(){
            document.getElementById("subtotal").value = Redondea(this.value * document.getElementById("cantidad").value,2);
        });

        document.getElementById('lote').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
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
                        html += "<thead><tr><th>NOMBRE</th><th>Presentación</th><th></th></tr></thead>";
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
                            html += "<tr><td>"+response[i].nombre + "</td><td>" +response[i].umedida.nombre+"</td>";
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
            document.getElementById("afecto").value = response[0].afecto;
            document.getElementById("producto_id").value = valor;
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