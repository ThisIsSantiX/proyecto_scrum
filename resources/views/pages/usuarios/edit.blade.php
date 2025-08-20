@extends('layouts.layout.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Editar Usuario</h4>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $user->nombre }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" value="{{ $user->apellido }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contraseña (opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar vacío si no deseas cambiarla">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="activo" {{ $user->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $user->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Rol</label>
                        @php
                            $roles = [
                                1 => 'Admin',
                                2 => 'Usuario',
                                3 => 'Invitado'
                            ];
                        @endphp
                        <select name="id_rol" class="form-select" required>
                            @foreach($roles as $key => $role)
                                <option value="{{ $key }}" {{ $user->id_rol == $key ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Foto</label>
                        @if($user->foto_url)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->foto_url) }}" alt="Foto actual" width="70" class="rounded-circle border">
                            </div>
                        @endif
                        <input type="file" name="foto_url" class="form-control">
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection