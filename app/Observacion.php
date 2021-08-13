<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    //
    protected $table='observaciones';
    protected $fillable = ['ïdarticulo','descripcion','archivo'];

    public function articulos(){

        return $this->belongsTo('App\Articulo');
    }

}
