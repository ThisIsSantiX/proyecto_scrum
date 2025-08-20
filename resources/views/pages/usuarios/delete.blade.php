@extends('layouts.layout.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Eliminar Usuario</h4>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="alert alert-danger">
                <h5 class="alert-heading">¡Atención!</h5>
                <p>Vas a eliminar al usuario <strong>{{ $user->nombre }} {{ $user->apellido }}</strong>. Esta acción es irreversible.</p>
            </div>

            <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection