@extends('layouts.layoutAuth.layoutAuth')   

@section('css')

@endsection

@section('content')
    <div class="row m-0 align-items-center bg-white vh-100">            
        <div class="col-md-6 p-0">    
            <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                <div class="card-body">
                    <div class="logo-main d-flex align-items-start justify-content-start mb-3">
                            <img src="../../assets/images/logos/workscrum.png" 
                                alt="WorkScrum Logo" 
                                class="me-2" 
                                width="40" 
                                height="40">

                            <!-- Nombre -->
                            <h2 class="mb-0 fw-bold">WorkScrum</h2>
                        </div>
                    </a>
                    <img src="../../assets/images/auth/mail.png" class="img-fluid" width="80" alt="">
                    <h2 class="mt-3 mb-0">Enviado!</h2>
                    <p>
                        Se ha enviado un correo electrónico a {{ $email ?? 'desconocido' }}. 
                        Por favor, revisa tu bandeja de entrada y haz clic en el enlace incluido para restablecer tu contraseña.
                    </p>

                    <div class="d-inline-block w-100">
                        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Volver al login</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
            <img src="../../assets/images/auth/03.png" class="img-fluid gradient-main animated-scaleX" alt="images">
        </div>
    </div>
@endsection

@section('js')

@endsection
