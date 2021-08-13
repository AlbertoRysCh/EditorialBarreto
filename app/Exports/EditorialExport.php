<?php

namespace App\Exports;
use App\Editorial;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EditorialExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {

        $editoriales=DB::table('editoriales')
        ->join('periocidades','editoriales.idperiodo','=','periocidades.id')
        ->join('niveles','editoriales.idnivelindex','=','niveles.id')
        ->select('editoriales.id','editoriales.codigo','editoriales.lineaInvestigacion','editoriales.nombre','editoriales.descripcion',
        'editoriales.condicion','editoriales.idperiodo','editoriales.idnivelindex','editoriales.nombre as nivelesnombre','periocidades.nombre as nombreperiocidad','editoriales.idioma','editoriales.pais','editoriales.enlace')
        ->orderBy('editoriales.id','asc')
        ->get();
        return view('editorial.exportarexcel',["editoriales"=>$editoriales]); 

    }
}
