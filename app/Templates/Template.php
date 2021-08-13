<?php

namespace App\Templates;

class Template
{

    public function pdf($template, $data,$fecha, $letras_total,$fecha_letras,$coautores,$valores_dinamicos,$temp = NULL)
    {
        view()->addLocation(__DIR__.'/../Templates');
        return view('pdf.'.$template , compact('data','fecha','letras_total','fecha_letras','coautores','valores_dinamicos','temp'))->render();
    }



}
