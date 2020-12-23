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
                        <h2 class="title"><i class="far fa-calendar"></i> Editar consulta</h2>
                    </div>
                    <div class="inside mbottom16">
                        {!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/change']) !!}
                        <div class="row mtop16">
                            <div class="col-md-3">
                                <label for="fecha" class="lsinmargen colorprin">Fecha:</label>
                                {!! Form::date('fecha', $historia->fecha, ['class'=>'form-control','autocomplete'=>'off','required']) !!}
                            </div>
                            <div class="col-md-4">
                                <label for="doctor_id" class="lsinmargen colorprin">Doctor:</label>
                                {!! Form::select('doctor_id',$doctor,$historia->doctor_id,['class'=>'custom-select']) !!}	
                            </div>
                            <div class="col-md-2">
                                <label for="tipo" class="lsinmargen colorprin">Tipo:</label>
                                {!! Form::select('tipo',$tipo,$historia->tipo,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-3">
                                <label for="tippac_id" class="lsinmargen colorprin">Tipo paciente:</label>
                                {!! Form::select('tippac_id',$tippac,$historia->tippac_id,['class'=>'custom-select']) !!}
                            </div>
                        </div>
                        {!! Form::submit('Actualizar', ['class'=>'btn btn-success mtop16']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection