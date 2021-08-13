<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Services\ElementsHtmlService;
use App\Helpers\LogSystem;
use Illuminate\Support\Facades\Auth;
// Modelos
use App\Models\Configuracion;
use App\User;
use Exception;

class ConfiguracionController extends Controller
{

    const VALUE = 'value';
    const MENSAJE = 'mensajeSuccess';

    public function __construct()
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array_obj  = [

        ];
        return View::make('configuraciones.index', $array_obj);
    }
    public function indexTable(Request $request)
    {
        $columns = array(
            0 => 'configuraciones.id',
            1 => 'configuraciones.code',
            2 => 'configuraciones.value',
            3 => 'configuraciones.description',
            4 => 'configuraciones.state',
        );
        $obj        = [];
        $obj        = new Configuracion();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $obj        = $obj->where('code','!=','MANTENIMIENTO_WEB');
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';


        $totalData  = $obj->count();


        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];
                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('configuraciones.code', 'like', "%{$search}%");
                    $query->orWhere('configuraciones.description', 'like', "%{$search}%");
                    $query->orWhere('configuraciones.value', 'like', "%{$search}%");
                });
        }

        // FILTROS DINAMICO
        $obj           = $request->state != 'T' ? $obj->where('configuraciones.state', $request->state): $obj;

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
                $optionsElements = $dataAtribute = [];
                $dataAtribute []    = (object)['name' => 'id', self::VALUE => $load->id];

                $optionsElements [] = (object)[
                    'name'   => 'Editar',
                    'icon'   => 'feather icon-edit-2',
                    'target' => '_self',
                    'route'  => url('configuraciones/'.$load->id.'/edit'),
                    'data'   => $dataAtribute,
                    'class'  => 'edit',
                ];
                if($load->code !== 'VERSION_APP'){
                    $optionsElements [] = (object)[
                        'name'   => $load->state == 1 ? 'Desactivar': 'Activar',
                        'icon'   => $load->state == 1 ? 'feather icon-user-minus' : 'feather icon-user-check',
                        'target' => '_self',
                        'route'  => route('configuraciones.act.desac',$load->id),
                        'data'   => $dataAtribute,
                        'class'  => 'activar_desactivar',
                    ];
                }



                if($load->state == 1){
                    $state = '<div class="badge badge-pill badge-glow badge-success mr-1 mb-1">Activo</div>';
                }
                else{
                    $state = '<div class="badge badge-pill badge-glow badge-danger mr-1 mb-1">Desactivado</div>';
                }

                $dataArray['action']            = ElementsHtmlService::optionElements($optionsElements,$load->estado == 1? null:'Inactivo');
                $dataArray['code']              = $load->code;
                $dataArray['value']             = $load->value;
                $dataArray['description']       = $load->description;
                $dataArray['state']             = $state;


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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Registrar configuración';

        $array_obj  = [
            'title'          => $title
        ];
        return View::make('configuraciones.create', $array_obj);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        Configuracion::create($attributes);
            $arr_msg = array(
            'message' => 'Configuración registrada correctamente',
            'status' => true);
        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Editar configuración';
        $configuracion = Configuracion::findOrfail($id);

        $array_obj  = [
            'title'          => $title,
            'configuracion'        => $configuracion
        ];
        return View::make('configuraciones.edit', $array_obj);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Configuracion::findOrfail($id);
        $data->update($request->all());
        $arr_msg = array(
            'message' => 'Configuración actualizada correctamente',
            'status' => true);
        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function activarDesactivar($id)
    {

        try{
            $configuracion = Configuracion::findOrfail($id);
            $estado = $configuracion->state;
            $estado == 1 ?  $configuracion->state = 0 :  $configuracion->state = 1;

            $configuracion->save();
            $e = $configuracion->state == 0 ? ' desactivada ' : ' activada ';
            $message ='Configuración'.$e.'correctamente.';
            $response = ['status' => true, 'data' => '','message' =>  $message ];
            LogSystem::addLog($response['message'],1);
            return Response()->json($response);

        } catch (Exception $e) {
            LogSystem::addLog($e->getMessage(),1);
            $response = ['status'  => false,'data' => $e->getMessage(),'message'=>'Ocurrio un error por favor intente de nuevo o contacte con soporte.'];
            return Response()->json($response);
        }

    }
    // Mantenimiento
    public function verificarMantenimiento()
    {
        $obj = Configuracion::where('code', 'MANTENIMIENTO_WEB')->first()->value;
        return $obj;
    }

    public function showMantenimiento()
    {
        $title = 'Mantenimiento';

        $array_obj  = [
            'title'          => $title
        ];
        return View::make('configuraciones.form-mantenimiento', $array_obj);
    }
    public function updateMantenimiento($id)
    {
        $obj = Configuracion::where('code', 'MANTENIMIENTO_WEB')->first();
        $obj->value = $id;
        $obj->save();
        $mensaje = $id == 1 ? 'Mantenimiento activado correctamente' : 'Mantenimiento desactivado correctamente';
        return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);
      
    }
}
