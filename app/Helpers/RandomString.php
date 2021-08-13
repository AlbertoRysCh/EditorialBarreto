<?php
namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RandomString
{
    public function randomString($value = NULL)
    {
        $fecha = Carbon::parse(now());
        $random = Str::random(15);
        $mes = $fecha->month;
        $day = $fecha->day;
        $year = $fecha->year;
        $arrayString = array(
            'mes'    =>$mes,
            'day'    =>$day,
            'year'   =>$year,
            'random' =>$random
        );
        $convert_array = implode("", $arrayString);
        $join_string = $value.$convert_array;
        return $join_string; 
    }

}