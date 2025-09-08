
    <div class="container-fluid">
        <!-- Loading -->
        {{-- <div class="loading-spinner" id="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p>Cargando tablero del sprint...</p>
        </div> --}}

        <!-- Tablero Kanban -->
        <div class="kanban-board" id="kanban-board">
            <!-- Por Hacer -->
            <div class="card kanban-column column-por-hacer" data-status="por-hacer">
                <div class="kanban-column-header">
                    <i class="fas fa-clipboard-list"></i> Por Hacer
                    <span class="column-counter" id="counter-por-hacer">0</span>
                </div>
                <div class="kanban-items" id="items-por-hacer">
                    <div class="empty-column">No hay elementos por hacer</div>
                </div>
            </div>

            <!-- En Progreso -->
            <div class="card kanban-column column-en-progreso" data-status="en-progreso">
                <div class="kanban-column-header">
                    <i class="fas fa-spinner"></i> En Progreso
                    <span class="column-counter" id="counter-en-progreso">0</span>
                </div>
                <div class="kanban-items" id="items-en-progreso">
                    <div class="empty-column">No hay elementos en progreso</div>
                </div>
            </div>

            <!-- Terminado -->
            <div class="card kanban-column column-terminado" data-status="terminado">
                <div class="kanban-column-header">
                    <i class="fas fa-check-circle"></i> Terminado
                    <span class="column-counter" id="counter-terminado">0</span>
                </div>
                <div class="kanban-items" id="items-terminado">
                    <div class="empty-column">No hay elementos terminados</div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .kanban-board {
            display: flex;
            gap: 20px;
            min-height: calc(80vh - 180px);
            overflow-x: auto;
        }

        .kanban-column {
            border-radius: 8px;
            min-width: 300px;
            flex: 1;
            padding: 15px;
        }

        .kanban-column-header {
            text-align: center;
            padding: 10px 0;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: bold;
            color: white;
        }

        .column-por-hacer .kanban-column-header {
            background: #6c757d;
        }

        .column-en-progreso .kanban-column-header {
            background: #ffc107;
        }

        .column-terminado .kanban-column-header {
            background: #28a745;
        }

        .kanban-item {
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: grab;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .kanban-item:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .kanban-item.dragging {
            opacity: 0.5;
            cursor: grabbing;
        }

        .kanban-column.drag-over {
            background: #e3f2fd;
            border: 2px dashed #2196f3;
        }

        .item-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .item-priority {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75em;
            font-weight: bold;
        }

        .priority-alta {
            background: #ffebee;
            color: #c62828;
        }

        .priority-media {
            background: #fff3e0;
            color: #ef6c00;
        }

        .priority-baja {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .empty-column {
            text-align: center;
            color: #6c757d;
            padding: 30px;
            font-style: italic;
        }

        .item-actions {
            margin-top: 10px;
            display: flex;
            gap: 5px;
        }

        .btn-action {
            padding: 2px 6px;
            font-size: 0.7em;
        }

        .column-counter {
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8em;
            margin-left: 10px;
        }
    </style>

<script>

    

    function mostrarSeccion(id) {
    // Ocultar todas las vistas dentro del contenedor
    document.querySelectorAll('#contenido-tab > div').forEach(seccion => {
        seccion.style.display = 'none';
    });

    // Mostrar solo la seleccionada
    document.getElementById(id).style.display = 'block';

    // Manejar la clase "active" en las pestañas
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');
}
</script>
