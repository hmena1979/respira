@extends('admin.master')
@section('title','Pacientes')
@section('breadcrumb')
	<li class="breadcrumb-item">
    <a href="javascript: history.go(-1)"><i class="fas fa-book-medical"></i> Pacientes</a>
    </li>
    <li class="breadcrumb-item">
    <a href="">Paciente: <strong> {{ $paciente->razsoc }}</strong> / Edad: <strong>{{\Carbon\Carbon::parse($paciente->fecnac)->age}} años</strong> / Ocupación: <strong> {{ $paciente->ocupacion }}</strong></a> 
        </li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">            
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/paciente/'.$paciente->id.'/'.$item.'/past']) !!}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="antecedentes">
                                    <label for="antecedentes" class="colorprin">Antecedentes patológicos:</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="dm" id="dm" value="true" @if(kvfj($paciente->antecedentes, 'dm')) checked @endif>
                                    <label class="form-check-label" for="dm">DM.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hta" id="hta" value="true" @if(kvfj($paciente->antecedentes, 'hta')) checked @endif>
                                    <label class="form-check-label" for="hta">HTA.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="neumonia" id="neumonia" value="true" @if(kvfj($paciente->antecedentes, 'neumonia')) checked @endif>
                                    <label class="form-check-label" for="neumonia">Neumonía.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="tbc" id="tbc" value="true" @if(kvfj($paciente->antecedentes, 'tbc')) checked @endif>
                                    <label class="form-check-label" for="tbc">TBC.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="asma" id="asma" value="true" @if(kvfj($paciente->antecedentes, 'asma')) checked @endif>
                                    <label class="form-check-label" for="asma">Asma.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="tabaco" id="tabaco" value="true" @if(kvfj($paciente->antecedentes, 'tabaco')) checked @endif>
                                    <label class="form-check-label" for="tabaco">Tabaco.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="covid19" id="covid19" value="true" @if(kvfj($paciente->antecedentes, 'covid19')) checked @endif>
                                    <label class="form-check-label" for="covid19">Covid-19.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="ehlc" id="ehlc" value="true" @if(kvfj($paciente->antecedentes, 'ehlc')) checked @endif>
                                    <label class="form-check-label" for="ehlc">Exposición al humo de leña o carbón.</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alergias">
                                    <label for="alergias" class="colorprin">Alergias:</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="polvo" id="polvo" value="true" @if(kvfj($paciente->alergia, 'polvo')) checked @endif>
                                    <label class="form-check-label" for="polvo">Polvo.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="humedad" id="humedad" value="true" @if(kvfj($paciente->alergia, 'humedad')) checked @endif>
                                    <label class="form-check-label" for="humedad">Humedad.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="polen" id="polen" value="true" @if(kvfj($paciente->alergia, 'polen')) checked @endif>
                                    <label class="form-check-label" for="polen">Polen.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="medicamentos" id="medicamentos" value="true" @if(kvfj($paciente->alergia, 'medicamentos')) checked @endif>
                                    <label class="form-check-label" for="medicamentos">Medicamentos.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label mr-2" for="otros">Otros:</label>
                                    {!! Form::text('desotros', kvfj($paciente->alergia, 'desotros'), ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="tie_enfer" class="lsinmargen colorprin">Tiempo enfermedad:</label>
                                        {!! Form::text('tie_enfer', $paciente->tie_enfer, ['class'=>'form-control mr-2','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="tenfact" class="lsinmargen colorprin">Tiempo EP actual:</label>
                                        {!! Form::text('tenfact', $paciente->tenfact, ['class'=>'form-control mr-2','autocomplete'=>'off']) !!}  
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
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
			<div class="col-md-2">
				<div class="panel shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-user-circle"></i> Historias</h2>
                    </div>
                    <div class="list-group">
                        @if($paciente->his->count()===0)
                        <a href="#" class="list-group-item list-group-item-action active">
                            {{\Carbon\Carbon::now()->format('d-m-Y')}}
                        </a>
                        @else
                        @foreach($paciente->his as $his) 
                            @if($his->item===$item && $exa <> '1')
                            <a href="{{ url('/admin/historias/'.$his->paciente_id.'/'.$his->item.'/home') }}" class="list-group-item list-group-item-action active">{{$his->fecha}}</a>
                            @else
                            <a href="{{ url('/admin/historias/'.$his->paciente_id.'/'.$his->item.'/home') }}" class="list-group-item list-group-item-action">{{$his->fecha}}</a>
                            @endif
                        @endforeach
                        <a href="{{ url('/admin/historias/'.$his->paciente_id.'/'.'E'.'/home') }}" class="list-group-item list-group-item-action @if($exa == '1') active @endif">Exámenes</a>
                        @endif
                        
                      </div>
                </div>
            </div>
            <div class="col-md-10">
				<div class="panel shadow">
					<div class="inside">
                        @if($exa == '1')
                        @include('admin.historias.form_historia_examen')    
                        @else
                        @if($paciente->his->count()===0)
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-anamnesis-tab" data-toggle="tab" href="#nav-anamnesis" role="tab" aria-controls="nav-anamnesis" aria-selected="true">Anamnesis</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-anamnesis" role="tabpanel" aria-labelledby="nav-anamnesis-tab">
                                    @include('admin.historias.form_historia_new')
                                </div>
                            </div>
                        @else
                        @foreach($historia1 as $historia)
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link @if(session('pagina')==='uno') active @endif" id="nav-anamnesis-tab" data-toggle="tab" href="#nav-anamnesis" role="tab" aria-controls="nav-anamnesis" aria-selected="true">Anamnesis</a>
                                <a class="nav-item nav-link @if(session('pagina')==='dos') active @endif" id="nav-diagnostico-tab" data-toggle="tab" href="#nav-diagnostico" role="tab" aria-controls="nav-diagnostico" aria-selected="true">Diagnóstico</a>
                                <a class="nav-item nav-link @if(session('pagina')==='tres') active @endif" id="nav-plan-tab" data-toggle="tab" href="#nav-plan" role="tab" aria-controls="nav-plan" aria-selected="false">Plan terapeutico</a>
                                <a class="nav-item nav-link @if(session('pagina')==='cuatro') active @endif" id="nav-receta-tab" data-toggle="tab" href="#nav-receta" role="tab" aria-controls="nav-receta" aria-selected="false">Receta</a>
                                <a class="nav-item nav-link @if(session('pagina')==='cinco') active @endif" id="nav-cita-tab" data-toggle="tab" href="#nav-cita" role="tab" aria-controls="nav-cita" aria-selected="false">Próxima consulta</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade @if(session('pagina')==='uno') show active @endif" id="nav-anamnesis" role="tabpanel" aria-labelledby="nav-anamnesis-tab">
                                @include('admin.historias.form_historia_edit')
                            </div>
                            <div class="tab-pane fade @if(session('pagina')==='dos') show active @endif" id="nav-diagnostico" role="tabpanel" aria-labelledby="nav-diagnostico-tab">
                                @include('admin.historias.form_historia_diagnosis')                                    
                            </div>
                            <div class="tab-pane fade @if(session('pagina')==='tres') show active @endif" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                                @include('admin.historias.form_historia_plan')
                            </div>
                            <div class="tab-pane fade @if(session('pagina')==='cuatro') show active @endif" id="nav-receta" role="tabpanel" aria-labelledby="nav-receta-tab">
                                @include('admin.historias.form_historia_prescription')
                            </div>
                            <div class="tab-pane fade @if(session('pagina')==='cinco') show active @endif" id="nav-cita" role="tabpanel" aria-labelledby="nav-cita-tab">
                                @include('admin.historias.form_historia_cita')                  
                            </div>
                        </div>
                        @endforeach
                        @endif
                        
                        @endif
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
        // $("cie10_id").bind('keypress',function(event){
        //     var regex = new RegExp("^[a-zA-Z0-9]+$");
        //     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        //     if(!regex.test(key)){
        //         event.preventDefault();
        //         return false;
        //     }
        // });

        document.getElementById('cie10_id').addEventListener("keypress",function(event){
            var regex = new RegExp("^[a-zA-Z0-9*]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if(!regex.test(key)){
                event.preventDefault();
                return false;
            }
        });
        
        document.getElementById('cie10_id').addEventListener("change",function(){
            this.value = this.value.toUpperCase();
            document.getElementById("dcie10").value = this.value;
        });

        document.getElementById('buscarm').addEventListener("keyup",function(){				
            tabresult(this.value);
            
        });

        document.getElementById('buscarp').addEventListener("keyup",function(){				
            tabproductos(this.value);
            
        });
    
        function tabresult(parbus){
            var html = '';
            if(parbus.length >= 1){					
                $.get(url_global+"/admin/cie10/buscie10/"+parbus+"",function(response){
                    if (response==""){
                        html = 'No se encontraton datos';
                    }else{
                        html += "<table class='table table-resposive table-hover table-sm'>";
                        html += "<thead><tr><th>CÓDIGO</th><th>NOMBRE</th><th></th></tr></thead>";
                        html += "<tbody>";
                        var regMostrar = 0;
                        if(response.length <= 250){
                            regMostrar = response.length;
                        }else{
                            regMostrar = 250;
                        }
                        for (var i = 0; i < regMostrar; i++) {
                            html += "<tr><td>"+response[i].codigo + "</td><td>" + response[i].nombre+"</td>";
                            html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devId('"+response[i].codigo+"');><i class='fas fa-check'></i></button></div></td></tr>"
                        }
                        html += "</tbody></table>";							
                    }
                    document.getElementsByClassName('cuerpom')[0].innerHTML = html;
                });								
            }
        }

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

        $('#nav-tab a[href="#nav-anamnesis"]').on('click', function (e) {
            {{session(['pagina' => "uno"])}}
            })
    });
    
    function devId(codigo){
        document.getElementById("cie10_id").value = codigo;
        document.getElementById("dcie10").value = codigo;
        document.getElementById('buscarm').value = '';
    }

    function devPr(valor){
        $.get(url_global+"/admin/producto/"+valor+"/searchid/",function(response){
            document.getElementById("nombrep").value = response[0].nombre;
            document.getElementById("composicion").value = response[0].composicion.nombre;
            document.getElementById("umedida_id").value = response[0].umedida_id;
            document.getElementById("producto_id").value = valor;
        });	
    
    }

    function editItemReceta(valor){
        //document.getElementById("agregaitem").style.display = 'none';
        $.get(url_global+"/admin/historia/"+valor+"/searchprescription/",function(response){
            // alert(response.nombre);
            document.getElementById("receta_id").value = response.id;
            document.getElementById("tipitem").value = 2;
            document.getElementById("producto_id").value = response.producto_id;
            document.getElementById("nombrep").value = response.nombre;
            document.getElementById("composicion").value = response.composicion;
            document.getElementById("umedida_id").value = response.umedida_id;
            document.getElementById("cantidad").value = response.cantidad;
            document.getElementById("posologia").value = response.posologia;
            document.getElementById("posmed_id").value = response.posmed_id;
            document.getElementById("posfrec_id").value = response.posfrec_id;
            document.getElementById("postie").value = response.postie;
            document.getElementById("postie_id").value = response.postie_id;
            document.getElementById("recomendacion").value = response.recomendacion;
            document.getElementById("btnprescription").value = 'Actualizar';
            document.getElementById("nombrep").focus();
        });	
        
        alert(id);
    }

    function limpia(){
        document.getElementsByClassName('cuerpom')[0].innerHTML = '';
        document.getElementsByClassName('cuerpop')[0].innerHTML = '';
    }
</script>
@endsection