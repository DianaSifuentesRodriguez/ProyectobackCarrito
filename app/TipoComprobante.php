<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table = "tipo_comprobante";
    protected $primaryKey = "ti_id";
    public $timestamps = false;
    protected $filliable = ['ti_descripcion'];
}