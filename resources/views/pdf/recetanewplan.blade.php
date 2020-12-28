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
                        <td>{{ $r->nombre }}</td>
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
        {{-- --------------------------------------------------------------------------------------------------------- --}}

        <table class="tituloproc mtop16">
            <tr>
                @if($radio || $ecograf || $tomogra)
                <td class="tam55 table-top">
                    <table class="tam100">
                        <tr>
                            <td class="borde-punteado table-top">
                                <img class="imgplan" src="{{ url('/static/images/logopruebas.jpg') }}" width="330" >
                                <p class="titpaciente">
                                    <span class=""><strong>FECHA: </strong></span>{{$historia->fecha}} <br>
                                    <span class=""><strong>PACIENTE: </strong></span>{{$paciente->razsoc}}
                                </p>
                                <table class="tam100 planes">
                                    <tr>
                                        @if($radio)
                                        <td class=" table-top tam50">
                                            <p class="text-left espaciado30">
                                                <span class="text-left"><u><strong>RADIOGRAFÍAS DIGITALES</strong></u></span>
                                            </p>
                                            <br class="espaciado10">
                                            @if(kvfj($historia->radtorax, 'senpar'))
                                                <p class="espaciado30">(X) SENOS PARANASALES.</p> 
                                            @endif
                                            @if(kvfj($historia->radtorax, 'cavum'))
                                                <p class="espaciado30">(X) CAVUM.</p> 
                                            @endif
                                            @if(kvfj($historia->radtorax, 'torax'))
                                                <p class="espaciado30">(X) TORAX.</p> 
                                            @endif
                                            @if(kvfj($historia->radtorax, 'parrcostal'))
                                                <p class="espaciado30">(X) PARRILLA COSTAL.</p> 
                                            @endif
                                            @if(kvfj($historia->radtorax, '1incidencia') || kvfj($historia->radtorax, 'frontal') || kvfj($historia->radtorax, 'lateral')
                                                || kvfj($historia->radtorax, '2incidencia'))
                                                <p class="espaciado30">PARA CADA CASO MARCAR</p> 
                                                <p class="espaciado30 ml-3">A) Una incicencia (@if(kvfj($historia->radtorax, '1incidencia')) X @else &nbsp; @endif)</p>
                                                <p class="espaciado30 ml-10">
                                                    <span>(@if(kvfj($historia->radtorax, 'frontal')) X @else &nbsp; @endif) Frontal</span>
                                                    <span class="ml-10">(@if(kvfj($historia->radtorax, 'lateral')) X @else &nbsp; @endif) Lateral</span>
                                                </p>
                                                <p class="espaciado30 ml-3">B) Dos incicencias (@if(kvfj($historia->radtorax, '2incidencia')) X @else &nbsp; @endif)</p>
                                            @endif
                                            @if(kvfj($historia->radtorax, 'otpradio'))
                                                <p class="espaciado30">(X) {{kvfj($historia->radtorax, 'otpradio')}} .</p> 
                                            @endif
                                            
                                        </td>
                                        @endif
                                        @if($tomogra)
                                        <td class="table-top tam50">
                                            <p class="text-left espaciado30">
                                                <span class="text-left"><u><strong>TOMOGRAFÍAS</strong></u></span>
                                            </p>
                                            <br class="espaciado10">
                                            @if(kvfj($historia->tomografia, 'ccontraste') || kvfj($historia->tomografia, 'scontraste'))
                                            <p class="espaciado30 text-left">
                                                <span>(@if(kvfj($historia->tomografia, 'ccontraste')) X @else &nbsp; @endif)Con contraste</span>
                                                <span class="ml-3">(@if(kvfj($historia->tomografia, 'scontraste')) X @else &nbsp; @endif)Sin contraste</span>
                                            </p>
                                            @endif
                                            @if(kvfj($historia->tomografia, 'sparanasal'))
                                                <p class="espaciado30">(X) SENOS PARANASALES.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'cuello'))
                                                <p class="espaciado30">(X) CUELLO.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'ttorax'))
                                                <p class="espaciado30">(X) TORAX.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'tpm'))
                                                <p class="espaciado30">(X) Torax o Pulmones y mediastino.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'tar'))
                                                <p class="espaciado30">(X) Torax alta resolución.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'ptpc'))
                                                <p class="espaciado30">(X) Pared Toráxica (Parrilla Costal).</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'vas3d'))
                                                <p class="espaciado30">(X) Vías Aereas Superiores(3D).</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'angiotem'))
                                                <p class="espaciado30">(X) ANGIOTEM.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'toraxico'))
                                                <p class="espaciado30">(X) Toráxico.</p> 
                                            @endif
                                            @if(kvfj($historia->tomografia, 'otptomografia'))
                                                <p class="espaciado30">(X) {{kvfj($historia->tomografia, 'otptomografia')}} .</p> 
                                            @endif

                                        </td>
                                        @endif
                                    </tr>
                                </table>
                                @if(kvfj($historia->radtorax, 'ecografia') || kvfj($historia->radtorax, 'ecotex') || kvfj($historia->radtorax, 'dpresuntivo')
                                    || kvfj($historia->radtorax, 'dclinico'))
                                <table class="tam100 planes">
                                    <tr>
                                        <td class="table-top tam50">
                                            <p class="text-left espaciado30">
                                                <span class="text-left"><u><strong>(@if(kvfj($historia->radtorax, 'ecografia')) X @else &nbsp; @endif) ECOGRAFÍA:</strong></u></span>
                                            </p>
                                            @if(kvfj($historia->radtorax, 'ecotex'))
                                            <p class="text-left espaciado30">
                                                <p class="espaciado30">{{kvfj($historia->radtorax, 'ecotex')}} .</p> 
                                            </p>
                                            @endif
                                            @if(kvfj($historia->radtorax, 'dpresuntivo'))
                                            <p class="text-left espaciado30">
                                                <p class="espaciado30">Diagnóstico Presuntivo: {{kvfj($historia->radtorax, 'dpresuntivo')}} .</p> 
                                            </p>
                                            @endif
                                            @if(kvfj($historia->radtorax, 'dclinico'))
                                            <p class="text-left espaciado30">
                                                <p class="espaciado30">Datos Clínicos: {{kvfj($historia->radtorax, 'dclinico')}} .</p> 
                                            </p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @endif
                                <table class="footertablaplan mtop16">
                                    <tr>
                                        <td>
                                            <p class="espaciado30">
                                                Citas: Telf.: 073-600195 / Cel.: 995303715
                                            </p>
                                            <p class="espaciado30">
                                                JR PROCER MENDIBURO N° 203 URB CLUB GRAU - PIURA
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            
                        </tr>
                    </table>
                    
                </td>
                @endif
                @if($espiro)
                <td class="tam45 table-top">
                    <table class="tam100">
                        <tr>
                            <td class="borde-punteado table-top">
                                <img class="imgplan" src="{{ url('/static/images/logopruebas.jpg') }}" width="310" >
                                <p class="titpaciente">
                                    <span class=""><strong>FECHA: </strong></span>{{$historia->fecha}} <br>
                                    <span class=""><strong>PACIENTE: </strong></span>{{$paciente->razsoc}}
                                </p>
                                <table class="tam100 planes">
                                    <tr>
                                        <td class="table-top">
                                            <p class="text-left espaciado30">
                                                <span class="text-left"><u><strong>SOLICITUD DE PRUEBAS DE FUNCIÓN RESPIRATORIA</strong></u></span>
                                            </p>
                                            <br class="espaciado10">
                                            @if(kvfj($historia->espirometria, 'esimple'))
                                                <p class="espaciado30">(X) ESPIROMETRÍA SIMPLE.</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'emb'))
                                                <p class="espaciado30">(X) ESPIROMETRÍA MAS BRONCODILATACIÓN.</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'tc'))
                                                <p class="espaciado30">(X) TEST DE CAMINATA.</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'on'))
                                                <p class="espaciado30">(X) OXIMETRIA NOCTURNA.</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'pmd'))
                                                <p class="espaciado30">(X) PLETISMOGRAFÍA + DLCO.</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'flujo'))
                                                <p class="espaciado30">(X) FLUJOMETRÍA.</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'opruebas'))
                                                <p class="espaciado30">(X) {{kvfj($historia->espirometria, 'opruebas')}} .</p> 
                                            @endif
                                            @if(kvfj($historia->espirometria, 'esimple') || kvfj($historia->espirometria, 'emb'))
                                            <p class="espaciado30">
                                                <span class="text-left"><u><strong>Recomendaciones para Espirometría:</strong></u></span>
                                                <ul>
                                                    <li class="ml-10" type="square">Acudir sin haber utilizado inhaladores o Broncodilatadores al menos 8 horas antes de la prueba.</li>
                                                    <li class="ml-10" type="square">No es necesario estar en ayunas.</li>
                                                </ul>
                                            </p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <table class="footertablaplan mtop16">
                                    <tr>
                                        <td>
                                            <p class="espaciado30">
                                                Citas: Telf.: 073-600195 / Cel.: 995303715
                                            </p>
                                            <p class="espaciado30">
                                                JR PROCER MENDIBURO N° 203 URB CLUB GRAU - PIURA
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                @else
                <td class="tam45 table-top"></td>
                @endif
                @if(!($radio || $ecograf || $tomogra))
                <td class="tam55 table-top">

                </td>
                @endif
            </tr>
        </table>
	</body>
</html>