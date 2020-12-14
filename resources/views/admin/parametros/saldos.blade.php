@extends('admin.master')
@section('title','Regenerar Saldos')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/saldos') }}"><i class="fas fa-cart-arrow-down"></i> Regenera saldos</a>
	</li>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel shadow">
				<div class="headercontent">
					<h2 class="title">Regenerar saldos</h2>
				</div>
				<div class="inside">
					{!! Form::open(['url'=>'/admin/saldos']) !!}
					<div class="row">
						<div class="col-md-5">
							<label class="lsinmargen" for="num_doc">Producto:</label>
							<div class="row no-gutters">
								<div class="col-md-4">
									{!! Form::select('tipo',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id'=>'tipo']) !!}
								</div>
								<div class="col-md-8">								
									{!! Form::select('producto',$productos,null,['class'=>'custom-select','id'=>'producto','disabled','placeholder' =>'']) !!}
								</div>
							</div>
                        </div>
                        <div class="col-md-2">
                            <label class="lsinmargen" for="periodo">Periodo:</label>
                            {!! Form::text('periodo', session('pfarmacia'), ['class'=>'form-control','id'=>'periodo','autocomplete'=>'off']) !!}
                        </div>
						<div class="col">
							{!! Form::submit('Regenerar', ['class'=>'btn btn-primary mtop20']) !!}
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
		document.getElementById('tipo').addEventListener("change",function(){
            if(this.value==1){
                document.getElementById("producto").disabled = true;
            }else{
                document.getElementById("producto").disabled = false;
            }
		});
	});
</script>
@endsection