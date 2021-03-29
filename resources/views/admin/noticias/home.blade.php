@extends('admin.master')
@section('title','Noticias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/web/noticias/') }}"><i class="far fa-newspaper"></i> Noticias</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="far fa-newspaper"></i> Noticias</h2>
						<ul>
							<li>
								<a class="btn btn-agregar mt-2" href="{{ url('/admin/web/noticia/add') }}">
									Agregar registro
								</a>
                            </li>
						</ul>
					</div>
					<div class="inside">
						<table class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="40%">Título</th>
									<th width="30%">Fecha</th>
									<th width="10%">Activo</th>
									<th width="20%"></th>
								</tr>
							</thead>
							<tbody>
							@foreach($not as $n)
							<tr @if($n->activo==2) class="table-danger"@endif>
								<td>{{ $n->titulo }}</td>
								<td>{{ $n->fecha }}</td>
								<td>{{ ($n->activo==1)?"Si":"No" }}</td>
								<td>
									<div class="opts">
										<a href="{{ url('/admin/web/noticia/'.$n->id.'/up') }}"datatoggle="tooltip" data-placement="top" title="Subir"><i class="fas fa-arrow-alt-circle-up"></i></a>
										<a href="{{ url('/admin/web/noticia/'.$n->id.'/down') }}"datatoggle="tooltip" data-placement="top" title="Bajar"><i class="fas fa-arrow-alt-circle-down"></i></a>

										<a href="{{ url('/admin/web/noticia/'.$n->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>

										<a href="{{ url('/admin/web/noticia/'.$n->id.'/del') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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