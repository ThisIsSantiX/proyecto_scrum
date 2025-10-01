<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>@yield('title', 'WorkScrum')</title>

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
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Source+Sans+Pro:wght@600&display=swap');

            h1, h2, h3, h4, h5 {
                font-family: 'Source Sans Pro', sans-serif;
                font-weight: 600;
            }

            body, p, span, li {
                font-family: 'Roboto', sans-serif;
                font-weight: 400;
            }

        </style>
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

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const body = document.body;
                const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");

                if (prefersDark.matches) {
                    body.classList.add("dark");
                } else {
                    body.classList.remove("dark");
                }

                prefersDark.addEventListener("change", e => {
                    if (e.matches) {
                        body.classList.add("dark");
                    } else {
                        body.classList.remove("dark");
                    }
                });
            });
        </script>


        @yield('js')
    </body>
</html>