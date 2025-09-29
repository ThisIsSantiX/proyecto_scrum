@extends('layouts.layout.layout')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')

<div class="container-fluid content-inner mt-2 pt-3 py-0">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="profile-container">
                        <!-- Avatar Section -->
                        <div class="profile-avatar-section">
                            <div class="avatar-wrapper position-relative">
                                <img id="avatarPreview"
                                    src="{{ $user->foto_url 
                                            ? (Str::startsWith($user->foto_url, 'http') 
                                                ? $user->foto_url 
                                                : asset('storage/'.$user->foto_url)) 
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=6e40c9&color=fff' }}"
                                    alt="Foto de perfil"
                                    class="profile-avatar"
                                    onclick="verFoto(this.src, '{{ $user->uid }}')"
                                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=6e40c9&color=fff';">
                                
                                @if(auth()->check() && auth()->user()->uid === $user->uid)
                                <div class="avatar-overlay" onclick="document.getElementById('foto_url').click()">
                                    <i class="bi bi-camera-fill"></i>
                                    <small class="d-block mt-1">Cambiar</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Info Section -->
                        <div class="profile-info-section">
                            <div id="displayMode">
                                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                    <div>
                                        <h2 class="profile-username mb-2" id="displayUsername">{{ $user->username }}</h2>
                                        <div class="profile-meta">
                                            <div class="meta-item">
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="bi bi-calendar3"></i>
                                                <span>Miembro desde {{ $user->created_at->format('M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if(auth()->check() && auth()->user()->uid === $user->uid)
                                    <button type="button" class="btn btn-outline-primary" onclick="toggleEditMode()">
                                        <i class="bi bi-pencil me-1"></i> Editar perfil
                                    </button>
                                    @endif
                                </div>
                            </div>

                            @if(auth()->check() && auth()->user()->uid === $user->uid)
                            <div id="editMode" style="display: none;">
                                <form id="formProfileUpdate" 
                                      action="{{ route('profile.update') }}" 
                                      method="POST" 
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <input type="file" 
                                           class="d-none" 
                                           id="foto_url" 
                                           name="foto_url" 
                                           accept="image/*" 
                                           onchange="handlePhotoChange(event)">

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="username" class="form-label fw-semibold">
                                                <i class="bi bi-person-badge me-1"></i>
                                                Nombre de usuario
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="username" 
                                                   name="username" 
                                                   value="{{ old('username', $user->username) }}"
                                                   placeholder="Ingresa tu nombre de usuario"
                                                   required>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label fw-semibold">
                                                <i class="bi bi-envelope me-1"></i>
                                                Correo electrónico
                                            </label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="tu@email.com"
                                                   required>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex gap-2 mt-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-check-lg me-1"></i>
                                                    Guardar cambios
                                                </button>
                                                <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">
                                                    <i class="bi bi-x-lg me-1"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
.card {
    border-radius: 12px;
}

.profile-container {
    display: flex;
    gap: 2.5rem;
    align-items: flex-start;
}

/* Avatar Section */
.profile-avatar-section {
    flex-shrink: 0;
}

.avatar-wrapper {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    display: block;
}

.avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.65);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    cursor: pointer;
    color: white;
    font-size: 13px;
}

.avatar-wrapper:hover .avatar-overlay {
    opacity: 1;
}

.avatar-overlay i {
    font-size: 28px;
}

/* Profile Info */
.profile-info-section {
    flex: 1;
    min-width: 0;
}

.profile-username {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.profile-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.9375rem;
}

.meta-item i {
    font-size: 1rem;
    color: #9ca3af;
}

/* Form adjustments */
.form-label {
    margin-bottom: 0.5rem;
    color: #374151;
}

/* Responsive */
@media (max-width: 992px) {
    .profile-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 2rem;
    }
    
    .profile-info-section {
        width: 100%;
    }
    
    .profile-meta {
        align-items: center;
    }
    
    .meta-item {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .avatar-wrapper {
        width: 150px;
        height: 150px;
    }
    
    .profile-username {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .avatar-wrapper {
        width: 130px;
        height: 130px;
    }
}
</style>
@endsection

@section('js')
<script>
function toggleEditMode() {
    const displayMode = document.getElementById('displayMode');
    const editMode = document.getElementById('editMode');
    
    if (displayMode.style.display === 'none') {
        displayMode.style.display = 'block';
        editMode.style.display = 'none';
    } else {
        displayMode.style.display = 'none';
        editMode.style.display = 'block';
    }
}

function handlePhotoChange(event) {
    const file = event.target.files[0];
    if (file) {
        // Validar tamaño (máximo 5MB)
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Archivo muy grande',
                text: 'La imagen no debe superar los 5MB'
            });
            event.target.value = '';
            return;
        }
        
        // Validar tipo
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                icon: 'error',
                title: 'Formato inválido',
                text: 'Por favor selecciona una imagen válida'
            });
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function verFoto(url, uid) {
    const isOwner = {{ auth()->check() && auth()->user()->uid === $user->uid ? 'true' : 'false' }};
    
    const deleteButton = isOwner ? `
        <button onclick="deleteFotoPerfil('${uid}')" 
                class="btn btn-danger position-absolute"
                style="top: 20px; right: 20px; z-index: 10; border-radius: 50%; width: 48px; height: 48px; padding: 0;"
                title="Eliminar foto">
            <i class="bi bi-trash"></i>
        </button>
    ` : '';
    
    Swal.fire({
        html: `
            <div style="position: relative; max-width: 600px; margin: auto;">
                <img src="${url}" 
                     alt="Foto de perfil" 
                     style="width: 100%; height: auto; border-radius: 12px;">
                ${deleteButton}
            </div>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        background: '#ffffff',
        width: 'auto',
        padding: '2rem',
        customClass: {
            popup: 'rounded-3'
        }
    });
}

function deleteFotoPerfil(uid) {
    Swal.fire({
        title: '¿Eliminar foto de perfil?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/usuarios/${uid}/foto`, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(response => {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminada!',
                        text: 'La foto de perfil ha sido eliminada correctamente.'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar la foto.'
                    });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error del servidor',
                    text: 'Ocurrió un error al procesar la solicitud.'
                });
            });
        }
    });
}
</script>
@endsection