<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function ListarMarca(){
        $marca = Marca::get();
        return response()->json($marca);
    }
    public function index()
    {
       
        $marca=DB::table('marca as m')->where('m.mar_estado','=','1')
        ->select('m.mar_id','m.mar_nombre')->get();
        return response()->json($marca);

    }
    public function store(Request $request)
    {
        try{
            $marca=new Marca(); 
            $marca->mar_nombre=$request->mar_nombre;
            $marca->mar_estado='1';
            $marca->save();
            return $marca;

        }catch(Throwable $e){
            return "Error - ".$e->getMessage();
        }
    }
    public function show($id)
    {
        return Marca::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $marca=Marca::findOrFail($id);
        $marca->mar_nombre=$request->mar_nombre;
        $marca->update(); 
        return 500;
    }
    public function destroy($id)
    {
        $marca=Marca::findOrFail($id);
        $marca->mar_estado='0';
        $marca->save();
        return 204;
    }
}
