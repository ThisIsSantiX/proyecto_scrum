@extends('layouts.layout.layout')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')

<div class="container-fluid content-inner mt-2 pt-3 py-0">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card p-4 shadow-lg animate__animated animate__fadeIn">
                
                <!-- Encabezado con avatar, nombre y correo -->
                <div class="row align-items-center mb-3" id="profileHeader">
                    <!-- Avatar -->
                    <div class="col-12 col-md-3 text-center mb-3 mb-md-0">
                        <div class="position-relative d-inline-block">
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


                            <!-- Botón ver foto -->
                            <button 
                            onclick="verFoto('{{ $user->foto_url 
                                ? (Str::startsWith($user->foto_url, 'http') 
                                    ? $user->foto_url 
                                    : asset('storage/'.$user->foto_url)) 
                                : asset('images/avatar/01.jpg') }}', '{{ $user->uid }}')" 

                            class="btn btn-secondary d-flex align-items-center justify-content-center position-absolute shadow"
                            style="bottom: 10px; right: -10px; 
                                width: 50px; height: 50px; 
                                border-radius: 50%; cursor: pointer;">
                            <i class="bi bi-eye fs-4"></i>
                        </button>
                        </div>
                    </div>

                    <!-- Nombre y correo -->
                    <div class="col-12 col-md-9 text-center text-md-start">
                        <h3 class="fw-bold text-uppercase mb-1 text-gradient">
                            {{ $user->nombre }} {{ $user->apellido }}
                        </h3>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-envelope"></i> {{ $user->email }}
                        </p>
                    </div>
                </div>

                <hr class="opacity-50">

                <!-- Botón que despliega el formulario -->
                <div class="text-center">
                    <button id="btnEditarPerfil" 
                            class="btn btn-primary mb-3 shadow-sm animate__animated animate__fadeInUp" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#editProfileForm" 
                            aria-expanded="false" 
                            aria-controls="editProfileForm"> 
                        Editar Perfil
                    </button>
                </div>

                <!-- Formulario colapsable -->
                <div class="collapse" id="editProfileForm">
                    <form id="formProfileUpdate" 
                          action="{{ route('profile.update') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="mt-3 animate__animated animate__fadeIn">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-center">
                            <!-- Avatar columna izquierda -->
                            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
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


                                        
                                        

                                    <!-- Botón editar foto -->
                                    <label for="foto_url"  
                                        class="btn btn-primary d-flex align-items-center justify-content-center position-absolute shadow pulse-btn"
                                        style="bottom: 10px; right: -10px; 
                                            width: 50px; height: 50px; border-radius: 50%; cursor: pointer;">
                                        <i class="bi bi-pencil-square fs-4"></i>
                                    </label>
                                    <input id="foto_url" class="d-none" type="file" name="foto_url" accept="image/*">
                                </div>
                                <p class="mt-2 small text-muted">Formatos permitidos: <b>.jpg .png .jpeg</b></p>
                            </div>

                            <!-- Campos del formulario columna derecha -->
                            <div class="col-12 col-md-8">
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}">
                                </div>

                                <!-- Apellido -->
                                <div class="mb-3">
                                    <label for="apellido" class="form-label fw-semibold">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $user->apellido) }}">
                                </div>

                                <!-- Correo -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Correo</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                                </div>

                                <!-- Botón guardar -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow-sm">
                                        <i class="bi bi-check-circle"></i> Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
/* Avatar hover */
.avatar-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.avatar-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
}

/* Botón de editar con pulso */
.pulse-btn {
    animation: pulse 1.8s infinite;
}
@keyframes pulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6); }
    70% { transform: scale(1.1); box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
}

/* Texto degradado */
.text-gradient {
    background: linear-gradient(90deg, #0d6efd, #6610f2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Animación collapse más suave */
.collapse {
    transition: all 0.5s ease-in-out;
}
</style>
@endsection

@section('js')
<script>
    // Mostrar/ocultar encabezado y botón
    document.addEventListener("DOMContentLoaded", () => {
        const collapseEl = document.getElementById("editProfileForm");
        const headerEl = document.getElementById("profileHeader");
        const btnEditarPerfil = document.getElementById("btnEditarPerfil");

        collapseEl.addEventListener("show.bs.collapse", () => {
            headerEl.style.display = "none"; 
            btnEditarPerfil.style.display = "none"; 
        });

        collapseEl.addEventListener("hide.bs.collapse", () => {
            headerEl.style.display = "flex"; 
            btnEditarPerfil.style.display = "inline-block"; 
        });
    });

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("foto_url");
    const preview = document.getElementById("preview");

    // avatar del encabezado
    const headerPreview = document.querySelector("#profileHeader img");

    // variable global para la última foto cargada
    let tempFoto = null;

    if (input && preview) {
        input.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    tempFoto = ev.target.result;

                    // refrescar imagen en el formulario
                    preview.src = tempFoto;

                    // refrescar también el avatar del encabezado
                    if (headerPreview) {
                        headerPreview.src = tempFoto;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // sobrescribimos verFoto para usar la temporal si existe
    window.verFoto = function(url, uid) {
        const finalUrl = tempFoto || url;
        Swal.fire({
            html: `
                <div style="
                width:80vw;
                max-width:350px;
                aspect-ratio:1/1;
                margin:auto;
                position:relative;
                border-radius:50%;
                overflow:hidden;
                box-shadow:0 4px 12px rgba(0,0,0,0.35);
                display:flex;align-items:center;
                justify-content:center;
                ">

                  <img src="${finalUrl}" 
                       alt="Foto de perfil" 
                       style="width:100%; height:100%; object-fit:cover;">
                </div>

                <!-- Botón de eliminar -->
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
            </div>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            background: '#000000cc',
            width: 'auto',
            padding: 0
        });
    };
});



    // Eliminar foto
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
                    Swal.fire('Eliminada!', 'La foto de perfil ha sido eliminada.', 'success')
                        .then(() => location.reload());

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
