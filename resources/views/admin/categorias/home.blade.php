@extends('admin.master')
@section('title','Categorias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/categorias/0') }}"><i class="fas fa-folder-open"></i> Categorias</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
            <div class="col-md-2 text-center mbottom16">
                @foreach(getModulosArray() as $m => $k)
                @if($m == $module)
                <a class='btn btn-primary btn-block' href="{{ url('/admin/categorias/'.$m) }}">{{ $k }}</a>
                @php($nombremodulo = $k)
                @else
                <a class='btn btn-outline-primary btn-block' href="{{ url('/admin/categorias/'.$m) }}">{{ $k }}</a>		
                @endif
                @endforeach
            </div>
			<div class="col-md-10">
				<div class="panel shadow">
					<div class="headercontent">
                    <h2 class="title"><i class="fas fa-folder-open"></i> Categorias: <strong>{{ $nombremodulo }}</strong></h2>
						<ul>
                            @if(kvfj(Auth::user()->permissions,'categoria_add'))
							<li>
								<a href="{{ url('/admin/categoria/add/'.$module) }}">
									<i class="fas fa-plus"></i> Agregar registro
								</a>
                            </li>
                            @endif
							{{--<li>
								<a href="#">Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/usuarios/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
							</li>--}}
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
                        
                        @if($titulo === '0')
                        <table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="75%">Nombre</th>
									<th width="25%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cats as $cat)
								<tr>
									<td>{{ $cat->nombre }}</td>
									<td>
										<div class="opts">
                                            @if(kvfj(Auth::user()->permissions,'categoria_add'))
											<a href="{{ url('/admin/categoria/'.$cat->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(kvfj(Auth::user()->permissions,'categoria_delete'))
                                            <a href="{{ url('/admin/categoria/'.$cat->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                            @endif
										</div>
									</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="20%">{{ $titulo }}</th>
									<th width="55%">Nombre</th>
									<th width="25%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cats as $cat)
								<tr>
                                    <td>{{ $cat->codigo }}</td>
									<td>{{ $cat->nombre }}</td>
									<td>
										<div class="opts">
                                            @if(kvfj(Auth::user()->permissions,'categoria_add'))
											<a href="{{ url('/admin/categoria/'.$cat->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(kvfj(Auth::user()->permissions,'categoria_delete'))
                                            <a href="{{ url('/admin/categoria/'.$cat->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
                                            @endif
										</div>
									</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
					</div>				
				</div>
			</div>

		</div>		
	</div>

@endsection