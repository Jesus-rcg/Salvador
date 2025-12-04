<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Torneo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index()
    {
        $search = request('search');

        $inscripciones = Inscripcion::with(['usuario', 'torneo'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('usuario', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('apellido', 'like', "%{$search}%");
                })
                ->orWhereHas('torneo', function ($q) use ($search) {
                    $q->where('nombre_torneo', 'like', "%{$search}%");
                })
                ->orWhere('estado', 'like', "%{$search}%");
            })
            ->orderBy('fecha_inscripcion', 'desc')
            ->paginate(10);

        $usuarios = Usuario::where('estado', 'activo')->get();
        $torneos = Torneo::whereIn('estado', ['planificado', 'en_curso'])->get();

        return view('inscripciones', compact('inscripciones', 'usuarios', 'torneos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_torneo' => 'required|exists:torneos,id_torneo',
            'fecha_inscripcion' => 'required|date',
            'estado' => 'required',
            'observaciones' => 'nullable|string|max:500'
        ]);

        if (Inscripcion::where('id_usuario', $request->id_usuario)
            ->where('id_torneo', $request->id_torneo)
            ->exists()) {
            return back()->with('error', 'Este usuario ya está inscrito en este torneo.');
        }

        Inscripcion::create($request->all());

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción creada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_inscripcion' => 'required|date',
            'estado' => 'required',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->update($request->all());

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción actualizada correctamente.');
    }

    public function destroy($id)
    {
        Inscripcion::findOrFail($id)->delete();

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción eliminada.');
    }
}
