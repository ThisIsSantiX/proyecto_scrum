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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        @yield('css')
    </head>
    <body class=" ">
        <div class="position-relative iq-banner">
            <div id="loading">
                <div class="loader simple-loader">
                    <div class="loader-body"></div>
                </div>    
            </div>

            @include('layouts.layout.components.sidebar')

            <div class="flex-1 flex flex-col">
                @include('layouts.layout.components.navbar')

                <main class="container-fluid bg-body-secondary bg-gradient min-vh-100">
                    <div class="mt-5">
                            @yield('content')
                    </div>
                </main>

            </div>
        </div>

        
        <style>
            
            .icon-21 {
                height: 2rem;
                width: 1.9rem;
            }

            .dropdown-toggle::after {
                display: none !important;
            
            }

            .navbar {
                background-color: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            #loading {
                position: fixed;      /* Se queda fijo en la pantalla */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9); /* Fondo blanco semitransparente */
                z-index: 9999;        /* Encima de todo */
                display: flex;
                justify-content: center;
                align-items: center;
            }

            body.dark #loading {
                background: rgba(0, 0, 0, 0.9);
            }


        </style>
        
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const body = document.body;
                const toggleBtn = document.getElementById("darkModeToggle");
                const moonIcon = document.getElementById("moonIcon");
                const sunIcon = document.getElementById("sunIcon");

                function applyTheme(isDark, save = false) {
                    if (isDark) {
                        body.classList.add("dark");
                        moonIcon.style.display = "none";
                        sunIcon.style.display = "block";
                        if (save) localStorage.setItem("theme", "dark");
                    } else {
                        body.classList.remove("dark");
                        moonIcon.style.display = "block";
                        sunIcon.style.display = "none";
                        if (save) localStorage.setItem("theme", "light");
                    }
                }   

                const savedTheme = localStorage.getItem("theme");
                if (savedTheme) {
                    applyTheme(savedTheme === "dark");
                } else {
                    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");
                    applyTheme(prefersDark.matches);

                    prefersDark.addEventListener("change", e => {
                        if (!localStorage.getItem("theme")) {
                            applyTheme(e.matches);
                        }
                    });
                }

                toggleBtn.addEventListener("click", e => {
                    e.preventDefault();
                    const isDark = !body.classList.contains("dark");
                    applyTheme(isDark, true);
                });
            });

            // document.addEventListener("DOMContentLoaded", function () {
            //     const sidebar = document.querySelector("aside.sidebar");
            //     const toggleBtn = document.getElementById("sidebar-toggle");

            //     if (!sidebar || !toggleBtn) return;

            //     sidebar.style.transition = "none";

            //     if (localStorage.getItem("sidebar") === "closed") {
            //         sidebar.classList.add("sidebar-mini");
            //     } else {
            //         sidebar.classList.remove("sidebar-mini");
            //     }

            //     setTimeout(() => {
            //         sidebar.style.transition = "";
            //     }, 100);

            //     toggleBtn.addEventListener("click", function () {
            //         sidebar.classList.toggle("sidebar-mini");

            //         if (sidebar.classList.contains("sidebar-mini")) {
            //             localStorage.setItem("sidebar", "closed");
            //         } else {
            //             localStorage.setItem("sidebar", "open");
            //         }
            //     });
            // });

            $(window).on("load", function () {
                $("#loading").fadeOut("slow"); // Animación suave para ocultar
            });
            
        </script>


        @yield('js')
    </body>
</html>
