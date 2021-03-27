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
                        {!! Form::open(['url'=>'/admin/terapia/'.$terapia->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ruc">Paciente:</label>
                                    <div class="input-group">
                                        {!! Form::select('razsoc',$pacientes,$terapia->paciente_id,['class'=>'custom-select', 'id'=>'razsoc', 'placeholder'=>'Elija paciente']) !!}
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
                                {!! Form::text('fnacim', $paciente->fecnac, ['class'=>'form-control','id'=>'fnacim','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="edad">Edad:</label>
                                {!! Form::text('edad', \Carbon\Carbon::parse($paciente->fecnac)->age, ['class'=>'form-control','id'=>'edad','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="sexo">Sexo:</label>
                                {!! Form::select('sexo',$sexo,$paciente->sexo_id,['class'=>'custom-select','id'=>'sexo','disabled', 'placeholder'=>'']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="direccion">Dirección:</label>
                                {!! Form::text('direccion', $paciente->direccion, ['class'=>'form-control','id'=>'direccion','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hijos">Hijos:</label>
                                {!! Form::text('hijos', null, ['class'=>'form-control','id'=>'hijos','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="doctor_id">Médico tratante:</label>
                                {!! Form::select('doctor_id',$doctor,$paciente->doctor_id,['class'=>'custom-select', 'id'=>'doctor_id', 'placeholder'=>'','disabled']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="diagnostico">Diagnóstico:</label>
                                {!! Form::text('diagnostico', $terapia->diagnostico, ['class'=>'form-control','id'=>'diagnostico','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hospitalizacion">Hospitalización:</label>
                                {!! Form::select('hospitalizacion',[1=>'Si',2=>'No'],$terapia->hospitalizacion,['class'=>'custom-select','id'=>'hospitalizacion']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hospfech">Fecha:</label>
                                {!! Form::text('hospfech', $terapia->hospfech, ['class'=>'form-control','id'=>'hospfech','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hosplugar">Lugar:</label>
                                {!! Form::text('hosplugar', $terapia->hosplugar, ['class'=>'form-control','id'=>'hosplugar','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="hospalta">Alta:</label>
                                {!! Form::text('hospalta', $terapia->hospalta, ['class'=>'form-control','id'=>'hospalta','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="fechaeval">Fecha evaluación:</label>
                                {!! Form::date('fechaeval', $terapia->fechaeval, ['class'=>'form-control','id'=>'fechaeval','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="altura">Altura:</label>
                                {!! Form::text('altura', $terapia->altura, ['class'=>'form-control','id'=>'altura','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="peso">Peso:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        {!! Form::text('peso', $terapia->peso, ['class'=>'form-control','autocomplete'=>'off','id'=>'peso']) !!}
                                    </div>
                                    <div class="col-md-9">								
                                        {!! Form::text('pesoglosa', $terapia->pesoglosa, ['class'=>'form-control','autocomplete'=>'off','id'=>'pesoglosa']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fumador">Fumador:</label>
                                {!! Form::select('fumador',[1=>'Si',2=>'No',3=>'Ex'],$terapia->fumador,['class'=>'custom-select','id'=>'fumador']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fumcese">Fecha cese:</label>
                                {!! Form::text('fumcese', $terapia->fumcese, ['class'=>'form-control','id'=>'fumcese','autocomplete'=>'off']) !!}
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
                                {!! Form::text('spo2', $terapia->spo2, ['class'=>'form-control','id'=>'spo2','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="fc">FC:</label>
                                {!! Form::text('fc', $terapia->fc, ['class'=>'form-control','id'=>'fc','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="resxmin">RESXMIN:</label>
                                {!! Form::text('resxmin', $terapia->resxmin, ['class'=>'form-control','id'=>'resxmin','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="pa">PA:</label>
                                {!! Form::text('pa', $terapia->pa, ['class'=>'form-control','id'=>'pa','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="ocupacion">Ocupación:</label>
                                {!! Form::text('ocupacion', $terapia->ocupacion, ['class'=>'form-control','id'=>'ocupacion','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-6">
                                <label class="lsinmargen" for="enfpersistente">Enfermedad persistente:</label>
                                {!! Form::text('enfpersistente', $terapia->enfpersistente, ['class'=>'form-control','id'=>'enfpersistente','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="hta">HTA:</label>
                                {!! Form::text('hta', $terapia->hta, ['class'=>'form-control','id'=>'hta','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="dbt">DBT:</label>
                                {!! Form::text('dbt', $terapia->dbt, ['class'=>'form-control','id'=>'dbt','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-4">
                                <label class="lsinmargen" for="colytri">Colesterol y Triglicéridos:</label>
                                {!! Form::text('colytri', $terapia->colytri, ['class'=>'form-control','id'=>'colytri','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-3">
                                <label class="lsinmargen" for="dolart">Dolor articular:</label>
                                {!! Form::text('dolart', $terapia->dolart, ['class'=>'form-control','id'=>'dolart','autocomplete'=>'off']) !!}
                            </div>                            
                            <div class="col-md-3">
                                <label class="lsinmargen" for="dolmusc">Dolor muscular:</label>
                                {!! Form::text('dolmusc', $terapia->dolmusc, ['class'=>'form-control','id'=>'dolmusc','autocomplete'=>'off']) !!}
                            </div>                            
                            <div class="col-md-3">
                                <label class="lsinmargen" for="cirujias">Antecedentes - Cirujías:</label>
                                {!! Form::text('cirujias', $terapia->cirujias, ['class'=>'form-control','id'=>'cirujias','autocomplete'=>'off']) !!}
                            </div>                            
                            <div class="col-md-3">
                                <label class="lsinmargen" for="osteoporosis">Osteoporosis:</label>
                                {!! Form::text('osteoporosis', $terapia->osteoporosis, ['class'=>'form-control','id'=>'osteoporosis','autocomplete'=>'off']) !!}
                            </div>                            
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="motivo">Motivo de la consulta:</label>
                                {!! Form::textarea('motivo',$terapia->motivo,['class'=>'form-control', 'rows'=>'3', 'id' => 'editor']) !!}			
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-4">
                                <label class="lsinmargen" for="tos">Tos:</label>
                                {!! Form::text('tos', $terapia->tos, ['class'=>'form-control','id'=>'tos','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-4">
                                <label class="lsinmargen" for="espectoracion">Espectoración:</label>
                                {!! Form::text('espectoracion', $terapia->espectoracion, ['class'=>'form-control','id'=>'espectoracion','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-4">
                                <label class="lsinmargen" for="sagita">Siente que se agita:</label>
                                {!! Form::text('sagita', $terapia->sagita, ['class'=>'form-control','id'=>'sagita','autocomplete'=>'off']) !!}
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
                                {!! Form::text('muscresp', $terapia->muscresp, ['class'=>'form-control','id'=>'muscresp','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-3">
                                <label class="lsinmargen" for="musccuello">Músculos del Cuello:</label>
                                {!! Form::text('musccuello', $terapia->musccuello, ['class'=>'form-control','id'=>'musccuello','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-3">
                                <label class="lsinmargen" for="muscabdom">Músculos Abdominales:</label>
                                {!! Form::text('muscabdom', $terapia->muscabdom, ['class'=>'form-control','id'=>'muscabdom','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3">
                                <label class="lsinmargen" for="capresp">Capacidad Respiratoria:</label>
                                {!! Form::text('capresp', $terapia->capresp, ['class'=>'form-control','id'=>'capresp','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                {!! Form::text('efisglosa', $terapia->efisglosa, ['class'=>'form-control','id'=>'efisglosa','autocomplete'=>'off']) !!}
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
                                {!! Form::text('emtono', $terapia->emtono, ['class'=>'form-control','id'=>'emtono','autocomplete'=>'off']) !!}
                            </div>    
                            <div class="col-md-3">
                                <label class="lsinmargen" for="emfuerza">Fuerza:</label>
                                {!! Form::text('emfuerza', $terapia->emfuerza, ['class'=>'form-control','id'=>'emfuerza','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row mtop8f">
                            <div class="col-md-12">
                                <label class="lsinmargen" for="objetivos">Objetivos:</label>
                                {!! Form::textarea('objetivos',$terapia->objetivos,['class'=>'form-control', 'rows'=>'3', 'id' => 'objetivos']) !!}			
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
        <div class="row mtop10">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        <div class="row mtop10">
                            <div class="col-md-12">
                                {!! Form::open(['url'=>'/admin/terapia/'.$terapia->id.'/addeditdetitem']) !!}
                                <div class="row">
                                    {!! Form::text('tipitem', 1, ['class'=>'form-control', 'autocomplete'=>'off','id'=>'tipitem','hidden']) !!}
                                    {!! Form::text('idi', null, ['class'=>'form-control', 'autocomplete'=>'off','id'=>'idi','hidden']) !!}
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="t">T:</label>
                                        {!! Form::text('t', null, ['class'=>'form-control', 'id'=>'t','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="v">V:</label>
                                        {!! Form::text('v', null, ['class'=>'form-control', 'id'=>'v','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="sao2">SaO2:</label>
                                        {!! Form::text('sao2', null, ['class'=>'form-control', 'id'=>'sao2','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="fc">FC:</label>
                                        {!! Form::text('fc', null, ['class'=>'form-control', 'id'=>'fc1','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="actividad">Actividad:</label>
                                        {!! Form::text('actividad', null, ['class'=>'form-control', 'id'=>'actividad','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::submit('+', ['class'=>'btn btn-success mtop25', 'title'=>"Agregar", 'id'=>'btndeteval']) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <table class="table table-hover table-sm table-bordered table">
                                    <thead class="thead-blue">
                                        <tr>
                                            <th width="10%">T</th>
                                            <th width="10%">V</th>
                                            <th width="10%">SaO2</th>
                                            <th width="10%">FC</th>
                                            <th width="30%">Actividad</th>
                                            <th width="10%"></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detterapia as $r)
                                        <tr>
                                            <td>{{ $r->t }}</td>
                                            <td>{{ $r->v}}</td>
                                            <td>{{ $r->sao2 }}</td>
                                            <td>{{ $r->fc }}</td>
                                            <td>{{ $r->actividad }}</td>
                                            <td class="text-center">
                                                <div class="opts">
                                                    <button type="button" class="btn" onclick="editItemReceta('{{ $r->id }}')" datatoggle="tooltip" data-placement="top" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="{{ url('/admin/terapia/'.$r->id.'/deleteitem') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                                    {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
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
            </div>
        </div>
        <div class="row mtop10">
            <div class="col-md-12 mb-5">
                <div class="panel shadow">
                    <div class="inside">
                        <div class="row mtop10">
                            <div class="col-md-12">
                                {!! Form::open(['url'=>'/admin/terapia/'.$terapia->id.'/addeditdetitem2']) !!}
                                <div class="row">
                                    {!! Form::text('tipitem', 1, ['class'=>'form-control', 'autocomplete'=>'off','id'=>'tipitem2','hidden']) !!}
                                    {!! Form::text('idi', null, ['class'=>'form-control', 'autocomplete'=>'off','id'=>'idi2','hidden']) !!}
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="t">T:</label>
                                        {!! Form::text('t', null, ['class'=>'form-control', 'id'=>'t2','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="v">V:</label>
                                        {!! Form::text('v', null, ['class'=>'form-control', 'id'=>'v2','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="sao2">SaO2:</label>
                                        {!! Form::text('sao2', null, ['class'=>'form-control', 'id'=>'sao22','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <label class="lsinmargen" for="fc">FC:</label>
                                        {!! Form::text('fc', null, ['class'=>'form-control', 'id'=>'fc12','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="lsinmargen" for="actividad">Actividad:</label>
                                        {!! Form::text('actividad', null, ['class'=>'form-control', 'id'=>'actividad2','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::submit('+', ['class'=>'btn btn-success mtop25', 'title'=>"Agregar", 'id'=>'btndeteval2']) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <table class="table table-hover table-sm table-bordered table">
                                    <thead class="thead-blue">
                                        <tr>
                                            <th width="10%">T</th>
                                            <th width="10%">V</th>
                                            <th width="10%">SaO2</th>
                                            <th width="10%">FC</th>
                                            <th width="30%">Actividad</th>
                                            <th width="10%"></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detterapia2 as $r)
                                        <tr>
                                            <td>{{ $r->t }}</td>
                                            <td>{{ $r->v}}</td>
                                            <td>{{ $r->sao2 }}</td>
                                            <td>{{ $r->fc }}</td>
                                            <td>{{ $r->actividad }}</td>
                                            <td class="text-center">
                                                <div class="opts">
                                                    <button type="button" class="btn" onclick="editItemReceta2('{{ $r->id }}')" datatoggle="tooltip" data-placement="top" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="{{ url('/admin/terapia/'.$r->id.'/deleteitem2') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                                    {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
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

    function editItemReceta(valor){
        //document.getElementById("agregaitem").style.display = 'none';
        $.get(url_global+"/admin/terapia/"+valor+"/searchitem/",function(response){
            // alert(response.nombre);
            document.getElementById("idi").value = response.id;
            document.getElementById("tipitem").value = 2;
            document.getElementById("t").value = response.t;
            document.getElementById("v").value = response.v;
            document.getElementById("sao2").value = response.sao2;
            document.getElementById("fc1").value = response.fc;
            document.getElementById("actividad").value = response.actividad;
            document.getElementById("btndeteval").value = 'Actualizar';
            document.getElementById("t").focus();
        });	
        
        alert(id);
    }

    function editItemReceta2(valor){
        //document.getElementById("agregaitem").style.display = 'none';
        $.get(url_global+"/admin/terapia/"+valor+"/searchitem2/",function(response){
            // alert(response.nombre);
            document.getElementById("idi2").value = response.id;
            document.getElementById("tipitem2").value = 2;
            document.getElementById("t2").value = response.t;
            document.getElementById("v2").value = response.v;
            document.getElementById("sao22").value = response.sao2;
            document.getElementById("fc12").value = response.fc;
            document.getElementById("actividad2").value = response.actividad;
            document.getElementById("btndeteval2").value = 'Actualizar';
            document.getElementById("t2").focus();
        });	
        
        alert(id);
    }

    function limpia(){
        document.getElementsByClassName('cuerpom')[0].innerHTML = '';
        document.getElementById('buscarm').value = '';
    }

</script>
@endsection