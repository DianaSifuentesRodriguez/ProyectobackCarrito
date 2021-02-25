<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "usuario";
    protected $primaryKey = "usu_dni";
    public $timestamps = false;
    protected $filliable = ['usu_dni','usu_apellidos','usu_nombres','usu_telefono','usu_celular','usu_direccion','usu_email','usu_password', 'usu_rol','usu_fech_reg','usu_estado', 'department_id', 'province_id', 'district_id'];
    protected $attributes = [
            'usu_rol' => 'cliente',
    ];
}
