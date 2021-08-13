<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    //
    protected $table = 'historialcorreos';
    protected $fillable = ['id', 'idarticulos', 'idautor', 'archivo', 'fecha_correo', 'observacion'];
}
