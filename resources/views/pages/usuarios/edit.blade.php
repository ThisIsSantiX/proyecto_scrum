@extends('layouts.layout.layout')

@section('content')
<div class="conatiner-fluid content-inner mt-5 pt-4 py-0">
    <div class="row">
        {{-- Columna izquierda: Foto y rol --}}
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Editar Usuario</h4>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Foto --}}
                    <div class="form-group">
                        <div class="profile-img-edit position-relative">
                            <img src="{{ $user->foto_url ? asset('storage/' . $user->foto_url) : 'https://ui-avatars.com/api/?name='.urlencode($user->nombre.' '.$user->apellido).'&background=random&color=fff' }}"
                                alt="profile-pic"
                                class="theme-color-default-img profile-pic rounded avatar-100">

                            <div class="upload-icone bg-primary">
                                <label for="foto_url" class="mb-0 d-flex align-items-center justify-content-center">
                                    <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                        <path fill="#ffffff"
                                            d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"/>
                                    </svg>
                                </label>
                                <input id="foto_url" class="file-upload d-none" type="file" name="foto_url" accept="image/*">
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
                            <option value="1" {{ $user->estado == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $user->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    {{-- Rol dinámico --}}
                    <div class="form-group mt-3">
                        <label class="form-label">Rol</label>
                        <select name="id_rol" id="id_rol" class="form-select" required>
                            <option value="">Seleccione un rol...</option>
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
                        <form action="{{ route('updateUsuario', $user->uid) }}" id="formEditarUsuario" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $user->nombre }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control" value="{{ $user->apellido }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Contraseña (opcional)</label>
                                    <input type="password" name="password" class="form-control" placeholder="Dejar vacío si no deseas cambiarla">
                                </div>
                            </div>
                        
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-pencil-square"></i> Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')

@endsection

@section('js')
<script>

    $(document).ready(function () {
        const notyf = new Notyf();

        $('form').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            const foto = $('#foto_url')[0]?.files[0];
            if (foto) {
                formData.append('foto_url', foto);
            }

            formData.set('estado', $('#estado').val());
            formData.set('id_rol', $('#id_rol').val());

            axios.post("{{ route('updateUsuario', $user->uid) }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-HTTP-Method-Override': 'PUT',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(response => {
                notyf.success('Usuario actualizado correctamente!');
                setTimeout(() => {
                    window.location.href = "{{ route('usuarios.index') }}";
                }, 1200);
            })
            .catch(error => {
                console.error(error);
                if (error.response?.data?.errors) {
                    let message = '';
                    const errors = error.response.data.errors;
                    for (const key in errors) {
                        message += errors[key].join('<br>') + '<br>';
                    }
                    notyf.error({ message: message, duration: 5000 });
                } else {
                    notyf.error('Error al actualizar el usuario.');
                }
            });
        });
    });


    $(document).ready(function () {
        const select = $('#id_rol'); 
        const notyf = new Notyf(); 
        const userRol = "{{ $user->id_rol }}";

        axios.get("{{ route('showRoles') }}")
            .then(response => {
                const roles = response.data; 
                console.log(roles);
                select.empty();
                select.append('<option value="">Seleccione un rol...</option>');

                roles.forEach(r => {
                    select.append(`<option value="${r.id}" ${r.id == userRol ? 'selected' : ''}>${r.nombre}</option>`);
                });
            })
            .catch(error => {
                console.error(error);
                notyf.error('No se pudieron cargar los roles.');
            });
    });

    $(document).ready(function () {
        const select = $('#id_rol'); 
        const notyf = new Notyf(); 
        const userRol = "{{ $userRole }}"; // viene del controlador

        axios.get("{{ route('showRoles') }}")
            .then(response => {
                const roles = response.data; 
                console.log(roles);
                select.empty();
                select.append('<option value="">Seleccione un rol...</option>');

                roles.forEach(r => {
                    // Si coincide con el rol actual, lo marcamos como seleccionado
                    select.append(`<option value="${r.id}" ${r.id == userRol ? 'selected' : ''}>${r.nombre}</option>`);
                });
            })
            .catch(error => {
                console.error(error);
                notyf.error('No se pudieron cargar los roles.');
            });
    });


</script>
@endsection
