<?php

namespace App\Exports;
use App\Archivo;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ArchivosExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $archivos=DB::table('archivos')
        ->join('libros','archivos.idlibros','=','libros.id')
        ->select('archivos.id','libros.titulo','libros.codigo','archivos.archivo','archivos.idlibros',
        'archivos.avance','archivos.observacion','archivos.iduser','archivos.created_at')
       // ->whereBetween('archivos.id', [5, 6])
        ->orderBy('archivos.id','desc')
        ->get();
      //  dd($archivos);
        return view('archivo.resumenexcel',["archivos"=>$archivos]); 


    }
}
