@extends('admin.master')
@section('title','Terapias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/terapias') }}"><i class="fas fa-procedures"></i> Terapias</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-procedures"></i> Terapias</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'terapia_add'))
							<li>
								<a class="btn btn-agregar" href="{{ url('/admin/terapia/add') }}">
									Agregar Evaluación
								</a>
                            </li>
							@endif
						</ul>
					</div>
					<div class="inside">
                        
						<table id= "grid1" class="table table-hover table-sm table">
							<thead>
								<tr>
                                    <th width="35%">Paciente</th>
                                    <th width="10%">Fecha</th>
									<th width="11%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($terapias as $terapia)
								<tr>
                                    <td>{{ $terapia->pac->razsoc }}</td>
                                    <td>{{ $terapia->fechaeval }}</td>
									<td>
										<div class="opts">
											@if(kvfj(Auth::user()->permissions,'terapia_edit'))
											<a href="{{ url('/admin/terapia/'.$terapia->id.'/edit') }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endif
											{{-- @if(kvfj(Auth::user()->permissions,'factura_delete'))
											<a href="{{ url('/admin/factura/'.$factura->id.'/delete') }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
											@endif --}}
											{{-- <a href="{{ url('/admin/pdf/'.$terapia->id.'/farmfact') }}"
												target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir comprobante">
												<i class="fas fa-print"></i> 
											</a>								 --}}
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
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
		$('#grid1').DataTable({
                    "paging":   true,
					"ordering": true,
					"order" : [[0, 'desc'],[2, 'desc']],
                    "info":     true,
                    "language":{
                        "info": "_TOTAL_ Registros",
                        "search": "Buscar",
                        "paginate":{
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "lengthMenu": "Mostrar <select>"+
                                        "<option value='10'>10</option>"+
                                        "<option value='25'>25</option>"+
                                        "<option value='50'>50</option>"+
                                        "<option value='100'>100</option>"+
                                        "<option value='-1'>Todos</option>"+
                                        "</select> Registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "emptyTable": "No se encontraton coincidencias",
                        "zeroRecords": "No se encontraton coincidencias",
                        "infoEmpty": "",
                        "infoFiltered": ""
    
                    }
                });
	});
</script>
@endsection