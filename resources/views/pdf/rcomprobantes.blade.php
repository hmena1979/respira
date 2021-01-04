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
                LISTADO DE MOVIMIENTO DE COMPROBANTES <br>
                <span class="subtitulo">
                    <strong>{{ $titulo }}</strong> / DEL {{$fini}} AL {{$ffin}}
                </span>
            </p>
            
            {{-- <span class="empresa">{{$parametro->razsoc}}</span>
            <h3 class="titulo">REPORTE DE MOVIMIENTOS</h3>
            <h3 class="subtitulo">Rango de fechas</h3> --}}
        </div>
        {{-- {{dd($fpago)}} --}}
        {{-- <center><h3>REPORTE DE MOVIMIENTOS</h3></center> --}}
        @php
            $st = 0;
            $tt = 0;
        @endphp
        @foreach ($mov as $m=>$value)
        <table class="detaller">
            <tr>
            <th class="text-left" width="50%">FORMA DE PAGO: {{$m}}</th>
            </tr>
        </table>
        <div class="detaller mbottom16">
            <table>
                {{-- <caption>
                    <h3 class="text-left">DOCTOR: {{$doctor->nombre}}</h3>
                </caption> --}}
                <thead>
                    <tr>
                        <th width="10%">FECHA</th>
                        <th width="30%">CLIENTE</th>
                        <th width="8%">DOCUMENTO</th>
                        <th width="42%">ESTADO</th>
                        <th class="text-right" width="10%">TOTAL</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                        $st = 0;
                    @endphp
                    @foreach($value as $valores)
                    <tr class="@if($valores->anulado==1)rojo @endif">
                        <td>{{ $valores->fecha }}</td>
                        <td>{{ substr($valores->cli->razsoc,0,30) }}</td>
                        <td>{{ $valores->serie.'-'.intval($valores->numero) }}</td>
                        <td>{{ $valores->cdr }}</td>
                        <td class="text-right">{{ $valores->total }}</td>
                    </tr>
                    @php
                        $st += $valores->total;
                        $tt += $valores->total;
                    @endphp
                    @endforeach
                    <tr class="ultimafila">
                        <td colspan="4"></td>
                        <td class="negrita text-right ultimafila">{{ number_format($st,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach
        <div class="detallef">
            <table>
                <thead>
                    <tr>
                        <th width="10%"></th>
                        <th width="30%"></th>
                        <th width="8%"></th>
                        <th width="42%"></th>
                        <th width="10%"></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td colspan="4"></td>
                        <td class="negrita text-right ultimafila">{{ number_format($tt,2) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        

	</body>
</html>