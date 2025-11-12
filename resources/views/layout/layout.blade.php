<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS desde CDN - Framework de estilos para diseño responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Estilos personalizados de la aplicación -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Navbar lateral izquierdo -->
        @include('layout.navbar')
        
        <!-- Contenido principal -->
        <div class="main-content flex-grow-1">
            <!-- Mensajes de éxito y error -->
            @include('layout.alerts')
            
            <!-- Contenido de la página -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JavaScript desde CDN - Necesario para funcionalidades como alertas dismissibles -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Sección para scripts adicionales de las páginas hijas -->
    @yield('scripts')
</body>
</html>

