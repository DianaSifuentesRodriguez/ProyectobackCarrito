<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Throwable;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

    public function index()
    {
        $usuario = DB::table('usuario as u')->select('u.usu_dni', 'u.usu_apellidos', 'u.usu_nombres', 'u.usu_telefono', 'u.usu_celular', 'u.usu_direccion', 'u.usu_email', 'u.usu_password', 'u.usu_rol','u.usu_fech_reg', 'u.usu_estado', 'u.department_id', 'u.province_id', 'u.district_id')->get();
        return response()->json($usuario);
    }
    public function UsuLogin($log, $pass)
    {
        $login = Usuario::where('usu_email', '=', $log)->where('usu_estado', '=', '1')->get();
        if (count($login)>0) {
            if (password_verify($pass, $login[0]['usu_password'])) {
                return response()->json($login);
            } else {
                return 500;
            }
        } else {
            return 400;
        }
    }
    public function verifySession($id)
    {
        $login = DB::table('usuario as u')->where('u.usu_dni', '=', $id)->get();
        return response()->json($login);
    }
    public function store(Request $request)
    {
        try {
            if (Usuario::where('usu_email', '=', $request->usu_email)->exists()) {
                return 0;
            } else {
                $usuario = new Usuario();
                $usuario->usu_dni = $request->usu_dni;
                $usuario->usu_apellidos = $request->usu_apellidos;
                $usuario->usu_nombres = $request->usu_nombres;
                $usuario->usu_telefono = $request->usu_telefono;
                $usuario->usu_celular = $request->usu_celular;
                $usuario->usu_direccion = $request->usu_direccion;
                $usuario->usu_email = $request->usu_email;
                $usuario->usu_password = Hash::make($request->usu_password);
                if($request->usu_rol == null || $request->usu_rol == ''){
                    $usuario->usu_rol = 'cliente';
                }else{
                    $usuario->usu_rol = $request->usu_rol;
                }
                $usuario->usu_fech_reg = $request->usu_fech_reg;
                $usuario->usu_estado = '1';
                $usuario->department_id = $request->department_id;
                $usuario->province_id = $request->province_id;
                $usuario->district_id = $request->district_id;
                $usuario->save();
            }
        } catch (Throwable $e) {
            return "Error - " . $e->getMessage();
        }
    }

    public function CantidadUsuarios(){
        $CountUsu = DB::table('usuario as u')->select(DB::raw('count(u.usu_dni) as CantidadUsuarios'))->get();
        return response()->json($CountUsu);
    }
    
    public function show($id)
    {
        return Usuario::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->usu_dni = $request->usu_dni;
        $usuario->usu_apellidos = $request->usu_apellidos;
        $usuario->usu_nombres = $request->usu_nombres;
        $usuario->usu_direccion = $request->usu_direccion;
        $usuario->usu_email = $request->usu_email;
        $usuario->department_id = $request->department_id;
        $usuario->province_id = $request->province_id;
        $usuario->district_id = $request->district_id;
        $usuario->update();
        return $usuario;
    }

    public function passwordUpdate(Request $request, $id, $password){
        $usuario = Usuario::findOrFail($id);
        if (password_verify($password, $usuario->usu_password)) {
            $usuario->usu_password = Hash::make($request->usu_password);
            $usuario->update();
            return $usuario;
        } else {
            return 50;
        }
    }
    
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->usu_estado = '0';
        $usuario->save();
        return 204;
    }
}
