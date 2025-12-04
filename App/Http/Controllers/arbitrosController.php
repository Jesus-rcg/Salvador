<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Arbitro;

class ArbitrosController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $query = DB::table('arbitros');

        if($search){
            $query->where(function ($q) use($search){
                $q->where('id_arbitro','LIKE',"%{$search}%")
                  ->orWhere('id_usuario','LIKE',"%{$search}%")
                  ->orWhere('licencia','LIKE',"%{$search}%")
                  ->orWhere('anos_experiencia','LIKE',"%{$search}%")
                  ->orWhere('categoria_arbitral','LIKE',"%{$search}%")
                  ->orWhere('estado','LIKE',"%{$search}%");
            });
        }

        $datos = $query->paginate(10);

        return view("arbitros", compact('datos'));
    }

    public function store(Request $request){
        DB::table('arbitros')->insert([
            'id_arbitro' => $request->id_arbitro,
            'id_usuario' => $request->id_usuario,
            'licencia' => $request->licencia,
            'anos_experiencia' => $request->anos_experiencia,
            'categoria_arbitral' => $request->categoria_arbitral,
            'estado' => $request->estado,
        ]);

        return redirect()->route('arbitros.index')
                         ->with('success', 'Árbitro creado correctamente.');
    }

    public function update(Request $request, $id){
        DB::table('arbitros')->where('id_arbitro', $id)->update([
            'id_usuario' => $request->id_usuario,
            'licencia' => $request->licencia,
            'anos_experiencia' => $request->anos_experiencia,
            'categoria_arbitral' => $request->categoria_arbitral,
            'estado' => $request->estado,
        ]);

        return redirect()->route('arbitros.index')
                         ->with('success', 'Árbitro actualizado correctamente.');
    }

    public function destroy($id){
        DB::table('arbitros')->where('id_arbitro', $id)->delete();

        return redirect()->route('arbitros.index')
                         ->with('success', 'Árbitro eliminado correctamente.');
    }
}