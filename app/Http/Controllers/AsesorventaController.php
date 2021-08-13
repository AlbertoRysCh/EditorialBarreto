<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use \PDF;

use App\OrdenAutores;
use Mpdf\Mpdf;
use App\Templates\Template;
use Carbon\Carbon;
use App\Helpers\RandomString;
use App\Services\NumberToLetter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\SendNotification;
use App\AsesorVenta;
use App\User;
use App\Contrato;
use App\Libro;
use App\Cliente;
use App\Coautor;
use App\Cuotas;
use App\Revision;
use App\OrdenTrabajo;
use App\Aviso;
use App\FirmaCliente;
use App\CoautoresTemporal;
use App\CuentasPorCobrar;
use Illuminate\Http\Request;
use App\Helpers\SelectHelper;

class AsesorventaController extends Controller
{
    const MENSAJE = 'mensajeSuccess';
    const MENSAJE_INFO = 'mensajeInfo';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        //
        if($request){
            $sql=trim($request->get('buscarTexto'));
            $asesoresventas=DB::table('asesorventas')
            ->select('asesorventas.id','asesorventas.usuario_id','asesorventas.num_documento',
            'asesorventas.nombres','asesorventas.telefono','asesorventas.correo','asesorventas.condicion')
            ->where('asesorventas.nombres','LIKE','%'.$sql.'%')
            ->orwhere('asesorventas.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('asesorventas.id','desc')
            ->paginate(5);
        }

        return view('asesorventas.index',["asesoresventas"=>$asesoresventas,"buscarTexto"=>$sql]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request,$id)
    {
        //
        $asesor= AsesorVenta::findOrFail($request->asesor_usuario_id);
        if($asesor->condicion=="1"){
                $asesor->condicion= '0';
                $asesor->save();
            }else{
                $asesor->condicion= '1';
                $asesor->save();

            }
        $user= User::findOrFail($request->idusuario);
         if($user->condicion=="1"){
                $user->condicion= '0';
                $user->save();
                return Redirect::to("asesorventas");

           }else{
                $user->condicion= '1';
                $user->save();
                return Redirect::to("asesorventas");

            }
    }
    public function gestionarOT($id)
    {
        $type = new SelectHelper();
        $productos = $type->listProducts();
        $ordentrabajo=DB::table('ordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('users','ordentrabajo.asesorventas','=','users.id')
        ->select('ordentrabajo.idordentrabajo','ordentrabajo.codigo','users.nombre',
        'ordentrabajo.precio','ordentrabajo.fechaorden','ordentrabajo.fecha_inicio','ordentrabajo.fecha_conclusion','ordentrabajo.zonaventa',
        'ordentrabajo.asesorventas','ordentrabajo.condicion','revisiones.titulo',
        'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria','ordentrabajo.idtipoeditoriales','revisiones.idclientes')
        ->where('revisiones.contrato_id','=',$id)
        ->first();

        $cuotas=Cuotas::join('ordentrabajo','cuotas.idordentrabajo','=','ordentrabajo.idordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('contratos', 'cuotas.contrato_id', '=', 'contratos.id')
        ->select('cuotas.id as idcuota','cuotas.fecha_cuota','cuotas.monto','cuotas.statu','cuotas.capturepago',
        'contratos.cliente->nombres as nombre_cliente',
        'contratos.cliente->apellidos as apellido_cliente',
        'contratos.cliente->num_documento as num_documento_cliente')
        ->where('revisiones.contrato_id','=',$id)
       ->where('cuotas.tipo_contrato',$ordentrabajo->tipo_contrato == 0 ? 0 : 1)
        ->where('cuotas.monto','>','0.00')
        ->orderBy('cuotas.fecha_cuota', 'desc')
        ->get();
        
        $firma=DB::table('firmaclientes')
        ->select('idclientes','idorden','id')
        ->where('firmaclientes.idorden',$ordentrabajo->idordentrabajo)
        ->get();

        $cuota_por_cobrar=CuentasPorCobrar::whereIdordentrabajo($ordentrabajo->idordentrabajo)->first('precio');
        
        $clientes = OrdenAutores::join('clientes','orden_autores.idcliente','=','clientes.id')
        ->select('clientes.especialidad','clientes.idgrado as nombregrados','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.universidad'
        ,'clientes.correocontacto','clientes.telefono','clientes.orcid','clientes.correogmail','clientes.contrasena','clientes.id as idclientes')
        ->where('orden_autores.idordentrabajo','=', $ordentrabajo->idordentrabajo)
        ->where('clientes.condicion',1)
        ->orderBy('orden_autores.id', 'asc')
        ->get();

        $libros=DB::table('ordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('libros','ordentrabajo.codigo','=','libros.codigo')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->join('status','libros.idstatu','=','status.id')
        ->select('ordentrabajo.idordentrabajo','ordentrabajo.codigo',
        'ordentrabajo.precio','ordentrabajo.fechaorden','ordentrabajo.fecha_inicio','ordentrabajo.fecha_conclusion','ordentrabajo.zonaventa',
        'ordentrabajo.asesorventas','ordentrabajo.condicion','revisiones.titulo',
        'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria','ordentrabajo.idtipoeditoriales','revisiones.idclientes','editoriales.nombre as nombrerevista','editoriales.pais as revistapais','asesors.nombres as nombreasesor','clasificaciones.nombre as nombreclasificacion',
        'status.nombre as nombrestatus')
        ->where('libros.codigo',$ordentrabajo->codigo)
        ->get();

        $array_obj  = [
            'productos'         => $productos,
            'ordentrabajo'      => $ordentrabajo,
            'cuotas'            => $cuotas,
            'idordentrabajo'    => $ordentrabajo->idordentrabajo,
            'clientes'          => $clientes,
            'firma'             => $firma,
            'libros'            => $libros,
            'cuota_por_cobrar'  => $cuota_por_cobrar,
            'cliente_id'        => $ordentrabajo->idclientes,
        ];
        return View::make('asesorventas.gestionar-ot', $array_obj);
    }

    public function guardarCuotaCoautoria(Request $request){

        $cuota = new Cuotas();
        $cuota->idordentrabajo =$request->ordentrabajo_id;
        $cuota->fecha_cuota = $request->fecha_cuota_aux;
        $cuota->monto = $request->monto_aux;
        $cuota->statu = 3;
        $cuota->is_fee_init = 4;
        $cuota->tipo_contrato = 1;
        $cuota->contrato_id = $request->contratoss_id;
        $cuota->save();
        $capturepago = $request->file("capturepago");
            if ($request->hasFile('capturepago')) {
                $archivo = $capturepago->getClientOriginalName();
                $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                $data = Cuotas::findOrfail($cuota->id);
                $string = new RandomString();
                $str_random = $string->randomString("PAGO-COAUTORIA");
                $request->file('capturepago')->storeAs('public/capture_pagos/'.$cuota->idordentrabajo, $str_random.'.'.$extension);
                $data->capturepago = $str_random.'.'.$extension;
                $data->statu = 3; // Verificando
                $data->save();
            }
            $mensaje = 'Se guardó la cuota del Coautor con éxito.';
        return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);


    }

    public function updatePagoCoautor(Request $request)
    {
            $string = new RandomString();
            $str_random = $string->randomString("PAGO-COAUTORIA");
            $capturepago_update = $request->file("capturepago_update");
            if ($request->hasFile('capturepago_update')) {
                $archivo = $capturepago_update->getClientOriginalName();
                $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                $data = Cuotas::findOrfail($request->cuota_id);
                // Eliminar capture
                $url = $request->orden_trabajo_id.'\\'.$data->capturepago;
                $exist = storage_path().'\\'.'app\\public'.'\\capture_pagos\\'.$url;
                if (@getimagesize($exist)) {
                unlink($exist);
                }
                // Subir capture
                $request->file('capturepago_update')->storeAs('public/capture_pagos/'.$request->orden_trabajo_id, $str_random.'.'.$extension);
                $data->capturepago = $str_random.'.'.$extension;
                $data->fecha_cuota = $request->fecha_cuota_update;
                $data->statu = 3;
                $data->is_fee_init = 4;
                $data->save();
                $updateCoautorId = Coautor::whereId($request->coautor_id)->first();
                $updateCoautorId->estado_pago = 1;
                $updateCoautorId->save();
            }
            $usuarioAdmin = User::where('id',Auth::id())->first();
            if($usuarioAdmin->id != 1){
                $user = User::where('id',Config::get('params.global.user_verificar_cuotas'))->first();
                SendNotification::notificationCuota($user,$data);

            }
            $mensaje = 'Se actualizo el pago exitosamente.';
            return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);

    }
    public function storePagoCoautor(Request $request)
    {
        $string = new RandomString();
        $str_random = $string->randomString("PAGO-COAUTORIA");
        $consultaOt = OrdenTrabajo::whereCodigo($request->codigo)->first();
        $updateCoautorId = Coautor::whereId($request->coautor_id)->first();
        //Agregar pago unico del coautor
        $monto = new Cuotas();
        $monto->idordentrabajo =$consultaOt->idordentrabajo;
        $monto->fecha_cuota = $request->fecha_cuota;
        $monto->monto = $request->monto_total_data;
        $monto->tipo_contrato = 1;
        $monto->contrato_id = $updateCoautorId->contrato_id;
        $monto->capturepago = $request->capturepago;
        $monto->observaciones = $request->observaciones;
        $monto->save();
        $updateCoautorId->estado_pago = 1;
        $updateCoautorId->save();
        $capturepago = $request->file("capturepago");
        if ($request->hasFile('capturepago')) {
            $archivo = $capturepago->getClientOriginalName();
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $data = Cuotas::findOrfail($monto->id);
            $request->file('capturepago')->storeAs('public/capture_pagos/'.$consultaOt->idordentrabajo, $str_random.'.'.$extension);
            $data->capturepago = $str_random.'.'.$extension;
            $data->statu = 3;
            $data->is_fee_init = 4;
            $data->save();
        }
        $usuarioAdmin = User::where('id',Auth::id())->first();
        if($usuarioAdmin->id != 1){
            $user = User::where('id',Config::get('params.global.user_verificar_cuotas'))->first();
            SendNotification::notificationCuota($user,$data);

        }
        $mensaje = 'Se adjunto el pago exitosamente.';
        return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);

    }
 



    public function downloadContratoCliente($id)
    {
        $data = Contrato::find($id);
        $valoresDinamicos = NULL;
        if ($data->tipo_contrato == 0) {
            // Calcular el porcentaje de la cuota inicial
            $monto_inicial = $data->monto_inicial;
            $monto_total = $data->monto_total;
            $precio_cuotas = $data->precio_cuotas;
            $num_cuotas = json_decode($data->num_cuotas, true);

            $monto = [];
            foreach ($num_cuotas as $key => $value) {
                $monto[$key]=$value['monto'];
            }
            $sum_total = array_sum($monto);
            $calcular_mi = self::porcentaje($monto_total, $monto_inicial, 2);
            $calcular_r = self::porcentaje($monto_total, $precio_cuotas, 2);
            $calcular_cuotas = self::porcentaje($monto_total, $sum_total, 2);
            // $calcular_mi = ($monto_inicial * 100) / $monto_total;
            // $calcular_r = ($precio_cuotas * 100) / $monto_total;
            // $calcular_cuotas = ($sum_total * 100) / $monto_total;
            $p1 = $calcular_mi;
            $p2 = $calcular_r;
            $p3 = $calcular_cuotas;
            $arrayDinamico = array(
                "p_monto_inicial" =>$p1,
                "p_monto_restante" =>$p2,
                "p_monto_cuotas" =>$p3,
            );
            $valoresDinamicos = json_encode($arrayDinamico);

        }
        // Consultando tabla de coautores temporal
        $temp = 0;
        $coautoresTemp = CoautoresTemporal::
        select('autores.id','autores.nombres','autores.apellidos','autores.num_documento','autores.tipo_documento','autores.idgrado')
        ->join('autores','coautores_temp.autor_id','=','autores.id')
        ->orderBy('coautores_temp.id','ASC')
        ->where('contrato_id',$id)->get();
        
        if(count($coautoresTemp) == 0){
            $temp = 1;
            $coautores = Revision::select('autores.id','autores.nombres','autores.apellidos','autores.num_documento','autores.tipo_documento','autores.idgrado')
            ->leftJoin('ordentrabajo','revisiones.id','=','ordentrabajo.idrevision')
            ->leftJoin('orden_autores','ordentrabajo.idordentrabajo','=','orden_autores.idordentrabajo')
            ->join('autores','orden_autores.idautor','=','autores.id')
            ->where('revisiones.contrato_id',$id)
            ->orderBy('orden_autores.id','ASC')
            ->get();
        }

        $cliente = json_decode($data->cliente);
        setlocale(LC_ALL, 'es_ES');
        $fecha = Carbon::parse($data->updated_at);
        $fecha->format("F"); // Inglés.
        $mes = $fecha->formatLocalized('%B');// mes en idioma español
        $letras_total=NumberToLetter::convertir($data->monto_total,'SOLES',false,'Céntimos');
        $arrayfecha = array(
            "mes" =>$mes,
            "dia" =>$fecha->day,
            "anio" =>$fecha->year
        );
        $arrayFechaLetras = array(
            "dia_letras" =>NumberToLetter::convertir($arrayfecha['dia'],'',false,''),
            "anio_letras" =>NumberToLetter::convertir($arrayfecha['anio'],'',false,'')
        );
        $json_fecha = json_encode($arrayfecha);
        $json_fecha_letras = json_encode($arrayFechaLetras);
        $template = new Template();
        $template = new Template();
        switch ($data->tipo_contrato) {
            case 0:
                $plantilla= "contrato";
                break;
            case 1:
                $plantilla= "contrato-coautoria";
                break;

        }
        $html = $template->pdf($plantilla,$data,$json_fecha, $letras_total,$json_fecha_letras,count($coautoresTemp) == 0 ? $coautores : $coautoresTemp,$valoresDinamicos,$temp);
        $pdf = new Mpdf([
            'format' => 'a4',
            'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 10,
			'margin_bottom' => 10,
        ]);
        $pdf->setFooter('{PAGENO}');
        $pdf->WriteHTML($html);

        // $pdf->Output();
        // return  $pdf;
        return $pdf->Output($cliente->num_documento.strtoupper($plantilla).'.pdf', 'D');

    }

    public function getPagoPendiente($id){

        $cuotas = Cuotas::select('monto','contrato_id')
       ->where('contrato_id',$id)
       ->sum('monto');        
       
       $contrato = Contrato::select('monto_total')
       ->where('id',$id)
       ->sum('monto_total');       

       $sumacuotas = $contrato - $cuotas;
       
       return Response::json($sumacuotas);
}

    public function getArticles(Request $request)
    {
        $obj = OrdenTrabajo::where('ordentrabajo.tipo_contrato',1)
        ->where('idtipoeditoriales',0)
        ->orderBy('ordentrabajo.idordentrabajo', 'desc');
        
        $coautores = Coautor::select('codigo_articulo',DB::raw('count(*) as count_pendientes')) 
        ->whereIn('condicion',array(2,0))
        ->groupBy('codigo_articulo')
        ->get();

        $data = $request->all();
        
        // FILTROS
        if ($request) {
            $sql=trim($request->get('buscarTexto'));

                $obj = $obj->where(function ($query) use ($sql) {
                    $query->orWhere('ordentrabajo.codigo', 'LIKE', '%'.$sql.'%');
                    $query->orWhere('ordentrabajo.titulo_coautoria', 'LIKE', '%'.$sql.'%');
                });
            

            //COUNT
            $count = $obj->get();
            $count->count();
        
            //PAGINATE
            $ordenTrabajo= $obj->paginate(15);
            $array_obj  = ['buscarTexto'=> $sql,'ordenTrabajo'=> $ordenTrabajo,'data'=> $data,'count'=> $count,'coautores'=> $coautores
        ];
            return View::make('asesorventas.listar-articulos', $array_obj);
        }
    }

    public function saveAuthors(Request $request)
    {
        DB::beginTransaction();
        try {
        $cantidadAutoresReales = $request->input('cantidadAutoresReales') + 2;
        $codigo = $request->codigo;
        for ($i = 0; $i < $cantidadAutoresReales; ++$i) {
            $autorNuevo = $request->input('nuevoCliente_'.$i);
            $especialidad = $request->input('especialidad_'.$i);
            $nombres = $request->input('nombres_'.$i);
            $apellidos = $request->input('apellidos_'.$i);
            $num_documento = $request->input('num_documento_'.$i);
            $correocontacto = $request->input('correocontacto_'.$i);
            $telefono = $request->input('telefono_'.$i);
            $tipo_documento = $request->input('tipo_doc_'.$i);
            $tipo_grado = $request->input('tipo_grado_'.$i);

            $cliente = array(
                "especialidad" =>$especialidad,
                "num_documento" =>$num_documento,
                "nombres" =>$nombres,
                "apellidos" =>$apellidos,
                "correocontacto" =>$correocontacto,
                "telefono" =>$telefono,
                "tipo_documento" =>$tipo_documento,
                //"autor" => 1,
                "idgrado" =>$tipo_grado,
                "asesor_venta_id" =>Auth::id(),
                "asesor_venta_nombre" =>Auth::user()->nombre,
                
            );
            
            if ('1' == $autorNuevo) {
                $coautores = new Coautor();
                $coautores->codigo_articulo = $codigo;
                $coautores->cliente = json_encode($cliente);
                $coautores->condicion = 2;
                $coautores->estado_pago = 0;
                $coautores->save();
            }
        }
  
            DB::commit();
            $mensaje = 'Sus cambios fueron guardados correctamente.';
            return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            $mensaje = 'Ocurrió un error al guardar los coautores.';
            return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);
        }

    }

    public function showDetailArticle(Request $request ,$id,$codigo)
    {

      //  dd($id);
        $grados=DB::table('grados')->whereCondicion(1)->get(); 
        
        $type = new SelectHelper();
        $tipoDocumentos = $type->listTypeDoc();

        $ordenTrabajo = OrdenTrabajo::where('ordentrabajo.tipo_contrato',1)
        ->where('ordentrabajo.idordentrabajo',$id)
        ->orderBy('ordentrabajo.idordentrabajo', 'asc')->first();

        $cuotas = Cuotas::select('id','idordentrabajo','statu','observaciones','fecha_cuota','contrato_id')
        ->where('cuotas.is_fee_init',4)
        ->get();


        $obj = Coautor::select('coautores.*','contratos.codigo as codigo_contrato',
        'contratos.uuid','contratos.titulo_contrato','contratos.monto_total','grados.nombre','coautores.contrato_id')
        ->join('grados','cliente->idgrado','=','grados.id')
        ->leftJoin('contratos', 'coautores.contrato_id', '=', 'contratos.id')
       // ->whereIn('coautores.condicion',array(2,0))
        ->where('coautores.codigo_articulo',$codigo)
        ->orderBy('coautores.condicion','ASC')
        ->orderBy('coautores.id','DESC');
       
        $data = $request->all();

        $clientes = OrdenAutores::join('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->join('ordentrabajo','orden_autores.idordentrabajo','=','ordentrabajo.idordentrabajo')
        ->join('grados','clientes.idgrado','=','grados.id')
        ->select('clientes.especialidad', 'clientes.idgrado as nombregrados', 
        'clientes.nombres', 'clientes.apellidos', 'clientes.num_documento',
        'clientes.universidad', 'clientes.correocontacto', 
        'clientes.telefono', 'clientes.orcid', 
        'clientes.correogmail', 'clientes.contrasena','clientes.tipo_documento','grados.nombre')
        ->where('ordentrabajo.codigo', $codigo)
        ->where('clientes.condicion', 1)
        ->orderBy('clientes.id', 'asc')
        ->get();
        //COUNT
        $count = $obj->get();
        $count->count();
        
        //PAGINATE
        $coautoresPendientes= $obj->paginate(5);
        $array_obj  = [
        'ordenTrabajo'            => $ordenTrabajo,
        'ordenTrabajo_id'         => $id,
        'codigo_articulo'         => $codigo,
        'clientes'                => $clientes,
        'coautoresPendientes'     => $coautoresPendientes,
        'data'                    => $data,
        'countPendientes'         => $count,
        'grados'                  => $grados,
        'tipoDocumentos'          => $tipoDocumentos,
        'cuotas'                  => $cuotas,
        ];
        return View::make('asesorventas.listar-detalles-articulo', $array_obj);
 
    }
    
    
    public function getHistorialCuotas($id){

        $cuotas = Cuotas::select('id','fecha_cuota','monto','statu','capturepago',
        DB::raw("IF(statu= '1', 'Aprobado', 'Rechazado') statu"))
       ->where('contrato_id',$id)
       ->get();        
        
       return Response::json($cuotas);
    }

    public function historialCuotas($id){

        $cuotas=Cuotas::join('contratos','cuotas.contrato_id', '=', 'contratos.id')
        ->select('cuotas.id as idcuota','cuotas.fecha_cuota','cuotas.monto','cuotas.statu','cuotas.capturepago','cuotas.idordentrabajo',
        'contratos.cliente->nombres as nombre_cliente',
        'contratos.cliente->apellidos as apellido_cliente',
        'contratos.cliente->num_documento as num_documento_cliente')
        ->where('cuotas.contrato_id','=',$id)
        ->orderBy('cuotas.fecha_cuota', 'desc')
        ->get();    
       // dd($cuotas);
        $cliente=Coautor::
        select('coautores.cliente->nombres as nombre_cliente',
        'coautores.cliente->apellidos as apellido_cliente',
        'coautores.cliente->num_documento as num_documento_cliente')
        ->where('contrato_id','=',$id)
        ->get();  

     //   dd($cliente);
    
        return view('asesorventas.historialcuotas',["cuotas"=>$cuotas,
            "cliente"=>$cliente,]);
}

        //Todo referente al Generar PDF de la Orden de Trabajo

        public function exportarPDF($id){
            // dd($id);
             $ordentrabajo=DB::table('ordentrabajo')
             ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
             ->join('users','ordentrabajo.asesorventas','=','users.id')
             ->select('ordentrabajo.idordentrabajo','ordentrabajo.codigo as codigoorden','users.nombre',
             'ordentrabajo.precio','ordentrabajo.fechaorden','ordentrabajo.zonaventa',
             'ordentrabajo.asesorventas','ordentrabajo.fecha_conclusion','ordentrabajo.observaciones','ordentrabajo.inde','ordentrabajo.condicion','revisiones.titulo as titulorevisiones',
             'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria','ordentrabajo.idtipoeditoriales')
             ->where('revisiones.contrato_id','=',$id)
             ->first();
     
             $articulo=DB::table('ordentrabajo')
             ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
             ->join('users','ordentrabajo.asesorventas','=','users.id')
             ->join('libros','ordentrabajo.codigo','=','libros.codigo')
             ->select('ordentrabajo.idordentrabajo','ordentrabajo.codigo as codigoorden','users.nombre',
             'ordentrabajo.precio','ordentrabajo.fechaorden','ordentrabajo.zonaventa',
             'ordentrabajo.asesorventas','ordentrabajo.fecha_conclusion','ordentrabajo.observaciones','libros.fechallegada','ordentrabajo.inde','ordentrabajo.condicion','revisiones.titulo as titulorevisiones',
             'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria','ordentrabajo.idtipoeditoriales')
             ->where('revisiones.contrato_id','=',$id)
             ->first();
     
             if($articulo == null){
                 $exist = 0;
             }
             else
             {
                 $exist = $articulo->fechallegada;
     
             }
     
          //  dd($exist);
             $coautores = Revision::select('clientes.id','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.correocontacto','clientes.telefono','clientes.tipo_documento','clientes.idgrado','grados.nombre as nombregrados')
             ->leftJoin('ordentrabajo','revisiones.id','=','ordentrabajo.idrevision')
             ->leftJoin('orden_autores','ordentrabajo.idordentrabajo','=','orden_autores.idordentrabajo')
             ->join('clientes','orden_autores.idcliente','=','clientes.id')
             ->join('grados','clientes.idgrado','=','grados.id')
             ->where('revisiones.contrato_id',$id)
             ->orderBy('orden_autores.id','ASC')
             ->get();
     
             $pdf= \PDF::loadView('pdf.ordentrabajo',['ordentrabajo'=>$ordentrabajo,'exist'=>$exist,'coautores'=>$coautores])->setPaper('letter', 'landscape');
             return $pdf->download('OrdendeTrabajo.pdf');
     
         }

         public function searchAutor($num_documento,$codigo)
    {
        $search_author =Libro::join('ordentrabajo','ordentrabajo.codigo','=','libros.codigo')
        ->join('orden_autores','ordentrabajo.idordentrabajo','=','orden_autores.idordentrabajo')
        ->join('clientes','orden_autores.idcliente','=','clientes.id')
        ->where('libros.codigo',$codigo)
        ->where('clientes.num_documento',$num_documento)->first();
        if($search_author)
        {
            $arr_msg = array('message' => 'Número de documento ya se encuentra registrado',
            'status' => true);
        }else{
            $coautor =Coautor::where('codigo_articulo',$codigo)
            ->where('cliente->num_documento',$num_documento)->first();
            if($coautor){
                $arr_msg = array('message' => 'Cliente se encuentra en proceso de aprobación.',
                'status' => true);
            }else{
                // Numero de autor disponible en el articulo pero busca para traer o no informacion del autor
                $cliente =Cliente::where('num_documento',$num_documento)->first();
                if($cliente && $cliente->condicion == 0){
                    $arr_msg = array('message' => 'Autor se encuentra deshabilitado.',
                    'status' => true); 
                }else{
                    $arr_msg = array('message' => 'Número disponible',
                    'status' => false,'data' =>$cliente);
                }

            }

        }
        
        return Response()->json($arr_msg);
       
    }
    
    public function subirPago(Request $request){

        $string = new RandomString();
        $str_random = $string->randomString("PAGO-");
        $id = $request->id_cuota;
        $ot_id = $request->ot_id;
        $capturepago = $request->file("capturepago");
        if ($request->hasFile('capturepago')) {
            $archivo = $capturepago->getClientOriginalName();
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $data = Cuotas::findOrfail($id);
            $request->file('capturepago')->storeAs('public/capture_pagos/'.$ot_id, $str_random.'.'.$extension);
            $data->capturepago = $str_random.'.'.$extension;
            $data->statu = 3; // Verificando
            $data->tipo_contrato = 1;
            $data->update();
        }
        $mensaje = 'Se guardó la cuota del Coautor con éxito.';
        return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);

    }

    public function guardarFirma(Request $request)
    {
        $firma= new FirmaCliente();
        $firma->idclientes = $request->id_clientes;
       // dd($firma->idclientes);
        $firma->idorden  = $request->idordentrabajo;
        if($request->hasFile('firma')){

            //Get filename with the extension
            $filenamewithExt = $request->file('firma')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('firma')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('firma')->storeAs('public/firma/',$fileNameToStore);
        
       } else{

        $fileNameToStore="noimagen.jpg";
    }
        
        $firma->archivo=$fileNameToStore; 
        $firma->save();

        $mensaje = 'Se guardó el archivo firma del Autor.';
        return redirect()->back()->withInput()->with(self::MENSAJE, $mensaje);
    }

    public function downloadFirma($id){
 
        $dl = FirmaCliente::find($id);
        return response()->download(storage_path("app/public/firma/".$dl->archivo));

     }

}
