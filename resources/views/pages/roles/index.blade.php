@extends('layouts.layout.layout')

@section('content')
<div class="conatiner-fluid content-inner mt-5 py-0">

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
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">+ Agregar Roles</a>
                </div>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                <table id="roles-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                    <thead>
                    <tr class="ligth">
                        <th>Rol</th>
                        <th>Estado</th>
                        <th style="min-width: 120px">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $rol)
                    <tr>
                    

                        {{-- Rol --}}
                        <td><span class="badge bg-info text-dark">{{ $rol->nombre ?? 'Sin rol' }}</span></td>

                        {{-- Estado --}}
                        <td>
                        <span class="badge {{ $rol->estado ? 'bg-success' : 'bg-secondary' }}">
                            {{ $rol->estado_texto ?? ($rol->estado ? 'Activo' : 'Inactivo') }}
                        </span>
                        </td>

                        {{-- Acciones --}}
                        <td>
                        <div class="d-flex gap-2">  
                            <!-- Editar -->
                            <a class="btn btn-sm btn-icon btn-warning"  data-bs-toggle="modal" 
                            data-bs-target="#editRoleModal{{ $rol->id }}" 
                            title="Editar">
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
                            <!-- Modal Editar Rol -->
                            @include('pages.roles.edit')

                            <!-- Eliminar -->
                            <button type="button" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Eliminar"
                                    onclick="deleteRoles('{{ $rol->uid }}', this)">
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
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                        <div class="alert alert-secondary mb-0">No Hay Roles Registrados.</div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>


</div>


@endsection

@section('js')
    <script>

            function deleteRoles(uid, button) {
                if(!confirm('¿Estás seguro de eliminar este rol?')) return;

                // Enviar petición DELETE
                axios.delete('/roles/' + uid)
                    .then(response => {
                        // Mostrar alerta temporal
                        const alertDiv = document.getElementById('delete-alert');
                        alertDiv.classList.remove('d-none');
                        
                        // Ocultar fila de la tabla
                        const row = button.closest('tr');
                        row.remove();

                        // Opcional: ocultar alerta después de 3 segundos
                        setTimeout(() => {
                            alertDiv.classList.add('d-none');
                        }, 3000);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('No se pudo eliminar el rol.');
                    });
            }
            function hideAlert() {
                const alertDiv = document.getElementById('delete-alert');
                alertDiv.classList.add('d-none');
            }

    </script>
@endsection