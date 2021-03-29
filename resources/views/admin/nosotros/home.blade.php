@extends('admin.master')
@section('title','Nosotros')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/web/nosotros/') }}"><i class="fas fa-chalkboard-teacher"></i> Nosotros</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">					
					<div class="inside">
						{!! Form::open(['url'=>'/admin/web/nosotros']) !!}
						<div class="row">
							<div class="col-md-3">
								<label for="ruc">Ruc:</label>
								{!! Form::text('ruc', $nos->ruc, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-9">
								<label for="razsoc">Razón Social:</label>
								{!! Form::text('razsoc', $nos->razsoc, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label for="telefono" class="mtop16">Teléfono:</label>
								{!! Form::text('telefono', $nos->telefono, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<label for="contacto" class="mtop16">Contacto:</label>
								{!! Form::text('contacto', $nos->contacto, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-12">
								<label for="descorta">Descripción Corta:</label>
								{!! Form::textarea('descorta',$nos->descorta,['class'=>'form-control', 'rows'=>'4']) !!}			
							</div>
						</div>
						<div class="row mtop16">
							<div class="col-md-12">
								<label for="quiesomos">Quienes somos:</label>
								{!! Form::textarea('quiesomos',$nos->quiesomos,['class'=>'form-control', 'id'=>'editor']) !!}			
							</div>
						</div>
						
						<div class="row mtop10">
							<div class="col">
								{!! Form::submit('Guardar', ['class'=>'btn btn-agregar']) !!}
							</div>
						</div>
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection
@section('script')
<script>
$(document).ready(function(){
	editor_init('editor');
})
</script>
@endsection
