@extends('welcome')

@section('title', 'cronologia')
@section('content')
<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo Cronologia</h3>
            

            <form action="{{ url('/cronologia') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Id, Nombre o Gravedad ">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/cronologia') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                        <th scope="col">Id Cronologia</th>
                            <th scope="col">Id Jugador</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Minuto</th>
                            <th scope="col">Tipo de Evento</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Tarjeta</th>
                            <th scope="col">Id Encuentro</th>
                            
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{$item->id_cronologia}}</td>
                                <td>{{$item->id_jugador}}</td>
                                <td>{{$item->estado}}</td>
                                <td>{{$item->minuto}}</td>
                                <td>{{$item->tipo_evento}}</td>
                                <td>{{$item->descripcion}}</td>
                                <td>{{$item->tarjeta}}</td>
                                <td>{{$item->id_encuentro}}</td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_cronologia }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('cronologia.destroy', $item->id_cronologia) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar la falta ?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_cronologia }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('cronologia.update', $item->id_cronologia) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Falta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="id_jugador" class="form-label">Id jugador</label>
                                                <input type="text" class="form-control" name="id_jugador" value="{{ $item->id_jugador }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="estado" class="form-label">Estado</label>
                                                <input type="text" class="form-control" name="estado" value="{{ $item->estado }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="minuto" class="form-label">Minuto</label>
                                                <input type="number" class="form-control" name="minuto" value="{{ $item->minuto }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tipo_evento" class="form-label">Tipo de Evento</label>
                                                <input type="text" class="form-control" name="tipo_evento" value="{{ $item->tipo_evento }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripcion</label>
                                                <input type="text" class="form-control" name="descripcion" value="{{ $item->descripcion }}" required>
                                            </div>
                                            <div class="mb-3">
                                
                                                    <label class="form-label">Tarjeta</label>
                                                     <select class="form-control" name="estado" required>
                                                        <option value="ninguna" {{ $item->tarjeta== 'ninguna' ? 'selected' : '' }}>Ninguna</option>
                                                        <option value="amarilla" {{ $item->tarjeta == 'amarilla' ? 'selected' : '' }}>Amarilla</option>
                                                         <option value="roja" {{ $item->tarjeta == 'roja' ? 'selected' : '' }}>Roja</option>
                                                    </select>
                                            </div>
                                           
                                            <div class="mb-3">
                                                <label for="id_encuentro" class="form-label">Id Encuentro</label>
                                                <input type="number" class="form-control" name="id_encuentro" value="{{ $item->id_encuentro }}" required>
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
            @else
                <p class="text-center mt-3">No se encontro Falta.</p>
            @endif
        </div>

        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('cronologia.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear Falta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_cronologia" class="form-label">Id Tipo de Falta</label>
                                <input type="text" class="form-control" name="id_cronologia" placeholder="Ingrese el ID del tipo de Falta" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_jugador" class="form-label">Id jugador</label>
                                <input type="text" class="form-control" name="id_jugador" placeholder="Ingrese el nombre del tipo de falta" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" class="form-control" name="estado" placeholder="Ingrese gravedad de la falta" required>
                            </div>
                            <div class="mb-3">
                                <label for="minuto" class="form-label">Minuto </label>
                                <input type="number" class="form-control" name="minuto" placeholder="Ingrese sancion base" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_evento" class="form-label">Tipo de Evento </label>
                                <input type="number" class="form-control" name="tipo_evento" placeholder="Ingrese sancion base" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripcion </label>
                                <input type="number" class="form-control" name="descripcion" placeholder="Ingrese sancion base" required>
                            </div>
                            <div class="mb-3">
                                
                                 <label class="form-label">Tarjeta</label>
                                    <select class="form-control" name="estado" required>
                                        <option value="ninguna" {{ $item->tarjeta== 'ninguna' ? 'selected' : '' }}>Ninguna</option>
                                         <option value="amarilla" {{ $item->tarjeta == 'amarilla' ? 'selected' : '' }}>Amarilla</option>
                                        <option value="roja" {{ $item->tarjeta == 'roja' ? 'selected' : '' }}>Roja</option>
                                    </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_encuentro" class="form-label">Id Encuentro </label>
                                <input type="number" class="form-control" name="id_encuentro" placeholder="Ingrese sancion base" required>
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