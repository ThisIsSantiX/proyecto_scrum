@extends('layouts.layout.layout')

@section('content')
<div class="container-fluid content-inner mt-5 pt-4 py-0">

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title">Lista de Usuarios</h4>
                    </div>

                    <div>
                        <input type="text" class="form-control form-control-sm" name="buscarUsuario" id="buscarUsuario" 
                            placeholder="Buscar usuario..." onkeyup="showUsuarios()">
                    </div>

                    <div>
                        <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary">+ Agregar Usuario</a>
                    </div>
                </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th style="min-width: 120px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="usuarios-tbody">
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="mb-0">Cargando usuarios...</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <nav class="ms-4 mt-2" aria-label="Page navigation example">
                        <ul id="paginacionUsuarios" class="pagination pagination-sm">
                            {{-- Paginación generada dinámicamente --}}
                        </ul>
                    </nav>
                </div>
            </div>
            </div>
        </div>
    </div>


</div>


@endsection

@section('js')
    <script>

        function showUsuarios(pgn = null) {
            const baseUrl = "{{ route('showUsuarios') }}";
            const url = new URL(pgn ?? baseUrl);
            const termino = $('#buscarUsuario').val(); 
            if (termino) {
                url.searchParams.set('search', termino);
            }

            axios.get(url.toString())
                .then(response => {
                    const usuarios = response.data.data;
                    const pgnLinks = response.data.links;

                    const tabla = usuarios.map(user => `
                        <tr>
                           <!-- Foto -->
                            <td class="text-center">
                                <img src="${user.foto_url.startsWith('http') 
                                            ? user.foto_url 
                                            : `/storage/${user.foto_url}`}" 
                                    alt="foto" 
                                    class="bg-soft-primary rounded img-fluid avatar-40"
                                    style="cursor: pointer"
                                    onclick="verFoto('${user.foto_url.startsWith('http') ? user.foto_url : `/storage/${user.foto_url}`}')">
                            </td>


                            <!-- Nombre -->
                            <td>${user.nombre} ${user.apellido}</td>

                            <!-- Email -->
                            <td>${user.email}</td>

                            <!-- Rol -->
                            <td><span class="badge bg-info text-dark">${user.rol_texto ?? 'Sin rol'}</span></td>

                            <!-- Estado -->
                            <td>
                                <span class="badge ${user.estado ? 'bg-success' : 'bg-secondary'}">
                                    ${user.estado_texto ?? (user.estado ? 'Activo' : 'Inactivo')}
                                </span>
                            </td>

                            <!-- Acciones -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a class="btn btn-sm btn-icon btn-warning" title="Editar"
                                    href="/usuarios/edit/${user.uid}">  
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
                                            onclick="deleteUsuario('${user.uid}', this)">
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

                    $('#usuarios-tbody').html(tabla.length ? tabla : `
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="mb-0">No hay usuarios registrados.</div>
                            </td>
                        </tr>
                    `);

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
                                    <a class="page-link" href="#" onclick="showUsuarios('${link.url}')">${label}</a>
                                </li>
                            `;
                        }
                    });

                    $("#paginacionUsuarios").html(paginacion);
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Error', 'No se pudieron cargar los usuarios.', 'error');
                });
        }

        function deleteUsuario(uid) {
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
                    axios.delete(`{{ route('deleteUsuario', ':uid') }}`.replace(':uid', uid), {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'El usuario ha sido eliminado correctamente.',
                                icon: 'success',
                                confirmButtonColor: '#198754',
                                background: isDark ? '#1e1e2d' : '#fff',
                                color: isDark ? '#fff' : '#000'
                            }).then(() => {
                                showUsuarios();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al eliminar el usuario.',
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
                            text: 'Ocurrió un error al eliminar el usuario.',
                            icon: 'error',
                            background: isDark ? '#1e1e2d' : '#fff',
                            color: isDark ? '#fff' : '#000'
                        });
                    });
                }
            });
        }


        $(document).ready(function() {
            showUsuarios();
        });


        function verFoto(url) {
            Swal.fire({
                imageUrl: url,
                imageAlt: 'Foto de perfil',
                showCloseButton: true,
                showConfirmButton: false,
                width: '30%',
                high: '50%',
                background: '#000000ff'
            });
        }

        

        
    </script>
@endsection