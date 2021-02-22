<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubi_prov extends Model
{
    protected $table = "ubigeo_peru_provinces";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['name','department_id'];
}
