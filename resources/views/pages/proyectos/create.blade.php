@extends('layouts.layout.layout')

@section('content')

<div class="container-fluid content-inner mt-5 py-0">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Añadir Proyecto</h4>
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

                    <form action="{{ route('proyectos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Descripción</label>
                                <input type="text" name="descripcion" class="form-control" required>
                            </div>

                            <!-- <div class="col-md-6">
                                <label class="form-label">Responsable</label>
                                <select name="id_owner" id="id_owner" class="form-select" required>
                                    <option value="">Seleccione un responsable...</option>
                                </select>
                            </div> -->

                            <div class="col-md-6">
                                <label class="form-label">Visibilidad</label>
                                <select name="visibilidad" class="form-select" required>
                                    <option value=""> Seleccione una visibilidad...</option>
                                    <option value="Privado">Privado</option>
                                    <option value="Publico">Publico</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Progreso (%)</label>
                                <input type="number" name="progreso" class="form-control" min="0" max="100" value="">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="datetime-local" name="fecha_inicio" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha Fin</label>
                                <input type="datetime-local" name="fecha_fin" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estado</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="">Seleccione Estado...</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
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