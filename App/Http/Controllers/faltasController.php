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
        ->select(
            'faltas.*',
            'jugadores.nombre_jugador as nombre_jugador'
        );

    if($search){
        $query->where(function ($q) use($search){
            $q->where('faltas_id_falta','LIKE',"%{$search}%")
              ->orWhere('faltas.id_encuentro','LIKE',"%{$search}%")
              ->orWhere('faltas.id_jugador','LIKE',"%{$search}%")
              ->orWhere('jugadores.nombre_jugador','LIKE',"%{$search}%")
              ->orWhere('faltas.minuto','LIKE',"%{$search}%")
              ->orWhere('faltas.tarjeta','LIKE',"%{$search}%")
              ->orWhere('faltas.descripcion','LIKE',"%{$search}%");
        });
    }
        $datos = $query->paginate(10)->appends($request->only('search'));

        $encuentros = DB::table('encuentros')->get();
        $jugadores = DB::table('jugadores')
                ->select(
                    'id_jugador',
                    'nombre_jugador'
                )
            ->get();


        return view("faltas", compact('datos', 'encuentros', 'jugadores'));
    }
    
    public function create(){
    $encuentros = DB::table('encuentros')->get(); 
    $jugadores = DB::table('jugadores')
            ->select(
                'id_jugador',
                'nombre_jugador'
            )
        ->get();

    return view('faltas.create', compact('encuentros', 'jugadores'));
    }

    //Crear
    public function store(Request $request){
        $request -> validate([
            'id_falta' => 'required|unique:faltas,id_falta',
            'id_encuentro' => 'required',
            'id_jugador'  => 'required',
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
