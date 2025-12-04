<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\lugaresModelo;

class lugaresController extends Controller
{
    // Mostrar roles + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('lugares');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_lugar','LIKE',"%{$search}%")
                  ->orWhere('nombre_lugar','LIKE',"%{$search}%")
                  ->orWhere('direccion','LIKE',"%{$search}%")
                  ->orWhere('ciudad','LIKE',"%{$search}%")
                  ->orWhere('capacidad','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        return view("lugares")->with("datos", $datos);
    }

    // Crear nuevo rol
    public function store(Request $request){
        $request->validate([
            'id_lugar' => 'required|unique:lugares,id_lugar',
            'nombre_lugar' => 'required',
            'direccion' => 'required',
            'ciudad' => 'required',
            'capacidad' => 'required',
        ]);

        lugaresModelo::create($request->all());
        return redirect()->route('lugares.index')->with('success', 'Lugar registrado correctamente');
    }

    // Actualizar (modificar)
    public function update(Request $request, $id_lugar){
        $lugar = lugaresModelo::findOrFail($id_lugar);
        $lugar->update([
            'nombre_lugar' => $request->nombre_lugar,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'capacidad' => $request->capacidad,
        ]);
        return redirect()->route('lugares.index')->with('success','Lugar actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_lugar){
        $rol = lugaresModelo::findOrFail($id_lugar);
        $rol->delete();
        return redirect()->route('lugares.index')->with('success','Lugar eliminado correctamente');
    }

    
}
