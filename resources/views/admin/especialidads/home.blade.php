@extends('admin.master')
@section('title','Servicios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/web/especialidads/') }}"><i class="fas fa-hand-holding-medical"></i> Servicios</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-hand-holding-medical"></i> Servicios</h2>
						<ul>
							<li>
								<a class="btn btn-agregar mt-2" href="{{ url('/admin/web/especialidad/add') }}">
									Agregar registro
								</a>
                            </li>
						</ul>
					</div>
					<div class="inside">
						<table class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">Icono</th>
									<th width="60%">Nombre</th>
									<th width="10%">Activo</th>
									<th width="20%"></th>
								</tr>
							</thead>
							<tbody>
							@foreach($esp as $es)
							<tr>
								<td>{!! htmlspecialchars_decode($es->icono) !!}</td>
								<td>{{ $es->nombre }}</td>
								<td>{{ ($es->activo==1)?"Si":"No" }}</td>
								<td>
									<div class="opts">
										<a href="{{ url('/admin/web/especialidad/'.$es->id.'/up') }}"datatoggle="tooltip" data-placement="top" title="Subir"><i class="fas fa-arrow-alt-circle-up"></i></a>
										<a href="{{ url('/admin/web/especialidad/'.$es->id.'/down') }}"datatoggle="tooltip" data-placement="top" title="Bajar"><i class="fas fa-arrow-alt-circle-down"></i></a>

										<a href="{{ url('/admin/web/especialidad/'.$es->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>

										<a href="{{ url('/admin/web/especialidad/'.$es->id.'/del') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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