@extends('layouts.layoutAuth.layoutAuth')   

@section('title', 'Scrum')

@section('css')

@endsection

@section('content')
    <div class="row m-0 align-items-center bg-white vh-100">            
        <div class="col-md-6">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                    <div class="card-body">
                        <a href="../../dashboard/index.html" class="navbar-brand d-flex align-items-center mb-3">
                            <!--Logo start-->
                            <!--logo End-->
                            
                            <!--Logo start-->
                            <div class="logo-main">
                                <div class="logo-normal">
                                    <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="logo-mini">
                                    <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                                    </svg>
                                </div>
                            </div>
                            <!--logo End-->
                            
                            
                            
                            
                            <h4 class="logo-title ms-3">Scrum</h4>
                        </a>
                        <h2 class="mb-2 text-center">Bienvenido a Scrum</h2>
                        <p class="text-center">Inicia sesion o registrate</p>
                        <form role="form" id="formLogin" action="{{ route('authLogin') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Correo</label>
                                    <input type="email" class="form-control" name="email" id="email" aria-describedby="email" placeholder=" ">
                                </div>
                                </div>
                                <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder=" ">
                                </div>
                                </div>
                                <div class="col-lg-12 d-flex justify-content-between">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                    <label class="form-check-label" for="customCheck1">Recuerdame</label>
                                </div>
                                <a href="{{ route('recoverypw') }}">Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Iniciar sesion</button>
                            </div>
                            <p class="mt-3 text-center">
                                No tienes una cuenta? <a href="{{ route('register') }}" class="text-underline">Haz click aquí para crear una.</a>
                            </p>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <div class="sign-bg">
                <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.05">
                    <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"/>
                    <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"/>
                    <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"/>
                    <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
            <img src="../../assets/images/auth/01.png" class="img-fluid gradient-main animated-scaleX" alt="images">
        </div>
    </div>
@endsection

@section('js')
    <script>

        $(document).ready(function() {
            $('#formLogin').submit(function(e) {
            e.preventDefault();

            // Validar que todos los campos estén completos
            var email = $('#email').val().trim();
            var password = $('#password').val().trim();

            if (email === '' || password === '') {
                Swal.fire({
                title: 'Completa todos los campos',
                icon: 'warning',
                position: 'top-end',
                toast: true,
                showConfirmButton: false,
                timer: 3000
                });
                return;
            }

            Swal.fire({
                title: 'Iniciando sesión...',
                icon: 'info',
                position: 'top-end',
                toast: true,
                showConfirmButton: false,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                    title: 'Inicio de sesión exitoso',
                    icon: 'success',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                    });
                    setTimeout(function() {
                    window.location.href = '/dashboard'; 
                    }, 1700);
                } else {
                    Swal.fire({
                    title: response.message,
                    icon: response.icon,
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                    });
                }
                }
            });
            });
        });

        // Envuelve el input de password en un contenedor con posición relativa
        $('#password').closest('.form-group').css('position', 'relative');

        // Agrega el icono del ojo dentro del input
        $('#password').after(`
            <span id="togglePassword" style="position: absolute; right: 20px; top: 38px; cursor: pointer; z-index: 2;">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                <path d="M8 5a3 3 0 0 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
            </span>
        `);

        // Ajusta el padding del input para que no tape el icono
        $('#password').css('padding-right', '40px');

        $('#togglePassword').on('click', function() {
            var passwordInput = $('#password');
            var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);

            // Cambia el icono del ojo
            $(this).html(type === 'password'
            ? `<svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                <path d="M8 5a3 3 0 0 0 0 6 3 3 0 0 0 0-6z"/>
                </svg>`
            : `<svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13.359 11.238l2.122 2.122a.5.5 0 0 1-.708.708l-2.122-2.122A7.027 7.027 0 0 1 8 13.5c-5 0-8-5.5-8-5.5a13.134 13.134 0 0 1 2.478-3.197l-1.147-1.147a.5.5 0 1 1 .708-.708l13 13a.5.5 0 0 1-.708.708l-1.147-1.147z"/>
                </svg>`
            );
        });
    </script>
@endsection
