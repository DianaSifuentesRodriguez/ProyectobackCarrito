<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function ListarUbidep(){
        $ubi_dep = DB::table('ubigeo_peru_departments')->get();
        return response()->json($ubi_dep);
    }

    public function ListarUbiprov($ubi_dep_cod){
        $ubi_prov = DB::table('ubigeo_peru_provinces as up')->join('ubigeo_peru_departments as ud', 'up.department_id', '=', 'ud.id')
                    ->where('up.department_id', '=', $ubi_dep_cod)->select('up.id', 'up.name', 'up.department_id')->get();
        return response()->json($ubi_prov);
    }

    public function ListarUbidist($ubi_prov_cod){
        $ubi_dist = DB::table('ubigeo_peru_districts as ut')->join('ubigeo_peru_provinces as up', 'ut.province_id', '=', 'up.id')
                    ->join('ubigeo_peru_departments as ud', 'ut.department_id', '=', 'ud.id')->where('ut.province_id', '=', $ubi_prov_cod)
                    ->select('ut.id', 'ut.name', 'ut.province_id', 'ut.department_id')->get();
        return response()->json($ubi_dist);
    }
}
