@extends('admin.master')
@section('title','Vencimientos')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/producto/vencimiento') }}"><i class="fab fa-product-hunt"></i> Producto: <strong>{{ $producto->nombre }}</strong></a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="inside">
						{!! Form::open(['url'=>'/admin/producto/'.$vencimiento->id.'/vencimientoedit']) !!}
						<div class="row">					
                            <div class="col-md-2">
                                <label class="lsinmargen" for="lote">Lote:</label>
                                {!! Form::text('lote', $vencimiento->lote, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="vencimiento">Vencimiento:</label>
                                {!! Form::text('vencimiento', $vencimiento->vencimiento, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="entradas">Entradas:</label>
                                {!! Form::text('entradas', $vencimiento->entradas, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="salidas">Salidas:</label>
                                {!! Form::text('salidas', $vencimiento->salidas, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="saldo">Saldo:</label>
                                {!! Form::text('saldo', $vencimiento->saldo, ['class'=>'form-control','autocomplete'=>'off', 'disabled','id'=>'saldo']) !!}
                            </div>
                        </div>
                        <div class="row mtop20">
                            <div class="col">
                                <label class="lsinmargen colorprin" for="lote">Nuevo Lote:</label>
                            </div>
                            
                        </div>
                        <div class="row">
							<div class="col-md-2">
                                <label class="lsinmargen" for="nlote">Lote:</label>
                                {!! Form::text('nlote', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="nvencimiento">Vencimiento:</label>
                                {!! Form::text('nvencimiento', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="lsinmargen" for="ncantidad">Cantidad:</label>
                                {!! Form::text('ncantidad', null, ['class'=>'form-control','autocomplete'=>'off','id'=>'ncantidad']) !!}
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
			document.getElementById('ncantidad').addEventListener("blur",function(){
                if(this.value > document.getElementById('saldo').value){
                    alert('La cantidad no puede ser mayor al saldo');
                    this.value = null;
                }
			});
		});
	</script>
@endsection