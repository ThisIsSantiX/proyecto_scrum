@extends('layouts.layout.layout')

@section('content')

<div class="conatiner-fluid content-inner mt-5 pt-4 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title">Todos los proyectos</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="position-relative">
                            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Buscar proyectos..." style="width: 250px;">
                            <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                        </div>
                        <a href="javascript:void(0);"
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalCrearProyecto">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                            Crear Proyecto
                        </a>

                    </div>
                </div>

                <div class="card-body">
                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando proyectos...</p>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5" style="display: none;">
                        <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16" class="text-muted mb-3">
                            <path d="m9.828 3 3 3v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.828ZM9 3H4a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V6L9 3ZM3 7.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Z" />
                        </svg>
                        <h5 class="text-muted">No se encontraron proyectos</h5>
                        <p class="text-muted">No hay proyectos que coincidan con tu búsqueda.</p>
                    </div>

                    <!-- Projects Cards Container -->
                    <div id="projectsContainer" class="row g-4" style="display: none;">
                        <!-- Las cartas se cargarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Proyecto -->
<div class="modal fade" id="modalCrearProyecto" tabindex="-1" aria-labelledby="modalCrearProyectoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- Header -->
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="modalCrearProyectoLabel">Crear Proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="formCrearProyecto">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="50">
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" maxlength="255"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="visibilidad" class="form-label">Visibilidad</label>
                        <select class="form-select" id="visibilidad" name="visibilidad" required>
                            <option value="1">Público</option>
                            <option value="0">Privado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="progreso" class="form-label">Progreso</label>
                        <select class="form-select" id="progreso" name="progreso" required>
                            <option value="planificacion">Planificación</option>
                            <option value="desarrollo">Desarrollo</option>
                            <option value="testing">Testing</option>
                            <option value="revision">Revisión</option>
                            <option value="completado">Completado</option>
                            <option value="pausado">Pausado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formCrearProyecto" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalles del Proyecto -->
<div class="modal fade" id="modalDetallesProyecto" tabindex="-1" aria-labelledby="modalDetallesProyectoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Bootstrap modal header with blue background -->
            <div class="modal-header bg-body text-white">
                <h5 class="modal-title" id="modalDetallesProyectoLabel">Detalles del Proyecto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Project header section with Bootstrap cards -->
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Main content area -->
                    <div class="col-md-8">
                        <!-- Bootstrap nav tabs -->
                        <ul class="nav nav-tabs px-4 pt-3" id="projectTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="detalles-tab" data-bs-toggle="tab" data-bs-target="#detalles" type="button" role="tab">
                                    Detalles
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button" role="tab">
                                    Usuarios del proyecto
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content p-4" id="projectTabsContent">
                            <!-- Converted detalles tab to use inputs for editing -->
                            <div class="tab-pane fade show active" id="detalles" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Nombre del proyecto</label>
                                        <input type="text" class="form-control" id="detalleNombre" value="Diseño estándar">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Progreso del proyecto</label>
                                        <!-- Updated progreso select with provided options -->
                                        <select class="form-select" id="detalleProgreso" name="progreso" required>
                                            <option value="planificacion">Planificación</option>
                                            <option value="desarrollo">Desarrollo</option>
                                            <option value="testing">Testing</option>
                                            <option value="revision">Revisión</option>
                                            <option value="completado">Completado</option>
                                            <option value="pausado">Pausado</option>
                                            <option value="cancelado">Cancelado</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Visibilidad</label>
                                        <!-- Updated visibilidad select with provided options -->
                                        <select class="form-select" id="detalleVisibilidad" name="visibilidad" required>
                                            <option value="1">Público</option>
                                            <option value="0">Privado</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Fecha de inicio</label>
                                        <input type="date" class="form-control" id="detalleFechaInicio" value="2025-08-15">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Fecha de fin</label>
                                        <input type="date" class="form-control" id="detalleFechaFin" value="2025-12-30">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label text-muted">Descripción</label>
                                        <textarea class="form-control" rows="3" id="detalleDescripcionInput">Este es un proyecto de diseño estándar que incluye la creación de interfaces modernas y funcionales.</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="descripcion" role="tabpanel">
                                <div class="card border-start border-primary border-4">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Descripción del proyecto</h6>
                                        <p class="card-text" id="detalleDescripcion">
                                            Este es un proyecto de diseño estándar que incluye la creación de interfaces modernas y funcionales para mejorar la experiencia del usuario.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="usuarios" role="tabpanel">
                                <div id="usuariosProyecto">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 48px; height: 48px;">
                                                    <span id="userInitial">S</span>
                                                </div>
                                                <div>
                                                    <!-- Updated to use dynamic user data from backend -->
                                                    <h6 class="fw-bold mb-1" id="userName">Santiago Torres</h6>
                                                    <p class="text-muted small mb-2" id="userEmail">santiago@example.com</p>
                                                    <span class="badge bg-primary">Propietario</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="projectUsersContainer" class="list-group">
                                        <!-- Aquí se insertarán los usuarios -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project info sidebar moved to right side -->
                    <div class="col-md-4 border-start">
                        <div class="p-4">
                            <h2 class="h4 fw-bold text-body mb-2" id="projectTitleDisplay">Prueba Scrum</h2>
                            <div class="text-muted small mb-4">
                                <span>Creado por <strong id="ownerNameDisplay">Santiago Torres</strong></span>
                                <br>
                                <span id="createdDateDisplay">07/Aug/2025 12:39 PM</span>
                            </div>

                            <!-- Stats cards -->
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="card text-center">
                                        <div class="card-body py-2">
                                            <div class="h5 text-primary mb-1" id="sprintsValue">0</div>
                                            <div class="text-muted small">Sprints</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card text-center">
                                        <div class="card-body py-2">
                                            <div class="h5 text-primary mb-1" id="elementsValue">2</div>
                                            <div class="text-muted small">Elementos</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Progreso</span>
                                                <span class="fw-bold text-primary" id="progressValue">Desarrollo</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Visibilidad</span>
                                                <span class="badge bg-success" id="visibilityValue">Público</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional info -->
                            <div class="mt-4">
                                <div class="small text-muted mb-2">
                                    <strong>Creado:</strong> <span id="detalleCreado">07/08/2025 12:39</span>
                                </div>
                                <div class="small text-muted mb-2">
                                    <strong>Actualizado:</strong> <span id="detalleActualizado">25/08/2025 09:15</span>
                                </div>
                                <!-- Added delete button with trash icon -->
                                <div class="mt-3">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="deleteProjectBtn">
                                        <svg class="me-1" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.708 6.23975H3.75"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Eliminar Proyecto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap modal footer -->
            <div class="modal-footer bg-body">
                <button type="button" class="btn btn-primary" id="updateProjectBtn">Actualizar Proyecto</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Añadir Usuario a Proyecto -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- Header -->
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="modalAddUserLabel">Añadir Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="formAddUser">
                    @csrf
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Correo del Usuario</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnSaveUser" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .project-card {
        transition: all 0.3s ease;
        border: 1px solid var(--bs-primary);
        border-radius: 12px;
        height: 100%;
    }

    .project-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.10);
        border-color: var(--bs-primary);
    }

    .project-header {
        background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px 12px 0 0;
        position: relative;
        overflow: hidden;
    }

    .project-header::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), transparent);
        border-radius: 12px 12px 0 0;
        pointer-events: none;
    }

    .project-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .project-title:hover {
        text-decoration: underline;
        opacity: 0.8;
    }

    .project-description {
        opacity: 0.9;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .owner-info {
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    .owner-avatar {
        width: 35px;
        height: 35px;
        background: var(--bs-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .project-meta {
        font-size: 0.85rem;
        color: var(--bs-secondary);
    }

    .badge-status {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 500;
    }

    .search-highlight {
        background-color: rgba(var(--bs-warning-rgb), 0.3);
        padding: 0.1rem 0.2rem;
        border-radius: 3px;
    }

    /* Status badges colors */
    .status-planificacion {
        background-color: #8054d1ff;
        color: white;
    }

    .status-desarrollo {
        background-color: #0d6efd;
        color: white;
    }

    .status-testing {
        background-color: #fd7e14;
        color: white;
    }

    .status-revision {
        background-color: #dc3545;
        color: white;
    }

    .status-completado {
        background-color: #198754;
        color: white;
    }

    .status-pausado {
        background-color: #6c757d;
        color: white;
    }

    .status-cancelado {
        background-color: #495057;
        color: white;
    }
    

    .avatar-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0d6efd;
        margin-right: -10px;
    }

    /* Fallback con iniciales cuando no hay foto */
    .avatar-fallback {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: #fff;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: -10px;
        border: 2px solid #fff;
    }

    /* Que los avatares se acomoden en fila */
    #membersContainer_[id] {
        display: flex;
        align-items: center;
    }

</style>
@endsection

@section('js')
<script>
        //cargarlos como una tarje en el detalle
        function loadProjectUsers(uid) {
            axios.get(`/miembros-equipo/${uid}`)
                .then(function(response) {
                    if (response.data.miembros && response.data.miembros.length > 0) {
                        let html = '';

                        response.data.miembros.forEach(miembro => {
                            html += `
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            ${miembro.foto_url ? `
                                        <img src="${miembro.foto_url ? miembro.foto_url + '?v=' + new Date().getTime() : ''}" 
                                                class="rounded-circle me-3"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">

                                        ` : `
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                ${getInitials(miembro.username)}
                                            </div>
                                        `}
                                        <div>
                                            <h6 class="fw-bold mb-1">${miembro.username}</h6>
                                            <p class="text-muted small mb-2">${miembro.email}</p>
                                                ${miembro.rol === 'propietario' ? `
                                                <span class="badge bg-primary">Propietario</span>
                                        ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        });

                        $("#projectUsersContainer").html(html);
                    } else {
                        $("#projectUsersContainer").html('<p class="text-muted">No hay usuarios en este proyecto.</p>');
                    }
                })
                .catch(function(error) {
                    console.error("Error cargando miembros del proyecto:", error);
                    $("#projectUsersContainer").html('<p class="text-danger">Error al cargar usuarios.</p>');
                });
        }


        $(document).ready(function() {
            let searchTimeout;
            let allProjects = [];

            // Cargar proyectos al inicializar
            loadProjects();

            // Búsqueda en tiempo real
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = $(this).val().trim();

                searchTimeout = setTimeout(function() {
                    if (searchTerm.length >= 2 || searchTerm.length === 0) {
                        loadProjects(searchTerm);
                    }
                }, 500);
            });

            function loadProjects(search = '') {
                showLoading();

                const params = search ? {
                    search: search
                } : {};

                axios.get('{{ route("showProyectos") }}', {
                        params: params
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            allProjects = response.data.data;
                            renderProjects(allProjects, search);
                        } else {
                            showError('Error al cargar los proyectos');
                            showEmptyState();
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        showError('Error al cargar los proyectos: ' + (error.response?.data?.message || error.message));
                        showEmptyState();
                    });
            }

            function renderProjects(projects, searchTerm = '') {
                hideLoading();

                if (projects.length === 0) {
                    showEmptyState();
                    return;
                }

                const container = $('#projectsContainer');
                container.empty().show();
                $('#emptyState').hide();

                projects.forEach(function(project) {
                    const card = createProjectCard(project, searchTerm);
                    container.append(card);

                    const membersContainer = $(`#membersContainer_${project.uid}`);
                    loadMembers(project.uid, membersContainer);
                });

                // Animar las cartas
                $('.project-card').each(function(index) {
                    $(this).css('opacity', 0).delay(index * 100).animate({
                        opacity: 1
                    }, 300);
                });
            }

            function createProjectCard(project, searchTerm = '') {
                // Generar iniciales para el avatar
                const initials = getInitials(project.usuario_username || 'Usuario');

                // Destacar términos de búsqueda
                const highlightedTitle = highlightSearchTerm(project.nombre || 'Sin título', searchTerm);
                const highlightedOwner = highlightSearchTerm(project.usuario_username || 'Usuario desconocido', searchTerm);

                // Determinar el progreso/estado
                const progress = project.progreso;
                const progressText = progress;
                const progressClass = getProgressClass(progress);

                return `
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="card project-card">
                            <div class="project-header">
                                <div class="d-flex justify-content-between align-items-start">
                                    <!-- Título -->
                                    <h5 class="project-title text-white mb-2 project-link" data-id="${project.uid}">
                                        ${highlightedTitle}
                                    </h5>

                                    <!-- Ícono Ver Detalles -->
                                    <button type="button" class="btn btn-sm btn-link text-white p-0 ms-2 btn-view"
                                            data-id="${project.uid}" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                            title="Ver detalles">
                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.52075 10.8035C6.85975 10.8035 6.32275 11.3405 6.32275 11.9995C6.32275 12.6595 6.85975 13.1975 7.52075 13.1975C8.18175 13.1975 8.71875 12.6595 8.71875 11.9995C8.71875 11.3405 8.18175 10.8035 7.52075 10.8035ZM11.9999 10.8035C11.3389 10.8035 10.8019 11.3405 10.8019 11.9995C10.8019 12.6595 11.3389 13.1975 11.9999 13.1975C12.6609 13.1975 13.1979 12.6595 13.1979 11.9995C13.1979 11.3405 12.6609 10.8035 11.9999 10.8035ZM15.2813 11.9995C15.2813 11.3405 15.8183 10.8035 16.4793 10.8035C17.1403 10.8035 17.6773 11.3405 17.6773 11.9995C17.6773 12.6595 17.1403 13.1975 16.4793 13.1975C15.8183 13.1975 15.2813 12.6595 15.2813 11.9995Z" fill="currentColor"></path>                                </svg>                            
                                    </button>

                                </div>

                                <!-- Descripción dentro del header -->
                                <p class="project-description mb-0">
                                    ${project.descripcion || ''}
                                </p>
                            </div>

                            
                            <div class="card-body">
                                <div class="mt-2 mb-3 d-flex justify-content-between align-items-center">
                                    <span class="badge badge-status ${progressClass}">
                                        ${getProgressIcon(progress)}
                                        ${progressText}
                                    </span>
                                </div>

                                <div class="owner-info d-flex mb-0 align-items-center">
                                    <!-- Avatar con iniciales (tooltip con nombre del propietario) -->
                                    <div class="owner-avatar rounded-circle d-flex align-items-center justify-content-center border border-2 border-primary"
                                        style="width: 40px; height: 40px; background-color: #0d6efd; color: white; font-weight: bold; margin-right: -10px; z-index: 1;"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Propietario del proyecto: ${highlightedOwner}"> ${initials }
                                        
                                    </div>

                                    <!-- miembros -->
                                    <div class="d-flex align-items-center" id="membersContainer_${project.uid}"></div>

                                    <!-- Botón con "+" (tooltip con añadir usuarios) -->
                                    <div class="rounded-circle d-flex align-items-center justify-content-center border border-2 border-primary bg-white text-primary"
                                        style="width: 40px; height: 40px; cursor: pointer; z-index: 2;"
                                        id="btnAddUser_${project.id}"
                                        data-project-id="${project.id}"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Añadir usuarios">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                `;
            }

        // función para listar a los miembros
        function loadMembers(uid, container) {
            axios.get(`/miembros-equipo/${uid}`)
                .then(function(response) {
                    if (response.data.miembros && response.data.miembros.length > 0) {
                        let membersHtml = '';

                response.data.miembros.forEach(miembro => {
                    membersHtml += renderAvatar(miembro);
                });

                container.html(membersHtml);
            }
        })
        .catch(function(error) {
            console.error("Error cargando miembros:", error);
            container.html('<small class="text-danger">Error al cargar</small>');
        });
}


// 🔹 Función que genera avatar según si hay foto o no
function renderAvatar(usuario) {
    const initials = getInitials(usuario.username);

    if (usuario.foto_url) {
        const img = document.createElement("img");
        img.src = usuario.foto_url;
        img.className = "avatar-img";
        img.title = `${usuario.username} (${usuario.rol})`;

        img.onerror = function () {
            this.replaceWith(getFallbackAvatarElement(initials, usuario.username, usuario.rol));
        };

        return img.outerHTML;
    } else {
        return getFallbackAvatar(initials, usuario.username, usuario.rol);
    }
}



function getFallbackAvatar(initials, username, rol) {
    return `
        <div class="avatar-fallback"
            title="${username} (${rol})">
            ${initials}
        </div>
    `;
}

window.getFallbackAvatarElement = function(initials, username, rol) {
    const div = document.createElement('div');
    div.className = 'avatar-fallback';
    div.title = `${username} (${rol})`;
    div.textContent = initials;
    return div;
};




// Esta función devuelve un nodo real para el replaceWith
function getFallbackAvatarElement(initials, username, rol) {
    const div = document.createElement('div');
    div.className = 'avatar-fallback';
    div.title = `${username} (${rol})`;
    div.textContent = initials;
    return div;
}

            //------------

            document.addEventListener("DOMContentLoaded", function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });

        // Funcion para crear un proyecto
        $(document).ready(function() {
            const notyf = new Notyf({
                duration: 3000,
                position: {
                    x: 'right',
                    y: 'top'
                }
            });

            $("#formCrearProyecto").on("submit", function(e) {
                e.preventDefault();

                // Botón en estado "Guardando..."
                let btn = $(this).find("button[type=submit]");
                btn.prop("disabled", true).text("Guardando...");

                let formData = new FormData(this);

                axios.post("{{ route('storeProyecto') }}", formData)
                    .then(function(response) {
                        if (response.data.success) {
                            notyf.success(response.data.message);

                            // Cerrar modal
                            $("#modalCrearProyecto").modal("hide");

                            // Resetear formulario
                            $("#formCrearProyecto")[0].reset();
                            loadProjects();
                        } else {
                            notyf.error("No se pudo guardar el proyecto");
                        }
                    })
                    .catch(function(error) {
                        if (error.response && error.response.status === 422) {
                            let errors = error.response.data.errors;
                            $.each(errors, function(key, value) {
                                notyf.error(value[0]);
                            });
                        } else {
                            notyf.error("Ocurrió un error inesperado");
                        }
                    })
                    .finally(function() {
                        // Restaurar botón
                        btn.prop("disabled", false).text("Guardar");
                    });
            });
        });

        function getProgressText(progress) {
            const progressMap = {
                'planificacion': 'Planificación',
                'desarrollo': 'Desarrollo',
                'testing': 'Testing',
                'revision': 'Revisión',
                'completado': 'Completado',
                'pausado': 'Pausado',
                'cancelado': 'Cancelado'
            };
            return progressMap[progress] || 'Sin definir';
        }

        function getProgressClass(progress) {
            return `status-${progress}`;
        }

        function getProgressIcon(progress) {
            const iconMap = {
                'planificacion': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/><path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319z"/></svg>',
                'desarrollo': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/><path d="M1 4.5A.5.5 0 0 1 1.5 4h13a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-8z"/></svg>',
                'testing': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M8.5 1.5A1.5 1.5 0 0 0 7 0a1.5 1.5 0 0 0-1.5 1.5v.681c-1.532.389-2.694 1.78-2.694 3.442v.975c0 .6-.315 1.17-.835 1.488a2.5 2.5 0 0 0 .382 4.64c.649.35 1.428.149 1.835-.599.612-1.127 1.8-1.884 3.096-1.884s2.484.757 3.096 1.884c.407.748 1.186.95 1.835.599a2.5 2.5 0 0 0 .382-4.64c-.52-.318-.835-.888-.835-1.488v-.975c0-1.661-1.162-3.053-2.694-3.442V1.5z"/></svg>',
                'revision': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>',
                'completado': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>',
                'pausado': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm3 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S8.448 5 9 5s1 .672 1 1.5z"/></svg>',
                'cancelado': '<svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>'
            };
            return iconMap[progress] || '';
        }

        function getInitials(name) {
            return name
                .split(' ')
                .map(word => word.charAt(0).toUpperCase())
                .slice(0, 2)
                .join('');
        }

        function highlightSearchTerm(text, searchTerm) {
            if (!searchTerm || searchTerm.trim() === '') return text;

            const regex = new RegExp(`(${escapeRegex(searchTerm)})`, 'gi');
            return text.replace(regex, '<span class="search-highlight">$1</span>');
        }

        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function formatDate(dateString) {
            if (!dateString) return 'Fecha no disponible';

            const date = new Date(dateString);
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };

            return date.toLocaleDateString('es-ES', options);
        }

        function showLoading() {
            $('#loadingSpinner').show();
            $('#projectsContainer').hide();
            $('#emptyState').hide();
        }

        function hideLoading() {
            $('#loadingSpinner').hide();
        }

        function showEmptyState() {
            hideLoading();
            $('#projectsContainer').hide();
            $('#emptyState').show();
        }

        function showError(message) {
            $.notify({
                title: 'Error',
                message: message
            }, {
                type: 'danger',
                placement: {
                    from: "top",
                    align: "right"
                },
                delay: 5000,
                animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
                }
            });
        }

        function showSuccess(message) {
            $.notify({
                title: 'Éxito',
                message: message
            }, {
                type: 'success',
                placement: {
                    from: "top",
                    align: "right"
                },
                delay: 3000,
                animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
                }
            });
        }

        $(document).on("click", "#deleteProjectBtn", function() {
            const uid = $(this).data('uid'); // Obtenemos el UID que asignamos antes
            const isDark = document.body.classList.contains('dark'); // Etiqueta de modo oscuro

            if (!uid) {
                Swal.fire({
                    title: 'Error',
                    text: 'No se encontró el proyecto.',
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este proyecto será eliminado y no podrás recuperarlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                background: isDark ? '#1e1e2d' : '#fff',
                color: isDark ? '#fff' : '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/proyectos/delete/${uid}`, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(response => {
                            if (response.data.success) {
                                // Cerrar modal de detalles del proyecto si está abierto
                                const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallesProyecto'));
                                if (modalDetalles) modalDetalles.hide();

                                Swal.fire({
                                    title: 'Eliminado!',
                                    text: 'El proyecto fue eliminado correctamente.',
                                    icon: 'success',
                                    confirmButtonColor: '#198754',
                                    background: isDark ? '#1e1e2d' : '#fff',
                                    color: isDark ? '#fff' : '#000'
                                }).then(() => {
                                    loadProjects(); // Recarga la lista de proyectos
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.data.message || 'No se pudo eliminar el proyecto.',
                                    icon: 'error',
                                    background: isDark ? '#1e1e2d' : '#fff',
                                    color: isDark ? '#fff' : '#000'
                                });
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                title: 'Error del servidor',
                                text: 'Ocurrió un problema al intentar eliminar el proyecto.',
                                icon: 'error',
                                background: isDark ? '#1e1e2d' : '#fff',
                                color: isDark ? '#fff' : '#000'
                            });
                        });
                }
            });
        });

        const notyf = new Notyf({
            duration: 3000,
            position: {
                x: 'right',
                y: 'top'
            },
            dismissible: true
        });

        $(document).on("click", "#updateProjectBtn", function() {
            const uid = $("#updateProjectBtn").data("uid") || $("#deleteProjectBtn").data("uid"); // UID del proyecto

            if (!uid) {
                notyf.error('No se encontró el proyecto.');
                return;
            }

            // Valores del modal
            const nombre = $("#detalleNombre").val();
            const progreso = $("#detalleProgreso").val();
            const visibilidad = $("#detalleVisibilidad").val();
            const fecha_inicio = $("#detalleFechaInicio").val();
            const fecha_fin = $("#detalleFechaFin").val();
            const descripcion = $("#detalleDescripcionInput").val();

            axios.put("{{ route('updateProyecto') }}", {
                    uid,
                    nombre,
                    progreso,
                    visibilidad,
                    fecha_inicio,
                    fecha_fin,
                    descripcion
                }, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => {
                    // Cerrar modal inmediatamente
                    const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallesProyecto'));
                    if (modalDetalles) modalDetalles.hide();

                    if (response.data.success) {
                        notyf.success('El proyecto fue actualizado correctamente.');
                        // Recargar proyectos
                        loadProjects();
                    } else {
                        notyf.error(response.data.message || 'No se pudo actualizar el proyecto.');
                    }
                })
                .catch(error => {
                    // Cerrar modal aunque haya error
                    const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallesProyecto'));
                    if (modalDetalles) modalDetalles.hide();

                    console.error(error);
                    if (error.response?.status === 422) {
                        const messages = Object.values(error.response.data.errors).flat().join(', ');
                        notyf.error(`Error de validación: ${messages}`);
                    } else {
                        notyf.error('Ocurrió un problema al actualizar el proyecto.');
                    }
                });
        });
    });

    $(document).on("click", ".btn-view", function() {
        let uid = $(this).data("id");

        axios.get(`/proyecto/${uid}`)
            .then(function(response) {
                if (response.data.success) {
                    let p = response.data.data;

                    $("#projectTitleDisplay").text(p.nombre || "Sin nombre");
                    $("#ownerNameDisplay").text(p.usuario_username || "Desconocido");
                    $("#createdDateDisplay").text(formatDate(p.created_at) || "N/A");

                    $("#userName").text(p.usuario_username || "Desconocido");
                    $("#userEmail").text(p.usuario_email || "Sin email");
                    $("#userInitial").text((p.usuario_username || "U").charAt(0).toUpperCase());

                    $("#progressValue").text(getProgressText(p.progreso));
                    $("#visibilityValue").text(getVisibilityText(p.visibilidad));

                    // Form inputs
                    $("#detalleNombre").val(p.nombre || "");
                    $("#detalleProgreso").val(p.progreso || "planificacion");
                    $("#detalleVisibilidad").val(p.visibilidad || "1");
                    $("#detalleFechaInicio").val(p.fecha_inicio || "");
                    $("#detalleFechaFin").val(p.fecha_fin || "");
                    $("#detalleDescripcionInput").val(p.descripcion || "");

                    $("#detalleDescripcion").text(p.descripcion || "Sin descripción");
                    $("#detalleCreado").text(formatDateTime(p.created_at) || "N/A");
                    $("#detalleActualizado").text(formatDateTime(p.updated_at) || "N/A");

                    $("#sprintsValue").text(p.total_sprints || 0);
                    $("#elementsValue").text(p.total_elementos || 0);


                    $("#deleteProjectBtn").data('uid', uid);
                    $("#updateProjectBtn").data('uid', uid);

                    loadProjectUsers(uid);

                    // Show modal
                    new bootstrap.Modal(document.getElementById('modalDetallesProyecto')).show();
                }
            })
            .catch(function(error) {
                console.error(error);
                alert("Error al cargar detalles del proyecto");
            });
    });

    function getVisibilityText(visibilidad) {
        return visibilidad == 1 ? 'Público' : 'Privado';
    }

    function getProgressText(progreso) {
        const progressMap = {
            'planificacion': 'Planificación',
            'desarrollo': 'Desarrollo',
            'testing': 'Testing',
            'revision': 'Revisión',
            'completado': 'Completado',
            'pausado': 'Pausado',
            'cancelado': 'Cancelado'
        };
        return progressMap[progreso] || 'Planificación';
    }

    function formatDate(dateString) {
        if (!dateString) return null;
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES');
    }

    function formatDateTime(dateString) {
        if (!dateString) return null;
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES') + ' ' + date.toLocaleTimeString('es-ES', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    $(document).on("click", ".project-link", function() {
        const uid = $(this).data("id");
        if (uid) {
            window.location.href = `/proyectos/backlog/${uid}`;
        }
    });


    //funciones para agregar una nueva persona al proyecto
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top'
        }
    });
    let proyectId = null
    $(document).on("click", "[id^=btnAddUser_]", function() {
        proyectId = $(this).data('project-id');
        $('#modalAddUser').modal('show');
    });

    $('#btnSaveUser').on('click', function() {
        if (!proyectId) {
            notyf.error('No se encontro el proyecto.');
            return;
        }

        let formData = $('#formAddUser').serialize();
        console.log(formData);
        $.ajax({
            url: `/proyectos/${proyectId}/enviar-invitacion`,
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#modalAddUser').modal('hide');
                $('#formAddUser')[0].reset();
                notyf.success(response.message);
                console.log(response.message);
            },
            error: function(xhr) {
                let errorMsg = "Error al enviar invitación.";

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                notyf.error(errorMsg);
            }
        });
    });
    //----------------
</script>
@endsection