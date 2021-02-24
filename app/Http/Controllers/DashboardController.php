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

    public function UsuariosConMasCompras(){
        $Compras = DB::table('usuario as u')->join('compra as c','c.usu_dni','=','u.usu_dni')
        ->where('u.usu_estado','=','1')->select('u.usu_dni','c.com_fecha');
        return response()->json($Compras);
    
    }

    // public function RegistroSemana(){
    //     $semana = DB::table('usuario as u')->whereDay('');
    // }

}
