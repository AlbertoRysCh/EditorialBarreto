<?php

namespace App\Http\Controllers;

use App\Helpers\Customize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
// Excel
use App\Exports\VendedoresExport;
use App\Exports\RepartidoresExport;
use App\Exports\TeleoperadoresExport;
// Models
use App\Models\Servicio;
use App\User;
use App\Models\GestionVisita;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

class ReporteController extends Controller
{
    const VALUE = 'value';

    public function reporteVendedor()
    {
        $vendedores = User::whereEstado(1)->whereRolId(4)->where('id','!=',2)->get();
        $formAprobados = 'formVendedores';

        $array_obj  = [
            'vendedores' => $vendedores,
            'form' => $formAprobados,
        ];

        return View::make('reportes.lista-vendedores', $array_obj);
    }

    public function indexTable(Request $request)
    {

        $columns = array(
            0 => 'users.name',
            1 => 'gestion_visitas.mes',
            2 => 'gestion_visitas.num_semana',
            3 => 'gestion_visitas.num_programadas',
            4 => 'gestion_visitas.num_realizadas',
            5 => 'gestion_visitas.num_pendientes',
            6 => 'gestion_visitas.clientes_rs',
            7 => 'gestion_visitas.clientes_foraneos'
        );
        $obj        = [];
        $obj        = new GestionVisita();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';
        $obj        = $obj->join('users','gestion_visitas.user_id','=','users.id');
        $obj        = $obj->select('gestion_visitas.*','users.name as vendedor');
        if(Auth::user()->rol_id == 4):
            $obj        = $obj->where('gestion_visitas.user_id',Auth::id());
        endif;
        $totalData  = $obj->count();

        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];

                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('users.name', 'like', "%{$search}%");
                    $query->orWhere('gestion_visitas.num_realizadas','like', "%{$search}%");
                    $query->orWhere('gestion_visitas.num_pendientes','like', "%{$search}%");
                    $query->orWhere('gestion_visitas.clientes_rs', 'like', "%{$search}%");
                    $query->orWhere('gestion_visitas.clientes_foraneos', 'like', "%{$search}%");
                });
        }
        // FILTROS DINAMICO
        $obj           = $request->fecha_ini != null ? $obj->whereBetween('gestion_visitas.created_at', [$request->fecha_ini . " 00:00:00", $request->fecha_fin . " 23:59:59"]) : $obj->whereBetween('gestion_visitas.created_at', [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"]);
        $obj           = $obj->whereYear('gestion_visitas.created_at', $request->anio);
        $obj           = $request->vendedores_select != 'T' ? $obj->where('gestion_visitas.user_id', $request->vendedores_select) : $obj;

        $totalFiltered = $obj->count();
        $obj           = $obj->offset($request->start);
        $obj           = $obj->limit($limit); //limite
        $obj           = $obj->orderBy($order, $dir);
        $obj           = $obj->get();
        // dd( $obj  );
        $data          = array();
            if ($obj) {
                foreach ($obj as $load) {
                    /*opciones (action)*/
                    $dataArray['vendedor']              = $load->vendedor;
                    $dataArray['num_semana']            = $load->num_semana;
                    $dataArray['mes']                   = Customize::obtenerMesEntero($load);
                    $dataArray['num_programadas']       = $load->num_programadas;
                    $dataArray['num_realizadas']        = $load->num_realizadas;
                    $dataArray['num_pendientes']        = $load->num_pendientes;
                    $dataArray['clientes_rs']           = $load->clientes_rs;
                    $dataArray['clientes_foraneos']     = $load->clientes_foraneos;

                    $data[]                          = $dataArray;
                }
            }
            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data,
            );
        return json_encode($json_data);
    }

    public function exportarVendedores($fecha_inicio, $fecha_fin, $vendedor,$anio,$search)
    {
            if($vendedor != 'T'):
                $vendedorSelect=User::select('name','num_documento')->whereId($vendedor)->first();
            else:
                $vendedorSelect = 'TODOS';
            endif;
            $mes = Customize::obtenerMes($fecha_inicio);
            $data      = new GestionVisita();
            $data      = $data->join('users','gestion_visitas.user_id','=','users.id');
            $data      = $data->select('gestion_visitas.*','users.name as vendedor');
            if(Auth::user()->rol_id == 4):
                $data        = $data->where('gestion_visitas.user_id',Auth::id());
            endif;
            $dataArray = [];

            // FILTROS
            $data           = $fecha_inicio != null ? $data->whereBetween('gestion_visitas.created_at', [$fecha_inicio . " 00:00:00", $fecha_fin . " 23:59:59"]) : $data;
            $data           = $data->whereYear('gestion_visitas.created_at', $anio);
            $data           = $vendedor != 'T' ? $data->where('gestion_visitas.user_id', $vendedor) : $data;
            // dd($search);
            $data   = $search == 'T'  ? $data : $data->where(function ($query) use ($search) {
                        $query->orWhere('users.name', 'like', "%{$search}%");
            });
            $data           = $data->get();
            
            $numProgramadas = 0;
            $numPendientes = 0;
            $numRealizadas = 0;
            $numClientesRs = 0;
            $numForaneos = 0;
            foreach ($data as $load) {

                $numProgramadas += $load->num_programadas;
                $numRealizadas += $load->num_realizadas;
                $numPendientes += $load->num_pendientes;
                $numClientesRs += $load->clientes_rs;
                $numForaneos += $load->clientes_foraneos;

            $dataArray[] = (object) [
                'vendedor'             => $load->vendedor,
                'num_semana'           => $load->num_semana,
                'mes'                  => Customize::obtenerMesEntero($load),
                'num_programadas'      => $load->num_programadas,
                'num_realizadas'       => $load->num_realizadas,
                'num_pendientes'       => $load->num_pendientes,
                'clientes_rs'          => $load->clientes_rs,
                'clientes_foraneos'    => $load->clientes_foraneos
            ];
            }

            $totales[] = (object) [
                'numProgramadas'    => $numProgramadas,
                'numRealizadas'     => $numRealizadas,
                'numPendientes'     => $numPendientes,
                'numClientesRs'     => $numClientesRs,
                'numForaneos'       => $numForaneos,
            ];

            $vendedores       = $dataArray;

            $export = new VendedoresExport($vendedores,$fecha_inicio, $fecha_fin,$anio,$vendedorSelect,$mes,$totales);
            return Excel::download($export, 'vendedores.xls');
    }

    public function reporteOperacional()
    {
        $repartidores = User::whereEstado(1)->whereRolId(6)->where('id','!=',3)->get();
        $formOperacional = 'formOperacional';

        $array_obj  = [
            'repartidores' => $repartidores,
            'form' => $formOperacional,
        ];

        return View::make('reportes.lista-operacional', $array_obj);
    }

    public function indexTableOperacional(Request $request)
    {
        $columns = array(
            0 => 'servicios.id',
            1 => 'servicios.cliente_id',
            2 => 'servicios.user_id',
            3 => 'servicios.observacion'
        );
        $obj        = [];
        $obj        = new Servicio();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';
        $obj        = $obj->join('clientes','servicios.cliente_id','=','clientes.id');
        $obj        = $obj->leftJoin('repartidor_has_servicios','servicios.id','=','repartidor_has_servicios.servicio_id');
        $obj        = $obj->leftJoin('users','repartidor_has_servicios.usuario_id','=','users.id');

        if(Auth::user()->rol_id == 6):
            $data        = $obj->where('repartidor_has_servicios.usuario_id',Auth::id());
        endif;

        $obj        = $obj->select('servicios.*',
                        'clientes.nombres_rz',
                        'clientes.direccion',
                        'clientes.tipo_documento',
                        'clientes.num_documento',
                        'clientes.direccion',
                        'clientes.correo',
                        'clientes.telefono',
                        'servicios.estado as estado_registro',
                        'users.id as user_id',
                        'repartidor_has_servicios.created_at as fecha_os',
                        'repartidor_has_servicios.hora_entrega',
                        'repartidor_has_servicios.hora_recojo',
                        'servicios.items->nombre_cliente as nombre_cliente',
                        'servicios.items->direccion_cliente as direccion_cliente',
                        'servicios.items->direccion_empresa as direccion_empresa',
                        'users.name as nombre_repartidor');

        $totalData  = $obj->count();


        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];

                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('servicios.cliente_id', 'like', "%{$search}%");
                });
        }
        // FILTROS DINAMICO
        $obj           = $request->fecha_ini != null ? $obj->whereBetween('repartidor_has_servicios.created_at', [$request->fecha_ini . " 00:00:00", $request->fecha_fin . " 23:59:59"]) : $obj->whereBetween('repartidor_has_servicios.created_at', [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"]);
        $obj           = $obj->whereYear('repartidor_has_servicios.created_at', $request->anio);
        $obj           = $request->repartidores_select != 'T' ? $obj->where('users.id', $request->repartidores_select) : $obj;

        $totalFiltered = $obj->count();
        $obj           = $obj->offset($request->start);
        $obj           = $obj->limit($limit); //limite
        $obj           = $obj->orderBy($order, $dir);
        $obj           = $obj->get();
        // dd( $obj  );
        $data          = array();
            if ($obj) {
                foreach ($obj as $load) {
                    /*opciones (action)*/

                    $dataArray['notificacion_os']       = date("H:i:s", strtotime($load->fecha_os));
                    $dataArray['repartidor']            = is_null($load->nombre_repartidor) ? 'No asignado' : $load->nombre_repartidor;
                    $dataArray['orden_servicio']        = $load->ticket;
                    $dataArray['cliente']               = $load->nombres_rz;
                    $dataArray['km_estimado']           = $load->km_estimado;
                    $dataArray['total_delivery']        = $load->total_delivery;
                    $dataArray['persona_contacto']      = is_null($load->persona_contacto) ? '-' : $load->persona_contacto;
                    $dataArray['punto_recojo']          = $load->tipo_servicio == 0 ? $load->direccion_empresa : $load->punto_recojo;
                    $dataArray['punto_entrega']         = $load->tipo_servicio == 0 ? $load->direccion_cliente : $load->direccion;
                    $dataArray['hora_entrega']          = is_null($load->hora_entrega) ? '-' : date("H:i:s", strtotime($load->hora_entrega));
                    $dataArray['hora_recojo']           = is_null($load->hora_recojo) ? '-' : date("H:i:s", strtotime($load->hora_recojo));
                    $dataArray['punto_partida']         = is_null($load->punto_partida) ? $load->direccion_empresa : $load->punto_partida;


                    $data[]                          = $dataArray;
                }
            }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        return json_encode($json_data);
    }

    public function exportarOperacional($fecha_inicio, $fecha_fin, $repartidor,$anio,$search)
    {
            if($repartidor != 'T'):
                $repartidorSelect=User::select('name','num_documento')->whereId($repartidor)->first();
            else:
                $repartidorSelect = 'TODOS';
            endif;

            $mes         = Customize::obtenerMes($fecha_inicio);
            $data        = new Servicio();
            $data        = $data->join('clientes','servicios.cliente_id','=','clientes.id');
            $data        = $data->leftJoin('repartidor_has_servicios','servicios.id','=','repartidor_has_servicios.servicio_id');
            $data        = $data->leftJoin('users','repartidor_has_servicios.usuario_id','=','users.id');
            $data        = $data->leftJoin('users as u2','servicios.user_id','=','u2.id');
            $data        = $data->select('servicios.*',
                        'clientes.nombres_rz',
                        'clientes.direccion',
                        'clientes.tipo_documento',
                        'clientes.num_documento',
                        'clientes.direccion',
                        'clientes.correo',
                        'clientes.telefono',
                        'servicios.estado as estado_registro',
                        'users.id as user_id',
                        'repartidor_has_servicios.created_at as fecha_os',
                        'repartidor_has_servicios.hora_entrega',
                        'repartidor_has_servicios.hora_recojo',
                        'repartidor_has_servicios.tiempo_programado',
                        'servicios.items->nombre_cliente as nombre_cliente',
                        'servicios.items->direccion_cliente as direccion_cliente',
                        'servicios.items->direccion_empresa as direccion_empresa',
                        'users.name as nombre_repartidor',
                        'u2.name as nombre_teleoperador');
    
            if(Auth::user()->rol_id == 6):
                $data        = $data->where('repartidor_has_servicios.usuario_id',Auth::id());
            endif;
            // $data        = $data->where('repartidor_has_servicios.servicio_id',4);

            $dataArray = [];

            // FILTROS
            $data           = $fecha_inicio != null ? $data->whereBetween('repartidor_has_servicios.created_at', [$fecha_inicio . " 00:00:00", $fecha_fin . " 23:59:59"]) : $data;
            $data           = $data->whereYear('repartidor_has_servicios.created_at', $anio);
            $data           = $repartidor != 'T' ? $data->where('repartidor_has_servicios.usuario_id', $repartidor) : $data;

            $data   = $search == 'T'  ? $data : $data->where(function ($query) use ($search) {
                        $query->orWhere('users.name', 'like', "%{$search}%");
            });
            $data           = $data->get();
            $totalDelivery = 0;
            foreach ($data as $load) {


                // Tiempo que tarda desde la hora estimada en recojer y el tiempo que recibio
                $horaEntrega = new DateTime( $load->hora_entrega);
                $horaRecojo = new DateTime( $load->hora_recojo);
                $duracionEntrega = $horaRecojo->diff($horaEntrega); 
                $duracion = $duracionEntrega->h.':'.$duracionEntrega->i.':'.$duracionEntrega->s;

                // Calcular el OTP del repartidor
                $tiempoS = Customize::convertTimeSeconds($load->tiempo_programado);
                $segundosD = Customize::convertTimeSeconds($duracion);
                // dd($duracion,$load->tiempo_programado, $tiempoS,  $segundosD);
                $otp = 0.00;
                if($tiempoS != 0 && $segundosD !=0):
                    $otp = round(($tiempoS / $segundosD)*100,2);
                endif;

                $duracionDate = new DateTime( $duracion);
                $tiempoProgramado = new DateTime( $load->tiempo_programado);
                $diferenciaTiempo = $duracionDate->diff($tiempoProgramado); 

                if($diferenciaTiempo->invert == 1):
                    $diferencia_tiempo_entrega = ' - '.$diferenciaTiempo->format('%H horas %i minutos %s segundos');
                else:
                    $diferencia_tiempo_entrega = ' + '.$diferenciaTiempo->format('%H horas %i minutos %s segundos');
                endif;

                $duracionEntrega = $horaRecojo->diff($horaEntrega); 

                $totalDelivery += $load->total_delivery;

            $dataArray[] = (object) [
                'notificacion_os'       => date("H:i:s", strtotime($load->fecha_os)),
                'repartidor'            => is_null($load->nombre_repartidor) ? 'No asignado' : $load->nombre_repartidor,
                'teleoperador'          => $load->nombre_teleoperador,
                'orden_servicio'        => $load->ticket,
                'cliente'               => $load->nombres_rz,
                'km_estimado'           => $load->km_estimado,
                'total_delivery'        => 'S/ '.number_format($load->total_delivery,2,".","."),
                'persona_contacto'      => is_null($load->persona_contacto) ? '-' : $load->persona_contacto,
                'punto_recojo'          => $load->tipo_servicio == 0 ? $load->direccion_empresa : $load->punto_recojo,
                'punto_entrega'         => $load->tipo_servicio == 0 ? $load->direccion_cliente : $load->direccion,
                'hora_entrega'          => is_null($load->hora_entrega) ? '-' : date("H:i:s", strtotime($load->hora_entrega)),
                // 'punto_partida'         => $load->tipo_servicio == 0 ? $load->direccion_empresa : $load->punto_partida,
                'punto_partida'         => is_null($load->punto_partida) ? $load->direccion_empresa : $load->punto_partida,
                'hora_recojo'           => is_null($load->hora_recojo) ? '-' : date("H:i:s", strtotime($load->hora_recojo)),
                'tiempo_programado'     => $load->tiempo_programado,
                'duracion_entrega'      => $duracion,
                'otp'                   => $otp.' % ',
                'diferencia_tiempo_entrega'                   => $diferencia_tiempo_entrega,
            ];
            }
           
            $totales[] = (object) [
                'totalDelivery'    => 'S/ '.number_format($totalDelivery,2,".","."),
            ];
            $repartidores       = $dataArray;
            // dd($repartidores);
            $export = new RepartidoresExport($repartidores,$fecha_inicio, $fecha_fin,$anio,$repartidorSelect,$mes,$totales);
            return Excel::download($export, 'repartidores.xls');
    }
    
    public function reporteTeleopeador()
    {
        $repartidores = User::whereEstado(1)->whereRolId(6)->where('id','!=',3)->get();
        $formTeleoperador = 'formTeleoperador';

        $array_obj  = [
            'repartidores' => $repartidores,
            'form' => $formTeleoperador,
        ];

        return View::make('reportes.lista-teleoperador', $array_obj);
    }
    
    public function indexTableTeleoperador(Request $request)
    {
        $columns = array(
            0 => 'servicios.id',
            1 => 'servicios.cliente_id',
            2 => 'servicios.user_id',
            3 => 'servicios.observacion'
        );
        $obj        = [];
        $obj        = new Servicio();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';
        $obj        = $obj->join('clientes','servicios.cliente_id','=','clientes.id');
        $obj        = $obj->leftJoin('repartidor_has_servicios','servicios.id','=','repartidor_has_servicios.servicio_id');
        $obj        = $obj->leftJoin('users','repartidor_has_servicios.usuario_id','=','users.id');
        $obj        = $obj->whereIn('servicios.payment_id',array('5','2','6'));


        $obj        = $obj->select('servicios.*',
                        'clientes.nombres_rz',
                        'clientes.empresa',
                        'clientes.direccion',
                        'clientes.tipo_documento',
                        'clientes.num_documento',
                        'clientes.direccion',
                        'clientes.correo',
                        'clientes.telefono',
                        'servicios.estado as estado_registro',
                        'users.id as user_id',
                        'repartidor_has_servicios.hora_estimada_recojo as fecha',
                        'repartidor_has_servicios.hora_entrega',
                        'servicios.items->nombre_cliente as nombre_cliente',
                        'servicios.items->direccion_cliente as direccion_cliente',
                        'servicios.items->direccion_empresa as direccion_empresa',
                        'servicios.items->telefono_cliente as telefono_cliente',
                        'users.name as nombre_repartidor');

        $totalData  = $obj->count();


        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];

                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('servicios.cliente_id', 'like', "%{$search}%");
                });
        }
        // FILTROS DINAMICO
        $obj           = $request->fecha_ini != null ? $obj->whereBetween('repartidor_has_servicios.hora_estimada_recojo', [$request->fecha_ini . " 00:00:00", $request->fecha_fin . " 23:59:59"]) : $obj->whereBetween('repartidor_has_servicios.hora_estimada_recojo', [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"]);
        $obj           = $obj->whereYear('repartidor_has_servicios.hora_estimada_recojo', $request->anio);
        $obj           = $request->repartidores_select != 'T' ? $obj->where('users.id', $request->repartidores_select) : $obj;
       
        if($request->estado_pago == '03'):
            $obj       = $obj->where('servicios.payment_id',6);
        else:
            $obj       = $request->estado_pago != 'T' ? $obj->where('servicios.estado_pago', $request->estado_pago)->where('servicios.payment_id','!=',6) : $obj;
        endif;

        $totalFiltered = $obj->count();
        $obj           = $obj->offset($request->start);
        $obj           = $obj->limit($limit); //limite
        $obj           = $obj->orderBy($order, $dir);
        $obj           = $obj->get();
        // dd( $obj  );
        $data          = array();

            if ($obj) {
                foreach ($obj as $load) {
                    /*opciones (action)*/
                    $estadoPago = '<div class="badge badge-pill badge-glow badge-danger mr-1 mb-1">RECHAZADO</div>';

                    switch ($load->estado_pago) {
                        case 0:
                            $estadoPago = '<div class="badge badge-pill badge-glow badge-danger mr-1 mb-1">PENDIENTE</div>';
                            break;
                        case 1:
                            $estadoPago = '<div class="badge badge-pill badge-glow badge-success mr-1 mb-1">CANCELADO</div>';
                            break;
    
                    }
                    if($load->tipo_servicio == 0):
                        $nroCelular = $load->telefono_cliente == "null" ? '-' : $load->telefono_cliente;
                    else:
                        $nroCelular = $load->telefono;
                    endif;

                    $dataArray['fecha']                 = date("d-m-Y", strtotime($load->fecha));
                    $dataArray['cliente']               = $load->tipo_servicio == 0 ? $load->empresa : $load->nombres_rz;
                    $dataArray['direccion_inicio']      = $load->tipo_servicio == 0 ? $load->direccion_empresa : $load->punto_recojo;
                    $dataArray['direccion_final']       = $load->tipo_servicio == 0 ? $load->direccion_cliente : $load->direccion;
                    $dataArray['nombre_cliente']        = $load->tipo_servicio == 0 ? $load->nombre_cliente : '-';
                    $dataArray['nro_celular']           = $nroCelular;
                    $dataArray['repartidor']            = $load->nombre_repartidor;
                    $dataArray['hora_fecha']            = date("H:i:s", strtotime($load->fecha));
                    $dataArray['hora_entrega']          = is_null($load->hora_entrega) ? '-' : date("H:i:s", strtotime($load->hora_entrega));
                    
                    
                    $dataArray['total_km']              = $load->km_estimado;
                    $dataArray['km_adicional']          = $load->km_adicional;
                    $dataArray['costo_basico']          = 'S/ 6.00';
                    $dataArray['km_adicional_soles']    = 'S/ '.number_format($load->km_adicional_soles,2,".",".");
                    $dataArray['total_a_pagar']         = $load->total_servicio;

                    $dataArray['estado']                = $load->payment_id == 6 ? '<div class="badge badge-pill badge-glow badge-warning mr-1 mb-1">DONACIÓN</div>' : $estadoPago;




                    $data[]                          = $dataArray;
                }
            }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        return json_encode($json_data);
    }

    public function calculateKm($load)
    {
        $sum_km = 0;

        $metros = $load->km_estimado * 1000;
        if($metros > 4000):
            $restarMetros = $metros - 4000;
            $sum_km = $restarMetros * 0.10 / 100;
        endif;

        return $sum_km;
    }

    public function exportarTeleoperador($fecha_inicio, $fecha_fin, $repartidor,$estado_pago,$anio,$search)
    {
            if($repartidor != 'T'):
                $repartidorSelect=User::select('name','num_documento')->whereId($repartidor)->first();
            else:
                $repartidorSelect = 'TODOS';
            endif;

            $mes         = Customize::obtenerMes($fecha_inicio);
            $data        = new Servicio();
            $data        = $data->join('clientes','servicios.cliente_id','=','clientes.id');
            $data        = $data->leftJoin('repartidor_has_servicios','servicios.id','=','repartidor_has_servicios.servicio_id');
            $data        = $data->leftJoin('users','repartidor_has_servicios.usuario_id','=','users.id');
            $data        = $data->whereIn('servicios.payment_id',array('5','2','6'));
            $data        = $data->select('servicios.*',
                        'clientes.nombres_rz',
                        'clientes.empresa',
                        'clientes.direccion',
                        'clientes.tipo_documento',
                        'clientes.num_documento',
                        'clientes.direccion',
                        'clientes.correo',
                        'clientes.telefono',
                        'servicios.estado as estado_registro',
                        'users.id as user_id',
                        'repartidor_has_servicios.hora_estimada_recojo as fecha',
                        'repartidor_has_servicios.hora_entrega',
                        'servicios.items->nombre_cliente as nombre_cliente',
                        'servicios.items->direccion_cliente as direccion_cliente',
                        'servicios.items->direccion_empresa as direccion_empresa',
                        'servicios.items->telefono_cliente as telefono_cliente',
                        'users.name as nombre_repartidor');

            $dataArray = [];

            // FILTROS
            if($estado_pago == '03'):
                $data       = $data->where('servicios.payment_id',6);
            else:
                $data       = $estado_pago != 'T' ? $data->where('servicios.estado_pago', $estado_pago)->where('servicios.payment_id','!=',6) : $data;
            endif;

            $data           = $fecha_inicio != null ? $data->whereBetween('repartidor_has_servicios.hora_estimada_recojo', [$fecha_inicio . " 00:00:00", $fecha_fin . " 23:59:59"]) : $data;
            $data           = $data->whereYear('repartidor_has_servicios.hora_estimada_recojo', $anio);
            $data           = $repartidor != 'T' ? $data->where('users.id', $repartidor) : $data;

            $data   = $search == 'T'  ? $data : $data->where(function ($query) use ($search) {
                        $query->orWhere('users.name', 'like', "%{$search}%");
            });

            $data           = $data->get();
            $total = 0;
            foreach ($data as $load) {
                $total += $load->total_servicio;

                $estadoPago = 'RECHAZADO';

                switch ($load->estado_pago) {
                    case 0:
                        $estadoPago = 'PENDIENTE';
                        break;
                    case 1:
                        $estadoPago = 'CANCELADO';
                        break;

                }

                if($load->tipo_servicio == 0):
                    $nroCelular = $load->telefono_cliente == "null" ? '-' : $load->telefono_cliente;
                else:
                    $nroCelular = $load->telefono;
                endif;

            $dataArray[] = (object) [

                'fecha'                 => date("d-m-Y", strtotime($load->fecha)),
                'cliente'               => $load->tipo_servicio == 0 ? $load->empresa : $load->nombres_rz,
                'direccion_inicio'      => $load->tipo_servicio == 0 ? $load->direccion_empresa : $load->punto_recojo,
                'direccion_final'       => $load->tipo_servicio == 0 ? $load->direccion_cliente : $load->direccion,
                'nombre_cliente'        => $load->tipo_servicio == 0 ? $load->nombre_cliente : '-',
                'nro_celular'           => $nroCelular,
                'repartidor'            => $load->nombre_repartidor,
                'hora_fecha'            => date("H:i:s", strtotime($load->fecha)),
                'hora_entrega'          => is_null($load->hora_entrega) ? '-' : date("H:i:s", strtotime($load->hora_entrega)),
                
                
                'total_km'              => $load->km_estimado,
                'km_adicional'          => $load->km_adicional,
                'costo_basico'          => 'S/ 6.00',
                'km_adicional_soles'    => 'S/ '.number_format($load->km_adicional_soles,2,".","."),
                'total_a_pagar'         => 'S/ '.number_format($load->total_servicio,2,".","."),
                'estado'                => $load->payment_id == 6 ? 'DONACIÓN' : $estadoPago,
                'observacion'           => $load->observacion,


            ];
            }
            $totales[] = (object) [
                'totalServicio'    => 'S/ '.number_format($total,2,".","."),
            ];
            $servicios       = $dataArray;

            $export = new TeleoperadoresExport($servicios,$fecha_inicio, $fecha_fin,$anio,$repartidorSelect,$estado_pago,$mes,$totales);
            return Excel::download($export, 'teleoperadores.xls');
    }
    
}
