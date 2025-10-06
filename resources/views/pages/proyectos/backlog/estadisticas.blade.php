
<style>

/* Tarjetas de métricas */
.metric-card {
    border-radius: 12px;
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.metric-card .icon-box {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    opacity: 0.15;
}

.metric-card .icon-box.primary {
    color: var(--bs-primary);
}

.metric-card .icon-box.success {
    color: var(--bs-success);
}

.metric-card .icon-box.warning {
    color: var(--bs-warning);
}

.metric-card .metric-value {
    font-size: 32px;
    font-weight: 700;
    margin: 10px 0 5px;
}

.metric-card .metric-label {
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.7;
}

.metric-card .metric-info {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid var(--bs-border-color);
    font-size: 13px;
    opacity: 0.8;
}

/* Gráficos */
.chart-container {
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--bs-border-color);
}

.chart-header h5 {
    margin: 0;
    font-weight: 600;
}

.chart-header .badge {
    font-size: 12px;
    padding: 6px 12px;
}

/* Lista de historias */
.stats-historia-item {
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 12px;
    border-left: 4px solid var(--bs-primary);
    transition: all 0.3s ease;
}


.stats-historia-item.prioridad-alta {
    border-left-color: var(--bs-danger);
}

.stats-historia-item.prioridad-media {
    border-left-color: var(--bs-warning);
}

.stats-historia-item.prioridad-baja {
    border-left-color: var(--bs-info);
}

.stats-historia-titulo {
    font-weight: 600;
    margin-bottom: 5px;
}

.stats-historia-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 10px;
    font-size: 13px;
    opacity: 0.8;
}

.stats-historia-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Progress personalizado */
.custom-progress {
    height: 8px;
    border-radius: 10px;
    background: var(--bs-border-color);
    overflow: hidden;
}

.custom-progress-bar {
    height: 100%;
    border-radius: 10px;
    transition: width 0.6s ease;
}

/* Tabla de detalles */
.table-estadisticas {
    border-radius: 8px;
    overflow: hidden;
}

.table-estadisticas th {
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.7;
}

.table-estadisticas tbody tr {
    transition: background 0.2s ease;
}

/* Badges personalizados */
.badge-progreso {
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 12px;
    border: 1px solid;
}

.badge-por-hacer {
    background: rgba(108, 117, 125, 0.15);
    color: #6c757d !important;
    border-color: rgba(108, 117, 125, 0.3);
}

.badge-en-progreso {
    background: rgba(13, 110, 253, 0.15);
    color: #0d6efd !important;
    border-color: rgba(13, 110, 253, 0.3);
}

.badge-en-revision {
    background: rgba(255, 193, 7, 0.15);
    color: #856404 !important; /* Color oscuro para modo claro */
    border-color: rgba(255, 193, 7, 0.3);
}

.badge-terminado {
    background: rgba(25, 135, 84, 0.15);
    color: #198754 !important;
    border-color: rgba(25, 135, 84, 0.3);
}

/* Estilos para MODO OSCURO */
[data-bs-theme="dark"] .badge-por-hacer,
.dark .badge-por-hacer,
body.dark .badge-por-hacer {
    color: #adb5bd !important;
}

[data-bs-theme="dark"] .badge-en-progreso,
.dark .badge-en-progreso,
body.dark .badge-en-progreso {
    color: #6ea8fe !important;
}

[data-bs-theme="dark"] .badge-en-revision,
.dark .badge-en-revision,
body.dark .badge-en-revision {
    color: #ffda6a !important; /* Amarillo más claro para modo oscuro */
}

[data-bs-theme="dark"] .badge-terminado,
.dark .badge-terminado,
body.dark .badge-terminado {
    color: #75b798 !important;
}order-color: var(--bs-success);
}

/* Responsive */
@media (max-width: 768px) {
    .metric-card .metric-value {
        font-size: 24px;
    }
    
    .chart-container {
        padding: 15px;
    }
}
    </style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    
function verificarYCargarEstadisticas(proyectoUid, forzarRecarga = false) {
    // Si ya está cargado y no es recarga forzada, no hacer nada
    if (estadisticasCargadas && !forzarRecarga) {
        return;
    }

    axios.get(`/proyectos/${proyectoUid}/sprints/activo`)
        .then(response => {
            if (response.data.success && response.data.sprint) {
                cargarVistaEstadisticas(proyectoUid, response.data.sprint);
                estadisticasCargadas = true;
            }
        })
        .catch(error => {
            console.error('Error al verificar sprint:', error);
        });
}

// En el evento del botón refresh
document.getElementById('btnRefreshStats')?.addEventListener('click', () => {
    const proyectoUid = document.querySelector('input[name="proyecto_uid"]')?.value;
    if (proyectoUid) {
        verificarYCargarEstadisticas(proyectoUid, true); // Forzar recarga
    }
});

function cargarVistaEstadisticas(proyectoUid, sprint) {
    // Reemplazar contenido
    document.getElementById('estadisticas').innerHTML = `
        <!-- Header con información del sprint -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>
                    Estadísticas del Sprint
                </h3>
                <p class="text-muted mb-0" id="sprintNombre">Cargando...</p>
            </div>
            <button class="btn btn-outline-primary" id="btnRefreshStats">
                <i class="fas fa-sync-alt me-2"></i>Actualizar
            </button>
        </div>

        <!-- Tarjetas de métricas principales -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="metric-card card" style="animation-delay: 0.1s">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="metric-label">Total Historias</div>
                            <div class="metric-value" id="totalHistorias">0</div>
                        </div>
                        <div class="icon-box primary">
                            <i class="fas fa-list-alt"></i>
                        </div>
                    </div>
                    <div class="metric-info">
                        <i class="fas fa-info-circle me-1"></i>
                        <span>En este sprint</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="metric-card card" style="animation-delay: 0.2s">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="metric-label">Completadas</div>
                            <div class="metric-value text-success" id="historiasCompletadas">0</div>
                        </div>
                        <div class="icon-box success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="metric-info">
                        <div class="custom-progress">
                            <div class="custom-progress-bar bg-success" id="progresoCompletadas" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="metric-card card" style="animation-delay: 0.3s">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="metric-label">En Progreso</div>
                            <div class="metric-value text-warning" id="historiasEnProgreso">0</div>
                        </div>
                        <div class="icon-box warning">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                    <div class="metric-info">
                        <i class="fas fa-clock me-1"></i>
                        <span>Trabajando ahora</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="metric-card card" style="animation-delay: 0.4s">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="metric-label">Velocity</div>
                            <div class="metric-value text-primary" id="velocitySprint">0</div>
                        </div>
                        <div class="icon-box primary">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                    </div>
                    <div class="metric-info">
                        <i class="fas fa-fire me-1"></i>
                        <span>Puntos de historia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="chart-container card">
                    <div class="chart-header">
                        <h5><i class="fas fa-chart-area me-2 text-primary"></i>Burndown Chart</h5>
                        <span class="badge bg-primary" id="diasRestantes">0 días restantes</span>
                    </div>
                    <canvas id="burndownChart" height="80"></canvas>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="chart-container card">
                    <div class="chart-header">
                        <h5><i class="fas fa-chart-pie me-2 text-success"></i>Por Estado</h5>
                    </div>
                    <canvas id="estadoChart"></canvas>
                    <div id="estadoLeyenda" class="mt-3"></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="chart-container card">
                    <div class="chart-header">
                        <h5><i class="fas fa-flag me-2 text-danger"></i>Distribución por Prioridad</h5>
                    </div>
                    <canvas id="prioridadChart" height="60"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-container card">
                    <div class="chart-header">
                        <h5><i class="fas fa-fire me-2 text-warning"></i>Velocity por Día</h5>
                    </div>
                    <canvas id="velocityChart" height="60"></canvas>
                </div>
            </div>
        </div>

        <!-- Lista de Historias -->
        <div class="chart-container card">
            <div class="chart-header">
                <h5><i class="fas fa-tasks me-2 text-info"></i>Historias del Sprint</h5>
            </div>
            <div id="historiasLista" class="mb-3"></div>
        </div>

        <!-- Tabla detallada -->
        <div class="chart-container card">
            <div class="chart-header">
                <h5><i class="fas fa-table me-2"></i>Detalles de Historias</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-estadisticas table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th class="text-center">Puntos</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDatosHistorias">
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `;

    // Inicializar funcionalidad
    inicializarEstadisticas(proyectoUid, sprint);
}

let chartsEstadisticas = {};

function inicializarEstadisticas(proyectoUid, sprint) {
    // Cargar datos
    axios.get(`/proyectos/${proyectoUid}/sprints/${sprint.uid}/estadisticas`)
        .then(response => {
            if (response.data.success) {
                actualizarUIEstadisticas(response.data);
            }
        })
        .catch(error => {
            console.error('Error al cargar estadísticas:', error);
        });

    // Event listeners - IMPORTANTE: usar addEventListener en lugar de jQuery
    const btnRefresh = document.getElementById('btnRefreshStats');
    if (btnRefresh) {
        btnRefresh.addEventListener('click', () => {
            inicializarEstadisticas(proyectoUid, sprint);
        });
    }

    // Filtros - corregido para que funcione
    const filterButtons = document.querySelectorAll('.btn-group button[data-filter]');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover active de todos
            filterButtons.forEach(b => b.classList.remove('active'));
            // Agregar active al clickeado
            this.classList.add('active');
            // Filtrar
            filtrarHistorias(this.dataset.filter);
        });
    });
}

function filtrarHistorias(filtro) {
    const items = document.querySelectorAll('.stats-historia-item');
    items.forEach(item => {
        if (filtro === 'all') {
            item.style.display = 'block';
        } else {
            if (item.dataset.estado === filtro) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        }
    });
}

function actualizarUIEstadisticas(data) {
    // Header
    document.getElementById('sprintNombre').textContent = 
        `${data.sprint.nombre} - ${formatearFecha(data.sprint.fecha_inicio)} al ${formatearFecha(data.sprint.fecha_fin)}`;

    // Métricas
    animarValor('totalHistorias', 0, data.total_historias, 800);
    animarValor('historiasCompletadas', 0, data.historias_completadas, 800);
    animarValor('historiasEnProgreso', 0, data.historias_en_progreso, 800);
    animarValor('velocitySprint', 0, data.velocity, 800);

    // Progreso
    const porcentaje = data.total_historias > 0 
        ? ((data.historias_completadas / data.total_historias) * 100).toFixed(1) 
        : 0;
    document.getElementById('progresoCompletadas').style.width = `${porcentaje}%`;

    // Días restantes
    const diasRestantes = calcularDiasRestantes(data.sprint.fecha_fin);
    document.getElementById('diasRestantes').textContent = `${diasRestantes} días restantes`;

    // Gráficos
    crearBurndownChart(data.burndown);
    crearEstadoChart(data.por_estado);
    crearPrioridadChart(data.por_prioridad);
    crearVelocityChart(data.velocity_diario);

    // Lista y tabla
    renderizarListaHistorias(data.historias);
    renderizarTablaHistorias(data.historias);
}

function animarValor(id, inicio, fin, duracion) {
    const elemento = document.getElementById(id);
    if (!elemento) return;

    const rango = fin - inicio;
    const incremento = rango / (duracion / 16);
    let actual = inicio;

    const timer = setInterval(() => {
        actual += incremento;
        if ((incremento > 0 && actual >= fin) || (incremento < 0 && actual <= fin)) {
            actual = fin;
            clearInterval(timer);
        }
        elemento.textContent = Math.round(actual);
    }, 16);
}

function crearBurndownChart(burndownData) {
    if (chartsEstadisticas.burndown) {
        chartsEstadisticas.burndown.destroy();
    }

    const ctx = document.getElementById('burndownChart').getContext('2d');
    const realArray = Array.isArray(burndownData.real) 
        ? burndownData.real 
        : Object.values(burndownData.real);

    chartsEstadisticas.burndown = new Chart(ctx, {
        type: 'line',
        data: {
            labels: burndownData.labels || [],
            datasets: [
                {
                    label: 'Ideal',
                    data: burndownData.ideal || [],
                    borderColor: 'rgba(108, 117, 125, 0.5)',
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.1,
                    pointRadius: 3
                },
                {
                    label: 'Real',
                    data: realArray,
                    borderColor: 'rgb(13, 110, 253)',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Puntos Restantes' }
                }
            }
        }
    });
}

function crearEstadoChart(estadoData) {
    if (chartsEstadisticas.estado) {
        chartsEstadisticas.estado.destroy();
    }

    const ctx = document.getElementById('estadoChart').getContext('2d');
    const colores = {
        'Por hacer': 'rgba(108, 117, 125, 0.8)',
        'En progreso': 'rgba(13, 110, 253, 0.8)',
        'En revision': 'rgba(255, 193, 7, 0.8)',
        'Terminado': 'rgba(25, 135, 84, 0.8)'
    };

    chartsEstadisticas.estado = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(estadoData),
            datasets: [{
                data: Object.values(estadoData),
                backgroundColor: Object.keys(estadoData).map(key => colores[key]),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            cutout: '65%'
        }
    });

    actualizarLeyendaEstado(estadoData);
}

function actualizarLeyendaEstado(estadoData) {
    const colores = {
        'Por hacer': 'secondary',
        'En progreso': 'primary',
        'En revision': 'warning',
        'Terminado': 'success'
    };

    const html = Object.entries(estadoData).map(([estado, cantidad]) => `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span><i class="fas fa-circle text-${colores[estado]} me-2"></i>${estado}</span>
            <strong>${cantidad}</strong>
        </div>
    `).join('');

    document.getElementById('estadoLeyenda').innerHTML = html;
}

function crearPrioridadChart(prioridadData) {
    if (chartsEstadisticas.prioridad) {
        chartsEstadisticas.prioridad.destroy();
    }

    const ctx = document.getElementById('prioridadChart').getContext('2d');
    chartsEstadisticas.prioridad = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(prioridadData),
            datasets: [{
                label: 'Historias',
                data: Object.values(prioridadData),
                backgroundColor: [
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(13, 202, 240, 0.7)'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
}

function crearVelocityChart(velocityData) {
    if (chartsEstadisticas.velocity) {
        chartsEstadisticas.velocity.destroy();
    }

    const ctx = document.getElementById('velocityChart').getContext('2d');
    chartsEstadisticas.velocity = new Chart(ctx, {
        type: 'line',
        data: {
            labels: velocityData.labels || [],
            datasets: [{
                label: 'Puntos Completados',
                data: velocityData.valores || [],
                borderColor: 'rgb(255, 193, 7)',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Puntos' } }
            }
        }
    });
}

function renderizarListaHistorias(historias) {
    const html = historias.map(historia => {
        // Asegurarse de que prioridad sea string
        const prioridad = historia.prioridad ? historia.prioridad.toLowerCase() : 'sin-prioridad';
        const prioridadClass = `prioridad-${prioridad}`;

        return `
            <div class="stats-historia-item ${prioridadClass}" data-estado="${historia.progreso}">
                <div class="stats-historia-titulo">${historia.titulo || 'Sin título'}</div>
                <p class="text-muted mb-2 small">${historia.descripcion || 'Sin descripción'}</p>
                <div class="stats-historia-meta">
                    <span>${getBadgePrioridad(historia.prioridad)}</span>
                    <span>${getBadgeProgreso(historia.progreso)}</span>
                    <span><i class="fas fa-fire text-warning"></i> ${historia.valor_historia || 0} puntos</span>
                </div>
            </div>
        `;
    }).join('') || '<p class="text-muted text-center py-4">No hay historias en este sprint</p>';

    document.getElementById('historiasLista').innerHTML = html;
}


function renderizarTablaHistorias(historias) {
    const tbody = historias.map(historia => `
        <tr>
            <td><strong>${historia.titulo}</strong></td>
            <td>${getBadgePrioridad(historia.prioridad)}</td>
            <td>${getBadgeProgreso(historia.progreso)}</td>
            <td class="text-center"><span class="badge bg-primary">${historia.valor_historia || 'No asignados'}</span></td>
            <td class="text-truncate" style="max-width: 200px;">${historia.descripcion || 'Sin descripción'}</td>
        </tr>
    `).join('') || '<tr><td colspan="5" class="text-center text-muted py-4">No hay historias disponibles</td></tr>';

    document.getElementById('tablaDatosHistorias').innerHTML = tbody;
}

function filtrarHistorias(filtro) {
    const items = document.querySelectorAll('.historia-item');
    items.forEach(item => {
        if (filtro === 'all' || item.dataset.estado === filtro) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function getBadgeProgreso(progreso) {
    const badges = {
        'Por hacer': '<span class="badge badge-progreso badge-por-hacer"><i class="fas fa-circle me-1"></i>Por hacer</span>',
        'En progreso': '<span class="badge badge-progreso badge-en-progreso"><i class="fas fa-spinner me-1"></i>En progreso</span>',
        'En revision': '<span class="badge badge-progreso badge-en-revision"><i class="fas fa-eye me-1"></i>En revisión</span>',
        'Terminado': '<span class="badge badge-progreso badge-terminado"><i class="fas fa-check-circle me-1"></i>Terminado</span>'
    };
    return badges[progreso] || badges['Por hacer'];
}

function getBadgePrioridad(prioridad) {
    const badges = {
        'Alta': '<span class="badge bg-danger"><i class="fas fa-flag me-1"></i>Alta</span>',
        'Media': '<span class="badge bg-warning text-dark"><i class="fas fa-flag me-1"></i>Media</span>',
        'Baja': '<span class="badge bg-info"><i class="fas fa-flag me-1"></i>Baja</span>'
    };
    return badges[prioridad] || badges['Media'];
}

function formatearFecha(fecha) {
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

function calcularDiasRestantes(fechaFin) {
    const hoy = new Date();
    const fin = new Date(fechaFin);
    const diferencia = Math.ceil((fin - hoy) / (1000 * 60 * 60 * 24));
    return diferencia >= 0 ? diferencia : 0;
}
</script>
