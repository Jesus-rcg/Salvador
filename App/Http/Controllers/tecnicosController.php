<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\tecnicosModelo; // ✅ Agregar esta línea

class tecnicosController extends Controller
{
    // Mostrar técnicos + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('tecnicos');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_tecnico','LIKE',"%{$search}%")
                  ->orWhere('id_usuario','LIKE',"%{$search}%")
                  ->orWhere('id_equipo','LIKE',"%{$search}%")
                  ->orWhere('licencia','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        return view("tecnicos")->with("datos", $datos);
    }

    // Crear nuevo técnico
    public function store(Request $request){
        $request->validate([
            'id_tecnico' => 'required|unique:tecnicos,id_tecnico',
            'id_usuario' => 'required',
            'id_equipo' => 'required',
            'licencia' => 'required'
        ]);

        tecnicosModelo::create($request->all());
        return redirect()->route('tecnicos.index')->with('success','Técnico registrado correctamente');
    }

    // Actualizar (modificar)
    public function update(Request $request, $id_tecnico){
        $tecnicos = tecnicosModelo::findOrFail($id_tecnico);
        $tecnicos->update([
            'id_usuario' => $request->id_usuario,
            'id_equipo' => $request->id_equipo,
            'licencia' => $request->licencia,
        ]);
        return redirect()->route('tecnicos.index')->with('success','Técnico actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_tecnico){
        $tecnicos = tecnicosModelo::findOrFail($id_tecnico); // ✅ Corregido el nombre
        $tecnicos->delete();
        return redirect()->route('tecnicos.index')->with('success','Técnico eliminado correctamente');
    }
}