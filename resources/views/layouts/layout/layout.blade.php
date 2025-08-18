<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>@yield('title', 'Scrum')</title>

        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

        <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/aos/dist/aos.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />

        @yield('css')
    </head>
    <body class="   ">
        <div class="position-relative iq-banner">
            <div id="loading">
                <div class="loader simple-loader">
                    <div class="loader-body"></div>
                </div>    </div>

            @include('layouts.layout.components.sidebar')

            <div class="flex-1 flex flex-col">
                @include('layouts.layout.components.navbar')

                <main class="container-fluid">
                    @yield('content')
                </main>
            </div>
        </div>
        
        <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/external.min.js') }}"></script>
        <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>
        <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
        <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/setting.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/dist/aos.js') }}"></script>
        <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

        @yield('js')
    </body>
</html>
