<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Services\ElementsHtmlService;
use App\Helpers\SelectHelper;
use App\Helpers\LogSystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Crypt;
// Excel
use App\Exports\PosiblesClientesExport;
use Maatwebsite\Excel\Facades\Excel;
// Modelos
use App\Models\Cliente;
use App\Models\Aviso;
use App\Models\DistritoVendedor;
use App\User;
use App\Models\GestionVisita;
use App\Models\Ubigeo;

class PosibleClienteController extends Controller
{
    const VALUE = 'value';

    protected $selectType;
    protected $cliente;

    public function __construct()
    {
        $this->selectType = new SelectHelper();
        $this->cliente = new Cliente();
    }

    public function index()
    {
        $tipoLlamadas = $this->selectType->listEstadoLlamada();
        $formExportarPosiblesClientes = 'formExportarPosiblesClientes';
        $array_obj  = [
            'tipoLlamadas' => $tipoLlamadas,
            'form' => $formExportarPosiblesClientes,
        ];
        return View::make('posibles-clientes.index', $array_obj);
    }

    public function indexTable(Request $request)
    {
        $columns = array(
            0 => 'clientes.id',
            1 => 'clientes.nombres_rz',
            2 => 'clientes.num_documento'
        );
        $obj        = [];
        $obj        = new Cliente();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';
        if(Auth::user()->rol_id == 4){
            $obj        = $obj->where('clientes.vendedor_id',Auth::id());
        }
        $obj        = $obj->where('clientes.is_empleado',0);
        $obj        = $obj->join('users','clientes.user_id','=','users.id');
        $obj        = $obj->leftJoin('users as u2','clientes.vendedor_id','=','u2.id');
        $obj        = $obj->select('clientes.*','users.name as usuario','u2.name as nombre_vendedor','users.id as usuario_id');


        $totalData  = $obj->count();


        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];
            if($search == 'Activo' || $search == 'Desactivado'){
                switch ($search) {
                    case 'Activo':
                        $search_number = 1;
                        break;
                    case 'Desactivado':
                        $search_number = 0;
                        break;

                }
                $obj    = $obj->where(function ($query) use ($search,$search_number) {
                    $query->where('clientes.estado', 'LIKE', '%' . $search_number . '%');
                    $query->orWhere('clientes.nombres_rz', 'like', "%{$search}%");
                    $query->orWhere('clientes.direccion', 'like', "%{$search}%");
                    $query->orWhere('clientes.correo','like', "%{$search}%");
                    $query->orWhere('clientes.telefono', 'like', "%{$search}%");
                    $query->orWhere('clientes.tipo_documento', 'like', "%{$search}%");
                    $query->orWhere('clientes.num_documento', 'like', "%{$search}%");
                });
            }else{
                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('clientes.nombres_rz', 'like', "%{$search}%");
                    $query->orWhere('clientes.direccion', 'like', "%{$search}%");
                    $query->orWhere('clientes.correo','like', "%{$search}%");
                    $query->orWhere('clientes.telefono', 'like', "%{$search}%");
                    $query->orWhere('clientes.tipo_documento', 'like', "%{$search}%");
                    $query->orWhere('clientes.num_documento', 'like', "%{$search}%");
                });
            }
        }
        // FILTROS DINAMICO
        $obj           = $request->fecha_ini != null ? $obj->whereBetween('clientes.created_at', [$request->fecha_ini . " 00:00:00", $request->fecha_fin . " 23:59:59"]) : $obj->whereBetween('clientes.created_at', [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"]);
        $obj           = $request->estado != 'T' ? $obj->where('clientes.estado', $request->estado): $obj;
        $obj           = $request->estado_cliente != 'T' ? $obj->where('clientes.estado_cliente', $request->estado_cliente): $obj;
        $obj           = $request->estado_llamada != 'T' ? $obj->where('clientes.estado_llamada', $request->estado_llamada): $obj;
        $totalFiltered = $obj->count();
        $obj           = $obj->offset($request->start);
        $obj           = $obj->limit($limit); //limite
        $obj           = $obj->orderBy($order, $dir);
        $obj           = $obj->get();
        $data          = array();
        if ($obj) {
            // $i=1;
            foreach ($obj as $load) {
                /*opciones (action)*/
                $estadoEnable       = ('0' == $load->estado ? 'desactivado' : null);
                $optionsElements = $dataAtribute = [];
                $dataAtribute []    = (object)['name' => 'id', self::VALUE => Crypt::encrypt($load->id)];

                $optionsElements [] = (object)[
                    'name'   => 'Editar',
                    'icon'   => 'feather icon-edit-2',
                    'target' => '_self',
                    'route'  => route('posibles.clientes.edit', Crypt::encrypt($load->id)),
                    'data'   => $dataAtribute,
                    'class'  => 'edit'
                ];
                if (Auth::user()->rol_id == 4) {
                    $optionsElements [] = (object)[
                        'name'   => 'Gestionar llamada',
                        'icon'   => 'feather icon-headphones',
                        'target' => '_self',
                        'route'  => route('gestionar.llamada', Crypt::encrypt($load->id)),
                        'data'   => $dataAtribute,
                        'class'  => 'edit'
                    ];

                    $optionsElements [] = (object)[
                    'name'   => $load->is_visita == 0 ? 'Marcar visita' : 'Desmarcar visita',
                    'icon'   => $load->is_visita == 0 ? 'feather icon-check' : 'feather icon-x',
                    'target' => '_self',
                    'route'  => route('posibles.clientes.visita', Crypt::encrypt($load->id)),
                    'data'   => $dataAtribute,
                    'class'  => 'activar_desactivar'
                    ];
                }
                if (Auth::user()->rol_id == 3) {
                    $optionsElements [] = (object)[
                    'name'   => $load->estado == 1 ? 'Desactivar': 'Activar',
                    'icon'   => $load->estado == 1 ? 'feather icon-user-minus' : 'feather icon-user-check',
                    'target' => '_self',
                    'route'  => route('posibles.clientes.act.desac', Crypt::encrypt($load->id)),
                    'data'   => $dataAtribute,
                    'class'  => 'activar_desactivar'
                ];
                }

                if(!$estadoEnable){
                    $labelEstado = '<div class="badge badge-pill badge-glow badge-success mr-1 mb-1">Activo</div>';
                }
                else{
                    $labelEstado = '<div class="badge badge-pill badge-glow badge-danger mr-1 mb-1">Desactivado</div>';
                }
                switch ($load->tipo_persona_id) {
                    case 1:
                        $tipo_persona = 'Jurídica';
                        break;
                    case 2:
                        $tipo_persona = 'Natural';
                        break;

                }
                $tipoCliente = 'Cliente RS';
                if($load->tipo_cliente == 0){
                    $tipoCliente = 'Foráneo';
                }

                $visita = 'Sí';
                if($load->is_visita == 0){
                    $visita = 'No';
                }
                /*datos de registro*/
                $datos_registro    = [];
                if (Auth::user()->rol_id != 4) {
                    $datos_registro [] = (object)['title' => 'Asignado a:', 'body' => $load->nombre_vendedor];
                }
                $datos_registro [] = (object)['class' => 'text-blue', 'title' => 'Ultima Actualización:', 'body' => date("d-m-Y H:i:s", strtotime($load->updated_at))];
                $datos_registro [] = (object)['title' => 'Usuario que registro:', 'body' => $load->usuario];

                $datos_contacto    = [];
                $datos_contacto [] = (object)['title' => 'Tipo persona:', 'body' => $tipo_persona];
                $datos_contacto [] = (object)['title' => 'Nombres:', 'body' => $load->nombres_rz];
                $datos_contacto [] = (object)['title' => 'Tipo de Documento:', 'body' => $load->tipo_documento];
                $datos_contacto [] = (object)['title' => 'Número de Documento:', 'body' => $load->num_documento];
                $datos_contacto [] = (object)['title' => 'Correo:', 'body' => $load->correo];
                $datos_contacto [] = (object)['title' => 'Teléfono:', 'body' => $load->telefono];
                $datos_contacto [] = (object)['title' => 'Dirección:', 'body' => $load->direccion];
                $datos_contacto [] = (object)['title' => 'Tipo de cliente:', 'body' => $tipoCliente];
                $datos_contacto [] = (object)['title' => 'Estado:', 'body' => $labelEstado];
                // $datos_contacto [] = (object)['title' => 'Empleado:', 'body' => $load->is_empleado == 0 ? 'No' : 'Sí'];
                switch ($load->estado_cliente) {
                    case 0:
                        $estado_cliente = '<div class="badge badge-pill badge-glow badge-warning mr-1 mb-1">Posible cliente</div>';
                        break;
                    case 1:
                        $estado_cliente = '<div class="badge badge-pill badge-glow badge-success mr-1 mb-1">Cliente</div>';
                        break;

                }
                switch ($load->estado_llamada) {
                    case 1:
                        $estado_llamada = '<div class="text-warning">Pendiente</div>';
                        break;
                    case 2:
                        $estado_llamada = '<div class="text-success">Realizada</div>';
                        break;
                    case 3:
                        $estado_llamada = '<div class="text-danger">Llamar luego</div>';
                        break;

                }
                $datos_estado_cliente    = [];
                $datos_estado_cliente [] = (object)['title' => '', 'body' => $estado_cliente];
                $datos_estado_cliente [] = (object)['title' => 'Visitado:', 'body' => $visita];
                $dataArray['action']             = ElementsHtmlService::optionElements($optionsElements,$load->estado == 1? null:'Desactivado');
                $dataArray['datos_registro']     = ElementsHtmlService::informativeColumn($datos_registro);
                $dataArray['datos_contacto']     = ElementsHtmlService::informativeColumn($datos_contacto);
                $dataArray['vendedor']           = $load->nombre_vendedor;
                $dataArray['estado_llamada']     = $estado_llamada;
                $dataArray['estado']             = $load->estado;
                $dataArray['estado_cliente']     = ElementsHtmlService::informativeColumn($datos_estado_cliente);


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

    public function create()
    {
        $usuario_rol = Auth::user()->rol_id;
        $usuario_vendedor = Auth::id();
        $title = 'Registrar posible cliente';
        $vendedores=User::select('id','name','num_documento')->whereRol_id(4)->whereEstado(1)->get();
        $tipoDocumentos = $this->selectType->listTypeDoc();
        $avisos= Aviso::whereEstado(1)->get();

        $distritos= Ubigeo::
        join('distritos_vendedores','ubigeos.ubigeo','=','distritos_vendedores.distrito_ubigeo')
        ->where('ubigeos.provincia', '<>', '')
        ->where('ubigeos.distrito', '<>', '')
        ->where('ubigeos.departamento','Lima')
        ->where('ubigeos.provincia','Lima')->orWhere('ubigeos.provincia', 'like', "%Prov. Const. del Callao%")->orderBy('ubigeos.id','Desc')
        ->groupBy('ubigeos.ubigeo')
        ->get();

        $array_obj  = [
            'title'          => $title,
            'tipoDocumentos' => $tipoDocumentos,
            'avisos'         => $avisos,
            'vendedores'     => $vendedores,
            'distritos'      => $distritos,
            'usuario_rol'    => $usuario_rol,
            'usuario_vendedor'    => $usuario_vendedor,
        ];
        return View::make('posibles-clientes.create', $array_obj);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $attributes = $request->except('cliente_id');
        $consulta = Cliente::count() + 1;
        $codigo = str_pad($consulta, 6, '0', STR_PAD_LEFT);
        $data_merge = array_merge($attributes, ['codigo'=>$codigo,
        'user_id' => $user_id,
        'tipo_cliente'=> Auth::user()->rol_id == 4 ? 0 : 1,
        // 'distrito_asignado'=> Auth::user()->rol_id == 4 ? Auth::user()->distrito_ubigeo : $request->distrito_asignado
        ]);
        
        Cliente::create($data_merge);
            $arr_msg = array(
            'message' => 'Posible cliente registrado',
            'status' => true);
        // Registrar gestion de visitas
        $numeroSemana = date("W"); 
        $mes = date("m"); 
        if($request->vendedor_id != 2 && Auth::user()->rol_id != 4):
        
        // Consultar gestion
        $consultGestion = GestionVisita::
          where('user_id',$request->vendedor_id)
        ->whereMes($mes)
        ->whereNumSemana($numeroSemana)
        ->first();
            if (!is_null($consultGestion)):
                $consultGestion->update([
                    'num_programadas' => $consultGestion->num_programadas + 1,
                    'num_pendientes' => $consultGestion->num_pendientes + 1
                    ]);
            else:
                $gestion = new GestionVisita();
                $gestion->user_id = $request->vendedor_id;
                $gestion->num_semana = $numeroSemana;
                $gestion->mes = $mes;
                $gestion->num_programadas = 1;
                $gestion->num_realizadas = 0;
                $gestion->num_pendientes = 1;
                $gestion->clientes_rs = 0;
                $gestion->save();
            endif;

        endif;
        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    public function edit($id)
    {
        $id =Crypt::decrypt($id);
        $usuario_rol = Auth::user()->rol_id;
        $usuario_vendedor = Auth::id();
        $title = 'Editar posible cliente';
        $cliente = Cliente::where('clientes.id',$id)->select('clientes.*','avisos.nombre')
        ->join('avisos','clientes.aviso_id','=','avisos.id')
        ->first();
        $vendedores=User::select('id','name','num_documento')->whereRol_id(4)->whereEstado(1)->get();
        $tipoDocumentos = $this->selectType->listTypeDoc();
        $avisos= Aviso::whereEstado(1)->get();

        $distritos= Ubigeo::
        join('distritos_vendedores','ubigeos.ubigeo','=','distritos_vendedores.distrito_ubigeo')
        ->where('ubigeos.provincia', '<>', '')
        ->where('ubigeos.distrito', '<>', '')
        ->where('ubigeos.departamento','Lima')
        ->where('ubigeos.provincia','Lima')->orWhere('ubigeos.provincia', 'like', "%Prov. Const. del Callao%")->orderBy('ubigeos.id','Desc')
        ->groupBy('ubigeos.ubigeo')
        ->get();

        $array_obj  = [
            'title'          => $title,
            'tipoDocumentos' => $tipoDocumentos,
            'avisos'         => $avisos,
            'vendedores'     => $vendedores,
            'distritos'      => $distritos,
            'cliente'        => $cliente,
            'usuario_rol'    => $usuario_rol,
            'usuario_vendedor'    => $usuario_vendedor,
        ];
        return View::make('posibles-clientes.edit', $array_obj);
    }

    public function update(Request $request, $id)
    {
        $data = Cliente::findOrfail($id);
        // Registrar gestion de visitas
        $fechaCreacion = strtotime($data->created_at);
        $numeroSemana = date("W",$fechaCreacion);
        $mes = date("m",$fechaCreacion);
        if($request->vendedor_id != 2 && Auth::user()->rol_id != 4):

            // Si no existe la gestion al actualizar
            $consultGestion = GestionVisita::
            where('user_id',$request->vendedor_id)
            ->whereMes($mes)
            ->whereNumSemana($numeroSemana)
            ->first();
                if(is_null($consultGestion)):
                    $gestion = new GestionVisita();
                    $gestion->user_id = $request->vendedor_id;
                    $gestion->num_semana = $numeroSemana;
                    $gestion->mes = $mes;
                    $gestion->num_programadas = 1;
                    $gestion->num_realizadas = 0;
                    $gestion->num_pendientes = 1;
                    $gestion->clientes_rs = 0;
                    $gestion->save();
                endif;

            if($data->vendedor_id != $request->vendedor_id):
            // Actualizando la gestion del anterior vendedor
            $r = $data->vendedor_id == 2 ? 0 : 1;
            $anteriorVendedor = GestionVisita::
            where('user_id',$data->vendedor_id)
            ->whereMes($mes)
            ->whereNumSemana($numeroSemana)
            ->first();
                if (!is_null($anteriorVendedor)):
                $anteriorVendedor->update([
                    'num_programadas' => $anteriorVendedor->num_programadas - $r,
                    'num_pendientes' => $anteriorVendedor->num_pendientes - $r
                    ]);
                endif;

                // Sumando al nuevo vendedor
                $consultGestionNueva = GestionVisita::
                where('user_id',$request->vendedor_id)
                ->whereMes($mes)
                ->whereNumSemana($numeroSemana)
                ->first();
                
                if (!is_null($consultGestion) && !is_null($consultGestionNueva)):
                    $consultGestionNueva->update([
                        'num_programadas' => $consultGestionNueva->num_programadas + 1,
                        'num_pendientes' => $consultGestionNueva->num_pendientes + 1
                        ]);
                endif;
            endif;
        // Consultar gestion

        endif;

        $data->update($request->except('cliente_id'));
        $arr_msg = array(
            'message' => 'Posible cliente actualizado',
            'status' => true);

        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    public function activarDesactivar($id)
    {
        $id =Crypt::decrypt($id);
        try{
            $cliente = Cliente::findOrfail($id);
            $estado = $cliente->estado;
            $estado == 1 ?  $cliente->estado = 0 :  $cliente->estado = 1;

            $cliente->save();
            $e = $cliente->estado == 0 ? ' desactivado ' : ' activado ';
            $message ='Cliente'.$e.'correctamente.';
            $response = ['status' => true, 'data' => '','message' =>  $message ];
            LogSystem::addLog($response['message'],1);
            return Response()->json($response);

        } catch (Exception $e) {
            LogSystem::addLog($e->getMessage(),0);
            $response = ['status'  => false,'data' => $e->getMessage(),'message'=>'Ocurrio un error por favor intente de nuevo o contacte con soporte.'];
            return Response()->json($response);
        }

    }

    public function searchClient($num_documento)
    {
        $search_cliente =Cliente::where('num_documento',$num_documento)->first();
        if($search_cliente)
        {
            $arr_msg = array('message' => 'Número de documento ya se encuentra registrado',
            'status' => true);
        }else{
            $arr_msg = array('message' => 'Cliente disponible',
            'status' => false);
        }

        return Response()->json($arr_msg);

    }

    // EXPORTAR EXCEL
    public function exportarExcel($fecha_inicio, $fecha_fin, $estado,$estado_cliente,$search = NULL)
    {
        $data = $this->cliente->getClientsHasSeller(Auth::id());
        // FILTROS
        $data   = $fecha_inicio != null ? $data->whereBetween(DB::raw('substr(clientes.created_at, 1, 10)'), [$fecha_inicio, $fecha_fin]) : $data;
        $data   = $estado != 'T' ? $data->where('clientes.estado', $estado): $data;
        $data   = $estado_cliente != 'T' ? $data->where('clientes.estado_cliente', $estado_cliente): $data;

        $data   = $search == null ? $data : $data->where(function ($query) use ($search) {
            if($search == 'Activo' || $search == 'Desactivado'){
                switch ($search) {
                    case 'Activo':
                        $search_number = 1;
                        break;
                    case 'Desactivado':
                        $search_number = 0;
                        break;

                }
                    $query->where('clientes.estado', 'LIKE', '%' . $search_number . '%');
                    $query->orWhere('clientes.nombres_rz', 'like', "%{$search}%");
                    $query->orWhere('clientes.direccion','like', "%{$search}%");
                    $query->orWhere('clientes.correo','like', "%{$search}%");
                    $query->orWhere('clientes.telefono', 'like', "%{$search}%");
                    $query->orWhere('clientes.tipo_documento', 'like', "%{$search}%");
                    $query->orWhere('clientes.num_documento', 'like', "%{$search}%");
            }else{
                    $query->orWhere('clientes.nombres_rz', 'like', "%{$search}%");
                    $query->orWhere('clientes.direccion','like', "%{$search}%");
                    $query->orWhere('clientes.correo','like', "%{$search}%");
                    $query->orWhere('clientes.telefono', 'like', "%{$search}%");
                    $query->orWhere('clientes.tipo_documento', 'like', "%{$search}%");
                    $query->orWhere('clientes.num_documento', 'like', "%{$search}%");
            }
        });
        $data   = $data->get();
        $export = new PosiblesClientesExport($data);
        LogSystem::addLog('Exportar clientes',1);
        return Excel::download($export, 'list-clientes.xlsx');
    }

    public function visitaCliente($id)
    {
        $id =Crypt::decrypt($id);
        try{
            $cliente = Cliente::findOrfail($id);
            $fechaCreacion = strtotime($cliente->created_at);
            $numeroSemana = date("W",$fechaCreacion);
            $mes = date("m",$fechaCreacion);
            
            $cliente->is_visita == 0 ?  $cliente->is_visita = 1 :  $cliente->is_visita = 0;

            $cliente->save();

            // Actualizar gestion de visitas

            $consult= GestionVisita::
            where('user_id',Auth::id())
            ->whereMes($mes)
            ->whereNumSemana($numeroSemana)
            ->first();

            if(is_null($consult)):
                $gestion = new GestionVisita();
                $gestion->user_id = Auth::id();
                $gestion->num_semana = $numeroSemana;
                $gestion->mes = $mes;
                $gestion->num_programadas = 0;
                $gestion->num_realizadas = 0;
                $gestion->num_pendientes = 0;
                $gestion->clientes_rs = 0;
                $gestion->clientes_foraneos = 0;
                $gestion->save();
            endif;

            $consultGestion= GestionVisita::
            where('user_id',Auth::id())
            ->whereMes($mes)
            ->whereNumSemana($numeroSemana)
            ->first();

            if($cliente->is_visita == 1):

                if($cliente->tipo_cliente == 1):
                    $consultGestion->num_realizadas = $consultGestion->num_realizadas + 1;
                    $consultGestion->num_pendientes = $consultGestion->num_pendientes - 1;
                    $consultGestion->clientes_rs = $consultGestion->clientes_rs + 1;
                else:
                    $consultGestion->clientes_foraneos = $consultGestion->clientes_foraneos + 1;
                endif;
            else:
                if($cliente->tipo_cliente == 1):
                    $consultGestion->num_realizadas = $consultGestion->num_realizadas - 1;
                    $consultGestion->num_pendientes = $consultGestion->num_pendientes + 1;
                    $consultGestion->clientes_rs = $consultGestion->clientes_rs - 1;
                else:
                    $consultGestion->clientes_foraneos = $consultGestion->clientes_foraneos - 1;
                endif;
            endif;
            $consultGestion->save();

            $e = $cliente->is_visita == 1 ? ' marcado como visita ' : ' desmarcado como visita ';
            $message ='Cliente'.$e.'correctamente.';
            $response = ['status' => true, 'data' => '','message' =>  $message ];
            LogSystem::addLog($response['message'],1);
            return Response()->json($response);

        } catch (Exception $e) {
            LogSystem::addLog($e->getMessage(),0);
            $response = ['status'  => false,'data' => $e->getMessage(),'message'=>'Ocurrio un error por favor intente de nuevo o contacte con soporte.'];
            return Response()->json($response);
        }
    }

    public function gestionarLlamada($id)
    {
        $id =Crypt::decrypt($id);
        $title = 'Gestionar llamada posible cliente';
        $cliente = Cliente::findOrfail($id);
        $tipoLlamadas = $this->selectType->listEstadoLlamada();

        $array_obj  = [
            'title'             => $title,
            'tipoLlamadas'      => $tipoLlamadas,
            'cliente'           => $cliente,
        ];
        return View::make('posibles-clientes.gestionar', $array_obj);
    }

    public function actualizarLlamada(Request $request)
    {   
        $data = Cliente::findOrfail($request->cliente_id);
        $data->estado_llamada = $request->estado_llamada;
        $data->save();

        $arr_msg = array(
            'message' => 'Gestión de llamada realizada correctamente',
            'status' => true);

        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    public function getVendedor($distrito)
    {
        $distrito = DistritoVendedor::join('users','distritos_vendedores.user_id','=','users.id')
        ->where('distritos_vendedores.distrito_ubigeo', $distrito)->pluck('users.name', 'users.id');

        return view('locations.usuarios_ditrito', ['distrito' => $distrito]);
    }
}
