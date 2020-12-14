@extends('admin.master')
@section('title','Unidad de medida')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/umedidas') }}"><i class="fas fa-ruler-combined"></i> Unidad de medida</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-ruler-combined"></i> Unidad de medida</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'umedida_add'))
							<li>
								<a href="{{ url('/admin/umedida/add') }}">
									<i class="fas fa-plus"></i> Agregar registro
								</a>
                            </li>
                            @endif
                            
							{{--  
							<li>
								<a href="#" id='btn_search'>
									Buscar <i class="fas fa-search"></i>
								</a>
							</li>
							--}}
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
                                    <th width="60%">Nombre</th>
									<th width="10%">C.Anterior</th>
									<th width="10%">Sunat</th>
									<th width="20%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($umedidas as $umedida)
								<tr>
                                    <td>{{ $umedida->nombre }}</td>
									<td>{{ $umedida->codant }}</td>
									<td>{{ $umedida->sunat }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'umedida_edit'))
											<a href="{{ url('/admin/umedida/'.$umedida->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											@if(kvfj(Auth::user()->permissions,'umedida_delete'))
											<a href="{{ url('/admin/umedida/'.$umedida->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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