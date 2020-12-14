@extends('admin.master')
@section('title','Importar - Carga inicial')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/umedidas') }}"><i class="fas fa-file-download"></i> Importar - Carga inicial</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-download"></i> Importar - Carga inicial</h2>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar categorías</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/categoria', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Categorias.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar CIE 10</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/cie10', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo CIE10.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-6">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar tipo medicamento</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/tipmed', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo TipMedica.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar composición</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/composicion', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Composicion.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-6 mbottom16">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar unidad de medida</h2>
                                    </div>
                                    <div class="inside">
                                        <a href="{{ url('/admin/import/umedida') }}">
                                            <i class="fas fa-plus"></i> Importar registros
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Productos</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/producto', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Productos.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Laboratorios</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/laboratorio', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Laboratorios.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Doctores</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/doctor', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Doctor.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-6">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Pacientes</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/paciente', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Pacientes.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Proveedores</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/proveedor', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Proveedores.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Servicios</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/servicio', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Servicios.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Comprobantes</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/comprobantes', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Comprantes.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Afectaciones</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/afectacion', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Afectacion.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Tipos de NC / ND</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/tiponota', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo TipoNota.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Detracciones</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/detraccion', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Detracciones.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Saldos</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/saldo', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Saldo.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Vencimiento</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/vence', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Vencimiento.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Historia</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/historia', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Historia.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
            
        </div>
            
			
	</div>

@endsection