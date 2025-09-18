@extends('layouts.layout.layout')

@section('title', 'Scrum')

@section('css')
<style>
    .notification-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .notification-item:hover {
        transform: translateX(5px);
    }

    .badge-invitacion {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .modal-proyecto-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Saludo -->
    <div class="text-center mb-4">
        <p class="text-muted mb-1">{{ $fecha }}</p>
        <h2 class="fw-bold">{{ $saludo }}, {{ Auth::user()->nombre }}</h2>
    </div>

    <!-- Barra de búsqueda -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="input-group shadow-sm rounded-pill">
                <span class="input-group-text bg-transparent border-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-0" placeholder="Tareas de búsqueda, proyectos y notas">
                <span class="input-group-text bg-transparent border-0 text-muted">Ctrl K</span>
            </div>
        </div>
    </div>

    <!-- Chips / Filtros -->
    <div class="d-flex justify-content-center gap-2 mb-5">
        <span class="badge rounded-pill bg-body-secondary text-body px-3 py-2">
            <i class="bi bi-people me-1"></i> Equipo del Proyecto de Santiago
        </span>
        <span class="badge rounded-pill bg-body-secondary text-body px-3 py-2">
            <i class="bi bi-clock-history me-1"></i> Ver todos los recientes
        </span>
    </div>

    <!-- Secciones -->
    <div class="row g-4 ps-5 pe-5 align-items-stretch">
        <!-- Columna izquierda -->
        <div class="col-lg-7 d-flex flex-column">
            <!-- Tarjeta Tareas -->
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                    <i class="bi bi-check-circle me-2">
                    </i> Tareas</h6>
                    <div class="text-center p-4">
                        <img src="https://img.icons8.com/ios/150/000000/todo-list--v1.png" 
                            alt="Sin tareas" 
                            class="mb-3 opacity-50" width="75">
                        <p class="text-muted mb-1">No hay tareas asignadas a usted</p>
                        <small class="text-muted">También puedes fijar tareas para verlas aquí</small>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Proyectos -->
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3 d-flex align-items-center">
                        <i class="bi bi-rocket-takeoff me-2"></i> Proyectos
                        <button class="btn btn-sm btn-primary ms-auto">
                            <i class="bi bi-filter"></i> 1
                        </button>
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0 small">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="py-1 px-2">Nombre del proyecto</th>
                                    <th class="py-1 px-2">Elementos</th>
                                    <th class="py-1 px-2">Sprints</th>
                                </tr>
                            </thead>
                            <tbody id="proyectosBody" class="mt-3">
                                <tr>
                                    <td class="py-1 px-2">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- Columna derecha -->
        <div class="col-lg-5 d-flex flex-column">
            <div class="card shadow-sm rounded-3 flex-grow-1">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-bell me-2"></i> Notificaciones
                        <span class="badge bg-primary float-end">1</span>
                    </h6>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" id="notifTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">Todo</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mentions">Menciones</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#projects">Proyectos</button></li>
                    </ul>

                    <div class="tab-content flex-grow-1">
                        <div class="tab-pane fade show active" id="all">
                            <div class="alert alert-light d-flex align-items-start border rounded-3">
                                <span class="badge bg-danger me-2">2</span>
                                <div>
                                    <strong>Hola  {{ Auth::user()->nombre }}, ¡Bienvenido a Scrum!</strong><br>
                                    Estamos encantados de tenerte a bordo. Disfruta.
                                    <div class="mt-1"><small class="text-muted">21 de agosto</small></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mentions">
                            <div class="empty-state py-4 text-center">
                                <i class="bi bi-at fs-1 mb-3"></i>
                                <p class="mb-0">No hay menciones nuevas</p>
                                <small>Te notificaremos cuando alguien te mencione</small>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="projects">
                            <div id="invitacionesProyectos"></div>
                            <div id="noInvitacionesProyectos" class="empty-state py-4 text-center" style="display: none;">
                                <i class="bi bi-inbox fs-1 mb-3"></i>
                                <p class="mb-0">No hay invitaciones pendientes</p>
                                <small>Las invitaciones a proyectos aparecerán aquí</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal detalle de invitación -->
    <div class="modal fade" id="modalDetalleInvitacion" tabindex="-1" aria-labelledby="modalDetalleInvitacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-proyecto-header border-0">
                    <div>
                        <h5 class="modal-title mb-1" id="modalDetalleInvitacionLabel">
                            <i class="bi bi-folder me-2"></i>
                            <span id="nombreProyecto">Nombre del Proyecto</span>
                        </h5>
                        <small class="opacity-75" id="fechaInvitacion">Invitación recibida el...</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-2">
                                    <i class="bi bi-info-circle me-2 text-primary"></i>
                                    Descripción del Proyecto
                                </h6>
                                <p class="text-muted" id="descripcionProyecto">
                                    Cargando descripción del proyecto...
                                </p>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-semibold mb-2">
                                    <i class="bi bi-person me-2 text-success"></i>
                                    Invitado por
                                </h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <span id="initialsInvitador">SI</span>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium" id="nombreInvitador">Santiago Invitador</p>
                                        <small class="text-muted" id="emailInvitador">santiago@ejemplo.com</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-semibold mb-2">
                                    <i class="bi bi-shield-check me-2 text-warning"></i>
                                    Tu rol en el proyecto
                                </h6>
                                <span class="badge bg-info px-3 py-2" id="rolAsignado">Miembro</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <i class="bi bi-clock fs-1 text-primary mb-2"></i>
                                    <h6 class="fw-semibold mb-1">Tiempo restante</h6>
                                    <p class="text-muted mb-0" id="tiempoExpiracion">6 días</p>
                                    <small class="text-muted">para responder</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <div class="w-100 d-flex gap-2">
                        <button type="button" class="btn btn-outline-danger flex-fill" id="btnRechazarInvitacion">
                            <i class="bi bi-x-circle me-2"></i>
                            Rechazar
                        </button>
                        <button type="button" class="btn btn-success flex-fill" id="btnAceptarInvitacion">
                            <i class="bi bi-check-circle me-2"></i>
                            Aceptar Invitación
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------------------- -->

    @endsection

    @section('js')
    <script>
        let invitacionActual = null;

        //cargar invitaciones en las notificaciones
        function cargarInvitacionesNotificaciones() {
            axios.get('{{ route("proyectos.misInvitaciones") }}')
                .then(response => {
                    const invitaciones = response.data.invitaciones;
                    actualizarContadoresNotificaciones(invitaciones.length);
                    mostrarInvitacionesEnTabs(invitaciones);
                })
                .catch(error => {
                    console.error('error al cargar invitaciones:', error);
                });
        }
        //-------------------------

        //funcion para actualizar el contador de notificaciones
        function actualizarContadoresNotificaciones(cantidad) {
            const badgeInvitaciones = $('#badgeInvitaciones');
            if (cantidad > 0) {
                badgeInvitaciones.text(cantidad).show();
            } else {
                badgeInvitaciones.hide();
            }

            const contadorTotal = $('#contadorNotificaciones');
            const cantidadTotal = cantidad + 1;
            contadorTotal.text(cantidadTotal);
        }
        //-------------------

        function mostrarInvitacionesEnTabs(invitaciones) {
            if (invitaciones.length === 0) {
                $('#invitacionesProyectos').hide();
                $('#noInvitacionesProyectos').show();
                $('#invitacionesTodo').html('');
                return;
            }
            $('#noInvitacionesProyectos').hide();
            $('#invitacionesProyectos').show();

            const tarjetasInvitaciones = invitaciones.map(invitacion => {
                const fechaInvitacion = new Date(invitacion.created_at).toLocaleDateString('es-ES');
                const diasRestantes = calcularDiasRestantes(invitacion.expira_en);

                return `
                <div class="notification-item alert alert-light d-flex align-items-start border rounded-3 mb-2" 
                    onclick="abrirDetalleInvitacion('${invitacion.uid}')">
                <div class="me-2">
                    <i class="bi bi-folder fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>${invitacion.proyecto.nombre}</strong>
                            <br>
                            <small>
                                Invitado por ${invitacion.invitado_por.nombre} • ${fechaInvitacion}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning text-dark">Pendiente</span>
                            <br>
                            <small>${diasRestantes}</small>
                        </div>
                    </div>
                </div>
            </div>
            `;
            }).join('');

            $('#invitacionesProyectos').html(tarjetasInvitaciones);
            //mostrar las invitaciones en el tab de todo
            const invitacionesTodo = invitaciones.map(invitacion => {
                const fechaInvitacion = new Date(invitacion.created_at).toLocaleDateString('es-ES');
                console.log(invitacion.invitado_por.nombre);

                return `
                <div class="notification-item alert alert-light d-flex align-items-start border rounded-3 mb-2" 
                    onclick="abrirDetalleInvitacion('${invitacion.uid}')">
                    <span class="badge bg-primary me-2">!</span>
                    <div>
                        <strong>Invitación a proyecto: ${invitacion.proyecto.nombre}</strong><br>
                        ${invitacion.invitado_por.nombre} te ha invitado a unirte al proyecto.
                        <div class="mt-1"><small class="text-muted">${fechaInvitacion}</small></div>
                    </div>
                </div>  
            `;
            }).join('');
            $('#invitacionesTodo').html(invitacionesTodo);
        }

        //funcion para calcular los dias 
        function calcularDiasRestantes(fechaExpiracion) {

            if (!fechaExpiracion) return 'sin límite';

            const ahora = new Date();
            const expira = new Date(fechaExpiracion);
            const diferencia = expira - ahora;
            const dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

            if (dias < 0) return 'Expirada';
            if (dias === 0) return 'Expira hoy';
            if (dias === 1) return '1 dia restante';
            return `${dias} dias restantes`;
        }

        //funcion para abrir el modal del detalle de la invitacion
        function abrirDetalleInvitacion(uid) {
            axios.get('{{ route("proyectos.misInvitaciones") }}')
                .then(response => {
                    const invitacion = response.data.invitaciones.find(inv => inv.uid === uid);
                    console.log(invitacion);

                    if (!invitacion) {
                        Swal.fire('Error', 'Invitacion no encontrada', 'error');
                        return;
                    }

                    invitacionActual = invitacion;

                    $('#nombreProyecto').text(invitacion.proyecto.nombre);
                    $('#fechaInvitacion').text(`Invitacion recibida el ${new Date(invitacion.created_at).toLocaleDateString('es-ES')}`);
                    $('#descripcionProyecto').text(invitacion.proyecto.descripcion || 'Sin descripcion');
                    $('#nombreInvitador').text(invitacion.invitado_por.nombre);
                    $('#emailInvitador').text(invitacion.invitado_por.email);
                    $('#tiempoExpiracion').text(calcularDiasRestantes(invitacion.expira_en));

                    //iniciales para el avatar
                    const nombres = invitacion.invitado_por.nombre.split(' ');
                    const iniciales = nombres.map(nombre => nombre.charAt(0)).join('').toUpperCase().substring(0, 2);
                    $('#initialsInvitador').text(iniciales);

                    const modal = new bootstrap.Modal(document.getElementById('modalDetalleInvitacion'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'No se pudo cargar la invitación', 'error');
                });
        }

        function responderInvitacionDetalle(accion) {
            if (!invitacionActual) {
                Swal.fire('Error', 'No hay invitación seleccionada', 'error');
                return;
            }

            const textoAccion = accion === 'aceptar' ? 'aceptar' : 'rechazar';
            const iconoAccion = accion === 'aceptar' ? 'question' : 'warning';
            const colorBoton = accion === 'aceptar' ? '#28a745' : '#dc3545';

            Swal.fire({
                title: `¿Estás seguro?`,
                text: `¿Deseas ${textoAccion} la invitación al proyecto "${invitacionActual.proyecto.nombre}"?`,
                icon: iconoAccion,
                showCancelButton: true,
                confirmButtonText: accion === 'aceptar' ? 'Sí, aceptar' : 'Sí, rechazar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: colorBoton
            }).then((result) => {
                if (result.isConfirmed) {
                    const btnAceptar = $('#btnAceptarInvitacion');
                    const btnRechazar = $('#btnRechazarInvitacion');
                    const textoOriginalAceptar = btnAceptar.html();
                    const textoOriginalRechazar = btnRechazar.html();

                    btnAceptar.prop('disabled', true);
                    btnRechazar.prop('disabled', true);

                    if (accion === 'aceptar') {
                        btnAceptar.html('<i class="bi bi-hourglass me-2"></i>Procesando...');
                    } else {
                        btnRechazar.html('<i class="bi bi-hourglass me-2"></i>Procesando...');
                    }

                    const formData = new FormData();
                    formData.append('accion', accion);
                    formData.append('_token', '{{ csrf_token() }}');

                    axios.post(`/invitaciones/${invitacionActual.uid}/responder`, formData)
                        .then(response => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalDetalleInvitacion'));
                            modal.hide();

                            Swal.fire({
                                title: '¡Éxito!',
                                text: response.data.message,
                                icon: 'success'
                            }).then(() => {
                                // Recargar las invitaciones
                                cargarInvitacionesNotificaciones();
                                cargarProyectos();
                            });
                        })
                        .catch(error => {
                            console.error('error: ', error);
                            let mensaje = 'Error al procesar la invitacion';

                            if (error.response && error.response.data.message) {
                                mensaje = error.response.data.message;
                            }
                            Swal.fire('Error', mensaje, 'error');
                        })
                        .finally(() => {
                            // Rehabilitar botones
                            btnAceptar.prop('disabled', false).html(textoOriginalAceptar);
                            btnRechazar.prop('disabled', false).html(textoOriginalRechazar);
                        });
                }
            });
        }

        $(document).ready(function() {
            cargarInvitacionesNotificaciones();

            setInterval(cargarInvitacionesNotificaciones, 30000);

            // Event listeners para los botones del modal
            $('#btnAceptarInvitacion').on('click', function() {
                responderInvitacionDetalle('aceptar');
            });

            $('#btnRechazarInvitacion').on('click', function() {
                responderInvitacionDetalle('rechazar');
            });

            // Limpiar datos cuando se cierra el modal
            $('#modalDetalleInvitacion').on('hidden.bs.modal', function() {
                invitacionActual = null;
            });

        });

        function cargarProyectos() {
            axios.get("{{ route('getProyectos') }}")
                .then(function(response) {
                    let proyectos = response.data;
                    let tbody = $('#proyectosBody');
                    tbody.empty();

                    if (proyectos.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No tienes proyectos creados.
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    proyectos.forEach(proyecto => {
                        let fila = `
                            <tr>
                                <td class="py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(proyecto.proyecto)}&background=random&color=fff"
                                            class="rounded-circle me-2"
                                            width="24" height="24"
                                            alt="Proyecto">
                                        <a href="{{ url('/proyectos/backlog') }}/${proyecto.uid}" 
                                        class="fw-semibold text-decoration-none">
                                            ${proyecto.proyecto}
                                        </a>
                                    </div>
                                </td>
                                <td class="py-1 px-2">${proyecto.total_elementos}</td>
                                <td class="py-1 px-2">${proyecto.total_sprints}</td>
                            </tr>
                        `;
                        tbody.append(fila);
                    });
                })
                .catch(function(error) {
                    console.error("Error cargando proyectos:", error);
                });
        }

        $(document).ready(function() {
            cargarProyectos();
        });
    </script>

    @endsection