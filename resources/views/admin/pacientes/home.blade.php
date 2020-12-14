@extends('admin.master')
@section('title','Pacientes')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/pacientes') }}"><i class="fas fa-user-circle"></i> Pacientes</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-user-circle"></i> Pacientes</h2>
						<ul>
							@if(kvfj(Auth::user()->permissions,'paciente_add'))
							<li>
								<a href="{{ url('/admin/paciente/add') }}">
									<i class="fas fa-plus"></i> Agregar registro
								</a>
							</li>							
							{{-- <li>
								<a href="#">Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/usuarios/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
							</li> --}}
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
							{!! Form::open(['url'=>'/admin/paciente/search']) !!}
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
						<table id= "pacw" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">Historia</th>
									<th width="10%">N° Doc</th>
									<th width="50%">Nombre</th>
									<th width="10%">Teléfono</th>
									<th width="20%"></th>
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
        $('#pacw').DataTable({
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
            "ajax": "{{ url('/admin/paciente/registro') }}",
            "columns": [
                {data: 'historia'},
                {data: 'numdoc'},
                {data: 'razsoc'},
                {data: 'telefono'},
				{data: 'btn'}
                ]
            });
        });
</script>
@endsection