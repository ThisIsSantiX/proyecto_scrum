@extends('layouts.layout.layout')

@section('content')
<div class="container-fluid content-inner mt-5 pt-4 py-0">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    {{-- Mensaje de eliminación temporal --}}
    <div id="delete-alert" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        Rol Eliminado
        <button type="button" class="btn-close" onclick="hideAlert()"></button>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title">Lista De Roles</h4>
                    </div>
                    <div>
                        <input type="text" class="form-control form-control-sm" name="buscarRoles" id="buscarRoles" 
                            placeholder="Buscar Roles..." onkeyup="showRoles()">
                    </div>

                    <div>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#agregarRol">+ Agregar Rol</a>
                    </div>
                </div>
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Nombre De Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="roles-tbody">
                                {{-- Los roles se cargarán aquí mediante JavaScript --}}
                            </tbody>
                        </table>

                    <nav class="ms-4 mt-2" aria-label="Page navigation example">
                        <ul id="paginacionRoles" class="pagination pagination-sm">
                            {{-- Paginación generada dinámicamente --}}
                        </ul>
                    </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal agregar Rol --}}
    <div class="modal fade" id="agregarRol" tabindex="-1" aria-labelledby="agregarRol" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="agregarRol">Agregar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                         @csrf
                        <div class="mb-3">
                            <label class="form-label">Rol </label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado" required>
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal único para editar rol -->
<div class="modal fade" id="editRolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editRolForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="uid" id="Uid">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Rol</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
    
    function showRoles(pgn = null) {
        const baseUrl = "{{ route('showRoles') }}";
        const url = new URL(pgn ?? baseUrl);
         const termino = $('#buscarRoles').val(); 
            if (termino) {
                url.searchParams.set('search', termino);
            }
         axios.get(url.toString())
            .then(response => {
                
              const roles = response.data.data ?? response.data ?? [];
              const pgnLinks = response.data.links ?? [];

       
                const tabla = roles.map(rol => `
                    <tr>
                        <td>${rol.nombre}</td>
                        <td>
                            <span class="badge ${rol.estado ? 'bg-success' : 'bg-secondary'}">
                                ${rol.estado_texto ?? (rol.estado ? 'Activo' : 'Inactivo')}
                            </span>
                        </td>
                        <td>
                                  <div class="d-flex align-items-center gap-2">
                                    <a  href="#" class="btn btn-sm btn-icon btn-warning"  title="Editar" 
                                    onclick="openEditModal('${rol.uid}', '${rol.nombre}')">
                                        <span class="btn-inner">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" 
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" 
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" 
                                                    d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" 
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M15.1655 4.60254L19.7315 9.16854" 
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-icon btn-danger"
                                            title="Eliminar"
                                            onclick="deleteRoles('${rol.uid}', this)">
                                            <span class="btn-inner">
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" 
                                                    xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                    <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" 
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M20.708 6.23975H3.75" 
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" 
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                    </button>
                                </div>
                        </td>
                    </tr>
                `);

                $('#roles-tbody').html(tabla.length ? tabla : `
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="mb-0">No Hay Roles Registrados.</div>
                        </td>
                    </tr>
                `);

                // Paginación (solo si existen links)
                    const paginacion = pgnLinks.map(link => {
                        const label = link.label.includes('Previous') ? 'Anterior' :
                                    link.label.includes('Next') ? 'Siguiente' : link.label;

                        if (link.url === null) {
                            return `
                                <li class="page-item disabled">
                                    <span class="page-link">${label}</span>
                                </li>
                            `;
                        } else {
                            return `
                                <li class="page-item ${link.active ? 'active' : ''}">
                                    <a class="page-link" href="#" onclick="showRoles('${link.url}')">${label}</a>
                                </li>
                            `;
                        }
                    });

                    $("#paginacionRoles").html(paginacion);
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Error', 'No Se Pudieron Cargar Los Usuarios.', 'error');
                });
    }


 function openEditModal(uid, nombre) {
    // Asignar valores
    $('#Uid').val(uid);
    $('#nombre').val(nombre);

    // Actualizar action del form
    $('#editRolForm').attr('action', `/roles/${uid}`);

    // Abrir modal
    const modal = new bootstrap.Modal(document.getElementById('editRolModal'));
    modal.show();
}



    function deleteRoles(uid) {
        const isDark = document.body.classList.contains('dark');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            background: isDark ? '#1e1e2d' : '#fff',
            color: isDark ? '#fff' : '#000'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`{{ route('deleteRoles', ':uid') }}`.replace(':uid', uid), {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'El Rol Ha Sido Eliminado Correctamente.',
                                icon: 'success',
                                confirmButtonColor: '#198754',
                                background: isDark ? '#1e1e2d' : '#fff',
                                color: isDark ? '#fff' : '#000'
                            }).then(() => {
                                showRoles();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo Un Problema Al Eliminar el Rol.',
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
                            text: 'Ocurrió Un Error Al Eliminar El Rol.',
                            icon: 'error',
                            background: isDark ? '#1e1e2d' : '#fff',
                            color: isDark ? '#fff' : '#000'
                        });
                    });
            }
        });
    }


    $(document).ready(function() {
        showRoles();
    });
</script>
@endsection