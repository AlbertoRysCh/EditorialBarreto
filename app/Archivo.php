<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table='archivos';
    protected $fillable=['id','idlibros','iduser','archivo','avance','observacion'];

    public function libros(){

        return $this->belongsTo('App\Libro');
    }

    public function users(){

        return $this->belongsTo('App\User');
    }
}
