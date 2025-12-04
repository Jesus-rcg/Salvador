<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\equipo;

class equiposController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $datos = DB::table('equipos')
            ->join('categorias', 'equipos.id_categoria', '=', 'categorias.id_categoria')
            ->select('equipos.*', 'categorias.nombre_categoria')
            ->when($search, function ($query, $search) {
                return $query->where('nombre_equipo', 'LIKE', "%{$search}%")
                             ->orWhere('ciudad', 'LIKE', "%{$search}%");
            })
            ->orderBy('id_equipo', 'asc')
            ->paginate(10);

        $escudosMap = [
            'Tigres FC' => 'https://dimayor.com.co/wp-content/uploads/2024/06/TIGRES-FC.png',
            'junior FC' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/ESCUDO_JUNIOR.svg/1024px-ESCUDO_JUNIOR.svg.png',
            'inter miami FC' =>'https://elparquedelosdibujos.com/colorear/dibujos-colorear-deportes/futbol/escudos-de-futbol/escudos-de-futbol-img/escudo-del-inter-miami-club-de-futbol-version-2-.webp',
            'las trenzas del calvo' =>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8AzsB9oyEwivSquj0Y_YanemnexyhorutGuEuXCj-UpBHQ4C__OJvOTNhigGTMPNu4NQ&usqp=CAU',
            'barcelona FC' => 'https://static.vecteezy.com/system/resources/thumbnails/014/414/712/small/fc-barcelona-logo-on-transparent-background-free-vector.jpg'
        ];

        // Asignar URL de escudos a cada equipo
        $datos->getCollection()->transform(function ($equipo) use ($escudosMap) {
            $equipo->escudo_final = $escudosMap[$equipo->nombre_equipo] ?? $equipo->escudo_url;
            return $equipo;
        });

        $categorias = DB::table('categorias')->get();

        return view('equipos', compact('datos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_equipo' => 'required',
            'ciudad' => 'required',
            'id_categoria' => 'required',
            'estado' => 'required',
        ]);

        DB::table('equipos')->insert([
            'nombre_equipo' => $request->nombre_equipo,
            'ciudad'        => $request->ciudad,
            'id_categoria'  => $request->id_categoria,
            'escudo_url'    => $request->escudo_url,
            'estado'        => $request->estado,
        ]);

        return redirect()->route('equipos.index');
    }

    public function update(Request $request, $id)
    {
        DB::table('equipos')->where('id_equipo', $id)->update([
            'nombre_equipo' => $request->nombre_equipo,
            'ciudad'        => $request->ciudad,
            'id_categoria'  => $request->id_categoria,
            'escudo_url'    => $request->escudo_url,
            'estado'        => $request->estado,
        ]);

        return redirect()->route('equipos.index');
    }

    public function destroy($id)
{
    try {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()
            ->route('equipos.index')
            ->with('success', 'Equipo eliminado de la base de datos');
            
    } catch (\Illuminate\Database\QueryException $e) {

        if ($e->getCode() == "23000") {
            return redirect()
                ->route('equipos.index')
                ->with('error', 'No se puede eliminar el equipo porque está relacionado con otro registro');
        }

        return redirect()
            ->route('equipos.index')
            ->with('error', 'Error al eliminar el registro, comuníquese con el administrador del sistema');
    }
}

}