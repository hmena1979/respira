{!! Form::open(['url'=>'/admin/historia/'.$paciente->id.'/new']) !!}
<div class="row mtop16">
    <div class="col-md-6">
        <label for="doctor_id" class="lsinmargen colorprin">Doctor:</label>
        {!! Form::select('doctor_id',$doctor,Auth::user()->doctor_id,['class'=>'custom-select', 'placeholder'=>'Sin asignar']) !!}	
    </div>
    <div class="col-md-3">
        <label for="fecha" class="lsinmargen colorprin">Fecha:</label>
        {!! Form::date('fecha', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-3">
        <label for="hora" class="lsinmargen colorprin">Hora cita:</label>
        {!! Form::time('hora', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off']) !!}
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
                {!! Form::text('peso', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-4">
                <label for="talla" class="lsinmargen">Talla(cm):</label>
                {!! Form::text('talla', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-4">
                <label for="temp" class="lsinmargen">T°(°C):</label>
                {!! Form::text('temp', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-3">
                <label for="fc" class="lsinmargen">FC(x'):</label>
                {!! Form::text('fc', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-3">
                <label for="fr" class="lsinmargen">FR(x'):</label>
                {!! Form::text('fr', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-3">
                <label for="sato2" class="lsinmargen">SpO2:</label>
                {!! Form::text('sato2', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-3">
                <label for="pa" class="lsinmargen">PA(mmHg):</label>
                {!! Form::text('pa', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
            </div>
        </div>
    </div>  
</div>
<div class="row mtop16">
    <div class="col-md-12">
        <label for="anammesis" class="lsinmargen colorprin">Relato:</label>
        {!! Form::textarea('anammesis','',['class'=>'form-control', 'rows'=>'4']) !!}			
    </div>
</div>
<div class="row mtop16 oculto">
    <div class="col-md-12">
        <label for="evolucion" class="lsinmargen colorprin">Evolución:</label>
        {!! Form::textarea('evolucion','',['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-12">
        <label for="antecedentes" class="lsinmargen colorprin">Antecedentes de importancia:</label>
        {!! Form::textarea('antecedentes','',['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-12">
        <label for="exafisico" class="lsinmargen colorprin">Descripción exámen físico:</label>
        {!! Form::textarea('exafisico','',['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
{!! Form::close() !!}