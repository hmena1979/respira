@extends('admin.master')
@section('title','Respira')


@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel shadow">
				<div class="headercontent">
					<h2 class="title">
						Pacientes
					</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/cambio']) !!}
					<div class="row">
						<div class="col-md-3">
							<div class="cita">
								<div class="input-group">
									{!! Form::date('fecha', session('fecha'), ['class'=>'form-control','autocomplete'=>'off', 'id'=>'fecha']) !!}
									<div class="input-group-append">
										{!! Form::submit('Mostar', ['class'=>'btn btn-success']) !!}

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1">
							
						</div>
						
					</div>
					{!! Form::close() !!}
					<table class="table table-hover table-sm">
						<thead>
							<tr>
								<th width="27%">Doctor</th>
								<th width="35%">Paciente</th>
								<th width="12%">Estado</th>
								<th width="8%">Tipo</th>
								<th width="18%"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($historias as $historia)
							<tr>
								<td>{{ $historia->dr->nombre }}</td>
								<td>{{ $historia->pac->razsoc }}</td>
								<td>{{ $historia->sta->nombre }}</td>
								<td>{{ $historia->tip->nombre }}</td>
								<td>
									<div class="opts">
										@if(kvfj(Auth::user()->permissions,'paciente_triage'))
										<a href="{{ url('/admin/historia/'.$historia->id.'/triage') }}"datatoggle="tooltip" data-placement="top" title="Triaje">
											<i class="fas fa-stethoscope"></i> Triaje
										</a>
										@endif
										@if(kvfj(Auth::user()->permissions,'paciente_history'))
										<a href="{{ url('/admin/historias/'.$historia->paciente_id.'/'.$historia->item.'/home') }}"datatoggle="tooltip" data-placement="top" title="Historia"><i class="fas fa-book-medical"></i> Historia</a>
										@endif										
										{{-- @if(kvfj(Auth::user()->permissions,'paciente_appointment'))
										<a href="{{ url('/admin/paciente/'.$historia->paciente_id.'/appointment') }}"datatoggle="tooltip" data-placement="top" title="Historia"><i class="fas fa-book-medical"></i> Programar</a>
										@endif										 --}}
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
	$(document).ready(function(){
	});
</script>
@endsection