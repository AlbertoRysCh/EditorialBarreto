<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoautoresTemporal extends Model
{
    //
    protected $table = 'coautores_temp';
    protected $guarded =  [];

    public static function getCoautores($id)
    {
        return CoautoresTemporal::select('coautores_temp.autor_id','autores.nombres','coautores_temp.contrato_id')
        ->join('autores','coautores_temp.autor_id','=','autores.id')
        ->where('coautores_temp.contrato_id',$id)
        ->get();
    }

}
