<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset('img/icono.ico') }}">

    <!-- Estilos de bootstrap -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="css">
    <!-- Estilos css generales -->
    <link href="{{asset('css/base/css/general.css') }}" rel="stylesheet">
    <link href="{{asset('css/base/css/menu.css') }}" rel="stylesheet">
    <link href="{{asset('css/base/css/footer.css') }}" rel="stylesheet">

    <!-- Estilos cambiantes -->
    @yield('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
</head>

<body>

    <div class="content">
        <!-- Incluir menú -->
        @include('layouts.menu')
        <section class="section">
         @yield('content')  
        </section>

        <!-- Incluir footer -->
    </div>
    @include('layouts.footer')
    @yield('scripts')
    <!-- Scripts de bootstrap -->
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>