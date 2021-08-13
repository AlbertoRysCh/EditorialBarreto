<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    //
    protected $table='editoriales';
    protected $fillable=['id','codigo','nombre','descripcion','lineaInvestigacion','idioma','pais','enlace','idperiodo','idnivelindex','condicion','sjr','citescore','articulo_numero','review','tiempo_respuesta','referencias','citados','open_access','nivel_rechazo'];
    public function periocidades(){

        return $this->belongsTo('App\Periocidad');
    }
}
