@extends('admin.master')
@section('title','Tipo medicamento')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/tipmeds/1') }}"><i class="fas fa-tablets"></i> Tipo medicamento</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
            <div class="col-md-3 text-center mbottom16">
				<a class='btn btn-convertir btn-block mb-2' href="{{ url('/admin/tipmeds/add') }}"><b><i class="fas fa-plus"></i> TIPO MEDICAMENTO</b></a>
                @foreach($tipmeds as $tipmed)
                @if($tipmed->id == $id)
                <a class='btn btn-primary btn-block' href="{{ url('/admin/tipmeds/'.$tipmed->id) }}">{{ $tipmed->nombre }}</a>
                @php($nombre = $tipmed->nombre)
                @else
                <a class='btn btn-outline-primary btn-block' href="{{ url('/admin/tipmeds/'.$tipmed->id) }}">{{ $tipmed->nombre }}</a>		
                @endif
                @endforeach
            </div>
			<div class="col-md-9">
				<div class="panel shadow">
					<div class="headercontent">
                    <h2 class="title">
						<i class="fas fa-tablets"></i> Tipo medicamento: <strong>{{ $nombre }}</strong>
						<span class="ml-2">
							<a href="{{ url('/admin/tipmed/'.$nombre.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
						</span>
						
					</h2>
						<ul>
                            @if(kvfj(Auth::user()->permissions,'tipmed_add'))
							<li>
								<a class="btn btn-agregar mt-2" href="{{ url('/admin/tipmed/add/'.$id) }}">
									Agregar Composición
								</a>
                            </li>
                            @endif
						</ul>
					</div>
					<div class="inside">
                        <table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="75%">Nombre</th>
									<th width="25%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Composicions as $Composicion)
								<tr>
									<td>{{ $Composicion->nombre }}</td>
									<td>
										<div class="opts">
                                            @if(kvfj(Auth::user()->permissions,'tipmed_add'))
											<a href="{{ url('/admin/tipmed/'.$Composicion->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(kvfj(Auth::user()->permissions,'tipmed_delete'))
                                            <a href="{{ url('/admin/tipmed/'.$Composicion->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                            @endif
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