@extends('admin.master')
@section('title','Vencimientos')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/producto/vencimiento') }}"><i class="fab fa-product-hunt"></i> Vencimientos</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">	
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fab fa-product-hunt"></i> Vencimientos</h2>
						<ul>
							
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
									<th width="20%">Lote</th>
									<th width="10%">Vencimiento</th>
									<th width="10%">Saldo</th>
									<th width="10%"></th>
                                </tr>
							</thead>
							<tbody>
								@foreach($vencimientos as $v)
								<tr>
									<td>{{ $v->nombre }}</td>
									<td>{{ $v->lote }}</td>
									<td>{{ $v->vencimiento }}</td>
									<td>{{ $v->saldo }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'producto_edit'))
											<a href="{{ url('/admin/producto/'.$v->id.'/vencimientoedit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
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