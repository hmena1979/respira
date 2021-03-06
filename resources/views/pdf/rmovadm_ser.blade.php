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
                REPORTE DE SERVICIOS <br>
                <span class="subtitulo">
                    DEL {{$fini}} AL {{$ffin}}
                </span>
            </p>
            
            {{-- <span class="empresa">{{$parametro->razsoc}}</span>
            <h3 class="titulo">REPORTE DE MOVIMIENTOS</h3>
            <h3 class="subtitulo">Rango de fechas</h3> --}}
        </div>
        {{-- {{dd($array_dr)}} --}}
        {{-- <center><h3>REPORTE DE MOVIMIENTOS</h3></center> --}}
        @php
            $tcli = 0;
            $tdoc = 0;
            $tst = 0;
        @endphp
        @foreach($doc as $d=>$mov)
        <table class="detaller">
            <tr>
            <th class="text-left" width="50%">SERVICIO: {{$d}}</th>
            </tr>
        </table>
        
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
                        <th width="8%">FECHA</th>
                        <th width="20%">CLIENTE</th>
                        <th width="10%">DOCUMENTO</th>
                        <th width="20%">DOCTOR</th>
                        <th class="text-right" width="10%">CLINICA</th>
                        <th class="text-right" width="10%">DOCTOR</th>
                        <th class="text-right" width="10%">TOTAL</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                        $scli = 0;
                        $sdoc = 0;
                        $sst = 0;
                    @endphp
                    @foreach($value as $valores)
                    <tr>
                        <td>{{ $valores->fecha }}</td>
                        <td>{{ substr($valores->cli->razsoc,0,23) }}</td>
                        <td>{{ $valores->serie.'-'.intval($valores->numero) }}</td>
                        <td>{{ substr($valores->dr->nombre,0,25) }}</td>
                        <td class="text-right">{{ $valores->stcli }}</td>
                        <td class="text-right">{{ $valores->stdr }}</td>
                        <td class="text-right">{{ $valores->subtotal }}</td>
                    </tr>
                    @php
                        $scli += $valores->stcli;
                        $sdoc += $valores->stdr;
                        $sst += $valores->subtotal;
                        $tcli += $valores->stcli;
                        $tdoc += $valores->stdr;
                        $tst += $valores->subtotal;
                    @endphp
                    @endforeach
                    <tr class="ultimafila">
                        <td colspan="4"></td>
                        <td class="negrita text-right ultimafila">{{ number_format($scli,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($sdoc,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($sst,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach
        @endforeach
        <div class="detallef">
            <table>
                <thead>
                    <tr>
                        <th width="8%"></th>
                        <th width="20%"></th>
                        <th width="10%"></th>
                        <th width="20%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td colspan="4"></td>
                        <td class="negrita text-right ultimafila">{{ number_format($tcli,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($tdoc,2) }}</td>
                        <td class="negrita text-right ultimafila">{{ number_format($tst,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

	</body>
</html>