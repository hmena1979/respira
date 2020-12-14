@extends('admin.master')
@section('title','Productos')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/productos') }}"><i class="fab fa-product-hunt"></i> Productos</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">	
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fab fa-product-hunt"></i> Productos</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'producto_add'))
							<li>
								<a href="{{ url('/admin/producto/add') }}">
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
                        <table id="grid" class="table table-hover table-sm table">
                            <thead>
                                <tr>
									<th width="45%">Nombre</th>
									<th width="20%">U.Medida</th>
									<th width="10%">Stock</th>
									<th width="10%">Precio</th>
									<th width="10%"></th>
                                </tr>
							</thead>
							<tbody>
								@foreach($productos as $producto)
								<tr>
									<td>{{ $producto->nombre }}</td>
									<td>{{ $producto->umedida->nombre }}</td>
									<td>{{ $producto->stock }}</td>
									<td>{{ $producto->premerca }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'producto_edit'))
											<a href="{{ url('/admin/producto/'.$producto->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											@if(kvfj(Auth::user()->permissions,'producto_delete'))
											<a href="{{ url('/admin/producto/'.$producto->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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

@section('script')
@endsection