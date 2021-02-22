<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = "detalle_compra";
    protected $primaryKey = "pro_id";
    public $timestamps = false;
    protected $filliable = ['pro_id','com_num','dco_punitario','dco_cantidad','dco_subtotal'];
}