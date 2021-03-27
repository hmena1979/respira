@extends('admin.master')
@section('title','Modelo de Receta')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/modrecetas') }}"><i class="fas fa-prescription"></i> Modelo de Recetas</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
                        {!! Form::open(['url'=>'/admin/modreceta/'.$modreceta->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <label class="lsinmargen" for="Nombre">Nombre:</label>
                                {!! Form::text('nombre', $modreceta->nombre, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
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
                        {!! Form::open(['url'=>'/admin/modreceta/'.$modreceta->id.'/deta']) !!}
                        <div class="row">
                            {!! Form::text('producto_id', '', ['class'=>'form-control', 'id'=>'producto_id', 'autocomplete'=>'off','hidden']) !!}
                            <div class="col-md-4">
                                <label class="lsinmargen" for="nombre">Producto:</label>
                                <div class="input-group">
                                    {!! Form::text('nombre', null, ['class'=>'form-control', 'id'=>'nombrep','autocomplete'=>'off']) !!}
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarprod" onclick="limpia()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="buscarprod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <input type="text" class='form-control' id= 'buscarp' placeholder = 'Ingrese productos' autocomplete="off" autofocus>
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
                                <label class="lsinmargen" for="composicion">Composición:</label>
                                {!! Form::text('composicion', null, ['class'=>'form-control', 'id'=>'composicion','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="umedida_id">Presentación:</label>
                                {!! Form::select('umedida_id',$umedida,null,['class'=>'custom-select', 'id'=>'umedida_id', 'placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="cantidad">Cantidad:</label>
                                {!! Form::text('cantidad', null, ['class'=>'form-control', 'id'=>'cantidad','autocomplete'=>'off']) !!}	
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-7">
                                <label class="lsinmargen" for="posologia">Posología:</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        {!! Form::text('posologia', null, ['class'=>'form-control tam30p','id'=>'posologia','autocomplete'=>'off']) !!}
                                        {!! Form::select('posmed_id',$posmed,'0',['class'=>'custom-select','id'=>'posmed_id']) !!}
                                        {!! Form::select('posfrec_id',$posfre,'0',['class'=>'custom-select','id'=>'posfrec_id']) !!}	
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="lsinmargen" for="postie_id">Tiempo:</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        {!! Form::text('postie', null, ['class'=>'form-control tam30p','id'=>'postie','autocomplete'=>'off']) !!}
                                        {!! Form::select('postie_id',$postie,'0',['class'=>'custom-select','id'=>'postie_id']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="recomendacion">Indicaciones:</label>
                                {!! Form::text('recomendacion', null, ['class'=>'form-control','id'=>'recomendacion','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::submit('+', ['class'=>'btn btn-success mtop25', 'title'=>"Agregar receta", 'id'=>'btnprescription']) !!}
                                {!! Form::close() !!}
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
        document.getElementById('buscarp').addEventListener("keyup",function(){				
            tabproductos(this.value);
            
        });

        function tabproductos(parbus){
            var html = '';
            if(parbus.length >= 1){					
                $.get(url_global+"/admin/producto/"+parbus+"/search/",function(response){
                    if (response==""){
                        html = 'No se encontraton datos';
                    }else{
                        html += "<table class='table table-resposive table-hover table-sm'>";
                        html += "<thead><tr><th>NOMBRE</th><th>COMPOSICION</th><th>Presentación</th><th>Stock</th><th>Precio</th><th></th></tr></thead>";
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
                            html += "<tr><td>"+response[i].nombre + "</td><td>" + response[i].composicion.nombre+"</td><td>"+response[i].umedida.nombre+"</td><td>"+stock.toFixed(2)+"</td><td>"+response[i].premerca+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devPr("+valor+");><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpop')[0].innerHTML = html;
                });								
            }
        }
    });

    function devPr(valor){
        $.get(url_global+"/admin/producto/"+valor+"/searchid/",function(response){
            document.getElementById("nombrep").value = response[0].nombre;
            document.getElementById("composicion").value = response[0].composicion.nombre;
            document.getElementById("umedida_id").value = response[0].umedida_id;
            document.getElementById("producto_id").value = valor;
        });	
    
    }

    function limpia(){
        document.getElementsByClassName('cuerpop')[0].innerHTML = '';
        document.getElementById('buscarp').value = '';
    }

    
</script>
@endsection