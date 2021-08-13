<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Calculo de tamaño automatico de las celdas
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CobranzasExport implements WithColumnFormatting,FromView,ShouldAutoSize,WithStyles
{
    public  $data;
    public  $fecha_inicio;
    public  $fecha_fin;
    public  $anio;
    public  $clientes;
    public  $mes;
    public  $totales;
    public  $value;


    public function __construct($data,$fecha_inicio, $fecha_fin,$anio,$clientes,$mes,$totales,$value)
    {
        $this->data             = $data;
        $this->fecha_inicio     = $fecha_inicio;
        $this->fecha_fin        = $fecha_fin;
        $this->anio             = $anio;
        $this->clientes         = $clientes;
        $this->mes              = $mes;
        $this->totales          = $totales;
        $this->value            = $value;
    }
    public function columnFormats(): array
    {
        if($this->value == 'pagos-aprobados' || $this->value == 'por-cobrar'){
            return [
                'J' => NumberFormat::FORMAT_NUMBER_00,
                'K' => NumberFormat::FORMAT_NUMBER_00,
            ];
        }else{
            return [
                'I' => NumberFormat::FORMAT_NUMBER_00,
                'J' => NumberFormat::FORMAT_NUMBER_00,
            ];
        }

    }
    public function styles(Worksheet $sheet)
    {
        
        return [
            1    => ['font' => ['bold' => true]],
            6    => ['font' => ['bold' => true]],
            'B2' => ['font' => ['italic' => true]],

        ];
    }
    public function view(): View
    {
        return view('exports.'.$this->value, ['data' => $this->data,'fecha_inicio'=>$this->fecha_inicio,
        'fecha_fin'=>$this->fecha_fin,'anio'=>$this->anio,'clientes'=>$this->clientes,'mes'=>$this->mes,
        'totales'=>$this->totales]);
    }
}
