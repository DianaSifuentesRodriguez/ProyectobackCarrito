<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\DetalleCompra;
use App\Delivery;
use App\Producto;
use Illuminate\Support\Facades\DB;
class CompraController extends Controller
{
    public function InsertarCompra(Request $request){
        $array = $request->json()->all();
        $fechact = new \DateTime();
        $compra = new Compra();
        $compra->com_fecha = $fechact->format('d-m-Y H:i:s');
        $compra->com_totalneto = $array[0]['com_totalneto'];
        $compra->com_descuento = $array[0]['com_descuento'];
        $compra->com_total = $array[0]['com_total'];
        $compra->usu_dni = $array[0]['usu_dni'];
        $compra->com_comercio = $array[0]['com_comercio'];
        $compra->ti_id = $array[0]['ti_id'];
        $compra->com_estado = $array[0]['com_estado'];
        $compra->com_doi = $array[0]['com_doi'];
        $compra->com_tipodoi = $array[0]['com_tipodoi'];
        $compra->com_isdelivery = $array[0]['com_isdelivery'];
        if($array[0]['ti_id'] == 1){
            $compra->com_serie = 'F001';
            $fac = Compra::where('ti_id', '=', 1)->get();
            $countFac = $fac->count();
            $compra->com_ncom = $countFac + 1;
        }else{
            $compra->com_serie = 'B001';
            $bol = Compra::where('ti_id', '=', 2)->get();
            $countBol = $bol->count();
            $compra->com_ncom = $countBol + 1;
        }
        $compra->com_periodo = $array[0]['com_periodo'];
        $compra->pa_id = $array[0]['pa_id'];
        $compra->save();
        $last_ID = $compra->com_num;
        $tamanio = sizeof($array);
        if($array[0]['com_isdelivery'] == 1){
            for($i = 1; $i<$tamanio-1; $i++) {
                $detalle_compra = new DetalleCompra();
                $detalle_compra->pro_id = $array[$i]['pro_id'];
                $detalle_compra->com_num = $last_ID;
                $detalle_compra->dco_punitario = $array[$i]['dco_punitario'];
                $detalle_compra->dco_cantidad = $array[$i]['dco_cantidad'];
                $detalle_compra->dco_subtotal = $array[$i]['dco_subtotal'];
                $detalle_compra->save();
    
                $producto = Producto::findOrFail($array[$i]['pro_id']);
                $producto->pro_cantidad = $producto->pro_cantidad - $array[$i]['dco_cantidad'];
                if($producto->pro_cantidad == $producto->pro_stock ){
                    $producto->pro_estado = 0;
                }
                $producto->update();
            }
            $delivery = new Delivery();
            $delivery->com_num = $last_ID;
            $delivery->del_precio = $array[$tamanio-1]['del_precio'];
            $delivery->del_fentrega = $array[$tamanio-1]['del_fentrega'];
            $delivery->del_estado = $array[$tamanio-1]['del_estado'];
            $delivery->department_id = $array[$tamanio-1]['del_deparment_id'];
            $delivery->province_id = $array[$tamanio-1]['del_province_id'];
            $delivery->district_id = $array[$tamanio-1]['del_district_id'];
            $delivery->del_calle = $array[$tamanio-1]['del_calle'];
            $delivery->save();

        }else{
            for($i = 1; $i<$tamanio; $i++) {
                $detalle_compra = new DetalleCompra();
                $detalle_compra->pro_id = $array[$i]['pro_id'];
                $detalle_compra->com_num = $last_ID;
                $detalle_compra->dco_punitario = $array[$i]['dco_punitario'];
                $detalle_compra->dco_cantidad = $array[$i]['dco_cantidad'];
                $detalle_compra->dco_subtotal = $array[$i]['dco_subtotal'];
                $detalle_compra->save();
    
                $producto = Producto::findOrFail($array[$i]['pro_id']);
                $producto->pro_cantidad = $producto->pro_cantidad - $array[$i]['dco_cantidad'];
                if($producto->pro_cantidad == $producto->pro_stock ){
                    $producto->pro_estado = 0;
                }
                $producto->update();
            }
            
        }

    }

    public function HistorialCompra($id_usuario){
        $Hcompra = DB::table('compra as c')->join('usuario as u', 'u.usu_dni', '=', 'c.usu_dni')->where('c.usu_dni', '=', $id_usuario)
        ->select(DB::raw('CONCAT(c.com_serie, \'-\', c.com_ncom) as NroComprobante, c.com_tipodoi, c.com_doi, c.com_estado, c.com_fecha, 
                        c.com_num, c.usu_dni'))
        ->orderBy('c.com_fecha')->get();
        return response()->json($Hcompra);
    }

    public function ComprasPorPeriodo(){
        $Pcompra = DB::table('compra as c')->select(DB::raw('count(c.com_num) as NroCompras, c.com_periodo'))
                    ->groupBy('c.com_periodo')->get();
        return response()->json($Pcompra);
    }
    
    public function CantidadCompras(){
        $Ccompras = DB::table('compra as c')->select(DB::raw('count(c.com_num) as NroCompras'))
                    ->get();
        return response()->json($Ccompras);
    }

    public function ListarDetalleCompra($id_compra){
        $detalle = DB::table('detalle_compra as dc')->join('compra as c', 'c.com_num', '=', 'dc.com_num')->join('producto as p', 'p.pro_id', '=', 'dc.pro_id')
        ->where('dc.com_num', '=', $id_compra)->select('dc.com_num','dc.pro_id', 'p.pro_nombre','dc.dco_punitario', 'dc.dco_cantidad', 'dc.dco_subtotal')
        ->get();
        return response()->json($detalle);
    }

    
    public function ListarUsuariosTOP(){
        $TOPusuarios = DB::table('usuario as u')->join('compra as c', 'c.usu_dni', '=', 'u.usu_dni')
        ->select(DB::raw('count(c.com_num) as ComprasRealizadas, c.usu_dni, CONCAT(u.usu_apellidos, \' \',u.usu_nombres) as NombreUsuario'))->groupBy('c.usu_dni')
        ->groupByRaw('CONCAT(u.usu_apellidos, \' \',u.usu_nombres)')->orderByRaw('count(c.com_num) DESC')->get();
        return response()->json($TOPusuarios);
    }
    //Usuarios ------
    
    //---------------

    public function Prueba(Request $request){
        $array = $request->json()->all();
        $tamanio = sizeof($array);
        return $tamanio;          
    }
}