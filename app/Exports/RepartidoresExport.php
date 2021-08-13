<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class RepartidoresExport implements WithColumnFormatting,FromView,ShouldAutoSize
{
    public  $data;
    public  $fecha_inicio;
    public  $fecha_fin;
    public  $anio;
    public  $repartidorSelect;
    public  $mes;
    public  $totales;


    public function __construct($data,$fecha_inicio, $fecha_fin,$anio,$repartidorSelect,$mes,$totales)
    {
        $this->data             = $data;
        $this->fecha_inicio     = $fecha_inicio;
        $this->fecha_fin        = $fecha_fin;
        $this->anio             = $anio;
        $this->repartidorSelect   = $repartidorSelect;
        $this->mes              = $mes;
        $this->totales          = $totales;
    }

    public function columnFormats(): array
    {
    return [
        'O' => NumberFormat::FORMAT_NUMBER_00,
    ];


    }
    public function view(): View
    {
        return view('exports.repartidores', ['repartidores' => $this->data,'fecha_inicio'=>$this->fecha_inicio,
        'fecha_fin'=>$this->fecha_fin,'anio'=>$this->anio,'repartidorSelect'=>$this->repartidorSelect,'mes'=>$this->mes,
        'totales'=>$this->totales]);
    }
}
