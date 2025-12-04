@extends('welcome')

@section('title', 'Faltas')
@section('content')

<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo faltas</h3>
            <hr>

            <form action="{{ url('/faltas') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por faltas">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/faltas') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                        <th>Identificación de la falta</th>
                        <th>Identificación del encuentro</th>
                        <th>Nombre del jugador</th>
                        <th>Nombre del tipo de falta</th>
                        <th>Minuto</th>
                        <th>Tarjeta</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->id_falta }}</td> 
                            <td>{{ $item->id_encuentro }} </td>
                            <td>{{ $item->nombre_usuario }} {{ $item->apellido_usuario }}</td>
                            <td>{{ $item->falta_nombre }}</td>
                            <td>{{ $item->minuto }}</td>
                            <td>{{ $item->tarjeta }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_falta }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('faltas.destroy', $item->id_falta) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta falta?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_falta }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('faltas.update', $item->id_falta) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar falta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_encuentro" class="form-label">Torneo:</label>
                                                <select class="form-select" name="id_encuentro" required>
                                                    @foreach($encuentros as $encuentro)
                                                        <option value="{{ $encuentro->id_encuentro }}"
                                                            {{ $encuentro->id_encuentro == $item->id_encuentro ? 'selected' : '' }}>
                                                            
                                                            {{ $encuentro->id_encuentro }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_jugador" class="form-label">Jugador:</label>
                                                <select class="form-select" name="id_jugador" required>
                                                    @foreach($jugadores as $jugador)
                                                        <option value="{{ $jugador->id_jugador }}"
                                                            {{ $jugador->id_jugador == $item->id_jugador ? 'selected' : '' }}>
                                                            
                                                            {{ $jugador->nombre_usuario }} {{ $jugador->apellido_usuario }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_tipo_falta" class="form-label">Tipo de falta:</label>
                                                <select class="form-select" name="id_tipo_falta" required>
                                                    @foreach($tipo_falta as $tipo)
                                                        <option value="{{ $tipo->id_tipo_falta }}"
                                                            {{ $tipo->id_tipo_falta == $item->id_tipo_falta ? 'selected' : '' }}>
                                                            
                                                            {{ $tipo -> nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="minuto" class="form-label">Minuto de falta</label>
                                                <input type="number" class="form-control" name="minuto" value="{{ $item->minuto }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="tarjeta" class="form-label">Tarjeta</label>
                                                <select class="form-select" name="tarjeta" required>
                                                <option value="amarilla" {{ $item->tarjeta == 'amarilla' ? 'selected' : '' }}>Amarilla</option>
                                                <option value="roja" {{ $item->tarjeta == 'roja' ? 'selected' : '' }}>Roja</option>
                                            </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción de falta:</label>
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
                <p class="text-center mt-3">No se encontraron fechas.</p>
            @endif
        </div>

        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('faltas.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear falta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_falta" class="form-label">Identificación de la falta</label>
                                <input type="number" class="form-control" id="id_falta "name="id_falta" placeholder="Digite el número de identificación de la falta." required>
                            </div>

                            <div class="mb-3">
                                <label for="id_encuentro" class="form-label">Encuentro:</label>
                                <select class="form-select" name="id_encuentro" required>
                                    <option value="" hidden disable selected>Seleccione un encuentro</option>
                                    @foreach($encuentros as $encuentro)
                                        <option value="{{ $encuentro->id_encuentro }}">{{ $encuentro->id_encuentro }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_jugador" class="form-label">Jugador:</label>
                                <select class="form-select" name="id_jugador" required>
                                    <option value="" hidden disable selected>Seleccione un jugador</option>
                                    @foreach($jugadores as $jugador)
                                        <option value="{{ $jugador->id_jugador }}">{{ $jugador->nombre_usuario }} {{ $jugador->apellido_usuario }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_tipo_falta" class="form-label">Tipo de falta::</label>
                                <select class="form-select" name="id_tipo_falta" required>
                                    <option value="" hidden disable selected>Seleccione un tipo de falta</option>
                                    @foreach($tipo_falta as $tipo)
                                        <option value="{{ $tipo->id_tipo_falta }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="minuto" class="form-label">Minuto de la falta:</label>
                                <input type="number" class="form-control" id="minuto" name="minuto" placeholder="Digite el minuto de la falta." required>
                            </div>

                            <div class="mb-3">
                                <label for="tarjeta" class="form-label">Estado</label>
                                <select class="form-select" name="tarjeta" aria-label="Default select example">
                                <option value="" hidden disable selected>Seleccione una tarjeta</option>
                                <option value="amarilla">Amarilla</option>
                                <option value="roja">Roja</option> 
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción de la falta:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ponga una descripción de la falta." required>
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
    </container>

@endsection

