<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\premiacionModelo;

class premiacionController extends Controller
{
    // Mostrar resultados + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('premiacion');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_premiacion','LIKE',"%{$search}%")
                  ->orWhere('id_torneo','LIKE',"%{$search}%")
                  ->orWhere('id_equipo','LIKE',"%{$search}%")
                  ->orWhere('posicion','LIKE',"%{$search}%")
                  ->orWhere('premio','LIKE',"%{$search}%")
                  ->orWhere('descripcion','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        return view("premiacion")->with("datos", $datos);
    }

    // Crear nueva pemiacion
    public function store(Request $request){
        $request->validate([
            'id_premiacion' => 'required|unique:resultados,id_resultado',
            'id_torneo' => 'required',
            'id_equipo' => 'required',
            'posicion' => 'required',
            'premio' => 'required',
            'descripcion' => 'required',
        ]);

        premiacionModelo::create($request->all());
        return redirect()->route('premiacion.index')->with('success','Premiacion registrada correctamente');
    }

    // Actualizar (modificar)
    public function update(Request $request, $id_premiacion){
        $premiacion = premiacionModelo::findOrFail($id_premiacion);
        $premiacion->update([
            'id_torneo' => $request->id_torneo,
            'id_equipo' => $request->id_equipo,
            'posicion' => $request->posicion,
            'premio' => $request->premio,
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('premiacion.index')->with('success','Datos actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_premiacion){
        $premiacion = premiacionModelo::findOrFail($id_premiacion);
        $premiacion->delete();
        return redirect()->route('premiacion.index')->with('success','Datos eliminado correctamente');
    }
    
}