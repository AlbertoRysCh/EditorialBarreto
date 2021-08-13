<?php

namespace App\Exports;
use App\Actividad;
use App\DetallesArticulos;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


use Illuminate\Support\Facades\DB;

class ActividadExport implements FromView
{
   
    public function view(): View
    {

        $actividades=DB::table('actividades')
        ->join('articulos','actividades.idarticulo','=','articulos.id')
        ->join('clasificaciones','articulos.idclasificacion','=','clasificaciones.id')
        ->join('users','actividades.idusuario','=','users.id')
        ->select('actividades.id as idactividad','actividades.avancemañana','articulos.codigo','actividades.avancetarde','actividades.observacion','users.nombre as nombreusuario',
        'actividades.created_at','articulos.id as idarticulo','articulos.titulo','clasificaciones.nombre as clasificacionesnombre', DB::raw(' (actividades.avancemañana + actividades.avancetarde) AS suma'))
      ->orderBy('actividades.created_at','desc')
        ->get();

        $detalles = DetallesArticulos::join('autores','detallesarticulos.idautor','=','autores.id')
        ->join('articulos','detallesarticulos.idarticulo','=','articulos.id')
        ->select('detallesarticulos.id','autores.especialidad','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','autores.telefono','autores.orcid','autores.correogmail','autores.contrasena','articulos.id','articulos.idstatu','articulos.fechaLlegada')
        ->where('articulos.condicion','=','1')
        ->get();   

        
        return view('actividad.resumenexcel',["actividades"=>$actividades,"detalles"=>$detalles]); 


   

    }
}
