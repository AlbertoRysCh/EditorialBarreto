<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Libro;
use App\DetallesArticulos;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClasificacionesExport;
use App\Exports\ArticulosPrincipalExport;
use App\Exports\ArticulosRedireccionExport;
use App\Exports\AjustesExport;
use App\Exports\ArticulosEnviadosExport;
use App\Exports\habilitadosExport;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Historial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvestigacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $data = $request->all();
            $sql=trim($request->get('buscarTexto'));
            $libros=DB::table('libros')
            ->join('editoriales','libros.ideditorial','=','editoriales.id')
            ->join('niveles','editoriales.idnivelindex','=','niveles.id')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->join('status','libros.idstatu','=','status.id')
            ->select('libros.id as idlibros','libros.codigo','libros.archivo','libros.condicion','libros.titulo',
            'libros.fechaOrden','libros.fechaCulminacion','niveles.nombre as nombreindex','status.nombre as nombrestatus',
            'editoriales.nombre as nombreeditoriales','asesors.nombres as nombreasesores','status.nombre')
          //  ->where('libros.codigo','!=','00000001')
            ->orwhere('libros.titulo','LIKE','%'.$sql.'%')
            ->orwhere('libros.codigo','LIKE','%'.$sql.'%')
            ->orwhere('asesors.nombres','LIKE','%'.$sql.'%')
            ->orwhere('status.nombre','LIKE','%'.$sql.'%')
            ->orwhere('editoriales.nombre','LIKE','%'.$sql.'%')
            ->orderBy('libros.id','desc')
            ->paginate(6); 
     
            $contar=DB::table('libros')
            ->join('editoriales','libros.ideditorial','=','editoriales.id')
            ->join('niveles','editoriales.idnivelindex','=','niveles.id')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->join('status','libros.idstatu','=','status.id')
            ->select('libros.id as idlibros','libros.codigo','libros.condicion','libros.titulo',
            'libros.fechaOrden','libros.fechaCulminacion','niveles.nombre as nombreindex','status.nombre as nombrestatus',
            'editoriales.nombre as nombreeditoriales','asesors.nombres as nombreasesores','status.nombre')
            ->orwhere('libros.titulo','LIKE','%'.$sql.'%')
            ->orwhere('libros.codigo','LIKE','%'.$sql.'%')
            ->orwhere('asesors.nombres','LIKE','%'.$sql.'%')
            ->orwhere('status.nombre','LIKE','%'.$sql.'%')
            ->get();
            
            return view('investigacion.index',["libros"=>$libros,"data"=>$data,"contar"=>$contar,"buscarTexto"=>$sql]);
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
      //  dd($id);


        $libros=DB::table('libros')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('areas','libros.idarea','=','areas.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->join('niveleslibros','libros.idnivelibros','=','niveleslibros.id')
        ->join('tipolibros','libros.idtipolibros','=','tipolibros.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('ordentrabajo','libros.codigo','=','ordentrabajo.codigo')
        ->join('revisiones','ordentrabajo.idrevision','=','revisiones.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->select('libros.id as idlibros','libros.codigo','libros.titulo','areas.nombre as nombrearea','clasificaciones.nombre as nombreclasificacion',
        'tipolibros.nombre as nombretipos','niveleslibros.nombre as nombreniveles','editoriales.nombre as nombreeditoriales','asesors.nombres as nombresasesor',
        'libros.fechaOrden','libros.fechaLlegada','libros.fechaAsignacion','libros.idstatu','libros.archivo',
        'libros.fechaCulminacion','libros.fechaEnvioPro','libros.fechaHabilitacion','libros.fechaAjustes','libros.fechaRevisionInterna',
        'libros.fechaEnvio','libros.fechaAceptacion','libros.fechaRechazo','libros.fechaIniCorre','libros.fechaFinCorre','libros.fechaAprobacion','status.nombre as nombrestatus',
        'libros.carta','modalidades.nombre as nombresmodalidades','libros.usuario','libros.contrasenna',
        'libros.pais','libros.observacion','revisiones.contrato_id',
        'editoriales.id as ideditoriales')
        ->where('libros.codigo','=',$id)
        ->first(); 
      //   dd($libros);
     //   dd($libros->nombresmodalidades);
         $detalles=DB::table('libros')
        ->leftjoin('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->leftjoin('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->leftjoin('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->select('libros.codigo','clientes.especialidad','clientes.id as idcliente','clientes.idgrado as nombregrados','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.universidad'
        ,'clientes.correocontacto','clientes.telefono','clientes.orcid','clientes.correogmail','clientes.contrasena')
        ->where('libros.codigo','=',$id)
        ->get();
        //dd($detalles); 


        $correosviejos=DB::table('libros')
        ->join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->join('correoslibros', 'clientes.id', '=', 'correoslibros.idcliente')
        ->select('libros.codigo','clientes.especialidad','clientes.id as idcliente','clientes.idgrado as nombregrados','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.universidad'
        ,'clientes.correocontacto','clientes.telefono','clientes.orcid','clientes.correogmail','clientes.contrasena','correoslibros.correo','correoslibros.contrasena','correoslibros.celularrelacionado','correoslibros.id as idcorreoslibros')
        ->where('libros.codigo','=',$id)
        ->where('correoslibros.codigolib','=','00000001')
        ->get(); 
   
        
        $correoscreados=DB::table('libros')
        ->join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->join('correoslibros', 'clientes.id', '=', 'correoslibros.idcliente')
         ->select('libros.codigo','clientes.especialidad','clientes.id as idcliente','clientes.nombres','clientes.apellidos','correoslibros.id as idcorreoslibros'
        ,'correoslibros.correo','correoslibros.contrasena','correoslibros.firma','correoslibros.celularrelacionado','correoslibros.id as idcorreoslibros','correoslibros.codigolib')
        ->where('correoslibros.codigolib','=',$id)
      //->orwhere('libros.codigo','=',$id)
        ->groupBy('correoslibros.codigolib','correoslibros.id')
        ->get(); 
        
        return view('investigacion.show',['libros' => $libros,
        'correoscreados' => $correoscreados,
        'correosviejos' => $correosviejos,
        "detalles"=>$detalles]);
    }

    public function download($id){
 
        $dl = Libro::find($id);
        return response()->download(storage_path("app/public/libros/".$dl->archivo));

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
        
        $usuario = auth()->user()->id;
        //dd($usuario);
        $libros= Libro::findOrFail($id);
        
        //Listado de libros

        $listalibros=DB::table('libros')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('areas','libros.idarea','=','areas.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->join('niveleslibros','libros.idnivelibros','=','niveleslibros.id')
        ->join('tipolibros','libros.idtipolibros','=','tipolibros.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->select('libros.id as idlibros','libros.codigo','libros.titulo','areas.nombre as nombrearea', 'areas.id as idareas',
       'tipolibros.nombre as nombretipos','tipolibros.id as idtipos','niveleslibros.id as idniveles','niveleslibros.nombre as nombreniveles','editoriales.nombre as nombreeditoriales','editoriales.id as ideditoriales','asesors.nombres as nombresasesor',
        'asesors.id as idsasesor','libros.fechaOrden','libros.fechaLlegada','libros.fechaAsignacion',
        'libros.fechaCulminacion','libros.fechaEnvioPro','libros.fechaHabilitacion','libros.fechaIniCorre','libros.fechaFinCorre',
        'libros.fechaEnvio','libros.fechaAceptacion','libros.step','libros.fechaAnalisis','libros.fechaAprobacion','libros.fechaAjustes','libros.fechaRevisionInterna','libros.fechaRechazo','status.nombre as nombrestatus','status.id as idstatus','clasificaciones.nombre as nombreclasificaciones','clasificaciones.id as idclasificacion',
        'libros.carta','modalidades.nombre as nombresmodalidades','modalidades.id as idmodalidades','libros.usuario','libros.contrasenna',
        'libros.pais','libros.observacion',
        'editoriales.id as ideditoriales')
        ->where('libros.id','=',$id)
        ->first();

        $detalles=DB::table('libros')
        ->leftjoin('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->leftjoin('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->leftjoin('clientes', 'orden_autores.idcliente', '=', 'clientes.id')
        ->select('libros.codigo','clientes.especialidad','clientes.idgrado as nombregrados','clientes.nombres','clientes.apellidos','clientes.num_documento','clientes.universidad'
        ,'clientes.correocontacto','clientes.telefono','clientes.orcid','clientes.correogmail','clientes.contrasena')
        ->where('libros.id','=',$id)
        ->get();

                $step = $listalibros->step;
                $status_articulo = $listalibros->idstatus;
                $actividades_articulo = $listalibros->idclasificacion;

                //Cuando el libro es nuevo aun no se ha enviado el Libro a Editorial
                if($step == 0){
                    
                    if($status_articulo == 12 && $actividades_articulo == 2 ){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[2,1])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 1){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[2])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 2){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[3])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }
                      

                       if ($status_articulo == 3){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[4])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 4){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[5])
                        ->orderby('nombre','asc','id')
                        ->get();
                        }

                        if ($status_articulo == 5){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[6])
                            ->orderby('nombre','asc','id')
                            ->get();
                            }

                        if ($status_articulo == 6){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[7])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }
                        
                           if ($status_articulo == 7){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[8])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }

                           if ($status_articulo == 8){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[9])
                            ->orderby('nombre','asc','id')
                             ->get();
                           }
                       
                       $clasificaciones=DB::table('clasificaciones')
                       ->select('id','nombre')
                       ->where('id','=','2')
                       ->where('condicion','=','1')
                       ->get();

                }
                //En este caso aparece todas las opciones de Clasificaciones - No asignados
                if($step == 1){
                   
                    if ($status_articulo == 9){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[10,11,12])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }
                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[4,2,5])
                    ->where('condicion','=','1')
                    ->get();
                }
                //Para casos de redireccionamiento
                if($step ==2){
                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[4])
                    ->where('condicion','=','1')
                    ->get();

                    if($status_articulo == 12){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[2])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 2){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[3])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 3){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[6])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 6){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[7])
                        ->orderby('nombre','asc','id')
                        ->get();
                        }

                        if ($status_articulo == 7){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[8])
                            ->orderby('nombre','asc','id')
                            ->get();
                            }

                        if ($status_articulo == 8){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[9])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }
                           if($status_articulo == 9 && $actividades_articulo == 4 ){
                            $clasificaciones=DB::table('clasificaciones')
                            ->select('id','nombre')
                            ->whereIn('id',[4,5])
                            ->where('condicion','=','1')
                            ->get();
                           }
                           
                        
                           if ($status_articulo == 9){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[10,11,12])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }
                         
                          
                }

                if($step ==3){

                    if ($status_articulo == 12){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[2])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }

                       if ($status_articulo == 2){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[3])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }

                       if ($status_articulo == 3){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[6])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }

                       if ($status_articulo == 6){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[7])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }
                       if ($status_articulo == 7){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[8])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }
                       if ($status_articulo == 8){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[9])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }
                       if ($status_articulo == 9){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[10,11,12])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }

                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[5])
                    ->where('condicion','=','1')
                    ->get();


                }
                if ($step == 4){

                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[5,3])
                    ->where('condicion','=','1')
                    ->get();

                    if($status_articulo == 10 && $actividades_articulo == 5 ){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[2])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 2){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[3])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 3){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[8])
                        ->orderby('nombre','asc','id')
                        ->get();
                        }

                        if ($status_articulo == 8){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[9])
                            ->orderby('nombre','asc','id')
                            ->get();
                            }

                        if ($status_articulo == 9){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[11])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }


                }
                if($step == 5){
                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[3])
                    ->where('condicion','=','1')
                    ->get();
                    if ($status_articulo == 11){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[11])
                        ->orderby('nombre','asc','id')
                        ->get();
                       }
                }
                if($step == 6){
                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[5])
                    ->where('condicion','=','1')
                    ->get();
                    if($status_articulo == 10 && $actividades_articulo == 2 ){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[2])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 2){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[3])
                        ->orderby('nombre','desc','id')
                        ->get();
                       }

                       if ($status_articulo == 3){
                        $status=DB::table('status')
                        ->select('id','nombre')
                        ->where('condicion','=','1')
                        ->whereIn('id',[8])
                        ->orderby('nombre','asc','id')
                        ->get();
                        }

                        if ($status_articulo == 8){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[9])
                            ->orderby('nombre','asc','id')
                            ->get();
                            }

                        if ($status_articulo == 9){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[11])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }
                }
                if($step == 7){
                    $clasificaciones=DB::table('clasificaciones')
                    ->select('id','nombre')
                    ->whereIn('id',[3])
                    ->where('condicion','=','1')
                    ->get();
                        if ($status_articulo == 11){
                            $status=DB::table('status')
                            ->select('id','nombre')
                            ->where('condicion','=','1')
                            ->whereIn('id',[11])
                            ->orderby('nombre','asc','id')
                            ->get();
                           }
                        } 
                        
                        if($step == 8){
                           
                                if ($status_articulo == 10){
                                    $status=DB::table('status')
                                    ->select('id','nombre')
                                    ->where('condicion','=','1')
                                    ->whereIn('id',[2])
                                    ->orderby('nombre','asc','id')
                                    ->get();
                                   }
                                   if ($status_articulo == 2){
                                    $status=DB::table('status')
                                    ->select('id','nombre')
                                    ->where('condicion','=','1')
                                    ->whereIn('id',[3])
                                    ->orderby('nombre','asc','id')
                                    ->get();
                                   }
                                   if ($status_articulo == 3){
                                    $status=DB::table('status')
                                    ->select('id','nombre')
                                    ->where('condicion','=','1')
                                    ->whereIn('id',[8])
                                    ->orderby('nombre','asc','id')
                                    ->get();
                                   }
                                   if ($status_articulo == 8){
                                    $status=DB::table('status')
                                    ->select('id','nombre')
                                    ->where('condicion','=','1')
                                    ->whereIn('id',[9])
                                    ->orderby('nombre','asc','id')
                                    ->get();
                                   }
                                   if ($status_articulo == 9){
                                    $status=DB::table('status')
                                    ->select('id','nombre')
                                    ->where('condicion','=','1')
                                    ->whereIn('id',[11,12])
                                    ->orderby('nombre','asc','id')
                                    ->get();
                                   }
                                   $clasificaciones=DB::table('clasificaciones')
                                   ->select('id','nombre')
                                   ->whereIn('id',[5,4])
                                   ->where('condicion','=','1')
                                   ->get();
                                }
                                if($step == 9){
                           
                                    if ($status_articulo == 12){
                                        $status=DB::table('status')
                                        ->select('id','nombre')
                                        ->where('condicion','=','1')
                                        ->whereIn('id',[2])
                                        ->orderby('nombre','asc','id')
                                        ->get();
                                       }
                                       if ($status_articulo == 2){
                                        $status=DB::table('status')
                                        ->select('id','nombre')
                                        ->where('condicion','=','1')
                                        ->whereIn('id',[3])
                                        ->orderby('nombre','asc','id')
                                        ->get();
                                       }
                                       if ($status_articulo == 3){
                                        $status=DB::table('status')
                                        ->select('id','nombre')
                                        ->where('condicion','=','1')
                                        ->whereIn('id',[8])
                                        ->orderby('nombre','asc','id')
                                        ->get();
                                       }
                                       if ($status_articulo == 8){
                                        $status=DB::table('status')
                                        ->select('id','nombre')
                                        ->where('condicion','=','1')
                                        ->whereIn('id',[9])
                                        ->orderby('nombre','asc','id')
                                        ->get();
                                       }
                                       if ($status_articulo == 9){
                                        $status=DB::table('status')
                                        ->select('id','nombre')
                                        ->where('condicion','=','1')
                                        ->whereIn('id',[11,12])
                                        ->orderby('nombre','asc','id')
                                        ->get();
                                       }
                                       $clasificaciones=DB::table('clasificaciones')
                                        ->select('id','nombre')
                                        ->whereIn('id',[5,4])
                                        ->where('condicion','=','1')
                                        ->get();
                                    }
                                    if($step == 10){
                           
                                        if ($status_articulo == 11){
                                            $status=DB::table('status')
                                            ->select('id','nombre')
                                            ->where('condicion','=','1')
                                            ->whereIn('id',[11])
                                            ->orderby('nombre','asc','id')
                                            ->get();
                                           }
                                           $clasificaciones=DB::table('clasificaciones')
                                            ->select('id','nombre')
                                            ->whereIn('id',[3])
                                            ->where('condicion','=','1')
                                            ->get();
                                        }

                

                //Listar Áreas

               $areas=DB::table('areas')
               ->select(DB::raw('CONCAT(areas.codigo," ",areas.nombre) AS nombresareas'),'areas.id')
               ->where('areas.condicion','=','1')
               ->get(); 
       
               //Listar Nivel tipo libros
       
               $tipolibros=DB::table('tipolibros')
               ->select('id','nombre')
               ->where('condicion','=','1')
               ->get();
       
               //Listar Niveles Artículos
       
               $niveleslibros=DB::table('niveleslibros')
               ->select('id','nombre')
               ->where('condicion','=','1')
               ->get();
               
               //Listar editoriales
       
               $editoriales=DB::table('editoriales')
               ->select(DB::raw('CONCAT(editoriales.codigo," ",editoriales.nombre) AS nombreseditoriales'),'editoriales.id')
               ->where('editoriales.condicion','=','1')
               ->get(); 
               
       
               //Listar Asesores
               

                if($usuario == 46 || $usuario == 57 || $usuario == 48  || $usuario == 59){
/*                     dd($usuario);
 */                   $asesores=DB::table('asesors')
                    ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'),'asesors.id','asesors.idusuario')
                    ->where('asesors.idusuario','=',$usuario)
                   // ->where('asesors.condicion','=','1')
                    ->get(); 
               
               if($usuario == 48){
                $asesores=DB::table('asesors')
                ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'),'asesors.id','asesors.idusuario')
                ->where('asesors.idusuario','=',13)
               // ->where('asesors.condicion','=','1')
                ->get(); 
               }
                }else{

                    $asesores=DB::table('asesors')
                    ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'),'asesors.id')
                    ->where('asesors.condicion','=','1')
                    ->get(); 

                }
                
      
               $modalidades=DB::table('modalidades')
               ->select('id','nombre')
               ->where('condicion','=','1')
               ->get();
       
               $autores=DB::table('autores')
               ->select(DB::raw('CONCAT(autores.nombres," ",autores.apellidos) AS autores'),'autores.id','autores.nombres','autores.apellidos','autores.num_documento')
               ->where('autores.condicion','=','1')
               ->get(); 
                
               
               return view('investigacion.edit',["areas"=>$areas,
               "clasificaciones"=>$clasificaciones,
               "tipolibros"=>$tipolibros,
               "niveleslibros"=>$niveleslibros,
               "editoriales"=>$editoriales,
               "asesores"=>$asesores,
               "autores"=>$autores,
               "status"=>$status,
               "modalidades"=>$modalidades,
               "libros"=>$libros,
               "listalibros"=>$listalibros,
               "usuario"=>$usuario,
               "detalles"=>$detalles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $usuario = auth()->user()->id;
        $articulo= Libro::findOrFail($request->id);
        $articulo->codigo = $request->codigo;
        $articulo->titulo = $request->titulo;
        $articulo->idarea = $request->area;
        $articulo->idtipolibros = $request->tipo_articulo;
        $articulo->idnivelibros = $request->nivel_articulo;
        $articulo->idasesor = $request->asesor;
        $articulo->usuario = $request->usuario;
        $articulo->fechaOrden = $request->fechaorden;
        $articulo->fechaLlegada = $request->fechallegada;
        $articulo->fechaAsignacion = $request->fechaasignacion;
        $articulo->fechaCulminacion = $request->fechaculminacion;
        $articulo->fechaRevisionInterna = $request->fecharevisioninterna;
        $articulo->fechaEnvioPro = $request->fechaenviopro;
        $articulo->fechaHabilitacion = $request->fechahabilitacion;
        $articulo->fechaaprobacion = $request->fechaaprobacion;
        $articulo->fechaEnvio = $request->fechaenvio;
        $articulo->fechaAjustes = $request->fechaajustes;
        $articulo->fechaIniCorre = $request->fechainicorre;
        $articulo->fechaFinCorre = $request->fechafincorre;
        $articulo->fechaAceptacion = $request->fechaaceptacion;
        $articulo->fechaRechazo = $request->fecharechazo;
        $articulo->idstatu = $request->statu;
        $articulo->ideditorial = $request->editorial;
        $articulo->carta = $request->carta;
        $articulo->idmodalidad = $request->modalidad;
        
        $articulo->contrasenna = $request->contrasenna;
        $articulo->pais = $request->pais;
        if($request->hasFile('archivo')){
            /*si la imagen que subes es distinta a la que está por defecto 
            entonces eliminaría la imagen anterior, eso es para evitar 
            acumular imagenes en el servidor*/ 
        if($articulo->archivo != 'noimagen.jpg'){ 
            Storage::delete('public/libros'.$articulo->archivo);
        }
            //Get filename with the extension
        $filenamewithExt = $request->file('archivo')->getClientOriginalName();
        
        //Get just filename
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        
        //Get just ext
        $extension = $request->file('archivo')->getClientOriginalExtension();
        
        //FileName to store
        $fileNameToStore = time().'.'.$extension;
        
        //Upload Image
        $path = $request->file('archivo')->storeAs('public/libros',$fileNameToStore);
               
    } else {
        
        $fileNameToStore = $articulo->archivo; 
    }

       $articulo->archivo=$fileNameToStore;

        $articulo->observacion = $request->observacion;
        $articulo->idclasificacion = $request->clasificacion;
        $articulo->condicion = '1';

        if($request->statu == 9 && $request->clasificacion == 2 ){
            $articulo->step = 1;
        }

         if($request->statu == 12 && $request->clasificacion == 4 ){
            $articulo->step = 2;
            $articulo->ideditorial = 1;
            $articulo->fechaAsignacion = NULL;
            $articulo->fechaCulminacion = NULL;
            $articulo->fechaRevisionInterna =NULL;
            $articulo->fechaIniCorre =NULL;
            $articulo->fechaFinCorre =NULL;
            $articulo->fechaEnvioPro = NULL;
            $articulo->fechaEnvio = NULL;

        } 

    

        if($request->statu == 10 && $request->clasificacion == 5 ){
            $articulo->step = 4;
            $articulo->fechaAsignacion = NULL;
            $articulo->fechaCulminacion = NULL;
            $articulo->fechaRevisionInterna =NULL;
            $articulo->fechaIniCorre =NULL;
            $articulo->fechaFinCorre =NULL;
            $articulo->fechaEnvioPro = NULL;
            $articulo->fechaEnvio = NULL;

        } 

     if($request->statu == 11 && $request->clasificacion == 5){
        $articulo->step = 5;
     }

     if($request->statu == 10 && $request->clasificacion == 2){
         $articulo->step = 6;

     }
     if($request->statu == 11 && $request->clasificacion == 2){
        $articulo->step = 7;

    }
    if($request->statu == 10 && $request->clasificacion == 5){
        $articulo->step = 8;
        $articulo->fechaAsignacion = NULL;
        $articulo->fechaCulminacion = NULL;
        $articulo->fechaRevisionInterna =NULL;
        $articulo->fechaEnvio = NULL;

    }
    if($request->statu == 12 && $request->clasificacion == 5){
        $articulo->step = 9;
        $articulo->fechaAsignacion = NULL;
        $articulo->fechaCulminacion = NULL;
        $articulo->fechaRevisionInterna =NULL;
        $articulo->fechaEnvio = NULL;
    }
    if($request->statu == 11 && $request->clasificacion == 4){
        $articulo->step = 10;
        
    }
        
        $articulo->save();
        
        if($request->statusselect == 12 && $request->statu == 12 ){
        return Redirect::to("librosinvestigacion/$articulo->codigo"); 

        }else
        {
         // AFTER UPDATE ON `articulos INSERT INTO table "historiales"
         $attributes = $request->all();
         $data = array('id'=>NULL,'idlibros' =>$request->id,
         'idasesor' =>$request->asesor,
         'idusuario' =>$request->idusuario,
         'idclasificacion'=>$request->clasificacion,
         'titulo'=>$request->titulo,
         'fechaOrden'=>$request->fechaorden,
         'fechaLlegada'=>$request->fechallegada,
         'fechaAsignacion'=>$request->fechaasignacion,
         'fechaCulminacion'=>$request->fechaculminacion,
         'fechaRevisionInterna'=>$request->fecharevisioninterna,
         'fechaEnvioPro'=>$request->fechaenviopro,
         'fechaHabilitacion'=>$request->fechahabilitacion,
         'fechaEnvio'=>$request->fechaenvio,
         'fechaAjustes'=>$request->fechaajustes,
         'fechaAceptacion'=>$request->fechaaceptacion,
         'fechaAprobacion'=>$request->fechaaprobacion,
         'fechaRechazo'=>$request->fecharechazo,
         'idstatu'=>$request->statu,
         'ideditoriales'=>$request->editorial,
         'usuario'=>$request->usuario,
         'contrasenna'=>$request->contrasenna,
         'archivo'=>$fileNameToStore,
         'fechaAdministrativo'=>$request->fechaadministrativos, 
         
         );

       //  dd($data);


         $data_merge = array_merge($attributes, $data);
         Historial::create($data_merge);
         return Redirect::to("librosinvestigacion/$articulo->codigo");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $libros= Libro::findOrFail($request->id_libros);
         
         if($libros->condicion=="1"){

                $libros->condicion= '0';
                $libros->save();
                return Redirect::to("librosinvestigacion");

           }else{

                $libros->condicion= '1';
                $libros->save();
                return Redirect::to("librosinvestigacion");

            }
    }
}
