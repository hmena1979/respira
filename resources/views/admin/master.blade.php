<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Centro Neumologico de Norte Respira SAC, tratamiento de enfermedades respiratorias"/>
        <meta name="keywords" content="Centro Neumológico, Respira, asma, enfermedades respiratorias, neumologia Piura"/>
        <title>@yield('title')</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="routeName" content="{{ Route::currentRouteName() }}">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('/static/css/admnew.css?v='.time()) }}">

        <!-- Scripts 
        -->
        <script src="{{ asset('js/jquery-3.5.1.min.js') }}" charset="utf-8"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.fancybox.min.js') }}"></script>
        <script src="{{ asset('/static/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('/static/js/admin.js?v='.time()) }}"></script>
	</head>
	<body>
        
		<!--wrapper start-->
		<div class="wrapper">
			<!--header menu start-->
			<div class="header">
				<div class="header-menu">
					<div class="title">CNN <span>Respira</span></div>
					<div class="sidebar-btn">
						<i class="fas fa-bars"></i>
					</div>
					<ul>
                        {{--
						<li><a href="#"><i class="fas fa-search"></i></a></li>
                        <li><a href="#"><i class="fas fa-bell"></i></a></li>
                        --}}
						<li><a href=" {{ url('/logout') }} "data-toggle="tooltip" data-placement="top" title = 'Salir'><i class="fas fa-power-off"></i></a></li>
					</ul>
				</div>
			</div>
			<!--header menu end-->
			<!--sidebar start-->
			@include('admin.sidebar')
			<!--sidebar end-->
			<!--main container start-->
			<div class="main-container">                
                <div class="page">
                    <div class="container-fluid">
                        <nav aria-lavel="breadcrumb shadow">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/admin') }}"><i class="fas fa-home"></i>Inicio</a>
                                </li>
                                @section('breadcrumb')
                                @show
                            </ol>
                        </nav>
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
                @section('prueba')
                @show
                @section('content')
                @show
                {{--
                
                --}}

            </div>
            
			<!--main container end-->
		</div>
		<!--wrapper end-->

		<script type="text/javascript">
		$(document).ready(function(){
			$(".sidebar-btn").click(function(){
				$(".wrapper").toggleClass("collapse show");
			});
		});
        </script>
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