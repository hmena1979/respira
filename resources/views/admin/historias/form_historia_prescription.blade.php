<div class="row mtop10">
    <div class="col-md-12">
        {{-- <a href="{{ url('admin/pdf/'.$historia->id.'/receta') }}" class="btn btn-outline-info" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir receta">
            <i class="fas fa-prescription"></i>H</a> --}}
        <a href="{{ url('admin/pdf/'.$historia->id.'/recetav') }}" class="btn btn-outline-info" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir receta">
            <i class="fas fa-prescription"></i></a>
    </div>
</a>
</div>
<div class="row mtop10">
    <div class="col-md-12">
        <table class="table table-hover table-sm table-bordered table">
            <thead class="thead-blue">
                <tr>
                    <th width="30%">Producto</th>
                    <th width="10%">Presentación</th>
                    <th width="10%">Cantidad</th>
                    <th width="30%">Posología</th>
                    <th width="10%">Tiempo</th>
                    <th width="10%">
                        {{-- <a href="{{ url('admin/pdf/'.$historia->id.'/receta') }}" class="opttable" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir receta"><i class="fas fa-prescription"></i>H </a> --}}
                        <a href="{{ url('admin/pdf/'.$historia->id.'/recetav') }}" class="opttable" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir receta"> <i class="fas fa-prescription"></i></a>
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($recetas as $r)
                <tr>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->um->nombre }}</td>
                    <td class="text-center">{{ round($r->cantidad,2) }}</td>
                    <td>
                        {{ $r->posologia.' '
                        .$r->pmed->nombre.' '
                        .$r->pfre->nombre }}<br>{{$r->recomendacion}}
                    </td>
                    <td>{{ $r->postie.' '.$r->ptie->nombre }}</td>
                    <td class="text-center">
                        <div class="opts">
                            <button type="button" class="btn" onclick="editItemReceta('{{ $r->id }}')" datatoggle="tooltip" data-placement="top" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                            {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="panel shadow" id ='agregaitem'>
    <div class="inside">
        {!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/prescriptionadd']) !!}
        <div class="row">
            {!! Form::text('receta_id', null, ['class'=>'form-control', 'autocomplete'=>'off','id'=>'receta_id','hidden']) !!}
            {!! Form::text('tipitem', 1, ['class'=>'form-control', 'autocomplete'=>'off','id'=>'tipitem','hidden']) !!}
            {!! Form::text('paciente_id', $historia->paciente_id, ['class'=>'form-control', 'autocomplete'=>'off','hidden']) !!}
            {!! Form::text('paciente_id', $historia->paciente_id, ['class'=>'form-control', 'autocomplete'=>'off','hidden']) !!}
            {!! Form::text('item', $historia->item, ['class'=>'form-control', 'autocomplete'=>'off','hidden']) !!}
            {!! Form::text('producto_id', '', ['class'=>'form-control', 'id'=>'producto_id', 'autocomplete'=>'off','hidden']) !!}

            <div class="col-md-6">
                <label class="lsinmargen" for="nombre">Producto:</label>
                <div class="input-group">
                    {!! Form::text('nombre', null, ['class'=>'form-control', 'id'=>'nombrep','autocomplete'=>'off']) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#buscarprod" onclick="limpia()"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="buscarprod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <input type="text" class='form-control' id= 'buscarp' placeholder = 'Ingrese productos' autocomplete="off" autofocus>
                            </div>
                            <div class="modal-body">
                                <div class="cuerpop">
                                    
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
            <div class="col-md-4">
                <label class="lsinmargen" for="umedida_id">Presentación:</label>
                {!! Form::select('umedida_id',$umedida,null,['class'=>'custom-select', 'id'=>'umedida_id', 'placeholder'=>'']) !!}	
            </div>
            <div class="col-md-2">
                <label class="lsinmargen" for="cantidad">Cantidad:</label>
                {!! Form::text('cantidad', null, ['class'=>'form-control', 'id'=>'cantidad','autocomplete'=>'off']) !!}	
            </div>
        </div>
        <div class="row mtop8f">
            <div class="col-md-7">
                <label class="lsinmargen" for="posologia">Posología:</label>
                <div class="input-group">
                    <div class="input-group-append">
                        {!! Form::text('posologia', null, ['class'=>'form-control tam30p','id'=>'posologia','autocomplete'=>'off']) !!}
                        {!! Form::select('posmed_id',$posmed,'0',['class'=>'custom-select','id'=>'posmed_id']) !!}
                        {!! Form::select('posfrec_id',$posfre,'0',['class'=>'custom-select','id'=>'posfrec_id']) !!}	
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <label class="lsinmargen" for="postie_id">Tiempo:</label>
                <div class="input-group">
                    <div class="input-group-append">
                        {!! Form::text('postie', null, ['class'=>'form-control tam30p','id'=>'postie','autocomplete'=>'off']) !!}
                        {!! Form::select('postie_id',$postie,'0',['class'=>'custom-select','id'=>'postie_id']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop8f">
            <div class="col-md-6">
                <label class="lsinmargen" for="recomendacion">Indicaciones:</label>
                {!! Form::text('recomendacion', null, ['class'=>'form-control','id'=>'recomendacion','autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-1">
                {!! Form::submit('+', ['class'=>'btn btn-success mtop25', 'title'=>"Agregar receta", 'id'=>'btnprescription']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="panel shadow mtop10 mbottom16">
    <div class="inside">
        {!! Form::open(['url'=>'/admin/historia/'.$historia->id.'/prescriptionfooter']) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="recomendaciones:">
                    <label for="recomendaciones" class="colorprin">Recomendaciones:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="rbt" id="rbt" value="true" @if(kvfj($historia->receta, 'rbt')) checked @endif>
                        <label class="form-check-label" for="rbt">Bebidas tibias.</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label mr-2" for="rotros">Otros:</label>
                        {!! Form::text('rotros', kvfj($historia->receta, 'rotros'), ['class'=>'form-control','autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="evitar">
                    <label for="evitar" class="colorprin">Evitar:</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="efrio" id="efrio" value="true" @if(kvfj($historia->receta, 'efrio')) checked @endif>
                    <label class="form-check-label" for="efrio">Frío.</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="epolvo" id="epolvo" value="true" @if(kvfj($historia->receta, 'epolvo')) checked @endif>
                    <label class="form-check-label" for="epolvo">Polvo.</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ehumo" id="ehumo" value="true" @if(kvfj($historia->receta, 'ehumo')) checked @endif>
                    <label class="form-check-label" for="ehumo">Humo.</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ecitricos" id="ecitricos" value="true" @if(kvfj($historia->receta, 'ecitricos')) checked @endif>
                    <label class="form-check-label" for="ecitricos">Cítricos.</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="eenvasados" id="eenvasados" value="true" @if(kvfj($historia->receta, 'eenvasados')) checked @endif>
                    <label class="form-check-label" for="eenvasados">Envasados.</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="eanimales" id="eanimales" value="true" @if(kvfj($historia->receta, 'eanimales')) checked @endif>
                    <label class="form-check-label" for="eanimales">Animales.</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ecolorantes" id="ecolorantes" value="true" @if(kvfj($historia->receta, 'ecolorantes')) checked @endif>
                    <label class="form-check-label" for="ecolorantes">Colorantes.</label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label mr-2" for="eotros">Otros:</label>
                    {!! Form::text('eotros', kvfj($historia->receta, 'eotros'), ['class'=>'form-control','autocomplete'=>'off']) !!}
                </div>
                <div class="form-check form-check-inline ml-2">
                    {!! Form::submit('Guardar', ['class'=>'btn btn-success ml-5']) !!}

                </div>
            </div>
            
        </div>
        {!! Form::close() !!}
    </div>
</div>

    

