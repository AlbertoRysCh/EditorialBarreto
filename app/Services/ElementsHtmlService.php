<?php

namespace App\Services;


// use Illuminate\Support\Facades\Crypt;

class ElementsHtmlService
{
    /**
     * @param null $object
     * @return string
     */
    public static function optionElements($object = null, $status = null )
    {
        $variable = '';

        if (isset($object)) {
            $variable .=(isset($status)?'<div class="disableItemCar">':'');
            $variable .= '<button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $variable .= '<i class="fa fa-cog"></i>';
            $variable .= '</button>';
            $variable .= '<div class="dropdown-menu dropdown-menu-right b-none contact-menu">';
            foreach ($object as $load) {
                $variable .= '<a class="dropdown-item '.(isset($load->class) ? $load->class : '').' " '. (isset($load->onclick)?  'onclick="'.$load->onclick.'"' : '' ) .' target="' . $load->target . ' " href="' . $load->route . '"';

               if(isset($load->data)) {
                   foreach ($load->data as $load2) {
                    if ($load->type == 'modal-call') {
                       $variable .= " data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#abrirHistorial' data-{$load2->name}='{$load2->value}' ";
                    }
                   }
               }
                $variable .= "><i class='{$load->icon}'></i>{$load->name}</a>";
            }

            $variable .= '</div>';
            $variable .=(isset($status)?'</div>':'');
        }

        return $variable;
    }
}
