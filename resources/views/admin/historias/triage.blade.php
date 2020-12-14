@extends('admin.master')
@section('title','Pacientes')
@section('breadcrumb')
	<li class="breadcrumb-item">
    <a href="javascript: history.go(-1)"><i class="fas fa-book-medical"></i> Pacientes</a>
    </li>
    <li class="breadcrumb-item">
    <a href="">Paciente: <strong> {{ $historia->pac->razsoc }}</strong> / Edad: <strong>{{\Carbon\Carbon::parse($historia->pac->fecnac)->age}} años</strong> / Ocupación: <strong> {{ $historia->pac->ocupacion }}</strong></a> 
        </li>
@endsection

@section('content')
	<div class="container-fluid">        
        <div class="row mtop16">            
            <div class="col-md-12">
				<div class="panel shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-stethoscope"></i> Triaje</h2>
                    </div>
                    <div class="inside mbottom16">
                    {!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/triage']) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="doctor_id" class="lsinmargen colorprin">Doctor:</label>
                            {!! Form::select('doctor_id',$doctor,$historia->doctor_id,['class'=>'custom-select', 'placeholder'=>'Sin asignar','disabled']) !!}	
                        </div>
                        <div class="col-md-3">
                            <label for="fecha" class="lsinmargen colorprin">Fecha:</label>
                            {!! Form::date('fecha', $historia->fecha, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                        </div>
                        <div class="col-md-3">
                            <label for="hora" class="lsinmargen colorprin">Hora cita:</label>
                            {!! Form::time('hora', $historia->hora, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                        </div>
                    </div>
                    <div class="row mtop16">
                        <div class="col-md-12">
                            <label for="signos" class="colorprin">Signos vitales:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="peso" class="lsinmargen">Peso(kg):</label>
                                    {!! Form::text('peso', $historia->peso, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-4">
                                    <label for="talla" class="lsinmargen">Talla(cm):</label>
                                    {!! Form::text('talla', $historia->talla, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-4">
                                    <label for="temp" class="lsinmargen">T°(°C):</label>
                                    {!! Form::text('temp', $historia->temp, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="fc" class="lsinmargen">FC(x'):</label>
                                    {!! Form::text('fc', $historia->fc, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="fr" class="lsinmargen">FR(x'):</label>
                                    {!! Form::text('fr', $historia->fr, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="sato2" class="lsinmargen">SpO2:</label>
                                    {!! Form::text('sato2', $historia->sato2, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="pa" class="lsinmargen">PA(mmHg):</label>
                                    {!! Form::text('pa', $historia->pa, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                        </div>  
                    </div>
                    {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                    </div>
                    

                </div>
            </div>
            
        </div>
	</div>
@endsection