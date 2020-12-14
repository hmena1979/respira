@extends('pdf.master')
@section('title','Respira')


@section('content')
<div class="fila">
    <div class="col-5">
        {{--
        <div class="titulo text-center">
            <strong>{{$doctor->nombre}}</strong><br>
            <strong>{{$doctor->especialidad}}</strong><br>
            <strong>CMP: {{$doctor->cmp}} RNE: {{$doctor->rne}}</strong><br>
        </div>
        --}}
    </div>
    <div class="col-5">

    </div>
</div>
<div class="detalle">
    <strong>Paciente:</strong> {{$paciente->numdoc}} - {{$paciente->razsoc}}
    <table class="table table-sm">
        <thead class="thead-light">
            <tr>
                <th width="30%">Producto</th>
                <th width="10%">Presentación</th>
                <th width="10%">Cantidad</th>
                <th width="35%">Indicaciones</th>
                <th width="15%">Tiempo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recetas as $r)
            <tr>
                <td>{{ $r->nombre }}</td>
                <td>{{ $r->um->nombre }}</td>
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
<div class="final">
    <div class="fila">
        <div class="col-5">
            <div class="qr">
                <img src="data:image/png;base64,{!! $qrcode !!}" alt="">
            </div>
            <div class="qrtext">
                Puede validar esta receta en:<br>
                www.cnnrespira.com/receta<br>
                Código: <strong>{{$paciente->historia}}{{$historia->item}}</strong>
            </div>
        </div>
        <div class="col-5">
            <div class="recomensaciones ml-5">
                @if($historia->ptipo == '1')CITA: @ELSE CONTROL: @ENDIF <strong> {{$historia->pfecha}}</strong>
            </div>            
            @if(kvfj($historia->receta, 'rbt') || kvfj($historia->receta, 'rotros'))
            <div class="recomendaciones ml-5">
                <strong>Recomendaciones:</strong><br>
                @if(kvfj($historia->receta, 'rbt'))
                <div class="rec">
                    - Bebidas tibias.
                </div>
                @endif
                @if(kvfj($historia->receta, 'rotros'))
                <div class="rec">
                    - {{kvfj($historia->receta, 'rotros')}}
                </div>
                @endif
            </div>
            @endif
            @if(kvfj($historia->receta, 'efrio')||kvfj($historia->receta, 'epolvo')||kvfj($historia->receta, 'ehumo')
                ||kvfj($historia->receta, 'ecitricos')||kvfj($historia->receta, 'eenvasados')||kvfj($historia->receta, 'eanimales')
                ||kvfj($historia->receta, 'ecolorantes')||kvfj($historia->receta, 'eotros'))
            <div class="recomendaciones ml-5 mtop16">
                <strong>Evitar:</strong><br>
                @if(kvfj($historia->receta, 'efrio'))
                <div class="rec">
                    - Frío.
                </div>
                @endif
                @if(kvfj($historia->receta, 'epolvo'))
                <div class="rec">
                    - Polvo.
                </div>
                @endif
                @if(kvfj($historia->receta, 'ehumo'))
                <div class="rec">
                    - Humo.
                </div>
                @endif
                @if(kvfj($historia->receta, 'ecitricos'))
                <div class="rec">
                    - Cítricos.
                </div>
                @endif
                @if(kvfj($historia->receta, 'eenvasados'))
                <div class="rec">
                    - Envasados.
                </div>
                @endif
                @if(kvfj($historia->receta, 'eanimales'))
                <div class="rec">
                    - Animales.
                </div>
                @endif
                @if(kvfj($historia->receta, 'ecolorantes'))
                <div class="rec">
                    - Colorantes.
                </div>
                @endif
                @if(kvfj($historia->receta, 'eotros'))
                <div class="rec">
                    - {{kvfj($historia->receta, 'eotros')}}
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
{{--
<div class="footer text-right">
    Teléfono: {{ $doctor->telefono }} / Celular: {{ $doctor->celular }}
</div>
--}}
@endsection