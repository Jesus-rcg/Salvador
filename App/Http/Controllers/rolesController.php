<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\rolesModelo;

class rolesController extends Controller
{
    // Mostrar roles + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('roles');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_rol','LIKE',"%{$search}%")
                  ->orWhere('nombrerol','LIKE',"%{$search}%")
                  ->orWhere('descripcion','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        return view("roles")->with("datos", $datos);
    }

    // Crear nuevo rol
    public function store(Request $request){
        $request->validate([
            'id_rol' => 'required|unique:roles,id_rol',
            'nombrerol' => 'required',
            'descripcion' => 'required',
        ]);

        rolesModelo::create($request->all());
        return redirect()->route('roles.index')->with('success','Rol registrado correctamente');
    }

    // Actualizar (modificar)
    public function update(Request $request, $id_rol){
        $rol = rolesModelo::findOrFail($id_rol);
        $rol->update([
            'nombrerol' => $request->nombrerol,
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('roles.index')->with('success','Rol actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_rol){
        $rol = rolesModelo::findOrFail($id_rol);
        $rol->delete();
        return redirect()->route('roles.index')->with('success','Rol eliminado correctamente');
    }
    
}