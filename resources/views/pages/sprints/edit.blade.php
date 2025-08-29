@extends('layouts.layout.layout')

@section('content')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Editar Sprint: {{ $sprint->nombre }}</h4>
    </div>


<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <form action="{{ route('sprints.update', $sprint->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $sprint->nombre) }}">
            </div>
            <div class="mb-3">
                <label for="objetivo" class="form-label">Objetivo</label>
                <textarea class="form-control" id="objetivo" name="objetivo">{{ old('objetivo', $sprint->objetivo) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $sprint->fecha_inicio) }}">
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', $sprint->fecha_fin) }}">
            </div>
            <div class="mb-3">
                <label for="progreso" class="form-label">Progreso</label>
                <input type="text" class="form-control" id="progreso" name="progreso" value="{{ old('progreso', $sprint->progreso) }}">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-control" id="estado" name="estado">
                    <option value="planificado" {{ old('estado', $sprint->estado) == 'planificado' ? 'selected' : '' }}>Planificado</option>
                    <option value="activo" {{ old('estado', $sprint->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="completado" {{ old('estado', $sprint->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelado" {{ old('estado', $sprint->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_proyecto" class="form-label">ID del Proyecto</label>
                <input type="number" class="form-control" id="id_proyecto" name="id_proyecto" value="{{ old('id_proyecto', $sprint->id_proyecto) }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar Sprint</button>
            <a href="{{ route('sprints.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

@endsection