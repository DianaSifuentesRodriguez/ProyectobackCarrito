<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubi_dep extends Model
{
    protected $table = "ubigeo_peru_departments";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','name'];
}
