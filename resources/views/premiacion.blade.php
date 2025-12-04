@extends('dashboard')

@section('title', 'Equipos')
@section('content')

<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo Premiacion</h3>
            <hr>

            <form action="{{ url('/premiacion') }}" method="GET">
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
                        <a href="{{ url('/premiacion') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                        <th>Identificación de la premiacion</th>
                        <th>Identificación del torneo</th>
                        <th>Identificación del equipo gandor</th>
                        <th>posicion</th>
                        <th>premio</th>
                        <th>descripcion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->id_premiacion }}</td>
                            <td>{{ $item->id_torneo }}</td>
                            <td>{{ $item->id_equipo }}</td>
                            <td>{{ $item->posicion }}</td>
                            <td>{{ $item->premio }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_premiacion }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('premiacion.destroy', $item->id_premiacion) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este resultado?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_premiacion }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('premiacion.update', $item->id_premiacion) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Resultado</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="id_torneo" class="form-label">identificador del torneo</label>
                                                <input type="text" class="form-control" name="id_torneo" value="{{ $item->id_torneo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_equipo" class="form-label">Identificador del equipo ganador</label>
                                                <input type="text" class="form-control" name="id_equipo" value="{{ $item->id_equipo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="posicion" class="form-label">Posicion</label>
                                                <input type="text" class="form-control" name="posicion" value="{{ $item->posicion }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="premio" class="form-label">premio</label>
                                                <input type="text" class="form-control" name="premio" value="{{ $item->premio }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">descripcion</label>
                                                <input type="text" class="form-control" name="descripcion" value="{{ $item->descripcion }}" required>
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
                    <form action="{{ route('premiacion.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear premiacion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_premiacion" class="form-label">Identificación de la premiacion</label>
                                <input type="text" class="form-control" id="id_premiacion" name="id_premiacion" placeholder="Digite el ID de la nueva premiacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_torneo" class="form-label">Encuentro</label>
                                <input type="text" class="form-control" id="id_torneo" name="id_torneo" placeholder="Digite el ID del torneo" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_equipo_ganador" class="form-label">Identificacion del equipo ganador</label>
                                <input type="text" class="form-control" id="id_equipo_ganador" name="id_equipo_ganador" placeholder="identifiacion del equipo gandor" required>
                            </div>
                            <div class="mb-3">
                                <label for="posicion" class="form-label">Posicion</label>
                                <input type="text" class="form-control" id="posicion" name="posicion" placeholder="posicion" required>
                            </div>
                            <div class="mb-3">
                                <label for="premio" class="form-label">Premio</label>
                                <input type="text" class="form-control" id="premio" name="premio" placeholder="premio" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">descripcion</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="descripcion" required>
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
