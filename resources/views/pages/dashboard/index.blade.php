@extends('layouts.layout.layout')   

@section('title', 'Scrum')

@section('css')

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
            <span class="badge rounded-pill bg-body-secondary text-dark px-3 py-2">
                <i class="bi bi-people me-1"></i> Equipo del Proyecto de Santiago
            </span>
            <span class="badge rounded-pill bg-body-secondary text-dark px-3 py-2">
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
                        <h6 class="fw-semibold mb-3"><i class="bi bi-check-circle me-2"></i> Tareas</h6>
                        <div class="text-center p-4">
                            <img src="https://via.placeholder.com/150" alt="No tareas" class="mb-3">
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
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#notes">Notas</button></li>
                        </ul>

                        <div class="tab-content flex-grow-1">
                            <div class="tab-pane fade show active" id="all">
                                <div class="alert alert-light d-flex align-items-start border rounded-3">
                                    <span class="badge bg-danger me-2">2</span>
                                    <div>
                                        <strong>Hola Santiago, ¡Bienvenido a Scrum!</strong><br>
                                        Estamos encantados de tenerte a bordo. Disfruta.
                                        <div class="mt-1"><small class="text-muted">21 de agosto</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="mentions">No hay menciones nuevas.</div>
                            <div class="tab-pane fade" id="projects">No hay notificaciones de proyectos.</div>
                            <div class="tab-pane fade" id="notes">No hay notas nuevas.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('js')
    <script>
        function cargarProyectos() {
            axios.get("{{ route('getProyectos') }}")
                .then(function (response) {
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
                .catch(function (error) {
                    console.error("Error cargando proyectos:", error);
                });
        }

        $(document).ready(function () {
            cargarProyectos();
        });

    </script>

@endsection
