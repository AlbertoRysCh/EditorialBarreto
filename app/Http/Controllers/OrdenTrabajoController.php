<?php

namespace App\Http\Controllers;
//Request
use Illuminate\Http\Request;
//Modelos
use App\OrdenTrabajo;
use App\OrdenAutores;
use App\Cuotas;
use App\CuentasPorCobrar;
use App\Libro;
use App\Revision;
use App\Zona;
use App\Contrato;
use App\Autor;
use App\Cliente;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Response;
use App\Helpers\RandomString;
use Carbon\Carbon;
use App\Helpers\SelectHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\SendNotification;
use App\User;

class OrdenTrabajoController extends Controller
{
    const ORDEN_TRABAJO_INDEX = 'ordentrabajo'; //route
    const MENSAJE = 'mensajeSuccess';
    const MENSAJE_INFO = 'mensajeInfo';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $obj=DB::table('ordentrabajo')
        ->join('revisiones', 'ordentrabajo.idrevision', '=', 'revisiones.id')
        ->join('users', 'ordentrabajo.asesorventas', '=', 'users.id')
        ->leftJoin('users as u2', 'ordentrabajo.aprobado_por', '=', 'u2.id') // ['aprobado_por']
        ->join('cuotas', 'ordentrabajo.idordentrabajo', '=', 'cuotas.idordentrabajo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->select('ordentrabajo.idordentrabajo', 'ordentrabajo.codigo',
        'users.nombre', 'ordentrabajo.precio', 'ordentrabajo.fechaorden','ordentrabajo.fecha_inicio','ordentrabajo.fecha_conclusion',
        'ordentrabajo.zonaventa', 'ordentrabajo.asesorventas','clientes.nombres','clientes.apellidos',
        'ordentrabajo.condicion', 'revisiones.titulo','u2.nombre as aprobado_por','ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria')
        /*->where('cuotas.is_fee_init',2)
        ->where('ordentrabajo.idtipoeditoriales',2)*/
        ->groupBy('ordentrabajo.idordentrabajo')
        ->orderBy('ordentrabajo.idordentrabajo', 'desc'); 

         $clientes=DB::table('orden_autores')
        ->join('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->select('orden_autores.idordentrabajo','clientes.nombres','clientes.apellidos')
        ->get(); 

        $data = $request->all();
        // FILTROS
        if ($request) {
            $sql=trim($request->get('buscarTexto'));
            if ($sql == 'Aprobado' || $sql == 'En proceso' || $sql == 'Pendiente' || $sql == 'pendiente' ) {
                switch ($sql) {
                    case 'Aprobado':
                        $search_number = 1;
                        break;
                    case 'En proceso':
                        $search_number = 0;
                        break;
                        case 'Pendiente':
                            $search_number = 0;
                            break;
                    case 'pendiente':
                    $search_number = 0;
                    break;
                }

                $obj= $obj->where(function ($query) use ($search_number) {
                    $query->where('ordentrabajo.condicion', 'LIKE', '%' . $search_number . '%');
                });
            } else {
                $obj = $obj->where(function ($query) use ($sql) {
                    $query->where('ordentrabajo.codigo','LIKE','%'.$sql.'%');
                    $query->orwhere('ordentrabajo.precio','LIKE','%'.$sql.'%');
                    $query->orwhere('ordentrabajo.zonaventa','LIKE','%'.$sql.'%');
                    $query->orwhere('ordentrabajo.asesorventas','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.nombres','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.apellidos','LIKE','%'.$sql.'%');
                    $query->orwhere('revisiones.titulo','LIKE','%'.$sql.'%');
                });
            }

            //COUNT
            $count = $obj->get();
            $count->count();

            //Total por cobrar
            $totalACobrar=CuentasPorCobrar::select('idordentrabajo','precio')->get();
            //PAGINATE
            $ordentrabajo= $obj->paginate(4);
                  
             return view('ordentrabajo.index', ["ordentrabajo"=>$ordentrabajo,"count"=>$count,"clientes"=>$clientes,"data"=>$data,"buscarTexto"=>$sql,'totalACobrar'=>$totalACobrar]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $type = new SelectHelper();
        $productos = $type->listProducts();
        $zonaVenta = Zona::whereEstado(1)->get();
        //Listar titulo de revisiones
        $revisiones=DB::table('revisiones')
        ->select(DB::raw('CONCAT(revisiones.codigo," ",revisiones.titulo) AS revisionestitulos'), 'revisiones.id')
        ->where('revisiones.condicion', '=', '1')
        ->get();

        //Listar Asesores
        $asesores=DB::table('asesors')
        ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'), 'asesors.id','asesors.nombres')
        ->where('asesors.condicion', '=', '1')
        ->get();

        //Listar Autores
        $clientes=DB::table('clientes')
        ->select('clientes.id','clientes.nombres','clientes.apellidos','clientes.num_documento')
        ->where('clientes.condicion','=','1')
        ->get();

        return view('ordentrabajo.create',["asesores"=>$asesores,"clientes"=>$clientes,'revisiones'=>$revisiones,'productos'=> $productos,'zonaVenta'=> $zonaVenta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            $usuario = auth()->user()->id;
            DB::beginTransaction();
            $date = Carbon::now();
            $user_id = $usuario;
            $revision_id = 1;
            $attributes = $request->all();

            $codigo =$request->codigo_ot;
            $fechaorden =$request->fechaorden;
            $fechainicio =$request->fechainicio;
            $fechaconclusion =$request->fechaculminacion;
            $idproducto =$request->idproducto;
            $zonaventa =$request->zonaventa;
            $aprobado_por =
            $data_merge = array_merge($attributes,
            ['asesorventas' => $user_id,
            'codigo' => $codigo,
            'condicion'=>1,
            'idrevision' => $revision_id,
            'fecha_inicio' => $fechainicio,
            'fecha_conclusion' => $fechaconclusion,
            'fechaorden' => $fechaorden,
            'idproducto' => $idproducto,
            'zonaventa' => $zonaventa,
            'aprobado_por' => $usuario, 
            'tipo_contrato'=> 1]);
            $data = OrdenTrabajo::create($data_merge);
            $ordenTrabajo_id = $data->getKey();
           // dd($idproducto);

            if($idproducto == 1){
          //  dd("entró al if");
            //$this->migrateArticle($ordenTrabajo_id); 

            $articulo = new Libro();
            $articulo->codigo = $codigo;
            $articulo->titulo = $request->titulo_coautoria;
            $articulo->fechaLlegada = $date->format('Y-m-d');
            $articulo->idarea = 6;
            $articulo->idtipolibros = 1;
            $articulo->idnivelibros = 1;
            $articulo->idasesor = 1;
            $articulo->idusuario = Auth::user()->id;
            $articulo->ideditorial = 1;
            $articulo->fechaOrden = $fechaorden;
            $articulo->idstatu = 12;
            $articulo->idmodalidad = 3;
            $articulo->idclasificacion = 2;
            $articulo->condicion = 1;
            $articulo->archivo = 'noimagen.jpg';
            $articulo->save();
            

            }

            $autorId = $request->input('id_autor');
            // OrdenAutores::where('idordentrabajo', $ordenTrabajo_id)->delete();
            foreach ($autorId as $value) {
                $ordenautores = new OrdenAutores();
                $ordenautores->idcliente = $value;
                $ordenautores->idordentrabajo  = $ordenTrabajo_id;
                $ordenautores->save();
            }
            //Agregar cuota por defecto
            $cuotaInicial = new Cuotas();
            $cuotaInicial->idordentrabajo =$ordenTrabajo_id;
            $cuotaInicial->fecha_cuota = $date->format('Y-m-d');
            $cuotaInicial->monto = 0.00;
            $cuotaInicial->statu = 0;
            $cuotaInicial->contrato_id = 0;
            $cuotaInicial->tipo_contrato = 1;
            $cuotaInicial->capturepago = NULL;
            $cuotaInicial->is_fee_init = 1;
            $cuotaInicial->save();

            DB::commit();
            $mensaje_success = "Orden de trabajo creada correctamente";
            return Redirect::to('libros/lista')->with(self::MENSAJE, $mensaje_success);

        } catch(Exception $e){
            dd($e);
            DB::rollBack();
            $mensaje_info = "Ocurrio un error al crear la orden de trabajo";
            return Redirect::to('libros/lista')->with(self::MENSAJE_INFO, $mensaje_info);
        }
        
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
        $type = new SelectHelper();
        $productos = $type->listProducts();

        $ordentrabajo=DB::table('ordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('users','ordentrabajo.asesorventas','=','users.id')
        ->select('ordentrabajo.idordentrabajo','ordentrabajo.codigo','users.nombre',
        'ordentrabajo.precio','ordentrabajo.fechaorden','ordentrabajo.fecha_inicio','ordentrabajo.fecha_conclusion','ordentrabajo.zonaventa',
        'ordentrabajo.asesorventas','ordentrabajo.condicion','revisiones.titulo','revisiones.contrato_id',
        'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria','ordentrabajo.idtipoeditoriales')
        ->where('ordentrabajo.idordentrabajo','=',$id)
        ->first();
    //dd($ordentrabajo);


        $cuotas=Cuotas::join('ordentrabajo','cuotas.idordentrabajo','=','ordentrabajo.idordentrabajo')
        ->join('contratos', 'cuotas.contrato_id', '=', 'contratos.id')
        ->select('cuotas.id as idcuota','cuotas.fecha_cuota','cuotas.monto','cuotas.statu','cuotas.capturepago',
        'contratos.cliente->nombres as nombre_cliente',
        'contratos.cliente->apellidos as apellido_cliente',
        'contratos.cliente->num_documento as num_documento_cliente')
        ->where('ordentrabajo.idordentrabajo','=',$id)
        ->where('cuotas.tipo_contrato',$ordentrabajo->tipo_contrato == 0 ? 0 : 1)
        ->where('cuotas.monto','>','0.00')
        ->orderBy('cuotas.fecha_cuota', 'desc')
        ->get();

        //Cuota por cobrar
        $cuota_por_cobrar=CuentasPorCobrar::whereIdordentrabajo($ordentrabajo->idordentrabajo)->first('precio');

        $clientes = OrdenAutores::join('clientes','orden_autores.idcliente','=','clientes.id')
        ->select('clientes.especialidad','clientes.idgrado as nombregrados','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.universidad'
        ,'clientes.correocontacto','clientes.telefono','clientes.orcid','clientes.correogmail','clientes.contrasena')
        ->where('orden_autores.idordentrabajo','=',$id)
        ->where('clientes.condicion',1)
        ->orderBy('orden_autores.id', 'asc')
        ->get();

        $array_obj  = [
            'productos'          => $productos,
            'ordentrabajo'       => $ordentrabajo,
            'cuotas'             => $cuotas,
            'idordentrabajo'     => $id,
            'clientes'            => $clientes,
            'cuota_por_cobrar'  => $cuota_por_cobrar
        ];
        return View::make('ordentrabajo.show', $array_obj);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $type = new SelectHelper();
        $productos = $type->listProducts();
        $zonaVenta = Zona::whereEstado(1)->get();
        $ordentrabajo= OrdenTrabajo::findOrFail($id);
        $Listarordentrabajo=DB::table('ordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->select('ordentrabajo.idordentrabajo','ordentrabajo.codigo','ordentrabajo.precio',
        'ordentrabajo.fechaorden','ordentrabajo.zonaventa','ordentrabajo.asesorventas',
        'ordentrabajo.condicion','ordentrabajo.idtipoeditoriales','revisiones.titulo',
        'ordentrabajo.titulo_coautoria','ordentrabajo.idtipoeditoriales','ordentrabajo.tipo_contrato','ordentrabajo.idrevision')
        ->where('ordentrabajo.idordentrabajo','=',$id)
        ->first();

        //Listar titulo de revisiones
        $revisiones=DB::table('revisiones')
        ->select(DB::raw('CONCAT(revisiones.codigo," ",revisiones.titulo) AS revisionestitulos'), 'revisiones.id')
        ->where('revisiones.condicion', '=', '1')
        ->get();

        //Listar Asesores
        $asesores=DB::table('asesors')
        ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'), 'asesors.id','asesors.nombres')
        ->where('asesors.condicion', '=', '1')
        ->get();

        //Listar Autores
        // $autores=DB::table('autores')
        // ->select(DB::raw('CONCAT(autores.nombres," ",autores.apellidos) AS autores'),'autores.id','autores.nombres','autores.apellidos','autores.num_documento')
        // ->where('autores.condicion','=','1')
        // ->get();

        $clientes = OrdenAutores::join('clientes','orden_autores.idcliente','=','clientes.id')
        ->select('clientes.especialidad','clientes.idgrado as nombregrados','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.universidad'
        ,'clientes.correocontacto','clientes.telefono','clientes.orcid','clientes.correogmail','clientes.contrasena')
        ->where('orden_autores.idordentrabajo','=',$id)
        ->orderBy('clientes.nombres', 'asc')
        ->get();

        $array_obj  = [
            'productos'          => $productos,
            'zonaVenta'          => $zonaVenta,
            'Listarordentrabajo' => $Listarordentrabajo,
            'revisiones'         => $revisiones,
            'asesores'           => $asesores,
            'clientes'            => $clientes,
            'ordentrabajo'       => $ordentrabajo
        ];
        return View::make('ordentrabajo.edit', $array_obj);
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
        //
        $data = OrdenTrabajo::findOrfail($id);
        $data->update($request->all());
        $mensaje_success = "Orden de trabajo actualiza correctamente";
        return Redirect::to('ordentrabajo')->with(self::MENSAJE, $mensaje_success);
    }

    public function guardarCuota(Request $request)
    {
        DB::beginTransaction();
        try{

            $attributes = $request->all();

            $consultaContratoId = OrdenTrabajo::join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
            ->where('ordentrabajo.idordentrabajo',$request->idordentrabajo)->first();

/*             $primeracuota = DB::table('cuotas')
            ->select('idordentrabajo')
            ->where('idordentrabajo',$request->idordentrabajo)
            ->first(); */
            
            $data_aux = array();
            $cuota = array();
            $i = 0;
            foreach ($attributes as $key => $value) {
                if ($key == 'fecha_cuota') {
                    foreach ($value as $fecha_cuota) {
                        $data_aux[$i]['fecha_cuota'] = $fecha_cuota;
                        $i++;
                    }
                }
                if ($key == 'monto') {
                    $i = 0;
                    foreach ($value as $monto) {
                        $data_aux[$i]['monto'] = $monto;
                        $i++;
                    }
                }

            }

            foreach($data_aux as $key=> $value){
                $primeracuota = DB::table('cuotas')
                ->select('idordentrabajo')
                ->where('idordentrabajo',$request->idordentrabajo)
                ->first(); 
            $cuota[$key]['fecha_cuota'] =  $value['fecha_cuota'];
            $cuota[$key]['monto'] =  $value['monto'];
            $cuota[$key]['statu'] =  0;
            $cuota[$key]['is_fee_init'] =  is_null($primeracuota) ? 3 : 2;
            $cuota[$key]['contrato_id'] =  $consultaContratoId->contrato_id;
            $cuota[$key]['capturepago'] =  NULL;
            $cuota[$key]['observaciones'] =  NULL;
            $cuota[$key]['idordentrabajo'] = $request->idordentrabajo;
            }

            foreach($cuota as $value){
                Cuotas::create($value);
            }

            DB::commit();

        } catch(Exception $e){
            DB::rollBack();
        }
        $mensaje = "Cuota(s) Registrada correctamente";
        // return redirect()->route(self::ORDEN_TRABAJO_INDEX)->with(self::MENSAJE, $mensaje);
        if($request->action_asesor_venta == 1){
            return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);
        }
        return Redirect::to(self::ORDEN_TRABAJO_INDEX)->with(self::MENSAJE, $mensaje);

    }

	public function uploadPay(Request $request)
	{
        $string = new RandomString();
        $str_random = $string->randomString("PAGO-");
        $id = $request->idcuota;
        $ot_id = $request->ot_id;
        $capturepago = $request->file("capturepago");
        if ($request->hasFile('capturepago')) {
            $archivo = $capturepago->getClientOriginalName();
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $data = Cuotas::findOrfail($id);
            $request->file('capturepago')->storeAs('public/capture_pagos/'.$ot_id, $str_random.'.'.$extension);
            $data->capturepago = $str_random.'.'.$extension;
            $data->statu = 3; // Verificando
           // $data->is_fee_init = 2;
            $data->tipo_contrato = 0;
            $data->update();
        }
        // Enviar una notificacion para verificar la cuota en pagos pendientes
        $usuarioAdmin = User::where('id',Auth::id())->first();
        if($usuarioAdmin->id != 1){
            $user = User::where('id',Config::get('params.global.user_verificar_cuotas'))->first();
            SendNotification::notificationAddCuota($user,$data);
        }
        $mensaje = "Capture subido correctamente";
        return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);


    }

    public function downloadPay($id,$ot_id)
    {
        $data = Cuotas::findOrfail($id);
        $path = storage_path().'/'.'app/public'.'/capture_pagos/'.$ot_id.'/'.$data->capturepago;
        if (file_exists($path)) {
            return Response::download($path);
        }

    }

    public function deletePay($id,$ot_id)
    {
        $mensaje = "Capture de pago eliminado correctamente.";
        $status = true;
        $data = Cuotas::findOrfail($id);

        if($data->statu == 1){
            $mensaje = "El capture de pago no se puede eliminar porque se encuentra aprobado";
            $status = false;
        }else{
            $url = $ot_id.'\\'.$data->capturepago;
            $exist = storage_path().'\\'.'app\\public'.'\\capture_pagos\\'.$url;
            if (@getimagesize($exist)) {
            unlink($exist);
            }
            $data->capturepago = NULL;
            $data->statu = 0;
            $data->save();
        }
        //Retorno del monto si el capture es eliminado y se encontraba aprobado
        // if($data->statu == 1){
        //     $resultado = 0;
        //     $cuota_por_cobrar=CuentasPorCobrar::whereIdordentrabajo($data->idordentrabajo)->first();
        //     $monto_cuota = $data->monto;
        //     $resultado = intval($cuota_por_cobrar->precio) + intval($monto_cuota);
        //     $cuota_por_cobrar->precio = number_format($resultado, 2, '.', '');
        //     $cuota_por_cobrar->save();
        // }
        $arr_msg = array('message' => $mensaje,
        'status' => $status);
        return Response()->json($arr_msg);

    }
    // Crea el articulo una vez sea aprobada la OT
    public function migrateArticle($ot)
    {
        DB::beginTransaction();
        try{
            $date = Carbon::now();
            if($ot->tipo_contrato == 0){
                $data = Revision::whereId($ot->idrevision)->first();
                $titulo = $data->titulo;
                $idnivelibros = $data->idnivelibros;
            }else{
                $titulo = $ot->titulo_coautoria;
                $idnivelibros = 1;
            }
            $articulo = new Articulo();
            $articulo->codigo = $ot->codigo;
            $articulo->titulo = $titulo;
            $articulo->fechaLlegada = $date->format('Y-m-d');
            $articulo->idarea = 6;
            $articulo->idtipoarticulo = $ot->idtipoeditoriales;
            $articulo->idnivelibros = $idnivelibros;
            $articulo->idasesor = Config::get('params.global.asesor_articulo_default');
            $articulo->idrevista = Config::get('params.global.revista_no_asignada');
            $articulo->fechaOrden = $ot->fechaorden;
            $articulo->idstatu = 13;
            $articulo->idmodalidad = 3;
            $articulo->idclasificacion = 2;
            $articulo->condicion = 1;
            $articulo->archivo = 'noimagen.jpg';
            $articulo->save();

            DB::commit();

        } catch(Exception $e){
            //dd($e->getMessage());
            DB::rollBack();
        }

    }
    public static function calcularPorcentaje($precio,$orden_trabajo_id)
    {
        // Consultar cuantas cuotas tiene aprobada
        $cuotas =  Cuotas::whereStatu(1)->whereTipo_contrato(0)->whereIdordentrabajo($orden_trabajo_id)->get();
        $monto = [];
        foreach ($cuotas as $key => $value) {
            $monto[$key]=$value->monto;
        }
        $sum_total_aprobada = array_sum($monto);

        // $calcular = ($sum_total_aprobada * 100) / $precio;
        // return round($calcular);
        return round($sum_total_aprobada / $precio * 100, 2);
    }
    public function verificarMontoOt(Request $request)
    {
        $orden_trabajo_id = $request->orden_trabajo_id;
        try {
            // Consultar monto total de la OT
            $ot = OrdenTrabajo::whereIdordentrabajo($orden_trabajo_id)->first();
            $total = self::calcularPorcentaje($ot->precio,$ot->idordentrabajo);
            if(intval($total) >= 50)
            {
                $this->migrateArticle($ot);
                $result['confirm'] = 0;
                $result['message'] = "La orden de trabajo ha sido aprobada.";
                $ot->condicion = 1;
                $ot->aprobado_por = Auth::user()->id;
                $ot->save();
            }else{
                $result['confirm'] = 1;
            }
            return json_encode($result);

        } catch (Exception $e) {
        //    dd($e->getMessage());
            $result['status'] = false;
            $result['message'] = 'Lo sentimos, ha ocurrido un error durante la verificación.';
            return json_encode($result);
        }
    }

    public function aprobarOrdenTrabajo(Request $request)
    {
        $orden_trabajo_id = $request->orden_trabajo_id;
        try {
            $ot = OrdenTrabajo::whereIdordentrabajo($orden_trabajo_id)->first();
            $this->migrateArticle($ot);
            $ot->condicion = 1;
            $ot->aprobado_por = Auth::user()->id;
            $ot->save();
            $result['status'] = true;
            $result['message'] = "La orden de trabajo ha sido aprobada.";
            return json_encode($result);
        } catch (Exception $e) {
            $result['status'] = false;
            $result['message'] = 'Lo sentimos, ha ocurrido un error durante la aprobación.';
            return json_encode($result);
        }
    }
    public function aprobarOtCoautoria(Request $request)
    {
        $orden_trabajo_id = $request->orden_trabajo_id;
        try {
            $ot = OrdenTrabajo::whereIdordentrabajo($orden_trabajo_id)->first();
            $this->migrateArticle($ot);
            $ot->condicion = 1;
            $ot->aprobado_por = Auth::user()->id;
            $ot->save();
            $mensaje_success = "La orden de trabajo ha sido aprobada.";
            return Redirect::to('ordentrabajo')->with(self::MENSAJE, $mensaje_success);
        } catch (Exception $e) {
            // dd($e);
            $mensaje_info = "Lo sentimos, ha ocurrido un error durante la aprobación.";
            return Redirect::to('ordentrabajo')->with(self::MENSAJE_INFO, $mensaje_info);
        }
    }

    public function generarOrdenTrabajo($id)
    {   

        //dd($id);
        $revisiones= DB::table('clientes')
        ->leftJoin('revisiones','clientes.id','=','revisiones.idclientes')
        ->leftJoin('ordentrabajo','revisiones.id','=','ordentrabajo.idrevision')
        ->join('users', 'revisiones.usuario_id', '=', 'users.id')
        ->join('niveleslibros','revisiones.idnivelibros','=','niveleslibros.id')
        ->leftJoin('contratos', 'revisiones.contrato_id', '=', 'contratos.id')
        ->join('tipoeditoriales','revisiones.idtipoeditoriales','=','tipoeditoriales.id')
        ->select('revisiones.*','revisiones.id as idrevision','revisiones.contrato_id','users.nombre as revisor',
        'contratos.codigo as codigo_contrato','contratos.uuid','contratos.has_ot','niveleslibros.nombre as nombre_revision','niveleslibros.descripcion',
        'contratos.monto_inicial','contratos.monto_total','contratos.id as contratosid','clientes.nombres','clientes.apellidos','tipoeditoriales.nombre as nombreeditorial','revisiones.usuario_id','revisiones.contrato_id','contratos.archivo_contrato','ordentrabajo.condicion as verificar_condicion_ot','ordentrabajo.idordentrabajo as ot_id')
        ->where('revisiones.id',$id)
        ->where('revisiones.contrato_id','!=',0)
        ->orderBy('revisiones.codigo','desc')
        ->first();
        //dd($revisiones);
        $type = new SelectHelper();
        $index = $type->listIndex();
        
        $zonas=DB::table('zonas')
        ->select('id','nombre','descripcion','estado')
        ->where('estado','=','1')
        ->get();

        $clientes= DB::table('clientes')
        ->select('id','nombres','apellidos')
        ->get();

      //dd($revisiones);

        return view('ordentrabajo.generateOT',["revisiones"=>$revisiones,
        "index"=>$index,
         "zonas"=>$zonas,
         "clientes"=>$clientes,]);

    }

    public function createAutor($revision_id,$ordenTrabajo_id)
    {
        $consultaCliente = Revision::join('clientes','revisiones.idclientes','=','clientes.id')
        ->where('revisiones.id',$revision_id)
        ->first();

        $cliente = Cliente::whereId($consultaCliente->idclientes)->first();
        $cliente->autor = 1;
        $cliente->update();
        
        $saveAuthorMain = new OrdenAutores();
        $saveAuthorMain->idordentrabajo = $ordenTrabajo_id;
        $saveAuthorMain->idcliente =  $cliente->id;

       // DD($saveAuthorMain);

        $saveAuthorMain->save();

    }

    public function saveOrdenTrabajo(Request $request)
    {


        DB::beginTransaction();
        try {
            
            $ot = new OrdenTrabajo();
            $ot->codigo = $request->codigo_ot;
            $ot->condicion = 0;
            $ot->precio = $request->montototal;
            $ot->idrevision = $request->idrevision;
            $ot->fechaorden = $request->fechaorden;
            $ot->fecha_inicio = $request->fechainicio;
            $ot->fecha_conclusion = $request->fechaculminacion;
            $ot->inde = $request->index;
            $ot->observaciones = $request->obsordentrabajo;
            $ot->zonaventa = $request->zonaventa;
            $ot->asesorventas = $request->usuario_id; //viene de Revisión Técnica
            $ot->idtipoeditoriales = $request->idtipoeditoriales;  //viene de revisión técnica
            $ot->save();
            //Actualizar column has_ot al crear la orden de trabajo
            $contrato = Contrato::whereId($request->idcontratos)->first();
            $contrato->has_ot = 1;
            $contrato->save();
            
            $this->createAutor($request->idrevision,$ot->idordentrabajo);


            // Crear autor principal
            
            $ordenTrabajo_id = $ot->getKey();

            $autorId = $request->input('id_autor');
            foreach ($autorId as $value) {
            $ordenautores = new OrdenAutores();
            $ordenautores->idcliente = $value;
            $ordenautores->idordentrabajo  = $ordenTrabajo_id;
            $ordenautores->save();
            } 


            DB::commit();

            $mensaje_success = "Orden de trabajo creada correctamente";
            return Redirect::to("cliente/$request->idclientes")->with(self::MENSAJE, $mensaje_success);

        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->withInput()->with(self::MENSAJE_INFO, 'Ocurrio un problema contacte con soporte favor.');
        }
    }
}
