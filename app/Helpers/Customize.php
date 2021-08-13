<?php
namespace App\Helpers;

use Carbon\Carbon;

class Customize
{
    const MESES = ["Enero", "Febrero", "Marzo", "Abril", "Mayo",
    "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
    "Noviembre", "Diciembre"];

    public static function dateAddDay()
    {
        $date = date("Y-m-d");
        $mod_date = strtotime($date."+ 1 days");
        $fecha = date("Y-m-d",$mod_date);
        return $fecha;
    }

    public static function mesActual()
    {
        setlocale(LC_ALL, 'es_ES');

        $fecha = Carbon::parse(now());
        $fecha->format("F"); // Inglés.
        $mesActual = $fecha->formatLocalized('%B');// mes en idioma español

        return ucwords($mesActual); 
    }

    public static function mesAnterior()
    {
        setlocale(LC_ALL, 'es_ES');

        $fecha = Carbon::parse(now()->startOfMonth()->subMonth()->toDateString());
        $fecha->format("F"); // Inglés.
        $mesAnterior = $fecha->formatLocalized('%B');// mes en idioma español
        return ucwords($mesAnterior); 
    }

    public static function mesActualConsulta()
    {

        $firstDay = Carbon::now()->startOfMonth()->toDateString(); 
        $lastDay = Carbon::now()->endOfMonth()->toDateString();

        $array = [
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
        ];
        return  $array;

    }
    public static function mesAnteriorConsulta()
    {

        $firstDay = Carbon::now()->startOfMonth()->subMonth()->toDateString(); 
        $lastDay = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $array = [
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
        ];
        return  $array;

    }

    public static function messageSuccess()
    {
       $mensajeSuccess=session("mensajeSuccess");
       return $mensajeSuccess;
    }

    public static function messageInfo()
    {
        $mensajeInfo=session("mensajeInfo");
        return $mensajeInfo;
    }

    public static function extractDay($fecha)
    {
        $day = date("d", strtotime($fecha));
        return $day;
    }

    public static function extractMonth($fecha)
    {
        $strFecha = explode("/", $fecha);
        return $strFecha[0];
    }

    public static function extractMonthCarbon($fecha)
    {
        $strFecha = explode("-", $fecha);
        return $strFecha[1];
    }

    public static function extractAnio($fecha)
    {
        $strFecha = explode("/", $fecha);
        return $strFecha[1];
    }
    public static function obtenerMes($fecha)
    {
        $mesActual = date("m", strtotime($fecha."- 1 month")); 
        return ucwords(self::MESES[intval($mesActual)]); 
    }

    public static function obtenerMesEntero($load)
    {
        switch ($load->mes) {
            case '01':
                $mes = "Enero";
                break;
            case '02':
                $mes = "Febrero";
                break;
            case '03':
                $mes = "Marzo";
                break;
            case '04':
                $mes = "Abril";
                break;
            case '05':
                $mes = "Mayo";
                break;
            case '06':
                $mes = "Junio";
                break;
            case '07':
                $mes = "Julio";
                break;
            case '08':
                $mes = "Agosto";
                break;
            case '09':
                $mes = "Septiembre";
                break;
            case '10':
                $mes = "Octubre";
                break;
            case '11':
                $mes = "Noviembre";
                break;
            case '12':
                $mes = "Diciembre";
                break;
            default:
                # code...
                break;
        }
        return $mes;
    }

    public static function convertTimeSeconds($tiempo)
    {
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $tiempo);

        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

        return $time_seconds;
    }

}