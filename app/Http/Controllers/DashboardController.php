<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Usuario;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function TotalClientes(){
        $TotalC = DB::table('usuario as u')->where('u.usu_estado','=','1')->count();
        return response()->json($TotalC);
    
    }
    // public function RegistroSemana(){
    //     $semana = DB::table('usuario as u')->whereDay('');
    // }

}
