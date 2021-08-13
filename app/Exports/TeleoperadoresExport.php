<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TeleoperadoresExport implements WithColumnFormatting,FromView,ShouldAutoSize
{
    public  $data;
    public  $fecha_inicio;
    public  $fecha_fin;
    public  $anio;
    public  $repartidorSelect;
    public  $mes;
    public  $estado_pago;
    public  $totales;


    public function __construct($data,$fecha_inicio, $fecha_fin,$anio,$repartidorSelect,$estado_pago,$mes,$totales)
    {
        $this->data             = $data;
        $this->fecha_inicio     = $fecha_inicio;
        $this->fecha_fin        = $fecha_fin;
        $this->anio             = $anio;
        $this->repartidorSelect   = $repartidorSelect;
        $this->mes              = $mes;
        $this->totales          = $totales;
        $this->estado_pago          = $estado_pago;
    }

    public function columnFormats(): array
    {
    return [
        'L' => NumberFormat::FORMAT_NUMBER_00,
        'M' => NumberFormat::FORMAT_NUMBER_00,
        'N' => NumberFormat::FORMAT_NUMBER_00,
    ];


    }
    public function view(): View
    {
        return view('exports.teleoperadores', ['servicios' => $this->data,'fecha_inicio'=>$this->fecha_inicio,
        'fecha_fin'=>$this->fecha_fin,'anio'=>$this->anio,'repartidorSelect'=>$this->repartidorSelect,'estado_pago'=>$this->estado_pago,
        'mes'=>$this->mes,'totales'=>$this->totales]);
    }
}
