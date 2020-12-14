@extends('admin.master')
@section('title','Venta / Consumo')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/salidas/'.$periodo) }}"><i class="fas fa-cart-arrow-down"></i> Venta / Consumo</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-cart-arrow-down"></i> Venta / Consumo</h2>
						<ul>
                            <li>
                                <div class="cita">
                                    {!! Form::open(['url'=>'admin/salida/cambio']) !!}
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
							@if(kvfj(Auth::user()->permissions,'salida_add'))
							<li>
								<a class="btn btn-agregar" href="{{ url('/admin/salida/add') }}">
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
                                    <th width="12%">Número</th>
									<th width="35%">Cliente</th>
									<th width="10%">Total</th>
									<th width="10%">Estado</th>
									<th width="11%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($salidas as $salida)
								<tr class="@if($salida->anulado==1)rojo @endif">
                                    <td>{{ $salida->fecha }}</td>
                                    <td>{{ $salida->comprobante_id }}</td>
                                    <td>{{ $salida->serie.'-'.$salida->numero}}</td>
                                    <td>{{ $salida->cli->razsoc }}</td>
									<td>{{ $salida->total }}</td>
									<td>{{ $salida->sta->nombre }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'salida_edit'))
											<a href="{{ url('/admin/salida/'.$salida->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											{{-- @if(kvfj(Auth::user()->permissions,'factura_delete'))
											<a href="{{ url('/admin/factura/'.$factura->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
											@endif --}}
											<a href="{{ url('/admin/pdf/'.$salida->id.'/farmfact') }}"
												target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir comprobante">
												<i class="fas fa-print"></i> 
											</a>								
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