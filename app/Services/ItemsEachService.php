<?php

namespace App\Services;

use App\AsesorVenta;
use Illuminate\Support\Facades\Config;
class ItemsEachService
{
    public function getAsesores()
    {
        $asesores = AsesorVenta::join('users','asesorventas.idusuario','=','users.id')
        ->select('users.id','asesorventas.nombres','asesorventas.num_documento')
        // ->whereNotIn('users.id',array(Config::get('params.global.asesor_venta_default')))
        ->where('asesorventas.condicion','=','1')->get(); 

        $asesorArray[''] = 'Selecciona un asesor de venta';
        foreach ($asesores as $asesor) {
            $num_documento = isset($asesor->num_documento) ? $asesor->num_documento.' - ' : '';
            $asesorArray[$asesor->id] = $num_documento.$asesor->nombres;
        }
        return $asesorArray;
    }
}