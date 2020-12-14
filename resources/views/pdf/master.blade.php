<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Centro Neumologico de Norte Respira SAC, tratamiento de enfermedades respiratorias"/>
        <meta name="keywords" content="Centro Neumológico, Respira, asma, enfermedades respiratorias, neumologia Piura"/>
        <title>@yield('title')</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="routeName" content="{{ Route::currentRouteName() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url('/static/css/pdf.css?v='.time()) }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
	</head>
	<body>
        @section('content')
        @show
	</body>
</html>