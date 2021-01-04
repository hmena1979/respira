@extends('admin.master')
@section('title','Comprobantes de pago')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/rfarmacia') }}"><i class="fas fa-cart-arrow-down"></i> Comprobantes de pago</a>
	</li>
@endsection

@section('content')
<div class="container">

	<div class="row mtop16 mbottom16">
		<div class="col-md-12">
			<div class="panel shadow">
				<div class="headercontent">
					<h2 class="title">Listado de Movimiento de Comprobantes</h2>
				</div>
				
				<div class="inside">
					{!! Form::open(['url'=>'/admin/sunat/comprobantes','target'=>"_blank"]) !!}
					<div class="row">
						<div class="col-md-3">
							<label class="lsinmargen" for="rp_opt">Emisor:</label>
                            {!! Form::select('rp_opt',[1=>'Admisión',2=>'Notas Admision', 3=>'Farmacia',4=>'Notas Farmacia'],1,['class'=>'custom-select','id'=>'rp_opt']) !!}
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