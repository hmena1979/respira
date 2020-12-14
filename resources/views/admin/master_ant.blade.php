<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">

	<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

    <!-- Styles -->
	<link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
	{{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
	{{-- <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">

	<!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script>     --}}
    <script src="{{ asset('/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('/js/all.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('/static/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/static/js/admin.js?v='.time()) }}"></script>
</head>
<body>
	<div class="wrapper">
		<div class="col1">@include('admin.sidebar')</div>
		<div class="col2">
            <nav class="navbar navbar-expand-lg shadow">
                <div class="sidebar-btn">
                    <i class="fas fa-bars"></i>
                </div>                
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/admin') }}"><i class="fas fa-home"></i>Inicio</a>
                    </li>
                    @section('breadcrumb')
                    @show
                </ol>
            </nav>            

			<div class="page">
				<div class="container-fluid">
                    {{--  
					<nav aria-lavel="breadcrumb shadow">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ url('/admin') }}"><i class="fas fa-home"></i>Inicio</a>
							</li>
							@section('breadcrumb')
							@show
						</ol>
                    </nav>
                    --}}
				</div>				
			</div>
			@if(Session::has('message'))
                <div class="container">
                    <div class="alert alert-{{ Session::get('typealert') }}" style="display:none;">
                        {{ Session::get('message') }}
                        @if ($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <script>
                            $('.alert').slideDown();
                            setTimeout(function(){ $('.alert').slideUp(); }, 10000);
                        </script>                
                    </div>
                </div>        
            @endif
            @section('content')
            @show
		</div>
	</div>

	<script>
		$(function () {
        	$('[data-toggle="tooltip"]').tooltip()
        })
    </script>


	<script>
        $(document).ready(function(){
            $('#grid').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "language":{
                    "info": "_TOTAL_ Registros",
                    "search": "Buscar",
                    "paginate":{
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "lengthMenu": "Mostrar <select>"+
                                    "<option value='10'>10</option>"+
                                    "<option value='25'>25</option>"+
                                    "<option value='50'>50</option>"+
                                    "<option value='100'>100</option>"+
                                    "<option value='-1'>Todos</option>"+
                                    "</select> Registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "emptyTable": "No se encontraton coincidencias",
                    "zeroRecords": "No se encontraton coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""

                }
            });
        });
    </script>

    @yield('script')
</body>
</html>