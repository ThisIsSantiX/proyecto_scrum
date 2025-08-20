<!DOCTYPE html>
<html lang="en">
    <head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Scrum')</title>

        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

        <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/aos/dist/aos.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        

        @yield('css')
    </head>
    <body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">

        <div id="loading">
            <div class="loader simple-loader">
                <div class="loader-body"></div>
            </div>    
        </div>

        <div class="wrapper">
            <section class="login-content">
                @yield('content')
            </section>
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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

        @yield('js')
    </body>
</html>