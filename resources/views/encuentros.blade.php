@extends('welcome')

@section('title', 'Encuentros')
@section('content')

<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1300px;">
        <div class="card-body">
            <h3>Módulo Encuentros</h3>
            <hr>

            <!-- BOTÓN NUEVO -->
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                    <i class="fa-solid fa-plus"></i> Nuevo
                </button>
            </div>

            <!-- BUSCAR -->
            <form action="{{ route('encuentros.index') }}" method="GET">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por torneo, fecha o equipos">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ route('encuentros.index') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            <!-- TABLA -->
            @if($datos->count() > 0)
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Torneo</th>
                        <th>Lugar</th>
                        <th>Árbitro</th>
                        <th>Local</th>
                        <th>Visitante</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datos as $d)
                    <tr>
                        <td>{{ $d->id_encuentro }}</td>
                        <td>{{ optional($d->fecha)->fecha ?? 'N/A' }}</td>
                        <td>{{ $d->hora }}</td>
                        <td>{{ optional($d->torneo)->nombre_torneo ?? 'N/A' }}</td>
                        <td>{{ optional($d->lugar)->nombre_lugar ?? 'N/A' }}</td>
                        <td>{{ $d->arbitro ? $d->arbitro->id_usuario : 'Sin árbitro' }}</td>
                        <td>{{ optional($d->equipoLocal)->nombre_equipo ?? 'N/A' }}</td>
                        <td>{{ optional($d->equipoVisitante)->nombre_equipo ?? 'N/A' }}</td>
                        <td>{{ $d->estado }}</td>
                        <td>
                            <!-- EDITAR -->
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal{{ $d->id_encuentro }}">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </button>

                            <!-- ELIMINAR -->
                            <form action="{{ route('encuentros.destroy', $d->id_encuentro) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro desea eliminar este encuentro?')">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- MODAL EDITAR -->
                    <div class="modal fade" id="editarModal{{ $d->id_encuentro }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('encuentros.update', $d->id_encuentro) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Encuentro</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Fecha:</label>
                                                <select name="id_fecha" class="form-select" required>
                                                    @foreach($fechas as $f)
                                                        <option value="{{ $f->id_fecha }}" {{ $f->id_fecha == $d->id_fecha ? 'selected' : '' }}>{{ $f->fecha }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Hora:</label>
                                                <input type="time" name="hora" class="form-control" value="{{ $d->hora }}" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Torneo:</label>
                                                <select name="id_torneo" class="form-select" required>
                                                    @foreach($torneos as $t)
                                                        <option value="{{ $t->id_torneo }}" {{ $t->id_torneo == $d->id_torneo ? 'selected' : '' }}>{{ $t->nombre_torneo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Lugar:</label>
                                                <select name="id_lugar" class="form-select" required>
                                                    @foreach($lugares as $l)
                                                        <option value="{{ $l->id_lugar }}" {{ $l->id_lugar == $d->id_lugar ? 'selected' : '' }}>{{ $l->nombre_lugar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Árbitro:</label>
                                                <select name="id_arbitro" class="form-select" required>
                                                    <option value="">Seleccione un árbitro</option>
                                                    @foreach($arbitros as $a)
                                                        <option value="{{ $a->id_arbitro }}" {{ $a->id_arbitro == $d->id_arbitro ? 'selected' : '' }}>
                                                            {{ $a->id_usuario }} ({{ $a->categoria_arbitral }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Equipo Local:</label>
                                                <select name="id_equipo_local" class="form-select" required>
                                                    @foreach($equipos as $e)
                                                        <option value="{{ $e->id_equipo }}" {{ $e->id_equipo == $d->id_equipo_local ? 'selected' : '' }}>{{ $e->nombre_equipo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Equipo Visitante:</label>
                                                <select name="id_equipo_visitante" class="form-select" required>
                                                    @foreach($equipos as $e)
                                                        <option value="{{ $e->id_equipo }}" {{ $e->id_equipo == $d->id_equipo_visitante ? 'selected' : '' }}>{{ $e->nombre_equipo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Estado:</label>
                                                <select name="estado" class="form-select" required>
                                                    <option value="Activo" {{ $d->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="Inactivo" {{ $d->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                </select>
                                            </div>
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

            {{ $datos->links() }}

            @else
                <p class="text-center mt-3">No se encontraron encuentros.</p>
            @endif
        </div>

        <!-- MODAL CREAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('encuentros.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Crear Encuentro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Fecha:</label>
                                    <select name="id_fecha" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($fechas as $f)
                                            <option value="{{ $f->id_fecha }}">{{ $f->fecha }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Hora:</label>
                                    <input type="time" name="hora" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Torneo:</label>
                                    <select name="id_torneo" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($torneos as $t)
                                            <option value="{{ $t->id_torneo }}">{{ $t->nombre_torneo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Lugar:</label>
                                    <select name="id_lugar" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($lugares as $l)
                                            <option value="{{ $l->id_lugar }}">{{ $l->nombre_lugar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Árbitro:</label>
                                    <select name="id_arbitro" class="form-select" required>
                                        <option value="">Seleccione un árbitro</option>
                                        @foreach($arbitros as $a)
                                            <option value="{{ $a->id_arbitro }}">{{ $a->id_usuario }} ({{ $a->categoria_arbitral }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Equipo Local:</label>
                                    <select name="id_equipo_local" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($equipos as $e)
                                            <option value="{{ $e->id_equipo }}">{{ $e->nombre_equipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Equipo Visitante:</label>
                                    <select name="id_equipo_visitante" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($equipos as $e)
                                            <option value="{{ $e->id_equipo }}">{{ $e->nombre_equipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Estado:</label>
                                    <select name="estado" class="form-select" required>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
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
