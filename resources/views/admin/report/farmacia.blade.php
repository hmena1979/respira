@extends('admin.master')
@section('title','Reportes farmacia')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/rfarmacia') }}"><i class="fas fa-cart-arrow-down"></i> Reporte farmacia</a>
	</li>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel shadow">
				<div class="headercontent">
					<h2 class="title">Listado de Productos</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/rfarmacia/productos','target'=>"_blank"]) !!}
					<div class="row">
						{{-- <div class="col-md-5">
							<label class="lsinmargen" for="num_doc">Doctor:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('rpopt',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rpopt']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('rpdoctor_id',$doctor,1,['class'=>'custom-select','id'=>'rpdoctor_id','disabled']) !!}
								</div>
							</div>
						</div> --}}
						<div class="col">
							{!! Form::submit('Listar productos', ['class'=>'btn btn-primary']) !!}
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
					<h2 class="title">Reporte de Movimiento de Productos</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/rfarmacia/movprod','target'=>"_blank"]) !!}
					<div class="row">
						<div class="col-md-5">
							<label class="lsinmargen" for="rp_optp">Producto:</label>
							<div class="row no-gutters">
								<div class="col-md-3">
									{!! Form::select('rp_optp',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rp_optp']) !!}
								</div>
								<div class="col-md-9">								
									{!! Form::select('rp_producto',$productos,null,['class'=>'custom-select','id'=>'rp_producto','disabled','placeholder'=>'']) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label class="lsinmargen" for="rp_optt">Tipo:</label>
							<div class="row no-gutters">
								<div class="col-md-5">
									{!! Form::select('rp_optt',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rp_optt']) !!}
								</div>
								<div class="col-md-7">								
									{!! Form::select('rp_tipo',[1=>'Venta',2=>'Consumo'],1,['class'=>'custom-select','id'=>'rp_tipo','disabled']) !!}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<label class="lsinmargen" for="rp_optfp">Forma de pago:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('rp_optfp',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'rp_optfp']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('rp_fpago',$fpago,null,['class'=>'custom-select','id'=>'rp_fpago','disabled','placeholder'=>'']) !!}
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
							{!! Form::select('rs_group',[1=>'Sin grupo',2=>'Producto'],1,['class'=>'custom-select','id'=>'rs_group']) !!}
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

	<div class="row mtop16 mbottom16">
		<div class="col-md-12">
			<div class="panel shadow">
				<div class="headercontent">
					<h2 class="title">Listado de Movimiento de Comprobantes</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/rfarmacia/movcomp','target'=>"_blank"]) !!}
					<div class="row">
						<div class="col-md-3">
							<label class="lsinmargen" for="rp_optt">Tipo:</label>
							<div class="row no-gutters">
								<div class="col-md-5">
									{!! Form::select('lis_optt',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'lis_optt']) !!}
								</div>
								<div class="col-md-7">								
									{!! Form::select('lis_tipo',[1=>'Venta',2=>'Consumo'],1,['class'=>'custom-select','id'=>'lis_tipo','disabled']) !!}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<label class="lsinmargen" for="lis_optfp">Forma de pago:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('lis_optfp',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'lis_optfp']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('lis_fpago',$fpago,null,['class'=>'custom-select','id'=>'lis_fpago','disabled','placeholder'=>'']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop8f">
						<div class="col-md-3">
							<label class="lsinmargen" for="rs_fini">Fecha Inicial:</label>
							{!! Form::date('lis_fini', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off', 'id'=>'lis_fini']) !!}
						</div>
						<div class="col-md-3">
							<label class="lsinmargen" for="rs_ffin">Fecha Final:</label>
							{!! Form::date('lis_ffin', \Carbon\Carbon::now(), ['class'=>'form-control','autocomplete'=>'off', 'id'=>'lis_ffin']) !!}
						</div>
						<div class="col-md-3 oculto">
							<label class="lsinmargen" for="rs_group">Agrupado:</label>
							{!! Form::select('lis_group',[1=>'Sin grupo',2=>'Producto'],1,['class'=>'custom-select','id'=>'lis_group']) !!}
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
.
@endsection
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
		document.getElementById('rp_optp').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("rp_producto").disabled = true;
            }else{
                document.getElementById("rp_producto").disabled = false;
            }
		});
		
		document.getElementById('rp_optt').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("rp_tipo").disabled = true;
            }else{
                document.getElementById("rp_tipo").disabled = false;
            }
		});
		
		document.getElementById('rp_optfp').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("rp_fpago").disabled = true;
            }else{
                document.getElementById("rp_fpago").disabled = false;
            }
        });
		document.getElementById('lis_optt').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("lis_tipo").disabled = true;
            }else{
                document.getElementById("lis_tipo").disabled = false;
            }
		});
		
		document.getElementById('lis_optfp').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("lis_fpago").disabled = true;
            }else{
                document.getElementById("lis_fpago").disabled = false;
            }
        });
	});
</script>
@endsection