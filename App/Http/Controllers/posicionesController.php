<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\posicionesModelo;
use App\Models\torneoModel;
use App\Models\equipo;

class posicionesController extends Controller
{
    // Mostrar roles + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('posiciones')
        ->join('torneos', 'posiciones.id_torneo','=','torneos.id_torneo')
        ->join('equipos', 'posiciones.id_equipo','=','equipos.id_equipo')
        ->select('posiciones.*','torneos.nombre_torneo','equipos.nombre_equipo');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_posicion','LIKE',"%{$search}%")
                  ->orWhere('id_torneo','LIKE',"%{$search}%")
                  ->orWhere('id_equipo','LIKE',"%{$search}%")
                  ->orWhere('pj','LIKE',"%{$search}%")
                  ->orWhere('pg','LIKE',"%{$search}%")
                  ->orWhere('pe','LIKE',"%{$search}%")
                  ->orWhere('pp','LIKE',"%{$search}%")
                  ->orWhere('gf','LIKE',"%{$search}%")
                  ->orWhere('gc','LIKE',"%{$search}%")
                  ->orWhere('gd','LIKE',"%{$search}%")
                  ->orWhere('puntos','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        return view("posiciones")->with("datos", $datos);
    }

    // Crear nuevo rol
    public function store(Request $request){
        $request->validate([
            'id_posicion' => 'required|unique:roles,id_rol',
            'id_torneo' => 'required',
            'id_equipo' => 'required',
            'pj' => 'required',
            'pg' => 'required',
            'pe' => 'required',
            'pp' => 'required',
            'gf' => 'required',
            'gc' => 'required',
            'gd' => 'required',
            'puntos' => 'required',
        ]);
        posicionesModelo::create($request->all());
        return redirect()->route('posiciones.index')->with('success','Datos registrado correctamente');
    }

    // Actualizar (modificar)
    public function update(Request $request, $id_posicion){
        $posicion = posicionesModelo::findOrFail($id_posicion);
        $posicion->update([
            'id_torneo' => $request->id_torneo,
            'id_equipo' => $request->id_equipo,
            'pj' => $request->pj,
            'pg' => $request->pg,
            'pe' => $request->pe,
            'pp' => $request->pp,
            'gf' => $request->gf,
            'gc' => $request->gc,
            'gd' => $request->gd,
            'puntos' => $request->puntos,
        ]);
        return redirect()->route('posiciones.index')->with('success','Datos actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_posicion){
        $posicion = posicionesModelo::findOrFail($id_posicion);
        $posicion->delete();
        return redirect()->route('posiciones.index')->with('success','Datos eliminado correctamente');
    }
    
}