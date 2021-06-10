<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Centro Neumologico de Norte Respira SAC, tratamiento de enfermedades respiratorias"/>
        <meta name="keywords" content="Centro Neumológico, Respira, asma, enfermedades respiratorias, neumologia Piura"/>
        <title>CNN Respira</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="routeName" content="{{ Route::currentRouteName() }}">

        <!-- Styles
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
        -->
        <link rel="stylesheet" href="{{ url('/static/css/reportes.css?v='.time()) }}">
	</head>
	<body>
        <div class="header">
            <p class="empresa">{{$parametro->razsoc}} 
                <span class="page">Página: </span><br>
                <span class="fecha">Fecha: {{\Carbon\Carbon::now()->format('Y-m-d')}}</span>
            </p>
            <p class="titulo">
                REPORTE DE PRODUCTOS
            </p>
        </div>
        {{-- <center><h3>REPORTE DE PACIENTES</h3></center> --}}
        {{-- <table class="cliente">
            <tr>
            <th class="text-left" width="50%">DOCTOR: {{$doctor->nombre}}</th>
            </tr>
        </table> --}}
        <div class="detalle mbottom16">
            <table>
                {{-- <caption>
                    <h3 class="text-left">DOCTOR: {{$doctor->nombre}}</h3>
                </caption> --}}
                <thead>
                    <tr>
                        <th width="60%">NOMBRE</th>
                        <th width="20%">U.MEDIDA</th>
                        <th width="10%">STOCK</th>
                        <th width="10%">PRECIO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->umedida->nombre }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>{{ $tipo==1 ? $producto->premerca : $producto->precompra}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

	</body>
</html>