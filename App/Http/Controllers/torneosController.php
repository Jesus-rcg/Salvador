<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Torneo;

class TorneosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $datos = DB::table('torneos')
            ->leftJoin('categorias', 'torneos.id_categoria', '=', 'categorias.id_categoria')
            ->leftJoin('usuarios', 'torneos.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'torneos.*',
                'categorias.nombre_categoria',
                DB::raw("CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS usuario_nombre_completo")
            )
            ->when($search, function ($query, $search) {
                return $query->where('nombre_torneo', 'LIKE', "%{$search}%")
                             ->orWhere('ciudad', 'LIKE', "%{$search}%");
            })
            ->orderBy('id_torneo', 'asc')
            ->paginate(10);

        $categorias = DB::table('categorias')->get();
        $usuarios = DB::table('usuarios')->get();

        return view('torneos', compact('datos', 'categorias', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_torneo' => 'required',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'required|date',
            'ciudad'        => 'required',
            'id_categoria'  => 'required',
            'id_usuario'    => 'required',
            'estado'        => 'required',
            'max_equipos'   => 'required|numeric',
            'tipo_torneo'   => 'nullable|string',
            'imagen' => 'required'
        ]);

        DB::table('torneos')->insert([
            'nombre_torneo' => $request->nombre_torneo,
            'fecha_inicio'  => $request->fecha_inicio,
            'fecha_fin'     => $request->fecha_fin,
            'ciudad'        => $request->ciudad,
            'id_categoria'  => $request->id_categoria,
            'id_usuario'    => $request->id_usuario,
            'estado'        => $request->estado,
            'max_equipos'   => $request->max_equipos,
            'tipo_torneo'   => $request->tipo_torneo,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('torneos.index');
    }

    public function update(Request $request, $id)
    {
        DB::table('torneos')->where('id_torneo', $id)->update([
            'nombre_torneo' => $request->nombre_torneo,
            'fecha_inicio'  => $request->fecha_inicio,
            'fecha_fin'     => $request->fecha_fin,
            'ciudad'        => $request->ciudad,
            'id_categoria'  => $request->id_categoria,
            'id_usuario'    => $request->id_usuario,
            'estado'        => $request->estado,
            'max_equipos'   => $request->max_equipos,
            'tipo_torneo'   => $request->tipo_torneo,
            'images' => $request->images,
        ]);

        return redirect()->route('torneos.index');
    }

    public function destroy($id)
    {
        try {
            $torneo = Torneo::findOrFail($id);
            $torneo->delete();

            return redirect()
                ->route('torneos.index')
                ->with('success', 'Torneo eliminado exitosamente');

        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == "23000") {
                return redirect()
                    ->route('torneos.index')
                    ->with('error', 'No se puede eliminar porque está relacionado con otros registros');
            }

            return redirect()
                ->route('torneos.index')
                ->with('error', 'Error inesperado. Contacte al administrador.');
        }
    }

    public function inicioVisitante()
    {
        $torneos = Torneo::orderBy('id_torneo', 'desc')->take(3)->get();
        return view('index', compact('torneos'));
    }
}