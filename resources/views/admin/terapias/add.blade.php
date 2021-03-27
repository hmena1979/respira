@extends('admin.master')
@section('title','Terapias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/terapias/') }}"><i class="fas fa-procedures"></i> Terapias</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
                        {!! Form::open(['url'=>'/admin/terapia/add']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ruc">Paciente:</label>
                                    <div class="input-group">
                                        {!! Form::select('razsoc',$pacientes,'',['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija paciente']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarModal" onclick="limpia()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="buscarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <input type="text" class='form-control' id= 'buscarm' placeholder = 'Buscar paciente' autocomplete='off' autofocus>
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
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fnacim">F.Nacimiento:</label>
                                {!! Form::text('fnacim', null, ['class'=>'form-control','id'=>'fnacim','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="edad">Edad:</label>
                                {!! Form::text('edad', null, ['class'=>'form-control','id'=>'edad','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="sexo">Sexo:</label>
                                {!! Form::select('sexo',$sexo,NULL,['class'=>'custom-select','id'=>'sexo','disabled', 'placeholder'=>'']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="direccion">Dirección:</label>
                                {!! Form::text('direccion', null, ['class'=>'form-control','id'=>'direccion','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hijos">Hijos:</label>
                                {!! Form::text('hijos', null, ['class'=>'form-control','id'=>'hijos','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="doctor_id">Médico tratante:</label>
                                {!! Form::select('doctor_id',$doctor,'',['class'=>'custom-select', 'id'=>'doctor_id', 'placeholder'=>'','disabled']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="diagnostico">Diagnóstico:</label>
                                {!! Form::text('diagnostico', null, ['class'=>'form-control','id'=>'diagnostico','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hospitalizacion">Hospitalización:</label>
                                {!! Form::select('hospitalizacion',[1=>'Si',2=>'No'],2,['class'=>'custom-select','id'=>'hospitalizacion']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hospfech">Fecha:</label>
                                {!! Form::text('hospfech', null, ['class'=>'form-control','id'=>'hospfech','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hosplugar">Lugar:</label>
                                {!! Form::text('hosplugar', null, ['class'=>'form-control','id'=>'hosplugar','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hospalta">Alta:</label>
                                {!! Form::text('hospalta', null, ['class'=>'form-control','id'=>'hospalta','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="fechaeval">Fecha evaluación:</label>
                                {!! Form::date('fechaeval', \Carbon\Carbon::now(), ['class'=>'form-control','id'=>'fechaeval','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="altura">Altura:</label>
                                {!! Form::text('altura', null, ['class'=>'form-control','id'=>'altura','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="peso">Peso:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        {!! Form::text('peso', null, ['class'=>'form-control','autocomplete'=>'off','id'=>'peso']) !!}
                                    </div>
                                    <div class="col-md-9">								
                                        {!! Form::text('pesoglosa', null, ['class'=>'form-control','autocomplete'=>'off','id'=>'pesoglosa']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fumador">Fumador:</label>
                                {!! Form::select('fumador',[1=>'Si',2=>'No',3=>'Ex'],2,['class'=>'custom-select','id'=>'fumador']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fumcese">Fecha cese:</label>
                                {!! Form::text('fumcese', null, ['class'=>'form-control','id'=>'fumcese','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label for="antecedentes" class="colorprin lsinmargen">SIGNOS VITALES:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="lsinmargen" for="spo2">SpO2:</label>
                                {!! Form::text('spo2', null, ['class'=>'form-control','id'=>'spo2','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fc">FC:</label>
                                {!! Form::text('fc', null, ['class'=>'form-control','id'=>'fc','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="resxmin">RESXMIN:</label>
                                {!! Form::text('resxmin', null, ['class'=>'form-control','id'=>'resxmin','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="pa">PA:</label>
                                {!! Form::text('pa', null, ['class'=>'form-control','id'=>'pa','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ocupacion">Ocupación:</label>
                                {!! Form::text('ocupacion', null, ['class'=>'form-control','id'=>'ocupacion','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-6">
                                <label class="lsinmargen" for="enfpersistente">Enfermedad persistente:</label>
                                {!! Form::text('enfpersistente', null, ['class'=>'form-control','id'=>'enfpersistente','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="hta">HTA:</label>
                                {!! Form::text('hta', null, ['class'=>'form-control','id'=>'hta','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="dbt">DBT:</label>
                                {!! Form::text('dbt', null, ['class'=>'form-control','id'=>'dbt','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="colytri">Colesterol y Triglicéridos:</label>
                                {!! Form::text('colytri', null, ['class'=>'form-control','id'=>'colytri','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="dolart">Dolor articular:</label>
                                {!! Form::text('dolart', null, ['class'=>'form-control','id'=>'dolart','autocomplete'=>'off']) !!}
                            </div>                            
                            <div class="col-md-3">
                                <label class="lsinmargen" for="dolmusc">Dolor muscular:</label>
                                {!! Form::text('dolmusc', null, ['class'=>'form-control','id'=>'dolmusc','autocomplete'=>'off']) !!}
                            </div>                            
                            <div class="col-md-3">
                                <label class="lsinmargen" for="cirujias">Antecedentes - Cirujías:</label>
                                {!! Form::text('cirujias', null, ['class'=>'form-control','id'=>'cirujias','autocomplete'=>'off']) !!}
                            </div>                            
                            <div class="col-md-3">
                                <label class="lsinmargen" for="osteoporosis">Osteoporosis:</label>
                                {!! Form::text('osteoporosis', null, ['class'=>'form-control','id'=>'osteoporosis','autocomplete'=>'off']) !!}
                            </div>                            
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="motivo">Motivo de la consulta:</label>
                                {!! Form::textarea('motivo',null,['class'=>'form-control', 'rows'=>'3', 'id' => 'editor']) !!}			
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="tos">Tos:</label>
                                {!! Form::text('tos', null, ['class'=>'form-control','id'=>'tos','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-4">
                                <label class="lsinmargen" for="espectoracion">Espectoración:</label>
                                {!! Form::text('espectoracion', null, ['class'=>'form-control','id'=>'espectoracion','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-4">
                                <label class="lsinmargen" for="sagita">Siente que se agita:</label>
                                {!! Form::text('sagita', null, ['class'=>'form-control','id'=>'sagita','autocomplete'=>'off']) !!}
                            </div>    
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label for="antecedentes" class="colorprin lsinmargen">EVALUACIÓN FÍSICA:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="muscresp">Músculos Respiratorios:</label>
                                {!! Form::text('muscresp', null, ['class'=>'form-control','id'=>'muscresp','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-3">
                                <label class="lsinmargen" for="musccuello">Músculos del Cuello:</label>
                                {!! Form::text('musccuello', null, ['class'=>'form-control','id'=>'musccuello','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-3">
                                <label class="lsinmargen" for="muscabdom">Músculos Abdominales:</label>
                                {!! Form::text('muscabdom', null, ['class'=>'form-control','id'=>'muscabdom','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="capresp">Capacidad Respiratoria:</label>
                                {!! Form::text('capresp', null, ['class'=>'form-control','id'=>'capresp','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                {!! Form::text('efisglosa', null, ['class'=>'form-control','id'=>'efisglosa','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label for="antecedentes" class="colorprin lsinmargen">ESTADO MUSCULAR:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="emtono">Tono:</label>
                                {!! Form::text('emtono', null, ['class'=>'form-control','id'=>'emtono','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-3">
                                <label class="lsinmargen" for="emfuerza">Fuerza:</label>
                                {!! Form::text('emfuerza', null, ['class'=>'form-control','id'=>'emfuerza','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="objetivos">Objetivos:</label>
                                {!! Form::textarea('objetivos',null,['class'=>'form-control', 'rows'=>'3', 'id' => 'objetivos']) !!}			
                            </div>
                        </div>
                        <div class="row mtop8f">
                            {{-- <div class="col-md-6">
                                <label class="lsinmargen" for="doctor_id">Doctor:</label>
                                {!! Form::select('doctor_id',$doctor,1,['class'=>'custom-select','id'=>'doctor_id']) !!}
                            </div> --}}
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
            // document.getElementById("periodo").disabled = false;
            // document.getElementById("dias").disabled = false;
            // document.getElementById("vencimiento").disabled = false;
            // document.getElementById("cancelacion").disabled = false;
            // document.getElementById("tc").disabled = false;
            // document.getElementById("serie").disabled = false;
            // document.getElementById("numero").disabled = false;
            // document.getElementById("noperacion").disabled = false;
        });

        
        document.getElementById('razsoc').addEventListener("change",function(){
            $.get(url_global+"/admin/paciente/"+this.value+"/busid/",function(response){
                document.getElementById('razsoc').value = response['id'];
                document.getElementById("fnacim").value = response['fecnac'];
                document.getElementById("edad").value = response['edad'];
                document.getElementById("sexo").value = response['sexo_id'];
                document.getElementById("direccion").value = response['direccion'];
                document.getElementById("hijos").value = '';
                document.getElementById("doctor_id").value = response['doctor_id'];
            });
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
        $.get(url_global+"/admin/paciente/"+codigo+"/busid/",function(response){
            document.getElementById('razsoc').value = response['id'];
            document.getElementById("fnacim").value = response['fecnac'];
            document.getElementById("edad").value = response['edad'];
            document.getElementById("sexo").value = response['sexo_id'];
            document.getElementById("direccion").value = response['direccion'];
            document.getElementById("hijos").value = '';
            document.getElementById("doctor_id").value = response['doctor_id'];
        });
    }

    function limpia(){
        document.getElementsByClassName('cuerpom')[0].innerHTML = '';
        document.getElementById('buscarm').value = '';
    }

</script>
@endsection