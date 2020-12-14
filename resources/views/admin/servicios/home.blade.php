@extends('admin.master')
@section('title','Servicios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/servicios') }}"><i class="fas fa-hand-holding-medical"></i> Servicios</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-hand-holding-medical"></i> Servicios</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'servicio_add'))
							<li>
								<a href="{{ url('/admin/servicio/add') }}">
									<i class="fas fa-plus"></i> Agregar registro
								</a>
                            </li>
                            @endif
						</ul>
					</div>
					<div class="inside">
						<table id= "serw" class="table table-hover table-sm">
							<thead>
								<tr>
                                    <th width="60%">Nombre</th>
									<th width="10%">Precio</th>
                                    <th width="10%">Clinica</th>
                                    <th width="10%">Especialista</th>
									<th width="10%"></th>
								</tr>
							</thead>
						</table>
					</div>				
				</div>
			</div>

		</div>		
	</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#serw').DataTable({
           "processing": true,
            "serverSide": true,
            "paging": true,
            "ordering": true,
            "info": true,
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
                    "</select> Registros"
            },
            "ajax": "{{ url('/admin/servicio/registro') }}",
            "columns": [
                {data: 'nombre'},
                {data: 'precio'},
                {data: 'clinica'},
                {data: 'especialista'},
				{data: 'btn'}
                ]
            });
        });
</script>
@endsection