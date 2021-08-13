<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Session;

// use Illuminate\Support\Facades\Crypt;

class ElementsHtmlService
{
    /**
     * @param null $object
     * @return string
     */
    public static function informativeColumn($object = null)
    {
        $variable = '';
        if (isset($object)) {
            foreach ($object as $load) {
                if(isset($load->type)) {
                    if ($load->type == 'link') {
                        $variable .= '<div class="m-b-5" style="display: ' . ($load->disable == '' ? 'none' : 'block') . '">';
                        $variable .= '<a href="' . $load->href . '" class="' . $load->class . '" style="color: #4099ff;" target="' . $load->target . '">' . $load->body . '</a>';
                        $variable .= '</div>';
                    }

                    if ($load->type == 'modal-image') {
                        $variable = '<img style="cursor:pointer" id="" data-toggle="modal" data-target="#modal" class="logo_img"  src="' . $load->src . '"';
                        $variable .= 'alt="The Project" width="60px" height="40px" data-img="' . $load->src . '" data-id="' . $load->id . '">';
                    }

                }

                if (!isset($load->type)) {
                    $variable .= '<div class="m-b-5 '. (isset($load->class)?$load->class:'') .'" style="display: '.($load->body==null?'none':'block').'">';
                    $variable .= '<b>' . $load->title . '</b> ' . $load->body;
                    $variable .= '</div>';
                }
            }
        }
        return $variable;
    }

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
                       $variable .= " data-{$load2->name}='{$load2->value}' ";
                   }
               }
                $variable .= "><i class='{$load->icon}'></i>{$load->name}</a>";
            }

            $variable .= '</div>';
            $variable .=(isset($status)?'</div>':'');
        }

        return $variable;
    }

    public static function subirCapturePago($servicio_id,$id)
    {
        $capture = '
        <form action="'.route('subir.pago').'" method="POST" role="form" enctype="multipart/form-data" onsubmit="return ValidateFile(this);">
        <input type="hidden" name="_token" value="'. Session::token() .'">
        <input value="'.$servicio_id.'" type="hidden" name="servicio_id">
        <label class="btn btn-sm btn-primary cursor-pointer waves-effect waves-light mb-1 px-3" for="capture_pago_'.$id.'">Cargar pago</label>
        <input type="file" id="capture_pago_'.$id.'" name="capture_pago" hidden>
        <button class="btn btn-sm btn-outline-success px-5 waves-effect waves-light">Subir</button></form>';

        return $capture;
    }

    public static function subirComprobanteAprobado($servicio_id,$id)
    {
        $capture = '
        <form action="'.route('subir.comprobante').'" method="POST" role="form" enctype="multipart/form-data" onsubmit="return ValidateFile(this);">
        <input type="hidden" name="_token" value="'. Session::token() .'">
        <input value="'.$servicio_id.'" type="hidden" name="servicio_id">
        <label class="btn btn-sm btn-primary cursor-pointer waves-effect waves-light mb-1 px-3" for="capture_pago_'.$id.'">Buscar comprobante</label>
        <input type="file" id="capture_pago_'.$id.'" name="capture_pago" hidden>
        <button class="btn btn-sm btn-outline-success px-5 waves-effect waves-light">Cargar</button></form>';

        return $capture;
    }

    public static function modalData($load,$metodoPago)
    {
        $data = '<a href="#" data-toggle="modal"
        data-backdrop="static" data-keyboard="false"
        data-target="#modal-detalles" data-id="'.$load->servicio_id.'"
        data-codigo="'.$load->codigo_cliente.'"
        data-ticket="'.$load->ticket.'"
        data-codigo_pedido="'.$load->codigo_pedido.'"
        data-num_documento="'.$load->num_documento.'"
        data-direccion="'.$load->direccion.'"
        data-telefono="'.$load->telefono.'"
        data-correo="'.$load->correo.'"
        data-metodo_pago="'.$metodoPago.'"
        data-total_servicio="'.$load->total_servicio.'"
        data-total_venta="'.$load->total_venta.'"
        data-efectivo="'.$load->efectivo.'"
        data-vuelto="'.$load->vuelto.'"
        data-is_fragil="'.$load->is_fragil.'"
        data-hora_estimada_recojo="'.$load->hora_estimada_recojo.'"
        data-tipo_servicio="'.$load->tipo_servicio.'"
        data-total_delivery="'.$load->total_delivery.'"
        data-nombres="'.$load->nombres_rz.'">'.$load->ticket.'</a>';

        return $data;
    }
}
