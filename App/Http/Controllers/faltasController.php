<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\faltasModelo;

class faltasController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');


        $query = DB::table('faltas')

        ->join('encuentros', 'faltas.id_encuentro', '=', 'encuentros.id_encuentro')
        ->join('jugadores', 'faltas.id_jugador', '=', 'jugadores.id_jugador')
        ->join('usuarios', 'jugadores.id_usuario', '=', 'usuarios.id_usuario')
        ->join('tipo_falta', 'faltas.id_tipo_falta', '=', 'tipo_falta.id_tipo_falta')
        ->select(
            'faltas.*',
            'tipo_falta.nombre as falta_nombre',
            'usuarios.nombre as nombre_usuario',
            'usuarios.apellido as apellido_usuario'
        );

    if($search){
        $query->where(function ($q) use($search){
            $q->where('faltas_id_falta','LIKE',"%{$search}%")
              ->orWhere('faltas.id_encuentro','LIKE',"%{$search}%")
              ->orWhere('faltas.id_jugador','LIKE',"%{$search}%")
              ->orWhere('fechas.id_tipo_falta','LIKE',"%{$search}%")
              ->orWhere('tipo_falta.nombre','LIKE',"%{$search}%")
              ->orWhere('usuarios.nombre','LIKE',"%{$search}%")
              ->orWhere('usuarios.apellido','LIKE',"%{$search}%")
              ->orWhere('fechas.minuto','LIKE',"%{$search}%")
              ->orWhere('fechas.tarjeta','LIKE',"%{$search}%")
              ->orWhere('fechas.descripcion','LIKE',"%{$search}%");
        });
    }
        $datos = $query->paginate(10)->appends($request->only('search'));

        $encuentros = DB::table('encuentros')->get();
        $jugadores = DB::table('jugadores')
                ->join('usuarios', 'jugadores.id_usuario', '=', 'usuarios.id_usuario')
                ->select(
                    'jugadores.id_jugador',
                    'usuarios.nombre as nombre_usuario',
                    'usuarios.apellido as apellido_usuario'
                )
            ->get();

        $tipo_falta = DB::table('tipo_falta')->get();

        return view("faltas", compact('datos', 'encuentros', 'jugadores', 'tipo_falta'));
    }
    
    public function create(){
    $encuentros = DB::table('encuentros')->get(); 
    $jugadores = DB::table('jugadores')
            ->join('usuarios', 'jugadores.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'jugadores.id_jugador',
                'usuarios.nombre as nombre_usuario',
                'usuarios.apellido as apellido_usuario'
            )
        ->get();
    $tipo_falta = DB::table('tipo_falta')->get();

    return view('faltas.create', compact('encuentros', 'jugadores', 'tipo_falta'));
    }

    //Crear
    public function store(Request $request){
        $request -> validate([
            'id_falta' => 'required|unique:faltas,id_falta',
            'id_encuentro' => 'required',
            'id_jugador'  => 'required',
            'id_tipo_falta' => 'required',
            'minuto' => 'required',
            'tarjeta' => 'required',
            'descripcion' => 'required',
        ]);

        faltasModelo::create($request->all());

        return redirect()->route('faltas.index')
                     ->with('success', 'Falta creada correctamente.');
    }

    //Actualizar
    public function update(Request $request, $id_falta){
        $falta = faltasModelo::findOrFail($id_falta);
        $falta ->update([
            'id_encuentro' => $request->id_encuentro,
            'id_jugador' => $request->id_jugador,
            'id_tipo_falta' => $request->id_tipo_falta,
            'minuto' => $request->minuto,
            'tarjeta' => $request->tarjeta,
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('faltas.index')->with('success','Falta actualizada correctamente');
    }

    // Eliminar
    public function destroy($id_falta){
        $falta = faltasModelo::findOrFail($id_falta);
        $falta ->delete();
        return redirect()->route('faltas.index')->with('success','Falta eliminada correctamente');
    }
}
