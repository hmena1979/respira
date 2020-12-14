@extends('admin.master')
@section('title','Facturación - Admisión')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/facturas/'.session('padmision')) }}"><i class="fas fa-money-check-alt"></i> Facturación - Admisión</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
                        {!! Form::open(['url'=>'/admin/factura/'.$factura->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="lsinmargen" for="fecha">Fecha:</label>
                                        {!! Form::text('fecha', $factura->fecha, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <label class="lsinmargen" for="comprobante_id">Comprobante:</label>
                                        {!! Form::select('comprobante_id',$comprobante,$factura->comprobante_id,['class'=>'custom-select', 'id'=>'comprobante_id','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="num_doc">Número:</label>							
                                        {!! Form::text('numero', $factura->serie.'-'.$factura->numero, ['class'=>'form-control','autocomplete'=>'off','id'=>'numero','disabled']) !!}
                                    </div>
                                    <div class="col-md-8">
                                        <label class="lsinmargen" for="ruc">Cliente:</label>
                                        {!! Form::select('razsoc',$clientes,$factura->ruc,['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija Cliente','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="doctor_id">Doctor:</label>
                                {!! Form::select('doctor_id',$doctor,$factura->doctor_id,['class'=>'custom-select','id'=>'doctor_id','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fpago_id">F.Pago:</label>
                                {!! Form::select('fpago_id',$fpago,$factura->fpago_id,['class'=>'custom-select', 'id'=>'fpago_id','disabled']) !!}
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
                        {!! Form::open(['url'=>'/admin/factura/'.$factura->id.'/deta']) !!}
                        <div class="row">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="servicio">Servicio:</label>
                                    <div class="input-group">
                                        {!! Form::textarea('servicio',null,['class'=>'form-control', 'rows'=>'1','id'=>'servicio']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarServ" onclick="limpia()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                <!-- Modal -->
                                <div class="modal fade" id="buscarServ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <input type="text" class='form-control' id= 'buscars' placeholder = 'Buscar servicio' autocomplete='off' autofocus>
                                            </div>
                                            <div class="modal-body">
                                                <div class="cuerpos">
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
                            <div class="col-md-1">
                                <label class="lsinmargen" for="cantidad">Cantidad:</label>
                                {!! Form::text('cantidad', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'cantidad']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="precio">Precio:</label>
                                {!! Form::text('precio', '', ['class'=>'form-control','autocomplete'=>'off','id'=>'precio']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="subtotal">Subtotal:</label>
                                {!! Form::text('subtotal', 0.00, ['class'=>'form-control','autocomplete'=>'off','id'=>'subtotal','disabled']) !!}
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="afectacion_id">Afectacion:</label>
                                {!! Form::select('afectacion_id',$afectacion,'10',['class'=>'custom-select','id'=>'afectacion_id']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen colorprin" for="clinica">Clínica:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="precli">Precio:</label>
                                        {!! Form::text('precli', 0.00, ['class'=>'form-control','autocomplete'=>'off','id'=>'precli']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="stcli">Subtotal:</label>
                                        {!! Form::text('stcli', 0.00, ['class'=>'form-control','autocomplete'=>'off','id'=>'stcli','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen colorprin" for="doctor">Doctor:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="predr">Precio:</label>
                                        {!! Form::text('predr', 0.00, ['class'=>'form-control','autocomplete'=>'off','id'=>'predr']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="lsinmargen" for="stdr">Subtotal:</label>
                                        {!! Form::text('stdr', 0.00, ['class'=>'form-control','autocomplete'=>'off','id'=>'stdr','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                {!! Form::submit('Agregar', ['class'=>'btn btn-success mtop40', 'id'=>'guardar']) !!}
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
            document.getElementById("subtotal").disabled = false;
            document.getElementById("stdr").disabled = false;
            document.getElementById("stcli").disabled = false;
        });

        document.getElementById('cantidad').addEventListener("blur",function(){
            document.getElementById("subtotal").value = this.value * document.getElementById("precio").value;
            document.getElementById("stdr").value = this.value * document.getElementById("predr").value;
            document.getElementById("stcli").value = this.value * document.getElementById("precli").value;
        });

        document.getElementById('servicio').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
        });

        document.getElementById('precio').addEventListener("blur",function(){
            document.getElementById("subtotal").value = this.value * document.getElementById("cantidad").value;
            document.getElementById("precli").value = this.value - document.getElementById("predr").value;
            document.getElementById("stdr").value = document.getElementById("cantidad").value * document.getElementById("predr").value;
            document.getElementById("stcli").value = document.getElementById("cantidad").value * document.getElementById("precli").value;
        });

        document.getElementById('precli').addEventListener("blur",function(){
            if(this.value > document.getElementById("precio").value){
                document.getElementById("predr").value = 0.00;
                document.getElementById("stdr").value = 0.00;
                document.getElementById("precio").value = this.value;
                document.getElementById("stcli").value = document.getElementById("cantidad").value * this.value;
                document.getElementById("subtotal").value = this.value * document.getElementById("cantidad").value;
            }else{
                document.getElementById("predr").value = document.getElementById("precio").value - this.value;
                document.getElementById("stdr").value = document.getElementById("cantidad").value * document.getElementById("predr").value;
                document.getElementById("stcli").value = document.getElementById("cantidad").value * document.getElementById("precli").value;
            }
        });

        document.getElementById('predr').addEventListener("blur",function(){
            document.getElementById("precli").value = document.getElementById("precio").value - this.value;
            document.getElementById("stdr").value = document.getElementById("cantidad").value * document.getElementById("predr").value;
            document.getElementById("stcli").value = document.getElementById("cantidad").value * document.getElementById("precli").value;
        });

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
                        html += "<thead><tr><th>Nombre</th><th>Precio</th><th></th></tr></thead>";
                        html += "<tbody>";
                        var regMostrar = 0;
                        if(response.length <= 10){
                            regMostrar = response.length;
                        }else{
                            regMostrar = 10;
                        }
                        for (var i = 0; i < regMostrar; i++) {
                            var valor = response[i].id;
                            html += "<tr><td>" + response[i].nombre+"</td><td>"+response[i].precio+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devIdS('"+valor+"');><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpos')[0].innerHTML = html;
                });								
            }
        }

        
    });

    function devIdS(codigo){
        $.get(url_global+"/admin/servicio/"+codigo+"/findid/",function(response){
            if (response!=""){
                document.getElementById("servicio").value = response[0].nombre;
                document.getElementById("precio").value = response[0].precio;
                if(document.getElementById("fpago_id").value==1){
                    document.getElementById("precli").value = response[0].clinica;
                    document.getElementById("predr").value = response[0].especialista;
                }else{
                    document.getElementById("precli").value = response[0].precio;
                    document.getElementById("predr").value = 0.00;
                }
                
            }else{
                alert('Errpr');
            }
        });
    }

    function limpia(){
        document.getElementsByClassName('cuerpos')[0].innerHTML = '';
        document.getElementById('buscars').value = '';
    }
</script>
@endsection