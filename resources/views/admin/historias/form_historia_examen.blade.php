<div class="row mtop10">
    <div class="col-md-12">
        <table class="table table-hover table-sm table-bordered table">
            <thead class="thead-blue">
                <tr>
                    <th width="15%">Fecha</th>
                    <th width="20%">Tipo</th>
                    <th width="50%">Resultado</th>
                    <th width="5%">Examen</th>
                    <th width="10%"></th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($examen as $r)
                <tr>
                    <td>{{ $r->fecha }}</td>
                    <td>{{ $r->tipo }}</td>
                    <td>{{ $r->resultado }}</td>
                    <td class="text-center">
                        <div class="opts">
                            <a href="{{ url('/examenes/'.$r->ruta) }}" class="btn btn-outline-info" target="_blank" datatoggle="tooltip" data-placement="top" title="Visualizar documento">
                                <i class="fas fa-notes-medical"></i>
                            </a>
                            {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
                            {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="opts">
                            <a href="{{ url('/admin/historia/'.$r->id.'/examendelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                            {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{!! Form::open(['url'=>'/admin/historia/'.$paciente->id.'/examenadd', 'files' => true]) !!}
<div class="row mtop16">
    <div class="col-md-3">
        <label class="lsinmargen" for="fecha">Fecha:</label>
        {!! Form::date('fecha', null, ['class'=>'form-control','id'=>'fecha','autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-5">
        <label class="lsinmargen" for="tipo">Tipo:</label>
        {!! Form::text('tipo', null, ['class'=>'form-control','id'=>'tipo','autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-4">
        <label class="lsinmargen" for="imagen" class="mtop16">Examen:</label>
        <div class="custom-file">
            {!! Form::file('imagen', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'image/*, .pdf']) !!}
            <label class="custom-file-label" for="customFile" data-browse="Buscar">Elegir examen</label>
        </div>
    </div>
</div>
<div class="row mtop10">
    <div class="col-md-12">
        <label class="lsinmargen" for="resultado">Resultado:</label>
        {!! Form::textarea('resultado',null,['class'=>'form-control', 'rows'=>'3', 'id' => 'resultado']) !!}			
    </div>
</div>
<div class="row">
    
</div>
{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
{!! Form::close() !!}