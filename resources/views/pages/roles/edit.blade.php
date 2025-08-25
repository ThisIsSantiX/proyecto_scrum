                    <div class="modal fade" id="editRoleModal{{ $rol->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel{{ $rol->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel{{ $rol->id }}">Editar Rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ route('roles.update', $rol->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select" required>
                                        <option value="1" {{ $rol->estado == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ $rol->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>