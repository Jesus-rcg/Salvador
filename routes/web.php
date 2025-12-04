<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\lugaresController;
use App\Http\Controllers\ArbitrosController;
use App\Http\Controllers\categoriasController;
use App\Http\Controllers\EncuentrosController;
use App\Http\Controllers\equiposController;
use App\Http\Controllers\fechasController;
use App\Http\Controllers\faltasController;
use App\Http\Controllers\jugadoresController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\resultadosController;
use App\Http\Controllers\premiacionController;
use App\Http\Controllers\posicionesController;
use App\Http\Controllers\torneosController;
use App\Http\Controllers\tecnicosController;
use App\Http\Controllers\cronologiaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckAuth; 


// LOGIN
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware([checkAuth::class])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    //Jorge
    // equipo 
    Route::get('/equipos', [equiposController::class, 'index'])->name('equipos.index');
    Route::post('/equipos/store', [equiposController::class, 'store'])->name('equipos.store');
    Route::put('/equipos/update/{id}', [equiposController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/delete/{id}', [equiposController::class, 'destroy'])->name('equipos.destroy');
    Route::resource('equipos', App\Http\Controllers\EquiposController::class);
    
    // categorias 
    Route::get('/categorias', [categoriasController::class, 'index'])->name('categorias.index');
    Route::post('/categorias/store', [categoriasController::class, 'store'])->name('categorias.store');
    Route::put('/categorias/update/{id}', [categoriasController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/delete/{id}', [categoriasController::class, 'destroy'])->name('categorias.destroy');

    // arbitros 
    Route::get('/arbitros', [arbitrosController::class, 'index'])->name('arbitros.index');
    Route::post('/arbitros/store', [arbitrosController::class, 'store'])->name('arbitros.store');
    Route::put('/arbitros/update/{id}', [arbitrosController::class, 'update'])->name('arbitros.update');
    Route::delete('/arbitros/delete/{id}', [arbitrosController::class, 'destroy'])->name('arbitros.destroy');
    
    //encuentros 
    Route::get('/encuentros', [EncuentrosController::class, 'index'])->name('encuentros.index');
    Route::post('/encuentros/store', [EncuentrosController::class, 'store'])->name('encuentros.store');
    Route::get('/encuentros/edit/{id}', [EncuentrosController::class, 'edit'])->name('encuentros.edit');
    Route::put('/encuentros/update/{id}', [EncuentrosController::class, 'update'])->name('encuentros.update');
    Route::delete('/encuentros/destroy/{id}', [EncuentrosController::class, 'destroy'])->name('encuentros.destroy');

    // inscripciones 
    Route::get('/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::post('/inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::put('/inscripciones/{id}', [InscripcionController::class, 'update'])->name('inscripciones.update');
    Route::delete('/inscripciones/{id}', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');

    //Jesus
    //Torneos
    Route::get('/torneos', [torneosController::class,"index"])->name("torneos.index");
    Route::post('/torneos/store', [torneosController::class, 'store'])->name('torneos.store');
    Route::put('/torneos/update/{id}', [torneosController::class, 'update'])->name('torneos.update');
    Route::delete('/torneos/delete/{id}', [torneosController::class, 'destroy'])->name('torneos.destroy');

    //Tecnicos
    Route::get('/tecnicos', [tecnicosController::class,"index"])->name("tecnicos.index");
    Route::post('/tecnicos/store', [tecnicosController::class, 'store'])->name('tecnicos.store');
    Route::put('/tecnicos/update/{id}', [tecnicosController::class, 'update'])->name('tecnicos.update');
    Route::delete('/tecnicos/delete/{id}', [tecnicosController::class, 'destroy'])->name('tecnicos.destroy');
    
    //Tipo_Falta
    Route::get('/tipo_falta', [tipo_faltaController::class,"index"])->name("tipo_falta.index");
    Route::post('/tipo_falta/store', [tipo_faltaController::class, 'store'])->name('tipo_falta.store');
    Route::put('/tipo_falta/update/{id}', [tipo_faltaController::class, 'update'])->name('tipo_falta.update');
    Route::delete('/tipo_falta/delete/{id}', [tipo_faltaController::class, 'destroy'])->name('tipo_falta.destroy');
    
    //Usuarios
    Route::get('/usuarios', [UsuariosController::class,"index"])->name("usuarios.index");
    Route::post('/usuarios/store', [usuariosController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/update/{id}', [usuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/delete/{id}', [usuariosController::class, 'destroy'])->name('usuarios.destroy');

    //Sebastian
    //Lugares
    Route::get('/lugares', [lugaresController::class, 'index'])->name('lugares.index');
    Route::post('/lugares', [lugaresController::class, 'store'])->name('lugares.store');
    Route::put('/lugares/{id_lugar}', [lugaresController::class, 'update'])->name('lugares.update');
    Route::delete('/lugares/{id_lugar}', [lugaresController::class, 'destroy'])->name('lugares.destroy');
    
    //Fechas
    Route::get('/fechas', [fechasController::class,"index"])->name("fechas.index");
    Route::post('/fechas', [fechasController::class, 'store'])->name('fechas.store');
    Route::put('/fechas/{id_fecha}', [fechasController::class, 'update'])->name('fechas.update');
    Route::delete('/fechas/{id_fecha}', [fechasController::class, 'destroy'])->name('fechas.destroy');
    
    //Faltas
    Route::get('/faltas', [faltasController::class,"index"])->name("faltas.index");
    Route::post('/faltas', [faltasController::class, 'store'])->name('faltas.store');
    Route::put('/faltas/{id_falta}', [faltasController::class, 'update'])->name('faltas.update');
    Route::delete('/faltas/{id_falta}', [faltasController::class, 'destroy'])->name('faltas.destroy');
    
    //Jugadores
    Route::get('/jugadores', [jugadoresController::class,'index'])->name('jugadores.index');
    Route::post('/jugadores', [jugadoresController::class, 'store'])->name('jugadores.store');
    Route::put('/jugadores/{id_jugador}', [jugadoresController::class, 'update'])->name('jugadores.update');
    Route::delete('/jugadores/{id_jugador}', [jugadoresController::class, 'destroy'])->name('jugadores.destroy');

    //Kevin
    //Roles
    Route::get('/roles', [rolesController::class, 'index'])->name('roles.index');
    Route::post('/roles', [rolesController::class, 'store'])->name('roles.store');
    Route::put('/roles/{id_rol}', [rolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id_rol}', [rolesController::class, 'destroy'])->name('roles.destroy');
    
    //Resultados
    Route::get('/resultados', [resultadosController::class,"index"])->name("resultados.index");
    Route::post('/resultados', [resultadosController::class, 'store'])->name('resultados.store');
    Route::put('/resultados/{id_rol}', [resultadosController::class, 'update'])->name('resultados.update');
    Route::delete('/resulatdos/{id_rol}', [resultadosController::class, 'destroy'])->name('resultados.destroy');
    
    //Premiacion
    Route::get('/premiacion', [premiacionController::class,"index"])->name("premiacion.index");
    Route::post('/premiacion', [premiacionController::class, 'store'])->name('premiacion.store');
    Route::put('/premiacion/{id_rol}', [premiacionController::class, 'update'])->name('premiacion.update');
    Route::delete('/premiacion/{id_rol}', [premiacionController::class, 'destroy'])->name('premiacion.destroy');
    
    //Posiciones
    Route::get('/posiciones', [posicionesController::class,"index"])->name("posiciones.index");
    Route::post('/posiciones', [posicionesController::class, 'store'])->name('posiciones.store');
    Route::put('/posiciones/{id_rol}', [posicionesController::class, 'update'])->name('posiciones.update');
    Route::delete('/posiciones/{id_rol}', [posicionesController::class, 'destroy'])->name('posiciones.destroy');

    });
