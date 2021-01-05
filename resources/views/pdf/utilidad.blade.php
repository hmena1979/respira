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
                UTILIDAD DE VENTAS <br>
                <span class="subtitulo">
                    @if($optipo == 1) SIN IGV @else CON IGV @endif/ DEL {{$fini}} AL {{$ffin}}
                </span>
            </p>
            {{-- {{ dd($doc) }} --}}
            
            {{-- <span class="empresa">{{$parametro->razsoc}}</span>
            <h3 class="titulo">REPORTE DE MOVIMIENTOS</h3>
            <h3 class="subtitulo">Rango de fechas</h3> --}}
        </div>
        {{-- {{dd($doc)}} --}}
        {{-- <center><h3>REPORTE DE MOVIMIENTOS</h3></center> --}}
        @php
            $tttcompra = 0;
            $tttmercado = 0;
            $ttutilidad = 0;
            $igv = $parametro->por_igv / 100;
        @endphp
        @foreach ($doc as $m=>$value)
        <table class="detaller">
            <tr>
            <th class="text-left" width="50%">PRODUCTO: {{$m}}</th>
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
                        <th class="text-right" width="10%">CANTIDAD</th>
                        <th class="text-right" width="10%">P.COMPRA</th>
                        <th class="text-right" width="10%">P.MERCADO</th>
                        <th class="text-right" width="10%">T.COMPRA</th>
                        <th class="text-right" width="10%">T.MERCADO</th>
                        <th class="text-right" width="10%">UTILIDAD</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ttcompra = 0;
                        $ttmercado = 0;
                        $tutilidad = 0;
                    @endphp
                    @foreach($value as $valores)
                    @php
                     if($optipo == 1){
                         $cantidad = $valores->cantidad;
                         $pcompra = $valores->preprom;
                         $pmercado = round($valores->precio / (1+$igv),4);
                         $tcompra = round($pcompra * $cantidad, 2);
                         $tmercado = round($pmercado * $cantidad, 2);
                         $utilidad = $tmercado - $tcompra;
                     }else{
                        $cantidad = $valores->cantidad;
                         $pcompra = round($valores->preprom * (1+$igv),4);
                         $pmercado = $valores->precio;
                         $tcompra = round($pcompra * $cantidad, 2);
                         $tmercado = round($pmercado * $cantidad, 2);
                         $utilidad = $tmercado - $tcompra;
                     }
                    @endphp
                    <tr>
                        <td>{{ $valores->fecha }}</td>
                        <td class="text-right">{{ $cantidad }}</td>
                        <td class="text-right">{{ $pcompra }}</td>
                        <td class="text-right">{{ $pmercado }}</td>
                        <td class="text-right">{{ $tcompra }}</td>
                        <td class="text-right">{{ $tmercado }}</td>
                        <td class="text-right">{{ $utilidad }}</td>
                    </tr>
                    @php
                        $ttcompra += $tcompra;
                        $ttmercado += $tmercado;
                        $tutilidad += $utilidad;
                        $tttcompra += $tcompra;
                        $tttmercado += $tmercado;
                        $ttutilidad += $utilidad;
                    @endphp
                    @endforeach
                    <tr class="ultimafila">
                        <td colspan="4"></td>
                        <td class="negrita text-right ultimafila">{{ number_format($ttcompra,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($ttmercado,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($tutilidad,2) }}</td>
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
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td colspan="4"></td>
                        <td class="negrita text-right ultimafila">{{ number_format($tttcompra,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($tttmercado,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($ttutilidad,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        

	</body>
</html>