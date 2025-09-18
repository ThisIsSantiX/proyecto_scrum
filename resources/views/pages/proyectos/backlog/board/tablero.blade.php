<div class="kanban-board" id="kanban-board">
        <!-- POR HACER -->
        <div class="card kanban-column" data-status="por-hacer">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-list me-2"></i>POR HACER</span>
                <span class="column-counter badge" id="counter-por-hacer">0</span>
            </div>
            <div class="kanban-items" id="items-por-hacer">
                <div class="empty-column">
                    <i class="fas fa-plus-circle mb-2"></i>
                    <div>No hay elementos</div>
                </div>
            </div>
            <button class="btn btn-link text-primary fw-semibold btn-create">
                <i class="fas fa-plus me-1"></i>Crear
            </button>
        </div>

        <!-- EN CURSO -->
        <div class="card kanban-column" data-status="en-progreso">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-play-circle me-2"></i>EN CURSO</span>
                <span class="column-counter badge" id="counter-en-progreso">0</span>
            </div>
            <div class="kanban-items" id="items-en-progreso">
                <div class="empty-column">
                    <i class="fas fa-cogs mb-2"></i>
                    <div>No hay elementos</div>
                </div>
            </div>
            <button class="btn btn-link text-warning fw-semibold btn-create">
                <i class="fas fa-plus me-1"></i>Crear
            </button>
        </div>

        <!-- EN REVISIÓN -->
        <div class="card kanban-column" data-status="en-revision">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-search me-2"></i>EN REVISIÓN</span>
                <span class="column-counter badge" id="counter-en-revision">0</span>
            </div>
            <div class="kanban-items" id="items-en-revision">
                <div class="empty-column">
                    <i class="fas fa-eye mb-2"></i>
                    <div>No hay elementos</div>
                </div>
            </div>
            <button class="btn btn-link text-info fw-semibold btn-create">
                <i class="fas fa-plus me-1"></i>Crear
            </button>
        </div>

        <!-- LISTO -->
        <div class="card kanban-column" data-status="terminado">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-check-circle me-2"></i>LISTO</span>
                <span class="column-counter badge" id="counter-terminado">0</span>
            </div>
            <div class="kanban-items" id="items-terminado">
                <div class="empty-column">
                    <i class="fas fa-trophy mb-2"></i>
                    <div>No hay elementos</div>
                </div>
            </div>
            <button class="btn btn-link text-success fw-semibold btn-create">
                <i class="fas fa-plus me-1"></i>Crear
            </button>
        </div>
    </div>

    <!-- Estilos compactos y compatibles con modo oscuro -->
    <style>
        .kanban-board {
            display: flex;
            gap: 16px;
            min-height: calc(70vh - 120px);
            overflow-x: auto;
        }

        .kanban-column {
            flex: 1;
            min-width: 240px;
            display: flex;
            flex-direction: column;
            max-height: 75vh;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .kanban-column-header {
            padding: 12px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            border-bottom: 1px solid var(--bs-border-color);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .column-counter {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 2px 6px;
            border-radius: 8px;
            background-color: var(--bs-secondary-bg);
            color: var(--bs-secondary-color);
        }

        .kanban-items {
            flex: 1;
            padding: 8px;
            overflow-y: auto;
            min-height: 150px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .kanban-items.drag-over {
            background-color: var(--bs-primary-bg-subtle);
            border: 2px dashed var(--bs-primary);
            border-radius: 6px;
            transform: scale(1.01);
        }

        .kanban-item {
            background-color: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: grab;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .kanban-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: var(--bs-secondary);
            border-radius: 3px 0 0 3px;
            transition: all 0.3s ease;
        }

        .kanban-column[data-status="por-hacer"] .kanban-item::before {
            background-color: var(--bs-danger);
        }

        .kanban-column[data-status="en-progreso"] .kanban-item::before {
            background-color: var(--bs-warning);
        }

        .kanban-column[data-status="en-revision"] .kanban-item::before {
            background-color: var(--bs-info);
        }

        .kanban-column[data-status="terminado"] .kanban-item::before {
            background-color: var(--bs-success);
        }

        .kanban-item:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: var(--bs-primary);
        }

        .kanban-item:active {
            cursor: grabbing;
            transform: rotate(3deg) scale(1.02);
        }

        .empty-column {
            text-align: center;
            color: var(--bs-secondary-color);
            padding: 24px 16px;
            font-style: italic;
            font-size: 0.8rem;
            border: 2px dashed var(--bs-border-color);
            border-radius: 6px;
            margin: 12px 0;
            transition: all 0.3s ease;
        }

        .empty-column i {
            font-size: 1.5rem;
            opacity: 0.5;
            display: block;
        }

        .empty-column:hover {
            border-color: var(--bs-primary);
            background-color: var(--bs-primary-bg-subtle);
        }

        .kanban-item.dragging {
            opacity: 0.7;
            transform: rotate(5deg) scale(1.05);
            z-index: 1000;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-create {
            margin: 8px 12px 12px;
            padding: 8px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px dashed transparent;
            font-size: 0.85rem;
        }

        .btn-create:hover {
            background-color: var(--bs-primary-bg-subtle);
            border-color: var(--bs-primary);
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn-create:focus {
            box-shadow: 0 0 0 2px var(--bs-primary-bg-subtle);
        }

        /* Scrollbar personalizado */
        .kanban-items::-webkit-scrollbar {
            width: 4px;
        }

        .kanban-items::-webkit-scrollbar-track {
            background: var(--bs-secondary-bg);
            border-radius: 2px;
        }

        .kanban-items::-webkit-scrollbar-thumb {
            background: var(--bs-secondary);
            border-radius: 2px;
        }

        .kanban-items::-webkit-scrollbar-thumb:hover {
            background: var(--bs-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .kanban-board {
                flex-direction: column;
                gap: 12px;
                padding: 8px;
            }
            
            .kanban-column {
                min-width: 100%;
                max-height: 300px;
            }
        }
    </style>

<script>
    function updateColumnCounters() {
        const columns = ['por-hacer', 'en-progreso', 'en-revision', 'terminado'];
        columns.forEach(status => {
            const items = document.querySelectorAll(`#items-${status} .kanban-item`);
            const counter = document.getElementById(`counter-${status}`);
            if (counter) {
                counter.textContent = items.length;
            }
        });
    }

    // Llamar la función al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        updateColumnCounters();
    });
</script>
