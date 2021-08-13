<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroLlamada extends Model
{
    protected $table='registrosllamadas';
    protected $fillable=['id','idclientes','iduser','idtipocontactos','llamada','duracion','observacion','idstatus','fecha_llamada'];


    public function clientes(){

        return $this->belongsTo('App\Cliente');
    }

    public function usuarios(){

        return $this->belongsTo('App\User');
    }

    public function contactos(){

        return $this->belongsTo('App\TipoContacto');
    }

    public function statusllamadas(){

        return $this->belongsTo('App\StatusLlamada');
    }
}
