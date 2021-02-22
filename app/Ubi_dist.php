<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubi_dist extends Model
{
    protected $table = "ubigeo_peru_districts";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','name', 'province_id', 'department_id'];
}
