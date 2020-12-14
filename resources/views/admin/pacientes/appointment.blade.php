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
        <div class="row mtop16">            
            <div class="col-md-12">
				<div class="panel shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-laptop-medical"></i> Programar cita</h2>
                    </div>
                    <div class="inside mbottom16">
                        {!! Form::open(['url'=>'/admin/paciente/'.$paciente->id.'/appointment']) !!}
                        <div class="row mtop16">
                            <div class="col-md-6">
                                <label for="doctor_id" class="lsinmargen colorprin">Dr asignado:</label>
                                {!! Form::select('doctor_id',$doctor,$paciente->doctor_id,['class'=>'custom-select']) !!}	
                            </div>
                            <div class="col-md-3">
                                <label for="tipo" class="lsinmargen colorprin">Tipo:</label>
                                {!! Form::select('tipo',$tipo,'1',['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-3">
                                <label for="tippac_id" class="lsinmargen colorprin">Tipo paciente:</label>
                                {!! Form::select('tippac_id',$tippac,$paciente->tippac_id,['class'=>'custom-select']) !!}
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-3">
                                <label for="fecha" class="lsinmargen colorprin">Fecha:</label>
                                {!! Form::date('fecha', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off','required']) !!}
                            </div>
                            <div class="col-md-3">
                                <label for="hora" class="lsinmargen colorprin">Hora:</label>
                                {!! Form::time('hora', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
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