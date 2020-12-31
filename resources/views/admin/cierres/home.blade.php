@extends('admin.master')
@section('title','Cierre de mes')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/umedidas') }}"><i class="fas fa-calendar-check"></i> Cierre de mes</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-calendar-check"></i> Cierre de mes</h2>
					</div>
					<div class="inside">
                        @if(kvfj(Auth::user()->permissions,'cadmision'))
                        <div class="row mbottom16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Cierre de admisión</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/cierre/cadmision']) !!}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="lsinmargen" for="padmision">Periodo:</label>
                                                {!! Form::text('padmision', session('padmision'), ['class'=>'form-control','id'=>'padmision','autocomplete'=>'off']) !!}
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Cerrar periodo', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(kvfj(Auth::user()->permissions,'cfarmacia'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Cierre de farmacia</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/cierre/cfarmacia']) !!}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="lsinmargen" for="pfarmacia">Periodo:</label>
                                                {!! Form::text('pfarmacia', session('pfarmacia'), ['class'=>'form-control','id'=>'pfarmacia','autocomplete'=>'off']) !!}
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Cerrar periodo', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
				</div>
            </div>
            
        </div>
            
			
	</div>

@endsection