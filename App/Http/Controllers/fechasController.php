<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\fechasModelo;

class fechasController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');


        $query = DB::table('fechas')

        ->join('torneos', 'fechas.id_torneo', '=', 'torneos.id_torneo')
        ->select(
            'fechas.*',
            'torneos.nombre_torneo as torneo_nombre',
        );

    if($search){
        $query->where(function ($q) use($search){
            $q->where('fechas.id_fecha','LIKE',"%{$search}%")
              ->orWhere('fechas.id_torneo','LIKE',"%{$search}%")
              ->orWhere('torneos.nombre_torneo','LIKE',"%{$search}%")
              ->orWhere('fechas.numero_fecha','LIKE',"%{$search}%")
              ->orWhere('fechas.fecha','LIKE',"%{$search}%")
              ->orWhere('fechas.estado','LIKE',"%{$search}%");
        });
    }
        $datos = $query->paginate(10)->appends($request->only('search'));

        $torneos = DB::table('torneos')->get();

        return view("fechas", compact('datos', 'torneos'));
    }
    
    public function create(){
    $torneos = DB::table('torneos')->get(); 

    return view('fechas.create', compact('torneos'));
    }

    //Crear
    public function store(Request $request){
        $request -> validate([
            'id_fecha' => 'required|unique:fechas,id_fecha',
            'id_torneo' => 'required',
            'numero_fecha'  => 'required',
            'fecha' => 'required',
            'estado' => 'required',
        ]);

        fechasModelo::create($request->all());

        return redirect()->route('fechas.index')
                     ->with('success', 'Fecha creada correctamente.');
    }

    //Actualizar
    public function update(Request $request, $id_fecha){
        $fecha = fechasModelo::findOrFail($id_fecha);
        $fecha ->update([
            'id_torneo' => $request->id_torneo,
            'numero_fecha' => $request->numero_fecha,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
        ]);
        return redirect()->route('fechas.index')->with('success','Fecha actualizada correctamente');
    }

    // Eliminar
    public function destroy($id_fecha){
        $fecha = fechasModelo::findOrFail($id_fecha);
        $fecha ->delete();
        return redirect()->route('fechas.index')->with('success','Fecha eliminada correctamente');
    }
}
