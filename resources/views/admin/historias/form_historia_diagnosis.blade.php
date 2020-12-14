<div class="row mtop16">
    <div class="col-md-12">
        <table class="table table-hover table-sm table-bordered table">
            <thead class="thead-blue">
                <tr>
                    <th width="10%">CIE 10</th>
                    <th width="50%">Diagnóstico</th>
                    <th width="15%">Tipo</th>
                    <th width="15%">Visita</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($diagnosticos as $d)
                <tr>
                    <td>{{ $d->cie10_id }}</td>
                    <td>{{ $d->cie->nombre }}</td>
                    <td>{{ $d->tip->nombre }}</td>
                    <td>{{ $d->vis->nombre }}</td>
                    <td>
                        <div class="opts">
                            <a href="{{ url('/admin/historia/'.$d->id.'/diagnosisdelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>										
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="panel shadow">
    <div class="inside">
        {!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/diagnosisadd']) !!}
        <div class="row mtop16">
            {!! Form::text('paciente_id', $historia->paciente_id, ['class'=>'form-control', 'autocomplete'=>'off','hidden']) !!}
            {!! Form::text('item', $historia->item, ['class'=>'form-control', 'autocomplete'=>'off','hidden']) !!}

            <div class="col-md-2">
                <label for="cie10_id">CIE 10:</label>
                {!! Form::text('cie10_id', null, ['class'=>'form-control', 'id'=>'cie10_id','autocomplete'=>'off']) !!}
            </div>

            <div class="col-md-5">
                <label for="dcie10">Diagnóstico:</label>
                <div class="input-group">
                    {!! Form::select('dcie10',$cie10s,'',['class'=>'custom-select', 'id'=>'dcie10', 'placeholder'=>'']) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon21" data-toggle="modal" data-target="#buscarModal" onclick="limpia()"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="buscarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <input type="text" class='form-control' id= 'buscarm' placeholder = 'Diagnóstico CIE 10' autofocus>
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
                <label for="tipo_id">Tipo:</label>
                {!! Form::select('tipo_id',$tipod,null,['class'=>'custom-select', 'placeholder'=>'']) !!}	
            </div>
            <div class="col-md-2">
                <label for="visita_id">Visita:</label>
                {!! Form::select('visita_id',$visitad,null,['class'=>'custom-select', 'placeholder'=>'']) !!}	
            </div>
            <div class="col-md-1">
                {!! Form::submit('+', ['class'=>'btn btn-success mtop30', 'title'=>"Agregar diagnóstico"]) !!}

            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>

