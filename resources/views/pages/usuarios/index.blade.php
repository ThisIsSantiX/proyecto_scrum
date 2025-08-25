@extends('layouts.layout.layout')

@section('content')
<div class="conatiner-fluid content-inner mt-5 pt-4 py-0">

    {{-- Mensaje de eliminación temporal --}}
    <div id="delete-alert" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        Usuario Eliminado
        <button type="button" class="btn-close" onclick="hideAlert()"></button>
    </div>

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
                                    class="bg-soft-primary rounded img-fluid avatar-40">
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
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-icon btn-danger"
                                            title="Eliminar"
                                            onclick="deleteUsuario('${user.uid}', this)">
                                        <i class="bi bi-trash"></i>
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

    </script>
@endsection