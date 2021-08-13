<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    //
    protected $table='revisiones';
    protected $fillable=['id','codigo','titulo','usuario_id','idclientes','idnivelarticulo','idtipoeditoriales','puntaje','observaciones','archivo','archivoevaluador','condicion','estado_revision','revisado_por','contrato_id'];
    // public $timestamps=false;

    public function asesores(){

        return $this->belongsTo('App\AsesorVenta');
    }

    public function clientes(){

        return $this->belongsTo('App\Cliente');
    }

    public function niveles(){

        return $this->belongsTo('App\Nivelarticulo');
    }
}
