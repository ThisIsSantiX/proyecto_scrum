@extends('layouts.layoutAuth.layoutAuth')   

@section('css')

@endsection

@section('content')
    <div class="row m-0 align-items-center bg-white vh-100">
        <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
            <img src="../../assets/images/auth/02.png" class="img-fluid gradient-main animated-scaleX" alt="images">
        </div>
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
                    <h2 class="mb-2">Cambiar contraseña</h2>
                    <p>Ingresa tu dirección de correo electrónico y te enviaremos un correo electrónico con instrucciones para restablecer tu contraseña.</p>
                    <form action="{{ route('recoverypw.send') }}" method="POST">
                        @csrf
                        <div class="floating-label form-group">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder=" " required>
                        </div>
                        <button type="submit" class="btn btn-primary">Restablecer</button>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                    </form>


                </div>
            </div>               
        </div>
        </div>
@endsection

@section('js')

@endsection
