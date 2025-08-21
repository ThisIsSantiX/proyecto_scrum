@extends('layouts.layoutAuth.layoutAuth')   

@section('title', 'Scrum')

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
                    <h2 class="mb-2">Cambiar contraseña</h2>
                    <p>Ingresa tu dirección de correo electrónico y te enviaremos un correo electrónico con instrucciones para restablecer tu contraseña.</p>
                    <form action="{{ route('confirmMail') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="floating-label form-group">
                                    <label for="email" class="form-label"></label>
                                    <input type="email" class="form-control" id="email" aria-describedby="email" placeholder=" ">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Restablecer</button>
                    </form>
                </div>
            </div>               
            <div class="sign-bg sign-bg-right">
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
        </div>
@endsection

@section('js')
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();

            if (email === '') {
                const notyf = new Notyf({
                    duration: 3000,
                    position: { x: 'left', y: 'top' }
                });

                notyf.error('Completa el campo de correo');
                return;
            }


            window.location.href = "{{ route('confirmMail') }}";
        });
    </script>
@endsection
