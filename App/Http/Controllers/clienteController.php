<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class clienteController extends Controller
{
    public function index(){
        $datos = DB::select("select * from cliente");
        return view("cliente")->with("datos, $datos");
    }
}
