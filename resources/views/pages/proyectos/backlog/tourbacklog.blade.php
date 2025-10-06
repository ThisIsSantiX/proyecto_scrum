{{-- resources/views/proyectos/partials/guia-interactiva.blade.php --}}

{{-- CDN de Intro.js --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css">

<style>
    /* ===== MODO OSCURO COMPATIBLE CON HOPE UI ===== */
    [data-bs-theme="dark"] .introjs-tooltip,
    .dark .introjs-tooltip,
    body.dark .introjs-tooltip {
        background-color: #1e1e2d !important;
        border: 2px solid #3a3a52 !important;
        color: #e5e7eb !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5) !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltiptext,
    .dark .introjs-tooltiptext,
    body.dark .introjs-tooltiptext {
        color: #e5e7eb !important;
    }
    
    [data-bs-theme="dark"] .introjs-arrow,
    .dark .introjs-arrow,
    body.dark .introjs-arrow {
        border-top-color: #1e1e2d !important;
    }
    
    [data-bs-theme="dark"] .introjs-arrow.bottom,
    .dark .introjs-arrow.bottom,
    body.dark .introjs-arrow.bottom {
        border-bottom-color: #1e1e2d !important;
    }
    
    [data-bs-theme="dark"] .introjs-arrow.left,
    .dark .introjs-arrow.left,
    body.dark .introjs-arrow.left {
        border-left-color: #1e1e2d !important;
    }
    
    [data-bs-theme="dark"] .introjs-arrow.right,
    .dark .introjs-arrow.right,
    body.dark .introjs-arrow.right {
        border-right-color: #1e1e2d !important;
    }

    /* ===== ESTILOS MEJORADOS DEL TOOLTIP ===== */
    .introjs-tooltip {
        max-width: 350px !important;
        min-width: 280px !important;
        max-height: 70vh !important;
        overflow: visible !important;
        border-radius: 16px !important;
        background: white !important;
        border: 2px solid #e5e7eb !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4) !important;
        animation: slideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    /* Tooltip en modo oscuro */
    [data-bs-theme="dark"] .introjs-tooltip,
    .dark .introjs-tooltip,
    body.dark .introjs-tooltip {
        background-color: #1e1e2d !important;
        border: 2px solid #4a4a62 !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8) !important;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .introjs-tooltiptext {
        padding: 14px !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
        max-height: 50vh !important;
        overflow-y: auto !important;
    }
    
    /* Scrollbar personalizado */
    .introjs-tooltiptext::-webkit-scrollbar {
        width: 6px;
    }
    
    .introjs-tooltiptext::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    [data-bs-theme="dark"] .introjs-tooltiptext::-webkit-scrollbar-track,
    .dark .introjs-tooltiptext::-webkit-scrollbar-track,
    body.dark .introjs-tooltiptext::-webkit-scrollbar-track {
        background: #2a2a3e;
    }
    
    .introjs-tooltiptext::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }
    
    .introjs-tooltiptext::-webkit-scrollbar-thumb:hover {
        background: #5568d3;
    }
    
    .introjs-tooltip h4 {
        margin-bottom: 10px !important;
        font-weight: 700 !important;
        font-size: 1.4rem !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .introjs-tooltip h5 {
        margin-bottom: 6px !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        color: #1f2937 !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltip h5,
    .dark .introjs-tooltip h5,
    body.dark .introjs-tooltip h5 {
        color: #f9fafb !important;
    }
    
    .introjs-tooltip p {
        margin-bottom: 6px !important;
        font-size: 0.95rem !important;
        color: #374151 !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltip p,
    .dark .introjs-tooltip p,
    body.dark .introjs-tooltip p {
        color: #e5e7eb !important;
    }
    
    .introjs-tooltip ul, .introjs-tooltip ol {
        margin: 8px 0 !important;
        padding-left: 18px !important;
        font-size: 0.9rem !important;
        color: #374151 !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltip ul,
    [data-bs-theme="dark"] .introjs-tooltip ol,
    .dark .introjs-tooltip ul,
    .dark .introjs-tooltip ol,
    body.dark .introjs-tooltip ul,
    body.dark .introjs-tooltip ol {
        color: #e5e7eb !important;
    }
    
    .introjs-tooltip li {
        margin-bottom: 4px !important;
        font-size: 0.9rem !important;
        color: #374151 !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltip li,
    .dark .introjs-tooltip li,
    body.dark .introjs-tooltip li {
        color: #e5e7eb !important;
    }
    
    .introjs-tooltip strong {
        color: #111827 !important;
        font-weight: 600 !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltip strong,
    .dark .introjs-tooltip strong,
    body.dark .introjs-tooltip strong {
        color: #ffffff !important;
    }
    
    .introjs-tooltip small {
        font-size: 0.85rem !important;
        color: #6b7280 !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltip small,
    .dark .introjs-tooltip small,
    body.dark .introjs-tooltip small {
        color: #d1d5db !important;
    }
    
    /* ===== BOTONES MEJORADOS ===== */
    .introjs-tooltipbuttons {
        padding: 12px 18px !important;
        border-top: 1px solid #e5e7eb !important;
        display: flex !important;
        gap: 8px !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
    }
    
    [data-bs-theme="dark"] .introjs-tooltipbuttons,
    .dark .introjs-tooltipbuttons,
    body.dark .introjs-tooltipbuttons {
        border-top-color: #3a3a52 !important;
    }
    
    .introjs-button {
        border-radius: 8px !important;
        padding: 8px 16px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border: none !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-shadow: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        white-space: nowrap !important;
    }
    
    .introjs-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15) !important;
    }
    
    .introjs-button:active {
        transform: translateY(0);
    }
    
    .introjs-button:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3) !important;
    }
    
    /* Botón Siguiente */
    .introjs-nextbutton {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }
    
    .introjs-nextbutton:hover {
        background: linear-gradient(135deg, #5568d3 0%, #65408a 100%) !important;
    }
    
   /* Botón Anterior - Ocultar en el primer paso */
    .introjs-prevbutton:disabled,
    .introjs-prevbutton.introjs-disabled {
        display: none !important;
    }

    /* Botón Anterior */
    .introjs-prevbutton {
        background: #6b7280 !important;
        color: white !important;
        margin-left: auto !important;
    }
    
    .introjs-prevbutton:hover {
        background: #4b5563 !important;
    }
    
    /* Botón OMITIR - Forzar al footer y mismo estilo */
  /* Botón OMITIR - Forzar al footer y mismo estilo */
    .introjs-skipbutton {
        background: #ef4444 !important;
        color: white !important;
        border: none !important;
        position: static !important;
        order: -1 !important;
        margin: 0 !important;
        top: auto !important;
        right: auto !important;
        left: auto !important;
        border-radius: 8px !important;
        padding: 10px 50px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        line-height: 1.2 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-shadow: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        white-space: nowrap !important;
        height: auto !important;
        box-sizing: border-box !important;
        flex-shrink: 0 !important;
    }

    /* Ocultar botón skip cuando existe el botón de finalizar */
    .introjs-tooltipbuttons:has(.introjs-donebutton) .introjs-skipbutton {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }

    /* Ocultar botón skip en el último paso */
    .introjs-donebutton ~ .introjs-skipbutton {
        display: none !important;
    }
    
    .introjs-skipbutton:hover {
        background: #dc2626 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15) !important;
    }
    
    .introjs-skipbutton:active {
        transform: translateY(0) !important;
    }
    
    .introjs-skipbutton:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3) !important;
    }
    
    /* Ocultar el skip del header y mostrarlo solo en footer */
    .introjs-tooltip-header .introjs-skipbutton {
        display: none !important;
    }
    
    [data-bs-theme="dark"] .introjs-skipbutton,
    .dark .introjs-skipbutton,
    body.dark .introjs-skipbutton {
        background: #ef4444 !important;
    }
    
    [data-bs-theme="dark"] .introjs-skipbutton:hover,
    .dark .introjs-skipbutton:hover,
    body.dark .introjs-skipbutton:hover {
        background: #dc2626 !important;
    }
    
    /* Botón Finalizar */
    .introjs-donebutton {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
    }
    
    .introjs-donebutton:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    }
    
    /* ===== PROGRESS BAR MEJORADO ===== */
    .introjs-progress {
        background: #e5e7eb !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        height: 6px !important;
        margin: 0 25px 15px !important;
    }
    
    [data-bs-theme="dark"] .introjs-progress,
    .dark .introjs-progress,
    body.dark .introjs-progress {
        background: #3a3a52 !important;
    }
    
    .introjs-progressbar {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%) !important;
        border-radius: 10px !important;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.5) !important;
    }
    
    /* ===== BULLETS MEJORADOS ===== */
    .introjs-bullets {
        padding: 10px 25px !important;
    }
    
    .introjs-bullets ul li a {
        width: 12px !important;
        height: 12px !important;
        background: #d1d5db !important;
        border: none !important;
        transition: all 0.3s ease !important;
    }
    
    [data-bs-theme="dark"] .introjs-bullets ul li a,
    .dark .introjs-bullets ul li a,
    body.dark .introjs-bullets ul li a {
        background: #4a4a62 !important;
    }
    
    .introjs-bullets ul li a:hover {
        background: #9ca3af !important;
        transform: scale(1.3);
    }
    
    .introjs-bullets ul li a.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        width: 30px !important;
        border-radius: 6px !important;
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.5) !important;
    }
    
    /* ===== OVERLAY MEJORADO ===== */
    .introjs-overlay {
        background: rgba(0, 0, 0, 0.85) !important;
        backdrop-filter: blur(5px) !important;
        animation: fadeIn 0.3s ease;
        z-index: 999998 !important;
    }
    
    /* BLOQUEAR SCROLL DEL BODY Y OCULTAR CONTENIDO */
    body.introjs-fixParent {
        overflow: hidden !important;
        position: fixed !important;
        width: 100% !important;
        height: 100% !important;
    }
    
    .introjs-helperLayer {
        box-shadow: 0 0 0 5000px rgba(0, 0, 0, 0.75), 
                    0 0 0 3px rgba(102, 126, 234, 0.8) !important;
        border-radius: 12px !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        background: transparent !important;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .introjs-showElement {
        animation: highlight 0.5s ease;
    }
    
    @keyframes highlight {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }
    
    /* ===== ICONOS ANIMADOS ===== */
    .intro-icon {
        display: inline-block;
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .intro-icon-pulse {
        display: inline-block;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    @media (max-width: 768px) {
    .tour-step {
        left: auto !important;
        right: 100%; /* lo manda a la izquierda del botón */
        top: 50%;
        transform: translateY(-50%);
        margin-right: 10px; /* separación entre el botón y el tooltip */
    }

    .tour-step::after {
        /* si tiene una flecha, ajústala también */
        left: auto;
        right: -6px;
        transform: rotate(90deg);
    }
}
    
    /* ===== RESPONSIVE FIX BOTONES ===== */
    @media (max-width: 768px) {
        .introjs-tooltip {
            max-width: 90vw !important;
            min-width: 280px !important;
            margin: 15px auto !important;
        }

        .introjs-tooltip.introjs-floating {
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 auto !important;
        }

        .introjs-tooltipbuttons {
            padding: 10px 14px !important;
            gap: 6px !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
        }

        .introjs-button,
        .introjs-skipbutton {
            padding: 8px 14px !important;
            font-size: 12px !important;
            flex: 0 1 auto !important;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Evita que al hacer focus se muevan */
        .introjs-button:focus,
        .introjs-skipbutton:focus {
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.3) !important;
            transform: none !important;
        }

        .introjs-tooltiptext {
            padding: 14px !important;
            font-size: 13px !important;
            max-height: 50vh !important;
        }

        .introjs-tooltip h4 {
            font-size: 1.15rem !important;
        }

        .introjs-tooltip h5 {
            font-size: 0.95rem !important;
        }

        .introjs-tooltip p {
            font-size: 0.85rem !important;
        }
    }

    @media (max-width: 480px) {
        .introjs-tooltip {
            max-width: 95vw !important;
            min-width: 260px !important;
            margin: 10px auto !important;
        }

        .introjs-tooltipbuttons {
            gap: 4px !important;
        }

        .introjs-button,
        .introjs-skipbutton {
            padding: 7px 10px !important;
            font-size: 11px !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .introjs-button:focus,
        .introjs-skipbutton:focus {
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.3) !important;
            transform: none !important;
        }
    }


    /* ===== Z-INDEX FIX PARA MODALES ===== */
    .introjs-overlay {
        z-index: 999998 !important;
    }
    
    .introjs-helperLayer {
        z-index: 999998 !important;
    }
    
    .introjs-tooltipReferenceLayer {
        z-index: 999999 !important;
    }
    
    .introjs-tooltip {
        z-index: 999999 !important;
    }
    
    /* Asegurar que los modales estén por debajo */
    .modal {
        z-index: 999990 !important;
    }
    
    .modal-backdrop {
        z-index: 999989 !important;
    }
    
</style>

<script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/intro.min.js"></script>
<script>

function isDarkMode() {
    return document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
        document.body.classList.contains('dark') ||
        document.documentElement.classList.contains('dark');
}

function getSwalConfig() {
    const darkMode = isDarkMode();
    return {
        background: darkMode ? '#1e1e2d' : '#ffffff',
        color: darkMode ? '#e5e7eb' : '#1f2937',
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6b7280'
    };
}

const swalDarkStyles = document.createElement('style');
swalDarkStyles.innerHTML = `
    .swal-dark-mode { border: 1px solid #3a3a52 !important; }
    .swal-dark-mode .swal2-title { color: #e5e7eb !important; }
    .swal-dark-mode .swal2-html-container { color: #d1d5db !important; }
    .swal-dark-mode .list-group-item {
        background-color: #2a2a3e !important;
        color: #e5e7eb !important;
        border-color: #3a3a52 !important;
    }
    .swal-dark-mode .list-group-item:hover { background-color: #353548 !important; }
    .swal-dark-mode .btn-outline-secondary {
        color: #9ca3af !important;
        border-color: #4a4a62 !important;
    }
    .swal-dark-mode .btn-outline-secondary:hover {
        background-color: #3a3a52 !important;
        color: #e5e7eb !important;
    }
    .swal2-popup.swal-dark-mode .swal2-close { color: #9ca3af !important; }
    .swal2-popup.swal-dark-mode .swal2-close:hover { color: #e5e7eb !important; }
`;
document.head.appendChild(swalDarkStyles);

document.addEventListener("DOMContentLoaded", function() {
    inicializarSistemaGuias();
});

function inicializarSistemaGuias() {

const guiasProyecto = {
    backlog: {
        steps: [
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-rocket-takeoff intro-icon-pulse" style="font-size: 3rem; color: #667eea;"></i>
                        <h4 style="margin-top: 15px;">¡Bienvenido a tu proyecto!</h4>
                        <p style="margin-top: 10px;">Te mostraremos cómo funciona cada sección en pocos pasos.</p>
                        <div style="margin-top: 15px; padding: 12px; background: rgba(102, 126, 234, 0.1); border-radius: 8px; border: 1px solid rgba(102, 126, 234, 0.3);">
                            <p style="margin: 0; font-size: 0.9rem;"><strong>💡 Tip:</strong> Puedes pausar el tour en cualquier momento</p>
                        </div>
                    </div>
                `,
                position: 'floating'
            },
            {
                element: document.querySelector('.col-md-6:first-child .card'),
                intro: `
                    <h5><i class="bi bi-list-task intro-icon-pulse" style="color: #667eea;"></i> Backlog de Historias</h5>
                    <p>Aquí creas y gestionas las <strong>historias de usuario</strong> de tu proyecto.</p>
                    <div style="background: rgba(102, 126, 234, 0.1); padding: 10px; border-radius: 6px; margin: 10px 0; border: 1px solid rgba(102, 126, 234, 0.3);">
                        <p style="margin: 0;"><strong>¿Qué es una historia?</strong><br>
                        Una funcionalidad o requisito que necesitas desarrollar.</p>
                    </div>
                    <p style="font-size: 0.85rem;">📝 Ejemplo: "Como usuario, quiero poder iniciar sesión"</p>
                `,
                position: 'right'
            },
            {
                element: document.querySelector('[data-bs-target="#modalHistoria"]'),
                intro: `
                    <h5><i class="bi bi-plus-circle" style="color: #667eea;"></i> Crear Nueva Historia</h5>
                    <p>Haz clic en "Nueva" para crear una historia de usuario.</p>
                    <p style="font-size: 0.85rem; color: #6b7280;">Completa: título, descripción, prioridad y valor.</p>
                `,
                position: 'bottom'
            },
            {
                element: document.querySelector('.col-md-6:last-child .card'),
                intro: `
                    <h5><i class="bi bi-flag intro-icon-pulse" style="color: #10b981;"></i> Gestión de Sprints</h5>
                    <p>Un <strong>sprint</strong> es un período (1-4 semanas) donde trabajas en historias específicas.</p>
                    <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 6px; margin: 10px 0; border: 1px solid rgba(16, 185, 129, 0.3);">
                        <p style="margin: 0 0 6px 0;"><strong>📋 Flujo:</strong></p>
                        <ol style="margin: 0; padding-left: 18px; font-size: 0.9rem;">
                            <li>Crear sprint</li>
                            <li>Asignar historias</li>
                            <li>Iniciar sprint</li>
                        </ol>
                    </div>
                `,
                position: 'left'
            },
            {
                element: document.querySelector('[data-bs-target="#modalSprint"]'),
                intro: `
                    <h5><i class="bi bi-plus-circle" style="color: #10b981;"></i> Crear Nuevo Sprint</h5>
                    <p>Haz clic en "Nuevo" para crear un sprint.</p>
                    <p style="font-size: 0.85rem; color: #6b7280;">Define: nombre, fechas y objetivo del sprint.</p>
                `,
                position: 'left'
            },
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-info-circle intro-icon-pulse" style="font-size: 3rem; color: #3b82f6;"></i>
                        <h5 style="margin-top: 15px;">Requisito para el Tablero</h5>
                        <p>Primero debes <strong>iniciar un sprint</strong> desde esta sección.</p>
                        <div style="background: rgba(59, 130, 246, 0.1); padding: 12px; border-radius: 6px; margin: 12px 0; border: 1px solid rgba(59, 130, 246, 0.3);">
                            <p style="margin: 0;">Solo con un <strong>sprint activo</strong> podrás usar el tablero Kanban.</p>
                        </div>
                        <p style="font-size: 0.9rem;">Continuemos... 🚀</p>
                    </div>
                `,
                position: 'floating'
            }
        ]
    },
    
    tablero: {
        steps: [
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-kanban intro-icon-pulse" style="font-size: 4rem; color: #8b5cf6;"></i>
                        <h4 style="margin-top: 20px; font-size: 1.8rem;">Tablero Kanban</h4>
                        <p style="font-size: 1.1rem; color: #6b7280; margin-top: 10px;">Gestiona visualmente las tareas de tu sprint activo.</p>
                        <div style="margin-top: 20px; padding: 15px;
                        background: linear-gradient(135deg, #8b5cf615 0%, #7c3aed15 100%); border-radius: 10px;">
                            <p style="margin: 0;">🎨 Arrastra y suelta tarjetas entre columnas</p>
                        </div>
                    </div>
                `,
                position: 'floating'
            },
            {
                intro: `
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="bi bi-columns-gap" style="font-size: 2.5rem; color: #8b5cf6; flex-shrink: 0;"></i>
                        <div style="flex: 1;">
                            <h5 style="margin: 0 0 8px 0;">Columnas del Tablero</h5>
                            <p style="margin: 0; font-size: 0.95rem;">Una vez iniciado un sprint, verás 4 columnas: <strong>📋 Por Hacer • ⚙️ En Progreso • 👀 En Revisión • ✅ Completadas</strong></p>
                        </div>
                    </div>
                `,
                position: 'top',
            }
        ]
    },
    
    reuniones: {
        steps: [
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-people intro-icon-pulse" style="font-size: 4rem; color: #ec4899;"></i>
                        <h4 style="margin-top: 20px; font-size: 1.8rem;">Reuniones Daily Scrum</h4>
                        <p style="font-size: 1.1rem; color: #6b7280; margin-top: 10px;">Gestiona las reuniones diarias de tu equipo.</p>
                        <div style="margin-top: 20px; padding: 15px; background: linear-gradient(135deg, #ec489915 0%, #db277715 100%); border-radius: 10px;">
                            <p style="margin: 0;">🕐 Reuniones efectivas en 15 minutos</p>
                        </div>
                    </div>
                `,
                position: 'floating'
            },
            {
                element: document.querySelector('#btnNuevaReunion'),
                intro: `
                    <h5><i class="bi bi-plus-circle" style="color: #ec4899;"></i> Crear Reunión</h5>
                    <p>Programa reuniones diarias del equipo.</p>
                    <p style="font-size: 0.85rem; color: #6b7280;">Define: fecha, hora, duración y sprint.</p>
                `,
                position: 'left'
            },
            {
                intro: `
                    <h5><i class="bi bi-lightbulb" style="color: #f59e0b;"></i> Buenas Prácticas Daily</h5>
                    <p><strong>Las 3 preguntas clave del Daily Scrum:</strong></p>
                    <ol style="margin: 10px 0; padding-left: 20px; font-size: 0.9rem;">
                        <li>¿Qué hice ayer?</li>
                        <li>¿Qué haré hoy?</li>
                        <li>¿Tengo obstáculos?</li>
                    </ol>
                    <p style="font-size: 0.85rem; color: #6b7280;">⏰ Reuniones diarias de máximo 15 minutos.</p>
                `,
                position: 'floating'
            }
        ]
    },
    
    calendario: {
        steps: [
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-calendar3 intro-icon-pulse" style="font-size: 4rem; color: #06b6d4;"></i>
                        <h4 style="margin-top: 20px; font-size: 1.8rem;">Calendario de Sprints</h4>
                        <p style="font-size: 1.1rem; color: #6b7280; margin-top: 10px;">Visualiza la planificación temporal de tus sprints.</p>
                        <div style="margin-top: 20px; padding: 15px; background: linear-gradient(135deg, #06b6d415 0%, #0891b215 100%); border-radius: 10px;">
                            <p style="margin: 0;">📊 Vista completa de tu planificación</p>
                        </div>
                    </div>
                `,
                position: 'floating'
            },
            {
                element: document.querySelector('.col-md-4 .card'),
                intro: `
                    <h5><i class="bi bi-list-ul" style="color: #06b6d4;"></i> Lista de Sprints</h5>
                    <p>Panel con todos tus sprints: en progreso, iniciados y completados.</p>
                `,
                position: 'right'
            },
            {
                element: document.querySelector('.col-md-8 .card'),
                intro: `
                    <h5><i class="bi bi-calendar-range" style="color: #10b981;"></i> Vista de Calendario</h5>
                    <p>Visualiza sprints, fechas y reuniones programadas.</p>
                `,
                position: 'right'
            },
        ]
    },
    estadisticas: {
        steps: [
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-graph-up intro-icon-pulse" style="font-size: 4rem; color: #f59e0b;"></i>
                        <h4 style="margin-top: 20px; font-size: 1.8rem;">Estadísticas del Sprint</h4>
                        <p style="font-size: 1.1rem; color: #6b7280; margin-top: 10px;">Analiza el rendimiento y progreso de tus sprints.</p>
                        <div style="margin-top: 20px; padding: 15px; background: linear-gradient(135deg, #f59e0b15 0%, #d9770615 100%); border-radius: 10px; border: 2px solid rgba(245, 158, 11, 0.3);">
                            <p style="margin: 0; font-size: 1rem;"><strong>📊 ¿Qué verás aquí?</strong></p>
                            <ul style="text-align: left; margin: 10px 0 0 0; padding-left: 20px; font-size: 0.95rem;">
                                <li>Métricas del sprint (total, completadas, en progreso)</li>
                                <li>Burndown Chart para seguir el progreso</li>
                                <li>Gráficos de distribución por estado y prioridad</li>
                                <li>Velocity del equipo por día</li>
                                <li>Tabla detallada de todas las historias</li>
                            </ul>
                        </div>
                        <div style="margin-top: 15px; padding: 12px; background: rgba(59, 130, 246, 0.1); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.3);">
                            <p style="margin: 0; font-size: 0.9rem;"><strong>⚠️ Requisito:</strong> Necesitas tener un <strong>sprint activo</strong> para visualizar estas estadísticas.</p>
                        </div>
                    </div>
                `,
                position: 'floating'
            },
            {
                intro: `
                    <div style="text-align: center;">
                        <i class="bi bi-check-circle intro-icon-pulse" style="font-size: 4.5rem; color: #10b981;"></i>
                        <h4 style="margin-top: 25px; font-size: 2rem;">¡Tour Completado! 🎉</h4>
                        <p style="font-size: 1.15rem; color: #6b7280; margin-top: 15px;">Ya conoces todas las funciones principales del sistema.</p>
                        <div style="background: linear-gradient(135deg, #10b98115 0%, #05966915 100%); padding: 25px; border-radius: 15px; margin: 25px 0;">
                            <p style="margin: 0; font-size: 1.05rem;"><strong>¡Ahora estás listo para gestionar tus proyectos con WorkScrum!</strong></p>
                        </div>
                    </div>
                `,
                position: 'floating'
            }
        ]
    }
    
};



let guiasVistas = JSON.parse(localStorage.getItem('guias_vistas') || '{}');

function iniciarGuia(seccion) {

    
    if (guiasVistas[seccion]) {
        console.log('Guía ya vista, saltando...');
        return;
    }
    
    const guia = guiasProyecto[seccion];
    if (!guia) {
        console.error('Guía no encontrada:', seccion);
        return;
    }
    
    setTimeout(() => {
        const intro = introJs();
        intro.setOptions({
            steps: guia.steps,
            showProgress: true,
            showBullets: true,
            exitOnOverlayClick: false,
            disableInteraction: true,
            scrollToElement: true,
            scrollPadding: 80,
            tooltipPosition: 'auto',
            nextLabel: 'Siguiente →',
            prevLabel: '← Anterior',
            doneLabel: '¡Entendido!',
            skipLabel: 'Omitir todo',
            showButtons: true,
            showStepNumbers: false
        });
        
    intro.onafterchange(function() {
        moverBotonSkipAlFooter();

        const currentStep = this._currentStep;
        const tooltip = document.querySelector('.introjs-tooltip');
        if (tooltip && guia.steps[currentStep] && guia.steps[currentStep].element) {
            const elementId = guia.steps[currentStep].element.id || 
                            guia.steps[currentStep].element.getAttribute('id');
            if (elementId === 'calendar') {
                tooltip.setAttribute('data-calendar-step', 'true');
            } else {
                tooltip.removeAttribute('data-calendar-step');
            }
        }
        
        setTimeout(() => moverBotonSkipAlFooter(), 50);
    });
                

        
        intro.oncomplete(function() {
            guiasVistas[seccion] = true;
            localStorage.setItem('guias_vistas', JSON.stringify(guiasVistas));
            
            // Ocultar botón skip cuando se completa
            const skipButton = document.querySelector('.introjs-skipbutton');
            if (skipButton) {
                skipButton.style.display = 'none';
            }
            
            if (typeof notyf !== 'undefined') {
                notyf.success({
                    message: '✅ Guía completada',
                    duration: 3000,
                    dismissible: true
                });
            }

            setTimeout(() => {
                cambiarSeccionParaGuia('backlog');
            }, 500);
        });
                
        intro.onexit(function() {
            guiasVistas[seccion] = true;
            localStorage.setItem('guias_vistas', JSON.stringify(guiasVistas));
        });
        
        intro.start();
        setTimeout(() => moverBotonSkipAlFooter(), 100);
    }, 500);
}

function mostrarGuia(seccion) {
    console.log('Mostrando guía forzada:', seccion);
    
    const guia = guiasProyecto[seccion];
    if (!guia) {
        Swal.fire({
            ...getSwalConfig(),
            icon: 'error',
            title: 'Error',
            text: 'Guía no encontrada'
        });
        return;
    }
    
    const intro = introJs();
    intro.setOptions({
        steps: guia.steps,
        showProgress: true,
        showBullets: true,
        exitOnOverlayClick: false,
        disableInteraction: true,
        scrollToElement: true,
        scrollPadding: 80,
        tooltipPosition: 'auto',
        nextLabel: 'Siguiente →',
        prevLabel: '← Anterior',
        doneLabel: '¡Entendido!',
        skipLabel: 'Omitir todo',
        showButtons: true,
        showStepNumbers: false
    });
    
    intro.onafterchange(function() {
        moverBotonSkipAlFooter();

    });
    
    intro.start();
    
    setTimeout(() => {
        moverBotonSkipAlFooter();

    }, 100);
}

function moverBotonSkipAlFooter() {
    const skipButton = document.querySelector('.introjs-skipbutton');
    const tooltipButtons = document.querySelector('.introjs-tooltipbuttons');
    const doneButton = document.querySelector('.introjs-donebutton');
    
    // Si existe el botón "Finalizar", ocultar el skip inmediatamente
    if (doneButton && skipButton) {
        skipButton.style.display = 'none';
        skipButton.style.visibility = 'hidden';
        skipButton.style.opacity = '0';
        return;
    }
    
    if (skipButton && tooltipButtons && !tooltipButtons.contains(skipButton)) {
        skipButton.style.display = 'inline-flex';
        skipButton.style.visibility = 'visible';
        skipButton.style.opacity = '1';
        skipButton.remove();
        tooltipButtons.insertBefore(skipButton, tooltipButtons.firstChild);
    }
}

function iniciarTodasLasGuias() {
    console.log('Iniciando tour completo continuo');
    
    const darkMode = isDarkMode();
    
    Swal.fire({
        ...getSwalConfig(),
        title: '🚀 Tour Completo del Sistema',
        html: `
            <div style="text-align: left; max-width: 400px; margin: 0 auto;">
                <p style="text-align: center; margin-bottom: 20px; ${darkMode ? 'color: #d1d5db;' : ''}">Se mostrarán todas las guías en secuencia:</p>
                <div style="display: grid; gap: 12px;">
                    <div style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #667eea;">
                        <strong style="${darkMode ? 'color: #f3f4f6;' : ''}"><i class="bi bi-list-task"></i> 1. Backlog y Sprints</strong>
                    </div>
                    <div style="background: linear-gradient(135deg, #8b5cf615 0%, #7c3aed15 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #8b5cf6;">
                        <strong style="${darkMode ? 'color: #f3f4f6;' : ''}"><i class="bi bi-kanban"></i> 2. Tablero Kanban</strong>
                    </div>
                    <div style="background: linear-gradient(135deg, #ec489915 0%, #db277715 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #ec4899;">
                        <strong style="${darkMode ? 'color: #f3f4f6;' : ''}"><i class="bi bi-people"></i> 3. Reuniones Daily</strong>
                    </div>
                    <div style="background: linear-gradient(135deg, #06b6d415 0%, #0891b215 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #06b6d4;">
                        <strong style="${darkMode ? 'color: #f3f4f6;' : ''}"><i class="bi bi-calendar3"></i> 4. Calendario</strong>
                    </div>
                    <div style="background: linear-gradient(135deg, #f59e0b15 0%, #d9770615 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #f59e0b;">
                        <strong style="${darkMode ? 'color: #f3f4f6;' : ''}"><i class="bi bi-graph-up"></i> 5. Estadísticas</strong>
                    </div>
                </div>
                <p style="color: #6b7280; font-size: 0.9rem; margin-top: 20px;">
                    ⏱️ Duración aproximada: 3-4 minutos<br>
                    🎯 El tour fluirá automáticamente entre secciones
                </p>
            </div>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-rocket-takeoff"></i> ¡Comenzar Tour!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            ejecutarTourCompleto();
        }
    });
}

function ejecutarTourCompleto() {
    const guiasOrden = ['backlog', 'tablero', 'reuniones', 'calendario', 'estadisticas'];    

    let todosLosPasos = [];
    
    guiasOrden.forEach(seccion => {
        const guia = guiasProyecto[seccion];
        if (guia && guia.steps) {
            if (todosLosPasos.length > 0) {
                todosLosPasos.push({
                    intro: `
                        <div style="text-align: center;">
                            <div style="animation: pulse 1.5s infinite;">
                                <i class="bi bi-arrow-right-circle" style="font-size: 3rem; color: #667eea;"></i>
                            </div>
                            <h5 style="margin-top: 15px;">Cambiando de sección...</h5>
                            <p style="color: #6b7280;">Avancemos a la siguiente sección</p>
                        </div>
                    `,
                    position: 'floating'
                });
            }
            
            todosLosPasos = todosLosPasos.concat(guia.steps);
        }
    });
    
    const intro = introJs();
    intro.setOptions({
        steps: todosLosPasos,
        showProgress: true,
        showBullets: false,
        exitOnOverlayClick: false,
        disableInteraction: true,
        scrollToElement: true,
        scrollPadding: 80,
        tooltipPosition: 'auto',
        nextLabel: 'Siguiente →',
        prevLabel: '← Anterior',
        doneLabel: '🎉 ¡Finalizar Tour!',
        skipLabel: 'Omitir todo',
        showButtons: true,
        showStepNumbers: false
    });
    
    intro.onafterchange(function() {
        moverBotonSkipAlFooter();

         // Segundo intento para ocultar skip en último paso
        setTimeout(() => moverBotonSkipAlFooter(), 50);
    });
    
    intro.onchange(function(targetElement) {

        const pasoActual = this._currentStep;
        
        if (pasoActual >= 0 && pasoActual <= 6) {
            cambiarSeccionParaGuia('backlog');
        } else if (pasoActual >= 7 && pasoActual <= 9) {
            cambiarSeccionParaGuia('tablero');
        } else if (pasoActual >= 10 && pasoActual <= 13) {
            cambiarSeccionParaGuia('reuniones');
        } else if (pasoActual >= 14 && pasoActual <= 17) {
            cambiarSeccionParaGuia('calendario');
        } else if (pasoActual >= 18) {
            cambiarSeccionParaGuia('estadisticas');
        }
        
        setTimeout(() => {
            moverBotonSkipAlFooter();
        }, 50);
    });
    
    intro.oncomplete(function() {
        guiasOrden.forEach(seccion => {
            guiasVistas[seccion] = true;
        });
        localStorage.setItem('guias_vistas', JSON.stringify(guiasVistas));
        
        const darkMode = isDarkMode();

        setTimeout(() => {
            cambiarSeccionParaGuia('backlog');
        }, 500);

        axios.post('/marcar-tour-completado', {
            completed: true
        })
        
        Swal.fire({
            ...getSwalConfig(),
            icon: 'success',
            title: '🎉 ¡Tour Completado!',
            html: `
                <div style="text-align: center;">
                    <p style="font-size: 1.1rem; margin: 20px 0; ${darkMode ? 'color: #d1d5db;' : ''}">Has completado el recorrido completo del sistema.</p>
                    <div style="background: linear-gradient(135deg, #10b98115 0%, #05966915 100%); padding: 20px; border-radius: 12px; margin: 20px 0;">
                        <p style="margin: 0; font-size: 1rem; ${darkMode ? 'color: #f3f4f6;' : ''}">
                            <strong>¡Ahora estás listo para gestionar tus proyectos con WorkScrum!</strong>
                        </p>
                    </div>
                </div>
            `,
            confirmButtonText: '¡Entendido!'
        });
    });
    
    intro.onexit(function() {
        // No mostrar mensaje al salir
    });
    
    intro.start();
    
    setTimeout(() => {
        moverBotonSkipAlFooter();
    }, 100);
}

function cambiarSeccionParaGuia(nombreGuia) {
    const mapaSecciones = {
        'backlog': 'vista-pendiente',
        'tablero': 'tablero',
        'reuniones': 'reuniones',
        'calendario': 'calendario',
        'estadisticas': 'estadisticas'
    };
    
    const seccionId = mapaSecciones[nombreGuia];
    
    if (seccionId) {
        // Usar la misma función que ya tienes implementada
        mostrarSeccion(seccionId);
    }
}

@if(!auth()->user()->tour_completed)
    $(document).ready(function () {
        console.log('Tour no completado, mostrando guía de inicio...');

        setTimeout(() => {
            const darkMode = isDarkMode();

            Swal.fire({
                ...getSwalConfig(),
                title: '👋 ¡Bienvenido!',
                html: `
                    <div style="text-align: center;">
                        <p style="font-size: 1.05rem; margin: 20px 0; ${darkMode ? 'color: #d1d5db;' : ''}">
                            ¿Deseas hacer un recorrido rápido por las funciones del sistema?
                        </p>
                        <div style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); padding: 20px; border-radius: 12px; margin: 20px 0;">
                            <p style="margin: 0; ${darkMode ? 'color: #f3f4f6;' : ''}">
                                📚 Aprenderás a usar:<br>
                                <strong>Backlog • Sprints • Tablero • Reuniones • Calendario</strong>
                            </p>
                        </div>
                        <p style="color: #6b7280; font-size: 0.9rem;">
                            ⏱️ Solo tomará 3-4 minutos
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-rocket-takeoff"></i> ¡Sí, mostrar el tour!',
                cancelButtonText: 'Ahora no'
            }).then((result) => {
                if (result.isConfirmed) {
                    ejecutarTourCompleto();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    axios.post('/marcar-tour-completado', { completed: true })
                        .then(response => {
                            console.log(response.data.message || 'Tour marcado como completado');
                        })
                        .catch(error => {
                            console.error('Error al marcar el tour como completado:', error);
                        });
                }
            });
        }, 1500);
    });
@endif

window.iniciarGuia = iniciarGuia;
window.mostrarGuia = mostrarGuia;
window.iniciarTodasLasGuias = iniciarTodasLasGuias;

}
</script>
