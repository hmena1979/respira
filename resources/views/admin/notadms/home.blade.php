@extends('admin.master')
@section('title','Notas de Débito/Crédito')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/notadms/'.$periodo) }}"><i class="fas fa-window-restore"></i> Notas de Débito/Crédito</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Notas de Débito/Crédito</h2>
						<ul>
                            <li>
                                <div class="cita">
                                    {!! Form::open(['url'=>'admin/notadm/cambio']) !!}
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
							@if(kvfj(Auth::user()->permissions,'notadm_add'))
							<li>
								<a class="btn btn-agregar" href="{{ url('/admin/notadm/add') }}">
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
								@foreach($notas as $nota)
								<tr>
                                    <td>{{ $nota->fecha }}</td>
                                    <td>{{ $nota->comprobante_id }}</td>
                                    <td>{{ $nota->serie.'-'.$nota->numero}}</td>
                                    <td>{{ $nota->cli->razsoc }}</td>
									<td>{{ $nota->total }}</td>
									<td>{{ $nota->sta->nombre }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'notadm_edit'))
											<a href="{{ url('/admin/notadm/'.$nota->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											{{-- @if(kvfj(Auth::user()->permissions,'factura_delete'))
											<a href="{{ url('/admin/factura/'.$factura->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
											@endif --}}
											<a href="{{ url('/admin/pdf/'.$nota->id.'/admnota') }}"
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