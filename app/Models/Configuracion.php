<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';
    protected $guarded =  [];
    
    public static function listVersion() {
		  return Configuracion::where('code','VERSION_APP')->first()->value;
    }

    public static function listMantenimiento() {
		  return Configuracion::where('code','MANTENIMIENTO_WEB')->first()->value;
    }
}
