<?php

namespace App\Http\Controllers;
//bf
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Departamento;
class DepartamentoController extends Controller
{
    public function ListarDepartamento(){
        $departamento = Departamento::get();
        return response()->json($departamento);
    }
    public function index()
    {
       
        $departamento=DB::table('departamento as d')->where('d.dep_estado','=','1')
        ->select('d.dep_id','d.dep_nombre')->get();
        return response()->json($departamento);

    }
    public function store(Request $request)
    {
        try{
            $departamento=new Departamento(); 
            $departamento->dep_nombre=$request->dep_nombre;
            $departamento->dep_estado='1';
            $departamento->save();
            return $departamento;

        }catch(Throwable $e){
            return "Error - ".$e->getMessage();
        }
    }
    public function show($id)
    {
        return Departamento::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $departamento=Departamento::findOrFail($id);
        $departamento->dep_nombre=$request->dep_nombre;
        $departamento->update(); 
        return 500;
    }
    public function destroy($id)
    {
        $departamento=Departamento::findOrFail($id);
        $departamento->dep_estado='0';
        $departamento->save();
        return 204;
    }
}
