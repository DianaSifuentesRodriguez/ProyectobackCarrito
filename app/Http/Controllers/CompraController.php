<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Producto;
use App\DetalleCompra;
use App\Delivery;
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
        $compra->com_periodo = '2021-02';
        $compra->pa_id = $array[0]['pa_id'];
        $compra->save();
        $last_ID = Compra::latest('com_num')->first();
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
            $delivery->department_id = $array[$tamanio-1]['department_id'];
            $delivery->province_id = $array[$tamanio-1]['province_id'];
            $delivery->district_id = $array[$tamanio-1]['district_id'];
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
}