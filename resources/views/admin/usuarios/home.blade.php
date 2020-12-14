@extends('admin.master')
@section('title','Usuarios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-user-friends"></i> Usuarios</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'usuario_add'))
							<li>
								<a href="{{ url('/admin/usuario/add') }}">
									<i class="fas fa-plus"></i> Agregar registro
								</a>
							</li>							
							<li>
								<a href="#">Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/usuarios/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
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
						<div class="form_search" id="form_search">
							{!! Form::open(['url'=>'/admin/usuario/search']) !!}
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
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="25%">Nombre</th>
									<th width="25%">e-mail</th>
									<th width="30%">Activo</th>
									<th width="20%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->nombre.' '.$user->apellido }}@if($user->activo==2) <i class="fas fa-eye-slash"></i>@endif</td>
									<td>{{ $user->email }}</td>
									<td>{{ ($user->activo==1)?"Si":"No" }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'usuario_edit'))
											<a href="{{ url('/admin/usuario/'.$user->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											@if(kvfj(Auth::user()->permissions,'usuario_password'))
											<a href="{{ url('/admin/usuario/'.$user->id.'/password') }}"datatoggle="tooltip" data-placement="top" title="Cambiar password"><i class="fas fa-unlock-alt"></i></a>
											@endif
											@if(kvfj(Auth::user()->permissions,'usuario_permissions'))
											<a href="{{ url('/admin/usuario/'.$user->id.'/permissions') }}"datatoggle="tooltip" data-placement="top" title="Permisos de usuario"><i class="fas fa-cogs"></i></a>
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