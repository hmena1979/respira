{!! Form::open(['url'=>'/admin/historia/'.$paciente->id.'/'.$historia->item.'/cita']) !!}
<div class="row mtop16">
    <div class="col-md-6">
        <label for="doctor_id" class="lsinmargen colorprin">Dr asignado:</label>
        {!! Form::select('doctor_id',$doctor,$paciente->doctor_id,['class'=>'custom-select', 'placeholder'=>'SIN ASIGNAR']) !!}	
    </div>
    <div class="col-md-3">
        <label for="tipo" class="lsinmargen colorprin">Tipo:</label>
        {!! Form::select('tipo',$tipo,$historia->ptipo,['class'=>'custom-select']) !!}
    </div>
    <div class="col-md-3">
        <label for="fecha" class="lsinmargen colorprin">Fecha:</label>
        {!! Form::date('fecha', $historia->pfecha, ['class'=>'form-control','autocomplete'=>'off','required']) !!}
    </div>
    
</div>
{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
{!! Form::close() !!}