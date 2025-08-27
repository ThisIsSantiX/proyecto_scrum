@extends('layouts.layout.layout')

@section('content')

<div class="container-fluid content-inner pt-4 mt-5 py-0">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Añadir Rol</h4>
                </div>
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

                    <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label">Roles</label>
                                <select name="nombre" id="nombre" class="form-select">
                                    <option value="">Seleccione Un Rol...</option>
                                    <option value="Scrum master">Scrum master</option>
                                    <option value="Scrum team">Scrum team</option>
                                    <option value="Product owner">Product owner</option>
                                    <option value="Usuario">Usuario</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="">Seleccione Un Estado...</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                       <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-save me-2" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 0-2 2v1H2.5A1.5 1.5 0 0 0 1 5.5v8A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 13.5 4H10V3a2 2 0 0 0-2-2zM2 5h12v8.5a.5.5 0 0 1-.5.5H2.5a.5.5 0 0 1-.5-.5V5zm5-2a1 1 0 0 1 2 0v1H7V3z"/>
                                </svg>
                                Guardar
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection

@section('js')
    
<script>
    
</script>

@endsection