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
        {{-- {{ dd($factura) }} --}}
        <table>
            {{-- <caption>
                <h3 class="text-left">DOCTOR: {{$doctor->nombre}}</h3>
            </caption> --}}
            <thead>
                <tr>
                    <th>CODIGO_1</th>
                    <th>FECHA</th>
                    <th>TIPO_DOC</th>
                    <th>FACTURA</th>
                    <th>RUC</th>
                    <th>NOMBRE</th>
                    <th>AFECTO</th>
                    <th>EXONERADO</th>
                    <th>IMPUESTO</th>
                    <th>OTROS_GAST</th>
                    <th>ICBPER</th>
                    <th>TOTAL</th>
                    <th>COD_MONEDA</th>
                    <th>COD_IGV</th>
                    <th>CREDITO</th>
                    <th>LUGAR</th>
                    <th>FECHA_REFE</th>
                    <th>FACTURA_RE</th>
                    <th>TIPODOC_RE</th>
                    <th>CLASE_DOCU</th>
                    <th>IMPORTE</th>
                    <th>COD_DETRAC</th>
                    <th>TIPO_DETRA</th>
                    <th>DETALLE</th>
                    <th>TIPO_CV</th>
                    <th>COD_DESTIN</th>
                    <th>EFE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura as $fac)
                <tr>
                    <td></td>
                    <td>{{ date("d/m/Y",strtotime($fac->fecha)) }}</td>
                    <td>{{ $fac->comprobante_id }}</td>
                    <td>{{ $fac->serie.'-'.$fac->numero }}</td>
                    <td>{{ $fac->ruc }}</td>
                    <td>{{ $fac->cli->razsoc }}</td>
                    <td>{{ $fac->tot_gravadas }}</td>
                    <td>{{ $fac->tot_exoneradas }}</td>
                    <td>{{ $fac->tot_igv }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $fac->total_clinica }}</td>
                    <td>
                        @if($fac->moneda == 'PEN')
                            1
                        @else
                            2
                        @endif
                    </td>
                    <td>02</td>
                    <td>
                        @if($fac->tipo == 1)
                            FALSO
                        @else
                            VERDADERO
                        @endif
                    </td>
                    <td>01</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>0</td>
                    <td></td>
                    <td></td>
                    <td>
                        @foreach($fac->det as $det1)
                            {{ $det1->servicio }}
                        @endforeach
                    </td>
                    <td>01</td>
                    <td>1</td>
                    <td></td>
                </tr>
                @endforeach
                @foreach($notaadm as $fac)
                <tr>
                    <td></td>
                    <td>{{ date("d/m/Y",strtotime($fac->fecha)) }}</td>
                    <td>{{ $fac->comprobante_id }}</td>
                    <td>{{ $fac->serie.'-'.$fac->numero }}</td>
                    <td>{{ $fac->ruc }}</td>
                    <td>{{ $fac->cli->razsoc }}</td>
                    <td>{{ $fac->tot_gravadas }}</td>
                    <td>{{ $fac->tot_exoneradas }}</td>
                    <td>{{ $fac->tot_igv }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $fac->total }}</td>
                    <td>
                        @if($fac->moneda == 'PEN')
                            1
                        @else
                            2
                        @endif
                    </td>
                    <td>02</td>
                    <td>FALSO</td>
                    <td>01</td>
                    <td>{{ date("d/m/Y",strtotime($fac->fecha)) }}</td>
                    <td>{{ $fac->dmserie.'-'.$fac->dmnumero }}</td>
                    <td>{{ $fac->dmcomprobante_id }}</td>
                    <td></td>
                    <td>0</td>
                    <td></td>
                    <td></td>
                    <td>
                        @foreach($fac->det as $det1)
                            {{ $det1->servicio }}
                        @endforeach
                    </td>
                    <td>01</td>
                    <td>1</td>
                    <td></td>
                </tr>
                @endforeach
                @foreach($salida as $fac)
                <tr>
                    <td></td>
                    <td>{{ date("d/m/Y",strtotime($fac->fecha)) }}</td>
                    <td>{{ $fac->comprobante_id }}</td>
                    <td>{{ $fac->serie.'-'.$fac->numero }}</td>
                    <td>{{ $fac->ruc }}</td>
                    <td>{{ $fac->cli->razsoc }}</td>
                    <td>{{ $fac->tot_gravadas }}</td>
                    <td>{{ $fac->tot_exoneradas }}</td>
                    <td>{{ $fac->tot_igv }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $fac->total }}</td>
                    <td>
                        @if($fac->moneda == 'PEN')
                            1
                        @else
                            2
                        @endif
                    </td>
                    <td>02</td>
                    <td>
                        @if($fac->tipo == 1)
                            FALSO
                        @else
                            VERDADERO
                        @endif
                    </td>
                    <td>01</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>0</td>
                    <td></td>
                    <td></td>
                    <td>Farmacia</td>
                    <td>01</td>
                    <td>1</td>
                    <td></td>
                </tr>
                @endforeach
                @foreach($notafar as $fac)
                <tr>
                    <td></td>
                    <td>{{ date("d/m/Y",strtotime($fac->fecha)) }}</td>
                    <td>{{ $fac->comprobante_id }}</td>
                    <td>{{ $fac->serie.'-'.$fac->numero }}</td>
                    <td>{{ $fac->ruc }}</td>
                    <td>{{ $fac->cli->razsoc }}</td>
                    <td>{{ $fac->tot_gravadas }}</td>
                    <td>{{ $fac->tot_exoneradas }}</td>
                    <td>{{ $fac->tot_igv }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $fac->total }}</td>
                    <td>
                        @if($fac->moneda == 'PEN')
                            1
                        @else
                            2
                        @endif
                    </td>
                    <td>02</td>
                    <td>FALSO</td>
                    <td>01</td>
                    <td>{{ date("d/m/Y",strtotime($fac->fecha)) }}</td>
                    <td>{{ $fac->dmserie.'-'.$fac->dmnumero }}</td>
                    <td>{{ $fac->dmcomprobante_id }}</td>
                    <td></td>
                    <td>0</td>
                    <td></td>
                    <td></td>
                    <td>Notas Farmacia</td>
                    <td>01</td>
                    <td>1</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        

	</body>
</html>