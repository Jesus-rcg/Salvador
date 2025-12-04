@extends('welcome')

@section('title', 'Fechas')
@section('content')

<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo fechas</h3>
            <hr>

            <form action="{{ url('/fechas') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por fechas">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/fechas') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                        <th>Identificación de la fecha</th>
                        <th>Torneo</th>
                        <th>Número de fecha</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->id_fecha }}</td> 
                            <td>{{ $item->torneo_nombre }} </td>
                            <td>{{ $item->numero_fecha }}</td>
                            <td>{{ $item->fecha }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_fecha }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('fechas.destroy', $item->id_fecha) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta fecha?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_fecha }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('fechas.update', $item->id_fecha) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar fecha</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_torneo" class="form-label">Torneo:</label>
                                                <select class="form-select" name="id_torneo" required>
                                                    @foreach($torneos as $torneo)
                                                        <option value="{{ $torneo->id_torneo }}"
                                                            {{ $torneo->id_torneo == $item->id_torneo ? 'selected' : '' }}>
                                                            
                                                            {{ $torneo->nombre_torneo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="numero_fecha" class="form-label">Número de fecha</label>
                                                <input type="number" class="form-control" name="numero_fecha" value="{{ $item->numero_fecha }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha</label>
                                                <input 
                                                    type="date" 
                                                    class="form-control" 
                                                    name="fecha" 
                                                    value="{{ $item->fecha }}" 
                                                    required
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select class="form-select" name="estado" required>
                                                <option value="pendiente" {{ $item->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="completada" {{ $item->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                                            </select>
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
                    <form action="{{ route('fechas.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear jugador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_fecha" class="form-label">Identificación de la fecha</label>
                                <input type="number" class="form-control" id="id_fecha "name="id_fecha" placeholder="Digite el número de identificación de la fecha." required>
                            </div>

                            <div class="mb-3">
                                <label for="id_torneo" class="form-label">Torneo:</label>
                                <select class="form-select" name="id_torneo" required>
                                    <option value="" hidden disable selected>Seleccione un torneo</option>
                                    @foreach($torneos as $torneo)
                                        <option value="{{ $torneo->id_torneo }}">{{ $torneo->nombre_torneo }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="numero_fecha" class="form-label">Número de fecha:</label>
                                <input type="number" class="form-control" id="numero_fecha" name="numero_fecha" placeholder="Digite el número de la fecha." required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    name="fecha" 
                                    value=""
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" name="estado" aria-label="Default select example">
                                <option value="" hidden disable selected>Seleccione un estado</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="completada">Completada</option> 
                                </select>
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

