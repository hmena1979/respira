{!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/plan']) !!}
<div class="row mtop16">
    <div class="col-md-12">
        <label for="plantera" class="lsinmargen colorprin">PLAN TERAPEUTICO:</label>
        {!! Form::textarea('plantera',$historia->plantera,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
<div class="row mtop16">
    <div class="col-md-7 borde-derecho">
        <div class="row">
            <div class="col-md-6 borde-derecho">
                <div class="radio">
                    <label for="radiografia" class="colorprin">RADIOGRAFIAS DIGITALES:</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="senpar" id="senpar" value="true" @if(kvfj($historia->radtorax, 'senpar')) checked @endif>
                    <label class="form-check-label" for="senpar">SENOS PARANASALES</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="cavum" id="cavum" value="true" @if(kvfj($historia->radtorax, 'cavum')) checked @endif>
                    <label class="form-check-label" for="cavum">CAVUM</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="torax" id="torax" value="true" @if(kvfj($historia->radtorax, 'torax')) checked @endif>
                    <label class="form-check-label" for="torax">TORAX</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="parrcostal" id="parrcostal" value="true" @if(kvfj($historia->radtorax, 'parrcostal')) checked @endif>
                    <label class="form-check-label" for="parrcostal">PARRILLA COSTAL</label>
                </div>
                <div class="radio">
                    <label class="lsinmargen" for="radiografia" class="colorprin">PARA CADA CASO MARCAR</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="1incidencia" id="1incidencia" value="true" @if(kvfj($historia->radtorax, '1incidencia')) checked @endif>
                    <label class="form-check-label" for="1incidencia">A) Una incidencia</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="frontal" id="frontal" value="true" @if(kvfj($historia->radtorax, 'frontal')) checked @endif>
                    <label class="form-check-label" for="frontal">Frontal</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="lateral" id="lateral" value="true" @if(kvfj($historia->radtorax, 'lateral')) checked @endif>
                    <label class="form-check-label" for="lateral">Lateral.</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="2incidencia" id="2incidencia" value="true" @if(kvfj($historia->radtorax, '2incidencia')) checked @endif>
                    <label class="form-check-label" for="2incidencia">B) Dos incidencias</label>
                </div>
                <div class="form-check form-check">
                    <label class="form-check-label mr-2" for="otpradio">Otro tipo de radiografía:</label>
                    {!! Form::text('otpradio', kvfj($historia->radtorax, 'otpradio'), ['class'=>'form-control','autocomplete'=>'off']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="radio">
                    <label for="antecedentes" class="colorprin">TOMOGRAFIAS:</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ccontraste" id="ccontraste" value="true" @if(kvfj($historia->tomografia, 'ccontraste')) checked @endif>
                    <label class="form-check-label" for="ccontraste">Con Contraste</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="scontraste" id="scontraste" value="true" @if(kvfj($historia->tomografia, 'scontraste')) checked @endif>
                    <label class="form-check-label" for="scontraste">Sin Contraste</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="sparanasal" id="sparanasal" value="true" @if(kvfj($historia->tomografia, 'sparanasal')) checked @endif>
                    <label class="form-check-label" for="sparanasal">SENOS PARANASALES</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="cuello" id="cuello" value="true" @if(kvfj($historia->tomografia, 'cuello')) checked @endif>
                    <label class="form-check-label" for="cuello">CUELLO</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="ttorax" id="ttorax" value="true" @if(kvfj($historia->tomografia, 'ttorax')) checked @endif>
                    <label class="form-check-label" for="ttorax">TORAX</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="tpm" id="tpm" value="true" @if(kvfj($historia->tomografia, 'tpm')) checked @endif>
                    <label class="form-check-label" for="tpm">Torax o Pulmones y mediastino</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="tar" id="tar" value="true" @if(kvfj($historia->tomografia, 'tar')) checked @endif>
                    <label class="form-check-label" for="tar">Torax alta resolución</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="ptpc" id="ptpc" value="true" @if(kvfj($historia->tomografia, 'ptpc')) checked @endif>
                    <label class="form-check-label" for="ptpc">Pared Toráxica (Parrilla Costal)</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="vas3d" id="vas3d" value="true" @if(kvfj($historia->tomografia, 'vas3d')) checked @endif>
                    <label class="form-check-label" for="vas3d">Vías Aereas Superiores(3D)</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="angiotem" id="angiotem" value="true" @if(kvfj($historia->tomografia, 'angiotem')) checked @endif>
                    <label class="form-check-label" for="angiotem">ANGIOTEM</label>
                </div>
                <div class="form-check form-check">
                    <input class="form-check-input" type="checkbox" name="toraxico" id="toraxico" value="true" @if(kvfj($historia->tomografia, 'toraxico')) checked @endif>
                    <label class="form-check-label" for="toraxico">Toráxico</label>
                </div>
                <div class="form-check form-check">
                    <label class="form-check-label mr-2" for="otptomografia">Otro tipo de Tomografía:</label>
                    {!! Form::text('otptomografia', kvfj($historia->tomografia, 'otptomografia'), ['class'=>'form-control','autocomplete'=>'off']) !!}
                </div>
            </div>
        </div>
        <div class="row mtop8f">
            <div class="col-md-3">
                <div class="form-check form-check mtop8f">
                    <input class="form-check-input" type="checkbox" name="ecografia" id="ecografia" value="true" @if(kvfj($historia->radtorax, 'ecografia')) checked @endif>
                    <label class="form-check-label colorprin" for="ecografia">ECOGRAFÍA:</label>
                </div>
            </div>
            <div class="col-md-9">
                {!! Form::text('ecotex', kvfj($historia->radtorax, 'ecotex'), ['class'=>'form-control','autocomplete'=>'off','id'=>'ecotex']) !!}
            </div>
        </div>
        <div class="row mtop8f">
            <div class="col-md-6">
                <label for="dpresuntivo" class="lsinmargen">Diagnóstico Presuntivo:</label>
                {!! Form::text('dpresuntivo', kvfj($historia->radtorax, 'dpresuntivo'), ['class'=>'form-control','autocomplete'=>'off','id'=>'dpresuntivo']) !!}
            </div>
            <div class="col-md-6">
                <label for="dclinico" class="lsinmargen">Datos Clínicos:</label>
                {!! Form::text('dclinico', kvfj($historia->radtorax, 'dclinico'), ['class'=>'form-control','autocomplete'=>'off','id'=>'dclinico']) !!}		
            </div>
        </div>

    </div>
    
    <div class="col-md-5">
        <div class="radio">
            <label for="antecedentes" class="colorprin">PRUEBAS DE FUNCIÓN RESPIRATORIA:</label>
        </div>
        <div class="form-check form-check">
            <input class="form-check-input" type="checkbox" name="esimple" id="esimple" value="true" @if(kvfj($historia->espirometria, 'esimple')) checked @endif>
            <label class="form-check-label" for="esimple">ESPIROMETRÍA SIMPLE</label>
        </div>
        <div class="form-check form-check">
            <input class="form-check-input" type="checkbox" name="emb" id="emb" value="true" @if(kvfj($historia->espirometria, 'emb')) checked @endif>
            <label class="form-check-label" for="emb">ESPIROMETRÍA MAS BRONCODILATACIÓN</label>
        </div>
        <div class="form-check form-check">
            <input class="form-check-input" type="checkbox" name="tc" id="tc" value="true" @if(kvfj($historia->espirometria, 'tc')) checked @endif>
            <label class="form-check-label" for="tc">TEST DE CAMINATA</label>
        </div>
        <div class="form-check form-check">
            <input class="form-check-input" type="checkbox" name="on" id="on" value="true" @if(kvfj($historia->espirometria, 'on')) checked @endif>
            <label class="form-check-label" for="on">OXIMETRIA NOCTURNA</label>
        </div>
        <div class="form-check form-check">
            <input class="form-check-input" type="checkbox" name="pmd" id="pmd" value="true" @if(kvfj($historia->espirometria, 'pmd')) checked @endif>
            <label class="form-check-label" for="pmd">PLETISMOGRAFÍA + DLCO</label>
        </div>
        <div class="form-check form-check">
            <input class="form-check-input" type="checkbox" name="flujo" id="flujo" value="true" @if(kvfj($historia->espirometria, 'flujo')) checked @endif>
            <label class="form-check-label" for="flujo">FLUJOMETRÍA</label>
        </div>
        <div class="form-check form-check">
            <label class="form-check-label mr-2" for="opruebas">Otras Pruebas:</label>
            {!! Form::text('opruebas', kvfj($historia->espirometria, 'opruebas'), ['class'=>'form-control','autocomplete'=>'off']) !!}
        </div>
    </div>
</div>

<div class="row mtop16">
    <div class="col-md-12">
        <label for="anotaciones" class="lsinmargen colorprin">ANOTACIONES:</label>
        {!! Form::textarea('anotaciones',$historia->anotaciones,['class'=>'form-control', 'rows'=>'3']) !!}			
    </div>
</div>
{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
{!! Form::close() !!}