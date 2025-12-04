@extends('welcome')

@section('title', 'tecnicos')
@section('content')
<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo Tecnicos</h3>
            <hr>

            <form action="{{ url('/tecnicos') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Id, Nombre o Equipo ">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/tecnicos') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                       <th scope="col">Tecnico</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">licencia</th>
                           
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{$item->id_tecnico}}</td>
                                <td>{{$item->id_usuario}}</td>
                                <td>{{$item->id_equipo}}</td>
                                <td>{{$item->licencia}}</td>
                                                    
                               <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_tecnico }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('tecnicos.destroy', $item->id_tecnico) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar Tecnico ?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_tecnico }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('tecnicos.update', $item->id_tecnico) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Tecnico</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="id_usuario" class="form-label">Id Usuario</label>
                                                <input type="text" class="form-control" name="id_usuario" value="{{ $item->id_usuario }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_equipo " class="form-label">Id Equipo</label>
                                                <input type="text" class="form-control" name="id_equipo " value="{{ $item->id_equipo  }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="licencia" class="form-label">Licencia</label>
                                                <input type="number" class="form-control" name="licencia" value="{{ $item->licencia }}" required>
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
                <p class="text-center mt-3">No se encontro Tecnico.</p>
            @endif
        </div>

        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('tecnicos.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear Tecnico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_tecnico" class="form-label">Id Tecnico</label>
                                <input type="text" class="form-control" name="id_tecnico" placeholder="Ingrese el ID del tecnico" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Id Usuario</label>
                                <input type="text" class="form-control" name="id_usuario" placeholder="Ingrese el ID de usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_equipo" class="form-label">Id Equipo</label>
                                <input type="text" class="form-control" name="id_equipo" placeholder="Ingrese el ID de equipo" required>
                            </div>
                            <div class="mb-3">
                                <label for="licencia" class="form-label">Licencia</label>
                                <input type="number" class="form-control" name="licencia" placeholder="Ingrese licencia" required>
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