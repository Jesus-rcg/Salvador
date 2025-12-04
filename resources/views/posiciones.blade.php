@extends('welcome')

@section('title', 'Equipos')
@section('content')

<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo posiciones</h3>
            <hr>

            <form action="{{ url('/posiciones') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por posicion">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/posiciones') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                            <th scope="col">Posicion</th>
                            <th scope="col">Torneo</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">Partidos Jugados</th>
                            <th scope="col">Partidos Ganados</th>
                            <th scope="col">Partidos Empatados</th>
                            <th scope="col">Partidos Perdidos</th>
                            <th scope="col">Goles A Favor</th>
                            <th scope="col">Goles En Contra</th>
                            <th scope="col">Diferencia De Goles</th>
                            <th scope="col">Puntos</th>
                            <th>Acciones</th>
                            </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                                <td>{{$item->id_posicion}}</td>
                                <td>{{$item->nombre_torneo}}</td>
                                <td>{{$item->nombre_equipo}}</td>
                                <td>{{$item->pj}}</td>
                                <td>{{$item->pg}}</td>
                                <td>{{$item->pe}}</td>
                                <td>{{$item->pp}}</td>
                                <td>{{$item->gf}}</td>
                                <td>{{$item->gc}}</td>
                                <td>{{$item->gd}}</td>
                                <td>{{$item->puntos}}</td>
                                <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_posicion }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('posiciones.destroy', $item->id_posicion) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dato?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_posicion }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('posiciones.update', $item->id_posicion) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar posicion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label for="id_posicion" class="form-label">ID posicion</label>
                                                <input type="text" class="form-control" name="id_posicion" value="{{ $item->id_posicion }}" required>
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
                <p class="text-center mt-3">No se encontro la posicion.</p>
            @endif
        </div>

        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('posiciones.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear Rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="id_posicion" class="form-label">Identificación del rol</label>
                                <input type="text" class="form-control" id="id_posicion" name="id_posicion" placeholder="Digite el ID de la posicion" required>
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
