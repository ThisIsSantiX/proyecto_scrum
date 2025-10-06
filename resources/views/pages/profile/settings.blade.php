@extends('layouts.layoutAuth.layoutAuth')

@section('title', 'Configuración de Cuenta - WorkScrum')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<style>
.settings-navbar {
    padding: 1.25rem 2rem;
    position: sticky;
    top: 0;
    z-index: 1020;
}

.settings-sidebar {
    min-height: calc(100vh - 73px);
    padding: 2rem 1rem;
}

.settings-nav-btn {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.875rem 1.25rem;
    margin-bottom: 0.5rem;
    background: transparent;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.9375rem;
    text-align: left;
    transition: all 0.2s ease;
    cursor: pointer;
}

.settings-nav-btn:hover {
    transform: translateX(4px);
}

.settings-nav-btn i {
    width: 20px;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.settings-card {
    border-radius: 0.75rem;
    margin-bottom: 2rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.settings-card-header {
    padding: 1.5rem 1.75rem;
}

.settings-card-header h5 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
}

.settings-card-body {
    padding: 2rem 1.75rem;
}

.settings-item {
    padding: 1.5rem 0;
}

.settings-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.settings-item:first-child {
    padding-top: 0;
}

.profile-photo-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.profile-photo-actions {
    margin-top: 1rem;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control,
.form-select {
    padding: 0.625rem 0.875rem;
    font-size: 0.9375rem;
    border-radius: 0.5rem;
}

.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.form-text {
    font-size: 0.8125rem;
    margin-top: 0.375rem;
}

.password-requirements {
    border-radius: 0.5rem;
    padding: 1rem 1.25rem;
    margin-top: 0.75rem;
}

.requirement {
    display: flex;
    align-items: center;
    padding: 0.375rem 0;
    font-size: 0.875rem;
}

.requirement i {
    margin-right: 0.625rem;
    width: 18px;
    font-size: 0.875rem;
}

.requirement.valid {
    color: #198754 !important;
}

.requirement.valid i {
    color: #198754 !important;
}

.requirement.invalid {
    color: #6c757d !important;
}

.requirement.invalid i {
    color: #6c757d !important;
}

.badge-status {
    padding: 0.375rem 0.875rem;
    border-radius: 0.375rem;
    font-weight: 500;
    font-size: 0.8125rem;
}

.btn {
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    border-radius: 0.5rem;
    font-size: 0.9375rem;
}

.btn-soft-primary {
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
    border: 1px solid transparent;
}

.btn-soft-primary:hover {
    background: rgba(13, 110, 253, 0.2);
    color: #0d6efd;
}

.btn-soft-danger {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: 1px solid transparent;
}

.btn-soft-danger:hover {
    background: rgba(220, 53, 69, 0.2);
    color: #dc3545;
}

.divider {
    height: 1px;
    margin: 1.75rem 0;
}

.form-switch .form-check-input {
    width: 3rem;
    height: 1.5rem;
    cursor: pointer;
}

@media (max-width: 768px) {
    .settings-navbar {
        padding: 1rem 1.25rem;
    }
    
    .settings-sidebar {
        min-height: auto;
        padding: 1rem;
        border-right: none;
    }
    
    .settings-nav-btn {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .settings-card-header,
    .settings-card-body {
        padding: 1.25rem;
    }
    
    .profile-photo-preview {
        width: 100px;
        height: 100px;
    }
}

@media (max-width: 576px) {
    .settings-navbar h4 {
        font-size: 1.125rem;
    }
    
    .logo-main img {
        width: 32px !important;
        height: 32px !important;
    }
}

#photoUpload {
    display: none;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <nav class="settings-navbar bg-white border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="logo-main">
                    <img src="../../assets/images/logos/workscrum.png" alt="Logo" width="40" height="40">
                </div>
                <h4 class="mb-0 fw-semibold">Configuración de Cuenta</h4>
            </div>

            @php
                $foto = Auth::user()->foto_url ?? Auth::user()->avatar;
                $esExterno = $foto && Str::startsWith($foto, ['http://', 'https://']);
            @endphp
            <img src="{{ $foto ? ($esExterno ? $foto : asset('storage/' . $foto)) : asset('assets/images/default-avatar.png') }}"
                alt="User Profile"
                class="rounded-circle border"
                style="width:45px; height:45px; object-fit:cover;">
        </div>
    </nav>

    <div class="row g-0">
        <div class="col-md-3 col-lg-2 settings-sidebar bg-white border-end">
            <div class="d-flex flex-column">
                <button class="settings-nav-btn active bg-primary text-white" onclick="cambiarTab('cuenta', this)">
                    <i class="fas fa-user-cog"></i> Perfil
                </button>
                <button class="settings-nav-btn text-muted" onclick="cambiarTab('seguridad', this)">
                    <i class="fas fa-lock"></i> Seguridad
                </button>
                <button class="settings-nav-btn text-muted" onclick="cambiarTab('apariencia', this)">
                    <i class="fas fa-palette"></i> Apariencia
                </button>
                <button class="settings-nav-btn text-muted" onclick="cambiarTab('privacidad', this)">
                    <i class="fas fa-shield-alt"></i> Privacidad
                </button>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 p-4 p-md-5">
            
            <div class="tab-pane-custom active" id="cuenta">
                <div class="settings-card card border">
                    <div class="settings-card-header bg-white border-bottom">
                        <h5 class="text-body">Información Personal</h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <form id="formPerfil">
                            @csrf
                            <div class="text-center mb-4 pb-4 border-bottom">
                                @php
                                    $foto = Auth::user()->foto_url ?? Auth::user()->avatar;
                                    $esExterno = $foto && Str::startsWith($foto, ['http://', 'https://']);
                                @endphp
                                <img src="{{ $foto ? ($esExterno ? $foto : asset('storage/' . $foto)) : asset('assets/images/default-avatar.png') }}"
                                    alt="Foto de perfil"
                                    class="profile-photo-preview mb-3 border"
                                    id="profilePhotoPreview">
                                <div class="profile-photo-actions">
                                    <input type="file" id="photoUpload" accept="image/*">
                                    <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('photoUpload').click()">
                                        <i class="fas fa-camera me-1"></i> Cambiar foto
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="btnEliminarFoto">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label text-body">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ Auth::user()->nombre }}" placeholder="Ingresa tu nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label text-body">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ Auth::user()->apellido }}" placeholder="Ingresa tu apellido" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="username" class="form-label text-body">Nombre de usuario</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->username }}" placeholder="@usuario" required>
                                    <small class="form-text text-muted">Este es tu identificador único en la plataforma</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label text-body">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="correo@ejemplo.com" required>
                                </div>
                            </div>

                            <div class="divider bg-secondary"></div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Estado de la cuenta</h6>
                                    <small class="text-muted">Tu cuenta está actualmente 
                                        @if(Auth::user()->estado == 1)
                                            <span class="badge badge-status bg-success">Activa</span>
                                        @else
                                            <span class="badge badge-status bg-secondary">Inactiva</span>
                                        @endif
                                    </small>
                                </div>
                            </div>

                            @if(Auth::user()->google_id)
                            <div class="d-flex align-items-center p-3 bg-white border rounded-3 mb-4">
                                <i class="fab fa-google me-3 text-danger" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Cuenta vinculada con Google</h6>
                                    <small class="text-muted">Tu cuenta está conectada con Google</small>
                                </div>
                            </div>
                            @endif

                            <div class="d-flex justify-content-end gap-2 pt-3">
                                <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="settings-card card border">
                    <div class="settings-card-header bg-white border-bottom">
                        <h5 class="text-body">Información del Sistema</h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <div class="settings-item border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Fecha de registro</h6>
                                    <small class="text-muted">Miembro desde</small>
                                </div>
                                <span class="text-muted fw-medium">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @if(Auth::user()->email_verified_at)
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Email verificado</h6>
                                    <small class="text-muted">Verificación completada</small>
                                </div>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Verificado
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="tab-pane-custom" id="seguridad" style="display: none;">
                <div class="settings-card card border">
                    <div class="settings-card-header bg-white border-bottom">
                        <h5 class="text-body">Contraseña</h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <form id="formPassword">
                            @csrf
                            @if(!Auth::user()->google_id)
                            <div class="settings-item">
                                <div class="mb-4">
                                    <label for="current_password" class="form-label text-body">Contraseña actual</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Ingresa tu contraseña actual" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label text-body">Nueva contraseña</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Ingresa tu nueva contraseña" required>
                                </div>
                                
                                <div class="password-requirements bg-white border">
                                    <div class="requirement invalid" id="req-length">
                                        <i class="fas fa-circle-xmark"></i>
                                        <span>Mínimo 8 caracteres</span>
                                    </div>
                                    <div class="requirement invalid" id="req-uppercase">
                                        <i class="fas fa-circle-xmark"></i>
                                        <span>Al menos una mayúscula</span>
                                    </div>
                                    <div class="requirement invalid" id="req-lowercase">
                                        <i class="fas fa-circle-xmark"></i>
                                        <span>Al menos una minúscula</span>
                                    </div>
                                    <div class="requirement invalid" id="req-number">
                                        <i class="fas fa-circle-xmark"></i>
                                        <span>Al menos un número</span>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="form-label text-body">Confirmar nueva contraseña</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirma tu nueva contraseña" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-1"></i> Cambiar contraseña
                                </button>
                            </div>
                            @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Tu cuenta está vinculada con Google. La contraseña se gestiona a través de Google.
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane-custom" id="apariencia" style="display: none;">
                <div class="settings-card card border">
                    <div class="settings-card-header bg-white border-bottom">
                        <h5 class="text-body">Tema de la Interfaz</h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Modo oscuro</h6>
                                    <small class="text-muted">Cambia entre modo claro y oscuro</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchTema" role="switch">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="settings-card card border">
                    <div class="settings-card-header bg-white border-bottom">
                        <h5 class="text-body">Idioma y Región <small class="text-muted fw-normal">(Próximamente)</small></h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <div class="settings-item">
                            <label for="idioma" class="form-label text-body">Idioma de la interfaz</label>
                            <select class="form-select" id="idioma" disabled>
                                <option value="es" selected>Español</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane-custom" id="privacidad" style="display: none;">
                <div class="settings-card card border">
                    <div class="settings-card-header bg-white border-bottom">
                        <h5 class="text-body">Datos y Privacidad <small class="text-muted fw-normal">(Próximamente)</small></h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Descargar mis datos</h6>
                                    <small class="text-muted">Obtén una copia de tu información personal</small>
                                </div>
                                <button class="btn btn-primary" disabled>
                                    <i class="fas fa-download me-1"></i> Descargar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="settings-card card border-danger">
                    <div class="settings-card-header bg-danger bg-opacity-10 border-bottom border-danger">
                        <h5 class="text-danger">Zona de Peligro</h5>
                    </div>
                    <div class="settings-card-body bg-white">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Desactivar cuenta</h6>
                                    <small class="text-muted">Tu cuenta será desactivada temporalmente</small>
                                </div>
                                <button class="btn btn-outline-danger" id="btnDesactivarCuenta">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Desactivar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function cambiarTab(tabId, button) {
    document.querySelectorAll('.tab-pane-custom').forEach(pane => {
        pane.style.display = 'none';
        pane.classList.remove('active');
    });
    
    document.querySelectorAll('.settings-nav-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-primary', 'text-white');
        btn.classList.add('text-muted');
    });
    
    document.getElementById(tabId).style.display = 'block';
    document.getElementById(tabId).classList.add('active');
    
    button.classList.add('active', 'bg-primary', 'text-white');
    button.classList.remove('text-muted');
}

const notyf = new Notyf({
    duration: 4000,
    position: {
        x: 'right',
        y: 'top',
    }
});

const switchTema = document.getElementById('switchTema');
const body = document.body;

if (localStorage.getItem('tema_config') === 'oscuro') {
    body.classList.add('dark');
    switchTema.checked = true;
}

switchTema.addEventListener('change', () => {
    if (switchTema.checked) {
        body.classList.add('dark');
        localStorage.setItem('tema_config', 'oscuro');
    } else {
        body.classList.remove('dark');
        localStorage.setItem('tema_config', 'claro');
    }
});

const newPasswordInput = document.getElementById('new_password');
if (newPasswordInput) {
    newPasswordInput.addEventListener('input', () => {
        const password = newPasswordInput.value;
        
        const reqLength = document.getElementById('req-length');
        if (password.length >= 8) {
            reqLength.classList.add('valid');
            reqLength.classList.remove('invalid');
            reqLength.querySelector('i').className = 'fas fa-circle-check';
        } else {
            reqLength.classList.remove('valid');
            reqLength.classList.add('invalid');
            reqLength.querySelector('i').className = 'fas fa-circle-xmark';
        }
        
        const reqUppercase = document.getElementById('req-uppercase');
        if (/[A-Z]/.test(password)) {
            reqUppercase.classList.add('valid');
            reqUppercase.classList.remove('invalid');
            reqUppercase.querySelector('i').className = 'fas fa-circle-check';
        } else {
            reqUppercase.classList.remove('valid');
            reqUppercase.classList.add('invalid');
            reqUppercase.querySelector('i').className = 'fas fa-circle-xmark';
        }
        
        const reqLowercase = document.getElementById('req-lowercase');
        if (/[a-z]/.test(password)) {
            reqLowercase.classList.add('valid');
            reqLowercase.classList.remove('invalid');
            reqLowercase.querySelector('i').className = 'fas fa-circle-check';
        } else {
            reqLowercase.classList.remove('valid');
            reqLowercase.classList.add('invalid');
            reqLowercase.querySelector('i').className = 'fas fa-circle-xmark';
        }
        
        const reqNumber = document.getElementById('req-number');
        if (/[0-9]/.test(password)) {
            reqNumber.classList.add('valid');
            reqNumber.classList.remove('invalid');
            reqNumber.querySelector('i').className = 'fas fa-circle-check';
        } else {
            reqNumber.classList.remove('valid');
            reqNumber.classList.add('invalid');
            reqNumber.querySelector('i').className = 'fas fa-circle-xmark';
        }
    });
}

function validarPassword(password) {
    const regexLength = /.{8,}/;
    const regexUppercase = /[A-Z]/;
    const regexLowercase = /[a-z]/;
    const regexNumber = /[0-9]/;
    
    return regexLength.test(password) && 
           regexUppercase.test(password) && 
           regexLowercase.test(password) && 
           regexNumber.test(password);
}

document.getElementById('formPerfil').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    try {
        const response = await axios.post('/user/update-settings', formData);
        notyf.success('Perfil actualizado correctamente');
    } catch (error) {
        notyf.error('Error al actualizar el perfil: ' + (error.response?.data?.message || 'Error desconocido'));
    }
});

document.getElementById('photoUpload').addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;
    
    if (file.size > 2 * 1024 * 1024) {
        notyf.error('La imagen no debe superar los 2MB');
        e.target.value = '';
        return;
    }
    
    if (!file.type.match('image.*')) {
        notyf.error('Solo se permiten imágenes');
        e.target.value = '';
        return;
    }
    
    const formData = new FormData();
    formData.append('foto', file);
    
    try {
        const response = await axios.post('/user/update-photo', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        document.getElementById('profilePhotoPreview').src = URL.createObjectURL(file);
        notyf.success('Foto actualizada correctamente');
        setTimeout(() => location.reload(), 1500);
    } catch (error) {
        notyf.error('Error al actualizar la foto: ' + (error.response?.data?.message || 'Error desconocido'));
    }
});

document.getElementById('btnEliminarFoto').addEventListener('click', async () => {
    const result = await Swal.fire({
        title: '¿Eliminar foto de perfil?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });
    
    if (!result.isConfirmed) return;
    
    try {
        await axios.post('/user/delete-photo');
        notyf.success('Foto eliminada correctamente');
        setTimeout(() => location.reload(), 1500);
    } catch (error) {
        notyf.error('Error al eliminar la foto: ' + (error.response?.data?.message || 'Error desconocido'));
    }
});

const formPassword = document.getElementById('formPassword');
if (formPassword) {
    formPassword.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const newPassword = formData.get('new_password');
        const confirmPassword = formData.get('new_password_confirmation');
        
        if (newPassword !== confirmPassword) {
            notyf.error('Las contraseñas no coinciden');
            return;
        }
        
        if (!validarPassword(newPassword)) {
            notyf.error('La contraseña no cumple con los requisitos mínimos');
            return;
        }
        
        try {
            await axios.post('/user/change-password', {
                current_password: formData.get('current_password'),
                new_password: newPassword,
                new_password_confirmation: confirmPassword
            });
            
            await Swal.fire({
                icon: 'success',
                title: 'Contraseña cambiada',
                text: 'Tu contraseña ha sido actualizada correctamente',
                confirmButtonColor: '#3a57e8'
            });
            
            e.target.reset();
        } catch (error) {
            notyf.error('Error al cambiar la contraseña: ' + (error.response?.data?.message || 'Error desconocido'));
        }
    });
}

document.getElementById('btnDesactivarCuenta').addEventListener('click', async () => {
    const result = await Swal.fire({
        title: '¿Desactivar tu cuenta?',
        text: "Tu cuenta será desactivada temporalmente. Puedes contactar al soporte para reactivarla.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    });
    
    if (!result.isConfirmed) return;
    
    try {
        await axios.post('/user/deactivate-account');
        
        await Swal.fire({
            icon: 'success',
            title: 'Cuenta desactivada',
            text: 'Serás redirigido al inicio de sesión',
            timer: 2000,
            showConfirmButton: false
        });
        
        setTimeout(() => {
            window.location.href = '/logout';
        }, 2000);
    } catch (error) {
        notyf.error('Error al desactivar la cuenta: ' + (error.response?.data?.message || 'Error desconocido'));
    }
});
</script>
@endsection
