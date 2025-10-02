@extends('layouts.layout.layout')

@section('content')

    
    <div class="conatiner-fluid content-inner mt-5 pt-4 py-0">
        <div class="row">
            {{-- Columna izquierda: Foto y rol --}}
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Añadir Usuario</h4>
                    </div>
                    </div>
                    <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Foto --}}
                    <div class="form-group">
                        <div class="profile-img-edit position-relative">
                            <img src="https://ui-avatars.com/api/?name=Nuevo+Usuario&background=random&color=fff"
                                alt="profile-pic"
                                class="theme-color-default-img profile-pic rounded avatar-100">

                            <div class="upload-icone bg-primary">
                                <label for="foto_url" class="mb-0 d-flex align-items-center justify-content-center">
                                    <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                        <path fill="#ffffff"
                                            d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"/>
                                    </svg>
                                </label>
                                    <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <input id="foto_url" class="file-upload d-none" type="file" name="foto_url" accept="image/*">
                                    </form>
                            </div>
                        </div>
                        <div class="img-extension mt-2">
                            <span>Formatos permitidos: <b>.jpg .png .jpeg</b></span>
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="form-group mt-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    </div>
                </div>
            </div>

            {{-- Columna derecha: Datos --}}
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Información del Usuario</h4>
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="new-user-info">
                        <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                                </div>
                                <div class="form-group col-md-16">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                        
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-save me-2" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 0-2 2v1H2.5A1.5 1.5 0 0 0 1 5.5v8A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 13.5 4H10V3a2 2 0 0 0-2-2zM2 5h12v8.5a.5.5 0 0 1-.5.5H2.5a.5.5 0 0 1-.5-.5V5zm5-2a1 1 0 0 1 2 0v1H7V3z"/>
                                </svg>
                                Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('js')
    <script>

        $(document).ready(function () {
            const notyf = new Notyf();

            // Interceptar el submit del formulario
            $('form').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this); // Datos dentro del form

                // Agregamos los campos que están fuera del form
                const foto = $('#foto_url')[0].files[0];
                if (foto) {
                    formData.append('foto_url', foto);
                }

                const estado = $('#estado').val();
                formData.append('estado', estado);

                axios.post("{{ route('usuarios.store') }}", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    notyf.success('Usuario guardado correctamente!');
            
                    window.location.href = "{{ route('usuarios.index') }}";
                })
                .catch(error => {
                    console.error(error);
                    if (error.response && error.response.data && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        let message = '';
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                message += errors[key].join('<br>') + '<br>';
                            }
                        }
                        notyf.error({ message: message, duration: 5000 });
                    } else {
                        notyf.error('Error al guardar el usuario.');
                    }
                });
            });

            // Previsualizar foto
            $('#foto_url').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('.profile-pic').attr('src', ev.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });


        document.getElementById('foto_url').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    document.querySelector('.profile-pic').src = ev.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

    </script>

@endsection