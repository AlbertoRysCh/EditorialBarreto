<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table='areas';
    protected $fillable=['id','codigo','nombre','descripcion','condicion'];

    public function libros(){

        return $this->hasMany('App\Libro');
    }
}
