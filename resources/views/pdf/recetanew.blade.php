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
        <link rel="stylesheet" href="{{ url('/static/css/receta.css?v='.time()) }}">
	</head>
	<body>
        <table class="titulo">
            <tr>
                <td width="60%">
                    <img class="img" src="{{ url('/static/images/logoinvoice.jpg') }}" width="430" height="140">
                </td>
                <td width="40%">
                    <div class="numero">
                        <span>RECETA MEDICA</span><br>
                        FECHA: {{$historia->fecha}}<br>
                        N° {{$paciente->historia.$historia->item}}<br>
                    </div>
                </td>
            </tr>
        </table>
        {{-- <div class="cuadro">
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
        </div> --}}
        <div class="cuadro">
            <table class="cliente">
                <tr>
                    <th class="text-left" width="50%">PACIENTE</th>
                    <th class="text-left" width="50%">MÉDICO</th>
                </tr>
            </table>
            <table class="cliente">
                <tr>
                    <td class="tam50"><span class="negrita">DOCUMENTO N°: </span> {{$paciente->numdoc}}</td>
                    <td class="tam50"><span class="negrita">NOMBRE: </span> {{$doctor->nombre}}</td>
                </tr>
                <tr>
                    <td class="tam50"><span class="negrita">NOMBRE: </span> {{$paciente->razsoc}}</td>
                    <td class="tam50">
                        <span class="negrita">ESPECIALIDAD: </span> {{$doctor->especialidad}}
                    </td>
                </tr>
                <tr>
                    <td class="tam50"><span class="negrita">EDAD: </span> {{\Carbon\Carbon::parse($paciente->fecnac)->age}} años</td>
                    <td class="tam50">
                        <span class="negrita"> CMP: </span> {{$doctor->cmp}}
                        <span class="negrita"> RNE: </span> {{$doctor->rne}}
                    </td>
                </tr>
            </table>
        </div>
        {{-- <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <td class="tam25"><span class="negrita">FECHA : </span> {{$nota->fecha}}</td>
                    <td class="tam25"><span class="negrita">VENCIMIENTO : </span> {{$nota->vencimiento}}</td>
                    <td class="tam25"><span class="negrita">MONEDA : </span> {{$nota->mon->nombre}}</td>
                    <td class="tam25"><span class="negrita"> </span> </td>
                </tr>
            </table>
        </div> --}}
        
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th width="30%">PRODUCTO</th>
                        <th width="10%">PRESENTACIÓN</th>
                        <th width="10%">CANTIDAD</th>
                        <th width="35%">INDICACIONES</th>
                        <th width="15%">TIEMPO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recetas as $r)
                    <tr>
                        <td>{{ $r->nombre }}<br><span class="letchica">{{$r->composicion}}</span></td>
                        <td class="text-center">{{ $r->um->nombre }}</td>
                        <td class="text-center">{{ round($r->cantidad,2) }}</td>
                        <td>
                            {{ $r->posologia.' '
                            .$r->pmed->nombre.' '
                            .$r->pfre->nombre }}<br>{{$r->recomendacion}}
                        </td>
                        <td>{{ $r->postie.' '.$r->ptie->nombre }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(kvfj($historia->receta, 'rbt') || kvfj($historia->receta, 'rotros') || kvfj($historia->receta, 'efrio')||kvfj($historia->receta, 'epolvo')||kvfj($historia->receta, 'ehumo')
        ||kvfj($historia->receta, 'ecitricos')||kvfj($historia->receta, 'eenvasados')||kvfj($historia->receta, 'eanimales')
        ||kvfj($historia->receta, 'ecolorantes')||kvfj($historia->receta, 'eotros'))
        <div class="cuadro">
            <table class="cliente">
                <tr>
                    <th class="text-left" width="50%">RECOMENDACIONES:</th>
                    <th class="text-left" width="50%">EVITAR:</th>
                </tr>
            </table>
            <table class="cliente">
                <tr>
                    <td class="tam50">
                        @if(kvfj($historia->receta, 'rbt'))
                            BEBIDAS TIBIAS,
                        @endif
                        @if(kvfj($historia->receta, 'rotros'))
                            {{kvfj($historia->receta, 'rotros')}}.
                        @endif
                    </td>
                    <td class="tam50">
                        @if(kvfj($historia->receta, 'efrio'))
                            FRÍO, 
                        @endif
                        @if(kvfj($historia->receta, 'epolvo'))
                            POLVO, 
                        @endif
                        @if(kvfj($historia->receta, 'ehumo'))
                            HUMO, 
                        @endif
                        @if(kvfj($historia->receta, 'ecitricos'))
                            CÍTRICOS, 
                        @endif
                        @if(kvfj($historia->receta, 'eenvasados'))
                            ENVASADOS.
                        @endif
                        @if(kvfj($historia->receta, 'eanimales'))
                            ANIMALES, 
                        @endif
                        @if(kvfj($historia->receta, 'ecolorantes'))
                            COLORANTES, 
                        @endif
                        @if(kvfj($historia->receta, 'eotros'))
                            {{kvfj($historia->receta, 'eotros')}}.
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        @endif
        <div class="cuadro">
            <table class="cliente">
                <tr>
                    <td class="tam10">
                        <div class="qr">
                            <img src="data:image/png;base64,{!! $qrcode !!}" alt="">
                        </div>
                    </td>
                    <td class="tam50">
                        <div class="qrtext">
                            Puede validar esta receta en:<br>
                            {{$parametro->dominio}}/receta<br>
                            Código: <strong>{{$paciente->historia}}{{$historia->item}}</strong>
                        </div>
                    </td>
                    <td class="tam40">
                        @if(!empty($historia->pfecha))
                        <div class="pcita">
                            @if($historia->ptipo == '1')CITA: @ELSE CONTROL: @ENDIF <strong> {{$historia->pfecha}}</strong>
                        </div>
                        @ENDIF
                        <div class="telfcita">
                            {{-- Teléfono: {{ $doctor->telefono }} / Celular: {{ $doctor->celular }} --}}
                            Citas: Telf.: 073-600195<br>
                            Cel.: 995303715<br>
                            Farmacia: Tel.: 073-600187

                        </div>
                        
                    </td>
                </tr>
            </table>
        </div>


        
        
        {{-- <div class="footer cuadro mtop5">
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
                                    Representación impresa de la Nota de Crédito de Venta Electrónica. <br>
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
        @endif --}}
	</body>
</html>