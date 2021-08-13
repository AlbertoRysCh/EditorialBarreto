<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VendedoresExport implements FromView,ShouldAutoSize
{
    public  $data;
    public  $fecha_inicio;
    public  $fecha_fin;
    public  $anio;
    public  $vendedorSelect;
    public  $mes;
    public  $totales;


    public function __construct($data,$fecha_inicio, $fecha_fin,$anio,$vendedorSelect,$mes,$totales)
    {
        $this->data             = $data;
        $this->fecha_inicio     = $fecha_inicio;
        $this->fecha_fin        = $fecha_fin;
        $this->anio             = $anio;
        $this->vendedorSelect   = $vendedorSelect;
        $this->mes              = $mes;
        $this->totales          = $totales;
    }


    public function view(): View
    {
        return view('exports.vendedores', ['vendedores' => $this->data,'fecha_inicio'=>$this->fecha_inicio,
        'fecha_fin'=>$this->fecha_fin,'anio'=>$this->anio,'vendedorSelect'=>$this->vendedorSelect,'mes'=>$this->mes,
        'totales'=>$this->totales]);
    }
}
