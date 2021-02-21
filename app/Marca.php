<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = "marca";
    protected $primaryKey = "mar_id";
    public $timestamps = false;
    protected $filliable = ['mar_nombre'];
}
