<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";
    protected $primaryKey = "pro_id";
    public $timestamps = false;
    protected $filliable = ['pro_nombre','pro_precio','pro_stock','mar_id','dep_id','pro_cantidad'];
}