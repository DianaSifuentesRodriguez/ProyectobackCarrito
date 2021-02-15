<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function ListarProductos($id_dep){
        $producto=DB::table('producto as p')->where('dep_id', '=' , $id_dep)->select('p.pro_id', 'p.pro_nombre', 'p.pro_precio', 'p.pro_stock', 'p.mar_id', 'p.dep_id' ,'p.pro_cantidad' , 'p.pro_estado')->get();
        return response()->json($producto);
    }
}
