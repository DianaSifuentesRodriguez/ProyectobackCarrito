<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table = "compra";
    protected $primaryKey = "com_mun";
    public $timestamps = false;
    protected $filliable = ['com_fecha','com_totalneto','com_descuento','com_total','usu_dni','com_comercio','ti_id','com_estado','com_doi','com_tipodoi','com_serie','com_ncom','com_periodo','com_isdelivery','pa_id'];
}
