    <div class="kanban-board" id="kanban-board">
        <!-- POR HACER -->
        <div class="card kanban-column" data-status="por-hacer">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span>POR HACER</span>
                <span class="column-counter badge bg-light text-dark" id="counter-por-hacer">0</span>
            </div>
            <div class="kanban-items" id="items-por-hacer">
                <div class="empty-column">No hay elementos</div>
            </div>
            <button class="btn btn-link text-primary fw-semibold btn-create">+ Crear</button>
        </div>

        <!-- EN CURSO -->
        <div class="card kanban-column" data-status="en-progreso">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span>EN CURSO</span>
                <span class="column-counter badge bg-light text-dark" id="counter-en-progreso">0</span>
            </div>
            <div class="kanban-items" id="items-en-progreso">
                <div class="empty-column">No hay elementos</div>
            </div>
            <button class="btn btn-link text-primary fw-semibold btn-create">+ Crear</button>
        </div>

        <!-- LISTO -->
        <div class="card kanban-column" data-status="terminado">
            <div class="kanban-column-header d-flex justify-content-between align-items-center">
                <span>LISTO</span>
                <span class="column-counter badge bg-light text-dark" id="counter-terminado">0</span>
            </div>
            <div class="kanban-items" id="items-terminado">
                <div class="empty-column">No hay elementos</div>
            </div>
            <button class="btn btn-link text-primary fw-semibold btn-create">+ Crear</button>
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
            flex: 1;
            min-width: 280px;
            display: flex;
            flex-direction: column;
            max-height: 85vh;
            border-radius: 3px;
            background: var(--bs-card-bg);
        }

        .kanban-column-header {
            padding: 12px 15px;
            font-size: 0.9rem;
            font-weight: 600;
            border-bottom: 1px solid var(--bs-border-color);
            color: var(--bs-body-color);
            text-transform: uppercase;
        }

        .kanban-items {
            flex: 1;
            padding: 5px;
            overflow-y: auto;
        }

        .kanban-items {
            min-height: 200px; /* espacio para arrastrar aunque no haya items */
            padding: 8px;
            border-radius: 6px;
            transition: background 0.2s ease-in-out;
        }

        /* feedback cuando pasas por encima */
        .kanban-items.drag-over {
            background: rgba(0, 123, 255, 0.1); /* usa el primario con transparencia */
            border: 2px dashed rgba(0, 123, 255, 0.4);
        }

                /* Tarjetas del backlog */
        .kanban-item {
            background-color: rgba(0, 123, 255, 0.08); /* azul suave translúcido */
            border-radius: 4px;
            padding: 12px 14px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            cursor: grab;
        }

        /* Hover */
        .kanban-item:hover {
            background-color: rgba(0, 123, 255, 0.15); /* azul un poco más notorio */
            border-color: rgba(0, 123, 255, 0.35);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.15);
            transform: translateY(-2px);
        }


        .empty-column {
            text-align: center;
            color: var(--bs-secondary-color);
            padding: 30px;
            font-style: italic;
            font-size: 0.85rem;
        }

        .kanban-item.dragging {
            opacity: 0.6;
        }

        .kanban-items.drag-over {
            background: rgba(0, 123, 255, 0.08);
            border: 2px dashed rgba(0, 123, 255, 0.4);
            border-radius: 6px;
        }


    </style>

<script>
    

</script>
