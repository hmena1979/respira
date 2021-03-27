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
            <p class="empresa">
                {{$parametro->razsoc}} <span class="page">Página: </span><br>
                <span class="fecha">Fecha: {{\Carbon\Carbon::now()->format('Y-m-d')}}</span>
            </p>
            <p class="titulo">
                REPORTE DE KARDEX<br>
                <span class="subtitulo">
                    PERIODO: {{$periodo}} / PRODUCTO: {{ $producto->nombre }}
                </span>
            </p>
            {{-- {{ dd($doc) }} --}}
            
            {{-- <span class="empresa">{{$parametro->razsoc}}</span>
            <h3 class="titulo">REPORTE DE MOVIMIENTOS</h3>
            <h3 class="subtitulo">Rango de fechas</h3> --}}
        </div>
        {{-- {{dd($doc)}} --}}
        {{-- <center><h3>REPORTE DE MOVIMIENTOS</h3></center> --}}
        <div class="detaller mbottom16">
            <table>
                {{-- <caption>
                    <h3 class="text-left">DOCTOR: {{$doctor->nombre}}</h3>
                </caption> --}}
                <thead>
                    <tr>
                        <th class="" width="10%">FECHA</th>
                        <th class="" width="10%">DOCUMENTO</th>
                        <th class="" width="30%">GLOSA</th>
                        <th class="text-right" width="10%">ENTRADAS</th>
                        <th class="text-right" width="10%">SALIDAS</th>
                        <th class="text-right" width="10%">SALDO</th>
                        <th class="text-right" width="10%">PRECIO</th>
                        <th class="text-right" width="10%">PROMEDIO</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($kardex as $kar)
                    <tr>
                        <td class="">{{ $kar->fecha }}</td>
                        <td class="">{{ $kar->documento }}</td>
                        <td class="">{{ $kar->proveedor }}</td>
                        <td class="text-right">{{ $kar->cant_ent }}</td>
                        <td class="text-right">{{ $kar->cant_sal }}</td>
                        <td class="text-right">{{ $kar->cant_sald }}</td>
                        <td class="text-right">{{ $kar->pre_compra }}</td>
                        <td class="text-right">{{ $kar->pre_prom }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

	</body>
</html>