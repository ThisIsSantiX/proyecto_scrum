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
                        <p class="text-center">Crea una cuenta</p>
                        <form  action="{{ route('storeCuenta') }}" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="full-name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"  placeholder="" required>
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="last-name" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="apellido" name="apellido"  placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Correo</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="confirm-password" class="form-label">Confirmar Contraseña</label>
                                            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder=" " required>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = {
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('confirm-password').value,
        };

        axios.post("{{ route('storeCuenta') }}", formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            alert("Cuenta creada con éxito");
            window.location.href = "/login";
        })
        .catch(error => {
            if(error.response && error.response.status === 422){
                let errores = error.response.data.errors;
                let mensaje = "Errores:\n";
                for(const campo in errores){
                    mensaje += `- ${errores[campo][0]}\n`;
                }
                alert(mensaje);
            } else {
                alert("Hubo un error inesperado");
                console.error(error);
            }
        });
    });
</script>
@endsection

