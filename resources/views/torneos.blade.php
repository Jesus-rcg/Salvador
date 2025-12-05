@extends('welcome')

@section('title', 'Torneos')

@section('content')

<!-- ===== HEADER ESTILO PLAYMATCH ===== -->
<header class="pm-header">
    <div class="pm-top-bar">
        <div class="pm-left">
            <img src="{{ asset('Images/Logo.png') }}" class="pm-logo">
            <h1 class="pm-title">Play Match</h1>

            <nav class="pm-menu">
                <a href="/">Principal/Torneos</a>
                <a href="#">Partidos</a>
                <a href="#">Equipos</a>
            </nav>
        </div>

        <div class="pm-buttons">
            <button type="button" onclick="location.href='/register'">Registrarse</button>
            <button type="button" onclick="location.href='/login'">Inicio sesión</button>
        </div>
    </div>

    <div class="pm-rect">
        <div class="pm-info">
            <h2><strong>BUSCADOR DE TORNEOS - PLAYMATCH.</strong></h2>
            <p>Ingresa una palabra clave o nombre del torneo para buscarlo.</p>
        </div>

        <form action="{{ url('/torneos') }}" method="GET" class="pm-search-box">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="  Fifas, 2154897...">
            <button type="submit">Buscar</button>
        </form>
    </div>
</header>

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<main class="pm-main">

<div class="pm-container">

    <div class="pm-card">
        <div class="pm-card-body">

            <div class="pm-top-actions">
                <button type="button" class="pm-btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                    <i class="fa-solid fa-plus"></i> Nuevo Torneo
                </button>
                <a href="{{ url('/torneos') }}" class="pm-btn-warning">
                    <i class="fas fa-list"></i> Reset
                </a>
            </div>

            @if($datos->count() > 0)

            <div class="pm-table-wrapper">
                <table class="pm-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Ciudad</th>
                            <th>Categoría</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Máx Equipos</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->id_torneo }}</td>
                            <td>{{ $item->nombre_torneo }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') }}</td>
                            <td>{{ $item->ciudad }}</td>
                            <td>{{ $item->nombre_categoria ?? 'Sin categoría' }}</td>
                            <td>{{ $item->usuario_nombre_completo ?? 'Usuario no encontrado' }}</td>

                            <td>
                                <span class="pm-badge pm-{{ $item->estado }}">
                                    {{ ucfirst(str_replace('_',' ', $item->estado)) }}
                                </span>
                            </td>

                            <td>{{ $item->max_equipos }}</td>
                            <td>{{ $item->tipo_torneo }}</td>

                            <td>
                                <button class="pm-btn-edit" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id_torneo }}">
                                    Editar
                                </button>

                                <form action="{{ route('torneos.destroy', $item->id_torneo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="pm-btn-delete" onclick="return confirm('¿Eliminar este torneo?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <!-- === MODAL EDITAR === -->
                        <div class="modal fade" id="editarModal{{ $item->id_torneo }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('torneos.update', $item->id_torneo) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Torneo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <!-- Campos iguales, no modificados -->
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre_torneo" value="{{ $item->nombre_torneo }}" required>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <label>Inicio</label>
                                                    <input type="date" class="form-control" name="fecha_inicio" value="{{ $item->fecha_inicio }}" required>
                                                </div>
                                                <div class="col">
                                                    <label>Fin</label>
                                                    <input type="date" class="form-control" name="fecha_fin" value="{{ $item->fecha_fin }}" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Ciudad</label>
                                                <input type="text" class="form-control" name="ciudad" value="{{ $item->ciudad }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Categoría</label>
                                                <select name="id_categoria" class="form-select" required>
                                                    @foreach($categorias as $c)
                                                        <option value="{{ $c->id_categoria }}" {{ $c->id_categoria == $item->id_categoria ? 'selected' : '' }}>
                                                            {{ $c->nombre_categoria }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Usuario</label>
                                                <select name="id_usuario" class="form-select" required>
                                                    @foreach($usuarios as $u)
                                                        <option value="{{ $u->id_usuario }}" {{ $u->id_usuario == $item->id_usuario ? 'selected' : '' }}>
                                                            {{ $u->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Estado</label>
                                                <select name="estado" class="form-control" required>
                                                    <option value="planificado" {{ $item->estado == 'planificado' ? 'selected' : '' }}>Planificado</option>
                                                    <option value="en_curso" {{ $item->estado == 'en_curso' ? 'selected' : '' }}>En curso</option>
                                                    <option value="finalizado" {{ $item->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                                    <option value="cancelado" {{ $item->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Máx Equipos</label>
                                                <input type="number" class="form-control" name="max_equipos" value="{{ $item->max_equipos }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Tipo Torneo</label>
                                                <input type="text" class="form-control" name="tipo_torneo" value="{{ $item->tipo_torneo }}" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pm-pagination">
                {{ $datos->links() }}
            </div>

            @else
                <p class="pm-no-results">No se encontraron Torneos.</p>
            @endif

        </div>
    </div>

</div>

</main>

<!-- ===== MODAL AGREGAR ===== -->
<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('torneos.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Crear Torneo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombre_torneo" required>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" required>
                        </div>
                        <div class="col">
                            <label>Fecha Fin</label>
                            <input type="date" class="form-control" name="fecha_fin" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" required>
                    </div>

                    <div class="mb-3">
                        <label>Categoría</label>
                        <select name="id_categoria" class="form-select" required>
                            <option disabled selected>Seleccione una categoría</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->id_categoria }}">
                                    {{ $c->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Usuario</label>
                        <select name="id_usuario" class="form-select" required>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->id_usuario }}">
                                    {{ $u->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Estado</label>
                        <select class="form-control" name="estado" required>
                            <option value="planificado">Planificado</option>
                            <option value="en_curso">En curso</option>
                            <option value="finalizado">Finalizado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Máx Equipos</label>
                        <input type="number" class="form-control" name="max_equipos" required>
                    </div>

                    <div class="mb-3">
                        <label>Tipo Torneo</label>
                        <input type="text" class="form-control" name="tipo_torneo" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
