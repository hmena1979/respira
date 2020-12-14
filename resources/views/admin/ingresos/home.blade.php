@extends('admin.master')
@section('title','Compras')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/ingresos/'.$periodo) }}"><i class="fas fa-cart-plus"></i> Compras</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-cart-plus"></i> Compras</h2>
						<ul>
                            <li>
                                <div class="cita">
                                    {!! Form::open(['url'=>'admin/ingreso/cambio']) !!}
                                    <div class="input-group">
                                        {!! Form::select('mes',getMeses(),substr($periodo,0,2),['class'=>'custom-select']) !!}
                                        {!! Form::text('año', substr($periodo,2,4), ['class'=>'form-control tamvar','autocomplete'=>'off']) !!}
                                        <div class="input-group-append">
                                            {!! Form::submit('Mostar', ['class'=>'btn btn-success']) !!}
                                        </div>
                                        
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </li>
							@if(kvfj(Auth::user()->permissions,'ingreso_add'))
							<li>
								<a class="btn btn-agregar" href="{{ url('/admin/ingreso/add') }}">
									Agregar registro
								</a>
                            </li>
							@endif
						</ul>
					</div>
					<div class="inside">
                        
						<table id= "grid" class="table table-hover table-sm table">
							<thead>
								<tr>
                                    <th width="10%">Fecha</th>
                                    <th width="5%">Tipo</th>
                                    <th width="15%">Número</th>
									<th width="40%">Proveedor</th>
									<th width="10%">Total</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($ingresos as $ingreso)
								<tr>
                                    <td>{{ $ingreso->fecha }}</td>
                                    <td>{{ $ingreso->comprobante_id }}</td>
                                    <td>{{ $ingreso->serie.'-'.$ingreso->numero}}</td>
                                    <td>{{ $ingreso->prov->razsoc }}</td>
									<td>{{ $ingreso->total }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'ingreso_edit'))
											<a href="{{ url('/admin/ingreso/'.$ingreso->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											@if(kvfj(Auth::user()->permissions,'ingreso_delete'))
											<a href="{{ url('/admin/ingreso/'.$ingreso->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
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