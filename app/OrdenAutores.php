<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenAutores extends Model
{
    //
    protected $table = 'orden_autores';
    protected $fillable = [
        'idordenautores',
        'idautor',
    ];
}
