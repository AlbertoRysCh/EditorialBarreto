<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cliente;
use App\AsesorVenta;
use App\Aviso;
use App\Zona;
use App\Contrato;
use App\Revision;
use App\Autor;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SelectHelper;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class ClienteController extends Controller
{   
    const MENSAJE = 'mensajeSuccess';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $data = $request->all();
            
            $obj=DB::table('clientes')
            ->join('grados','clientes.idgrado','=','grados.id')
            ->join('avisos','clientes.aviso_id','=','avisos.id')
            ->join('asesorventas','clientes.asesor_venta_id','=','asesorventas.id')
            ->join('zonas','clientes.zona_id','=','zonas.id')
            /*->join('tipoeditoriales','clientes.productos_id','=','tipoeditoriales.id')*/
            ->select('clientes.id','clientes.tipo_documento','clientes.num_documento',
            'clientes.nombres','clientes.apellidos','clientes.correocontacto',
            'clientes.telefono','clientes.correogmail','clientes.contrasena','clientes.resumen','clientes.universidad','clientes.orcid',
            'grados.nombre as nombregrado', 'clientes.condicion', 'clientes.idgrado','clientes.especialidad',
            'clientes.autor','avisos.nombre as nombre_aviso','clientes.asesor_venta_id','clientes.aviso_id',
            'asesorventas.nombres as nombre_asesor_venta','clientes.autor','clientes.codigo','zonas.descripcion as nombre_zona',
            'clientes.zona_id'/*'clientes.productos_id','tipoeditoriales.nombre as nombreproductos'*/)
            ->orderBy('clientes.id','desc');

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
                    $query->where('clientes.condicion', 'LIKE', '%' . $search_number . '%');
                });
            }else{
                $obj = $obj->where(function ($query) use ($sql) {
                    $query->where('clientes.nombres', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.apellidos', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.num_documento', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.tipo_documento', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.codigo', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('asesorventas.nombres', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('avisos.nombre', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.condicion', 'LIKE', '%'.$sql.'%');
                });
            }

        //COUNT   
        $count = $obj->get();
        $count->count();
        
        //PAGINATE
        $clientes= $obj->paginate(4);
        /*Listar los Tipos de productos*/
        $productos=DB::table('tipoeditoriales')->where('condicion','=','1')->get();
        /*listar los Grados en ventana modal*/
        $grados=DB::table('grados')->where('condicion','=','1')->get(); 
        /*listar Asesores de Ventas*/
        $asesorVentas=AsesorVenta::select('id','nombres','num_documento')->whereCondicion(1)->get();
        $type = new SelectHelper();
        $tipoDocumentos = $type->listTypeDoc();
        $avisos= Aviso::whereEstado(1)->get();
        $zonaVenta = Zona::whereEstado(1)->get();
        return view('cliente.index',["clientes"=>$clientes,
        /*"productos"=>$productos,*/
        "count"=>$count,
        "data"=>$data,
        "grados"=>$grados,
        'avisos'=>$avisos,
        "asesorVentas"=>$asesorVentas,
        "tipoDocumentos" => $tipoDocumentos,
        "buscarTexto"=>$sql,
        "zonaVenta"=>$zonaVenta]);
        
    }
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        // Se crea automaticamente el correlativo
        
        $consulta = Cliente::count() + 1;
        $codigo = str_pad($consulta, 7, '0', STR_PAD_LEFT);
        //$cliente->codigo =  $codigo;
        $condicion = '1';
        


        $asesorVentaId = 1;
        $attributes = $request->all();       
        $data = array('asesor_venta_id'=> $asesorVentaId,'codigo'=>$codigo,'condicion'=>$condicion);
        $array = array_merge($attributes,$data);
        Cliente::create($array);
        return redirect()->route('cliente.index')->with('success','Registro creado satisfactoriamente');
        
         //inicio registrar archivos

         if($request->hasFile('resumen')){

            //Get filename with the extension
            $filenamewithExt = $request->file('resumen')->getClientOriginalName();
            
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            
            //Get just ext
            $extension = $request->file('resumen')->guessClientExtension();
            
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            
            //Upload Image
            $path = $request->file('resumen')->storeAs('public/documento/autor',$fileNameToStore);

        
       } else{

        $fileNameToStore="noimagen.jpg";
    }
        
       $cliente->resumen=$fileNameToStore; 

        //fin registrar imagen
        $cliente->save();
        return Redirect::to("cliente");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::whereId($id)->first();
       

        $listarevisiones=DB::table('revisiones')
        ->select('revisiones.id','revisiones.codigo','revisiones.titulo')
        ->where('revisiones.idclientes','=',$id)
        ->where('revisiones.contrato_id','=',0)
        ->orderBy('revisiones.codigo','desc')
        ->get();

        $revisiones= DB::table('clientes')
        ->leftJoin('revisiones','clientes.id','=','revisiones.idclientes')
        ->leftJoin('ordentrabajo','revisiones.id','=','ordentrabajo.idrevision')
        ->join('users', 'revisiones.usuario_id', '=', 'users.id')
        ->join('niveleslibros','revisiones.idnivelibros','=','niveleslibros.id')
        ->leftJoin('contratos', 'revisiones.contrato_id', '=', 'contratos.id')
        ->join('tipoeditoriales','revisiones.idtipoeditoriales','=','tipoeditoriales.id')
        ->select('revisiones.*','revisiones.id as idrevision','revisiones.contrato_id','users.nombre as revisor',
        'contratos.codigo as codigo_contrato','contratos.uuid','contratos.has_ot','niveleslibros.nombre as nombre_revision','niveleslibros.descripcion',
        'contratos.monto_inicial','contratos.monto_total','tipoeditoriales.nombre as nombreproductos','revisiones.usuario_id','revisiones.contrato_id','contratos.archivo_contrato','ordentrabajo.condicion as verificar_condicion_ot','ordentrabajo.idordentrabajo as ot_id','ordentrabajo.aprobado_por')
        ->where('clientes.id',$id)
        ->where('revisiones.contrato_id','!=',0)
        ->orderBy('revisiones.codigo','desc')
        ->get();
        $select = new SelectHelper();
        
        $tipoDocumentos = $select->listTypeDoc();
        /*listar Grados*/
        $grados=DB::table('grados')->where('condicion','=','1')->get(); 
        
        
        $asesorventas=DB::table('asesorventas')
        ->select('id','nombres','num_documento','usuario_id')
        ->where('condicion','=','1')
        ->orderby('nombres','asc')
        ->get();

        $count = $revisiones->count();

        /*Listar los Tipos de productos editoriales*/
        $productos=DB::table('tipoeditoriales')
        ->where('condicion','=','1')
        ->orderby('nombre','asc')
        ->get();

        return view('cliente.show',["listarevisiones"=>$listarevisiones,
        "revisiones"=>$revisiones,
        "count"=>$count,
        "asesorventas"=>$asesorventas,
        "tipoDocumentos"=>$tipoDocumentos,
        "grados"=>$grados,
        'id'=>$id,
        'productos'=>$productos,
        'cliente'=>$cliente,]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$cliente=Cliente::find($id);
        return view('cliente.edit',compact('cliente'));*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        //dd($request->all());
        //$this->validate($request,['tipo_documento'=>'required', 'num_documento'=>'required', 'nombres'=>'required', 'apellidos'=>'required', 'correocontacto'=>'required', 'telefono'=>'required', 'correogmail'=>'required', 'contrasena'=>'required', 'resumen'=>'required', 'orcid'=>'required', 'universidad'=>'required', 'idgrado'=>'required', 'especialidad'=>'required', 'condicion'=>'required', 'autor'=>'required', 'aviso_id'=>'required', 'asesor_venta_id'=>'required', 'zona_id'=>'required']);
        
        Cliente::find($id)->update($request->all());
        
        return redirect()->route('cliente.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cliente= Cliente::findOrFail($request->cliente_id);
        if($cliente->condicion=="1"){

               $cliente->condicion= '0';
               $cliente->save();
               return Redirect::to("cliente");

          }else{

               $cliente->condicion= '1';
               $cliente->save();
               return Redirect::to("cliente");

           }
    }

    public function verificarEstadoCliente($id)
    {
        $cliente= Cliente::whereId($id)->where('autor',0)->first();
        $respuestaAutor = is_null($cliente) ? null : $cliente->autor;
        $result['status'] =  $respuestaAutor === null ? false : true;
        return json_encode($result);
    }
    public function exportarExcel(){
        return Excel::download(new ClientesExport, 'clientes.xlsx');

   }
   public function storeContrato(Request $request)
   {
            $contrato= new Contrato();
            $consulta_contratos = Contrato::count() + 1;
            $correlativo = str_pad($consulta_contratos, 4, '0', STR_PAD_LEFT);
            $contrato->codigo = $correlativo; 
            $contrato->uuid = $correlativo; 
            //Seleccionar si se hizo un revisión técnica
            $cliente = array(
                "tipo_documento" =>$request->tipodocumento,
                "numero_documento" =>$request->numdocumento,
                "nombres" =>$request->nombres_contrato,
                "apellidos" =>$request->apellidos_contrato,
            );

            $seleccion= $request->selectrevision;
            if($seleccion == 'si'){
            $contrato->titulo_contrato = $request->titulo_revision;
            $contrato->monto_total = $request->monto_total;
            $contrato->monto_inicial = $request->monto_inicial;

       //inicio registrar archivos
            if($request->hasFile('archivo')){
                //Get filename with the extension
                $filenamewithExt = $request->file('archivo')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('archivo')->getClientOriginalExtension();
                //FileName to store
                $fileNameToStore = time().'.'.$extension;
                //Upload Image
                $path = $request->file('archivo')->storeAs('public/generacontratos',$fileNameToStore);

        } else{

            $fileNameToStore="noimagen.jpg";

        }
            
        $contrato->archivo_contrato=$fileNameToStore;
        $contrato->cliente = json_encode($cliente);

        dd($contrato->cliente);
        $contrato->save();

        $updateContratoId = Revision::whereId($request->titulo_revision)->first();
        $updateContratoId->contrato_id = $contrato->id;
        $updateContratoId->usuario_id = $request->id_asesor;
        $updateContratoId->save();
        return Redirect::to("cliente/$request->id_cliente"); 


            }else
            {
                $contrato->titulo_contrato = $request->titulo;
                $contrato->monto_total = $request->monto_total;
                $contrato->monto_inicial = $request->monto_inicial;
    
           //inicio registrar archivos
                if($request->hasFile('archivo')){
                    //Get filename with the extension
                    $filenamewithExt = $request->file('archivo')->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
                    //Get just ext
                    $extension = $request->file('archivo')->getClientOriginalExtension();
                    //FileName to store
                    $fileNameToStore = time().'.'.$extension;
                    //Upload Image
                    $path = $request->file('archivo')->storeAs('public/generacontratos',$fileNameToStore);
                
            } else{

                $fileNameToStore="noimagen.jpg";
                
            }
                
            $contrato->archivo_contrato=$fileNameToStore; 
            $contrato->cliente = json_encode($cliente);
          //  dd($contrato->archivo_contrato);
            $contrato->save();

            $rev= new Revision();
            $consulta = Revision::count() + 1;
            $codigo = str_pad($consulta, 6, '0', STR_PAD_LEFT);
            $rev->codigo =  $codigo;
            $rev->usuario_id = $request->id_asesor;
            $rev->idclientes = $request->id_cliente;
            $rev->titulo = $request->titulo;
            $rev->idnivelibros = 1;
            $rev->idtipoeditoriales =  $request->idtipoeditoriales;
            $rev->revisado_por = auth()->user()->id;
            $rev->puntaje = 40;
            $rev->observaciones = "Producto desde Cero, realizado directamente por Venta";
            $rev->estado_revision = 1;
            $rev->decision = 1;
            $rev->contrato_id =  $contrato->id;
            $rev->save();
            return Redirect::to("cliente/$request->id_cliente");
    

            }
             
   }

   public function downloadContrato($id)
   {
           $data = Contrato::find($id);
           $path = storage_path().'/'.'app/public'.'/generacontratos/'.$data->archivo_contrato;
           if (file_exists($path)) {
               return Response::download($path);
           }

   }

   public function agregarAutor(Request $request)
    {   
        $asesor_id = Auth::user()->asesorventa == null ? 1 : Auth::user()->asesorventa->id;
     //   dd($asesor_id);
        $consulta = Cliente::count() + 1;
        $codigo = str_pad($consulta, 7, '0', STR_PAD_LEFT);
        
        $autor= new Autor();
        $autor->tipo_documento = $request->tipo_documento_cliente;
        $autor->num_documento = $request->num_documento_cliente;
        $autor->nombres = $request->nombres_cliente;
        $autor->apellidos = $request->apellidos_cliente;
        $autor->correocontacto = $request->correocontacto_cliente;
        $autor->telefono = $request->telefono_cliente;
        $autor->idgrado = $request->grado_id_cliente;
      //$autor->condicion = 2;
        $autor->resumen = 'noimagen.jpg';
        
        $autor->save();
        //validarcliente
        $newcliente = new Cliente();
        $newcliente->codigo =  $codigo;
        $newcliente->tipo_documento = $request->tipo_documento_cliente;
        $newcliente->num_documento = $request->num_documento_cliente;
        $newcliente->nombres = $request->nombres_cliente;
        $newcliente->apellidos = $request->apellidos_cliente;
        $newcliente->correocontacto = $request->correocontacto_cliente;
        $newcliente->telefono = $request->telefono_cliente;
        $newcliente->idgrado = $request->grado_id_cliente;
        $newcliente->condicion = 1;
        $newcliente->autor = 0;
        $newcliente->aviso_id = 1;
        $newcliente->asesor_venta_id = $asesor_id;
        $newcliente->zona_id = Auth::user()->zonas->id;
       
        $newcliente->resumen = 'noimagen.jpg';
        
        $newcliente->save();

        $mensaje = "Autor agregado correctamente.";

        return Redirect::to("cliente/$request->id_cliente"); 
    }


    // public function downloadDefault($file)
    // {
    //     $pathtoFile = public_path().'/img/'.$file;
    //     return response()->download($pathtoFile);
    // }
    
}
