@extends('admin.master')
@section('title','Modelo de Receta')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/modrecetas') }}"><i class="fas fa-prescription"></i> Modelo de Recetas</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                <div class="panel shadow">
					<div class="inside">
                        {!! Form::open(['url'=>'/admin/modreceta/'.$modreceta->id.'/edit']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <label class="lsinmargen" for="nombre">Nombre:</label>
                                {!! Form::text('nombre', $modreceta->nombre, ['class'=>'form-control','id'=>'nombre','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
								<label class="lsinmargen" for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],$modreceta->activo,['class'=>'custom-select']) !!}	
							</div>
                            <div class="col-md-5 text-right">
                                {!! Form::submit('Guardar', ['class'=>'btn btn-success mtop20', 'id'=>'guardar']) !!}
                                <a class="btn thead-blue mtop20" href="{{ url('/admin/modreceta/'.$modreceta->id.'/deta') }}"
                                    datatoggle="tooltip" data-placement="top" title="Agregar">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>

                        </div>
						{!! Form::close() !!}
					</div>				
				</div>
			</div>

        </div>
        <div class="row mtop10">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        <table class="table table-hover table-sm table-bordered table">
                            <thead class="thead-blue">
                                <tr>
                                    <th width="20%">Producto</th>
                                    <th width="15%">Composicion</th>
                                    <th width="10%">Presentación</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="25%">Posología</th>
                                    <th width="10%">Tiempo</th>
                                    <th width="10%">
                                        {{-- <a href="{{ url('admin/pdf/'.$historia->id.'/receta') }}" class="opttable" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir receta"><i class="fas fa-prescription"></i>H </a> --}}
                                        {{-- <a href="{{ url('admin/pdf/'.$historia->id.'/recetav') }}" class="opttable" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir receta"> <i class="fas fa-prescription"></i></a> --}}
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detmodrecetas as $r)
                                <tr>
                                    <td>{{ $r->nombre }}</td>
                                    <td>{{ $r->composicion }}</td>
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
                                            {{-- <button type="button" class="btn" onclick="editItemReceta('{{ $r->id }}')" datatoggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button> --}}
                                            <a href="{{ url('/admin/modreceta/'.$r->id.'/dete') }}"datatoggle="tooltip" data-placement="top" title="Editar" ><i class="fas fa-edit"></i></a>
                                            <a href="{{ url('/admin/modreceta/'.$r->id.'/detdelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                            {{-- <a href="{{ url('/admin/historia/'.$r->id.'/prescriptiondelete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a> --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
@section('script')
<script>
    var url_global='{{url("/")}}';
</script>
@endsection