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
        <link rel="stylesheet" href="{{ url('/static/css/invoice.css?v='.time()) }}">
	</head>
	<body>
        <table class="titulo">
            <tr>
                <td width="60%">
                    <img class="img" src="{{ url('/static/images/logoinvoice.jpg') }}" width="430">
                </td>
                <td width="40%">
                    <div class="numero text-center">
                        <strong>
                        FACTURA ELECTRÓNICA<br>
                        RUC {{ $parametro->ruc }}<br>
                        N° {{$salida->serie.'-'.$salida->numero}}<br>
                        </strong>

                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="cliente">
                <tr>
                    <td class="tam10 negrita">CLIENTE</td>
                    <td class="tam70">: {{trim($salida->cli->razsoc)}}</td>
                    <td class="tam5 negrita">RUC</td>
                    <td class="tam15">: {{$salida->ruc}}</td>
                </tr>
                <tr>
                    <td class="negrita tam10">DIRECCIÓN</td>
                    <td colspan="3">: {{trim($salida->direccion)}}</td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <td class="tam25"><span class="negrita">FECHA : </span> {{$salida->fecha}}</td>
                    <td class="tam25"><span class="negrita">VENCIMIENTO : </span> {{$salida->vencimiento}}</td>
                    <td class="tam25"><span class="negrita">FORMA PAGO : </span> {{$salida->tipo==1?'CONTADO':'CRÉDITO'}}</td>
                    <td class="tam25"><span class="negrita">MONEDA : </span> {{$salida->mon->nombre}}</td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th width="10%">CANTIDAD</th>
                        <th width="10%">U.M.</th>
                        <th width="50%">DESCRIPCIÓN</th>
                        <th width="10%">VALOR<br>UNITARIO</th>
                        <th width="10%">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detsalidas as $detsalida)
                    <tr>
                        <td>{{ round($detsalida->cantidad,2) }}</td>
                        <td>{{ $detsalida->prod->umedida->sunat}}</td>
                        <td class="text-left">
                            {{ $detsalida->prod->nombre}}
                        </td>
                        <td>{{ $detsalida->precio }}</td>
                        <td>{{ $detsalida->subtotal }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer cuadro mtop5">
            <table>
                <tr>
                    <td class="tam70">
                        <table class="letras">
                            <tr>
                                <td class="borde-inferior" colspan="2">
                                    SON: {{ $letra }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tam10">
                                    <img src="data:image/png;base64,{!! $qrcode !!}" alt="">
                                </td>
                                <td class="tam60 lchicas">
                                    Representación impresa de la Factura de Venta Electrónica. <br>
                                    Autorizado mediante Resolución de Intendencia Nº 279-2019/SUNAT <br>
                                    Puede ser consultada en: {{$parametro->dominio}}/documentos
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="tam30">
                        <table class="totales">
                            <tr>
                                <td class="negrita tam65">GRAVADO @if($salida->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$salida->tot_gravadas}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">INAFECTO @if($salida->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$salida->tot_inafectas}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">EXONERADO @if($salida->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$salida->tot_exoneradas}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">IGV ({{round($parametro->por_igv,2)}}%) @if($salida->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$salida->tot_igv}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">TOTAL @if($salida->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$salida->total}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        @if(strlen($salida->observaciones)>0)
        <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <th class="text-left" width="50%">OBSERVACIONES:</th>
                </tr>
                <tr>
                    <td class="text-left" width="50%">
                        {!! htmlspecialchars_decode(nl2br($salida->observaciones)) !!}
                    </th>
                </tr>
            </table>
        </div>
        @endif
	</body>
</html>