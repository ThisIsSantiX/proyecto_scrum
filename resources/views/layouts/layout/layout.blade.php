<!DOCTYPE html>
<html lang="es">

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


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
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Source+Sans+Pro:wght@600&display=swap');

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Source Sans Pro', sans-serif;
            font-weight: 600;
        }

        body,
        p,
        span,
        li {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }


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
            position: fixed;
            /* Se queda fijo en la pantalla */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            /* Fondo blanco semitransparente */
            z-index: 9999;
            /* Encima de todo */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body.dark .modal-content {
            background-color: #1e1e2d !important;
            /* fondo oscuro */
            color: #f8f9fa !important;
        }

        body.dark .modal-header,
        body.dark .modal-footer {
            background-color: #1e1e2d !important;
            color: #f8f9fa !important;
            border-color: #2c2c40 !important;
        }

        body.dark .modal-body {
            background-color: #1e1e2d !important;
            color: #f8f9fa !important;
        }

        body.dark .modal-body .form-control,
        body.dark .modal-body .form-select {
            background-color: #2a2a3d !important;
            color: #f8f9fa !important;
            border: 1px solid #44475a !important;
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
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

        window.addEventListener("load", () => {
            setTimeout(() => {
                const sidebar = document.querySelector("aside.sidebar");

                if (!sidebar) {
                    console.warn("No se encontró el sidebar");
                    return;
                }

                const savedState = localStorage.getItem("sidebar") || "open";

                if (savedState === "closed") {
                    sidebar.classList.add("sidebar-mini");
                } else {
                    sidebar.classList.remove("sidebar-mini");
                }

                // ===== Guardar estado cuando cambie =====
                const observer = new MutationObserver(() => {
                    const isClosed = sidebar.classList.contains("sidebar-mini");
                    localStorage.setItem("sidebar", isClosed ? "closed" : "open");
                });

                observer.observe(sidebar, {
                    attributes: true,
                    attributeFilter: ['class']
                });

                document.addEventListener('click', (e) => {
                    if (e.target.closest('[data-toggle="sidebar"]')) {
                        setTimeout(() => {
                            const isClosed = sidebar.classList.contains("sidebar-mini");
                            localStorage.setItem("sidebar", isClosed ? "closed" : "open");
                        }, 50);
                    }
                });

            }, 300);
        });

        $(window).on("load", function() {
            $("#loading").fadeOut("slow");
        });

        $(document).ready(function() {
            let recientesLoaded = false;

            function cargarRecientesSidebar(force = false) {
                const lista = $('#listaRecientes');
                const loadingLi = $('#loadingRecientesLi');
                const noRecientesLi = $('#noRecientesLi');

                if (lista.length === 0) return;
                if (recientesLoaded && !force) return;

                lista.empty();
                noRecientesLi.addClass('d-none');
                loadingLi.removeClass('d-none');

                axios.get('{{ route("proyectos.recientes") }}')
                    .then(function(response) {
                        loadingLi.addClass('d-none');
                        if (response.data.success && response.data.data.length > 0) {
                            noRecientesLi.addClass('d-none');
                            response.data.data.forEach(proj => {
                                lista.append(`
                                <li class="nav-item">
                                    <a class="nav-link link-reciente"
                                       href="/proyectos/backlog/${proj.uid}"
                                       data-uid="${proj.uid}">
                                        <i class="sidenav-mini-icon">•</i>
                                        <span class="item-name">${proj.nombre}</span>
                                    </a>
                                </li>
                            `);
                            });
                            recientesLoaded = true;
                        } else {
                            noRecientesLi.removeClass('d-none');
                            recientesLoaded = true;
                        }
                    })
                    .catch(function(error) {
                        loadingLi.addClass('d-none');
                        noRecientesLi.removeClass('d-none');
                    });
            }

            $(document).on('show.bs.collapse', '#recent-projects', function() {
                cargarRecientesSidebar();
            });

            if ($('#recent-projects').hasClass('show')) {
                cargarRecientesSidebar();
            }

            $(document).on('click', '.link-reciente', function() {
                const uid = $(this).data('uid');
                axios.post(`/proyectos/${uid}/registrar-acceso`)
                    .then(() => cargarRecientesSidebar(true))
                    .catch(err => console.error(err));
            });
        });
    </script>


    @yield('js')
</body>

</html>