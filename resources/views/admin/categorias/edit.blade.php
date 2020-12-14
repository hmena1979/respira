@extends('admin.master')
@section('title','Categorias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/categorias/'.$cat->modulo) }}"><i class="fas fa-folder-open"></i> Categorias</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
                    <div class="headercontent">
                        @php($nombres = getModulosArray())

                        <h2 class="title"><i class="fas fa-folder-open"></i> Categorias: <strong>{{ $nombres[$cat->modulo] }}</strong></h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{!! Form::open(['url'=>'/admin/categoria/'.$cat->id.'/edit']) !!}
						<div class="row">
                            @if($titulo <> '0')
                            <div class="col-md-2">
								<label for="codigo">Código:</label>
								{!! Form::text('codigo', $cat->codigo, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            @endif
                            
							<div class="col-md-7">
								<label for="nombre">Nombre:</label>
								{!! Form::text('nombre', $cat->nombre, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						{!! Form::submit('Guardar', ['class'=>'btn btn-success mtop16']) !!}
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection