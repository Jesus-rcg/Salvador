@extends('welcome')

@section('title', 'Equipos')
@section('content')

<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo Resultados</h3>
            <hr>

            <form action="{{ url('/resultados') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Resultados">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/resultados') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                        <th>Identificación del resultado</th>
                        <th>Identificación del encuentro</th>
                        <th>goles del local</th>
                        <th>goles del visitante</th>
                        <th>id_equipo </th>
                        <th>id_equipo_local</th>
                        <th>id_equipo_visitante</th>
                        <th>observacion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->id_resultado }}</td>
                            <td>{{ $item->id_encuentro }}</td>
                            <td>{{ $item->id_torneo }}</td>
                            <td>{{ $item->goles_local }}</td>
                            <td>{{ $item->goles_visitante }}</td>
                            <td>{{ $item->id_equipo }}</td>
                            <td>{{ $item->id_equipo_local }}</td>
                            <td>{{ $item->id_equipo_visitante }}</td>
                            <td>{{ $item->observaciones }}</td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_resultado }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('resultados.destroy', $item->id_resultado) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este resultado?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_resultado }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('resultados.update', $item->id_resultado) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Resultado</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="id_encuentro" class="form-label">identificador del encuntro</label>
                                                <input type="text" class="form-control" name="id_encuentro" value="{{ $item->id_encuentro }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="goles_local" class="form-label">Goles del Equipo local</label>
                                                <input type="text" class="form-control" name="goles_local" value="{{ $item->goles_local }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="goles_visitante" class="form-label">Goles del Equipo visitante</label>
                                                <input type="text" class="form-control" name="goles_visitante" value="{{ $item->goles_visitante }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_equipo" class="form-label">Ganador</label>
                                                <input type="text" class="form-control" name="id_equipo" value="{{ $item->id_equipo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="observaciones" class="form-label">observaciones</label>
                                                <input type="text" class="form-control" name="observaciones" value="{{ $item->observaciones }}" required>
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
                <div class="d-flex justify-content-end">
                    {{ $datos->links() }}
                </div>
            @else
                <p class="text-center mt-3">No se encontraron resultados.</p>
            @endif
        </div>

        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('resultados.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear Resultado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_resultado" class="form-label">Identificación del resultado</label>
                                <input type="text" class="form-control" id="id_resultado" name="id_resultado" placeholder="Digite el ID del nuevo resultado" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_encuentro" class="form-label">Encuentro</label>
                                <input type="text" class="form-control" id="id_encuentro" name="id_encuentro" placeholder="Digite el ID del encuentro" required>
                            </div>
                            <div class="mb-3">
                                <label for="goles_local" class="form-label">Goles local</label>
                                <input type="text" class="form-control" id="goles_local" name="goles_local" placeholder="goles del local" required>
                            </div>
                            <div class="mb-3">
                                <label for="goles_visitante" class="form-label">Goles del Visitante</label>
                                <input type="text" class="form-control" id="goles_visitante" name="goles_visitante" placeholder="goles del visitante" required>
                            </div>
                            <div class="mb-3">
                                <label for="ganador" class="form-label">Equipo Gandor</label>
                                <input type="text" class="form-control" id="ganador" name="ganador" placeholder="Equipo ganador" required>
                            </div>
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">observaciones</label>
                                <input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="observaciones" required>
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
