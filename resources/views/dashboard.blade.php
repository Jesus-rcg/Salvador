@extends('layouts.main')

@section('title', 'Dashboard Principal')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Panel de Control</h1>
        
        <div class="card shadow mb-4">
            <div class="card-body">
                <p>¡Bienvenido! Has iniciado sesión con éxito.</p>
                
                {{-- Opcional: Mostrar detalles de la sesión del usuario --}}
                @if(session('user'))
                    <p>Nombre: <strong>{{ session('user.nombre') }}</strong></p>
                    <p>Correo: <strong>{{ session('user.correo') }}</strong></p>
                    <p>ID Rol: <strong>{{ session('user.id_rol') }}</strong></p>
                @endif
                
            </div>
        </div>

        {{-- Aquí puedes agregar estadísticas, tarjetas, gráficos, etc. --}}
    </div>
@endsection