<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table='actividades';
    protected $fillable=['id','usuario_id','idlibros','idstatu','avancemañana','avancetarde','observacion'];


    public function libros(){

        return $this->belongsTo('App\Libro');
    }

    public function users(){

        return $this->belongsTo('App\User');
    }

    public function status(){

        return $this->belongsTo('App\Status');
    }
}
