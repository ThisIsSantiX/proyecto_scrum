@extends('layouts.layout.layout')

@section('content')
<div class="container-fluid py-4">

    {{-- Mensaje de eliminación temporal --}}
    <div id="delete-alert" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        Usuario Eliminado
        <button type="button" class="btn-close" onclick="hideAlert()"></button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Usuarios</h4>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo Usuario
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($users as $user)
        <div class="col">
            <div class="card shadow-sm h-100 border-0 rounded-3">
                <div class="card-body text-center">
                    {{-- Foto --}}
                    @if($user->foto_url)
                        <img src="{{ asset('storage/' . $user->foto_url) }}" alt="foto" class="rounded-circle mb-3" width="80" height="80">
                    @else
                        <div class="bg-secondary rounded-circle mb-3" style="width:80px; height:80px; line-height:80px; color:white;">
                            Sin foto
                        </div>
                    @endif

                    {{-- Nombre y correo --}}
                    
                    <h5 class="card-title mb-1">{{ $user->nombre }} {{ $user->apellido }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>

                    {{-- Rol y Estado --}}
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-info text-dark">{{ $user->rol_texto }}</span>
                        <span class="badge {{ $user->estado ? 'bg-success' : 'bg-secondary' }}">
                            {{ $user->estado_texto }}
                        </span>
                    </div>

                    {{-- Acciones --}}
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger" 
                            onclick="deleteUser('{{ $user->id }}', this)">
                            <i class="bi bi-trash"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">No hay usuarios registrados.</div>
        </div>
        @endforelse
    </div>
</div>

<script>

function deleteUser(userId, btn) {
    if(!confirm('¿Deseas eliminar este usuario permanentemente?')) return;

    fetch(`/usuarios/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            const cardCol = btn.closest('.col'); // busca el contenedor de la tarjeta
            if (cardCol) cardCol.remove(); // elimina del DOM
            showAlert();
        } else {
            alert('No se pudo eliminar el usuario.');
        }
    })
    .catch(error => console.error(error));
}
function showAlert() {
    const alert = document.getElementById('delete-alert');
    alert.classList.remove('d-none');
}
</script>

@endsection