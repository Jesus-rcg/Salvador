<?php

namespace App\Http\Controllers;

use App\Models\Encuentro;
use App\Models\fechasModelo;
use App\Models\Torneo;
use App\Models\lugaresModelo;
use App\Models\arbitrosModelo;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EncuentrosController extends Controller
{
    public function index(Request $request)
    {
        $fechas = fechasModelo::all();
        $torneos = Torneo::all();
        $lugares = lugaresModelo::all();
        $arbitros = arbitrosModelo::all();
        $equipos = Equipo::all();

        // Buscar si hay query
        $query = Encuentro::with(['fecha', 'torneo', 'lugar', 'arbitro', 'equipoLocal', 'equipoVisitante']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('torneo', fn($q) => $q->where('nombre_torneo', 'like', "%$search%"))
                  ->orWhereHas('fecha', fn($q) => $q->where('fecha', 'like', "%$search%"))
                  ->orWhereHas('equipoLocal', fn($q) => $q->where('nombre_equipo', 'like', "%$search%"))
                  ->orWhereHas('equipoVisitante', fn($q) => $q->where('nombre_equipo', 'like', "%$search%"));
        }

        $datos = $query->paginate(10);

        return view('encuentros', compact('fechas', 'torneos', 'lugares', 'arbitros', 'equipos', 'datos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_fecha' => 'required|integer',
            'hora' => 'required',
            'id_torneo' => 'required|integer',
            'id_lugar' => 'required|integer',
            'id_arbitro' => 'required|integer',
            'id_equipo_local' => 'required|integer',
            'id_equipo_visitante' => 'required|integer',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        Encuentro::create($request->all());
        return back()->with('success', 'Encuentro creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_fecha' => 'required|integer',
            'hora' => 'required',
            'id_torneo' => 'required|integer',
            'id_lugar' => 'required|integer',
            'id_arbitro' => 'required|integer',
            'id_equipo_local' => 'required|integer',
            'id_equipo_visitante' => 'required|integer',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $encuentro = Encuentro::findOrFail($id);
        $encuentro->update($request->all());
        return back()->with('success', 'Encuentro actualizado correctamente.');
    }

    public function destroy($id)
    {
        Encuentro::findOrFail($id)->delete();
        return back()->with('success', 'Encuentro eliminado correctamente.');
    }
}
