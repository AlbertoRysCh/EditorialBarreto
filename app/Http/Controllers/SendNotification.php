<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Notifications\OTNotification;
use App\Notifications\NotificationCuotas;
use Illuminate\Support\Facades\Config;
//Model
use App\OrdenTrabajo;

class SendNotification extends Controller
{
    public static function notificationOT($user,$cuotas)
    {
        if (Config::get('params.general.ambiente') == 'local') {
            $url = 'innova.test/articulo';
        }else{
            $url = 'innova.scientificdat.com/articulo';
        }
        // Consultar Orden de trabajo
        $ordenTrabajo = OrdenTrabajo::
        select('ordentrabajo.codigo','revisiones.titulo','ordentrabajo.precio')
        ->where('idordentrabajo',$cuotas->idordentrabajo)
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->first();

        $details = (object)[
            'subject' => 'Notificación de orden de trabajo '.$ordenTrabajo->codigo,
            'intro' => 'Buen día,',
            'body' => '<b>' .'Código OT: '.'</b>'.$ordenTrabajo->codigo.'<br>'.'<b>'.' Título artículo: '.'</b>'.$ordenTrabajo->titulo.'<br>'.
                    'La orden de trabajo fue cancelada el 100 % del monto total: '.$ordenTrabajo->precio.'<br>'.
                    'Por favor actualizar su estado'.'<b>'.' Habilitado para su envío a la revista.'.'</b>',
            'thanks' => 'Gracias Innova Scientific.',
            'actionURL' =>  $url,
            'actionName' => 'Ir',
            'user' => 'Estimado(a): '.ucwords($user->nombre)
        ];

        Notification::send($user, new OTNotification($details));

    }
    public static function notificationAddCuota($user,$data)
    {
        if (Config::get('params.general.ambiente') == 'local') {
            $url = 'innova.test/gerencia_pendientes';
        }else{
            $url = 'innova.scientificdat.com/gerencia_pendientes';
        }
        // Consultar Orden de trabajo y el monto de la cuota
        $ordenTrabajo = OrdenTrabajo::
        select('cuotas.id','ordentrabajo.codigo','revisiones.titulo','ordentrabajo.precio','cuotas.monto',
        'cuotas.fecha_cuota','ordentrabajo.idordentrabajo','cuotas.capturepago')
        ->where('cuotas.id',$data->id)
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('cuotas','ordentrabajo.idordentrabajo','=','cuotas.idordentrabajo')
        ->first();
        // RUTA
        $path = storage_path('app/public/').'capture_pagos/'.$ordenTrabajo->idordentrabajo.'/'.$ordenTrabajo->capturepago;

        $details = (object)[
            'subject' => 'Notificación de pago pendiente por revisar de OT '.$ordenTrabajo->codigo,
            'intro' => 'Buen día,',
            'body' => '<b>' .'Código OT: '.'</b>'.$ordenTrabajo->codigo.'<br>'.'<b>'.' Título artículo: '.'</b>'.$ordenTrabajo->titulo.'<br>'.
                    'El monto de la cuota pendiente por aprobar es de: '.$ordenTrabajo->monto.'<br>'.
                    'Fecha de la cuota: '.date("d-m-Y", strtotime($ordenTrabajo->fecha_cuota)).'<br>'.
                    'Por favor verificar para'.'<b>'.' Aprobar o rechazar la cuota.'.'</b>',
            'thanks' => 'Gracias Innova Scientific.',
            'actionURL' =>  $url,
            'actionName' => 'Ir',
            'path' => $path,
            'user' => 'Estimado(a): '.ucwords($user->nombre)
        ];

/*         Notification::send($user, new NotificationCuotas($details));
 */
    }
    public static function notificationCuota($user,$data)
    {
        if (Config::get('params.general.ambiente') == 'local') {
            $url = 'innova.test/gerencia_pendientes';
        }else{
            $url = 'innova.scientificdat.com/gerencia_pendientes';
        }
        // Consultar Orden de trabajo y el monto de la cuota inicial o unica
        $ordenTrabajo = OrdenTrabajo::
        select('cuotas.id','ordentrabajo.codigo','revisiones.titulo','ordentrabajo.precio','cuotas.monto',
        'cuotas.fecha_cuota','ordentrabajo.titulo_coautoria','cuotas.tipo_contrato','ordentrabajo.idordentrabajo',
        'cuotas.capturepago')
        ->where('cuotas.id',$data->id)
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('cuotas','ordentrabajo.idordentrabajo','=','cuotas.idordentrabajo')
        ->first();

        $cuota = 'cuota inicial';
        $tipo_contrato = 'Foráneo';
        $titulo = $ordenTrabajo->titulo;
        if($ordenTrabajo->tipo_contrato == 1 ){
            $cuota = 'cuota única';
            $titulo = $ordenTrabajo->titulo_coautoria;
            $tipo_contrato = 'Coautoría';
        }
        // RUTA
        $path = storage_path('app/public/').'capture_pagos/'.$ordenTrabajo->idordentrabajo.'/'.$ordenTrabajo->capturepago;

        $details = (object)[
            'subject' => 'Notificación de pago pendiente de '.$cuota.' por revisar de OT '.$ordenTrabajo->codigo,
            'intro' => 'Buen día,',
            'body' => '<b>' .'Código OT: '.'</b>'.$ordenTrabajo->codigo.'<br>'.'<b>'.' Título artículo: '.'</b>'.$titulo.'<br>'.
                    'Tipo de contrato: '.$tipo_contrato.'<br>'.
                    'El monto de la '.$cuota.' pendiente por aprobar es de: '.$ordenTrabajo->monto.'<br>'.
                    'Fecha de la cuota: '.date("d-m-Y", strtotime($ordenTrabajo->fecha_cuota)).'<br>'.
                    'Por favor verificar para'.'<b>'.' Aprobar o rechazar la cuota.'.'</b>',
            'thanks' => 'Gracias Innova Scientific.',
            'actionURL' =>  $url,
            'actionName' => 'Ir',
            'path' => $path,
            'user' => 'Estimado(a): '.ucwords($user->nombre)
        ];

    //    Notification::send($user, new NotificationCuotas($details));

    }
}
