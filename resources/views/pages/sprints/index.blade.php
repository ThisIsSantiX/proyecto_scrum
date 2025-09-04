@extends('layouts.layout.layout')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Listado de Sprints</h4>
        <a href="{{ route('sprints.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Crear Nuevo Sprint
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Objetivo</th>
                <th>Progreso</th>
                <th>Estado</th>
                <th>Proyecto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sprints as $sprint)
            <tr>
                <td>{{ $sprint->id }}</td>
                <td>{{ $sprint->nombre }}</td>
                <td>{{ $sprint->objetivo }}</td>
                <td>{{ $sprint->progreso }}</td>
                <td>{{ $sprint->estado_texto }}</td>
                <td>{{ $sprint->id_proyecto }}</td> {{-- O el nombre del proyecto si tienes la relación --}}
                <td>
                    <a href="{{ route('sprints.show', $sprint->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('sprints.edit', $sprint->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                        data-sprint-id="{{ $sprint->id }}">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres eliminar este sprint? Esta acción es irreversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        // Botón que activó la modal
        var button = event.relatedTarget;
        
        // Extrae el ID del sprint del atributo 'data-sprint-id'
        var sprintId = button.getAttribute('data-sprint-id');
        
        // Obtiene el formulario de la modal
        var form = deleteModal.querySelector('#deleteForm');
        
        // Actualiza la acción del formulario con la ruta correcta
        form.action = '/sprints/' + sprintId;
    });
</script>
@endpush
@endsection