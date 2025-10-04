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
                            <div class="d-flex justify-content-center">
                                <div class="position-relative" style="display:inline-block;">
                                    <img id="preview"
                                        src="https://ui-avatars.com/api/?name=Nuevo+Usuario&background=random&color=fff"
                                        alt="Foto de perfil"
                                        class="rounded-circle img-fluid"
                                        style="width: 200px; height:200px; object-fit: cover;"
                                        onclick="verFoto(document.getElementById('preview').src)"
                                        onerror="this.onerror=null;this.src='/images/avatar/01.jpg';">

                                    <!-- Botón flotante -->
                                    <label for="foto_url"
                                        class="btn btn-primary d-flex align-items-center justify-content-center position-absolute shadow"
                                        style="bottom: 5px; right: 5px; 
                                            width: 45px; height: 45px; border-radius: 50%; cursor: pointer;">
                                        <i class="bi bi-pencil-square"></i>
                                    </label>
                                    <input id="foto_url" class="d-none" type="file" name="foto_url" accept="image/*">
                                </div>
                            </div>
                            <div class="img-extension mt-2 text-center">    
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
                                        <input type="text" name="apellido" id="apellido" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                </div>
                            
                                <div class="mt-4 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i> Guardar
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

@section('js')
<script>
    $(document).ready(function () {
        const notyf = new Notyf();

        // Interceptar submit
        $('form').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            const foto = $('#foto_url')[0].files[0];
            if (foto) {
                formData.append('foto_url', foto);
            }

            formData.append('estado', $('#estado').val());

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
                if (error.response?.data?.errors) {
                    let message = '';
                    const errors = error.response.data.errors;
                    for (const key in errors) {
                        message += errors[key].join('<br>') + '<br>';
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
                    $('#preview').attr('src', ev.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });

    function verFoto(url, uid) {
        const esAvatarPorDefecto = url.includes('ui-avatars.com') || url.includes('/images/avatar/01.jpg');
        Swal.fire({
            html: `
                <div style="width:400px;height:400px;margin:auto;display:flex;align-items:center;justify-content:center;position:relative;">
                    <img src="${url}" 
                        alt="Foto de perfil" 
                            style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                </div>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            background: '#000000cc',
            width: 'auto',
            padding: 0
        });
    }

</script>
@endsection