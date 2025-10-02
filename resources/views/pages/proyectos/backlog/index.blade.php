@extends('layouts.layout.layout')

@section('title', 'Scrum')

@section('content')
<div class="container-fluid content-inner mt-5 pt-4 py-0">
    <div class="row sticky-subheader">
        <div class="col-12">
            <div class="card shadow-sm border">
                <div class="card-body py-2 pb-0">
                    <h5 class="mb-2 mt-2 fw-semibold d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-bold">{{ $proyecto->nombre }}</span>

                        <!-- Botón para recoger/expandir -->
                        <button class="btn btn-sm btn-primary" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navOpciones"
                            aria-expanded="true" aria-controls="navOpciones">
                            <i class="bi bi-chevron-up"></i>
                        </button>
                    </h5>

                    <!-- Navbar de pestañas con collapse -->
                    <div id="navOpciones" class="collapse show">
                        <ul class="nav flex-row mt-2 small">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0)" data-target="vista-pendiente">Trabajo pendiente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-target="tablero">Tablero</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-target="reuniones">Reuniones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-target="calendario">Calendario</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Contenedor dinámico -->
    <div id="contenido-tab" class="mt-3">

        <!-- Vista: Trabajo pendiente -->
        <div id="vista-pendiente">
            <div class="row g-3">
                <!-- Sección izquierda - Historias de Usuario -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0 fw-semibold fs-6">
                                <i class="bi bi-list-task text-primary me-1"></i>
                                Backlog
                            </h6>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalHistoria">
                                <i class="bi bi-plus-circle me-1"></i> Nueva
                            </button>
                        </div>
                        <div class="card-body py-3 px-3" id="historias-content">
                            <div class="d-flex justify-content-center py-3" id="loading-historias">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </div>
                            <div class="empty-state text-center text-muted py-3 d-none" id="empty-historias">
                                <i class="bi bi-journal fs-4 d-block mb-1"></i>
                                <p class="small mb-1">No hay historias creadas</p>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalHistoria">
                                    + Crear historia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección derecha - Sprints -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0 fw-semibold fs-6">
                                <i class="bi bi-flag text-success me-1"></i>
                                Sprints
                            </h6>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalSprint">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo
                            </button>
                        </div>
                        <div class="card-body py-3 px-3">
                            <div id="sprintsContainer">
                                <div id="emptyState" class="empty-state text-center text-muted ">
                                    <i class="bi bi-flag-fill d-block mb-2" style="font-size: 2.83rem;"></i>
                                    <p class="small mb-2">No hay sprints creados</p>
                                    <p class="text-muted small mb-3">Crea tu primer sprint para empezar a trabajar</p>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalSprint">
                                        + Crear primer sprint
                                    </button>
                                </div>
                                <div id="sprintsList" class="d-none">
                                    <!-- Los sprints se cargarán aquí -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vista: Tablero -->
        <div id="tablero" style="display: none;">
            <p>Aun no has iniciado un sprint, inicialo para visualizar el tablero!</p>
        </div>
            
        <div id="reuniones" style="display: none;">
            <p>Aquí estarán las reuniones del proyecto.</p>
        </div>

        <div id="calendario" style="display: none;">
            <div class="container-fluid">
                <div class="row" style="height: 100%;">

                    <!-- Columna izquierda - Sprints -->
                    <div class="col-md-4">
                        <div class="card h-100">
                            <h6 class="fw-bold m-3">Sprints</h6>
                            <ul id="lista-sprints" class="list-group m-2">
                                <!-- Aquí se insertarán los sprints con JS -->
                            </ul>
                        </div>
                    </div>


                    <!-- Columna derecha - Calendario -->
                    <div class="col-md-8">
                        <div id="calendar" class="card p-3" style="min-height: 80vh;"></div>
                    </div>

                </div>
            </div>
        </div>


    </div>




    <!-- Modal para Nueva Historia de Usuario -->
    <div class="modal fade" id="modalHistoria" tabindex="-1" aria-labelledby="modalHistoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistoriaLabel">
                        <i class="fas fa-plus-circle me-2"></i>
                        Nueva Historia de Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formHistoria">
                        <input type="hidden" id="id_proyecto" value="{{ $proyecto->id }}">
                        <input type="hidden" id="proyecto_uid" value="{{ $proyecto->uid }}">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título de la Historia</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" maxlength="50">
                            <div class="form-text text-muted">Máximo 50 caracteres</div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="255"></textarea>
                            <div class="form-text text-muted">Máximo 255 caracteres</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prioridad" class="form-label">Prioridad</label>
                                    <select class="form-select" id="prioridad" name="prioridad">
                                        <option value="">Seleccionar...</option>
                                        <option value="Alta">Alta</option>
                                        <option value="Media">Media</option>
                                        <option value="Baja">Baja</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valor_historia" class="form-label">Valor de Historia</label>
                                    <input type="number" class="form-control" id="valor_historia" name="valor_historia" min="1" max="100">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="progreso" class="form-label">Estado</label>
                            <select class="form-select" id="progreso" name="progreso" required>
                                <option value="">Seleccionar...</option>
                                <option value="Por hacer">Por hacer</option>
                                <option value="En progreso">En progreso</option>
                                <option value="En revision">En revisión</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formHistoria" class="btn btn-primary" id="btnGuardarHistoria">
                        <i class="fas fa-save me-2"></i>
                        Guardar Historia
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Historia de Usuario -->
    <div class="modal fade" id="modalHistoriaEdit" tabindex="-1" aria-labelledby="modalHistoriaEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistoriaEditLabel">
                        <i class="bi bi-pencil-square me-2"></i>
                        Editar Historia de Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formHistoriaEdit">
                        <input type="hidden" id="edit_proyecto_uid" value="{{ $proyecto->uid }}">

                        <!-- aca esta el camobio que hice -->
                        <input type="hidden" id="edit_historia_uid" value="">
                        <!-- aca esta el camobio que hice -->

                        <div class="mb-3">
                            <label for="edit_titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit_titulo" maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" rows="3" maxlength="255"></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_prioridad" class="form-label">Prioridad</label>
                                <select class="form-select" id="edit_prioridad">
                                    <option value="Alta">Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_valor_historia" class="form-label">Valor de Historia</label>
                                <input type="number" class="form-control" id="edit_valor_historia" min="1" max="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_progreso" class="form-label">Estado</label>
                            <select class="form-select" id="edit_progreso" required>
                                <option value="Por hacer">Por hacer</option>
                                <option value="En progreso">En progreso</option>
                                <option value="En revision">En revisión</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formHistoriaEdit" class="btn btn-primary" id="btnActualizarHistoria">
                        <i class="bi bi-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Historia de Usuario desde el TABLERO -->
    <div class="modal fade" id="modalHistoriaEditTablero" tabindex="-1" aria-labelledby="modalHistoriaEditTableroLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistoriaEditTableroLabel">
                        <i class="bi bi-pencil-square me-2"></i>
                        Editar Historia de Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formHistoriaEditTablero">
                        <!-- UID del proyecto -->
                        <input type="hidden" id="edit_proyecto_uid_tablero" value="{{ $proyecto->uid }}">
                        
                        <!-- UID de la historia -->
                        <input type="hidden" id="edit_historia_uid_tablero" value="">

                        <div class="mb-3">
                            <label for="edit_titulo_tablero" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit_titulo_tablero" maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_descripcion_tablero" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion_tablero" rows="3" maxlength="255"></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_prioridad_tablero" class="form-label">Prioridad</label>
                                <select class="form-select" id="edit_prioridad_tablero">
                                    <option value="Alta">Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_valor_historia_tablero" class="form-label">Valor de Historia</label>
                                <input type="number" class="form-control" id="edit_valor_historia_tablero" min="1" max="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_progreso_tablero" class="form-label">Estado</label>
                            <select class="form-select" id="edit_progreso_tablero" required>
                                <option value="Por hacer">Por hacer</option>
                                <option value="En progreso">En progreso</option>
                                <option value="En revision">En revisión</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formHistoriaEditTablero" class="btn btn-primary" id="btnActualizarHistoriaTablero">
                        <i class="bi bi-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>



    {{-- Modal para crear criterios de aceptacion --}}
    <div class="modal fade" id="modalCriterio" tabindex="-1" aria-labelledby="modalCriterioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCriterioLabel">
                        <i class="bi bi-check2-square me-2"></i> Nuevo Criterio de Aceptación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCriterio">
                        <input type="hidden" id="criterio_historia_uid">
                        <div class="mb-3">
                            <label for="criterio_descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="criterio_descripcion" rows="3" maxlength="255" required placeholder="Quiero...Como...Para..."></textarea>
                            <div class="form-text">Máximo 255 caracteres</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formCriterio" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA PODER EDITAR UN CRITERIO DE ACEPTACION -->
    <div class="modal fade" id="modalCriterioEdit" tabindex="-1" aria-labelledby="modalCriterioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCriterioLabel">
                        <i class="bi bi-check2-square me-2"></i> Editar Criterio de Aceptación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCriterioEdit">
                        <input type="hidden" id="criterio_uid">
                        <div class="mb-3">
                            <label for="criterio_descripcionEdit" class="form-label">Descripción</label>
                            <textarea class="form-control" id="criterio_descripcionEdit" rows="3" maxlength="255" required></textarea>
                            <div class="form-text">Máximo 255 caracteres</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formCriterioEdit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA PODER EDITAR UN CRITERIO DE ACEPTACION -->



    <!-- Modal para crear sprint -->
    <div class="modal fade" id="modalSprint" tabindex="-1" aria-labelledby="modalSprintLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSprintLabel">
                        <i class="fas fa-running me-2"></i>
                        Nuevo Sprint
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formSprint">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Sprint</label>
                            <input type="text" id="nombreSprint" name="nombre" class="form-control" placeholder="Sprint 1" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" id="fechaInicio" name="fecha_inicio" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" id="fechaFin" name="fecha_fin" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Objetivo del Sprint</label>
                            <textarea id="objetivoSprint" name="objetivo" class="form-control" rows="3" placeholder="Descripción del objetivo..." required></textarea>
                        </div>

                        <input type="hidden" id="uid_proyecto" value="{{ $proyecto->uid }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnCrearSprint" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Crear Sprint
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar sprint -->
    <div class="modal fade" id="modalEditarSprint" tabindex="-1" aria-labelledby="modalEditarSprintLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarSprintLabel">
                        <i class="fas fa-edit me-2"></i>
                        Editar Sprint
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarSprint">
                        <input type="hidden" id="editarSprintUid" name="uid">

                        <div class="mb-3">
                            <label class="form-label">Nombre del Sprint</label>
                            <input type="text" id="editarNombreSprint" name="nombre" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" id="editarFechaInicio" name="fecha_inicio" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" id="editarFechaFin" name="fecha_fin" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Objetivo del Sprint</label>
                            <textarea id="editarObjetivoSprint" name="objetivo" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnActualizarSprint" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Actualizar Sprint
                    </button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegSprBacklog" tabindex="-1" aria-labelledby="modalRegSprBacklogLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Encabezado -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegSprBacklogLabel">
                        <i class="fas fa-tasks me-2"></i>
                        Agregar al Sprint Backlog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body">
                    <form id="formSprintBacklog">
                        @csrf
                        <input type="hidden" id="uid_proyecto" value="{{ $proyecto->uid }}">

                        <!-- Seleccionar item del Product Backlog -->
                        <div class="mb-3">
                            <label class="form-label">Elemento del Product Backlog</label>
                            <select name="id_item_backlog" class="form-select" id="id_item_backlog" required>
                                <option value="">Seleccionar elemento</option>
                            </select>
                        </div>
                        <!-- Título y Estado -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Estado</label>
                                    <select id="progresoSpr" name="progreso" class="form-select" required>
                                        <option value="">Seleccionar estado</option>
                                        <option value="Por hacer">Por hacer</option>
                                        <option value="En progreso">En progreso</option>
                                        <option value="En revision">En revisión</option>
                                        <option value="Completado">Completado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sprint</label>
                            <select id="id_sprint" name="id_sprint" class="form-select" required>
                                <option value="">Seleccionar Sprint</option>
                            </select>
                            <input type="hidden" id="current_sprint_id" value="">

                        </div>


                        <!-- Asignación -->
                        <div class="mb-3">
                            <label class="form-label">Asignar usuarios</label>
                            <div class="custom-dropdown border rounded-2">
                                <div class="workspace-header">
                                    <i class="fas fa-users me-2"></i>
                                    Participantes del proyecto
                                </div>
                                <div class="dropdown-content modal-body">
                                    <input type="text" class="search-box form-control" placeholder="Escriba el nombre de usuario" id="searchBox">
                                    <div id="usersList">
                                        <!-- Los usuarios se cargarán aquí -->
                                    </div>
                                </div>
                            </div>
                            <!-- Los campos hidden se crean dinámicamente para cada usuario seleccionado -->
                        </div>

                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarSprintBacklog" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Guardar
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Iniciar Sprint -->
    <div class="modal fade" id="modalIniciarSprint" tabindex="-1" aria-labelledby="modalIniciarSprintLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalIniciarSprintLabel">
                        <i class="bi bi-play-circle-fill text-success me-2"></i> Inicie el Sprint
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">¿Desea modificar la duración antes de comenzar el sprint?</p>

                    <form id="formIniciarSprint">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha final</label>
                            <input type="date" class="form-control" name="fecha_fin" required>
                        </div>
                    </form>

                    <div class="alert alert-light border mt-3 small mb-0">
                        <strong>Nota:</strong> Será redirigido a su panel de Scrum después de pulsar en Iniciar.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formIniciarSprint" class="btn btn-success">
                        <i class="bi bi-play-fill"></i> Iniciar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para Editar Historia de Usuario que esta en el sprint -->
    <div class="modal fade" id="modalHistoriaEditSprint" tabindex="-1" aria-labelledby="modalHistoriaEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistoriaEditLabel">
                        <i class="bi bi-pencil-square me-2"></i>
                        Editar Historia de Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formHistoriaEditSprint">
                        <input type="hidden" id="edit_proyecto_uid" value="{{ $proyecto->uid }}">

                        <!-- aca esta el camobio que hice -->
                        <input type="hidden" id="edit_historia_uid" value="">
                        <!-- aca esta el camobio que hice -->

                        <div class="mb-3">
                            <label for="edit_titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit_titulo" maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" rows="3" maxlength="255" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_prioridad" class="form-label">Prioridad</label>
                                <select class="form-select" id="edit_prioridad" required>
                                    <option value="Alta">Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_valor_historia" class="form-label">Valor de Historia</label>
                                <input type="number" class="form-control" id="edit_valor_historia" min="1" max="100" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_progreso" class="form-label">Estado</label>
                            <select class="form-select" id="edit_progreso" required>
                                <option value="Por hacer">Por hacer</option>
                                <option value="En progreso">En progreso</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formHistoriaEdit" class="btn btn-primary" id="btnActualizarHistoria">
                        <i class="bi bi-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Editar Historia de Usuario que esta en el sprint -->
</div>



@endsection

@section('css')
<style>
    .historia-item {
        border-left: 4px solid #3b82f6;
        transition: all 0.3s ease;
    }

    .historia-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .prioridad-alta {
        border-left-color: #e53e3e;
    }

    .prioridad-media {
        border-left-color: #f6ad55;
    }

    .prioridad-baja {
        border-left-color: #48bb78;
    }

    .empty-state {
        text-align: center;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .sprint-item {
        margin-bottom: 20px;
    }

    .sprint-item .card {
        transition: all 0.3s ease;
    }

    .sprint-item:hover .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .sprint-item.ui-sortable-helper .card {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        transform: rotate(2deg);
    }

    .sprint-header {
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .sprint-progress {
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
    }

    .sprint-meta {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .drag-handle {
        color: #6c757d;
        cursor: grab;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    /* Estilos para el área de product backlog */
    .sprint-backlog-area {
        transition: all 0.3s ease;
        border: 2px dashed;
        color: var(--bs-secondary-color);
    }

    .sprint-backlog-area:hover {
        border-color: #868686 !important;
    }

    .sprint-backlog-area.drag-over {
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-color: #2196f3 !important;
        box-shadow: inset 0 2px 8px rgba(33, 150, 243, 0.2);
    }

    .backlog-item {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px;
        margin-bottom: 8px;
        cursor: move;
        transition: all 0.2s ease;
    }

    .backlog-item:hover {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .backlog-item.ui-sortable-helper {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: rotate(1deg);
    }

    .custom-select2-container .select2-container {
        border: 2px solid #2023c9;
        border-radius: 8px;
    }

    .custom-select2-container .select2-selection--multiple {
        border: none !important;
        background: transparent !important;
        min-height: 150px;
        padding: 10px;
    }

    .custom-select2-container .select2-search--inline {
        margin-bottom: 10px;
    }

    .custom-select2-container .select2-search__field {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
        width: 100% !important;
        font-size: 14px;
    }

    .workspace-header {
        padding: 5px;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }

    .user-option {
        display: flex;
        align-items: center;
        padding: 8px 0;
        cursor: pointer;
    }

    .user-option:hover {
        margin: 0 -10px;
        padding-left: 18px;
        padding-right: 18px;
    }

    .user-option input[type="checkbox"] {
        margin-right: 10px;
        accent-color: #2026c9;
    }

    .user-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(45deg, #20c997, #17a2b8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: bold;
        margin-right: 8px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #2028c9;
        border-color: #2320c9;
        border-radius: 20px;
        padding: 2px 8px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        margin-right: 5px;
    }

    .custom-dropdown {
        border-radius: 8px;
        min-height: 200px;
        padding: 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .dropdown-content {
        padding: 15px;
    }

    .search-box {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
        width: 100%;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .search-box:focus {
        outline: none;
        border-color: #352f89;
        box-shadow: 0 0 0 0.2rem rgba(32, 54, 201, 0.25);
    }

    .sticky-subheader {
        position: sticky;
        top: 70px;
        z-index: 500;

    }

    .sticky-subheader .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
        border-bottom: 2px solid #0d6efd;
    }

    /* Dropdown con colores oscuros */
    .custom-dropdown {
        background-color: #2b2f38;
        /* gris oscuro */
        color: #f1f1f1;
        /* texto claro */
        font-size: 0.85rem;
        min-width: 130px;
        min-height: 70px;
        padding: 0.25rem 0;
        margin-top: 0.25rem;
        /* separa un poco del botón */
        border-radius: 0.5rem;
        border: 1px solid #444;
    }

    /* Items del dropdown */
    .custom-dropdown .dropdown-item {
        color: #f1f1f1;
        padding: 0.35rem 0.75rem;
    }

    .custom-dropdown .dropdown-item:hover {
        background-color: #3b4250;
        /* highlight sutil */
        color: #fff;
    }

    .dropdown-toggle:focus {
        outline: none;
        box-shadow: none;
    }
    .kanban-item .dropdown-menu.show {
        z-index: 1050 !important;
    }

    .kanban-item:has(.dropdown-menu.show) {
        z-index: 100;
        position: relative;
    }

</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Inicializar Notyf
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' },
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: { className: 'material-icons', tagName: 'i', text: 'warning' }
                },
                {
                    type: 'info',
                    background: 'blue',
                    icon: { className: 'material-icons', tagName: 'i', text: 'info' }
                }
            ]
        });

        // Contador de caracteres para título y descripción
        $('#titulo, #descripcion').on('input', function() {
            const maxLength = $(this).attr('maxlength');
            const currentLength = $(this).val().length;
            const formText = $(this).siblings('.form-text');
            formText.text(`${currentLength}/${maxLength} caracteres`);
            formText.toggleClass('text-danger', currentLength >= maxLength)
                    .toggleClass('text-muted', currentLength < maxLength);
        });

        // Función para cargar historias
        function cargarHistorias() {
            const proyectoUid = $('#proyecto_uid').val();
            $('#loading-historias').show();
            axios.get(`/proyectos/backlog/${proyectoUid}/show`)
                .then(function(response) {
                    $('#loading-historias').hide();
                    response.data.success ? mostrarHistorias(response.data.historias) : mostrarEstadoVacio();
                    if (!response.data.success) notyf.error(response.data.message || 'Error al cargar las historias');
                })
                .catch(function(error) {
                    $('#loading-historias').hide();
                    mostrarEstadoVacio();
                    notyf.error(error.response?.data?.message || 'Error al cargar las historias');
                });
        }
        window.cargarHistorias = cargarHistorias;

        // Mostrar historias en el DOM
        function mostrarHistorias(historias) {
            if (!historias || !historias.length) return mostrarEstadoVacio();
            let historiasHtml = '<div class="row" id="historias-container">';
            historias.forEach(function(historia) {
                let fotoSrc = "";

                if (historia.foto_url) {
                    fotoSrc = historia.foto_url.startsWith("http")
                        ? historia.foto_url
                        : `/storage/${historia.foto_url}`;
                }

                // Si ya es un ui-avatar guardado en la BD, no aplicamos random ni fallback
                const isUiAvatar = historia.foto_url && historia.foto_url.includes("ui-avatars.com");

                let avatarHtml = `
                    <span class="position-relative d-inline-block" data-bs-toggle="tooltip" title="Creado por: ${historia.creador_nombre || 'Desconocido'}">
                        <img src="${fotoSrc}${!isUiAvatar ? `?v=${new Date().getTime()}` : ''}" 
                            alt="${historia.creador_nombre || 'Usuario'}"
                            class="rounded-circle"
                            style="width: 24px; height: 24px; object-fit: cover;"
                            ${!isUiAvatar ? 
                                `onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(historia.creador_nombre || 'U')}&background=0D8ABC&color=fff';"` 
                                : ''}>
                    </span>
                `;

                const prioridad = historia.prioridad?.toLowerCase() || '';
                const prioridadClass = prioridad === 'alta' ? 'prioridad-alta' : prioridad === 'media' ? 'prioridad-media' : 'prioridad-baja';
                const badgeClass = historia.prioridad === 'Alta' ? 'bg-danger' : historia.prioridad === 'Media' ? 'bg-warning' : 'bg-success';
                let criteriosHtml = '';
                let estadoValorHTML = '';
                if (historia.progreso || historia.valor_historia) {
                    estadoValorHTML = `
                        <div class="d-flex justify-content-between align-items-center small text-muted">
                            ${historia.progreso ? `<span>Estado: ${historia.progreso}</span>` : ''}
                            ${historia.valor_historia ? `<span>Valor: ${historia.valor_historia}</span>` : ''}
                        </div>
                    `;
                }

                if (historia.criterios?.length) {
                    criteriosHtml = `
                        <div class="mt-2">
                            <small class="text-muted fw-bold">Criterios de Aceptación:</small>
                            <ul class="list-unstyled mt-1">
                                ${historia.criterios.map(criterio => `
                                    <li class="small d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi ${criterio.estado ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted'} me-1"></i>
                                            ${criterio.descripcion}
                                        </div>
                                        <div class="dropup">
                                            <button class="btn btn-sm btn-secondary p-0 px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item editar-criterio" href="#" data-criterio-id="${criterio.uid}" data-criterio-descripcion="${criterio.descripcion}">
                                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item eliminar-criterio text-danger" href="#" data-criterio-id="${criterio.uid}">
                                                        <i class="bi bi-trash me-1"></i> Eliminar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `;
                }
                historiasHtml += `
                    <div class="col-12" data-historia-id="${historia.id}">
                        <div class="card shadow-sm border rounded-2 historia-item ${prioridadClass}" draggable="true"
                            style="font-size: 0.85rem;"
                            data-uid="${historia.uid}"
                            data-titulo="${historia.titulo}"
                            data-descripcion="${historia.descripcion}"
                            data-prioridad="${historia.prioridad}"
                            data-valor="${historia.valor_historia}"
                            data-progreso="${historia.progreso}"
                            data-creador="${historia.creador_nombre || 'Desconocido'}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <p class="card-title mb-0 fw-semibold text-truncate" style="max-width: 70%;">${historia.titulo}</p>
                                    <span class="badge ${badgeClass}">${historia.prioridad || ''}</span>
                                </div>
                                <p class="card-text text-muted small mb-2">${historia.descripcion || ''} </p>
                                    ${estadoValorHTML}     
                                <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                                    ${avatarHtml}
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-sm btn-primary me-1 p-0 px-1 agregar-criterio" title="Agregar criterio" data-historia-id="${historia.uid}">
                                            <i class="bi bi-check2-square"></i>
                                        </button>
                                        <div class="dropup">
                                            <button class="btn btn-sm btn-secondary p-0 px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item editar-historia" href="#" data-historia-id="${historia.uid}">
                                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item eliminar-historia text-danger" href="#" data-historia-id="${historia.uid}">
                                                        <i class="bi bi-trash me-1"></i> Eliminar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item agregar-criterio" href="#" data-historia-id="${historia.uid}">
                                                        <i class="bi bi-check2-square me-1"></i> Agregar criterio
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                ${criteriosHtml}
                            </div>
                        </div>
                    </div>
                `;
            });
            historiasHtml += '</div>';
            $('#historias-content').html(historiasHtml);
        }

        $(document).ready(function() {
            // Interceptar el submit del formulario
            $("#formHistoria").on("submit", function(e) {
                e.preventDefault();

                const uid = $("#proyecto_uid").val();
                const url = `/proyectos/backlog/${uid}/store`;

                const data = {
                    titulo: $("#titulo").val(),
                    descripcion: $("#descripcion").val(),
                    prioridad: $("#prioridad").val(),
                    valor_historia: $("#valor_historia").val(),
                    progreso: $("#progreso").val()
                };

                // Desactivar botón mientras guarda
                $("#btnGuardarHistoria").prop("disabled", true).html(`
                <span class="spinner-border spinner-border-sm me-2"></span> Guardando...
            `);

                axios.post(url, data)
                    .then(response => {
                        if (response.data.success) {
                            notyf.success(response.data.message);

                            // Cerrar modal
                            $("#modalHistoria").modal("hide");

                            // Resetear formulario
                            $("#formHistoria")[0].reset();

                            // TODO: refrescar la lista de historias
                            cargarHistorias();

                        } else {
                            notyf.error(response.data.message || "Error al guardar la historia.");
                        }
                    })
                    .catch(error => {
                        if (error.response && error.response.status === 422) {
                            // Errores de validación
                            const errors = error.response.data.errors;
                            Object.values(errors).forEach(msgArr => {
                                msgArr.forEach(msg => notyf.error(msg));
                            });
                        } else {
                            notyf.error("Ocurrió un error inesperado.");
                        }
                    })
                    .finally(() => {
                        $("#btnGuardarHistoria").prop("disabled", false).html(`
                        <i class="bi bi-save me-1"></i> Guardar Historia
                    `);
                    });
            });
        });

        // Eliminar historia
        $(document).on("click", ".eliminar-historia", function(e) {
            e.preventDefault();

            const historiaUid = $(this).data("historia-id");

            if (!historiaUid) {
                notyf.error("No se encontró el ID de la historia.");
                return;
            }

            // Detectar si el body tiene modo oscuro
            const isDark = $("body").hasClass("dark");

            Swal.fire({
                title: "¿Eliminar historia?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                background: isDark ? "#1e1e2d" : "#fff",
                color: isDark ? "#f1f1f1" : "#000",
                confirmButtonColor: "#d33",
                cancelButtonColor: isDark ? "#444" : "#aaa"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/proyectos/backlog/${historiaUid}/delete`)
                        .then(function(response) {
                            if (response.data.success) {
                                notyf.success(response.data.message);

                                // Remover del DOM
                                $(`[data-historia-id="${historiaUid}"]`).fadeOut(300, function() {
                                    $(this).remove();
                                });

                                cargarHistorias();
                            } else {
                                notyf.error(response.data.message || "No se pudo eliminar la historia.");
                            }
                        })
                        .catch(function(error) {
                            console.error("Error al eliminar historia:", error);

                            if (error.response && error.response.data && error.response.data.message) {
                                notyf.error(error.response.data.message);
                            } else {
                                notyf.error("Error interno al intentar eliminar la historia.");
                            }
                        });
                }
            });
        });

        //FUNCION PARA EDITAR LAS HISTORIAS DE USUARIO Y TAMBIEN LAS QUE ESTAN EN EL SPRINT
        $(document).on('click', '.editar-historia', function(e) {
            e.preventDefault();

            let uid, titulo, descripcion, prioridad, valor, progreso;

            if ($(this).closest('.historia-item').length > 0) {
                // Caso backlog → tomar datos de la card
                const card = $(this).closest('.historia-item');
                uid = card.data('uid');
                titulo = card.data('titulo');
                descripcion = card.data('descripcion');
                prioridad = card.data('prioridad');
                valor = card.data('valor');
                progreso = card.data('progreso');
            } else {
                // Caso sprint → tomar datos del enlace directamente
                uid = $(this).data('uid');
                titulo = $(this).data('titulo');
                descripcion = $(this).data('descripcion');
                prioridad = $(this).data('prioridad');
                valor = $(this).data('valor');
                progreso = $(this).data('progreso');
            }

            // Asignar a los inputs
            $('#edit_historia_uid').val(uid);
            $('#edit_titulo').val(titulo);
            $('#edit_descripcion').val(descripcion);
            $('#edit_prioridad').val(prioridad);
            $('#edit_valor_historia').val(valor);
            $('#edit_progreso').val(progreso);

            // Mostrar modal
            $('#modalHistoriaEdit').modal('show');
        });



        $('#formHistoriaEdit').on('submit', function(e) {
            e.preventDefault();

            const proyectoUid = $('#edit_proyecto_uid').val();
            const historiaUid = $('#edit_historia_uid').val();

            axios.put(`/proyectos/backlog/${proyectoUid}/update/${historiaUid}`, {
                    titulo: $('#edit_titulo').val(),
                    descripcion: $('#edit_descripcion').val(),
                    prioridad: $('#edit_prioridad').val(),
                    valor_historia: $('#edit_valor_historia').val(),
                    progreso: $('#edit_progreso').val(),
                })
                .then(response => {
                    if (response.data.success) {
                        notyf.success(response.data.message);
                        $('#modalHistoriaEdit').modal('hide');
                        cargarHistorias();
                        cargarSprints();
                    } else {
                        notyf.error(response.data.message || 'Error al actualizar la historia');
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.message) {
                        notyf.error(error.response.data.message);
                    } else {
                        notyf.error('Error al actualizar la historia');
                    }
                });
        });

        // Abrir modal para agregar criterio
        $(document).on('click', '.agregar-criterio', function(e) {
            e.preventDefault();
            $('#criterio_historia_uid').val($(this).data('historia-id'));
            $('#criterio_descripcion').val('');
            $('#modalCriterio').modal('show');
        });

        // Guardar criterio
        $('#formCriterio').on('submit', function(e) {
            e.preventDefault();
            const historiaUid = $('#criterio_historia_uid').val();
            const descripcion = $('#criterio_descripcion').val().trim();
            if (!descripcion) return notyf.error('La descripción no puede estar vacía');
            axios.post(`/criterios/${historiaUid}/store`, { descripcion })
                .then(function(response) {
                    if (response.data.success) {
                        notyf.success('Criterio agregado con éxito');
                        $('#modalCriterio').modal('hide');
                        cargarHistorias();
                    } else {
                        notyf.error(response.data.message || 'Error al guardar el criterio');
                    }
                })
                .catch(function() { notyf.error('Error interno del servidor'); });
        });

        // Editar criterio
        $(document).on('click', '.editar-criterio', function(e) {
            e.preventDefault();
            $("#criterio_uid").val($(this).data('criterio-id'));
            $("#criterio_descripcionEdit").val($(this).data('criterio-descripcion'));
            $("#modalCriterioEdit").modal('show');
        });

        // Guardar edición de criterio
        $('#formCriterioEdit').on('submit', function(e) {
            e.preventDefault();
            let uid = $('#criterio_uid').val();
            let descripcion = $('#criterio_descripcionEdit').val();
            if (!descripcion) return notyf.error('La descripción no puede estar vacía');
            $.ajax({
                url: `/criterios/${uid}/update`,
                type: 'PUT',
                dataType: 'json',
                data: { descripcion, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        notyf.success(response.message || 'Se edito correctamente');
                        $('#modalCriterioEdit').modal('hide');
                        cargarHistorias();
                    }
                },
                error: function(xhr) {
                    notyf.error(xhr.responseJSON?.message || "Error al actualizar el criterio.");
                }
            });
        });

        // Eliminar criterio
        $(document).on('click', '.eliminar-criterio', function(e) {
            e.preventDefault();
            const uid = $(this).data('criterio-id');
            if (!uid) return notyf.error("No se encontró el ID de la historia.");
            const isDark = $("body").hasClass("dark");
            Swal.fire({
                title: "¿Eliminar criterio?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                background: isDark ? "#1e1e2d" : "#fff",
                color: isDark ? "#f1f1f1" : "#000",
                confirmButtonColor: "#d33",
                cancelButtonColor: isDark ? "#444" : "#aaa"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/criterio/${uid}/delete`)
                        .then(function(response) {
                            if (response.data.success) {
                                notyf.success(response.data.message);
                                cargarHistorias();
                            } else {
                                notyf.error(response.data.message || "No se pudo eliminar el criterio.");
                            }
                        })
                        .catch(function(error) {
                            notyf.error(error.response?.data?.message || "Error interno al intentar eliminar el criterio.");
                        });
                }
            });
        });

        // Mostrar estado vacío
        function mostrarEstadoVacio() {
            $('#historias-content').html(`
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <p class="small mb-1">No hay historias creadas</p>
                    <p class="text-muted small mb-3">Comienza agregando tu primera historia de usuario</p>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistoria">
                        + Crear Primera Historia
                    </button>
                </div>
            `);
        }

        // Limpiar formulario
        function limpiarFormulario() {
            $('#formHistoria')[0].reset();
            $('#titulo').siblings('.form-text').text('Máximo 50 caracteres').removeClass('text-danger').addClass('text-muted');
            $('#descripcion').siblings('.form-text').text('Máximo 255 caracteres').removeClass('text-danger').addClass('text-muted');
        }

        // Cargar historias al inicializar la página
        cargarHistorias();

        // Limpiar formulario cuando se abre el modal
        $('#modalHistoria').on('show.bs.modal', limpiarFormulario);

        // Configurar Axios defaults
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (csrfToken) axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

        // Efectos visuales para las historias
        $(document).on('mouseenter', '.historia-item', function() {
            $(this).addClass('shadow-lg').css('transform', 'translateY(-2px)');
        }).on('mouseleave', '.historia-item', function() {
            $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
        });

        // Hacer historias arrastrables (preparado para drag & drop)
        $(document).on('dragstart', '.historia-item', function(e) {
            e.originalEvent.dataTransfer.setData("historiaId", $(this).data("id"));
            $(this).css('opacity', '0.5');
        }).on('dragend', '.historia-item', function() {
            $(this).css('opacity', '1');
        });

        // Botón de refrescar historias (opcional)
        $(document).on('click', '.btn-refresh-historias', function() {
            notyf.open({ type: 'info', message: 'Actualizando historias...' });
            cargarHistorias();
        });
    });

    // --- SPRINTS & CALENDARIO OPTIMIZADO ---
    const notyf = new Notyf({ duration: 3000, position: { x: 'right', y: 'top' } });
    let sprints = [], calendar;

    // Utilidades
    const getStatusBadge = estado => {
        const estados = {
            1: { text: 'Por hacer', class: 'bg-secondary' },
            2: { text: 'En progreso', class: 'bg-warning' },
            2: { text: 'En revision', class: 'bg-info' },
            3: { text: 'Completado', class: 'bg-success' }
        };
        const status = estados[estado] || { text: 'Desconocido', class: 'bg-dark' };
        return `<span class="badge ${status.class} status-badge">${status.text}</span>`;
    };

    const renderSprint = sprint => {
        const fechaInicio = new Date(sprint.fecha_inicio).toLocaleDateString();
        const fechaFin = new Date(sprint.fecha_fin).toLocaleDateString();
        return `
            <div class="sprint-item mb-4" data-sprint-id="${sprint.id}">
                <div class="card shadow-sm border rounded-3">
                    <div class="card-header">
                        <div class="sprint-header">
                            <div class="d-flex align-items-center flex-grow-1">
                                <i class="fas fa-grip-vertical drag-handle me-2"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">${sprint.nombre}</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="sprint-meta">${fechaInicio} - ${fechaFin}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary p-0 px-1" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li><a class="dropdown-item editar-sprint" href="#" data-sprint-uid="${sprint.uid}"><i class="bi bi-pencil-square me-1"></i> Editar</a></li>
                                    <li><a class="dropdown-item eliminar-sprint text-danger" href="#" data-sprint-uid="${sprint.uid}"><i class="bi bi-trash me-1"></i> Eliminar</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-outline-success btn-sm ms-2" data-bs-toggle="modal" data-sprint-uid="${sprint.uid}" data-fecha-inicio="${sprint.fecha_inicio || ''}" data-fecha-fin="${sprint.fecha_fin || ''}" data-bs-target="#modalIniciarSprint">
                                <i class="bi bi-play-fill"></i> Iniciar
                            </button>
                        </div>
                        <p class="small text-muted mb-1 mt-2">${sprint.objetivo}</p>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 text-muted"><i class="fas fa-tasks me-2"></i> Sprint Backlog</h6>
                            <span class="badge bg-secondary">0 elementos</span>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegSprBacklog" data-sprint-id="${sprint.id}">Agregar</button>
                        </div>
                        <div class="sprint-backlog-wrapper" data-sprint-id="${sprint.id}">
                            <div class="sprint-backlog-area rounded p-3 min-height-100" style="min-height: 100px; border-color: #dee2e6;" data-sprint-id="${sprint.id}" data-sprint-uid="${sprint.uid}">
                                <div class="text-center text-body py-3">
                                    <i class="fas fa-arrow-down fs-4 mb-2 d-block"></i>
                                    <p class="small mb-0">
                                        <a href="#" class="text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalRegSprBacklog" data-sprint-id="${sprint.id}">Agregue un elemento</a> o simplemente arrastre y suelte Backlog.
                                    </p>
                                </div>
                                <div class="sprint-backlog-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    };

    function cargarSprints() {
        const proyectoUID = $('#uid_proyecto').val();
        axios.get(`/proyectos/backlog/${proyectoUID}/sprints/show`)
            .then(res => { sprints = res.data; mostrarSprints(); window.refreshAllSprintBacklogs(); cargarTodosLosSprints(); })
            .catch(err => notyf.error(err.response?.status === 404 ? 'Proyecto no encontrado' : 'Error al cargar los sprints'));
    }

    function cargarTodosLosSprints() {
        const proyectoUID = $('#uid_proyecto').val();
        axios.get(`/proyectos/backlog/${proyectoUID}/sprints/all`)
            .then(res => {
                sprints = res.data;
                const lista = document.getElementById('lista-sprints');
                lista.innerHTML = sprints.length === 0
                    ? `<li class="list-group-item text-muted">No hay sprints creados</li>`
                    : sprints.map(sprint => {
                        const hoy = new Date(), fi = new Date(sprint.fecha_inicio), ff = new Date(sprint.fecha_fin);
                        let estado = hoy < fi ? ["Por hacer", "badge bg-secondary"] : hoy <= ff ? ["En progreso", "badge bg-warning text-dark"] : ["Finalizado", "badge bg-success"];
                        return `<li class="list-group-item d-flex justify-content-between align-items-start"><div><div class="fw-bold">${sprint.nombre}</div><small class="text-muted">${fi.toLocaleDateString()} - ${ff.toLocaleDateString()}</small></div><span class="${estado[1]}">${estado[0]}</span></li>`;
                    }).join('');
                calendar.removeAllEvents();
                sprints.forEach(addSprintToCalendar);
                mostrarCalendario();
            })
            .catch(err => notyf.error(err.response?.status === 404 ? 'Proyecto no encontrado' : 'Error al cargar los sprints'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable: false,
            headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
            events: []
        });
        calendar.render();
    });

    function mostrarCalendario() {
        document.querySelector('[data-target="calendario"]').addEventListener('click', function() {
            document.getElementById('calendario').style.display = "block";
            setTimeout(() => calendar.updateSize(), 200);
        });
    }

    function addSprintToCalendar(sprint) {
        calendar.addEvent({
            title: sprint.nombre,
            start: sprint.fecha_inicio,
            end: sprint.fecha_fin,
            allDay: true,
            backgroundColor: '#198754',
            borderColor: '#198754'
        });
    }

    function mostrarSprints() {
        const emptyState = $('#emptyState'), sprintsList = $('#sprintsList');
        if (!sprints.length) {
            emptyState.removeClass('d-none'); sprintsList.addClass('d-none');
        } else {
            emptyState.addClass('d-none'); sprintsList.removeClass('d-none');
            sprintsList.html(sprints.map(renderSprint).join(''));
            if (typeof $.fn.sortable === 'undefined') habilitarDragDropHTML5();
            else {
                sprintsList.sortable({ handle: '.drag-handle', placeholder: 'sprint-placeholder', update: actualizarOrdenSprints });
                $('.sprint-backlog-area').sortable({
                    connectWith: '.sprint-backlog-area',
                    placeholder: 'backlog-placeholder',
                    tolerance: 'pointer',
                    over: function () { $(this).addClass('drag-over'); },
                    out: function () { $(this).removeClass('drag-over'); },
                    drop: function () { $(this).removeClass('drag-over'); notyf.success('Elemento movido al sprint'); }
                });
            }
        }
    }

    // Drag & Drop HTML5 para historias → sprint backlog
    function habilitarDragDropHTML5() {
        $(document).on('mouseenter', '.historia-item', function () { $(this).attr('draggable', 'true'); });
        $(document).on('dragstart', '.historia-item', function (e) {
            e.originalEvent.dataTransfer.setData('historiaUid', $(this).data('uid'));
            $(this).addClass('dragging').css('opacity', '0.5');
        });
        $(document).on('dragend', '.historia-item', function () { $(this).removeClass('dragging').css('opacity', '1'); });
        $(document).on('dragover', '.sprint-backlog-area', function (e) { e.preventDefault(); $(this).addClass('drag-over'); });
        $(document).on('dragleave', '.sprint-backlog-area', function () { $(this).removeClass('drag-over'); });
        $(document).on('drop', '.sprint-backlog-area', function (e) {
            e.preventDefault(); $(this).removeClass('drag-over');
            const historiaUid = e.originalEvent.dataTransfer.getData('historiaUid');
            const $historia = $(`.historia-item[data-uid="${historiaUid}"]`);
            $(this).find('.sprint-backlog-list').append($historia.closest('.col-12'));
            $(this).find('.text-center').remove();
            const sprintId = $(this).data('sprint-id'), proyectoUID = $('#uid_proyecto').val(), progreso = $historia.data('progreso'), historiaId = $historia.closest('[data-historia-id]').data('historia-id');
            axios.post(`/proyectos/backlog/${proyectoUID}/sprints/${sprintId}/sprbacklog/store`, { id_item_backlog: historiaId, progreso, asignado_a: [] })
                .then(() => { notyf.success('Historia agregada al Sprint Backlog'); window.refreshAllSprintBacklogs(); mostrarSprints(); cargarSprints(); window.cargarHistorias(); })
                .catch(err => { notyf.error('Error al mover historia al Sprint'); console.error(err.response?.data || err); });
        });
    }

    function actualizarOrdenSprints() {
        const orden = [];
        $('#sprintsList .sprint-item').each(function (i) { orden.push({ id: $(this).data('sprint-id'), orden: i + 1 }); });
        notyf.success('Orden de sprints actualizado (visual)');
    }

    function crearSprint() {
        const proyectoUID = $('#uid_proyecto').val();
        const formData = {
            nombre: $('#nombreSprint').val(),
            objetivo: $('#objetivoSprint').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        if (new Date(formData.fecha_fin) <= new Date(formData.fecha_inicio)) return notyf.error('La fecha de fin debe ser posterior a la fecha de inicio');
        axios.post(`/proyectos/backlog/${proyectoUID}/sprints/store`, formData)
            .then(res => { notyf.success(res.data.message || 'Sprint creado correctamente'); $('#modalSprint').modal('hide'); $('#formSprint')[0].reset(); cargarSprints(); })
            .catch(error => {
                if (error.response?.status === 422) notyf.error(Object.values(error.response.data.errors).map(e => `- ${e[0]}`).join('\n'));
                else notyf.error(error.response?.data?.error || 'Error al crear el sprint');
            });
    }

    $(function () {
        cargarSprints();
        $('#btnCrearSprint').click(function () {
            if ($('#formSprint')[0].checkValidity()) crearSprint();
            else { notyf.error('Por favor completa todos los campos requeridos'); $('#formSprint')[0].reportValidity(); }
        });
        $('#modalSprint').on('hidden.bs.modal', function () { $('#formSprint')[0].reset(); });
        const hoy = new Date().toISOString().split('T')[0];
        $('#fechaInicio').attr('min', hoy);
        $('#fechaInicio').change(function () { $('#fechaFin').attr('min', $(this).val()); });
    });

    function editarSprint(sprintUid) {
        const sprint = sprints.find(s => s.uid === sprintUid);
        if (!sprint) return notyf.error('Sprint no encontrado');
        $('#editarSprintUid').val(sprint.uid);
        $('#editarNombreSprint').val(sprint.nombre);
        $('#editarObjetivoSprint').val(sprint.objetivo);
        $('#editarFechaInicio').val(sprint.fecha_inicio);
        $('#editarFechaFin').val(sprint.fecha_fin);
        $('#modalEditarSprint').modal('show');
    }

    function actualizarSprint() {
        const proyectoUID = $('#uid_proyecto').val();
        const formData = {
            uid: $('#editarSprintUid').val(),
            nombre: $('#editarNombreSprint').val(),
            objetivo: $('#editarObjetivoSprint').val(),
            fecha_inicio: $('#editarFechaInicio').val(),
            fecha_fin: $('#editarFechaFin').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        if (new Date(formData.fecha_fin) <= new Date(formData.fecha_inicio)) return notyf.error('La fecha de fin debe ser posterior a la fecha de inicio');
        axios.post(`/proyectos/backlog/${proyectoUID}/sprints/update`, formData)
            .then(res => { notyf.success(res.data.message || 'Sprint actualizado correctamente'); $('#modalEditarSprint').modal('hide'); $('#formEditarSprint')[0].reset(); cargarSprints(); })
            .catch(error => {
                if (error.response?.status === 422) notyf.error(Object.values(error.response.data.errors).map(e => `- ${e[0]}`).join('\n'));
                else notyf.error(error.response?.data?.error || 'Error al actualizar el sprint');
            });
    }

    function eliminarSprint(sprintUid) {
        const sprint = sprints.find(s => s.uid === sprintUid), nombreSprint = sprint ? sprint.nombre : 'este sprint', isDark = $("body").hasClass("dark");
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar ${nombreSprint}? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: isDark ? '#444' : '#aaa',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            background: isDark ? '#1e1e2d' : '#fff',
            color: isDark ? '#f1f1f1' : '#000'
        }).then(result => { if (result.isConfirmed) ejecutarEliminacionSprint(sprintUid); });
    }

    function ejecutarEliminacionSprint(sprintUid) {
        const proyectoUID = $('#uid_proyecto').val(), isDark = $("body").hasClass("dark");
        axios.post(`/proyectos/backlog/${proyectoUID}/sprints/destroy`, { uid: sprintUid, _token: $('meta[name="csrf-token"]').attr('content') })
            .then(res => {
                Swal.fire({ title: '¡Eliminado!', text: res.data.message || 'Sprint eliminado correctamente', icon: 'success', timer: 2000, showConfirmButton: false, background: isDark ? '#1e1e2d' : '#fff', color: isDark ? '#f1f1f1' : '#000' });
                cargarSprints();
            })
            .catch(error => {
                Swal.fire({ title: 'Error', text: error.response?.data?.error || 'Error al eliminar el sprint', icon: 'error', background: isDark ? '#1e1e2d' : '#fff', color: isDark ? '#f1f1f1' : '#000' });
            });
    }

    $('#modalIniciarSprint').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget), sprintUid = button.data('sprint-uid');
        $('#formIniciarSprint').data('sprint-uid', sprintUid);
        $('#formIniciarSprint input[name="fecha_inicio"]').val(button.data('fecha-inicio'));
        $('#formIniciarSprint input[name="fecha_fin"]').val(button.data('fecha-fin'));
    });

    $('#formIniciarSprint').on('submit', function (e) {
        e.preventDefault();
        const proyectoUID = $('#uid_proyecto').val(), sprintUID = $(this).data('sprint-uid'), fechaInicio = $(this).find('input[name="fecha_inicio"]').val(), fechaFin = $(this).find('input[name="fecha_fin"]').val();
        axios.post(`/proyectos/backlog/${proyectoUID}/sprints/${sprintUID}/items/start`, { fecha_inicio: fechaInicio, fecha_fin: fechaFin })
            .then(res => {
                $('#modalIniciarSprint').modal('hide');
                notyf.success(res.data.message || 'Sprint iniciado correctamente');
                sessionStorage.setItem('currentSprintUID', sprintUID);
                mostrarSeccion('tablero');
                cargarTablero(proyectoUID, sprintUID);
                cargarSprints();
            })
            .catch(error => notyf.error(error.response?.data?.message || 'Error al iniciar sprint'));
    });

    // ============================================
    // EDITAR HISTORIA (TABLERO)
    // ============================================
    $(document).on('click', '.editar-historia-tablero', function (e) {
        e.preventDefault();
        const historiaUID = $(this).data('product-uid');
        const proyectoUID = $('#tablero').data('proyecto');
        const sprintUID = $('#tablero').data('sprint');
        
        axios.get(`/proyectos/${proyectoUID}/sprints/${sprintUID}/items/${historiaUID}`)
            .then(res => {
                if (res.data.success) {
                    const historia = res.data.item;
                    $('#edit_historia_uid_tablero').val(historia.uid);
                    $('#edit_titulo_tablero').val(historia.titulo);
                    $('#edit_descripcion_tablero').val(historia.descripcion || '');
                    $('#edit_prioridad_tablero').val(historia.prioridad);
                    $('#edit_valor_historia_tablero').val(historia.valor_historia);
                    $('#edit_progreso_tablero').val(historia.progreso);
                    $('#modalHistoriaEditTablero').modal('show');
                } else {
                    notyf.error(res.data.message || 'Error al cargar la historia');
                }
            })
            .catch(err => {
                console.error(err);
                notyf.error('Error al cargar los datos de la historia');
            });
    });

    // ============================================
    // ACTUALIZAR HISTORIA (TABLERO)
    // ============================================
    $('#formHistoriaEditTablero').on('submit', function (e) {
        e.preventDefault();
        const historiaUID = $('#edit_historia_uid_tablero').val();
        const proyectoUID = $('#tablero').data('proyecto');
        const sprintUID = $('#tablero').data('sprint');
        
        const datos = {
            titulo: $('#edit_titulo_tablero').val(),
            descripcion: $('#edit_descripcion_tablero').val(),
            prioridad: $('#edit_prioridad_tablero').val(),
            valor_historia: $('#edit_valor_historia_tablero').val(),
            progreso: $('#edit_progreso_tablero').val()
        };
        
        $('#btnActualizarHistoriaTablero').prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i>Guardando...');
        
        axios.put(`/proyectos/${proyectoUID}/sprints/${sprintUID}/items/${historiaUID}`, datos)
            .then(res => {
                if (res.data.success) {
                    notyf.success(res.data.message || 'Historia actualizada correctamente');
                    $('#modalHistoriaEditTablero').modal('hide');
                    
                    // Actualización dinámica sin recargar
                    const tarjetaActual = document.querySelector(`[data-product-uid="${historiaUID}"]`);
                    if (tarjetaActual) {
                        // Normaliza el progreso actual y nuevo
                        let progresoActual = tarjetaActual.closest('.kanban-items')?.id?.replace('items-', '') || '';
                        let progresoNuevo = datos.progreso;
                        
                        // Normaliza progreso nuevo
                        if (["Por hacer","to_do"].includes(progresoNuevo)) progresoNuevo = "por-hacer";
                        if (["En progreso","in_progress"].includes(progresoNuevo)) progresoNuevo = "en-progreso";
                        if (["Completado","done","Terminado"].includes(progresoNuevo)) progresoNuevo = "terminado";
                        if (["En revision","in_revision","en-revision"].includes(progresoNuevo)) progresoNuevo = "en-revision";
                        
                        // Si cambió de columna
                        if (progresoActual !== progresoNuevo) {
                            // Obtiene la columna actual antes de eliminar
                            const columnaActual = tarjetaActual.closest('.kanban-items');
                            
                            // Remueve de la columna actual
                            tarjetaActual.remove();
                            
                            // Renderiza en la nueva columna
                            if (res.data.item) {
                                renderKanbanItem(res.data.item);
                            }
                            
                            // Verifica si la columna anterior quedó vacía
                            if (columnaActual) {
                                const tarjetasRestantes = columnaActual.querySelectorAll('.kanban-item');
                                const btnCrear = columnaActual.querySelector('.btn-crear-rapido-container');
                                
                                if (tarjetasRestantes.length === 0 && !columnaActual.querySelector('.empty-column')) {
                                    const emptyDiv = document.createElement('div');
                                    emptyDiv.className = 'empty-column';
                                    emptyDiv.innerHTML = '<i class="bi bi-inbox"></i><p>No hay elementos</p>';
                                    
                                    if (btnCrear) {
                                        columnaActual.insertBefore(emptyDiv, btnCrear);
                                    } else {
                                        columnaActual.appendChild(emptyDiv);
                                    }
                                }
                            }
                        } else {
                            // Solo actualiza el contenido sin cambiar de columna
                            // Actualiza título
                            const tituloEl = tarjetaActual.querySelector('.kanban-title');
                            if (tituloEl) tituloEl.textContent = datos.titulo;
                            
                            // Actualiza valor historia
                            const valorEl = tarjetaActual.querySelector('.kanban-item-footer p');
                            if (valorEl) valorEl.textContent = datos.valor_historia || '';
                            
                            // Actualiza prioridad
                            const prioridadEl = tarjetaActual.querySelector('.kanban-item-footer small');
                            if (prioridadEl) prioridadEl.textContent = datos.prioridad || '';
                        }
                        
                        // Actualiza contadores
                        actualizarContadores();
                        
                        // Re-habilita drag and drop
                        enableDragAndDrop();
                    }
                } else {
                    console.error('Error completo:', res); 
                    console.error('Datos enviados:', datos);
                    notyf.error(res.data.message || 'Error al actualizar la historia');
                }
            })
            .catch(err => {
                console.error(err);
                notyf.error('Error al actualizar la historia');
            })
            .finally(() => {
                $('#btnActualizarHistoriaTablero').prop('disabled', false).html('<i class="bi bi-save me-2"></i> Guardar Cambios');
            });
    });


    // ============================================
    // ELIMINAR HISTORIA
    // ============================================
    $(document).on('click', '.eliminar-historia-tablero', function (e) {
        e.preventDefault();
        const historiaUID = $(this).data('product-uid');
        const proyectoUID = $('#tablero').data('proyecto');
        const sprintUID = $('#tablero').data('sprint');
        
        const isDark = document.body.classList.contains("dark");

        Swal.fire({
            title: '¿Eliminar historia?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: isDark ? '#444' : '#6c757d',
            background: isDark ? '#1e1e2d' : '#fff',
            color: isDark ? '#f1f1f1' : '#000',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                axios.delete(`/proyectos/${proyectoUID}/sprints/${sprintUID}/items/${historiaUID}`)
                    .then(res => {
                        if (res.data.success) {
                            notyf.success(res.data.message || 'Historia eliminada correctamente');
                            
                            // Eliminación dinámica sin recargar
                            const tarjeta = document.querySelector(`[data-product-uid="${historiaUID}"]`);
                            if (tarjeta) {
                                const itemsContainer = tarjeta.closest('.kanban-items');
                                const containerId = itemsContainer?.id || '';
                                
                                // Animación de salida
                                tarjeta.style.transition = 'opacity 0.3s, transform 0.3s';
                                tarjeta.style.opacity = '0';
                                tarjeta.style.transform = 'scale(0.9)';
                                
                                setTimeout(() => {
                                    tarjeta.remove();
                                    
                                    // Verifica si la columna quedó vacía
                                    if (itemsContainer) {
                                        const tarjetasRestantes = itemsContainer.querySelectorAll('.kanban-item');
                                        const btnCrear = itemsContainer.querySelector('.btn-crear-rapido-container');
                                        
                                        if (tarjetasRestantes.length === 0 && !itemsContainer.querySelector('.empty-column')) {
                                            const emptyDiv = document.createElement('div');
                                            
                                            if (btnCrear) {
                                                itemsContainer.insertBefore(emptyDiv, btnCrear);
                                            } else {
                                                itemsContainer.appendChild(emptyDiv);
                                            }
                                        }
                                    }
                                    
                                    // Actualiza el contador de la columna
                                    if (containerId) {
                                        const estado = containerId.replace('items-', '');
                                        const counter = document.getElementById(`counter-${estado}`);
                                        if (counter) {
                                            const currentCount = parseInt(counter.textContent || 0);
                                            counter.textContent = Math.max(0, currentCount - 1);
                                        }
                                    }
                                    
                                    // Actualiza contadores generales
                                    actualizarContadores();
                                }, 300);
                            }
                        } else {
                            notyf.error(res.data.message || 'No se pudo eliminar la historia');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        notyf.error('Error al eliminar la historia');
                    });
            }
        });
    });

    // ============================================
    // EDICIÓN INLINE DEL TÍTULO
    // ============================================
    $(document).on('click', '.kanban-title', function (e) {
        e.stopPropagation();
        const $title = $(this);
        const $card = $title.closest('.kanban-item');
        if ($title.find('input').length > 0) return;

        const currentTitle = $title.text().trim();
        const historiaUID = $card.data('product-uid'); // ⬅️ actualizado

        const $input = $('<input>', {
            type: 'text',
            class: 'form-control form-control-sm',
            value: currentTitle,
            maxlength: 50
        });
        
        $title.html($input);
        $input.focus().select();

        const saveTitle = () => {
            const newTitle = $input.val().trim();
            if (newTitle === currentTitle || newTitle === '') {
                $title.text(currentTitle);
                return;
            }
            $title.html('<span class="spinner-border spinner-border-sm"></span>');
            const proyectoUID = $('#tablero').data('proyecto');
            const sprintUID = $('#tablero').data('sprint');

            axios.patch(`/proyectos/${proyectoUID}/sprints/${sprintUID}/items/${historiaUID}/titulo`, { titulo: newTitle })
                .then(res => {
                    if (res.data.success) {
                        $title.text(newTitle);
                        notyf.success('Título actualizado');
                    } else {
                        $title.text(currentTitle);
                        notyf.error(res.data.message || 'Error al actualizar el título');
                    }
                })
                .catch(err => {
                    console.error(err);
                    $title.text(currentTitle);
                    notyf.error('Error al actualizar el título');
                });
        };

        $input.on('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); $(this).blur(); }
            else if (e.key === 'Escape') { $title.text(currentTitle); }
        });

        $input.on('blur', function () { saveTitle(); });
    });

    // ============================================
    // AGREGAR BOTONES DE CREACIÓN RÁPIDA 
    // ============================================
    function agregarBotonesCreacionRapida() {
        const columnas = document.querySelectorAll('.kanban-column, [data-status]');
        
        columnas.forEach(columna => {
            const itemsContainer = columna.querySelector('.kanban-items');
            if (!itemsContainer) return;
            
            // Evita duplicar el botón si ya existe
            if (itemsContainer.querySelector('.btn-crear-rapido')) return;
            
            // Crea el contenedor del botón
            const btnContainer = document.createElement('div');
            btnContainer.className = 'btn-crear-rapido-container';
            btnContainer.style.cssText = `
                padding: 2px;
                opacity: 0;
                transition: opacity 0.2s ease;
            `;
            
            // Crea el botón
            const btnCrear = document.createElement('button');
            btnCrear.className = 'btn btn-crear-rapido w-100 btn-sm';
            btnCrear.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Crear';
            btnCrear.style.cssText = `
                text-align: left;
            `;
            
            btnContainer.appendChild(btnCrear);
            
            // Agrega el botón al final del contenedor de items
            itemsContainer.appendChild(btnContainer);
            
            // Eventos hover en el contenedor de items para mostrar/ocultar el botón
            itemsContainer.addEventListener('mouseenter', () => {
                btnContainer.style.opacity = '1';
            });
            
            itemsContainer.addEventListener('mouseleave', () => {
                // Solo oculta si no hay un formulario activo
                if (!itemsContainer.querySelector('.form-creacion-rapida')) {
                    btnContainer.style.opacity = '0';
                }
            });
            
            // Evento click para crear tarjeta
            btnCrear.addEventListener('click', (e) => {
                e.stopPropagation();
                const status = columna.getAttribute('data-status');
                mostrarFormularioCreacionRapida(itemsContainer, status, btnContainer);
            });
        });
    }

    // ============================================
    // MOSTRAR FORMULARIO DE CREACIÓN RÁPIDA 
    // ============================================
    function mostrarFormularioCreacionRapida(itemsContainer, status, btnContainer) {
        // Oculta el botón de crear
        if (btnContainer) btnContainer.style.display = 'none';
        
        // Verifica si ya existe un formulario activo
        if (itemsContainer.querySelector('.form-creacion-rapida')) return;
        
        // Determina el progreso según el status
        let progreso = status === "por-hacer" ? "Por hacer"
                    : status === "en-progreso" ? "En progreso"
                    : status === "terminado" ? "Terminado"
                    : status === "en-revision" ? "En revision"
                    : "";
        
        // Crea el formulario inline
        const formContainer = document.createElement('div');
        formContainer.className = 'form-creacion-rapida rounded shadow-sm';
        formContainer.style.cssText = `
            margin: 8px;
        `;
        formContainer.innerHTML = `
            <form id="formCreacionRapida">
                <div class="mb-2">
                    <input type="text" 
                        class="form-control form-control-sm" 
                        id="titulo_rapido" 
                        placeholder="Título de la historia..." 
                        maxlength="50" 
                        required 
                        autofocus>
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" 
                            id="descripcion_rapido" 
                            placeholder="Descripción (opcional)" 
                            rows="2" 
                            maxlength="255"></textarea>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <select class="form-select form-select-sm" id="prioridad_rapido" required>
                            <option value="Media" selected>Prioridad: Media</option>
                            <option value="Alta">Prioridad: Alta</option>
                            <option value="Baja">Prioridad: Baja</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="number" 
                            class="form-control form-control-sm" 
                            id="valor_rapido" 
                            placeholder="Valor" 
                            min="1" 
                            max="100" 
                            value="5" 
                            required>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i>
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-cancelar-rapido">
                        <i class="bi bi-x-lg"></i> 
                    </button>
                </div>
            </form>
        `;
        
        // Inserta el formulario al final del contenedor (antes del botón)
        itemsContainer.appendChild(formContainer);
        
        // Scroll al formulario
        setTimeout(() => {
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            document.getElementById('titulo_rapido')?.focus();
        }, 100);
        
        // Evento para cancelar
        formContainer.querySelector('.btn-cancelar-rapido').addEventListener('click', () => {
            formContainer.remove();
            if (btnContainer) {
                btnContainer.style.display = 'block';
                btnContainer.style.opacity = '0';
            }
        });
        
        // Evento para enviar el formulario
        formContainer.querySelector('#formCreacionRapida').addEventListener('submit', (e) => {
            e.preventDefault();
            crearTarjetaRapida(formContainer, progreso, status, btnContainer);
        });
        
        // Cerrar con ESC
        const handleEsc = (e) => {
            if (e.key === 'Escape') {
                formContainer.remove();
                if (btnContainer) {
                    btnContainer.style.display = 'block';
                    btnContainer.style.opacity = '0';
                }
                document.removeEventListener('keydown', handleEsc);
            }
        };
        document.addEventListener('keydown', handleEsc);
    }

    // ============================================
    // CREAR TARJETA RÁPIDA (ACTUALIZADO)
    // ============================================
    function crearTarjetaRapida(formContainer, progreso, status, btnContainer) {
        const titulo = document.getElementById('titulo_rapido').value.trim();
        const descripcion = document.getElementById('descripcion_rapido').value.trim();
        const prioridad = document.getElementById('prioridad_rapido').value;
        const valorHistoria = document.getElementById('valor_rapido').value;
        
        if (!titulo) {
            notyf.error('El título es obligatorio');
            return;
        }
        
        // Deshabilita el formulario
        const btnSubmit = formContainer.querySelector('button[type="submit"]');
        const btnCancel = formContainer.querySelector('.btn-cancelar-rapido');
        btnSubmit.disabled = true;
        btnCancel.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creando...';
        
        const tablero = document.getElementById("tablero");
        const proyectoUID = tablero.getAttribute("data-proyecto");
        const sprintUID = tablero.getAttribute("data-sprint");
        
        const datos = {
            titulo: titulo,
            descripcion: descripcion || null,
            prioridad: prioridad,
            valor_historia: parseInt(valorHistoria),
            progreso: progreso
        };
        
        axios.post(`/proyectos/${proyectoUID}/sprints/${sprintUID}/items`, datos)
            .then(res => {
                if (res.data.success) {
                    notyf.success('Creado correctamente');
                    
                    // Remueve el formulario
                    formContainer.remove();
                    
                    // Muestra el botón de crear nuevamente (oculto)
                    if (btnContainer) {
                        btnContainer.style.display = 'block';
                        btnContainer.style.opacity = '0';
                    }
                    
                    // Agrega la nueva tarjeta al tablero
                    if (res.data.item) {
                        const columna = document.querySelector(`[data-status="${status}"]`);
                        const itemsContainer = columna?.querySelector('.kanban-items');
                        
                        if (itemsContainer) {
                            // Remueve el mensaje de "No hay elementos" si existe
                            const mensajeVacio = itemsContainer.querySelector('.empty-column');
                            if (mensajeVacio) mensajeVacio.remove();
                            
                            // Renderiza la nueva tarjeta antes del botón de crear
                            renderKanbanItem(res.data.item);
                            
                            // Mueve el botón al final
                            const btnCrearContainer = itemsContainer.querySelector('.btn-crear-rapido-container');
                            if (btnCrearContainer) {
                                itemsContainer.appendChild(btnCrearContainer);
                            }
                            
                            // Actualiza contadores
                            actualizarContadores();
                            
                            // Re-habilita drag and drop para la nueva tarjeta
                            enableDragAndDrop();
                        }
                    }
                } else {
                    notyf.error(res.data.message || 'Error al crear la tarjeta');
                    btnSubmit.disabled = false;
                    btnCancel.disabled = false;
                    btnSubmit.innerHTML = '<i class="bi bi-check-lg me-1"></i> Crear';
                }
            })
            .catch(err => {
                console.error('Error al crear tarjeta:', err);
                const errorMsg = err.response?.data?.message || 'Error al crear la tarjeta';
                notyf.error(errorMsg);
                btnSubmit.disabled = false;
                btnCancel.disabled = false;
                btnSubmit.innerHTML = '<i class="bi bi-check-lg me-1"></i> Crear';
            });
    }

    // ============================================
    // RENDERIZAR ITEM ACTUALIZADO
    // ============================================
    function renderKanbanItem(item) {
        let estado = item.progreso;
        if (["Por hacer","to_do"].includes(estado)) estado = "por-hacer";
        if (["En progreso","in_progress"].includes(estado)) estado = "en-progreso";
        if (["Completado","done","Terminado"].includes(estado)) estado = "terminado";
        if (["En revision","in_revision","en-revision"].includes(estado)) estado = "en-revision";

        const container = document.getElementById(`items-${estado}`);
        if (!container) return;

        const emptyMsg = container.querySelector('.empty-column');
        if (emptyMsg) emptyMsg.remove();

        const card = document.createElement('div');
        card.classList.add('kanban-item','card','mb-2','p-2', 'border');
        card.setAttribute('data-id', item.id);
        card.setAttribute('data-product-uid', item.product_uid || item.uid); // ⬅️ product-uid
        card.setAttribute('data-sprint-uid', item.sprint_uid || ''); // ⬅️ sprint-uid extra
        card.style.cursor = 'move';

        card.innerHTML = `
            <div class="kanban-item-header d-flex justify-content-between align-items-center">
                <p class="kanban-title m-0 fs-6 small" style="cursor: text; flex: 1;" title="Click para editar" style="font-size: 0.75rem;">${item.titulo}</p>
                <div class="dropdown ms-2">
                    <button class="btn btn-sm btn-link text-body p-0" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item editar-historia-tablero" href="#" data-product-uid="${item.product_uid || item.uid}">
                                <i class="bi bi-pencil-square me-2"></i>Editar
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger eliminar-historia-tablero" href="#" data-product-uid="${item.product_uid || item.uid}">
                                <i class="bi bi-trash me-2"></i>Eliminar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kanban-item-footer d-flex justify-content-between align-items-center mt-2">
                <p class="text-body m-0"  >${item.valor_historia || ''}</p>
                <small class="text-muted">${item.prioridad || ''}</small>
            </div>
        `;
        const btnCrearContainer = container.querySelector('.btn-crear-rapido-container');
        if (btnCrearContainer) {
            container.insertBefore(card, btnCrearContainer);
        } else {
            container.appendChild(card);
        }
        enableDragAndDrop();

        const counter = document.getElementById(`counter-${estado}`);
        if (counter) counter.textContent = parseInt(counter.textContent || 0) + 1;
    }

    // ============================================
    // CARGAR TABLERO
    // ============================================
    function cargarTablero(proyectoUID, sprintUID) {
        $("#tablero").attr({ "data-proyecto": proyectoUID, "data-sprint": sprintUID })
            .html('<div class="text-center p-3"><div class="spinner-border"></div><p class="mt-2">Cargando tablero...</p></div>');

        axios.get(`/proyectos/${proyectoUID}/sprints/${sprintUID}/board/view`)
            .then(res => {
                $("#tablero").html(res.data);
                return axios.get(`/proyectos/${proyectoUID}/sprints/${sprintUID}/board/items`);
            })
            .then(res => {
                if (!res.data.success) {
                    notyf.error(res.data.message || "Error al cargar ítems del tablero");
                    return;
                }
                (res.data.items || []).forEach(renderKanbanItem);

                enableDragAndDrop();
                agregarBotonesCreacionRapida();
            })
            .catch(err => {
                console.error(err);
                $("#tablero").html('<div class="alert alert-danger">Error al cargar el tablero</div>');
            });
    }

    // ============================================
    // ENABLE DRAG AND DROP 
    // ============================================
    function enableDragAndDrop() {
        const items = document.querySelectorAll('.kanban-item');
        const columns = document.querySelectorAll('.kanban-items');

        // Limpiar listeners anteriores en items
        items.forEach(item => {
            if (!item.hasAttribute('data-drag-initialized')) {
                item.setAttribute('draggable', true);
                item.setAttribute('data-drag-initialized', 'true');

                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragend', handleDragEnd);
            }
        });

        // Limpiar listeners anteriores en columnas
        columns.forEach(column => {
            if (!column.hasAttribute('data-drop-initialized')) {
                column.setAttribute('data-drop-initialized', 'true');
                
                column.addEventListener('dragover', handleDragOver);
                column.addEventListener('dragleave', handleDragLeave);
                column.addEventListener('drop', handleDrop);
            }
        });
    }

    // ============================================
    // HANDLERS DE DRAG AND DROP
    // ============================================
    function handleDragStart(e) {
        e.dataTransfer.setData('text/plain', this.getAttribute('data-product-uid'));
        e.dataTransfer.effectAllowed = 'move';
        this.classList.add('dragging');
    }

    function handleDragEnd() {
        this.classList.remove('dragging');
    }

    function handleDragOver(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    }

    function handleDragLeave() {
        this.classList.remove('drag-over');
    }

    function handleDrop(e) {
        e.preventDefault();
        this.classList.remove('drag-over');

        const productUID = e.dataTransfer.getData('text/plain');
        const item = document.querySelector(`.kanban-item[data-product-uid="${productUID}"]`);
        if (!item) return;

        const originalColumn = item.parentElement;
        
        // Evitar drop en la misma columna
        if (originalColumn === this) return;
        
        // ⬇️ CAMBIO AQUÍ: Insertar antes del botón de crear
        const btnCrearContainer = this.querySelector('.btn-crear-rapido-container');
        if (btnCrearContainer) {
            this.insertBefore(item, btnCrearContainer);
        } else {
            this.appendChild(item);
        }

        actualizarMensajesVacios();
        actualizarContadores();

        const statusKey = this.parentElement.getAttribute('data-status');
        const newProgreso = 
            statusKey === "por-hacer" ? "Por hacer" :
            statusKey === "en-progreso" ? "En progreso" :
            statusKey === "terminado" ? "Terminado" :
            statusKey === "en-revision" ? "En revision" : "";

        const tablero = document.getElementById("tablero");
        const proyectoUID = tablero.getAttribute("data-proyecto");
        const sprintUID = tablero.getAttribute("data-sprint");

        item.setAttribute('draggable', false);
        item.style.opacity = '0.6';

        axios.post(`/proyectos/${proyectoUID}/sprints/${sprintUID}/items/${productUID}/progreso`, { 
            progreso: newProgreso 
        })
        .then(() => {
            item.setAttribute('draggable', true);
            item.style.opacity = '1';
        })
        .catch(err => {
            console.error(err);
            notyf.error('Error al actualizar el estado');
            originalColumn.appendChild(item);
            item.setAttribute('draggable', true);
            item.style.opacity = '1';
            actualizarMensajesVacios();
            actualizarContadores();
        });
}

    // Función para manejar los mensajes vacíos
    function actualizarMensajesVacios() {
        const columns = document.querySelectorAll('.kanban-items');

        columns.forEach(column => {
            const tarjetas = column.querySelectorAll('.kanban-item');
            let mensajeVacio = column.querySelector('.empty-column');

            if (tarjetas.length === 0) {
                if (!mensajeVacio) {
                    mensajeVacio = document.createElement('div');

                    const btnCrear = column.querySelector('.btn-crear-rapido-container');
                    if (btnCrear) {
                        column.insertBefore(mensajeVacio, btnCrear);
                    } else {
                        column.appendChild(mensajeVacio);
                    }
                }
            } else if (mensajeVacio) {
                mensajeVacio.remove();
            }
        });
    }

    // Función para actualizar los contadores de cada columna
    function actualizarContadores() {
        ["por-hacer", "en-progreso", "terminado", "en-revision"].forEach(status => {
            const container = document.getElementById(`items-${status}`);
            const counter = document.getElementById(`counter-${status}`);
            if (container && counter) {
                counter.textContent = container.querySelectorAll('.kanban-item').length;
            }
        });
    }

    enableDragAndDrop();


    $(document).on('click', '.editar-sprint', function (e) { e.preventDefault(); editarSprint($(this).data('sprint-uid')); });
    $(document).on('click', '.eliminar-sprint', function (e) { e.preventDefault(); eliminarSprint($(this).data('sprint-uid')); });
    $('#formEditarSprint').on('submit', function (e) { e.preventDefault(); actualizarSprint(); });
    $(document).on('click', '#btnActualizarSprint', function (e) { e.preventDefault(); actualizarSprint(); });

    // --- ASIGNACIÓN DE USUARIOS SPRINT BACKLOG ---
    $(function () {
        const uid = $("#id_proyecto").val();
        let selectedUsers = [], allUsers = [];

        // Renderizar lista de usuarios
        const renderUsersList = users => {
            const $usersList = $("#usersList").empty();
            users.forEach(user => {
                const isSelected = selectedUsers.includes(user.id);

                // Iniciales (fallback si no hay foto)
                const initials = user.nombre_completo
                    ? user.nombre_completo.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2)
                    : "U";

                // Avatar dinámico
                let avatarHtml = "";
                if (user.foto_url) {
                    let fotoSrc = user.foto_url.startsWith("http")
                        ? user.foto_url
                        : `/storage/${user.foto_url}`;
                    const isUiAvatar = user.foto_url.includes("ui-avatars.com");

                    avatarHtml = `
                        <img src="${fotoSrc}${!isUiAvatar ? `?v=${new Date().getTime()}` : ''}" 
                            alt="${user.nombre_completo || 'Usuario'}"
                            class="rounded-circle user-avatar"
                            style="width: 32px; height: 32px; object-fit: cover;"
                            ${!isUiAvatar 
                                ? `onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(initials)}&background=0D8ABC&color=fff';"` 
                                : ''}>
                    `;
                } else {
                    avatarHtml = `
                        <div class="user-avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold"
                            style="width: 32px; height: 32px;">
                            ${initials}
                        </div>
                    `;
                }


                $usersList.append(`
                    <div class="user-option d-flex align-items-center mb-2" data-user-id="${user.id}">
                        <input type="checkbox" class="me-2" ${isSelected ? 'checked' : ''}>
                        ${avatarHtml}
                        <span class="ms-2">${user.nombre_completo}</span>
                    </div>
                `);
            });
        };


        // Filtrar usuarios por búsqueda
        $("#searchBox").on("input", function () {
            const term = $(this).val().toLowerCase();
            renderUsersList(allUsers.filter(u => u.nombre_completo.toLowerCase().includes(term)));
        });

        // Manejar selección de usuarios
        $(document).on("click", ".user-option", function (e) {
            const $checkbox = $(this).find('input[type="checkbox"]');
            if (e.target.type !== 'checkbox') $checkbox.prop('checked', i => !i);

            const userId = parseInt($(this).data('user-id'));
            $checkbox.prop('checked')
                ? selectedUsers.includes(userId) || selectedUsers.push(userId)
                : selectedUsers = selectedUsers.filter(id => id !== userId);

            $('input[name="asignado_a[]"]').remove();
            selectedUsers.forEach(id => $('<input>').attr({ type: 'hidden', name: 'asignado_a[]', value: id }).appendTo('form'));
        });

        // Cargar datos de backlog y sprint
        const loadUserData = (sprintId = null) => {
            axios.get(`/proyectos/backlog/${uid}/sprints/items`)
                .then(res => {
                    const { backlog, sprints, equipo } = res.data;
                    const $itemBacklog = $("#id_item_backlog").empty().append('<option value="">Seleccionar elemento</option>');
                    backlog.forEach(item => $itemBacklog.append(`<option value="${item.id}">${item.titulo}</option>`));

                    const $sprintSelect = $("#id_sprint").empty().append('<option value="">Seleccionar Sprint</option>');
                    sprints.forEach(s => $sprintSelect.append(`<option value="${s.id}">${s.nombre}</option>`));
                    if (sprintId) $sprintSelect.val(sprintId);

                    allUsers = equipo;
                    selectedUsers = [];
                    renderUsersList(allUsers);
                    $("#searchBox").val('');
                })
                .catch(() => notyf.error("Error al cargar los datos"));
        };

        // Abrir modal
        $(document).on("show.bs.modal", "#modalRegSprBacklog", function (event) {
            const sprintId = $(event.relatedTarget).data("sprint-id");
            $("#current_sprint_id").val(sprintId);
            loadUserData(sprintId);
        });

        // Limpiar modal al cerrarlo
        $("#modalRegSprBacklog").on("hidden.bs.modal", () => {
            selectedUsers = [];
            allUsers = [];
            $("#usersList").empty();
            $("#searchBox").val('');
            $('input[name="asignado_a[]"]').remove();
        });

        // Guardar Sprint Backlog
        $("#btnGuardarSprintBacklog").on("click", () => {
            const sprintId = $("#current_sprint_id").val();
            const formData = {
                id_sprint: sprintId,
                id_item_backlog: $("#id_item_backlog").val(),
                titulo: $("#tituloSpr").val(),
                progreso: $("#progresoSpr").val(),
                asignado_a: selectedUsers
            };

            axios.post(`/proyectos/backlog/${uid}/sprints/${sprintId}/sprbacklog/store`, formData)
                .then(res => {
                    notyf.success(res.data.message);
                    $("#modalRegSprBacklog").modal("hide");
                    // Limpiar campos
                    $("#tituloSpr, #progresoSpr, #id_item_backlog").val('');
                    selectedUsers = [];
                    allUsers = [];
                    $("#usersList").empty();
                    $("#searchBox").val('');
                    $('input[name="asignado_a[]"]').remove();
                    window.cargarHistorias();
                })
                .catch(err => notyf.error(err.response?.data?.error || "Error al guardar en Sprint Backlog"));
        });
    });


    $(document).ready(function() {

        // Función para cargar Sprint Backlog
        function loadSprintBacklog(sprintId) {
            const uid = $("#id_proyecto").val();

            if (!uid || !sprintId) {
                console.error('ID de proyecto o sprint no definido');
                return;
            }

            // Mostrar loading en el área del sprint
            const sprintWrapper = $(`.sprint-backlog-wrapper[data-sprint-id="${sprintId}"]`);
            const sprintArea = sprintWrapper.find('.sprint-backlog-area');

            // Mostrar indicador de carga
            sprintArea.html(`
                    <div class="text-center text-body py-3">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <span>Cargando elementos del sprint...</span>
                    </div>
                `);

            // Llamada axios para obtener los items del sprint
            axios.get(`/proyectos/backlog/${uid}/sprints/${sprintId}/sprbacklog/show`)
                .then(function(response) {
                    if (response.data.success) {
                        const items = response.data.items;

                        if (items.length === 0) {
                            // No hay items - mostrar mensaje para agregar
                            sprintWrapper.html(`
                                    <div class="sprint-backlog-area rounded p-3 min-height-100" 
                                        style="min-height: 100px; border-color: #dee2e6;"
                                        data-sprint-id="${sprintId}">

                                        <div class="text-center text-body py-3">
                                            <i class="fas fa-arrow-down fs-4 mb-2 d-block"></i>
                                            <p class="small mb-0">
                                                <a 
                                                    href="#" 
                                                    class="text-primary fw-bold" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalRegSprBacklog" 
                                                    data-sprint-id="${sprintId}"
                                                >
                                                    Agregue un elemento
                                                </a> 
                                                o simplemente arrastre y suelte Backlog.
                                            </p>
                                        </div>

                                        <div class="sprint-backlog-list"></div>

                                    </div>
                                `);
                        } else {
                            // Hay items - mostrar lista
                            let itemsHtml = '<div class="sprint-items">';

                            items.forEach(function(item) {
                                // Determinar color de prioridad
                                const prioridadClass = item.prioridad?.toLowerCase() === 'alta' ? 'prioridad-alta' :
                                    item.prioridad?.toLowerCase() === 'media' ? 'prioridad-media' : 'prioridad-baja';

                                const badgeClass = item.prioridad === 'Alta' ? 'bg-danger' :
                                    item.prioridad === 'Media' ? 'bg-warning' : 'bg-success';


                                itemsHtml += `
                                        <div class="col-12 mb-2 sprint-item" data-item-id="${item.sprint_uid}">
                                            <div class="card shadow-sm border rounded-2 sprint-item ${prioridadClass}" style="font-size: 0.85rem;">
                                                <div class="card-body p-3">
                                                    
                                                    <!-- Título + Prioridad -->
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <p class="card-title mb-0 fw-semibold text-truncate" style="max-width: 70%;">
                                                            ${item.titulo || 'Sin título'}
                                                        </p>
                                                        <span class="badge ${badgeClass}">${item.prioridad || ''}</span>
                                                    </div>
                                                    
                                                    <!-- Descripción -->
                                                    ${item.descripcion ? `<p class="card-text text-muted small mb-2">${item.descripcion}</p>` : ''}

                                                    <!-- Estado + Tipo -->
                                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                                        <span> Estado: ${item.progreso || 'Sin estado'}</span>
                                                        <span> Valor: ${item.valor_historia || ''}</span>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                                                        <!-- Avatares de responsables -->
                                                        ${item.responsables_detalle && item.responsables_detalle.length > 0 ? `
                                                            <div class="d-flex align-items-center">
                                                                ${item.responsables_detalle.map(r => {
                                                                    let fotoSrc = "";
                                                                    if (r.foto_url) {
                                                                        fotoSrc = r.foto_url.startsWith("http") ? r.foto_url : "/storage/" + r.foto_url;
                                                                    }
                                                                    const isUiAvatar = r.foto_url && r.foto_url.includes("ui-avatars.com");

                                                                    return `
                                                                        <span class="position-relative d-inline-block me-1" data-bs-toggle="tooltip" title="${r.nombre}">
                                                                            ${r.foto_url 
                                                                                ? `
                                                                                    <img src="${fotoSrc}${!isUiAvatar ? `?v=${new Date().getTime()}` : ''}" 
                                                                                        alt="${r.nombre}" 
                                                                                        class="rounded-circle" 
                                                                                        style="width: 24px; height: 24px; object-fit: cover;"
                                                                                        ${!isUiAvatar 
                                                                                            ? `onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(r.nombre || 'U')}&background=0D8ABC&color=fff';"` 
                                                                                            : ''}>
                                                                                `
                                                                                : `
                                                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                                                        style="width: 24px; height: 24px;" 
                                                                                        title="${r.nombre}">
                                                                                        ${(r.nombre || 'U').charAt(0).toUpperCase()}
                                                                                    </div>
                                                                                `
                                                                            }
                                                                        </span>
                                                                    `;
                                                                }).join('')}
                                                            </div>
                                                        ` : `<div></div>` } <!-- Div vacío si no hay responsables -->


                                                        <!-- Dropup a la derecha -->
                                                        <div class="dropup">
                                                            <button class="btn btn-sm btn-secondary p-0 px-1" 
                                                                    type="button" 
                                                                    data-bs-toggle="dropdown" 
                                                                    aria-expanded="false" 
                                                                    data-bs-display="static">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                <li>
                                                                    <a class="dropdown-item editar-item editar-historia" href="#" 
                                                                    data-uid="${item.uid}"
                                                                    data-titulo="${item.titulo || ''}"
                                                                    data-descripcion="${item.descripcion || ''}"
                                                                    data-prioridad="${item.prioridad || ''}"
                                                                    data-valor="${item.valor_historia || ''}"
                                                                    data-progreso="${item.progreso || ''}">
                                                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item eliminar-item text-danger" href="#" data-item-id="${item.sprint_uid}">
                                                                        <i class="bi bi-box-arrow-left me-1"></i> Devolver
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    `;
                            });

                            itemsHtml += `
                                    <div class="text-center mt-3 sprint-backlog-area p-2 rounded-2"
                                        data-sprint-id="${sprintId}"
                                        <a href="#"
                                            class="text-primary fw-semibold small"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalRegSprBacklog"
                                            data-sprint-id="${sprintId}">
                                            <i class="fas fa-plus me-1"></i>
                                            Agregar otro elemento
                                        </a>

                                        <!-- Lista "virtual" para que tu drop funcione aquí también -->
                                        <div class="sprint-backlog-list sprint-backlog-area d-none"></div>
                                    </div>
                                    `;

                            sprintWrapper.html(itemsHtml);
                        }

                        // notyf.success("Sprint Backlog cargado correctamente");
                    } else {
                        throw new Error(response.data.error || 'Error desconocido');
                    }
                })
                .catch(function(error) {
                    console.error('Error al cargar Sprint Backlog:', error);

                    sprintWrapper.html(`
                            <div class="text-center text-danger py-3">
                                <i class="fas fa-exclamation-triangle fs-4 mb-2 d-block"></i>
                                <p class="small mb-2">Error al cargar los elementos del sprint</p>
                                <button class="btn btn-sm btn-outline-primary retry-load" data-sprint-id="${sprintId}">
                                    <i class="fas fa-redo me-1"></i>
                                    Intentar de nuevo
                                </button>
                            </div>
                        `);

                    notyf.error("Error al cargar el Sprint Backlog");
                });
        }

        // Cargar Sprint Backlog automáticamente cuando se cargue la página
        $('.sprint-backlog-wrapper').each(function() {
            const sprintId = $(this).data('sprint-id');
            if (sprintId) {
                loadSprintBacklog(sprintId);
            }
        });

        // Manejo del botón "Intentar de nuevo"
        $(document).on('click', '.retry-load', function(e) {
            e.preventDefault();
            const sprintId = $(this).data('sprint-id');
            loadSprintBacklog(sprintId);
        });

        // Recargar cuando se guarde un nuevo item en el modal
        $('#modalRegSprBacklog').on('hidden.bs.modal', function() {
            // Obtener el sprint ID del modal
            const sprintId = $(this).data('sprint-id');
            if (sprintId) {
                // Recargar el sprint backlog después de cerrar el modal
                setTimeout(() => {
                    loadSprintBacklog(sprintId);
                }, 500);
            }
        });

        // Capturar el sprint ID cuando se abre el modal
        $(document).on('click', '[data-bs-target="#modalRegSprBacklog"]', function() {
            const sprintId = $(this).data('sprint-id');
            $('#modalRegSprBacklog').data('sprint-id', sprintId);
        });

        // Manejo de acciones de los items (editar/eliminar)
        $(document).on('click', '.edit-item', function(e) {
            e.preventDefault();
            const itemId = $(this).data('item-id');
            // Aquí puedes abrir un modal de edición o redirigir
            console.log('Editar item:', itemId);
            // Ejemplo: $('#modalEditSprBacklog').modal('show').data('item-id', itemId);
        });

        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            const itemId = $(this).data('item-id');
            if (confirm('¿Está seguro de que desea eliminar este elemento?')) {
                const uid = $("#id_proyecto").val();

                axios.delete(`/proyectos/backlog/${uid}/sprints/items/${itemId}`)
                    .then(function(response) {
                        if (response.data.success) {
                            notyf.success("Elemento eliminado correctamente");
                            // Recargar el sprint backlog
                            const sprintId = $(`.sprint-item[data-item-id="${itemId}"]`)
                                .closest('.sprint-backlog-wrapper')
                                .data('sprint-id');
                            if (sprintId) {
                                loadSprintBacklog(sprintId);
                            }
                        } else {
                            notyf.error("Error al eliminar el elemento");
                        }
                    })
                    .catch(function(error) {
                        console.error('Error al eliminar:', error);
                        notyf.error("Error al eliminar el elemento");
                    });
            }
        });

        // Función para refrescar todos los sprint backlogs
        window.refreshAllSprintBacklogs = function() {
            $('.sprint-backlog-wrapper').each(function() {
                const sprintId = $(this).data('sprint-id');
                if (sprintId) {
                    loadSprintBacklog(sprintId);
                }
            });
        };

        // Exponer la función globalmente para poder llamarla desde otros lugares
        window.loadSprintBacklog = loadSprintBacklog;

        //Devolver historia al product_backlog
        $(document).on('click', '.eliminar-item', function(e) {
            e.preventDefault();

            const uidHistoria = $(this).data('item-id');
            const uidProyecto = $("#id_proyecto").val();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "La historia será devuelta al Product Backlog",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, devolver',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/proyectos/backlog/${uidProyecto}/sprints/items/${uidHistoria}/devolver`)
                        .then(function(response) {
                            if (response.data.success) {
                                Swal.fire(
                                    'Devuelta!',
                                    response.data.message,
                                    'success'
                                );

                                cargarHistorias();

                                // Recargar sprint backlog solo del sprint afectado
                                const sprintId = $(`.sprint-item[data-item-id="${uidHistoria}"]`)
                                    .closest('.sprint-backlog-wrapper')
                                    .data('sprint-id');

                                if (sprintId) {
                                    loadSprintBacklog(sprintId);
                                }
                            } else {
                                Swal.fire(
                                    'Error',
                                    response.data.message || "No se pudo devolver la historia",
                                    'error'
                                );
                            }
                        })
                        .catch(function(error) {
                            console.error('Error al devolver:', error);
                            Swal.fire(
                                'Error',
                                "Error al devolver la historia",
                                'error'
                            );
                        });
                }
            });
        });


    });

    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });


    function mostrarSeccion(id) {
        // Ocultar todas las vistas
        document.querySelectorAll('#contenido-tab > div').forEach(seccion => {
            seccion.style.display = 'none';
        });

        // Mostrar solo la seleccionada
        const target = document.getElementById(id);
        if (target) target.style.display = 'block';

        // Manejar clase active en tabs
        document.querySelectorAll('.nav-link[data-target]').forEach(link =>
            link.classList.remove('active')
        );
        const activeLink = document.querySelector(`.nav-link[data-target="${id}"]`);
        if (activeLink) activeLink.classList.add('active');
    }

    // Tabs: manejar clicks solo si tienen data-target
    document.querySelectorAll('.nav-link[data-target]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-target');
            if (id) {
                mostrarSeccion(id);
            }
        });
    });


    // 👉 Verificar si hay sprint activo al cargar
    document.addEventListener('DOMContentLoaded', function() {
        const proyectoUID = document.getElementById('uid_proyecto').value;

        axios.get(`/proyectos/${proyectoUID}/sprints/activo`)
            .then(response => {
                if (response.data.success && response.data.sprint) {
                    const sprintUID = response.data.sprint.uid;

                    sessionStorage.setItem('currentSprintUID', sprintUID);

                    // Mostrar directamente tablero
                    mostrarSeccion('tablero');
                    cargarTablero(proyectoUID, sprintUID);
                } else {
                    // Mostrar por defecto trabajo pendiente
                    mostrarSeccion('vista-pendiente');
                }
            })
            .catch(err => {
                console.error(err);
                mostrarSeccion('vista-pendiente');
            });
    });

    function enableRightDropdowns(scope) {
        // scope = tarjeta nueva, o todo el documento si no pasas nada
        const root = scope || document;
        root.querySelectorAll('.dropdown').forEach(function(drop) {
            if (drop.dataset.rightDropdownAttached) return; // ya lo tiene
            drop.dataset.rightDropdownAttached = '1';

            const toggle = drop.querySelector('[data-bs-toggle="dropdown"]');
            const menu = drop.querySelector('.dropdown-menu');

            if (!toggle || !menu) return;

            // al abrir
            drop.addEventListener('shown.bs.dropdown', function() {
                // guardar referencia
                menu.__origParent = menu.parentNode;
                menu.__origNext = menu.nextSibling;
                menu.__toggle = toggle;

                // mover al body
                document.body.appendChild(menu);

                menu.style.position = 'absolute';
                menu.style.zIndex = 2000;

                positionMenu(menu, toggle);
            });

            // al cerrar
            drop.addEventListener('hidden.bs.dropdown', function() {
                if (menu.__origParent) {
                    if (menu.__origNext) {
                        menu.__origParent.insertBefore(menu, menu.__origNext);
                    } else {
                        menu.__origParent.appendChild(menu);
                    }
                }
                menu.style.position = '';
                menu.style.left = '';
                menu.style.top = '';
                menu.style.zIndex = '';
                menu.__origParent = null;
                menu.__origNext = null;
                menu.__toggle = null;
            });
        });
    }

    // Calcula la posición a la derecha del botón, centrado verticalmente
    function positionMenu(menu, toggle) {
        const rect = toggle.getBoundingClientRect();
        const menuRect = menu.getBoundingClientRect();

        const left = rect.right + 8 + window.scrollX; // 8px espacio
        let top = rect.top + (rect.height / 2) - (menuRect.height / 2) + window.scrollY;

        // evitar que se salga de pantalla
        const maxTop = document.documentElement.clientHeight - menuRect.height + window.scrollY - 8;
        const minTop = window.scrollY + 8;
        if (top > maxTop) top = maxTop;
        if (top < minTop) top = minTop;

        menu.style.left = left + 'px';
        menu.style.top = top + 'px';
    }

    // re-posicionar si haces scroll o resize
    window.addEventListener('scroll', function() {
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            if (menu.__toggle) positionMenu(menu, menu.__toggle);
        });
    }, true);

    window.addEventListener('resize', function() {
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            if (menu.__toggle) positionMenu(menu, menu.__toggle);
        });
    });
</script>
@endsection