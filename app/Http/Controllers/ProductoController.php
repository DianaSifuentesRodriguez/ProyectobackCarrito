<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index()
    {
       
        $producto=DB::table('producto as p')->join('departamento as d','d.dep_id','=','p.dep_id')->join('marca as m','m.mar_id','=','p.mar_id')->where('p.pro_estado','=','1')->select('p.pro_id','p.pro_nombre','p.pro_precio','p.pro_stock','m.mar_id','d.dep_id','p.pro_cantidad','d.dep_nombre'
        ,'m.mar_nombre')->get();
        return response()->json($producto);

    }
    public function GetDescripcionProducto($pro_nombre,$id_dep)
    {
       
        $producto=DB::table('producto as p')->join('departamento as d','d.dep_id','=','p.dep_id')->join('marca as m','m.mar_id','=','p.mar_id')->where('p.pro_estado','=','1')->where('p.dep_id', '=' , $id_dep)->where('p.pro_nombre','like','%'.$pro_nombre.'%')->select('p.pro_id','p.pro_nombre','p.pro_precio','p.pro_stock','m.mar_id','m.mar_nombre as marca','d.dep_id','d.dep_nombre as departamento','p.pro_cantidad')->get();
        return response()->json($producto);

    }
    public function GetDescripcionProductoOnly($pro_nombre)
    {
       
        $producto=DB::table('producto as p')->join('departamento as d','d.dep_id','=','p.dep_id')->join('marca as m','m.mar_id','=','p.mar_id')->where('p.pro_estado','=','1')->where('p.pro_nombre','like','%'.$pro_nombre.'%')->select('p.pro_id','p.pro_nombre','p.pro_precio','p.pro_stock','m.mar_id','m.mar_nombre as marca','d.dep_id','d.dep_nombre as departamento','p.pro_cantidad')->get();
        return response()->json($producto);

    }
    public function ListarProductos($id_dep){
        $producto=DB::table('producto as p')->where('dep_id', '=' , $id_dep)->where('p.pro_estado','=','1')->select('p.pro_id', 'p.pro_nombre', 'p.pro_precio', 'p.pro_stock', 'p.mar_id', 'p.dep_id' ,'p.pro_cantidad' , 'p.pro_estado')->get();
        return response()->json($producto);

    }
    public function store(Request $request)
    {
        try{
            $producto=new Producto(); 
            $producto->pro_nombre=$request->pro_nombre;
            $producto->pro_precio=$request->pro_precio;
            $producto->pro_stock=$request->pro_stock;
            $producto->mar_id=$request->mar_id;
            $producto->dep_id=$request->dep_id;
            $producto->pro_cantidad=$request->pro_cantidad;
            $producto->pro_estado='1';
            $producto->save();
            return $producto;

        }catch(Throwable $e){
            return "Error - ".$e->getMessage();
        }
    }
    public function show($id)
    {
        return Producto::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $producto=Producto::findOrFail($id);
        $producto->pro_nombre=$request->pro_nombre;
        $producto->pro_precio=$request->pro_precio;
        $producto->pro_stock=$request->pro_stock;
        $producto->mar_id=$request->mar_id;
        $producto->dep_id=$request->dep_id;
        $producto->pro_cantidad=$request->pro_cantidad;
        $producto->update(); 
        return 500;
    }
    public function destroy($id)
    {
        $producto=Producto::findOrFail($id);
        $producto->pro_estado='0';
        $producto->save();
        return 204;
    }
}
