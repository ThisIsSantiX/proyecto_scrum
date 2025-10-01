@extends('layouts.layout.layout')

@section('title', 'Scrum')

@section('content')
    <!-- ========== HEADER Y NAVEGACIÓN ========== -->
    <div class="container-fluid content-inner mt-5 pt-4 py-0">
        <div class="row sticky-subheader">
            <div class="col-12">
                <div class="card shadow-sm border">
                    <div class="card-body py-2 pb-0">
                        <!-- Título del Proyecto -->
                        <h5 class="mb-2 mt-2 fw-semibold d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-bold">{{ $proyecto->nombre }}</span>
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navOpciones" aria-expanded="true" aria-controls="navOpciones">
                                <i class="bi bi-chevron-up"></i>
                            </button>
                        </h5>

                        <!-- Navegación por Pestañas -->
                        <div id="navOpciones" class="collapse show">
                            <ul class="nav flex-row mt-2 small">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0)" data-target="vista-pendiente">
                                        Trabajo pendiente
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0)" data-target="tablero">
                                        Tablero
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-target="reuniones">
                                        Reuniones
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0)" data-target="calendario">
                                        Calendario
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== CONTENIDO PRINCIPAL ========== -->
        <div id="contenido-tab" class="mt-3">

            <!-- ========== VISTA: TRABAJO PENDIENTE ========== -->
            <div id="vista-pendiente">
                <div class="row g-3">

                    <!-- Columna: Backlog de Historias -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header d-flex justify-content-between align-items-center py-2">
                                <h6 class="mb-0 fw-semibold fs-6">
                                    <i class="bi bi-list-task text-primary me-1"></i>
                                    Backlog
                                </h6>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalHistoria">
                                    <i class="bi bi-plus-circle me-1"></i> Nueva
                                </button>
                            </div>
                            <div class="card-body py-3 px-3" id="historias-content">
                                <!-- Loading State -->
                                <div class="d-flex justify-content-center py-3" id="loading-historias">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                </div>
                                <!-- Empty State -->
                                <div class="empty-state text-center text-muted py-3 d-none" id="empty-historias">
                                    <i class="bi bi-journal fs-4 d-block mb-1"></i>
                                    <p class="small mb-1">No hay historias creadas</p>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalHistoria">
                                        + Crear historia
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna: Sprints -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header d-flex justify-content-between align-items-center py-2">
                                <h6 class="mb-0 fw-semibold fs-6">
                                    <i class="bi bi-flag text-success me-1"></i>
                                    Sprints
                                </h6>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalSprint">
                                    <i class="bi bi-plus-circle me-1"></i> Nuevo
                                </button>
                            </div>
                            <div class="card-body py-3 px-3">
                                <div id="sprintsContainer">
                                    <!-- Empty State Sprints -->
                                    <div id="emptyState" class="empty-state text-center text-muted">
                                        <i class="bi bi-flag-fill d-block mb-2" style="font-size: 2.83rem;"></i>
                                        <p class="small mb-2">No hay sprints creados</p>
                                        <p class="text-muted small mb-3">Crea tu primer sprint para empezar a trabajar</p>
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#modalSprint">
                                            + Crear primer sprint
                                        </button>
                                    </div>
                                    <!-- Lista de Sprints -->
                                    <div id="sprintsList" class="d-none">
                                        <!-- Los sprints se cargarán aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== VISTA: TABLERO ========== -->
            <div id="tablero" style="display: none;">
                <!-- Contenido del tablero se carga dinámicamente -->
            </div>

            <!-- ========== VISTA: REUNIONES ========== -->
            <div id="reuniones" style="display: none;">
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">Daily Scrum</h3>
                                    <button class="btn btn-light" data-bs-toggle="modal"
                                        data-bs-target="#createModal" id="btnNuevaReunion">
                                        <i class="fas fa-plus me-2"></i>Nueva Reunión
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="dailyScrumTable">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Programada</th>
                                                    <th>Duración (min)</th>
                                                    <th>Proyecto</th>
                                                    <th>Sprint</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dailyScrumTableBody">
                                                <tr id="loadingRow">
                                                    <td colspan="5" class="text-center py-4">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="visually-hidden">Cargando...</span>
                                                        </div>
                                                        <p class="mt-2">Cargando reuniones...</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Paginación -->
                                    <nav aria-label="Page navigation" class="mt-3" id="paginationContainer"
                                        style="display: none;">
                                        <ul class="pagination justify-content-center" id="pagination">
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== VISTA: CALENDARIO ========== -->
            <div id="calendario" style="display: none;">
                <div class="container-fluid">
                    <div class="row" style="height: 100%;">
                        <!-- Columna: Lista de Sprints -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <h6 class="fw-bold m-3">Sprints</h6>
                                <ul id="lista-sprints" class="list-group m-2">
                                    <!-- Los sprints se cargarán aquí -->
                                </ul>
                            </div>
                        </div>
                        <!-- Columna: Calendario -->
                        <div class="col-md-8">
                            <div id="calendar" class="card p-3" style="min-height: 80vh;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== MODALES ========== -->

    <!-- MODAL: NUEVA HISTORIA DE USUARIO -->
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
                            <input type="text" class="form-control" id="titulo" name="titulo" maxlength="50" required>
                            <div class="form-text text-muted">Máximo 50 caracteres</div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="255" required></textarea>
                            <div class="form-text text-muted">Máximo 255 caracteres</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prioridad" class="form-label">Prioridad</label>
                                    <select class="form-select" id="prioridad" name="prioridad" required>
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
                                    <input type="number" class="form-control" id="valor_historia" name="valor_historia"
                                        min="1" max="100" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="progreso" class="form-label">Estado</label>
                            <select class="form-select" id="progreso" name="progreso" required>
                                <option value="">Seleccionar...</option>
                                <option value="Por hacer">Por hacer</option>
                                <option value="En progreso">En progreso</option>
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

    <!-- MODAL: EDITAR HISTORIA DE USUARIO -->
    <div class="modal fade" id="modalHistoriaEdit" tabindex="-1" aria-labelledby="modalHistoriaEditLabel"
        aria-hidden="true">
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
                        <input type="hidden" id="edit_historia_uid" value="">

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

    <!-- MODAL: NUEVO CRITERIO DE ACEPTACIÓN -->
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
                            <textarea class="form-control" id="criterio_descripcion" rows="3" maxlength="255" required></textarea>
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

    <!-- MODAL: EDITAR CRITERIO DE ACEPTACIÓN -->
    <div class="modal fade" id="modalCriterioEdit" tabindex="-1" aria-labelledby="modalCriterioLabel"
        aria-hidden="true">
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

    <!-- MODAL: NUEVO SPRINT -->
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
                            <input type="text" id="nombreSprint" name="nombre" class="form-control"
                                placeholder="Sprint 1" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" id="fechaInicio" name="fecha_inicio" class="form-control"
                                        required>
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
                            <textarea id="objetivoSprint" name="objetivo" class="form-control" rows="3"
                                placeholder="Descripción del objetivo..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Duración</label>
                            <select id="duracionSprint" name="duracion" class="form-select" required>
                                <option value="">Seleccionar duración</option>
                                <option value="1">1 semana</option>
                                <option value="2">2 semanas</option>
                                <option value="3">3 semanas</option>
                                <option value="4">4 semanas</option>
                            </select>
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

    <!-- MODAL: EDITAR SPRINT -->
    <div class="modal fade" id="modalEditarSprint" tabindex="-1" aria-labelledby="modalEditarSprintLabel"
        aria-hidden="true">
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
                                    <input type="date" id="editarFechaInicio" name="fecha_inicio"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" id="editarFechaFin" name="fecha_fin" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Objetivo del Sprint</label>
                            <textarea id="editarObjetivoSprint" name="objetivo" class="form-control" rows="3" required></textarea>
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

    <!-- MODAL: AGREGAR AL SPRINT BACKLOG -->
    <div class="modal fade" id="modalRegSprBacklog" tabindex="-1" aria-labelledby="modalRegSprBacklogLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegSprBacklogLabel">
                        <i class="fas fa-tasks me-2"></i>
                        Agregar al Sprint Backlog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
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

                        <!-- Estado -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Estado</label>
                                    <select id="progresoSpr" name="progreso" class="form-select" required>
                                        <option value="">Seleccionar estado</option>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="en_progreso">En progreso</option>
                                        <option value="completado">Completado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Sprint -->
                        <div class="mb-3">
                            <label class="form-label">Sprint</label>
                            <select id="id_sprint" name="id_sprint" class="form-select" required>
                                <option value="">Seleccionar Sprint</option>
                            </select>
                            <input type="hidden" id="current_id_sprints" value="">
                        </div>

                        <!-- Asignación de Usuarios -->
                        <div class="mb-3">
                            <label class="form-label">Asignar usuarios</label>
                            <div class="custom-dropdown border rounded-2">
                                <div class="workspace-header">
                                    <i class="fas fa-users me-2"></i>
                                    Participantes del proyecto
                                </div>
                                <div class="dropdown-content modal-body">
                                    <input type="text" class="search-box form-control"
                                        placeholder="Escriba el nombre de usuario" id="searchBox">
                                    <div id="usersList">
                                        <!-- Los usuarios se cargarán aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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

    <!-- MODAL: INICIAR SPRINT -->
    <div class="modal fade" id="modalIniciarSprint" tabindex="-1" aria-labelledby="modalIniciarSprintLabel"
        aria-hidden="true">
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

    <!-- MODAL: EDITAR HISTORIA EN SPRINT -->
    <div class="modal fade" id="modalHistoriaEditSprint" tabindex="-1" aria-labelledby="modalHistoriaEditLabel"
        aria-hidden="true">
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
                        <input type="hidden" id="edit_historia_uid" value="">

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

    <!-- MODALES PARA REUNIONES -->

    <!-- Modal Crear Reunión -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Crear Nueva Reunión Daily Scrum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm" method="POST" action="{{ route('storeDailyScrum', $proyecto->uid) }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duracion" class="form-label">Duración (minutos) *</label>
                                <input type="number" class="form-control" id="duracion" name="duracion" min="1" max="15" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_proyectos" class="form-label">Proyecto *</label>
                                <select class="form-select" id="id_proyectos" name="id_proyectos" required>
                                    <option value="">Seleccionar proyecto...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_sprints" class="form-label">Sprint *</label>
                                <select class="form-select" id="id_sprints" name="id_sprints" required>
                                    <option value="">Seleccionar sprint...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="URL" class="form-label">URL de la Reunión</label>
                            <input type="url" class="form-control" id="URL" name="URL"
                                placeholder="https://ejemplo.com/reunion">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveDailyScrum">
                        <span class="btn-loading" style="display: none;">
                            <span class="spinner-border spinner-border-sm me-2"></span> Guardando...
                        </span>
                        <span class="btn-text">Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Reunión -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Reunión Daily Scrum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="{{ route('updateDailyScrum', $proyecto->uid) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="edit_uid" name="uid">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fecha" class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="edit_fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_duracion" class="form-label">Duración (minutos) *</label>
                                <input type="number" class="form-control" id="edit_duracion" name="duracion" min="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_id_proyectos" class="form-label">Proyecto *</label>
                                <select class="form-select" id="edit_id_proyectos" name="id_proyectos" required>
                                    <option value="">Seleccionar proyecto...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_id_sprints" class="form-label">Sprint *</label>
                                <select class="form-select" id="edit_id_sprints" name="id_sprints" required>
                                    <option value="">Seleccionar sprint...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_URL" class="form-label">URL de la Reunión</label>
                            <input type="url" class="form-control" id="edit_URL" name="URL"
                                placeholder="https://ejemplo.com/reunion">
                        </div>
                        <div class="mb-3">
                            <label for="edit_observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_bloqueos_detectados" class="form-label">Bloqueos Detectados</label>
                            <textarea class="form-control" id="edit_bloqueos_detectados" name="bloqueos_detectados" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_acuerdos" class="form-label">Acuerdos</label>
                            <textarea class="form-control" id="edit_acuerdos" name="acuerdos" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="updateDailyScrum">
                        <span class="btn-loading" style="display: none;">
                            <span class="spinner-border spinner-border-sm me-2"></span> Actualizando...
                        </span>
                        <span class="btn-text">Actualizar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalles Reunión -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Detalles de la reunión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <strong>Fecha:</strong> <span id="detail_fecha"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Duración:</strong> <span id="detail_duracion"></span> min
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <strong>Proyecto:</strong> <span id="detail_proyecto"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Sprint:</strong> <span id="detail_sprint"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>URL:</strong> <a id="detail_URL" href="#" target="_blank"></a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Observaciones:</strong>
                            <div id="detail_observaciones" class="border rounded p-2 bg-light"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Bloqueos detectados:</strong>
                            <div id="detail_bloqueos" class="border rounded p-2 bg-light"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Acuerdos:</strong>
                            <div id="detail_acuerdos" class="border rounded p-2 bg-light"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        /* ========== ESTILOS GENERALES ========== */
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

        /* ========== ESTILOS DE SPRINTS ========== */
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

        /* ========== ESTILOS DE BACKLOG ========== */
        .sprint-backlog-area {
            transition: all 0.3s ease;
            border: 2px white dashed;
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

        /* ========== ESTILOS DE FORMULARIOS ========== */
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

        /* ========== ESTILOS DE NAVEGACIÓN ========== */
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
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar Notyf
            const notyf = new Notyf({
                duration: 4000,
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                        type: 'warning',
                        background: 'orange',
                        icon: {
                            className: 'material-icons',
                            tagName: 'i',
                            text: 'warning'
                        }
                    },
                    {
                        type: 'info',
                        background: 'blue',
                        icon: {
                            className: 'material-icons',
                            tagName: 'i',
                            text: 'info'
                        }
                    }
                ]
            });

            // Contador de caracteres para título
            $('#titulo').on('input', function() {
                const maxLength = 50;
                const currentLength = $(this).val().length;
                const formText = $(this).siblings('.form-text');
                formText.text(`${currentLength}/${maxLength} caracteres`);

                if (currentLength >= maxLength) {
                    formText.addClass('text-danger').removeClass('text-muted');
                } else {
                    formText.addClass('text-muted').removeClass('text-danger');
                }
            });

            // Contador de caracteres para descripción
            $('#descripcion').on('input', function() {
                const maxLength = 255;
                const currentLength = $(this).val().length;
                const formText = $(this).siblings('.form-text');
                formText.text(`${currentLength}/${maxLength} caracteres`);

                if (currentLength >= maxLength) {
                    formText.addClass('text-danger').removeClass('text-muted');
                } else {
                    formText.addClass('text-muted').removeClass('text-danger');
                }
            });

            // Función para cargar historias
            function cargarHistorias() {
                const proyectoUid = $('#proyecto_uid').val();

                $('#loading-historias').show();

                axios.get(`/proyectos/backlog/${proyectoUid}/show`)
                    .then(function(response) {
                        $('#loading-historias').hide();

                        if (response.data.success) {
                            mostrarHistorias(response.data.historias);
                        } else {
                            mostrarEstadoVacio();
                            notyf.error(response.data.message || 'Error al cargar las historias');
                        }
                    })
                    .catch(function(error) {
                        $('#loading-historias').hide();
                        console.error('Error al cargar historias:', error);
                        mostrarEstadoVacio();

                        if (error.response && error.response.data && error.response.data.message) {
                            notyf.error(error.response.data.message);
                        } else {
                            notyf.error('Error al cargar las historias');
                        }
                    });
            }

            window.cargarHistorias = cargarHistorias;


            // Función para mostrar las historias en el DOM
            function mostrarHistorias(historias) {
                if (historias && historias.length > 0) {
                    let historiasHtml = '<div class="row" id="historias-container">';

                    historias.forEach(function(historia) {
                        const prioridadClass = historia.prioridad.toLowerCase() === 'alta' ?
                            'prioridad-alta' :
                            historia.prioridad.toLowerCase() === 'media' ? 'prioridad-media' :
                            'prioridad-baja';

                        const badgeClass = historia.prioridad === 'Alta' ? 'bg-danger' :
                            historia.prioridad === 'Media' ? 'bg-warning' : 'bg-success';

                        let criteriosHtml = '';
                        if (historia.criterios && historia.criterios.length > 0) {
                            criteriosHtml = `
                                <div class="mt-2">
                                    <small class="text-muted fw-bold">Criterios de Aceptación:</small>
                                    <ul class="list-unstyled mt-1">
                            `;

                            historia.criterios.forEach(function(criterio) {
                                criteriosHtml += `
                                    <li class="small d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi ${criterio.estado ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted'} me-1"></i>
                                            ${criterio.descripcion}
                                        </div>
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
                                                    <a class="dropdown-item editar-criterio" href="#"
                                                    data-criterio-id="${criterio.uid}"
                                                    data-criterio-descripcion="${criterio.descripcion}">
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

                                `;
                            });

                            criteriosHtml += `
                                    </ul>
                                </div>
                            `;
                        }

                        historiasHtml += `
                            <div class="col-12 mb-2" data-historia-id="${historia.id}">
                                <div class="card shadow-sm border rounded-2 historia-item ${prioridadClass}"
                                    draggable="true"
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
                                            <p class="card-title mb-0 fw-semibold text-truncate" style="max-width: 70%;">
                                                ${historia.titulo}
                                            </p>
                                            <span class="badge ${badgeClass}">${historia.prioridad}</span>
                                        </div>

                                        <p class="card-text text-muted small mb-2">${historia.descripcion}</p>

                                        <div class="d-flex justify-content-between align-items-center small text-muted">
                                            <span> Estado: ${historia.progreso}</span>
                                            <span> Valor: ${historia.valor_historia}</span>
                                        </div>

                                        <!-- Creado por + opciones -->
                                        <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                                            <span class="position-relative d-inline-block" data-bs-toggle="tooltip" title="${historia.creador_nombre || 'Desconocido'}">
                                                <img src="${historia.foto_url}"
                                                    alt="${historia.creador_nombre || 'Usuario'}"
                                                    class="rounded-circle"
                                                    style="width: 24px; height: 24px; object-fit: cover;">
                                            </span>

                                            <div class="d-flex align-items-center">
                                                <!-- Botón para agregar criterios -->
                                                <button class="btn btn-sm btn-primary me-1 p-0 px-1 agregar-criterio" title="Agregar criterio" data-historia-id="${historia.uid}">
                                                    <i class="bi bi-check2-square"></i>
                                                </button>
                                                <!-- Menú de opciones (Editar / Eliminar) -->
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
                } else {
                    mostrarEstadoVacio();
                }
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
                                notyf.error(response.data.message ||
                                    "Error al guardar la historia.");
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
                                    $(`[data-historia-id="${historiaUid}"]`).fadeOut(300,
                                        function() {
                                            $(this).remove();
                                        });

                                    cargarHistorias();
                                } else {
                                    notyf.error(response.data.message ||
                                        "No se pudo eliminar la historia.");
                                }
                            })
                            .catch(function(error) {
                                console.error("Error al eliminar historia:", error);

                                if (error.response && error.response.data && error.response.data
                                    .message) {
                                    notyf.error(error.response.data.message);
                                } else {
                                    notyf.error(
                                        "Error interno al intentar eliminar la historia.");
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
            //_______________________________________________

            // Abrir modal y pasar el UID de la historia
            $(document).on('click', '.agregar-criterio', function(e) {
                e.preventDefault();
                const historiaUid = $(this).data('historia-id');
                $('#criterio_historia_uid').val(historiaUid);
                $('#criterio_descripcion').val('');
                $('#modalCriterio').modal('show');
            });

            // Guardar criterio
            $('#formCriterio').on('submit', function(e) {
                e.preventDefault();

                const historiaUid = $('#criterio_historia_uid').val();
                const descripcion = $('#criterio_descripcion').val().trim();

                if (descripcion === '') {
                    notyf.error('La descripción no puede estar vacía');
                    return;
                }

                axios.post(`/criterios/${historiaUid}/store`, {
                        descripcion: descripcion
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            notyf.success('Criterio agregado con éxito');
                            $('#modalCriterio').modal('hide');
                            cargarHistorias(); // refresca la lista con criterios
                        } else {
                            notyf.error(response.data.message || 'Error al guardar el criterio');
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        notyf.error('Error interno del servidor');
                    });
            });
            //FUNCION PARA EDITAR UN CRITERIO
            $(document).on('click', '.editar-criterio', function(e) {
                e.preventDefault();
                const uid = $(this).data('criterio-id');
                const descripcion = $(this).data('criterio-descripcion');

                $("#criterio_uid").val(uid);
                $("#criterio_descripcionEdit").val(descripcion);

                $("#modalCriterioEdit").modal('show');
            });

            //mandar la informacion del critertio
            $('#formCriterioEdit').on('submit', function(e) {
                e.preventDefault();

                let uid = $('#criterio_uid').val();
                let descripcion = $('#criterio_descripcionEdit').val();

                if (descripcion === '') {
                    notyf.error('La descripción no puede estar vacía');
                    return;
                }
                $.ajax({
                    url: `/criterios/${uid}/update`,
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        descripcion: descripcion,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            notyf.success(response.message || 'Se edito correctamente');
                            $('#modalCriterioEdit').modal('hide');
                            cargarHistorias();
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = "Error al actualizar el criterio.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        notyf.error(errorMsg);
                    }
                })
            })
            //-----------------
            //ELIMINAR UN CRITERIO
            $(document).on('click', '.eliminar-criterio', function(e) {
                e.preventDefault();

                const uid = $(this).data('criterio-id');

                if (!uid) {
                    notyf.error("No se encontró el ID de la historia.");
                    return;
                }
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
                                    notyf.error(response.data.message ||
                                        "No se pudo eliminar el criterio.");
                                }
                            })
                            .catch(function(error) {
                                console.error("Error al eliminar el criterio:", error);

                                if (error.response && error.response.data && error.response.data
                                    .message) {
                                    notyf.error(error.response.data.message);
                                } else {
                                    notyf.error(
                                        "Error interno al intentar eliminar el criterio.");
                                }
                            });
                    }
                })

            })
            //--------------------
            //____________________________


            // Función para mostrar estado vacío
            function mostrarEstadoVacio() {
                const estadoVacioHtml = `
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <p class="small mb-1">No hay historias creadas</p>
                        <p class="text-muted small mb-3">Comienza agregando tu primera historia de usuario</p>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistoria">
                            + Crear Primera Historia
                        </button>
                    </div>
                `;
                $('#historias-content').html(estadoVacioHtml);
            }

            function limpiarFormulario() {
                $('#formHistoria')[0].reset();
                $('#titulo').siblings('.form-text').text('Máximo 50 caracteres').removeClass('text-danger')
                    .addClass('text-muted');
                $('#descripcion').siblings('.form-text').text('Máximo 255 caracteres').removeClass('text-danger')
                    .addClass('text-muted');
            }

            // Función para validar formulario
            function validarFormulario() {
                const titulo = $('#titulo').val().trim();
                const descripcion = $('#descripcion').val().trim();
                const prioridad = $('#prioridad').val();
                const valorHistoria = $('#valor_historia').val();
                const progreso = $('#progreso').val();

                if (!titulo) {
                    notyf.error('El título es requerido.');
                    $('#titulo').focus();
                    return false;
                }

                if (titulo.length > 50) {
                    notyf.error('El título no puede exceder los 50 caracteres.');
                    $('#titulo').focus();
                    return false;
                }

                if (!descripcion) {
                    notyf.error('La descripción es requerida.');
                    $('#descripcion').focus();
                    return false;
                }

                if (descripcion.length > 255) {
                    notyf.error('La descripción no puede exceder los 255 caracteres.');
                    $('#descripcion').focus();
                    return false;
                }

                if (!prioridad) {
                    notyf.error('Debe seleccionar una prioridad.');
                    $('#prioridad').focus();
                    return false;
                }

                if (!valorHistoria || valorHistoria < 1 || valorHistoria > 100) {
                    notyf.error('El valor de la historia debe estar entre 1 y 100.');
                    $('#valor_historia').focus();
                    return false;
                }

                if (!progreso) {
                    notyf.error('Debe seleccionar un estado.');
                    $('#progreso').focus();
                    return false;
                }

                return true;
            }

            // Cargar historias al inicializar la página
            cargarHistorias();

            // Limpiar formulario cuando se abre el modal
            $('#modalHistoria').on('show.bs.modal', function() {
                limpiarFormulario();
            });

            // Configurar Axios defaults
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

            // Si usas CSRF token en Laravel
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            if (csrfToken) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
            }

            // Efectos visuales para las historias
            $(document).on('mouseenter', '.historia-item', function() {
                $(this).addClass('shadow-lg').css('transform', 'translateY(-2px)');
            });

            $(document).on('mouseleave', '.historia-item', function() {
                $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
            });

            // Hacer historias arrastrables (preparado para futuro drag & drop)
            $(document).on('dragstart', '.historia-item', function(e) {
                e.originalEvent.dataTransfer.setData("historiaId", $(this).data("id"));
                $(this).css('opacity', '0.5');
            });

            $(document).on('dragend', '.historia-item', function() {
                $(this).css('opacity', '1');
            });


            // Botón de refrescar historias (opcional)
            $(document).on('click', '.btn-refresh-historias', function() {
                notyf.open({
                    type: 'info',
                    message: 'Actualizando historias...'
                });
                cargarHistorias();
            });
        });

        // Sprints
        const notyf = new Notyf({
            duration: 3000,
            position: {
                x: 'right',
                y: 'top',
            }
        });

        // Variable global para almacenar sprints
        function getStatusBadge(estado) {
            const estados = {
                1: {
                    text: 'Por hacer',
                    class: 'bg-secondary'
                },
                2: {
                    text: 'En progreso',
                    class: 'bg-warning'
                },
                3: {
                    text: 'Completado',
                    class: 'bg-success'
                }
            };
            const status = estados[estado] || {
                text: 'Desconocido',
                class: 'bg-dark'
            };
            return `<span class="badge ${status.class} status-badge">${status.text}</span>`;
        }

        // Función para renderizar un sprint con su área de product backlog
        function renderSprint(sprint) {
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
                                    <button class="btn btn-sm btn-secondary p-0 px-1"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            data-bs-display="static">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li>
                                            <a class="dropdown-item editar-sprint" href="#" data-sprint-uid="${sprint.uid}">
                                                <i class="bi bi-pencil-square me-1"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item eliminar-sprint text-danger" href="#" data-sprint-uid="${sprint.uid}">
                                                <i class="bi bi-trash me-1"></i> Eliminar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <button class="btn btn-outline-success btn-sm ms-2"
                                        data-bs-toggle="modal"
                                        data-sprint-uid="${sprint.uid}"
                                        data-fecha-inicio="${sprint.fecha_inicio || ''}"
                                        data-fecha-fin="${sprint.fecha_fin || ''}"
                                        data-bs-target="#modalIniciarSprint">
                                <i class="bi bi-play-fill"></i> Iniciar
                                </button>
                            </div>
                            <p class="small text-muted mb-1 mt-2">${sprint.objetivo}</p>
                        </div>

                        <!-- Área de Product Backlog para el Sprint -->
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-muted">
                                    <i class="fas fa-tasks me-2"></i>
                                    Sprint Backlog
                                </h6>
                                <span class="badge bg-secondary">0 elementos</span>
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalRegSprBacklog"
                                    data-sprint-id="${sprint.id}"
                                >
                                    Agregar
                                </button>

                            </div>

                            <!-- Contenedor Sprint Backlog -->
                            <div class="sprint-backlog-wrapper" data-sprint-id="${sprint.id}">
                                <!-- Sprint backlog area (cuando hay SBs) -->
                                <div class="sprint-backlog-area rounded p-3 min-height-100"
                                    style="min-height: 100px; border-color: #dee2e6;"
                                    data-sprint-id="${sprint.id}"
                                    data-sprint-uid="${sprint.uid}">

                                    <div class="text-center text-body py-3">
                                        <i class="fas fa-arrow-down fs-4 mb-2 d-block"></i>
                                        <p class="small mb-0">
                                            <a
                                                href="#"
                                                class="text-primary fw-bold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalRegSprBacklog"
                                                data-sprint-id="${sprint.id}"
                                            >
                                                Agregue un elemento
                                            </a>
                                            o simplemente arrastre y suelte Backlog.
                                        </p>
                                    </div>

                                    <div class="sprint-backlog-list"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;


        }

        // Función para cargar sprints
        function cargarSprints() {
            const proyectoUID = $('#uid_proyecto').val();

            axios.get(`/proyectos/backlog/${proyectoUID}/sprints/show`)
                .then(response => {
                    sprints = response.data;
                    mostrarSprints();
                    window.refreshAllSprintBacklogs();
                    cargarTodosLosSprints();
                })
                .catch(error => {
                        console.error('Error al cargar sprints:', error);
                        if (error.response && error.response.status === 404) {
                            notyf.error('Proyecto no encontrado');
                        } else {
                            emptyState.addClass('d-none');
                            sprintsList.removeClass('d-none');

                            function cargarTodosLosSprints() {
                                const proyectoUID = $('#uid_proyecto').val();

                                axios.get(`/proyectos/backlog/${proyectoUID}/sprints/all`)
                                    .then(response => {
                                        sprints = response.data;
                                        console.log(sprints);

                                        // 🔹 Renderizar lista de sprints en la izquierda
                                        const lista = document.getElementById('lista-sprints');
                                        lista.innerHTML = "";

                                        if (sprints.length === 0) {
                                            lista.innerHTML =
                                                `<li class="list-group-item text-muted">No hay sprints creados</li>`;
                                        } else {
                                            const hoy = new Date();

                                            sprints.forEach(sprint => {
                                                const fechaInicio = new Date(sprint.fecha_inicio);
                                                const fechaFin = new Date(sprint.fecha_fin);

                                                // Determinar estado del sprint
                                                let estadoTexto = "";
                                                let estadoClase = "";

                                                if (hoy < fechaInicio) {
                                                    estadoTexto = "Por hacer";
                                                    estadoClase = "badge bg-secondary";
                                                } else if (hoy >= fechaInicio && hoy <= fechaFin) {
                                                    estadoTexto = "En progreso";
                                                    estadoClase = "badge bg-warning text-dark";
                                                } else {
                                                    estadoTexto = "Finalizado";
                                                    estadoClase = "badge bg-success";
                                                }

                                                lista.innerHTML += `
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-bold">${sprint.nombre}</div>
                                        <small class="text-muted">
                                            ${fechaInicio.toLocaleDateString()} - ${fechaFin.toLocaleDateString()}
                                        </small>
                                    </div>
                                    <span class="${estadoClase}">${estadoTexto}</span>
                                </li>
                            `;
                                            });
                                        }

                                        // 🔹 limpiar calendario
                                        calendar.removeAllEvents();

                                        // 🔹 volver a agregar cada sprint al calendario
                                        sprints.forEach(sprint => {
                                            addSprintToCalendar(sprint);
                                        });

                                        // 🔹 mostrar calendario si está oculto
                                        mostrarCalendario();
                                    })
                                    .catch(error => {
                                        console.error('Error al cargar todos los sprints:', error);
                                        if (error.response && error.response.status === 404) {
                                            notyf.error('Proyecto no encontrado');
                                        } else {
                                            notyf.error('Error al cargar los sprints');
                                        }
                                    });
                            }



                            let calendar;

                            document.addEventListener('DOMContentLoaded', function() {
                                const calendarEl = document.getElementById('calendar');
                                calendar = new FullCalendar.Calendar(calendarEl, {
                                    initialView: 'dayGridMonth',
                                    locale: 'es', // idioma español
                                    selectable: false,
                                    headerToolbar: {
                                        left: 'prev,next today',
                                        center: 'title',
                                        right: 'dayGridMonth,timeGridWeek'
                                    },
                                    events: [] // empieza vacío
                                });
                                calendar.render();
                            });

                            function mostrarCalendario() {
                                // Detectar clic en la pestaña "Calendario"
                                document.querySelector('[data-target="calendario"]').addEventListener('click', function() {
                                    // Mostrar el contenedor
                                    document.getElementById('calendario').style.display = "block";

                                    // Forzar que el calendario se redibuje con el tamaño correcto
                                    setTimeout(() => {
                                        calendar.updateSize();
                                    }, 200);
                                });

                            }


                            // 🔹 Función para agregar un sprint al calendario
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


                            // Función para mostrar sprints
                            function mostrarSprints() {
                                const container = $('#sprintsContainer');
                                const emptyState = $('#emptyState');
                                const sprintsList = $('#sprintsList');

                                sprintsList.html(html);

                                // Alternativa sin jQuery UI - usar HTML5 drag and drop
                                if (typeof $.fn.sortable === 'undefined') {
                                    habilitarDragDropHTML5();
                                } else {
                                    // Verificar que jQuery UI esté cargado antes de habilitar sortable
                                    // Habilitar drag & drop para sprints
                                    sprintsList.sortable({
                                        handle: '.drag-handle',
                                        placeholder: 'sprint-placeholder',
                                        update: function(event, ui) {
                                            actualizarOrdenSprints();
                                        }
                                    });

                                    // Habilitar drag & drop para las áreas de product backlog
                                    $('.sprint-backlog-area').sortable({
                                        connectWith: '.sprint-backlog-area',
                                        placeholder: 'backlog-placeholder',
                                        tolerance: 'pointer',
                                        over: function(event, ui) {
                                            $(this).addClass('drag-over');
                                        },
                                        out: function(event, ui) {
                                            $(this).removeClass('drag-over');
                                        },
                                        drop: function(event, ui) {
                                            $(this).removeClass('drag-over');
                                            notyf.success('Elemento movido al sprint');
                                        }
                                    });
                                }

                                // Agregar algunos elementos de prueba para mostrar el drag & drop
                            }
                        }

                        // Función alternativa usando HTML5 drag and drop
                        function habilitarDragDropHTML5() {
                            // Hacer las historias arrastrables
                            $(document).on('mouseenter', '.historia-item', function() {
                                $(this).attr('draggable', 'true');
                            });

                            // Inicia el arrastre
                            $(document).on('dragstart', '.historia-item', function(e) {
                                e.originalEvent.dataTransfer.setData('historiaUid', $(this).data('uid'));
                                $(this).addClass('dragging').css('opacity', '0.5');
                            });

                            // Termina el arrastre
                            $(document).on('dragend', '.historia-item', function(e) {
                                $(this).removeClass('dragging').css('opacity', '1');
                            });

                            // Permitir soltar en sprint
                            $(document).on('dragover', '.sprint-backlog-area', function(e) {
                                e.preventDefault();
                                $(this).addClass('drag-over');
                            });

                            $(document).on('dragleave', '.sprint-backlog-area', function(e) {
                                $(this).removeClass('drag-over');
                            });

                            // Soltar en sprint backlog

                            $(document).on('drop', '.sprint-backlog-area', function(e) {
                                e.preventDefault();
                                $(this).removeClass('drag-over');

                                const historiaUid = e.originalEvent.dataTransfer.getData('historiaUid');
                                const $historia = $(`.historia-item[data-uid="${historiaUid}"]`);

                                // Mover visualmente dentro del sprint backlog
                                $(this).find('.sprint-backlog-list').append($historia.closest('.col-12'));

                                // Borrar mensaje vacío si existía
                                $(this).find('.text-center').remove();

                                // Obtener datos necesarios
                                const sprintId = $(this).data('sprint-id');
                                const proyectoUID = $('#uid_proyecto').val();
                                const progreso = $historia.data('progreso');
                                const historiaId = $historia.closest('[data-historia-id]').data('historia-id');

                                // Llamar al backend para guardar en sprint_backlog
                                axios.post(
                                    `/proyectos/backlog/${proyectoUID}/sprints/${sprintId}/sprbacklog/store`, {
                                        id_item_backlog: historiaId,
                                        progreso: progreso,
                                        asignado_a: [] // puedes enviar IDs de miembros después
                                    }).then(res => {
                                    notyf.success('Historia agregada al Sprint Backlog');
                                    window.refreshAllSprintBacklogs();
                                    mostrarSprints();
                                    cargarSprints();
                                    window.cargarHistorias();
                                }).catch(err => {
                                    notyf.error('Error al mover historia al Sprint');
                                    console.error(err.response?.data || err);
                                });
                            });
                        }



                        // Función para actualizar orden de sprints (solo visual)
                        function actualizarOrdenSprints() {
                            const orden = [];
                            $('#sprintsList .sprint-item').each(function(index) {
                                orden.push({
                                    id: $(this).data('sprint-id'),
                                    orden: index + 1
                                });
                            });

                            // Solo mostramos feedback visual, no hacemos petición real
                            notyf.success('Orden de sprints actualizado (visual)');
                        }

                        // Función para crear sprint
                        function crearSprint() {
                            const proyectoUID = $('#uid_proyecto').val();

                            // Obtener datos del formulario
                            const formData = {
                                nombre: $('#nombreSprint').val(),
                                objetivo: $('#objetivoSprint').val(),
                                fecha_inicio: $('#fechaInicio').val(),
                                fecha_fin: $('#fechaFin').val(),
                                _token: $('meta[name="csrf-token"]').attr('content')
                            };

                            // Validar fechas
                            const fechaInicio = new Date(formData.fecha_inicio);
                            const fechaFin = new Date(formData.fecha_fin);

                            if (fechaFin <= fechaInicio) {
                                notyf.error('La fecha de fin debe ser posterior a la fecha de inicio');
                                return;
                            }

                            axios.post(`/proyectos/backlog/${proyectoUID}/sprints/store`, formData, {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    notyf.success(response.data.message || 'Sprint creado correctamente');
                                    $('#modalSprint').modal('hide');
                                    $('#formSprint')[0].reset();
                                    cargarSprints(); // Recargar la lista
                                })
                                .catch(error => {
                                    console.error('Error al crear sprint:', error);
                                    if (error.response) {
                                        if (error.response.status === 422) {
                                            // Errores de validación de Laravel
                                            const errors = error.response.data.errors;
                                            let errorMessage = 'Errores de validación:\n';
                                            Object.keys(errors).forEach(key => {
                                                errorMessage += `- ${errors[key][0]}\n`;
                                            });
                                            notyf.error(errorMessage);
                                        } else if (error.response.data && error.response.data.error) {
                                            notyf.error(error.response.data.error);
                                        } else {
                                            notyf.error('Error al crear el sprint');
                                        }
                                    } else {
                                        notyf.error('Error de conexión');
                                    }
                                });
                        }

                        // Event Listeners
                        $(document).ready(function() {
                            // Verificar librerías

                            // Cargar sprints al iniciar
                            cargarSprints();

                            // Crear sprint
                            $('#btnCrearSprint').click(function() {
                                if ($('#formSprint')[0].checkValidity()) {
                                    crearSprint();
                                } else {
                                    notyf.error('Por favor completa todos los campos requeridos');
                                    $('#formSprint')[0].reportValidity();
                                }
                            });

                            // Limpiar formulario al cerrar modal
                            $('#modalSprint').on('hidden.bs.modal', function() {
                                $('#formSprint')[0].reset();
                            });

                            // Establecer fecha mínima como hoy
                            const hoy = new Date().toISOString().split('T')[0];
                            $('#fechaInicio').attr('min', hoy);

                            // Actualizar fecha mínima de fin cuando cambie la de inicio
                            $('#fechaInicio').change(function() {
                                const fechaInicio = $(this).val();
                                if (fechaInicio) {
                                    $('#fechaFin').attr('min', fechaInicio);
                                }
                            });
                        });

                        // Función para editar sprint
                        function editarSprint(sprintUid) {
                            // Buscar sprint en el array
                            const sprint = sprints.find(s => s.uid === sprintUid);

                            if (!sprint) {
                                notyf.error('Sprint no encontrado');
                                return;
                            }

                            // Llenar el formulario
                            $('#editarSprintUid').val(sprint.uid); // <-- nuevo
                            $('#editarSprintId').val(sprint.id); // puedes mantenerlo si backend aún lo necesita
                            $('#editarNombreSprint').val(sprint.nombre);
                            $('#editarObjetivoSprint').val(sprint.objetivo);
                            $('#editarFechaInicio').val(sprint.fecha_inicio);
                            $('#editarFechaFin').val(sprint.fecha_fin);

                            // Mostrar modal
                            $('#modalEditarSprint').modal('show');
                        }



                        // Función para actualizar sprint
                        function actualizarSprint() {
                            const proyectoUID = $('#uid_proyecto').val();

                            // Obtener datos del formulario
                            const formData = {
                                uid: $('#editarSprintUid').val(), // <-- aquí cambias
                                nombre: $('#editarNombreSprint').val(),
                                objetivo: $('#editarObjetivoSprint').val(),
                                fecha_inicio: $('#editarFechaInicio').val(),
                                fecha_fin: $('#editarFechaFin').val(),
                                _token: $('meta[name="csrf-token"]').attr('content')
                            };

                            // Validar fechas
                            const fechaInicio = new Date(formData.fecha_inicio);
                            const fechaFin = new Date(formData.fecha_fin);

                            if (fechaFin <= fechaInicio) {
                                notyf.error('La fecha de fin debe ser posterior a la fecha de inicio');
                                return;
                            }

                            axios.post(`/proyectos/backlog/${proyectoUID}/sprints/update`, formData, {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    notyf.success(response.data.message || 'Sprint actualizado correctamente');
                                    $('#modalEditarSprint').modal('hide');
                                    $('#formEditarSprint')[0].reset();
                                    cargarSprints(); // Recargar la lista
                                })
                                .catch(error => {
                                    console.error('Error al actualizar sprint:', error);
                                    if (error.response) {
                                        if (error.response.status === 422) {
                                            // Errores de validación de Laravel
                                            const errors = error.response.data.errors;
                                            let errorMessage = 'Errores de validación:\n';
                                            Object.keys(errors).forEach(key => {
                                                errorMessage += `- ${errors[key][0]}\n`;
                                            });
                                            notyf.error(errorMessage);
                                        } else if (error.response.data && error.response.data.error) {
                                            notyf.error(error.response.data.error);
                                        } else {
                                            notyf.error('Error al actualizar el sprint');
                                        }
                                    } else {
                                        notyf.error('Error de conexión');
                                    }
                                });
                        }


                        // Función para eliminar sprint con SweetAlert
                        function eliminarSprint(sprintUid) {
                            // Buscar el sprint en el array para mostrar su nombre
                            const sprint = sprints.find(s => s.uid === sprintUid);
                            const nombreSprint = sprint ? sprint.nombre : 'este sprint';

                            const isDark = $("body").hasClass("dark");

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
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    ejecutarEliminacionSprint(sprintUid);
                                }
                            });
                        }

                        // Función para ejecutar la eliminación del sprint
                        function ejecutarEliminacionSprint(sprintUid) {
                            const proyectoUID = $('#uid_proyecto').val();
                            const isDark = $("body").hasClass("dark");

                            // Limpiar columnas y contadores
                            ["por-hacer", "en-progreso", "terminado", "en revision"].forEach(status => {
                                        const container = document.getElementById(`items-${status}`);
                                        if (container) container.innerHTML =
                                            `<div class="empty-column">No hay elementos en ${status.replace("-", " ")}</div>`;

                                        axios.post(`/proyectos/backlog/${proyectoUID}/sprints/destroy`, formData, {
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                                    'Content-Type': 'application/json'
                                                }
                                            })
                                            .then(response => {
                                                Swal.fire({
                                                    title: '¡Eliminado!',
                                                    text: response.data.message ||
                                                        'Sprint eliminado correctamente',
                                                    icon: 'success',
                                                    timer: 2000,
                                                    showConfirmButton: false,
                                                    background: isDark ? '#1e1e2d' : '#fff',
                                                    color: isDark ? '#f1f1f1' : '#000'
                                                });
                                                cargarSprints(); // Recargar la lista
                                            })
                                            .catch(error => {
                                                console.error('Error al eliminar sprint:', error);
                                                let errorMessage = 'Error al eliminar el sprint';

                                                if (error.response && error.response.data && error.response.data
                                                    .error) {
                                                    errorMessage = error.response.data.error;
                                                }

                                                Swal.fire({
                                                    title: 'Error',
                                                    text: errorMessage,
                                                    icon: 'error',
                                                    background: isDark ? '#1e1e2d' : '#fff',
                                                    color: isDark ? '#f1f1f1' : '#000'
                                                });
                                            });
                                    }

                                    $('#modalIniciarSprint').on('show.bs.modal', function(event) {
                                        const button = $(event.relatedTarget); // botón que abrió el modal
                                        const sprintUid = button.data('sprint-uid');
                                        const fechaInicio = button.data('fecha-inicio');
                                        const fechaFin = button.data('fecha-fin');

                                        // Guardar UID en el modal (para el submit después)
                                        $('#formIniciarSprint').data('sprint-uid', sprintUid);

                                        // Rellenar inputs
                                        $('#formIniciarSprint input[name="fecha_inicio"]').val(fechaInicio);
                                        $('#formIniciarSprint input[name="fecha_fin"]').val(fechaFin);
                                    });


                                    if (estado === "Por hacer" || estado === "to_do") estado = "por-hacer";
                                    if (estado === "En progreso" || estado === "in_progress") estado = "en-progreso";
                                    if (estado === "Completado" || estado === "done" || estado === "Terminado") estado =
                                        "terminado";
                                    if (estado === "En revision" || estado === "in_revision" || estado === "en-revision")
                                        estado = "en revision";

                                    $('#formIniciarSprint').on('submit', function(e) {
                                        e.preventDefault();

                                        const proyectoUID = $('#uid_proyecto').val();
                                        const sprintUID = $(this).data('sprint-uid');
                                        const fechaInicio = $(this).find('input[name="fecha_inicio"]').val();
                                        const fechaFin = $(this).find('input[name="fecha_fin"]').val();

                                        axios.post(
                                                `/proyectos/backlog/${proyectoUID}/sprints/${sprintUID}/items/start`, {
                                                    fecha_inicio: fechaInicio,
                                                    fecha_fin: fechaFin
                                                })
                                            .then(response => {
                                                $('#modalIniciarSprint').modal('hide');
                                                notyf.success('Sprint iniciado correctamente');
                                                sessionStorage.setItem('currentSprintUID', sprintUID);
                                                mostrarSeccion('tablero');
                                                cargarTablero(proyectoUID, sprintUID);
                                                cargarSprints();
                                            })
                                            .catch(error => {
                                                console.error(error);
                                                notyf.error('Error al iniciar sprint');
                                            });
                                    });

                                    function cargarTablero(proyectoUID, sprintUID) {
                                        $("#tablero").attr("data-proyecto", proyectoUID);
                                        $("#tablero").attr("data-sprint", sprintUID);

                                        $("#tablero").html('<div class="text-center p-3">Cargando tablero...</div>');

                                        // 1️⃣ Primero cargamos la estructura del tablero desde la vista Blade
                                        axios.get(`/proyectos/${proyectoUID}/sprints/${sprintUID}/board/view`, {
                                                headers: {
                                                    "X-Requested-With": "XMLHttpRequest"
                                                }
                                            })
                                            .then(response => {
                                                // Pintar la estructura del tablero (HTML)
                                                $("#tablero").html(response.data);

                                                // 2️⃣ Luego traemos los ítems del sprint backlog
                                                return axios.get(
                                                    `/proyectos/${proyectoUID}/sprints/${sprintUID}/board/items`);
                                            })
                                            .then(response => {
                                                if (!response.data.success) {
                                                    notyf.error(response.data.message ||
                                                        "Error al cargar ítems del tablero");
                                                    return;
                                                }

                                                const items = response.data.items || [];

                                                // Limpiar columnas y contadores
                                                ["por-hacer", "en-progreso", "terminado"].forEach(status => {
                                                    const container = document.getElementById(
                                                        `items-${status}`);
                                                    if (container) container.innerHTML =
                                                        `<div class="empty-column">No hay elementos en ${status.replace("-", " ")}</div>`;

                                                    const counter = document.getElementById(
                                                        `counter-${status}`);
                                                    if (counter) counter.textContent = 0;
                                                });

                                                // Renderizar los ítems
                                                items.forEach(item => renderKanbanItem(item));
                                            })
                                            .catch(error => {
                                                console.error(error);
                                                $("#tablero").html(
                                                    '<div class="alert alert-danger">Error al cargar el tablero</div>'
                                                );
                                            });
                                    }

                                    function renderKanbanItem(item) {
                                        // Usar item.progreso (texto) en vez de item.estado (número)
                                        let estado = item.progreso;

                                        if (estado === "Por hacer" || estado === "to_do") estado = "por-hacer";
                                        if (estado === "En progreso" || estado === "in_progress") estado = "en-progreso";
                                        if (estado === "Completado" || estado === "done" || estado === "Terminado") estado =
                                            "terminado";

                                        const container = document.getElementById(`items-${estado}`);
                                        if (!container) {
                                            console.warn("Estado no reconocido:", estado, item);
                                            return;
                                        }

                                        // Si hay mensaje "No hay elementos...", lo eliminamos
                                        const emptyMsg = container.querySelector('.empty-column');
                                        if (emptyMsg) emptyMsg.remove();

                                        // Crear tarjeta
                                        const card = document.createElement('div');
                                        card.classList.add('kanban-item', 'card', 'mb-2', 'p-2');

                                        // Guardar tanto el id como el uid
                                        card.setAttribute('data-id', item.id); // id en la BD (sprint backlog)
                                        card.setAttribute('data-uid', item.uid); // uid generado (si lo usas en frontend)

                                        card.innerHTML = `
                <div class="kanban-item-header d-flex justify-content-between align-items-center">
                    <strong class="kanban-title">${item.titulo}</strong>
                </div>
                <div class="kanban-item-footer d-flex justify-content-between mt-2">
                    <span class="badge bg-info">Pts: ${item.valor_historia}</span>
                </div>
            `;


                                        container.appendChild(card);
                                        enableDragAndDrop();

                                        // Actualizar contador
                                        const counter = document.getElementById(`counter-${estado}`);
                                        counter.textContent = parseInt(counter.textContent) + 1;
                                    }


                                    function enableDragAndDrop() {
                                        const items = document.querySelectorAll('.kanban-item');
                                        const columns = document.querySelectorAll('.kanban-items');

                                        items.forEach(item => {
                                            if (!item.hasAttribute("draggable")) {
                                                item.setAttribute('draggable', true);

                                                item.addEventListener('dragstart', (e) => {
                                                    e.dataTransfer.setData('text/plain', item.getAttribute(
                                                        'data-uid')); // 👈 ahora pasamos el UID del item
                                                    e.dataTransfer.effectAllowed = "move";
                                                    item.classList.add('dragging');
                                                });

                                                item.addEventListener('dragend', () => {
                                                    item.classList.remove('dragging');
                                                });
                                            }
                                        });

                                        columns.forEach(column => {
                                            column.addEventListener('dragover', (e) => {
                                                e.preventDefault();
                                                column.classList.add('drag-over');
                                            });

                                            column.addEventListener('dragleave', () => {
                                                column.classList.remove('drag-over');
                                            });

                                            column.addEventListener('drop', (e) => {
                                                e.preventDefault();
                                                column.classList.remove('drag-over');

                                                const itemUID = e.dataTransfer.getData('text/plain');
                                                const item = document.querySelector(
                                                    `.kanban-item[data-uid="${itemUID}"]`);
                                                if (!item) return;

                                                column.appendChild(item);

                                                // Detectar nuevo progreso
                                                const statusKey = column.parentElement.getAttribute(
                                                    'data-status');
                                                let newProgreso = "";
                                                if (statusKey === "por-hacer") newProgreso = "Por hacer";
                                                if (statusKey === "en-progreso") newProgreso =
                                                    "En progreso";
                                                if (statusKey === "terminado") newProgreso = "Terminado";

                                                console.log(`Tarea ${itemUID} movida a: ${newProgreso}`);

                                                // Sacar proyectoUID y sprintUID desde el dataset del tablero
                                                const tablero = document.getElementById("tablero");
                                                const proyectoUID = tablero.getAttribute("data-proyecto");
                                                const sprintUID = tablero.getAttribute("data-sprint");

                                                // ✅ Llamada al backend con UIDs
                                                axios.post(
                                                    `/proyectos/${proyectoUID}/sprints/${sprintUID}/items/${itemUID}/progreso`, {
                                                        progreso: newProgreso
                                                    }).then(res => {
                                                    cargarTablero(proyectoUID, sprintUID);
                                                }).catch(err => {
                                                    console.error("Error al actualizar progreso ❌",
                                                        err);
                                                });
                                            });
                                        });
                                    }

                                    // Activar drag & drop después de renderizar las tarjetas
                                    enableDragAndDrop();



                                    // Editar sprint (abrir modal)
                                    $(document).on('click', '.editar-sprint', function(e) {
                                        e.preventDefault();
                                        const sprintUid = $(this).data('sprint-uid');
                                        editarSprint(sprintUid); // tu función ya lo maneja
                                    });

                                    // Eliminar sprint (abrir SweetAlert)
                                    $(document).on('click', '.eliminar-sprint', function(e) {
                                        e.preventDefault();
                                        const sprintUid = $(this).data('sprint-uid');
                                        eliminarSprint(sprintUid); // tu función ya lo maneja
                                    });

                                    // Guardar cambios desde el modal
                                    $('#formEditarSprint').on('submit', function(e) {
                                        e.preventDefault();
                                        actualizarSprint();
                                    });

                                    // Cuando el DOM está listo
                                    $(document).on('click', '#btnActualizarSprint', function(e) {
                                        e.preventDefault();
                                        actualizarSprint();
                                    });


                                    $(document).ready(function() {
                                        const uid = $("#id_proyecto").val();
                                        let selectedUsers = [];
                                        let allUsers = [];

                                        // Función para renderizar la lista de usuarios
                                        function renderUsersList(users) {
                                            const usersList = $("#usersList");
                                            usersList.empty();

                                            users.forEach(function(usuario) {
                                                const isSelected = selectedUsers.includes(usuario.id);
                                                const initials = getInitials(usuario.nombre_completo);

                                                const userOption = $(`
                        <div class="user-option" data-user-id="${usuario.id}">
                            <input type="checkbox" ${isSelected ? 'checked' : ''}>
                            <div class="user-avatar">${initials}</div>
                            <span>${usuario.nombre_completo}</span>
                        </div>
                    `);

                                                usersList.append(userOption);
                                            });
                                        }

                                        // Función para obtener iniciales
                                        function getInitials(name) {
                                            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0,
                                                2);
                                        }

                                        // Función para filtrar usuarios
                                        function filterUsers(searchTerm) {
                                            const filtered = allUsers.filter(user =>
                                                user.nombre_completo.toLowerCase().includes(searchTerm
                                                    .toLowerCase())
                                            );
                                            renderUsersList(filtered);
                                        }

                                        // Manejo del campo de búsqueda
                                        $("#searchBox").on("input", function() {
                                            const searchTerm = $(this).val();
                                            filterUsers(searchTerm);
                                        });

                                        // Manejo de selección de usuarios
                                        $(document).on("click", ".user-option", function(e) {
                                            if (e.target.type !== 'checkbox') {
                                                const checkbox = $(this).find('input[type="checkbox"]');
                                                checkbox.prop('checked', !checkbox.prop('checked'));
                                            }

                                            const userId = parseInt($(this).data('user-id'));
                                            const checkbox = $(this).find('input[type="checkbox"]');

                                            if (checkbox.prop('checked')) {
                                                if (!selectedUsers.includes(userId)) {
                                                    selectedUsers.push(userId);
                                                }
                                            } else {
                                                selectedUsers = selectedUsers.filter(id => id !== userId);
                                            }

                                            updateHiddenField();
                                        });

                                        // Actualizar campo oculto con formato de array para el backend
                                        function updateHiddenField() {
                                            // Crear inputs hidden separados para cada usuario seleccionado
                                            $('input[name="asignado_a[]"]').remove();

                                            selectedUsers.forEach(function(userId) {
                                                $('<input>').attr({
                                                    type: 'hidden',
                                                    name: 'asignado_a[]',
                                                    value: userId
                                                }).appendTo('form');
                                            });
                                        }

                                        // Función para cargar usuarios del proyecto
                                        function loadUserData(sprintId = null) {
                                            axios.get(`/proyectos/backlog/${uid}/sprints/items`)
                                                .then(function(response) {
                                                    const data = response.data;

                                                    // Limpiar backlog
                                                    $("#id_item_backlog").empty().append(
                                                        '<option value="">Seleccionar elemento</option>');
                                                    data.backlog.forEach(function(item) {
                                                        $("#id_item_backlog").append(
                                                            `<option value="${item.id}">${item.titulo}</option>`
                                                        );
                                                    });

                                                    // Limpiar y cargar sprints
                                                    $("#id_sprint").empty().append(
                                                        '<option value="">Seleccionar Sprint</option>');
                                                    data.sprints.forEach(sprint => {
                                                        $("#id_sprint").append(
                                                            `<option value="${sprint.id}">${sprint.nombre}</option>`
                                                        );
                                                    });

                                                    if (sprintId) {
                                                        $("#id_sprint").val(sprintId);
                                                    }

                                                    // Cargar usuarios
                                                    allUsers = data.equipo;
                                                    selectedUsers = [];
                                                    renderUsersList(allUsers);
                                                    $("#searchBox").val('');
                                                })
                                                .catch(function(error) {
                                                    console.error(error);
                                                    notyf.error("Error al cargar los datos");
                                                });
                                        }

                                        // Cargar datos al abrir modal
                                        $(document).on("show.bs.modal", "#modalRegSprBacklog", function(event) {
                                            const button = $(event.relatedTarget);
                                            const sprintId = button.data("sprint-id");
                                            $("#current_id_sprints").val(sprintId);
                                            loadUserData(sprintId);
                                        });


                                        // Reset del formulario cuando se cierra el modal
                                        $("#modalRegSprBacklog").on("hidden.bs.modal", function() {
                                            selectedUsers = [];
                                            allUsers = [];
                                            $("#usersList").empty();
                                            $("#searchBox").val('');
                                            $('input[name="asignado_a[]"]').remove();
                                        });

                                        $("#btnGuardarSprintBacklog").on("click", function() {
                                            const uid = $("#uid_proyecto").val();
                                            const sprintId = $("#current_id_sprints").val(); // viene del botón
                                            console.log(sprintId)
                                            const formData = {
                                                id_sprint: sprintId,
                                                id_item_backlog: $("#id_item_backlog").val(),
                                                titulo: $("#tituloSpr").val(),
                                                progreso: $("#progresoSpr").val(),
                                                asignado_a: selectedUsers
                                            };

                                            axios.post(
                                                    `/proyectos/backlog/${uid}/sprints/${sprintId}/sprbacklog/store`,
                                                    formData)
                                                .then(function(response) {
                                                    notyf.success(response.data.message);
                                                    $("#modalRegSprBacklog").modal("hide");

                                                    $("#tituloSpr").val('');
                                                    $("#progresoSpr").val('');
                                                    $("#id_item_backlog").val('');
                                                    selectedUsers = [];
                                                    allUsers = [];
                                                    $("#usersList").empty();
                                                    $("#searchBox").val('');
                                                    $('input[name="asignado_a[]"]').remove();

                                                    // loadSprintBacklog(uid);
                                                    window.cargarHistorias();
                                                })
                                                .catch(function(error) {
                                                    console.error(error);
                                                    notyf.error(error.response?.data?.error ||
                                                        "Error al guardar en Sprint Backlog");
                                                });
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
                                            const sprintWrapper = $(
                                                `.sprint-backlog-wrapper[data-sprint-id="${sprintId}"]`);
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
                                                                const prioridadClass = item.prioridad
                                                                    ?.toLowerCase() === 'alta' ?
                                                                    'prioridad-alta' :
                                                                    item.prioridad?.toLowerCase() ===
                                                                    'media' ? 'prioridad-media' :
                                                                    'prioridad-baja';

                                                                const badgeClass = item.prioridad ===
                                                                    'Alta' ? 'bg-danger' :
                                                                    item.prioridad === 'Media' ?
                                                                    'bg-warning' : 'bg-success';


                                                                itemsHtml += `
                                        <div class="col-12 mb-2 sprint-item" data-item-id="${item.sprint_uid}">
                                            <div class="card shadow-sm border rounded-2 sprint-item ${prioridadClass}" style="font-size: 0.85rem;">
                                                <div class="card-body p-3">

                                                    <!-- Título + Prioridad -->
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <p class="card-title mb-0 fw-semibold text-truncate" style="max-width: 70%;">
                                                            ${item.titulo || 'Sin título'}
                                                        </p>
                                                        <span class="badge ${badgeClass}">${item.prioridad || 'Sin prioridad'}</span>
                                                    </div>

                                                    <!-- Descripción -->
                                                    ${item.descripcion ? `<p class="card-text text-muted small mb-2">${item.descripcion}</p>` : ''}

                                                    <!-- Estado + Tipo -->
                                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                                        <span> Estado: ${item.estado || 'Sin estado'}</span>
                                                        <span> Valor: ${item.valor_historia}</span>
                                                    </div>

                                                    <!-- Responsable -->
                                                    ${item.responsables ? `
                                                                                                                            <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                                                                                                                                <span>
                                                                                                                                    <i class="bi bi-person-circle me-1"></i> ${item.responsables}
                                                                                                                                </span>

                                                                                                                            </div>
                                                                                                                        ` : ''}
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

                                                axios.delete(
                                                        `/proyectos/backlog/${uid}/sprints/items/${itemId}`)
                                                    .then(function(response) {
                                                        if (response.data.success) {
                                                            notyf.success(
                                                                "Elemento eliminado correctamente");
                                                            // Recargar el sprint backlog
                                                            const sprintId = $(
                                                                    `.sprint-item[data-item-id="${itemId}"]`
                                                                )
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
                                                    axios.delete(
                                                            `/proyectos/backlog/${uidProyecto}/sprints/items/${uidHistoria}/devolver`
                                                        )
                                                        .then(function(response) {
                                                            if (response.data.success) {
                                                                Swal.fire(
                                                                    'Devuelta!',
                                                                    response.data.message,
                                                                    'success'
                                                                );

                                                                cargarHistorias();

                                                                // Recargar sprint backlog solo del sprint afectado
                                                                const sprintId = $(
                                                                        `.sprint-item[data-item-id="${uidHistoria}"]`
                                                                    )
                                                                    .closest(
                                                                        '.sprint-backlog-wrapper')
                                                                    .data('sprint-id');

                                                                if (sprintId) {
                                                                    loadSprintBacklog(sprintId);
                                                                }
                                                            } else {
                                                                Swal.fire(
                                                                    'Error',
                                                                    response.data.message ||
                                                                    "No se pudo devolver la historia",
                                                                    'error'
                                                                );
                                                            }
                                                        })
                                                        .catch(function(error) {
                                                            console.error('Error al devolver:',
                                                                error);
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
                                        var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                                            '[data-bs-toggle="tooltip"]'))
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
                                    //-----------------------------------------------------------------------------------------------------------------------

                                    $(document).ready(function() {
                                        // Variables globales
                                        let reuniones = [];
                                        let proyectos = [];
                                        let sprints = [];
                                        const proyectoUID = "{{ $proyecto->uid }}";
                                        const proyectoID = "{{ $proyecto->id }}";

                                        // Inicializar Notyf para notificaciones
                                        const notyf = new Notyf({
                                            duration: 4000,
                                            position: {
                                                x: 'right',
                                                y: 'top',
                                            }
                                        });

                                        // Cargar datos iniciales
                                        cargarReuniones();
                                        cargarProyectos();
                                        cargarSprints();

                                        // Event Listeners
                                        $('#saveDailyScrum').on('click', crearReunion);
                                        $('#updateDailyScrum').on('click', actualizarReunion);
                                        $('#createModal').on('show.bs.modal', prepararModalCrear);
                                        $('#editModal').on('show.bs.modal', prepararModalEditar);

                                        // Función para cargar reuniones
                                        function cargarReuniones() {
                                            // MOSTRAR LOADING
                                            $('#loadingRow').show();

                                            // CORRECCIÓN: Usar la ruta correcta según tu controlador
                                            axios.get(`/reuniones`)
                                                .then(function(response) {
                                                    if (response.data.success) {
                                                        // Filtrar reuniones por el proyecto actual
                                                        reuniones = response.data.data.filter(reunion =>
                                                            reunion.id_proyectos == proyectoID
                                                        );
                                                        mostrarReuniones();
                                                    } else {
                                                        notyf.error(response.data.message ||
                                                            'Error al cargar las reuniones');
                                                    }
                                                })
                                                .catch(function(error) {
                                                    console.error('Error al cargar reuniones:', error);
                                                    notyf.error('Error al cargar las reuniones');
                                                })
                                                .finally(function() {
                                                    $('#loadingRow').hide();
                                                });
                                        }

                                        // Función para mostrar reuniones en la tabla
                                        function mostrarReuniones() {
                                            const tbody = $('#dailyScrumTableBody');
                                            tbody.empty();

                                            if (reuniones.length === 0) {
                                                tbody.append(`
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-calendar-times fs-1 text-muted d-block mb-2"></i>
                        <p class="text-muted">No hay reuniones registradas</p>
                        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus me-1"></i> Crear primera reunión
                        </button>
                    </td>
                </tr>
            `);
                                                return;
                                            }

                                            reuniones.forEach(reunion => {
                                                const fecha = new Date(reunion.fecha).toLocaleDateString();
                                                const row = `
                <tr data-uid="${reunion.uid}">
                    <td>${fecha}</td>
                    <td>${reunion.duracion} min</td>
                    <td>${reunion.proyecto_nombre || 'N/A'}</td>
                    <td>${reunion.sprint_nombre || 'N/A'}</td>
                    <td>
                        <button class="btn btn-sm btn-info view-reunion" data-uid="${reunion.uid}" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-primary edit-reunion" data-uid="${reunion.uid}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-reunion" data-uid="${reunion.uid}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
                                                tbody.append(row);
                                            });

                                            // Agregar event listeners a los botones
                                            $('.view-reunion').on('click', function() {
                                                const uid = $(this).data('uid');
                                                verReunion(uid);
                                            });

                                            $('.edit-reunion').on('click', function() {
                                                const uid = $(this).data('uid');
                                                abrirModalEditar(uid);
                                            });

                                            $('.delete-reunion').on('click', function() {
                                                const uid = $(this).data('uid');
                                                eliminarReunion(uid);
                                            });
                                        }

                                        // Función para cargar proyectos
                                        function cargarProyectos() {
                                            // Esta función obtiene los proyectos
                                            proyectos = [{
                                                id: proyectoID,
                                                nombre: "{{ $proyecto->nombre }}"
                                            }];

                                            // Llenar select de proyectos en modales
                                            $('#id_proyectos, #edit_id_proyectos').empty();
                                            proyectos.forEach(proyecto => {
                                                $('#id_proyectos').append(
                                                    `<option value="${proyecto.id}">${proyecto.nombre}</option>`
                                                );
                                                $('#edit_id_proyectos').append(
                                                    `<option value="${proyecto.id}">${proyecto.nombre}</option>`
                                                );
                                            });
                                        }

                                        // Función para cargar sprints - CORREGIDA
                                        function cargarSprints() {
                                            // Obtener sprints del proyecto actual
                                            axios.get(`/proyectos/backlog/${proyectoUID}/sprints/show`)
                                                .then(function(response) {
                                                    // CORRECCIÓN: Verificar la estructura de la respuesta
                                                    sprints = Array.isArray(response.data) ? response.data : [];

                                                    console.log('Sprints cargados:', sprints); // Para debugging

                                                    // Llenar select de sprints en modales
                                                    $('#id_sprints, #edit_id_sprints').empty();
                                                    $('#id_sprints, #edit_id_sprints').append(
                                                        '<option value="">Seleccionar sprint...</option>');

                                                    if (sprints.length > 0) {
                                                        sprints.forEach(sprint => {
                                                            $('#id_sprints').append(
                                                                `<option value="${sprint.id}">${sprint.nombre}</option>`
                                                            );
                                                            $('#edit_id_sprints').append(
                                                                `<option value="${sprint.id}">${sprint.nombre}</option>`
                                                            );
                                                        });
                                                    } else {
                                                        $('#id_sprints, #edit_id_sprints').append(
                                                            '<option value="">No hay sprints disponibles</option>'
                                                        );
                                                    }
                                                })
                                                .catch(function(error) {
                                                    console.error('Error al cargar sprints:', error);
                                                    notyf.error('Error al cargar los sprints');

                                                    // Opción alternativa si falla la petición
                                                    $('#id_sprints, #edit_id_sprints').empty();
                                                    $('#id_sprints, #edit_id_sprints').append(
                                                        '<option value="">Error al cargar sprints</option>');
                                                });
                                        }

                                        // Función para preparar el modal de creación
                                        function prepararModalCrear() {
                                            $('#createForm')[0].reset();

                                            // Establecer fecha actual por defecto
                                            const today = new Date().toISOString().split('T')[0];
                                            $('#fecha').val(today);

                                            // Seleccionar el proyecto actual por defecto
                                            $('#id_proyectos').val(proyectoID);

                                            // Forzar recarga de sprints por si hay nuevos
                                            cargarSprints();
                                        }

                                        // Función para crear una reunión - CORREGIDA
                                        function crearReunion() {
                                            const btn = $('#saveDailyScrum');
                                            const loading = btn.find('.btn-loading');
                                            const text = btn.find('.btn-text');

                                            // Validar formulario
                                            if (!$('#createForm')[0].checkValidity()) {
                                                $('#createForm')[0].reportValidity();
                                                return;
                                            }

                                            // Validar que se haya seleccionado un sprint
                                            if (!$('#id_sprints').val()) {
                                                notyf.error('Por favor selecciona un sprint');
                                                return;
                                            }

                                            // Mostrar loading
                                            loading.show();
                                            text.hide();
                                            btn.prop('disabled', true);

                                            // Obtener datos del formulario
                                            const formData = {
                                                fecha: $('#fecha').val(),
                                                duracion: $('#duracion').val(),
                                                URL: $('#URL').val(),
                                                id_proyectos: $('#id_proyectos').val(),
                                                id_sprints: $('#id_sprints').val(),
                                                observaciones: $('#observaciones').val(),
                                                bloqueos_detectados: $('#bloqueos_detectados').val(),
                                                acuerdos: $('#acuerdos').val()
                                            };

                                            console.log('Enviando datos:', formData); // Para debugging

                                            // CORRECCIÓN: Usar la ruta correcta según tu controlador
                                            axios.post(`/proyectos/backlog/${proyectoUID}/reuniones/store`, formData)
                                                .then(function(response) {
                                                    console.log('Respuesta:', response.data); // Para debugging

                                                    if (response.data.success) {
                                                        notyf.success(response.data.message);
                                                        $('#createModal').modal('hide');
                                                        cargarReuniones();
                                                    } else {
                                                        notyf.error(response.data.message ||
                                                            'Error al crear la reunión');
                                                    }
                                                })
                                                .catch(function(error) {
                                                    console.error('Error al crear reunión:', error);

                                                    if (error.response && error.response.data && error.response.data
                                                        .errors) {
                                                        // Mostrar errores de validación
                                                        const errors = error.response.data.errors;
                                                        Object.keys(errors).forEach(key => {
                                                            notyf.error(errors[key][0]);
                                                        });
                                                    } else if (error.response && error.response.data && error
                                                        .response.data.message) {
                                                        notyf.error(error.response.data.message);
                                                    } else {
                                                        notyf.error('Error al crear la reunión');
                                                    }
                                                })
                                                .finally(function() {
                                                    // Ocultar loading
                                                    loading.hide();
                                                    text.show();
                                                    btn.prop('disabled', false);
                                                });
                                        }

                                        // Función para abrir modal de edición
                                        function abrirModalEditar(uid) {
                                            // Buscar la reunión
                                            const reunion = reuniones.find(r => r.uid === uid);

                                            if (!reunion) {
                                                notyf.error('No se encontró la reunión');
                                                return;
                                            }

                                            // Llenar el formulario
                                            $('#edit_uid').val(reunion.uid);
                                            $('#edit_fecha').val(reunion.fecha);
                                            $('#edit_duracion').val(reunion.duracion);
                                            $('#edit_URL').val(reunion.URL || '');
                                            $('#edit_id_proyectos').val(reunion.id_proyectos);
                                            $('#edit_id_sprints').val(reunion.id_sprints);
                                            $('#edit_observaciones').val(reunion.observaciones || '');
                                            $('#edit_bloqueos_detectados').val(reunion.bloqueos_detectados || '');
                                            $('#edit_acuerdos').val(reunion.acuerdos || '');

                                            // Abrir modal
                                            $('#editModal').modal('show');
                                        }

                                        // Función para preparar modal de edición
                                        function prepararModalEditar() {
                                            // Esta función se ejecuta cuando el modal se abre
                                            // Podemos usarla para realizar acciones adicionales si es necesario
                                        }

                                        // Función para actualizar una reunión - CORREGIDA
                                        function actualizarReunion() {
                                            const btn = $('#updateDailyScrum');
                                            const loading = btn.find('.btn-loading');
                                            const text = btn.find('.btn-text');

                                            // Validar formulario
                                            if (!$('#editForm')[0].checkValidity()) {
                                                $('#editForm')[0].reportValidity();
                                                return;
                                            }

                                            // Validar que se haya seleccionado un sprint
                                            if (!$('#edit_id_sprints').val()) {
                                                notyf.error('Por favor selecciona un sprint');
                                                return;
                                            }

                                            // Mostrar loading
                                            loading.show();
                                            text.hide();
                                            btn.prop('disabled', true);

                                            // Obtener datos del formulario
                                            const uid = $('#edit_uid').val();
                                            const formData = {
                                                fecha: $('#edit_fecha').val(),
                                                duracion: $('#edit_duracion').val(),
                                                URL: $('#edit_URL').val(),
                                                id_proyectos: $('#edit_id_proyectos').val(),
                                                id_sprints: $('#edit_id_sprints').val(),
                                                observaciones: $('#edit_observaciones').val(),
                                                bloqueos_detectados: $('#edit_bloqueos_detectados').val(),
                                                acuerdos: $('#edit_acuerdos').val()
                                            };

                                            console.log('Enviando datos para actualizar:', formData); // Para debugging

                                            // CORRECCIÓN: Usar la ruta correcta según tu controlador
                                            axios.put(`/proyectos/backlog/${uid}/reuniones/update`, {
                                                    ...formData,
                                                    uid: uid
                                                })
                                                .then(function(response) {
                                                    console.log('Respuesta actualización:', response
                                                        .data); // Para debugging

                                                    if (response.data.success) {
                                                        notyf.success(response.data.message);
                                                        $('#editModal').modal('hide');
                                                        cargarReuniones();
                                                    } else {
                                                        notyf.error(response.data.message ||
                                                            'Error al actualizar la reunión');
                                                    }
                                                })
                                                .catch(function(error) {
                                                    console.error('Error al actualizar reunión:', error);

                                                    if (error.response && error.response.data && error.response.data
                                                        .errors) {
                                                        // Mostrar errores de validación
                                                        const errors = error.response.data.errors;
                                                        Object.keys(errors).forEach(key => {
                                                            notyf.error(errors[key][0]);
                                                        });
                                                    } else if (error.response && error.response.data && error
                                                        .response.data.message) {
                                                        notyf.error(error.response.data.message);
                                                    } else {
                                                        notyf.error('Error al actualizar la reunión');
                                                    }
                                                })
                                                .finally(function() {
                                                    // Ocultar loading
                                                    loading.hide();
                                                    text.show();
                                                    btn.prop('disabled', false);
                                                });
                                        }

                                        // Función para ver detalles de una reunión
                                        function verReunion(uid) {
                                            // Buscar la reunión
                                            const reunion = reuniones.find(r => r.uid === uid);

                                            if (!reunion) {
                                                notyf.error('No se encontró la reunión');
                                                return;
                                            }

                                            // Formatear fecha
                                            const fecha = new Date(reunion.fecha).toLocaleDateString();

                                            // Llenar el modal de detalles
                                            $('#detail_fecha').text(fecha);
                                            $('#detail_duracion').text(reunion.duracion);
                                            $('#detail_proyecto').text(reunion.proyecto_nombre || 'N/A');
                                            $('#detail_sprint').text(reunion.sprint_nombre || 'N/A');

                                            // URL
                                            if (reunion.URL) {
                                                $('#detail_URL').attr('href', reunion.URL).text(reunion.URL);
                                            } else {
                                                $('#detail_URL').attr('href', '#').text('No especificada');
                                            }

                                            // Campos de texto
                                            $('#detail_observaciones').text(reunion.observaciones ||
                                                'No hay observaciones');
                                            $('#detail_bloqueos').text(reunion.bloqueos_detectados ||
                                                'No se detectaron bloqueos');
                                            $('#detail_acuerdos').text(reunion.acuerdos ||
                                                'No se registraron acuerdos');

                                            // Abrir modal
                                            $('#detailsModal').modal('show');
                                        }

                                        // Función para eliminar una reunión - CORREGIDA
                                        function eliminarReunion(uid) {
                                            const isDark = $("body").hasClass("dark");

                                            // Confirmación con SweetAlert
                                            Swal.fire({
                                                title: '¿Estás seguro?',
                                                text: "Esta acción no se puede deshacer",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: isDark ? '#444' : '#aaa',
                                                confirmButtonText: 'Sí, eliminar',
                                                cancelButtonText: 'Cancelar',
                                                reverseButtons: true,
                                                background: isDark ? '#1e1e2d' : '#fff',
                                                color: isDark ? '#f1f1f1' : '#000'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Enviar solicitud de eliminación
                                                    // CORRECCIÓN: Usar la ruta correcta según tu controlador
                                                    axios.post(`/proyectos/backlog/${uid}/reuniones/destroy`, {
                                                            uid: uid
                                                        })
                                                        .then(function(response) {
                                                            if (response.data.success) {
                                                                notyf.success(response.data.message);
                                                                cargarReuniones();
                                                            } else {
                                                                notyf.error(response.data.message ||
                                                                    'Error al eliminar la reunión');
                                                            }
                                                        })
                                                        .catch(function(error) {
                                                            console.error('Error al eliminar reunión:',
                                                                error);
                                                            notyf.error('Error al eliminar la reunión');
                                                        });
                                                }
                                            });
                                        }
                                    });
    </script>
@endsection
