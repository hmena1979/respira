@extends('admin.master')
@section('title','Productos')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/productos') }}"><i class="fab fa-product-hunt"></i> Productos</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/producto/'.$producto->id.'/edit']) !!}
						<div class="row">					
                            <div class="col-md-6">
                                <label class="lsinmargen" for="nombre">Nombre:</label>
                                {!! Form::text('nombre', $producto->nombre, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-4">
								<label class="lsinmargen"  for="umedida_id">Presentación:</label>
								{!! Form::select('umedida_id',$umedida,$producto->umedida_id,['class'=>'custom-select','placeholder' =>'Elija presentación']) !!}	
                            </div>
                            <div class="col-md-2">
								<label class="lsinmargen"  for="afecto">Afectación:</label>
								{!! Form::select('afecto',['1'=>'AFECTO','2'=>'EXONERADO','3'=>'INAFECTO'],$producto->afecto,['class'=>'custom-select']) !!}	
							</div>
                        </div>
                        <div class="row mtop10">
                            <div class="col-md-4">
								<label class="lsinmargen"  for="tipmed_id">Tipo medicamento:</label>
								{!! Form::select('tipmed_id',$tipmed,$producto->tipmed_id,['class'=>'custom-select','placeholder' =>'Elija tipo de medicamento','id'=>'tipmed_id']) !!}	
                            </div><div class="col-md-4">
								<label class="lsinmargen"  for="composicion_id">Composición:</label>
								{!! Form::select('composicion_id',$composicion,$producto->composicion_id,['class'=>'custom-select','placeholder' =>'Elija composición','id'=>'composicion_id']) !!}	
                            </div><div class="col-md-4">
								<label class="lsinmargen"  for="laboratorio_id">Laboratorio:</label>
								{!! Form::select('laboratorio_id',$laboratorio,$producto->laboratorio_id,['class'=>'custom-select','placeholder' =>'Elija laboratorio']) !!}	
                            </div>
                        </div>
                        <div class="row mtop10">
							<div class="col-md-2">
								<label class="lsinmargen"  for="stock">Stock:</label>
								{!! Form::text('stock', $producto->stock, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-2">
								<label class="lsinmargen"  for="stockmin">Stock mínimo:</label>
								{!! Form::text('stockmin', $producto->stockmin, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
							<div class="col-md-2" style="display:@if(kvfj(Auth::user()->permissions,'producto_price')) block @else none @endif">
								<label class="lsinmargen"  for="precompra">Precio promedio:</label>
								{!! Form::text('precompra', $producto->precompra, ['class'=>'form-control','autocomplete'=>'off','id'=>'precompra','disabled']) !!}
                            </div>
							<div class="col-md-2" style="display:@if(kvfj(Auth::user()->permissions,'producto_price')) block @else none @endif">
								<label class="lsinmargen"  for="porganancia">% Ganancia:</label>
								{!! Form::text('porganancia', $producto->porganancia, ['class'=>'form-control','autocomplete'=>'off','id'=>'porganancia']) !!}
                            </div>
							<div class="col-md-2" style="display:@if(kvfj(Auth::user()->permissions,'producto_price')) block @else none @endif">
								<label class="lsinmargen"  for="premerca">Precio venta:</label>
								{!! Form::text('premerca', $producto->premerca, ['class'=>'form-control','autocomplete'=>'off','id'=>'premerca']) !!}
                            </div>
                            <div class="col-md-2">
								<label class="lsinmargen"  for="codant">Código anterior:</label>
								{!! Form::text('codant', $producto->codant, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
@section('script')
	<script>
        var url_global='{{url("/")}}';
		$(document).ready(function(){
			document.getElementById('tipmed_id').addEventListener("change",function(){
				var iddes = this.value;
				$.get(url_global+"/admin/tipmeds/"+iddes+"/selcomp",function(response){
					$('#composicion_id').empty();
					for(i=0;i<response.length;i++){
						$('#composicion_id').append("<option value='"+response[i].id+"'>"+response[i].nombre+"</option>");
					}
				});
			});
		});
	</script>
@endsection