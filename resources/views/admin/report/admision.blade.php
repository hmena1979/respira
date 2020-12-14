@extends('admin.master')
@section('title','Reportes admisión')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/radmision') }}"><i class="fas fa-cart-arrow-down"></i> Reporte admisión</a>
	</li>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel shadow">
				<div class="headercontent">
					<h2 class="title">Listado de Pacientes</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/radmision/pacientes','target'=>"_blank"]) !!}
					<div class="row">
						<div class="col-md-5">
							<label class="lsinmargen" for="num_doc">Doctor:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('rpopt',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rpopt']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('rpdoctor_id',$doctor,1,['class'=>'custom-select','id'=>'rpdoctor_id','disabled']) !!}
								</div>
							</div>
						</div>
						<div class="col">
							{!! Form::submit('Mostar', ['class'=>'btn btn-primary mtop20']) !!}
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
					<h2 class="title">Reporte de Servicios</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/radmision/servicios','target'=>"_blank"]) !!}
					<div class="row">
						<div class="col-md-4">
							<label class="lsinmargen" for="rs_opts">Servicio:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('rs_opts',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rs_opts']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('rs_servicio',$servicios,null,['class'=>'custom-select','id'=>'rs_servicio','disabled','placeholder'=>'']) !!}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<label class="lsinmargen" for="rs_optd">Doctor:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('rs_optd',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rs_optd']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('rs_doctor',$doctor,1,['class'=>'custom-select','id'=>'rs_doctor','disabled']) !!}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<label class="lsinmargen" for="rs_optfp">Forma de pago:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('rs_optfp',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rs_optfp']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('rs_fpago',$fpago,null,['class'=>'custom-select','id'=>'rs_fpago','disabled','placeholder'=>'']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop8f">
						<div class="col-md-3">
							<label class="lsinmargen" for="rs_fini">Fecha Inicial:</label>
							{!! Form::date('rs_fini', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off', 'id'=>'rs_fini']) !!}
						</div>
						<div class="col-md-3">
							<label class="lsinmargen" for="rs_ffin">Fecha Final:</label>
							{!! Form::date('rs_ffin', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off', 'id'=>'rs_ffin']) !!}
						</div>
						<div class="col-md-3">
							<label class="lsinmargen" for="rs_group">Agrupado:</label>
							{!! Form::select('rs_group',[1=>'Sin grupo',2=>'Servicio',3=>'Doctor'],1,['class'=>'custom-select','id'=>'rs_group']) !!}
						</div>
						<div class="col">
							{!! Form::submit('Mostar', ['class'=>'btn btn-primary mtop20']) !!}
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
    var url_global='{{url("/")}}';
    $(document).ready(function(){
		document.getElementById('rs_opts').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("rs_servicio").disabled = true;
            }else{
                document.getElementById("rs_servicio").disabled = false;
            }
		});
		
		document.getElementById('rs_optd').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("rs_doctor").disabled = true;
            }else{
                document.getElementById("rs_doctor").disabled = false;
            }
		});
		
		document.getElementById('rs_optfp').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("rs_fpago").disabled = true;
            }else{
                document.getElementById("rs_fpago").disabled = false;
            }
        });
	});
</script>
@endsection