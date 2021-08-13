<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogSystem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogSystem as LogHelper;
// Excel
use App\Exports\LogSystemExport;
use Maatwebsite\Excel\Facades\Excel;

class LogSystemController extends Controller
{
    public function index()
    {

        $formExportarLogSystem = 'formExportarLogSystem';
        $array_obj  = [
            'form' => $formExportarLogSystem,
        ];
        return View::make('logs.index', $array_obj);
    }


    public function indexTable(Request $request)
    {
        $columns = array(
            0 => 'log_systems.id',
            1 => 'log_systems.ip',
            2 => 'log_systems.agent',
            3 => 'log_systems.user_id',
            4 => 'log_systems.user_email',
            5 => 'log_systems.error',
            6 => 'log_systems.created_at'
        );
        $obj        = [];
        $obj        = new LogSystem();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';
        $obj        = $obj->join('users','log_systems.user_id','=','users.id');
        $obj        = $obj->select('log_systems.*','users.name as usuario');

        $totalData  = $obj->count();

        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];
            if($search == 'Correcto' || $search == 'Error'){
                switch ($search) {
                    case 'Correcto':
                        $search_number = 1;
                        break;
                    case 'Error':
                        $search_number = 0;
                        break;

                }
                    $obj->where('log_systems.error', 'LIKE', '%' . $search_number . '%');

            }else{
                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('log_systems.description', 'like', "%{$search}%");
                    $query->orWhere('log_systems.ip', 'like', "%{$search}%");
                    $query->orWhere('log_systems.agent', 'like', "%{$search}%");
                    $query->orWhere('log_systems.user_email', 'like', "%{$search}%");
                    $query->orWhere('users.name', 'like', "%{$search}%");
                });
            }
            
        }
        // FILTROS DINAMICO
        $obj           = $request->fecha_ini != null ? $obj->whereBetween('log_systems.created_at', [$request->fecha_ini . " 00:00:00", $request->fecha_fin . " 23:59:59"]) : $obj->whereBetween('log_systems.created_at', [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"]);
        $obj           = $obj->whereYear('log_systems.created_at', $request->anio);
        $obj           = $request->error != 'T' ? $obj->where('log_systems.error', $request->error): $obj;

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
                $name_error = 'Correcto';
                if($load->error == 0){
                    $name_error = 'Error';
                }
            
                $dataArray['description']               = $load->description;
                $dataArray['url']                       = $load->url;
                $dataArray['method']                    = $load->method;
                $dataArray['ip']                        = $load->ip;
                $dataArray['agent']                     = $load->agent;
                $dataArray['user_id']                   = $load->user_id;
                $dataArray['usuario']                   = $load->usuario;
                $dataArray['user_email']                = $load->user_email;
                $dataArray['error']                     = $name_error;
                $dataArray['created_at']                = date("d-m-Y H:i:s", strtotime($load->created_at));


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

    public function exportarExcel($fecha_inicio, $fecha_fin, $estado,$anio,$search)
    {
        $data        = new LogSystem();
        $data        = $data->join('users','log_systems.user_id','=','users.id');
        $data        = $data->select('log_systems.*','users.name as usuario');
        // FILTROS
        $data   = $fecha_inicio != null ? $data->whereBetween(DB::raw('substr(log_systems.created_at, 1, 10)'), [$fecha_inicio, $fecha_fin]) : $data;
        $data   = $data->whereYear('log_systems.created_at', $anio);
        $data   = $estado != 'T' ? $data->where('log_systems.error', $estado): $data;

        $data   = $search != 'T' ? $data->where(function ($query) use ($search) {
                    $query->orWhere('log_systems.description', 'like', "%{$search}%");
                    $query->orWhere('users.name', 'like', "%{$search}%");
                    $query->orWhere('log_systems.agent', 'like', "%{$search}%");
        })  : $data;
        $data   = $data->get();
        $export = new LogSystemExport($data);
        LogHelper::addLog('Exportar log del sistema',1);
        return Excel::download($export, 'log-sistema.xlsx');
    }
}
