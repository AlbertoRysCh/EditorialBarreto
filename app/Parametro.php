<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Parametro extends Model
{
    //
    protected $table = 'parametros';
    protected $guarded =  [];

    public static function mantenimientoWeb() {
		return Parametro::select(DB::raw('parametros.*'))
						->where('codigo','MANTENIMIENTO_WEB')
						->first();
    }
}
