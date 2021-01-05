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
                REPORTE DE SALDOS<br>
                <span class="subtitulo">
                    PERIODO: {{$periodo}}
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
                        <th width="50%">PRODUCTO</th>
                        <th class="text-right" width="10%">INICIAL</th>
                        <th class="text-right" width="10%">ENTRADAS</th>
                        <th class="text-right" width="10%">SALIDAS</th>
                        <th class="text-right" width="10%">SALDO</th>
                        <th class="text-right" width="10%">PRECIO</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($producto as $pro)
                    <tr>
                        <td>{{ $pro->nombre }}</td>
                        <td class="text-right">{{ $pro->inicial }}</td>
                        <td class="text-right">{{ $pro->entradas }}</td>
                        <td class="text-right">{{ $pro->salidas }}</td>
                        <td class="text-right">{{ $pro->saldo }}</td>
                        <td class="text-right">{{ $pro->precio }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

	</body>
</html>