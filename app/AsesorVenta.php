<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsesorVenta extends Model
{
    protected $table='asesorventas';
    protected $fillable=['usuario_id','num_documento','nombres','telefono','correo'];

    public function users(){

        return $this->hasOne('App\User');
    }

    public function revisiones(){

        return $this->hasMany('App\Revision');
    }
}
