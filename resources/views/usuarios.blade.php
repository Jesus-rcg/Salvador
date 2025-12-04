@extends('welcome')

@section('title', 'usuarios')
@section('content')
<div class="container-sm d-flex justify-content-center mt-5">
    <div class="card" style="width: 1200px;">
        <div class="card-body">
            <h3>Módulo Usuarios</h3>
            <hr>

            <form action="{{ url('/usuarios') }}" method="GET">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Nombre o Id ">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                        <a href="{{ url('/usuarios') }}" class="btn btn-warning"><i class="fas fa-list"></i> Reset</a>
                    </div>
                </div>
            </form>

            @if($datos->count() > 0)
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                    <tr>
                        <th scope="col">Usuario</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Registro</th>
                            <th scope="col">Fecha de Nacimiento</th>
                            <th scope="col">Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{$item->id_usuario}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->apellido}}</td>
                                <td>{{$item->correo}}</td>
                                <td>{{$item->telefono}}</td>
                                <td>{{$item->nombrerol}}</td>
                                <td>{{$item->fecha_registro}}</td>
                                <td>{{$item->fecha_nacimiento}}</td>
                                <td>{{$item->estado}}</td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_usuario }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>

                                <!-- BOTÓN ELIMINAR -->
                                <form action="{{ route('usuarios.destroy', $item->id_usuario) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este Usuario ?')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{ $item->id_usuario }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('usuarios.update', $item->id_usuario) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" value="{{ $item->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="apellido" class="form-label">Apellido</label>
                                                <input type="text" class="form-control" name="apellido" value="{{ $item->apellido }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="correo" class="form-label">Correo</label>
                                                <input type="text" class="form-control" name="correo" value="{{ $item->correo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telefono" class="form-label">Telefono</label>
                                                <input type="number" class="form-control" name="telefono" value="{{ $item->telefono }}" required>

                                            </div>

                                            <select class="form-control" name="id_rol" required>
                                                @foreach($roles as $rol)
                                                    <option value="{{ $rol->id_rol }}" 
                                                        {{ $item->id_rol == $rol->id_rol ? 'selected' : '' }}>
                                                        {{ $rol->nombrerol }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="mb-3">
                                                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                                <input type="text" class="form-control" name="fecha_registro" value="{{ $item->fecha_registro }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                                <input type="text" class="form-control" name="fecha_nacimiento" value="{{ $item->fecha_nacimiento }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <select class="form-control" name="estado" required>
                                                    <option value="activo" {{ $item->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="inactivo" {{ $item->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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
            @else
                <p class="text-center mt-3">No se encontro Usuarios.</p>
            @endif
        </div>

        <!-- MODAL AGREGAR -->
        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-user"></i> Crear Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Id Usuario</label>
                                <input type="text" class="form-control" name="id_usuario" placeholder="Ingrese el ID del Usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ingrese el Nombre del Usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="apellido" placeholder="Ingrese el Apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="text" class="form-control" name="correo" placeholder="Ingrese el Apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" placeholder="Ingrese el Telefono" required>
                            </div>
                            <div>
                            <select class="form-control" name="id_rol" required>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id_rol }}">
                                        {{ $rol->nombrerol }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                <input type="date" class="form-control" name="fecha_registro" placeholder="Ingrese la fecha de registro" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" placeholder="Ingrese la Fecha de Nacimiento" required>
                            </div>
                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <select class="form-control" name="estado" required>
                                                    <option value="activo" {{ $item->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="inactivo" {{ $item->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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

    </div>
</div>

@endsection