{!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/edit']) !!}
<div class="row mtop16">
    <div class="col-md-6">
        <label for="doctor_id" class="lsinmargen colorprin">Doctor:</label>
        {!! Form::select('doctor_id',$doctor,$historia->doctor_id,['class'=>'custom-select', 'placeholder'=>'Sin asignar','required']) !!}	
    </div>
    <div class="col-md-3">
        <label for="fecha" class="lsinmargen colorprin">Fecha:</label>
        {!! Form::date('fecha', $historia->fecha, ['class'=>'form-control','autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-3">
        <label for="hora" class="lsinmargen colorprin">Hora cita:</label>
        {!! Form::time('hora', $historia->hora, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
<div class="row mtop16">
    <div class="col-md-12">
        <label for="anammesis" class="lsinmargen colorprin">Relato:</label>
        {!! Form::textarea('anammesis',$historia->anammesis,['class'=>'form-control', 'rows'=>'4']) !!}			
    </div>
</div>
<div class="row mtop16 @if($historia->item==='001') oculto @endif">
    <div class="col-md-12">
        <label for="evolucion" class="lsinmargen colorprin">Evolución:</label>
        {!! Form::textarea('evolucion',$historia->evolucion,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-12">
        <label for="antecedentes" class="lsinmargen colorprin">Antecedentes de importancia:</label>
        {!! Form::textarea('antecedentes',$historia->antecedentes,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-12">
        <label for="exafisico" class="lsinmargen colorprin">Descripción exámen físico:</label>
        {!! Form::textarea('exafisico',$historia->exafisico,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    
    <div class="col-md-2">
        {!! Form::submit('Guardar', ['class'=>'btn btn-success']) !!}
    </div>
    <div class="col-md-10 text-right">
        <a class="btn btn-danger" href="{{ url('/admin/historia/'.$historia->id.'/delete') }}">Borrar Historia</a>
    </div>
</div>
{!! Form::close() !!}