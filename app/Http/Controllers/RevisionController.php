<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Revision;
use App\Cliente;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\RandomString;
use Illuminate\Support\Facades\Response;

class RevisionController extends Controller
{
    const MENSAJE = 'mensajeSuccess';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //idtipoproductos//idnivelarticulo
        if($request){
            $data = $request->all();
            $obj=DB::table('revisiones')
            ->join('users','revisiones.usuario_id','=','users.id')
            ->join('clientes','revisiones.idclientes','=','clientes.id')
            ->join('niveleslibros','revisiones.idnivelibros','=','niveleslibros.id')
            ->join('tipoeditoriales','revisiones.idtipoeditoriales','=','tipoeditoriales.id')
            ->select('revisiones.id',
            'revisiones.codigo',
            'revisiones.titulo',
            'users.id as usuario_id',
            'users.nombre as asesornombres',
            'clientes.nombres as clientesnombres',
            'clientes.id as clientesid','clientes.apellidos',
            'niveleslibros.nombre as nombreniveles',
            'niveleslibros.id as nivelesid',
            'tipoeditoriales.nombre as nombreeditoriales',
            'tipoeditoriales.id as editorialesid',
            'clientes.tipo_documento','clientes.num_documento','clientes.correocontacto',
            'clientes.telefono','clientes.autor','revisiones.archivoevaluador','revisiones.estado_revision',
            'revisiones.idclientes',
            'revisiones.idnivelibros','niveleslibros.nombre as nombre_revision','niveleslibros.descripcion',
            'revisiones.idtipoeditoriales','tipoeditoriales.nombre as nombre_editoriales','tipoeditoriales.descripcion',
            'revisiones.puntaje','revisiones.observaciones','revisiones.condicion','revisiones.archivo','revisiones.parent','revisiones.contrato_id')
            ->whereIn('revisiones.condicion',array('1','0'))
            ->orderBy('revisiones.id','desc');

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
                    $query->orwhere('users.nombre','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.nombres','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.num_documento', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.tipo_documento', 'LIKE', '%'.$sql.'%');
                });
            }

            //COUNT   
            $count = $obj->get();
            $count->count();
            
            //PAGINATE
            $revisiones= $obj->paginate(10);

            $niveleslibros=DB::table('niveleslibros')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get(); 

            $tipoeditoriales=DB::table('tipoeditoriales')
            ->select('id','nombre')
            ->where('condicion','=','1')->get(); 

            $clientes=DB::table('clientes')
            ->select('id','num_documento','nombres','apellidos')
            ->where('condicion','=','1')->get(); 

            return view('revision.index',["revisiones"=>$revisiones,"clientes"=>$clientes,"count"=>$count,"data"=>$data,"niveleslibros"=>$niveleslibros,"tipoeditoriales"=>$tipoeditoriales,"buscarTexto"=>$sql]);
        }

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
        $string = new RandomString();
        
        // Consulta si el cliente tiene revisiones de articulo
        $data_cliente = Cliente::whereId($request->cliente_create)->first();
        if($data_cliente == null){
            $parent = 2;
        }else{
            $parent = 1; // 1 significa que va  a guardar una revision hija ya que existe una revision padre con valor = 0
        }
        $rev= new Revision();
        $consulta = Revision::count() + 1;
        $codigo = str_pad($consulta, 6, '0', STR_PAD_LEFT);
        $rev->codigo =  $codigo;
        $rev->usuario_id = 1;
        $rev->idclientes = $request->cliente_create;
        $rev->titulo = $request->titulo_create;
        $rev->idnivelibros = $request->idnivelibros_create;
        $rev->idtipoeditoriales = $request->idtipoeditoriales_create;
        $rev->revisado_por = auth()->user()->id;
        $rev->puntaje = $request->puntaje_create;
        $rev->observaciones = $request->observaciones_create;
        $rev->estado_revision = 1;
        $rev->parent = $parent; 
       

        $rev->save();
        $str_random_revision = $string->randomString("REV-");

        $archivoevaluador = $request->file("archivoevaluador_create");
        if ($request->hasFile('archivoevaluador_create')) {
            $archivo1 = $archivoevaluador->getClientOriginalName();
            $extension = pathinfo($archivo1, PATHINFO_EXTENSION);
            $request->file('archivoevaluador_create')->storeAs('public/revision/'.$rev->idclientes, $str_random_revision.'.'.$extension);
            $rev->archivoevaluador = $str_random_revision.'.'.$extension;
            $rev->update();
        }else{
            $rev->archivoevaluador = "noimagen.jpg";
            $rev->update();
        }

        $str_random_resumen = $string->randomString("RES-");

        $archivoevaluador = $request->file("archivoresumen_create");
        if ($request->hasFile('archivoresumen_create')) {
            $archivo2 = $archivoevaluador->getClientOriginalName();
            $extension = pathinfo($archivo2, PATHINFO_EXTENSION);
            $request->file('archivoresumen_create')->storeAs('public/resumen_cliente/'.$request->cliente_create, $str_random_resumen.'.'.$extension);
            $rev->archivo = $str_random_resumen.'.'.$extension;
            $rev->update();
        }


        // Actualizar estado del cliente para ser evaluado por el Jefe de ventas (Gerencia)
        // if ($request->estado_revision == 1) {
        //     $data_cliente = Cliente::whereId($request->clientesid)->first();
        //     $data_cliente->autor = 3;
        //     $data_cliente->save();
        // }

        return Redirect::to('revision'); 
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
        $string = new RandomString();
        $str_random = $string->randomString("REV-");

        $blade = 'Revision' == $request->type ? 'revision' : 'gerencia';
        $rev= Revision::findOrFail($request->revision_id);
        $rev->codigo = $request->codigo;
        $rev->titulo = $request->titulo;
        // $rev->iduser = auth()->user()->id; // ID DEL USUARIO ASESOR
        if ($request->type == "Revision") {
            $rev->revisado_por = auth()->user()->id;
        }
        //$rev->idclientes = $request->idclientes;
        $rev->idnivelibros = $request->idnivelibros;
        $rev->puntaje = $request->puntaje;
        $rev->observaciones = $request->observaciones;
        $rev->estado_revision = $request->estado_revision;

        // $revision_id = $request->revision_id;
        $archivoevaluador = $request->file("archivoevaluador");
        if ($request->hasFile('archivoevaluador')) {
            $archivo = $archivoevaluador->getClientOriginalName();
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $request->file('archivoevaluador')->storeAs('public/revision/'.$rev->idclientes, $str_random.'.'.$extension);
            $rev->archivoevaluador = $str_random.'.'.$extension;
        }

        $rev->save();

        // Actualizar estado del cliente para ser evaluado por el Jefe de ventas (Gerencia)
        if ($request->estado_revision== 1 && ($rev->parent== 0 || $rev->parent== 2)  && date("Y-m-d", strtotime($rev->created_at)) > '2020-08-12') {
            $data_cliente = Cliente::whereId($request->clientesid)->first();
            $data_cliente->autor = 3;
            $data_cliente->save();
        }

        return Redirect::to($blade); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        $blade = 'Revision' == $request->type ? 'revision' : 'gerencia';
        $revision= Revision::findOrFail($request->revision_id);
        if($revision->condicion=="1"){

               $revision->condicion= '0';
               $revision->save();
               return Redirect::to($blade);

          }else{

               $revision->condicion= '1';
               $revision->save();
               return Redirect::to($blade);

           }
    }
    public function download($idclientes,$id){
       // dd($idclientes);
        $data = Revision::find($id);

        return response()->download(storage_path("app/public/revision/".$idclientes.'/'.$data->archivoevaluador));

     }
    public function downloadResumen($idclientes,$id)
    {
        $data = Revision::find($id);
        $path = storage_path().'/'.'app/public'.'/resumen_cliente/'.$idclientes.'/'.$data->archivo;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    public function getClientes(Request $request)
    {
        if($request->ajax()){    
            $clientes = Cliente::join('asesorventas','clientes.asesor_venta_id','=','asesorventas.id')
           ->where('clientes.condicion',1)
            ->get(['clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.id']);
            if(count($clientes) > 0){
                foreach($clientes as $cliente){
                    $arrayCliente[$cliente->id] = $cliente->num_documento.' - '.$cliente->nombres.' '.$cliente->apellidos;
                }
            }else{
                $arrayCliente[''] = "El asesor no tiene cliente asignados.";
            }

            return response()->json( $arrayCliente);
        }
    }
    
}
