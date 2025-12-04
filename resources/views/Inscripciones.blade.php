@extends('welcome')

@section('title', 'Inscripciones')
@section('content')
<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo Inscripciones</h3>
            <hr>

            <!-- BOTÓN NUEVO -->
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                    <i class="fa-solid fa-plus"></i> Nueva Inscripción
                </button>
            </div>

            <!-- BUSCADOR -->
            <form action="{{ route('inscripciones.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por torneo, usuario o estado">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ route('inscripciones.index') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            <!-- TABLA -->
            @if($inscripciones->count() > 0)
                <table class="table table-striped table-hover table-bordered text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Torneo</th>
                            <th>Fecha Inscripción</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($inscripciones as $inscripcion)
                        <tr>
                            <td>{{ $inscripcion->id_inscripcion }}</td>

                            <!-- USUARIO -->
                            <td>
                                @if($inscripcion->usuario)
                                    {{ $inscripcion->usuario->nombre }} {{ $inscripcion->usuario->apellido }}
                                @else
                                    <span class="text-danger">Usuario no encontrado</span>
                                @endif
                            </td>

                            <!-- TORNEO -->
                            <td>
                                @if($inscripcion->torneo)
                                    {{ $inscripcion->torneo->nombre_torneo }}
                                @else
                                    <span class="text-danger">Torneo no encontrado</span>
                                @endif
                            </td>

                            <!-- FECHA -->
                            <td>{{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}</td>

                            <!-- ESTADO -->
                            <td>
                                <span class="badge 
                                    @if($inscripcion->estado == 'Inscrito') bg-success
                                    @elseif($inscripcion->estado == 'Participando') bg-primary
                                    @elseif($inscripcion->estado == 'Finalizado') bg-info
                                    @else bg-secondary @endif">
                                    {{ $inscripcion->estado }}
                                </span>
                            </td>

                            <!-- OBSERVACIONES -->
                            <td>{{ $inscripcion->observaciones ? Str::limit($inscripcion->observaciones, 30) : 'Sin observaciones' }}</td>

                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- EDITAR -->
                                    <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editarModal{{ $inscripcion->id_inscripcion }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- ELIMINAR -->
                                    <form action="{{ route('inscripciones.destroy', $inscripcion->id_inscripcion) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta inscripción?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $inscripcion->id_inscripcion }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('inscripciones.update', $inscripcion->id_inscripcion) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Inscripción</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Usuario</label>
                                                    <input type="text" class="form-control" value="{{ $inscripcion->usuario->nombre ?? '' }} {{ $inscripcion->usuario->apellido ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Torneo</label>
                                                    <input type="text" class="form-control" value="{{ $inscripcion->torneo->nombre_torneo ?? '' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Fecha Inscripción</label>
                                                    <input type="date" name="fecha_inscripcion" class="form-control" value="{{ $inscripcion->fecha_inscripcion }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Estado</label>
                                                    <select name="estado" class="form-control">
                                                        <option value="Inscrito"      {{ $inscripcion->estado == 'Inscrito' ? 'selected' : '' }}>Inscrito</option>
                                                        <option value="Participando" {{ $inscripcion->estado == 'Participando' ? 'selected' : '' }}>Participando</option>
                                                        <option value="Finalizado"   {{ $inscripcion->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                                        <option value="Retirado"     {{ $inscripcion->estado == 'Retirado' ? 'selected' : '' }}>Retirado</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="form-label">Observaciones</label>
                                                <textarea name="observaciones" class="form-control" rows="3">{{ $inscripcion->observaciones }}</textarea>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $inscripciones->links() }}
                </div>

            @else
                <p class="text-center mt-3">No se encontraron Inscripciones.</p>
            @endif
        </div>


        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="{{ route('inscripciones.store') }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user-plus"></i> Crear Inscripción</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Usuario *</label>
                                    <select name="id_usuario" class="form-control" required>
                                        <option value="">Seleccione un usuario</option>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id_usuario }}">
                                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Torneo *</label>
                                    <select name="id_torneo" class="form-control" required>
                                        <option value="">Seleccione un torneo</option>
                                        @foreach($torneos as $torneo)
                                            <option value="{{ $torneo->id_torneo }}">
                                                {{ $torneo->nombre_torneo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Inscripción *</label>
                                    <input type="date" name="fecha_inscripcion" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estado *</label>
                                    <select name="estado" class="form-control">
                                        <option value="Inscrito">Inscrito</option>
                                        <option value="Participando">Participando</option>
                                        <option value="Finalizado">Finalizado</option>
                                        <option value="Retirado">Retirado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="3"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
