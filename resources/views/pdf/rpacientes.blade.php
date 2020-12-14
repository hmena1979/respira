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
            <span class="empresa">{{$parametro->razsoc}}</span>
            <h3 class="titulo">REPORTE DE PACIENTES</h3>
        </div>
        {{-- <center><h3>REPORTE DE PACIENTES</h3></center> --}}
        @foreach ($doctores as $doctor)
        <table class="cliente">
            <tr>
            <th class="text-left" width="50%">DOCTOR: {{$doctor->nombre}}</th>
            </tr>
        </table>
        <div class="detalle mbottom16">
            <table>
                {{-- <caption>
                    <h3 class="text-left">DOCTOR: {{$doctor->nombre}}</h3>
                </caption> --}}
                <thead>
                    <tr>
                        <th width="8%">CÓDIGO</th>
                        <th width="30%">NOMBRE</th>
                        <th width="10%">F.NACIM</th>
                        <th width="10%">TELEFONO</th>
                        <th width="20%">e-mail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctor->pac as $paciente)
                    <tr>
                        <td>{{ $paciente->numdoc }}</td>
                        <td>{{ $paciente->razsoc }}</td>
                        <td>{{ $paciente->fecnac }}</td>
                        <td>{{ $paciente->telefono }}</td>
                        <td>{{ $paciente->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
        

	</body>
</html>