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
                                <label class="lsinmargen" for="total_clinica">Total:</label>
                                {!! Form::text('total_clinica', $factura->total_clinica, ['class'=>'form-control','autocomplete'=>'off','id'=>'total_clinica','disabled']) !!}

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
                        {!! Form::open(['url'=>'/admin/factura/'.$factura->id.'/detraccion']) !!}
                        <div class="row">
                            <div class="col-md-2">
                                <label class="lsinmargen" for="detraccion">Detracción:</label>
                                {!! Form::select('detraccion',[1=>'SI',2=>'NO'],$factura->detraccion,['class'=>'custom-select','id'=>'detraccion']) !!}
                            </div>
                            <div class="col-md-5">
                                <label class="lsinmargen" for="detraccion_id">Bien/Servicio:</label>
                                {!! Form::select('detraccion_id',$detraccion,$factura->detraccion_id,['class'=>'custom-select','id'=>'detraccion_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="detraccion_por">Procentaje:</label>
                                {!! Form::text('detraccion_por', $factura->detraccion_por, ['class'=>'form-control','autocomplete'=>'off','id'=>'detraccion_por']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="detraccion_monto">Monto:</label>
                                {!! Form::text('detraccion_monto', $factura->detraccion_monto, ['class'=>'form-control','autocomplete'=>'off','id'=>'detraccion_monto']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-1">
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success', 'id'=>'guardar']) !!}
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
        if(document.getElementById("detraccion").value == 1){
            document.getElementById("detraccion_id").disabled = false;
            document.getElementById("detraccion_por").disabled = false;
            document.getElementById("detraccion_monto").disabled = false;
        }else{
            document.getElementById("detraccion_id").disabled = true;
            document.getElementById("detraccion_por").disabled = true;
            document.getElementById("detraccion_monto").disabled = true;
        }
        document.getElementById('guardar').addEventListener("click",function(){
            document.getElementById("detraccion_id").disabled = false;
            document.getElementById("detraccion_por").disabled = false;
            document.getElementById("detraccion_monto").disabled = false;
        });

        document.getElementById('detraccion').addEventListener("change",function(){
            if(this.value == 1){
                document.getElementById("detraccion_id").disabled = false;
                document.getElementById("detraccion_por").disabled = false;
                document.getElementById("detraccion_monto").disabled = false;
            }else{
                document.getElementById("detraccion_id").disabled = true;
                document.getElementById("detraccion_por").disabled = true;
                document.getElementById("detraccion_monto").disabled = true;
                document.getElementById("detraccion_id").value = '';
                document.getElementById("detraccion_por").value = '';
                document.getElementById("detraccion_monto").value = '';
            }
        });

        document.getElementById('detraccion_id').addEventListener("change",function(){
            var detr = this.value;
            var total = document.getElementById("total_clinica").value
            $.get(url_global+"/admin/factura/"+detr+"/bdetrac/",function(response){
                document.getElementById("detraccion_por").value = response[0].porcentaje;
                document.getElementById("detraccion_monto").value = Redondea((response[0].porcentaje/100) * total,2);
            });
        });

        document.getElementById('detraccion_por').addEventListener("blur",function(){
            var total = document.getElementById("total_clinica").value
            document.getElementById("detraccion_monto").value = Redondea((this.value/100) * total,2);
        });

        document.getElementById('precli').addEventListener("blur",function(){
            document.getElementById("predr").value = document.getElementById("precio").value - this.value;
            document.getElementById("stdr").value = document.getElementById("cantidad").value * document.getElementById("predr").value
            document.getElementById("stcli").value = document.getElementById("cantidad").value * document.getElementById("precli").value
        });

        document.getElementById('predr').addEventListener("blur",function(){
            document.getElementById("precli").value = document.getElementById("precio").value - this.value;
            document.getElementById("stdr").value = document.getElementById("cantidad").value * document.getElementById("predr").value
            document.getElementById("stcli").value = document.getElementById("cantidad").value * document.getElementById("precli").value
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
                document.getElementById("precli").value = response[0].clinica;
                document.getElementById("predr").value = response[0].especialista;
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