<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Contrato;
use App\Libro;
use App\Revision;

use App\Coautor;
use \PDF;
use App\AsesorVenta;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\View;
use App\Cuotas;
use App\OrdenTrabajo;
use App\CuentasPorCobrar;
use App\Helpers\SelectHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use App\Templates\Template;
use Carbon\Carbon;
use App\Services\NumberToLetter;
use Exception;
use App\OrdenAutores;
use App\Http\Controllers\SendNotification;
use App\User;
use App\Parametro;
use App\CoautoresTemporal;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\AsesorventaController;
use Illuminate\Support\Facades\Auth;
use Response;
use Config;

class GerenciaController extends Controller
{
    const GERENCIA_INDEX = 'gerencia'; //route
    const MENSAJE = 'mensajeSuccess';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request){
            $data = $request->all();
            $usuario=  Auth::user()->id;
            $obj=DB::table('revisiones')
            ->join('users as u1', 'revisiones.usuario_id', '=', 'u1.id') // ['created_by']
            ->join('users as u2', 'revisiones.revisado_por', '=', 'u2.id') // ['modified_by']
            ->join('clientes','revisiones.idclientes','=','clientes.id')
            ->join('niveleslibros','revisiones.idnivelibros','=','niveleslibros.id')
            ->leftJoin('contratos','revisiones.contrato_id','=','contratos.id')
            ->select('revisiones.id','revisiones.codigo','revisiones.titulo','u1.id as usuario_id',
            'u1.nombre as asesornombres','clientes.nombres as clientesnombres','clientes.id as clientesid','clientes.apellidos',
            'niveleslibros.nombre as nombreniveles','niveleslibros.id as nivelesid',
            'clientes.tipo_documento','clientes.num_documento','clientes.correocontacto',
            'clientes.telefono','clientes.asesor_venta_id','clientes.autor','clientes.idgrado','revisiones.archivoevaluador','revisiones.estado_revision',
            'revisiones.idclientes','revisiones.idnivelibros','niveleslibros.nombre as nombre_revision','niveleslibros.descripcion',
            'revisiones.puntaje','revisiones.observaciones','revisiones.condicion','revisiones.archivo',
            'u2.nombre as revisor','contratos.id as contrato_id','contratos.monto_inicial','contratos.monto_total',
            'contratos.num_cuotas','revisiones.contrato_id as revision_contrato_id','contratos.precio_cuotas',
            'contratos.check_cuotas','contratos.observaciones as observacion_contrato',
            'contratos.cliente->domicilio as domicilio',
            'revisiones.usuario_id as asesor_venta_id')
            ->where('estado_revision',1)
/*             ->where('revisiones.iduser',$usuario)
 */         //   ->whereIn('revisiones.iduser', [$usuario, 32,14])
/*             ->orwhere('revisiones.iduser',32)
 */            ->orderBy('revisiones.id','desc');

            // FILTROS
            $sql=trim($request->get('buscarTexto'));
            if ($sql == 'Activo' || $sql == 'Desactivado') {
                switch ($sql) {
                    case 'Activo':
                        $search_number = 1;
                        break;
                    case 'Desactivado':
                        $search_number = 0;
                        break;
                }

                $obj    = $obj->where(function ($query) use ($search_number) {
                    $query->where('revisiones.condicion', 'LIKE', '%' . $search_number . '%');
                });
            }else{
                $obj = $obj->where(function ($query) use ($sql) {
                    $query->where('revisiones.titulo','LIKE','%'.$sql.'%');
                    $query->orwhere('revisiones.codigo','LIKE','%'.$sql.'%');
                    $query->orwhere('u1.nombre','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.nombres','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.apellidos','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.num_documento', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.tipo_documento', 'LIKE', '%'.$sql.'%');
                });
            }

            //COUNT
            $count = $obj->get();
            $count->count();

            //PAGINATE
            $revisiones= $obj->paginate(10);

            $clientes=DB::table('clientes')
            ->select('id','nombres','apellidos','num_documento')
            ->where('condicion','=','1')->get();

            $asesorventas=DB::table('asesorventas')
            ->select('id','nombres','num_documento','usuario_id')
            ->where('condicion','=','1')->get();

            $niveleslibros=DB::table('niveleslibros')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get();

            $typeDoc = new SelectHelper();
            $tipoDocumentos = $typeDoc->listTypeDoc();

            return view('gerencia.index',["revisiones"=>$revisiones,"count"=>$count,"data"=>$data,"clientes"=>$clientes,"asesorventas"=>$asesorventas,"niveleslibros"=>$niveleslibros,"tipoDocumentos"=>$tipoDocumentos,"buscarTexto"=>$sql]);
        }

    }
    public function listPendientes(Request $request)
    {
        $obj=Cuotas::join('ordentrabajo','cuotas.idordentrabajo','=','ordentrabajo.idordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('contratos', 'cuotas.contrato_id', '=', 'contratos.id')
        ->select('cuotas.id as idcuota','cuotas.fecha_cuota','cuotas.monto','cuotas.statu','cuotas.capturepago',
        'cuotas.idordentrabajo as ot_id','ordentrabajo.codigo','revisiones.titulo','cuotas.is_fee_init',
        'cuotas.tipo_contrato','ordentrabajo.titulo_coautoria',
        'contratos.cliente->nombres as nombre_cliente',
        'contratos.cliente->apellidos as apellido_cliente',
        'contratos.cliente->num_documento as num_documento_cliente','revisiones.idtipoeditoriales')
        ->where('capturepago','!=',null)
        ->whereIn('statu', ['3','2'])
        ->orderBy('ordentrabajo.codigo', 'desc')
        ->orderBy('cuotas.fecha_cuota', 'asc');
        $data = $request->all();
        // FILTROS
        $sql=trim($request->get('buscarTexto'));
         if ($sql == 'Pendiente' || $sql == 'Rechazado') {
             switch ($sql) {
                 case 'Pendiente':
                     $search_number = 0;
                     break;
                 case 'Rechazado':
                     $search_number = 2;
                     break;
             }

             $obj    = $obj->where(function ($query) use ($search_number) {
                 $query->where('cuotas.statu', 'LIKE', '%' . $search_number . '%');
             });
         }else{
             $obj = $obj->where(function ($query) use ($sql) {
                 $query->where('ordentrabajo.codigo','LIKE','%'.$sql.'%');
                 $query->orwhere('revisiones.titulo','LIKE','%'.$sql.'%');
                 $query->orwhere('cuotas.monto','LIKE','%'.$sql.'%');
             });
         }
        //COUNT
        $count = $obj->get();
        //dd($count);
        $count->count();
        $cuotas_pendientes= $obj->paginate(10);
        $array_obj  = [
            'cuotas'             => $cuotas_pendientes,
            'data'               => $data,
            'count'              => $count,
            'buscarTexto'        => $sql
        ];
        return View::make('gerencia.listado_pendientes', $array_obj);
    }
    public function listAprobados(Request $request)
    {
        $obj=Cuotas::join('ordentrabajo','cuotas.idordentrabajo','=','ordentrabajo.idordentrabajo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('contratos', 'cuotas.contrato_id', '=', 'contratos.id')
        ->select('cuotas.id as idcuota','cuotas.fecha_cuota','cuotas.monto','cuotas.statu','cuotas.capturepago',
        'cuotas.idordentrabajo as ot_id','ordentrabajo.codigo','revisiones.titulo','cuotas.is_fee_init',
        'cuotas.tipo_contrato','cuotas.created_at','ordentrabajo.titulo_coautoria',
        'contratos.cliente->nombres as nombre_cliente',
        'contratos.cliente->apellidos as apellido_cliente',
        'contratos.cliente->num_documento as num_documento_cliente')
        ->whereStatu(1)
        ->orderBy('cuotas.fecha_cuota', 'desc')
        ->orderBy('ordentrabajo.codigo', 'desc')
        ->orderBy('cuotas.id', 'desc');
        
        $data = $request->all();
        
        // FILTROS
        $sql=trim($request->get('buscarTexto'));

        $obj = $obj->where(function ($query) use ($sql) {
            $query->where('ordentrabajo.codigo','LIKE','%'.$sql.'%');
            $query->orwhere('revisiones.titulo','LIKE','%'.$sql.'%');
            $query->orwhere('cuotas.monto','LIKE','%'.$sql.'%');
        });

        //COUNT
        $count = $obj->get();
        $count->count();
        $cuotas_aprobadas= $obj->paginate(10);
        //dd($cuotas_aprobadas);

        $array_obj  = [
            'cuotas'             => $cuotas_aprobadas,
            'data'               => $data,
            'count'              => $count,
            'buscarTexto'        => $sql
        ];
        
        return View::make('gerencia.listado_aprobados', $array_obj);
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

        $title = "Gestionar cuota de pago";
        $cuotas=Cuotas::find($id);
        $ordentrabajo=OrdenTrabajo::
        join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->select('ordentrabajo.idordentrabajo',
        'ordentrabajo.codigo','ordentrabajo.precio',
        'ordentrabajo.fechaorden','ordentrabajo.zonaventa',
        'ordentrabajo.asesorventas','ordentrabajo.condicion','revisiones.titulo',
        'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria')
        ->whereIdordentrabajo($cuotas->idordentrabajo)
        ->first();
        $array_obj  = [
            'cuotas'             => $cuotas,
            'title'              => $title,
            'ordentrabajo'       => $ordentrabajo,
        ];
        return View::make('gerencia.show', $array_obj);
    }
    public function showDetail($id)
    {
        $title = "Detalle";
        $cuotas=Cuotas::find($id);
        $ordentrabajo=OrdenTrabajo::
        join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->select('ordentrabajo.idordentrabajo',
        'ordentrabajo.codigo','ordentrabajo.precio',
        'ordentrabajo.fechaorden','ordentrabajo.zonaventa',
        'ordentrabajo.asesorventas','ordentrabajo.condicion','revisiones.titulo',
        'ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria')
        ->whereIdordentrabajo($cuotas->idordentrabajo)
        ->first();
        $array_obj  = [
            'cuotas'             => $cuotas,
            'title'              => $title,
            'ordentrabajo'       => $ordentrabajo,
        ];
        return View::make('gerencia.show_detail', $array_obj);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        //
    }*/
    public function updateOt($ordenTrabajo_id)
    {
        OrdenTrabajo::where('ordentrabajo.idordentrabajo', $ordenTrabajo_id)
        ->update(['ordentrabajo.condicion' => 2]);
    }

    public function updateAuthorNew($orden_trabajo_id)
    {
         OrdenTrabajo::select('clientes.id','clientes.num_documento','clientes.condicion','ordentrabajo.idordentrabajo')
         ->join('orden_autores','ordentrabajo.idordentrabajo','=','orden_autores.idordentrabajo')
         ->join('clientes','orden_autores.idautor','=','clientes.id')
         ->where('clientes.condicion',2)
         ->where('ordentrabajo.idordentrabajo', $orden_trabajo_id) //->get()->dd();
         ->update(['clientes.condicion' => 1]);
    }
    /*public function createAuthor($num_documento)
    {
        $data = Cliente::whereNum_documento($num_documento)->first();
        $c = Cliente::whereNum_documento($num_documento)->first();
        if ($data == null) {
            $cliente = new Cliente();
            $cliente->tipo_documento = $c->tipo_documento;
            $cliente->num_documento = $c->num_documento;
            $cliente->nombres = $c->nombres;
            $cliente->apellidos = $c->apellidos;
            $cliente->correocontacto = $c->correocontacto;
            $cliente->telefono = $c->telefono;
            $cliente->correogmail = $c->correogmail;
            $cliente->contrasena = $c->contrasena;
            $cliente->resumen = $c->resumen;
            $cliente->orcid = $c->orcid;
            $cliente->universidad = $c->universidad;
            $cliente->idgrado = $c->idgrado;
            $cliente->especialidad  = $c->especialidad;
            $cliente->condicion = 1;
            $cliente->save();
        }else{
            $data->condicion = 1;
            $data->save();
        }

    }*/
    public function createCoAuthor($coautor,$contrato_id,$idordentrabajo)
    {

        $c = json_decode($coautor->cliente);
        $data = Cliente::whereNum_documento($c->num_documento)->first();
        //dd($data);
        if ($data == null) {
            $cliente = new Cliente();
            $cliente->tipo_documento = $c->tipo_documento;
            $cliente->num_documento = $c->num_documento;
            $cliente->nombres = $c->nombres;
            $cliente->apellidos = $c->apellidos;
            $cliente->correocontacto = $c->correocontacto;
            $cliente->telefono = $c->telefono;
            $cliente->idgrado = $c->idgrado;
            $cliente->especialidad  = $c->especialidad;
            $cliente->condicion = 1;
            $cliente->aviso_id = 7;
            $cliente->autor = 1;
            $cliente->asesor_venta_id=Auth::user()->id;
            $cliente->zona_id= Auth::user()->zona_id;
            $cliente->save();
           // dd($cliente);
        }
        
        $coautorUpdate = Coautor::whereContrato_id($contrato_id)->first();
        $coautorUpdate->estado_pago = 3;
        $coautorUpdate->condicion = 1;
        $coautorUpdate->save();

        if($coautorUpdate->condicion == 1 ){
            
           $existorden= OrdenAutores::where('orden_autores.idordentrabajo', $idordentrabajo)
           ->where('orden_autores.idcliente', $data == null ? $cliente->id : $data->id)
            ->count();
           // dd($existorden);
            if($existorden == 0){
                $objModels = new OrdenAutores();
                $objModels->idordentrabajo = $idordentrabajo;
                $objModels->idcliente = $data == null ? $cliente->id : $data->id;
                $objModels->save();  
            }else{

            }

        }
         

    }
    /*public function updateCliente($ot)
    {
        $searchClientId = Revision::join('ordentrabajo','revisiones.id','=','ordentrabajo.idrevision')
        ->where('ordentrabajo.idordentrabajo',$ot)->first();

        $num_documento = Cliente::whereId($searchClientId->idclientes)->first();
        $num_documento->autor = 1;
        $num_documento->save();

        return $num_documento->num_documento;

    }*/

    public function downloadContratoCoautoria($id)
    {
            $data = Contrato::find($id);
            $path = storage_path().'/'.'/app/public'.'/generacontratos/'.$data->archivo_contrato;
            if (file_exists($path)) {
                return Response::download($path);
            }
        //return $pdf->Output($cliente->num_documento.strtoupper($plantilla).'.pdf', 'D');
    }
    public function calcularMonto($cuotas)
    {
        $cuenta_x_cobrar = CuentasPorCobrar::whereIdordentrabajo($cuotas->idordentrabajo)->first();
        //Calcular precio pendiente de la orden de trabajo
        $resultado = 0;
        $precio_p = $cuenta_x_cobrar->precio;
        $monto_cuota = $cuotas->monto;
        $resultado = floatval($precio_p) - floatval($monto_cuota);
        //Actualizar Cuentas por cobrar}
        $r = number_format($resultado, 2, '.', '');

        $cuenta_x_cobrar->precio = $r;
        $cuenta_x_cobrar->save();

        // return $r;
    }
    public function enviarNotificacion($cuotas)
    {
        $parametro = Parametro::select('descripcion')
        ->where('codigo', 'JEFE_ARTICULOS')->first();

        $precioTotal = OrdenTrabajo::where('idordentrabajo',$cuotas->idordentrabajo)
        ->first()->precio;
        /* Verificar si para la OT ya pagaron el 100 % para
        notificar por correo al jefe de articulo para
        su cambio de estado (Habilitado para envio) */
        $porcentaje = OrdenTrabajoController::calcularPorcentaje($precioTotal,$cuotas->idordentrabajo);
        $usuarioAdmin = User::where('id',Auth::id())->first();
        if (intval($porcentaje) == 100 && $usuarioAdmin->id != 1) {
            $user = User::where('id',$parametro->descripcion)->first();
            SendNotification::notificationOT($user,$cuotas);
        }
    }
    public function updateEstadoPago($status,$contrato_id)
    {   

      //  dd($status);
        $coa = Coautor::whereContrato_id($contrato_id)
        ->first();
       // dd($coa);
       $coa->estado_pago = $status;
       $coa->save();
        // $coa->update(['coautores.estado_pago' => $status]);

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
        DB::beginTransaction();
        try{
        $date = Carbon::now();
        $cuotas=Cuotas::find($id);
        //dd($cuotas);
        $cuotas->statu = $request->statu;
        $codigoOT = $request->codigo;
        
        $id = $request->id_ordentrabajo;
        // Proceso el cual se esta aprobando una cuota
        if ($request->statu == 1) { //Aprobada

            // Actualizar el estado del cliente y crear el autor
            // Tipo de contrato foraneo
                /*if($cuotas->is_fee_init == 3 && $request->tipo_contrato == 0){
                    $num_documento = $this->updateCliente($cuotas->idordentrabajo);
                    $this->createAuthor($num_documento);
                    $this->updateAuthorNew($cuotas->idordentrabajo);
                }*/
            // Tipo de contrato coautoria
            if ($request->tipo_contrato == 1) {
                $coautor = Coautor::whereContrato_id($request->contrato_id)->first();
                $countOt = Cuotas::where('idordentrabajo', $cuotas->idordentrabajo)->count();
                if($coautor->estado_pago == 3){
                $cuotas->is_fee_init = $cuotas->is_fee_init == 4 ? 5 : $verificar;

                }else{
                    $cuotas->is_fee_init = $cuotas->is_fee_init == 4 ? 4 : $verificar;
                }
                $this->createCoAuthor($coautor,$request->contrato_id,$cuotas->idordentrabajo);

            }
            $verificar = $cuotas->is_fee_init == 3 ? 1 : 0;
            $cuotas->observaciones = $request->observaciones;
            $cuotas->is_fee_init =  $verificar;
            $cuotas->save();
            if($request->tipo_contrato == 0){
                $this->calcularMonto($cuotas);
                //$this->enviarNotificacion($cuotas);
                $obj=DB::table('ordentrabajo')
                ->join('revisiones', 'ordentrabajo.idrevision', '=', 'revisiones.id')
                ->join('users', 'ordentrabajo.asesorventas', '=', 'users.id')
                ->leftJoin('users as u2', 'ordentrabajo.aprobado_por', '=', 'u2.id') // ['aprobado_por']
                ->join('cuotas', 'ordentrabajo.idordentrabajo', '=', 'cuotas.idordentrabajo')
                ->select('ordentrabajo.idordentrabajo', 'ordentrabajo.codigo',
                'users.nombre', 'ordentrabajo.precio', 'ordentrabajo.fechaorden','ordentrabajo.fecha_inicio','ordentrabajo.fecha_conclusion',
                'ordentrabajo.zonaventa', 'ordentrabajo.asesorventas',
                'ordentrabajo.condicion', 'revisiones.titulo','u2.nombre as aprobado_por','ordentrabajo.tipo_contrato','ordentrabajo.titulo_coautoria','revisiones.idnivelibros')
                ->where('ordentrabajo.codigo',$codigoOT)
                ->first();
                $libro = new Libro();
                $libro->codigo = $obj->codigo;
                $libro->titulo = $obj->titulo;
                $libro->fechaLlegada = $date->format('Y-m-d');
                $libro->idarea = 6;
                $libro->idtipolibros = 1;
                $libro->idnivelibros = $obj->idnivelibros;
                $libro->idasesor = 1;
                $libro->idusuario = Auth::user()->id;
                $libro->ideditorial = 1;
                $libro->fechaOrden =  $obj->fechaorden;
                $libro->idstatu = 12;
                $libro->idmodalidad = 3;
                $libro->idclasificacion = 2;
                $libro->condicion = 1;
                $libro->archivo = 'noimagen.jpg';
                $libro->save();
            }               
               
                $data = OrdenTrabajo::findOrfail($id);
                
                $data->aprobado_por = Auth::user()->id;
                $data->condicion = 1;
                $data->update();
                    
        }else{ //Rechazada
            $cuotas->statu = $request->statu;
            $cuotas->observaciones = $request->observaciones;
            $coautor = Coautor::whereContrato_id($request->contrato_id)->first();
            //dd($coautor->estado_pago);
            if ($request->tipo_contrato ==1 && $coautor->estado_pago != 3) {
                $this->updateEstadoPago($request->statu,$request->contrato_id);
            }
            $cuotas->save();
        }
            // $cuotas->save();

            DB::commit();

        $statu =$request->statu == 1 ? 'Aprobada' : 'Rechazada';
        $arr_msg = array('message' => 'La cuota ha sido'.' '.$statu,
                         'status' => $request->statu == 1 ? true : false);

         return Response()->json($arr_msg);

        } catch(Exception $e){
            dd($e);
            $arr_msg = array('message' => 'Ocurrio un problema intente más tarde o actualize la página',
            'status' => true);
            return Response()->json($arr_msg);
            DB::rollBack();
        }
    }
    public function generarActualizarContrato(Request $request)
    {
        $usuario = $request->id_asesor;
      //  dd($usuario);
        $result = [];
        $result2 = [];
        $result['condicion'] = 1;
        $string = Str::uuid($request->codigo_revision_contrato.$request->tipo_documento_contrato.$request->num_documento_contrato);
        $result['uuid'] = $string; /* CREAR CADENA ALEATORIA UNICA */
        //GENERAR CODIGO UNICO DE CONTRATO
        $consulta_contratos = Contrato::count() + 1;
        $correlativo = str_pad($consulta_contratos, 4, '0', STR_PAD_LEFT);
        $result['codigo'] = 'CO'.$correlativo.$request->num_documento_contrato;
        $result['titulo_contrato'] = $request->titulo_contrato;
        $cliente = array(
            "tipo_documento" =>$request->tipo_documento_contrato,
            "idgrado" =>$request->idgrado,
            "num_documento" =>$request->num_documento_contrato,
            "nombres" =>$request->nombres_contrato,
            "apellidos" =>$request->apellidos_contrato,
            "correo" =>$request->correocontacto_contrato,
            "telefono" =>$request->telefono_contrato,
            "domicilio" =>$request->domicilio_contrato,
            "asesor_venta_id" =>$usuario
        );
    
        $result['monto_inicial'] = $request->monto_inicial;
        $result['monto_total'] = $request->monto_total;
         //inicio registrar archivos
/*          dd($request->hasFile('nombrecontrato')); 
 */         if($request->hasFile('nombrecontrato')){
            //Get filename with the extension
            $filenamewithExt = $request->file('nombrecontrato')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('nombrecontrato')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('nombrecontrato')->storeAs('public/generacontratos',$fileNameToStore);
       } 
       else{
        $fileNameToStore="noimagen.jpg";
        }
        $result['archivo_contrato']=$fileNameToStore; 
        $items = [];
        $data_aux = array();
        $cuota = array();
        $attributes = $request->all();
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
        $j = 1;
        foreach($data_aux as $key=> $value){
            $arrayItems = [
                'id' => $j,
                'fecha_cuota' => $cuota[$key]['fecha_cuota'] =  $value['fecha_cuota'],
                'monto' => $cuota[$key]['monto'] =  $value['monto']
            ];
            $j++;
            array_push($items, $arrayItems);
        }
        // $data =['cuotas' => $items];
        $jsonItems = json_encode($items);
        $result['num_cuotas'] = $jsonItems;
        $result['precio_cuotas'] = $request->precio_cuotas;
        $result['check_cuotas'] = isset($request->check_cuotas) == true ? $request->check_cuotas : 0;
        $result['cliente'] = json_encode($cliente);
        $result['observaciones'] = $request->observaciones_contrato;
        if($request->contrato_id > 0){
            $mensaje = "Se actualizo el contrato con éxito.";
            $buscarContrato = Contrato::find($request->contrato_id);
            $result2['titulo_contrato'] = $request->titulo_contrato;
            $result2['observaciones'] = $request->observaciones_contrato;
            $result2['cliente'] = json_encode($cliente);
            $result2['monto_inicial'] = $request->monto_inicial;
            $result2['monto_total'] = $request->monto_total;
                     //inicio registrar archivos
/*          dd($request->hasFile('nombrecontrato')); 
 */         if($request->hasFile('nombrecontrato')){
            //Get filename with the extension
            $filenamewithExt = $request->file('nombrecontrato')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('nombrecontrato')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('nombrecontrato')->storeAs('public/generacontratos',$fileNameToStore);
       } 
       else{
        $fileNameToStore="noimagen.jpg";
        }
            $result2['archivo_contrato']=$fileNameToStore; 
            $result2['num_cuotas'] = $jsonItems;
            $result2['precio_cuotas'] = $request->precio_cuotas;
            $result2['check_cuotas'] = isset($request->check_cuotas) == true ? $request->check_cuotas : 0;
            $buscarContrato->update($result2);
        }else{
            $mensaje = "Se genero el contrato con éxito.";
            $data = Contrato::create($result);
            $updateContratoId = Revision::whereId($request->revision_id)->first();
            $updateContratoId->contrato_id = $data->id;
            $updateContratoId->save();
        if (($updateContratoId->parent== 0 || $updateContratoId->parent== 2) && date("Y-m-d", strtotime($updateContratoId->created_at)) > '2020-08-12') {
            $data_cliente = Cliente::whereId($request->clientesid)->first();
            $data_cliente->autor = 4;
            $data_cliente->save();
        }
        }

        $asesorventa=AsesorVenta::where('idusuario',$usuario)->get()->first();
        $asesorven = $asesorventa->id;
        $revision=Revision::find($request->revision_id);
        $revision->usuario_id = $usuario;
        $revision->update();
        $cliente=Cliente::find($request->clientesid);
        $cliente->asesor_venta_id = $asesorven;
        $cliente->update();

        return Redirect::to(self::GERENCIA_INDEX)->with(self::MENSAJE, $mensaje);

    }

    public function downloadContrato($id)
    {
            $data = Contrato::find($id);
            $path = storage_path().'/'.'app/public'.'/generacontratos/'.$data->archivo_contrato;
            if (file_exists($path)) {
                return Response::download($path);
            }
        return $pdf->Output($cliente->num_documento.strtoupper($plantilla).'.pdf', 'D');


    }
    public function getCoautores(Request $request)
    {
        $obj = Coautor::select('coautores.*','ordentrabajo.titulo_coautoria','contratos.monto_total',
        'contratos.observaciones as observacion_contrato',
        'contratos.cliente->domicilio as domicilio')
        ->join('ordentrabajo','coautores.codigo_articulo','=','ordentrabajo.codigo')
        ->leftJoin('contratos','coautores.contrato_id','=','contratos.id')
        ->orderBy('coautores.id','DESC');
        $data = $request->all();
        // FILTROS
        if ($request) {
            $sql=trim($request->get('buscarTexto'));
            $obj = $obj->where(function ($query) use ($sql) {
                $query->orWhere('coautores.codigo_articulo', 'LIKE', '%'.$sql.'%');
                $query->orWhere('ordentrabajo.titulo_coautoria', 'LIKE', '%'.$sql.'%');
                $query->orWhereRaw('LOWER(coautores.cliente) LIKE "%'. strtolower($sql). '%"');
            });

            //COUNT
            $count = $obj->get();
            $count->count();

            //PAGINATE
            $coautores= $obj->paginate(15);
            $array_obj  = [
            'buscarTexto'          => $sql,
            'data'                 => $data,
            'count'                => $count,
            'coautores'            => $coautores
        ];
            return View::make('gerencia.listar-coautores', $array_obj);
        }
    }
    public function generarContratoCoautoria(Request $request)
    {
        $result = [];
        $result2 = [];
        $items = [];
        $result['condicion'] = 1;
        $consulta_contratos = Contrato::count() + 1;
        $correlativo = str_pad($consulta_contratos, 4, '0', STR_PAD_LEFT);
        $result['codigo'] = 'CO'.$correlativo;
        $result['titulo_contrato'] = $request->titulo_contrato;
        $result['check_cuotas'] = 0;
        $cliente = array(
            "tipo_documento" =>$request->tipo_documentos,
            "numero_documento" =>$request->num_documento,
            "nombres" =>$request->nombres_contrato,
            "apellidos" =>$request->apellidos_contrato,
        );
        $result['monto_inicial'] = 0.00;
        $result['monto_total'] = $request->monto_total;
        $result['num_cuotas'] = json_encode($items);
        $result['precio_cuotas'] = 0.00;
        $result['tipo_contrato'] = 1;
        $result['cliente'] = json_encode($cliente);
        //inicio registrar archivos
        if($request->hasFile('archivo_contrato')){
                //Get filename with the extension
                $filenamewithExt = $request->file('archivo_contrato')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('archivo_contrato')->guessClientExtension();
                //FileName to store
                $fileNameToStore = time().'.'.$extension;
                //Upload Image
                $path = $request->file('archivo_contrato')->storeAs('public/generacontratos',$fileNameToStore);
         } 
        else{
                $fileNameToStore="noimagen.jpg";
        }
        $result['archivo_contrato']=$fileNameToStore; 

        $mensaje = "Se genero el contrato de coautoría con éxito.";
        $data = Contrato::create($result);
        $updateCoautorId = Coautor::whereId($request->coautor_id)->first();
        $updateCoautorId->condicion = 0;
        $updateCoautorId->contrato_id = $data->id;
        $updateCoautorId->save(); 
        return redirect()->back()->with(self::MENSAJE, $mensaje);

        /*$result = [];
        $result2 = [];
        $items = [];
        $result['condicion'] = 1;
        $string = Str::uuid($request->tipo_documento_contrato.$request->num_documento_contrato);
        $result['uuid'] = $string;
        $consulta_contratos = Contrato::count() + 1;
        $correlativo = str_pad($consulta_contratos, 4, '0', STR_PAD_LEFT);
        $result['codigo'] = 'CO'.$correlativo.$request->num_documento_contrato;
        $result['titulo_contrato'] = $request->titulo_contrato;
        $result['check_cuotas'] = 0;
        $cliente = array(
            "tipo_documento" =>$request->tipo_documento_contrato,
            "idgrado" =>$request->idgrado,
            "num_documento" =>$request->num_documento_contrato,
            "nombres" =>$request->nombres_contrato,
            "apellidos" =>$request->apellidos_contrato,
            "correo" =>$request->correocontacto_contrato,
            "telefono" =>$request->telefono_contrato,
            "domicilio" =>$request->domicilio_contrato,
            "asesor_venta_id" =>$request->asesor_venta_id,
        );
        $result['monto_inicial'] = 0.00;
        $result['monto_total'] = $request->monto_total;
        $result['num_cuotas'] = json_encode($items);
        $result['precio_cuotas'] = 0.00;
        $result['tipo_contrato'] = 1;
        $result['cliente'] = json_encode($cliente);
        $result['observaciones'] = $request->observaciones_contrato;
        if($request->contrato_id > 0){
            $mensaje = "Se actualizo el contrato de coautoría con éxito.";
            $buscarContrato = Contrato::find($request->contrato_id);
            $result2['titulo_contrato'] = $request->titulo_contrato;
            $result2['observaciones'] = $request->observaciones_contrato;
            $result2['cliente'] = json_encode($cliente);
            $result2['monto_inicial'] = 0.00;
            $result2['monto_total'] = $request->monto_total;
            $result2['num_cuotas'] = json_encode($items);
            $result2['check_cuotas'] = 0;
            $result2['precio_cuotas'] = 0.00;
            $buscarContrato->update($result2);
        }else{
            $mensaje = "Se genero el contrato de coautoría con éxito.";
            $data = Contrato::create($result);

            $updateCoautorId = Coautor::whereId($request->coautor_id)->first();
            $updateCoautorId->condicion = 0;
            $updateCoautorId->contrato_id = $data->id;
            $updateCoautorId->save();

        }
        return redirect()->back()->with(self::MENSAJE, $mensaje);*/

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id)
    {
        //
    }*/
}
