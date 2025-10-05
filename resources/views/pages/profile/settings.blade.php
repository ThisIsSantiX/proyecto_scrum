@extends('layouts.layoutAuth.layoutAuth')

@section('title', 'Configuración de Cuenta - WorkScrum')

@section('css')
<style>
:root {
    --settings-bg: #f8f9fa;
    --settings-card-bg: #ffffff;
    --settings-sidebar-bg: #ffffff;
    --settings-border: #e9ecef;
    --settings-text-primary: #212529;
    --settings-text-secondary: #6c757d;
    --settings-hover-bg: #f8f9fa;
    --settings-active-bg: #e7f1ff;
    --settings-active-color: #0d6efd;
    --settings-shadow: rgba(0, 0, 0, 0.05);
}

body.dark {
    --settings-bg: #1a1d23;
    --settings-card-bg: #242830;
    --settings-sidebar-bg: #1e2128;
    --settings-border: #2d3139;
    --settings-text-primary: #e9ecef;
    --settings-text-secondary: #adb5bd;
    --settings-hover-bg: #2d3139;
    --settings-active-bg: #2a3441;
    --settings-active-color: #4d9fff;
    --settings-shadow: rgba(0, 0, 0, 0.3);
}

body {
    background-color: var(--settings-bg);
    color: var(--settings-text-primary);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.settings-navbar {
    background-color: var(--settings-card-bg);
    border-bottom: 1px solid var(--settings-border);
    padding: 1rem 1.5rem;
}

.settings-sidebar {
    background-color: var(--settings-sidebar-bg);
    border-right: 1px solid var(--settings-border);
    min-height: calc(100vh - 73px);
    padding: 1.5rem 0;
    border-radius: 0;
}

.settings-sidebar .nav-link {
    color: var(--settings-text-secondary);
    margin: 0.25rem 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    border: none;
    border-radius: 0%
}

.settings-sidebar .nav-link:hover {
    background-color: var(--settings-hover-bg);
    color: var(--settings-text-primary);
}

.settings-sidebar .nav-link.active {
    background-color: var(--settings-active-bg);
    color: var(--settings-active-color);
    font-weight: 500;
}

.settings-card {
    background-color: var(--settings-card-bg);
    border: 1px solid var(--settings-border);
    border-radius: 0.75rem;
    box-shadow: 0 2px 8px var(--settings-shadow);
    margin-bottom: 1.5rem;
}

.settings-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--settings-border);
}

.settings-card-body {
    padding: 1.5rem;
}

.settings-item {
    padding: 1.25rem 0;
    border-bottom: 1px solid var(--settings-border);
}

.settings-item:last-child {
    border-bottom: none;
}

.form-label {
    color: var(--settings-text-primary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    background-color: var(--settings-card-bg);
    border: 1px solid var(--settings-border);
    color: var(--settings-text-primary);
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    background-color: var(--settings-card-bg);
    border-color: var(--settings-active-color);
    color: var(--settings-text-primary);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

body.dark .form-control:focus, body.dark .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(77, 159, 255, 0.25);
}

.form-control::placeholder {
    color: var(--settings-text-secondary);
}

.form-check-input {
    background-color: var(--settings-card-bg);
    border: 1px solid var(--settings-border);
}

.form-check-input:checked {
    background-color: var(--settings-active-color);
    border-color: var(--settings-active-color);
}

.form-switch .form-check-input {
    width: 3rem;
    height: 1.5rem;
    cursor: pointer;
}

.badge-status {
    padding: 0.35rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
}

.profile-photo-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--settings-border);
}

.btn-outline-custom {
    border: 1px solid var(--settings-border);
    color: var(--settings-text-primary);
    background-color: transparent;
}

.btn-outline-custom:hover {
    background-color: var(--settings-hover-bg);
    border-color: var(--settings-border);
    color: var(--settings-text-primary);
}

.logo-title {
    color: var(--settings-text-primary);
}

.text-muted {
    color: var(--settings-text-secondary) !important;
}

.divider {
    height: 1px;
    background-color: var(--settings-border);
    margin: 1.5rem 0;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-0">

    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg settings-navbar">
        <div class="d-flex align-items-center w-100 justify-content-between">
            <div class="d-flex align-items-center">
                <div class="logo-main me-2">
                    <img src="../../assets/images/logos/workscrum.png" alt="Logo" width="40" height="40">
                </div>
                <h4 class="logo-title mb-0">Configuración de Cuenta</h4>
            </div>

            @php
                $foto = Auth::user()->foto_url;
                $esExterno = Str::startsWith($foto, ['http://', 'https://']);
            @endphp
            <img src="{{ $esExterno ? $foto : asset('storage/' . $foto) }}"
                 alt="User Profile"
                 class="rounded-circle"
                 style="width:45px; height:45px; object-fit:cover;">
        </div>
    </nav>

    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 settings-sidebar">
            <ul class="nav flex-column nav-pills px-1">
                <li class="nav-item">
                    <button class="nav-link active text-start w-100" data-bs-toggle="tab" data-bs-target="#cuenta">
                        <i class="fas fa-user-cog me-2"></i> Perfil
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-start w-100" data-bs-toggle="tab" data-bs-target="#seguridad">
                        <i class="fas fa-lock me-2"></i> Seguridad
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-start w-100" data-bs-toggle="tab" data-bs-target="#notificaciones">
                        <i class="fas fa-bell me-2"></i> Notificaciones
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-start w-100" data-bs-toggle="tab" data-bs-target="#apariencia">
                        <i class="fas fa-palette me-2"></i> Apariencia
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-start w-100" data-bs-toggle="tab" data-bs-target="#privacidad">
                        <i class="fas fa-shield-alt me-2"></i> Privacidad
                    </button>
                </li>
            </ul>
        </div>

        <!-- Contenido de secciones -->
        <div class="col-md-9 col-lg-10 tab-content p-4">
            
            <!-- Perfil / Cuenta -->
            <div class="tab-pane fade show active" id="cuenta">
                <!-- Información Personal -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Información Personal</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="row mb-4">
                            <div class="col-12 text-center mb-4">
                                @php
                                    $foto = Auth::user()->foto_url;
                                    $esExterno = Str::startsWith($foto, ['http://', 'https://']);
                                @endphp
                                <img src="{{ $esExterno ? $foto : asset('storage/' . $foto) }}"
                                     alt="Foto de perfil"
                                     class="profile-photo-preview mb-3">
                                <div>
                                    <button class="btn btn-sm btn-outline-custom me-2">
                                        <i class="fas fa-camera me-1"></i> Cambiar foto
                                    </button>
                                    <button class="btn btn-sm btn-outline-custom">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" value="{{ Auth::user()->nombre }}" placeholder="Ingresa tu nombre">
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" value="{{ Auth::user()->apellido }}" placeholder="Ingresa tu apellido">
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" placeholder="@usuario">
                                <small class="text-muted">Este es tu identificador único en la plataforma</small>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" placeholder="correo@ejemplo.com">
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Estado de la cuenta</h6>
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
                        <div class="divider"></div>
                        <div class="d-flex align-items-center">
                            <i class="fab fa-google me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-0">Cuenta vinculada con Google</h6>
                                <small class="text-muted">ID: {{ Str::limit(Auth::user()->google_id, 20) }}</small>
                            </div>
                        </div>
                        @endif

                        <div class="divider"></div>

                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-outline-custom">Cancelar</button>
                            <button class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>

                <!-- Información de Sistema -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Información del Sistema</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">ID de Usuario (UID)</h6>
                                    <small class="text-muted">Identificador único del sistema</small>
                                </div>
                                <code class="text-muted">{{ Auth::user()->uid ?? 'No asignado' }}</code>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Fecha de registro</h6>
                                    <small class="text-muted">Miembro desde</small>
                                </div>
                                <span class="text-muted">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seguridad -->
            <div class="tab-pane fade" id="seguridad">
                <!-- Contraseña -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Contraseña</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Cambiar contraseña</h6>
                                    <small class="text-muted">Actualiza tu contraseña regularmente para mayor seguridad</small>
                                </div>
                                <button class="btn btn-outline-custom">
                                    <i class="fas fa-key me-1"></i> Cambiar
                                </button>
                            </div>
                        </div>
                        
                        @if(!Auth::user()->google_id)
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Última actualización</h6>
                                    <small class="text-muted">Hace 3 meses</small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Autenticación de dos factores -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Autenticación de Dos Factores</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Autenticación 2FA</h6>
                                    <small class="text-muted">Agrega una capa extra de seguridad a tu cuenta</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switch2FA">
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Aplicación de autenticación</h6>
                                    <small class="text-muted">Google Authenticator, Authy, etc.</small>
                                </div>
                                <button class="btn btn-sm btn-outline-custom" disabled>
                                    <i class="fas fa-mobile-alt me-1"></i> Configurar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sesiones activas -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Sesiones Activas</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-desktop me-2"></i> Windows - Chrome</h6>
                                    <small class="text-muted">192.168.1.100 • Activa ahora</small>
                                </div>
                                <span class="badge badge-status bg-success">Actual</span>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-mobile-alt me-2"></i> iPhone - Safari</h6>
                                    <small class="text-muted">192.168.1.105 • Hace 2 horas</small>
                                </div>
                                <button class="btn btn-sm btn-outline-custom">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <button class="btn btn-outline-custom w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar todas las sesiones
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notificaciones -->
            <div class="tab-pane fade" id="notificaciones">
                <!-- Notificaciones por correo -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Notificaciones por Correo</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Actualizaciones del proyecto</h6>
                                    <small class="text-muted">Recibe notificaciones sobre cambios en tus proyectos</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifProyectos" checked>
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Menciones y comentarios</h6>
                                    <small class="text-muted">Cuando alguien te menciona o comenta</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifMenciones" checked>
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Resumen semanal</h6>
                                    <small class="text-muted">Recibe un resumen de actividad cada semana</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifResumen">
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Boletín informativo</h6>
                                    <small class="text-muted">Noticias, consejos y actualizaciones de la plataforma</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifBoletin">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificaciones push -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Notificaciones Push</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Notificaciones del navegador</h6>
                                    <small class="text-muted">Recibe alertas en tiempo real en tu navegador</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifPush">
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Sonido de notificación</h6>
                                    <small class="text-muted">Reproduce un sonido al recibir notificaciones</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifSonido" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Frecuencia -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Frecuencia de Notificaciones</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <label for="frecuenciaNotif" class="form-label">¿Con qué frecuencia deseas recibir notificaciones?</label>
                            <select class="form-select" id="frecuenciaNotif">
                                <option value="tiempo-real" selected>En tiempo real</option>
                                <option value="cada-hora">Cada hora</option>
                                <option value="diario">Resumen diario</option>
                                <option value="semanal">Resumen semanal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apariencia -->
            <div class="tab-pane fade" id="apariencia">
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Tema de la Interfaz</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Modo oscuro</h6>
                                    <small class="text-muted">Cambia entre modo claro y oscuro</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchTema">
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <label for="temaAuto" class="form-label">Preferencia de tema</label>
                            <select class="form-select" id="temaAuto">
                                <option value="manual" selected>Manual</option>
                                <option value="sistema">Seguir configuración del sistema</option>
                                <option value="horario">Automático según horario</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Idioma y región -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Idioma y Región</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <label for="idioma" class="form-label">Idioma de la interfaz</label>
                            <select class="form-select" id="idioma">
                                <option value="es" selected>Español</option>
                                <option value="en">English</option>
                                <option value="pt">Português</option>
                                <option value="fr">Français</option>
                            </select>
                        </div>
                        <div class="settings-item">
                            <label for="zonaHoraria" class="form-label">Zona horaria</label>
                            <select class="form-select" id="zonaHoraria">
                                <option value="america-mexico" selected>América/Ciudad de México (GMT-6)</option>
                                <option value="america-bogota">América/Bogotá (GMT-5)</option>
                                <option value="america-argentina">América/Buenos Aires (GMT-3)</option>
                                <option value="europe-madrid">Europa/Madrid (GMT+1)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Accesibilidad -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Accesibilidad</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Reducir animaciones</h6>
                                    <small class="text-muted">Minimiza efectos de movimiento en la interfaz</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="reducirAnimaciones">
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <label for="tamanoTexto" class="form-label">Tamaño del texto</label>
                            <select class="form-select" id="tamanoTexto">
                                <option value="pequeno">Pequeño</option>
                                <option value="normal" selected>Normal</option>
                                <option value="grande">Grande</option>
                                <option value="muy-grande">Muy grande</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacidad -->
            <div class="tab-pane fade" id="privacidad">
                <!-- Visibilidad del perfil -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Visibilidad del Perfil</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Perfil público</h6>
                                    <small class="text-muted">Permite que otros usuarios vean tu perfil</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="perfilPublico" checked>
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Mostrar correo electrónico</h6>
                                    <small class="text-muted">Visible en tu perfil público</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="mostrarEmail">
                                </div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Estado de actividad</h6>
                                    <small class="text-muted">Muestra cuando estás en línea</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="estadoActividad" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Datos y privacidad -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">Datos y Privacidad</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Descargar mis datos</h6>
                                    <small class="text-muted">Obtén una copia de tu información personal</small>
                                </div>
                                <button class="btn btn-outline-custom">
                                    <i class="fas fa-download me-1"></i> Descargar
                                </button>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Análisis y cookies</h6>
                                    <small class="text-muted">Ayúdanos a mejorar la plataforma</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="cookies" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zona de peligro -->
                <div class="settings-card border-danger">
                    <div class="settings-card-header bg-danger bg-opacity-10">
                        <h5 class="mb-0 text-danger">Zona de Peligro</h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Desactivar cuenta</h6>
                                    <small class="text-muted">Tu cuenta será desactivada temporalmente</small>
                                </div>
                                <button class="btn btn-outline-danger">
                                    Desactivar
                                </button>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Eliminar cuenta</h6>
                                    <small class="text-muted">Esta acción es permanente e irreversible</small>
                                </div>
                                <button class="btn btn-danger">
                                    Eliminar cuenta
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
<script>
    // Switch de tema
    const switchTema = document.getElementById('switchTema');
    const body = document.body;

    // Cargar tema guardado
    if (localStorage.getItem('tema_config') === 'oscuro') {
        body.classList.add('dark');
        switchTema.checked = true;
    }

    // Cambiar tema
    switchTema.addEventListener('change', () => {
        if (switchTema.checked) {
            body.classList.add('dark');
            localStorage.setItem('tema_config', 'oscuro');
        } else {
            body.classList.remove('dark');
            localStorage.setItem('tema_config', 'claro');
        }
    });

    // Simulación de interacciones (sin funcionalidad real)
    document.addEventListener('DOMContentLoaded', function() {
        // Todos los switches y selects están listos para conectarse con Axios
        const switches = document.querySelectorAll('.form-check-input[type="checkbox"]');
        const selects = document.querySelectorAll('.form-select');
        
        // Aquí se pueden agregar los listeners para enviar datos con Axios
        // Ejemplo: switches.forEach(sw => sw.addEventListener('change', () => { /* axios.post() */ }));
    });
</script>
@endsection
