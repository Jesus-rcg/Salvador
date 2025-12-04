<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cronologiaController extends Controller
{
    // Mostrar roles + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('cronologia');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_cronologia','LIKE',"%{$search}%")
                  ->orWhere('id_jugador','LIKE',"%{$search}%")
                  ->orWhere('estado','LIKE',"%{$search}%")
                  ->orWhere('minuto','LIKE',"%{$search}%")
                  ->orWhere('tipo_evento','LIKE',"%{$search}%")
                  ->orWhere('descripcion','LIKE',"%{$search}%")
                  ->orWhere('tarjeta','LIKE',"%{$search}%")
                 ->orWhere('id_encuentro','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        return view("cronologia")->with("datos", $datos);
    }

    // Crear nuevo rol
    public function store(Request $request){
        $request->validate([
            'id_cronologia' => 'required|unique:cronologia,id_cronologia',
            'id_jugador' => 'required',
            'estado' => 'required',
            'minuto' => 'required',
            'tipo_evento' => 'required',
            'descripcion' => 'required',
            'tarjeta' => 'required',
            'id_encuentro' => 'required',

        ]);

        cronologiaModelo::create($request->all());
        return redirect()->route('cronologia.index')->with('success','Tipo de falta registrado correctamente');
    }

    // Actualizar (modificar)
    public function update(Request $request, $id_cronologia){
        $cronologia = cronologiaModelo::findOrFail($id_cronologia);
        $cronologia->update([
            'id_jugador' => $request->id_jugador,
            'estado' => $request->estado,
            'minuto' => $request->minuto,
            'tipo_evento' => $request->tipo_evento,
            'descripcion' => $request->descripcion,
            'tarjeta' => $request->tarjeta,
            'id_encuentro' => $request->id_encuentro,
            
        ]);
        return redirect()->route('cronologia.index')->with('success','Tipo de falta actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_cronologia){
        $cronologia = cronologiaModelo::findOrFail($id_cronologia);
        $cronologia->delete();
        return redirect()->route('cronologia.index')->with('success','Tipo de falta  eliminado correctamente');
    }
}
