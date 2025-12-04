<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    // Mostrar usuarios + roles + búsqueda
    public function index(Request $request){
        $search = $request->input('search');
        
        $query = DB::table('usuarios')
            ->join('roles', 'roles.id_rol', '=', 'usuarios.id_rol')
            ->select('usuarios.*', 'roles.nombrerol');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('usuarios.id_usuario','LIKE',"%{$search}%")
                  ->orWhere('usuarios.nombre','LIKE',"%{$search}%")
                  ->orWhere('usuarios.apellido','LIKE',"%{$search}%")
                  ->orWhere('usuarios.correo','LIKE',"%{$search}%")
                  ->orWhere('roles.nombrerol','LIKE',"%{$search}%")
                  ->orWhere('usuarios.fecha_registro','LIKE',"%{$search}%")
                  ->orWhere('usuarios.fecha_nacimiento','LIKE',"%{$search}%")
                  ->orWhere('usuarios.estado','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);
        $roles = DB::table('roles')->get();

        return view("usuarios", compact('datos', 'roles'));
    }

    // Crear usuario
    public function store(Request $request){
        $request->validate([
            'id_usuario' => 'required|unique:usuarios,id_usuario',
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'id_rol' => 'required',
            'fecha_registro' => 'required',
            'fecha_nacimiento' => 'required',
            'estado' => 'required',
        ]);

        Usuario::create($request->all());

        return redirect()->route('usuarios.index')
                         ->with('success','Usuario registrado correctamente');
    }

    // Actualizar usuario
    public function update(Request $request, $id_usuario){
        $usuarios = Usuario::findOrFail($id_usuario);

        $usuarios->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'id_rol' => $request->id_rol,
            'fecha_registro' => $request->fecha_registro,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado' => $request->estado,
        ]);

        return redirect()->route('usuarios.index')
                         ->with('success','Usuario actualizado correctamente');
    }

    // Eliminar
    public function destroy($id_usuario){
        $usuarios = Usuario::findOrFail($id_usuario);
        $usuarios->delete();

        return redirect()->route('usuarios.index')
                         ->with('success','Usuario eliminado correctamente');
    }
}
