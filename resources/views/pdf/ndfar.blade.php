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
                        NOTA DE DÉBITO ELECTRÓNICA<br>
                        RUC {{ $parametro->ruc }}<br>
                        N° {{$nota->serie.'-'.$nota->numero}}<br>
                        </strong>

                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="cliente">
                <tr>
                    <td class="tam10 negrita">CLIENTE</td>
                    <td class="tam70">: {{trim($nota->cli->razsoc)}}</td>
                    <td class="tam5 negrita">RUC</td>
                    <td class="tam15">: {{$nota->ruc}}</td>
                </tr>
                <tr>
                    <td class="negrita tam10">DIRECCIÓN</td>
                    <td colspan="3">: {{trim($nota->direccion)}}</td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <td class="tam25"><span class="negrita">FECHA : </span> {{$nota->fecha}}</td>
                    <td class="tam25"><span class="negrita">VENCIMIENTO : </span> {{$nota->vencimiento}}</td>
                    <td class="tam25"><span class="negrita">MONEDA : </span> {{$nota->mon->nombre}}</td>
                    <td class="tam25"><span class="negrita"> </span> </td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <th class="text-left" width="50%">DOCUMENTO QUE MODIFICA:</th>
                </tr>
            </table>
            <table class="cliente">
                <tr>
                    <td class="tam30"><span class="negrita">COMPROBANTE : </span> {{$nota->dmcomp->nombre}}</td>
                    <td class="tam25"><span class="negrita">NÚMERO : </span> {{$nota->dmserie.'-'.$nota->dmnumero}}</td>
                    <td class="tam45"><span class="negrita">MOTIVO : </span> {{$nota->dmdescripcion}}</td>
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
                    @foreach($detnotas as $detnota)
                    <tr>
                        <td>{{ round($detnota->cantidad,2) }}</td>
                        <td>{{ $detnota->prod->umedida->sunat}}</td>
                        <td class="text-left">
                            {{ $detnota->prod->nombre}}
                        </td>
                        <td>{{ $detnota->precio }}</td>
                        <td>{{ $detnota->subtotal }}</td>
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
                                    Representación impresa de la Nota de Débito de Venta Electrónica. <br>
                                    Autorizado mediante Resolución de Intendencia Nº 279-2019/SUNAT <br>
                                    Puede ser consultada en: {{$parametro->dominio}}/documentos
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="tam30">
                        <table class="totales">
                            <tr>
                                <td class="negrita tam65">GRAVADO @if($nota->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$nota->tot_gravadas}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">INAFECTO @if($nota->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$nota->tot_inafectas}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">EXONERADO @if($nota->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$nota->tot_exoneradas}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">IGV ({{round($parametro->por_igv,2)}}%) @if($nota->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$nota->tot_igv}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">TOTAL @if($nota->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{$nota->total}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        @if(strlen($nota->observaciones)>0)
        <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <th class="text-left" width="50%">OBSERVACIONES:</th>
                </tr>
                <tr>
                    <td class="text-left" width="50%">
                        {!! htmlspecialchars_decode(nl2br($nota->observaciones)) !!}
                    </th>
                </tr>
            </table>
        </div>
        @endif
	</body>
</html>