<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Calculo de tamaño automatico de las celdas

class PosiblesClientesExport implements FromView,ShouldAutoSize
{
    public  $data;


    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('exports.posibles-clientes', ['posiblesClientes' => $this->data]);
    }
}
