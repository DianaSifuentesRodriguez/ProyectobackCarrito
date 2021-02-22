<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = "delivery";
    protected $primaryKey = "com_num";
    public $timestamps = false;
    protected $filliable = ['com_num','del_precio','del_fentrega','del_estado','department_id','province_id','district_id', 'del_calle'];
}