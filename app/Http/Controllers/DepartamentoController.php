<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
class DepartamentoController extends Controller
{
    public function ListarDepartamento(){
        $departamento = Departamento::get();
        return response()->json($departamento);
    }
}
