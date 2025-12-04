<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria; 

class categoriasController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $datos = DB::table('categorias')
            ->when($search, function ($query, $search) {
                return $query->where('nombre_categoria', 'LIKE', "%{$search}%")
                             ->orWhere('descripcion', 'LIKE', "%{$search}%")
                             ->orWhere('edad_minima', 'LIKE', "%{$search}%")
                             ->orWhere('edad_maxima', 'LIKE', "%{$search}%");
            })
            ->orderBy('id_categoria', 'asc') ->paginate(10);

        return view('categorias', compact('datos'));
    }

    // Guarda
    public function store(Request $request)
    {
        DB::table('categorias')->insert([
            'nombre_categoria' => $request->nombre_categoria,
            'descripcion' => $request->descripcion,
            'edad_minima' => $request->edad_minima,
            'edad_maxima' => $request->edad_maxima,
        ]);

        return redirect()->route('categorias.index');
    }

    // Actualiza
    public function update(Request $request, $id)
    {
        DB::table('categorias')->where('id_categoria', $id)->update([
            'nombre_categoria' => $request->nombre_categoria,
            'descripcion' => $request->descripcion,
            'edad_minima' => $request->edad_minima,
            'edad_maxima' => $request->edad_maxima,
        ]);

        return redirect()->route('categorias.index');
    }

    // Elimina
    public function destroy($id)
    {
        DB::table('categorias')->where('id_categoria', $id)->delete();
        return redirect()->route('categorias.index');
    }
}
