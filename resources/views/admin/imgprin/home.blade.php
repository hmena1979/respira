@extends('admin.master')
@section('title','Imagen Principal')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/imgprin/') }}"><i class="fas fa-images"></i> Imagen principal</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-images"></i> Imagen principal</h2>
						<ul>
							<li>
								<a class="btn btn-agregar mt-2" href="{{ url('/admin/web/imgprin/add') }}">
									Agregar registro
								</a>
                            </li>
						</ul>
					</div>
					<div class="inside">
						<table class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="70%">Imagen</th>
									<th width="10%">Activo</th>
									<th width="20%"></th>
								</tr>
							</thead>
							<tbody>
							@foreach($im as $i)
							<tr>
								<td>
									<img src="{{ url('web/'.$i->imagen) }}" class = "w-100" alt="">
								</td>
								<td>{{ ($i->activo==1)?"Si":"No" }}</td>
								<td>
									<div class="opts">
										<a href="{{ url('/admin/web/imgprin/'.$i->id.'/up') }}"datatoggle="tooltip" data-placement="top" title="Subir"><i class="fas fa-arrow-alt-circle-up"></i></a>
										<a href="{{ url('/admin/web/imgprin/'.$i->id.'/down') }}"datatoggle="tooltip" data-placement="top" title="Bajar"><i class="fas fa-arrow-alt-circle-down"></i></a>

										<a href="{{ url('/admin/web/imgprin/'.$i->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
										<a href="{{ url('/admin/web/imgprin/'.$i->id.'/del') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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