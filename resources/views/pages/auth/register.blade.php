@extends('layouts.layoutAuth.layoutAuth')   

@section('title', 'Scrum')

@section('css')
    <style>
        .form-group {
            position: relative;
        }

        .form-group .form-control {
            padding-right: 40px; 
        }

        .form-group .togglePassword {
            position: absolute;
            top: 38px; 
            right: 15px;
            cursor: pointer;
            z-index: 2;
        }

    </style>
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
                        <p class="text-center">Crea una cuenta</p>
                        <form id="registerForm" action="route{{ ('register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="full-name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="full-name" placeholder="Cesar" required>
                                        <div class="invalid-feedback">El nombre es obligatorio</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="last-name" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="last-name" placeholder="Yepes" required>
                                        <div class="invalid-feedback">El apellido es obligatorio</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Correo</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
                                        <div class="invalid-feedback">Debes ingresar un correo válido</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required minlength="8">
                                        <div class="invalid-feedback">Mínimo 8 caracteres</div>
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group position-relative">
                                        <label for="confirm-password" class="form-label">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="••••••••" required>
                                        <div class="invalid-feedback">Las contraseñas no coinciden</div>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Crear Cuenta</button>
                            </div>
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
        

        $(document).ready(function () {
            const notyf = new Notyf({
                duration: 3000,
                position: { x: 'right', y: 'top' }
            });

            $("#registerForm").on("submit", function (e) {
                e.preventDefault();

                $(".form-control").removeClass("is-invalid");

                let data = {
                    nombre: $("#full-name").val(),
                    apellido: $("#last-name").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    password_confirmation: $("#confirm-password").val(),
                };

                axios.post("{{ route('register') }}", data)
                    .then(function (response) {
                        notyf.success(response.data.message);

                        setTimeout(() => {
                            window.location.href = "/auth/login";
                        }, 2000);
                    })
                    .catch(function (error) {
                        if (error.response && error.response.status === 422) {
                            let errors = error.response.data.errors;

                            if (errors.nombre) {
                                $("#full-name").addClass("is-invalid")
                                    .siblings(".invalid-feedback").text(errors.nombre[0]);
                            }
                            if (errors.apellido) {
                                $("#last-name").addClass("is-invalid")
                                    .siblings(".invalid-feedback").text(errors.apellido[0]);
                            }
                            if (errors.email) {
                                $("#email").addClass("is-invalid")
                                    .siblings(".invalid-feedback").text(errors.email[0]);
                            }
                            if (errors.password) {
                                $("#password").addClass("is-invalid")
                                    .siblings(".invalid-feedback").text(errors.password[0]);
                                $("#confirm-password").addClass("is-invalid")
                                    .siblings(".invalid-feedback").text(errors.password[0]);
                            }

                            notyf.error("Revisa los campos marcados en rojo");
                        } else {
                            notyf.error("Ocurrió un error inesperado, intenta de nuevo.");
                        }
                    });
            });
        });

        function addTogglePassword(inputId) {
            const input = $('#' + inputId);

            input.closest('.form-group').css('position', 'relative');

            input.after(`
                <span class="togglePassword" data-input="${inputId}" 
                    style="position: absolute; right: 20px; top: 38px; cursor: pointer; z-index: 2;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                        <path d="M8 5a3 3 0 0 0 0 6 3 3 0 0 0 0-6z"/>
                    </svg>
                </span>
            `);

            input.css('padding-right', '40px');
        }

        addTogglePassword('password');
        addTogglePassword('confirm-password');

        $(document).on('click', '.togglePassword', function () {
            const inputId = $(this).data('input');
            const input = $('#' + inputId);
            const type = input.attr('type') === 'password' ? 'text' : 'password';

            input.attr('type', type);

            $(this).html(
                type === 'password'
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
