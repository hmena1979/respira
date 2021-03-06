@extends('admin.master')
@section('title','Wincontall')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/sunat/wincontall') }}"><i class="fas fa-calendar-check"></i> Wincontall</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-calendar-check"></i> Wincontall</h2>
					</div>
					<div class="inside">
                        <div class="row mbottom16">
                            <div class="col-md-12">
                                <div class="panel shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Wincontall</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/sunat/wincontall']) !!}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="lsinmargen" for="periodo">Periodo:</label>
                                                {!! Form::text('periodo', session('padmision'), ['class'=>'form-control','id'=>'periodo','autocomplete'=>'off']) !!}
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Generar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        
                    </div>
				</div>
            </div>
            
        </div>
            
			
	</div>

@endsection