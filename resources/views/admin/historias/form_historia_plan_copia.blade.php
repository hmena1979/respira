{!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/plan']) !!}
<div class="row mtop16">
    <div class="col-md-12">
        <label for="plantera" class="lsinmargen colorprin">Plan terapeutico:</label>
        {!! Form::textarea('plantera',$historia->plantera,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-6">
        <label for="radtorax" class="lsinmargen colorprin">Radiografía de torax:</label>
        {!! Form::textarea('radtorax',$historia->radtorax,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
    <div class="col-md-6">
        <label for="tomografia" class="lsinmargen colorprin">Tomografía:</label>
        {!! Form::textarea('tomografia',$historia->tomografia,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-6">
        <label for="espirometria" class="lsinmargen colorprin">Espirometría:</label>
        {!! Form::textarea('espirometria',$historia->espirometria,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
    <div class="col-md-6">
        <label for="anotaciones" class="lsinmargen colorprin">Anotaciones:</label>
        {!! Form::textarea('anotaciones',$historia->anotaciones,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
{!! Form::close() !!}