<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    //
    protected $table='historiales';
    protected $fillable=['id','idlibros','idasesor','titulo','fechaOrden',
    'fechaLlegada','fechaAsignacion','fechaCulminacion','fechaRevisionInterna',
    'fechaEnvioPro','fechaHabilitacion','fechaEnvio','fechaAjustes',
    'fechaAceptacion','fechaAprobacion','fechaRechazo','print','idstatu',
    'ideditoriales','idclasificacion','usuario','contrasenna','archivo','CheckNo'];


    public function articulos(){

        return $this->belongsTo('App\Articulo');
    }

}
