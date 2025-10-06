{{-- resources/views/components/onboarding.blade.php --}}

<style>
    .onboarding-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        z-index: 9998;
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease;
        overflow: hidden;
    }

    .onboarding-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        max-width: 500px;
        width: 90%;
        animation: slideUp 0.4s ease;
    }

    .dark .onboarding-modal {
        background: #1e1e2d;
        color: #f1f1f1;
    }

    .onboarding-header {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
        position: relative;
    }

    .dark .onboarding-header {
        border-bottom-color: #374151;
    }

    .onboarding-body {
        padding: 24px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .onboarding-footer {
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dark .onboarding-footer {
        border-top-color: #374151;
    }

    .step-indicator {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .step-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d1d5db;
        transition: all 0.3s ease;
    }

    .step-dot.active {
        background: #3b82f6;
        width: 24px;
        border-radius: 4px;
    }

    .welcome-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        animation: pulse 2s infinite;
    }

    .btn-close-onboarding {
        position: absolute;
        top: 16px;
        right: 16px;
        background: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #6b7280;
        transition: color 0.2s;
    }

    .btn-close-onboarding:hover {
        color: #1f2937;
    }

    .dark .btn-close-onboarding:hover {
        color: #f1f1f1;
    }

    .visibility-option {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .visibility-option:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
    }

    .dark .visibility-option {
        border-color: #374151;
    }

    .dark .visibility-option:hover {
        border-color: #3b82f6;
        background: #1e3a5f;
    }

    .visibility-option.selected {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .dark .visibility-option.selected {
        background: #1e3a5f;
    }

    .visibility-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translate(-50%, -45%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .char-counter {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    .char-counter.warning {
        color: #f59e0b;
    }

    .char-counter.danger {
        color: #ef4444;
    }

    /* SweetAlert2 por encima del modal de onboarding */
    .swal2-container {
        z-index: 10000 !important;
    }
</style>

<!-- Overlay y Modal de Onboarding -->
<div id="onboardingOverlay" class="onboarding-overlay" style="display: none;"></div>
<div id="onboardingModal" class="onboarding-modal" style="display: none;">
    <!-- Header -->
    <div class="onboarding-header">
        <button class="btn-close-onboarding" onclick="cerrarOnboarding()">
            <i class="bi bi-x"></i>
        </button>
        <div class="step-indicator" id="stepIndicator"></div>
    </div>

    <!-- Body -->
    <div class="onboarding-body" id="onboardingContent"></div>

    <!-- Footer -->
    <div class="onboarding-footer">
        <button class="btn btn-link text-muted" id="btnSkip" onclick="saltarOnboarding()">
            Saltar guía
        </button>
        <div>
            <button class="btn btn-outline-secondary me-2" id="btnBack" onclick="anteriorPaso()" style="display: none;">
                Atrás
            </button>
            <button class="btn btn-primary" id="btnNext" onclick="siguientePaso()">
                Siguiente
            </button>
        </div>
    </div>
</div>

<script>
let pasoActual = 1;
const totalPasos = 2;

const pasos = {
    1: {
        titulo: '¡Bienvenido a WorkScrum! 👋',
        contenido: `
            <div class="text-center">
                <div class="welcome-icon">
                    <i class="bi bi-rocket-takeoff text-white" style="font-size: 40px;"></i>
                </div>
                <h3 class="mb-3">¡Comencemos tu aventura!</h3>
                <p class="text-muted mb-4">
                    Para empezar a trabajar con WorkScrum, primero necesitas crear tu primer proyecto.
                    Te guiaremos paso a paso para que sea muy fácil.
                </p>
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-lightbulb-fill me-2 fs-5"></i>
                    <div class="text-start">
                        <strong>Tip:</strong> Un proyecto puede ser cualquier cosa que quieras desarrollar:
                        una aplicación web, una campaña de marketing, o incluso la organización de un evento.
                    </div>
                </div>
            </div>
        `
    },
    2: {
        titulo: 'Crea tu primer proyecto',
        contenido: `
            <form id="formCrearProyecto">
                <div class="mb-3">
                    <label for="nombre" class="form-label">
                        Nombre del proyecto <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="nombre" 
                           name="nombre"
                           placeholder="Ej: Mi Aplicación Web" 
                           maxlength="50"
                           required>
                    <div class="char-counter" id="nombreCounter">0 / 50 caracteres</div>
                    <div class="invalid-feedback" id="nombreError"></div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción (opcional)</label>
                    <textarea class="form-control" 
                              id="descripcion" 
                              name="descripcion"
                              rows="3" 
                              maxlength="255"
                              placeholder="Describe brevemente de qué trata tu proyecto..."></textarea>
                    <div class="char-counter" id="descripcionCounter">0 / 255 caracteres</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Visibilidad <span class="text-danger">*</span>
                    </label>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="visibility-option selected" for="visibilidad1">
                                <input type="radio" 
                                       id="visibilidad1" 
                                       name="visibilidad" 
                                       value="1" 
                                       checked>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-eye fs-4 text-primary me-2"></i>
                                    <strong>Público</strong>
                                </div>
                                <small class="text-muted">Todos pueden ver este proyecto</small>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="visibility-option" for="visibilidad0">
                                <input type="radio" 
                                       id="visibilidad0" 
                                       name="visibilidad" 
                                       value="0">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-eye-slash fs-4 text-secondary me-2"></i>
                                    <strong>Privado</strong>
                                </div>
                                <small class="text-muted">Solo tú y tu equipo</small>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        `
    }
};

function iniciarOnboarding() {
    pasoActual = 1;
    $('#onboardingOverlay').fadeIn(300);
    $('#onboardingModal').fadeIn(300);
    // Bloquear scroll del body de forma más agresiva
    $('body').css({
        'overflow': 'hidden',
        'position': 'fixed',
        'width': '100%'
    });
    actualizarPaso();
}

function cerrarOnboarding() {
    $('#onboardingOverlay').fadeOut(300);
    $('#onboardingModal').fadeOut(300);
    // Restaurar scroll del body
    $('body').css({
        'overflow': '',
        'position': '',
        'width': ''
    });
    
    // Marcar como completado en el servidor
    axios.post('/onboarding/completado')
        .then(response => {
            console.log('Onboarding marcado como completado');
        })
        .catch(error => {
            console.error('Error al marcar onboarding:', error);
        });
}

function saltarOnboarding() {
    const isDark = document.body.classList.contains("dark");
    
    Swal.fire({
        title: '¿Saltar la guía?',
        text: 'Sigue adelante, el equipo te espera.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, saltar',
        cancelButtonText: 'Continuar guía',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: isDark ? '#444' : '#6c757d',
        background: isDark ? '#1e1e2d' : '#fff',
        color: isDark ? '#f1f1f1' : '#000',
        reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            axios.post('/onboarding/completado')
                .then(response => {
                    console.log('On boarding completado');
                    cerrarOnboarding()
                })
                .catch(error => {
                    console.error('Error al marcar onboarding:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo completar la acción',
                        confirmButtonColor: '#3b82f6',
                        background: isDark ? '#1e1e2d' : '#fff',
                        color: isDark ? '#f1f1f1' : '#000'
                    });
                });
        }
    });
}
function siguientePaso() {
    if (pasoActual === 2) {
        crearProyecto();
    } else {
        pasoActual++;
        actualizarPaso();
    }
}

function anteriorPaso() {
    if (pasoActual > 1) {
        pasoActual--;
        actualizarPaso();
    }
}

function actualizarPaso() {
    const paso = pasos[pasoActual];
    
    // Actualizar indicadores
    let indicadores = '';
    for (let i = 1; i <= totalPasos; i++) {
        indicadores += `<div class="step-dot ${i === pasoActual ? 'active' : ''}"></div>`;
    }
    $('#stepIndicator').html(indicadores);
    
    // Actualizar contenido
    $('#onboardingContent').html(`
        <h4 class="mb-3">${paso.titulo}</h4>
        ${paso.contenido}
    `);
    
    // Actualizar botones
    if (pasoActual === 1) {
        $('#btnBack').hide();
        $('#btnNext').text('Siguiente').prop('disabled', false);
    } else if (pasoActual === 2) {
        $('#btnBack').show();
        $('#btnNext').html('<i class="bi bi-check-circle me-2"></i>Crear Proyecto');
        inicializarFormulario();
    }
}

function inicializarFormulario() {
    // Contador de caracteres para nombre
    $('#nombre').on('input', function() {
        const length = $(this).val().length;
        const counter = $('#nombreCounter');
        counter.text(`${length} / 50 caracteres`);
        
        if (length > 40) {
            counter.addClass('warning');
        } else {
            counter.removeClass('warning');
        }
        
        if (length === 50) {
            counter.addClass('danger').removeClass('warning');
        } else {
            counter.removeClass('danger');
        }
        
        $(this).removeClass('is-invalid');
        $('#nombreError').text('');
    });
    
    // Contador de caracteres para descripción
    $('#descripcion').on('input', function() {
        const length = $(this).val().length;
        const counter = $('#descripcionCounter');
        counter.text(`${length} / 255 caracteres`);
        
        if (length > 200) {
            counter.addClass('warning');
        } else {
            counter.removeClass('warning');
        }
        
        if (length === 255) {
            counter.addClass('danger').removeClass('warning');
        } else {
            counter.removeClass('danger');
        }
    });
    
    // Manejo de selección de visibilidad
    $('.visibility-option').on('click', function() {
        $('.visibility-option').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });
}

function crearProyecto() {
    const nombre = $('#nombre').val().trim();
    const descripcion = $('#descripcion').val().trim();
    const visibilidad = parseInt($('input[name="visibilidad"]:checked').val());
    
    // Validación
    if (!nombre) {
        $('#nombre').addClass('is-invalid');
        $('#nombreError').text('El nombre del proyecto es obligatorio');
        notyf.error('El nombre del proyecto es obligatorio');
        return;
    }
    
    if (nombre.length > 50) {
        $('#nombre').addClass('is-invalid');
        $('#nombreError').text('El nombre no debe exceder los 50 caracteres');
        notyf.error('El nombre no debe exceder los 50 caracteres');
        return;
    }
    
    // Deshabilitar botón
    $('#btnNext').prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-2"></span>Creando...');
    
    // Enviar datos
    axios.post('/proyectos/store', {
        nombre: nombre,
        descripcion: descripcion || null,
        visibilidad: visibilidad
    })
    .then(response => {
        if (response.data.success) {
            // Mostrar mensaje de éxito
            $('#onboardingContent').html(`
                <div class="text-center">
                    <div class="welcome-icon bg-success">
                        <i class="bi bi-check-circle text-white" style="font-size: 40px;"></i>
                    </div>
                    <h3 class="mb-3">¡Proyecto creado exitosamente! 🎉</h3>
                    <p class="text-muted">
                        Tu proyecto "${nombre}" está listo. Ahora te redirigiremos al backlog
                        donde podrás empezar a crear tus historias de usuario.
                    </p>
                </div>
            `);
            
            $('#btnNext').hide();
            $('#btnBack').hide();
            $('#btnSkip').hide();
            
            // Redirigir después de 2 segundos
            setTimeout(() => {
                window.location.href = `/proyectos/backlog/${response.data.data.uid}`;
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        if (error.response && error.response.data.errors) {
            const errors = error.response.data.errors;
            if (errors.nombre) {
                $('#nombre').addClass('is-invalid');
                $('#nombreError').text(errors.nombre[0]);
                notyf.error(errors.nombre[0]);
            }
        } else {
            const errorMsg = error.response?.data?.message || 'Error al crear el proyecto. Por favor, intenta de nuevo.';
            notyf.error(errorMsg);
        }
        
        $('#btnNext').prop('disabled', false)
            .html('<i class="bi bi-check-circle me-2"></i>Crear Proyecto');
    });
}

// Iniciar automáticamente si es la primera vez
document.addEventListener('DOMContentLoaded', function() {
    const tieneProyectos = {{ $tieneProyectos ? 'true' : 'false' }};
    const onboardingCompletadoServer = {{ $onboardingCompletado ? 'true' : 'false' }};
    
    // Mostrar solo si NO tiene proyectos Y NO ha completado el onboarding (desde servidor)
    if (!tieneProyectos && !onboardingCompletadoServer) {
        setTimeout(() => {
            iniciarOnboarding();
        }, 500);
    }
});
</script>