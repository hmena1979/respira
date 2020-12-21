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
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-prescription"></i> Modelo de Recetas</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'modreceta_add'))
							<li>
								<a href="{{ url('/admin/modreceta/add') }}">
									<i class="fas fa-plus"></i> Agregar registro
								</a>
                            </li>
                            {{--
							<li>
								<a href="#">Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/doctores/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/doctores/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/doctores/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
                            </li>
                            --}}
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
						<div class="form_search" id="form_search">
							{!! Form::open(['url'=>'/admin/doctores/search']) !!}
							<div class="row">
								<div class="col-md-4">
									{!! Form::text('search', null, ['class'=>'form-control', 'placeholder'=>'Buscar']) !!}
								</div>
								<div class="col-md-3">
									{!! Form::select('filter', ['0'=>'Nombre'], '0',['class'=>'form-control']) !!}
								</div>
								<div class="col-md-3">
									{!! Form::select('estado', [1=>'Activo', 2=>'No activo'], 1,['class'=>'form-control']) !!}
								</div>
								<div class="col-md-2">
									{!! Form::submit('Buscar', ['class'=>'btn btn-success']) !!}
								</div>
							</div>
							
							{!! Form::close() !!}
						</div>
						<table id= "grid" class="table table-hover table-sm table">
							<thead>
								<tr>
									<th width="80%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($modrecetas as $modreceta)
								<tr>
									<td>{{ $modreceta->nombre }}@if($modreceta->activo==2) <i class="fas fa-eye-slash"></i>@endif</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'modreceta_edit'))
											<a href="{{ url('/admin/modreceta/'.$modreceta->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											@if(kvfj(Auth::user()->permissions,'modreceta_delete'))
											<a href="{{ url('/admin/modreceta/'.$modreceta->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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