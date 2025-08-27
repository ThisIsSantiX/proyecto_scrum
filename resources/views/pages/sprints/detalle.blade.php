@extends('layouts.layout.layout')

@section('content')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detalles del Sprint: {{ $sprint->nombre }}</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $sprint->nombre }}</h5>
            <p class="card-text"><strong>ID:</strong> {{ $sprint->id }}</p>
            <p class="card-text"><strong>UID:</strong> {{ $sprint->uid }}</p>
            <p class="card-text"><strong>Objetivo:</strong> {{ $sprint->objetivo }}</p>
            <p class="card-text"><strong>Fecha de Inicio:</strong> {{ $sprint->fecha_inicio }}</p>
            <p class="card-text"><strong>Fecha de Fin:</strong> {{ $sprint->fecha_fin }}</p>
            <p class="card-text"><strong>Progreso:</strong> {{ $sprint->progreso }}</p>
            <p class="card-text"><strong>Estado:</strong> {{ $sprint->estado }}</p>
            <p class="card-text"><strong>ID del Proyecto:</strong> {{ $sprint->id_proyecto }}</p>
        </div>
    </div>
    <a href="{{ route('sprints.index') }}" class="btn btn-primary mt-3">Volver al Listado</a>

@endsection