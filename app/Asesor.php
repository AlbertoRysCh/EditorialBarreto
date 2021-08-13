<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    //
    protected $table='asesors';
    protected $fillable=['id','usuario_id','num_documento','nombres','telefono','correo'];

    public function users(){

        return $this->hasOne('App\User');
    }

    public function articulos(){

        return $this->hasMany('App\Articulo');
    }
}
