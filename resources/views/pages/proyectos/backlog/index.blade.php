@extends('layouts.layout.layout')   

@section('title', 'Scrum')

@section('content')
    <div class="container-fluid content-inner mt-5 pt-4 py-0">
        <div class="row">
            <!-- Título principal -->
            <div class="col-12 mb-2">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex align-items-center py-2">
                        <h5 class="mb-0 fw-semibold">
                            Backlog del Proyecto: 
                            <span class="text-muted fw-normal">{{ $proyecto->nombre }}</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Sección izquierda - Historias de Usuario -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                        <h6 class="mb-0 fw-semibold fs-6">
                            <i class="bi bi-list-task text-primary me-1"></i>
                            Product Backlog
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalHistoria">
                            <i class="bi bi-plus-circle me-1"></i> Nueva
                        </button>
                    </div>
                    <div class="card-body py-3 px-3" id="historias-content">
                        <!-- Estado de carga -->
                        <div class="d-flex justify-content-center py-3" id="loading-historias">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>

                        <!-- Estado vacío -->
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
                        <!-- Estado vacío -->
                        <div class="empty-state text-center text-muted py-4">
                            <i class="bi bi-flag-fill fs-3 d-block mb-2"></i>
                            <p class="small mb-2">No hay sprints creados</p>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalSprint">
                                +   Crear primer sprint
                            </button>
                        </div>
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
                                    <input type="number" class="form-control" id="valor_historia" name="valor_historia" min="1" max="100" required>
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
                        <input type="hidden" id="edit_historia_uid">

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



    <!-- Modal para Nuevo Sprint (Solo visual) -->
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
                            <input type="text" class="form-control" placeholder="Sprint 1" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Objetivo del Sprint</label>
                            <textarea class="form-control" rows="3" placeholder="Descripción del objetivo..." disabled></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Duración</label>
                            <select class="form-select" disabled>
                                <option>1 semana</option>
                                <option>2 semanas</option>
                                <option>3 semanas</option>
                                <option>4 semanas</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" disabled>
                        <i class="fas fa-plus me-2"></i>
                        Crear Sprint
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        
        .historia-item {
            border-left: 4px solid #3b82f6;
            transition: all 0.3s ease;
        }
        
        .historia-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .prioridad-alta { border-left-color: #e53e3e; }
        .prioridad-media { border-left-color: #f6ad55; }
        .prioridad-baja { border-left-color: #48bb78; }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #d1d5db;
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
                types: [
                    {
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

            // Función para mostrar las historias en el DOM
            function mostrarHistorias(historias) {
                if (historias && historias.length > 0) {
                    let historiasHtml = '<div class="row" id="historias-container">';
                    
                    historias.forEach(function(historia) {
                        const prioridadClass = historia.prioridad.toLowerCase() === 'alta' ? 'prioridad-alta' : 
                                            historia.prioridad.toLowerCase() === 'media' ? 'prioridad-media' : 'prioridad-baja';
                        
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
                                    <li class="small">
                                        <i class="bi ${criterio.estado ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted'} me-1"></i>
                                        ${criterio.descripcion}
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
                                <div class="card shadow-sm border rounded-3 historia-item ${prioridadClass}" 
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
                                            <h6 class="card-title mb-0 fw-semibold text-truncate" style="max-width: 70%;">
                                                ${historia.titulo}
                                            </h6>
                                            <span class="badge ${badgeClass}">${historia.prioridad}</span>
                                        </div>
                                        
                                        <p class="card-text text-muted small mb-2">${historia.descripcion}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center small text-muted">
                                            <span><i class="bi bi-star me-1"></i>Valor: ${historia.valor_historia}</span>
                                            <span><i class="bi bi-list-task me-1"></i>${historia.progreso}</span>
                                        </div>
                                        
                                        <!-- Creado por + opciones -->
                                        <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                                            <span>
                                                <i class="bi bi-person-circle me-1"></i> ${historia.creador_nombre || 'Desconocido'}
                                            </span>
                                            <div class="d-flex align-items-center">
                                                <!-- Botón para agregar criterios -->
                                                <button class="btn btn-sm btn-primary me-1 agregar-criterio" title="Agregar criterio" data-historia-id="${historia.uid}">
                                                    <i class="bi bi-check2-square"></i>
                                                </button>
                                                <!-- Menú de opciones (Editar / Eliminar) -->
                                                <div class="dropup">
                                                    <button class="btn btn-sm btn-secondary" 
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


        $(document).ready(function () {
            // Interceptar el submit del formulario
            $("#formHistoria").on("submit", function (e) {
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
        $(document).on("click", ".eliminar-historia", function (e) {
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
                        .then(function (response) {
                            if (response.data.success) {
                                notyf.success(response.data.message);

                                // Remover del DOM
                                $(`[data-historia-id="${historiaUid}"]`).fadeOut(300, function () {
                                    $(this).remove();
                                });

                                cargarHistorias();
                            } else {
                                notyf.error(response.data.message || "No se pudo eliminar la historia.");
                            }
                        })
                        .catch(function (error) {
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

        $(document).on('click', '.editar-historia', function(e) {
            e.preventDefault();

            const card = $(this).closest('.historia-item');

            $('#edit_historia_uid').val(card.data('uid'));
            $('#edit_titulo').val(card.data('titulo'));
            $('#edit_descripcion').val(card.data('descripcion'));
            $('#edit_prioridad').val(card.data('prioridad'));
            $('#edit_valor_historia').val(card.data('valor'));
            $('#edit_progreso').val(card.data('progreso'));

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
                $('#titulo').siblings('.form-text').text('Máximo 50 caracteres').removeClass('text-danger').addClass('text-muted');
                $('#descripcion').siblings('.form-text').text('Máximo 255 caracteres').removeClass('text-danger').addClass('text-muted');
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
                $(this).css('opacity', '0.5');
                console.log('Arrastrando historia:', $(this).find('.card-title').text());
            });

            $(document).on('dragend', '.historia-item', function(e) {
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
    </script>
@endsection
