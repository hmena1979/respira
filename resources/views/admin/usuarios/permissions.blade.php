@extends('admin.master')
@section('title','Usuarios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
    </li>
    <li class="breadcrumb-item">
    <a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-cogs"></i> Permisos de  Usuario: {{ $user->nombre.' '.$user->apellido }}</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
        <div class="page_user">
            <form action="{{ url('/admin/usuario/'.$user->id.'/permissions') }}" method="POST">
                @csrf
                <div class="row">
                        @include('admin.usuarios.permissions.module_inicio')
                        @include('admin.usuarios.permissions.module_pacientes')
                        @include('admin.usuarios.permissions.module_doctores')                        
                    </div>
                    <div class="row mtop16">
                        @include('admin.usuarios.permissions.module_categorias')
                        @include('admin.usuarios.permissions.module_usuarios')
                        @include('admin.usuarios.permissions.module_cie10')
                    </div>
                    <div class="row mtop16">
                        @include('admin.usuarios.permissions.module_productos')
                        @include('admin.usuarios.permissions.module_umedidas')
                        @include('admin.usuarios.permissions.module_tipmeds')
                    </div>
                    <div class="row mtop16">
                        @include('admin.usuarios.permissions.module_historias')
                        @include('admin.usuarios.permissions.module_modrecetas')
                    </div>
                    <div class="row mtop16">
                        @include('admin.usuarios.permissions.module_servicios')
                        @include('admin.usuarios.permissions.module_proveedores')
                        @include('admin.usuarios.permissions.module_comprobantes')
                    </div>
                    <div class="row mtop16">
                        @include('admin.usuarios.permissions.module_facturas')
                        @include('admin.usuarios.permissions.module_ingresos')
                        @include('admin.usuarios.permissions.module_salidas')
                    </div>
                    <div class="row mtop16">
                        @include('admin.usuarios.permissions.module_notadms')
                        @include('admin.usuarios.permissions.module_notfars')
                        {{-- @include('admin.usuarios.permissions.module_salidas') --}}
                    </div>
                    <div class="row mtop16">
                        <div class="col-md-12">
                            <div class="panel shadow">
                                <div class="inside">
                                    <input type="submit" value="Guardar" class="btn btn-primary">
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
        </div>

		
	</div>
@endsection