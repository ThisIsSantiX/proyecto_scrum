edit
@extends('layouts.layout.layout')

@section('content')
<div class="conatiner-fluid content-inner mt-5 pt-4 py-0">
    <div class="row">
        {{-- Columna izquierda: Foto y rol --}}
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between mb-3">
                    <div class="header-title">
                        <h4 class="card-title">Editar Usuario</h4>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-center"> <!-- centramos solo la foto -->
                        <div class="position-relative" style="display: inline-block;">
                            <img id="preview"
                                src="{{ $user->foto_url 
                                        ? (Str::startsWith($user->foto_url, 'http') 
                                            ? $user->foto_url 
                                            : asset('storage/'.$user->foto_url)) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre . ' ' . $user->apellido) . '&background=random&color=fff' }}"
                                alt="Foto de perfil"
                                class="rounded-circle img-fluid"
                                style="width: 200px; height:200px; object-fit: cover;"
                                onclick="verFoto(document.getElementById('preview').src, '{{ $user->uid }}')"
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
                </div>
                <div class="img-extension mt-2 text-center">    
                    <span>Formatos permitidos: <b>.jpg .png .jpeg</b></span>
                </div>
            
                <div class="card-body">

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
                                <div class="form-group col-md-12">
                                    <label class="form-label">Nombre de usuario</label>
                                    <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" required>
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
                                <button type="submit" class="btn btn-primary">
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
<style>
    @media (max-width: 576px) {
        #id_rol {
            font-size: 14px;
            padding: 8px;
        }
    }
</style>
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
            formData.set('username', $('#username').val());
            formData.set('apellido', $('#apellido').val());
            formData.set('email', $('#email').val());


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
                    window.location.href = "{{ route('usuarios.index')}}";
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
        const userRol = "{{$userRole }}";

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

// Cambiar la imagen de vista previa al seleccionar un archivo
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("foto_url");
    const preview = document.getElementById("preview");

    if (input && preview) {
        input.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    preview.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});


// este diseño es para que la imagen ocupe todo el espacio del modal 
// el border hace que la imagen sea circular
function verFoto(url, uid) {
    const esAvatarPorDefecto = url.includes('ui-avatars.com') || url.includes('/images/avatar/01.jpg');
    let deleteBtn = '';

    if (!esAvatarPorDefecto && uid !== 'nuevo') {
        deleteBtn = `
            <button onclick="deleteFotoPerfil('${uid}')" 
                    style="
                        position:absolute;
                        top:18px;
                        left:18px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        width:40px;
                        height:40px;
                        background: linear-gradient(135deg, #ff4b5c, #c9184a);
                        border:none;
                        border-radius:50%;
                        color:white;
                        cursor:pointer;
                        box-shadow:0 4px 12px rgba(0,0,0,0.25);
                        transition: all 0.25s ease;
                    "
                    onmouseover="this.style.transform='scale(1.1)'; this.style.background='linear-gradient(135deg,#ff6b75,#e63956)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.background='linear-gradient(135deg,#ff4b5c,#c9184a)';"
                    title="Eliminar foto">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" 
                     viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" 
                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118z"/>
                </svg>
            </button>
        `;
    }

    Swal.fire({
        html: `
            <div style="width:400px;height:400px;margin:auto;display:flex;align-items:center;justify-content:center;position:relative;">
                <img src="${url}" 
                     alt="Foto de perfil" 
                     style="width:100%;height:100%;object-fit:cover;border-radius:50%;"> 
                ${deleteBtn}
            </div>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        background: '#000000cc',
        width: 'auto',
        padding: 0
    });
}

function activarPreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    if (input && preview) {
        input.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    preview.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// Llamar a la función en DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
    activarPreview("foto_url", "previewForm");
});


function deleteFotoPerfil(uid) {
    Swal.fire({
        title: '¿Eliminar foto de perfil?',
        text: "No podrás revertir esta acción.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            // Usamos la URL directa que coincide con tu ruta web.php
            axios.delete(`/usuarios/${uid}/foto`, {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            .then(response => {
                if (response.data.success) {
                    Swal.fire('Eliminada!', 'La foto de perfil ha sido eliminada.', 'success');

                    // Avatar por defecto (puedes cambiar por ui-avatars si quieres)
                   const defaultAvatar = "https://ui-avatars.com/api/?name={{ urlencode($user->username . ' ' . $user->apellido) }}&background=random&color=fff";
                    // Cambiar header
                    const previewHeader = document.getElementById('preview');
                    if (previewHeader) previewHeader.src = defaultAvatar;

                    // Cambiar formulario
                    const previewForm = document.getElementById('previewForm');
                    if (previewForm) previewForm.src = defaultAvatar;
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la foto.', 'error');
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire('Error', 'Ocurrió un error en el servidor.', 'error');
            });
        }
    });
}

</script>
@endsection