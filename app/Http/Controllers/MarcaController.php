<?php

namespace App\Http\Controllers;
use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function ListarMarca(){
        $marca = Marca::get();
        return response()->json($marca);
    }
}
