<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Historial;
use App\Libro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $sql=trim($request->get('buscarTexto'));
        $status=DB::table('status')
        ->select('id','nombre')
        ->where('condicion','=','1')
        ->orderby('nombre','asc')
        ->get();

        $clasificaciones=DB::table('clasificaciones')
        ->select('id','nombre')
        ->where('condicion','=','1')
        ->get();

        $editoriales=DB::table('editoriales')
        ->select(DB::raw('CONCAT(editoriales.codigo," ",editoriales.nombre) AS nombreseditoriales'),'editoriales.id')
        ->where('editoriales.condicion','=','1')
        ->get();
        

        if(!empty($sql)){
            $historiales=DB::table('historiales')
            ->join('libros','historiales.idlibros','=','libros.id')
            ->join('asesors','historiales.idasesor','=','asesors.id')
            ->join('status','historiales.idstatu','=','status.id')
            ->join('editoriales','historiales.ideditoriales','=','editoriales.id')
            ->join('clasificaciones','historiales.idclasificacion','=','clasificaciones.id')
            ->select('libros.codigo', 'historiales.id','clasificaciones.id as idclasificacion','clasificaciones.nombre as nombreclasificaciones',
            'historiales.fechaOrden','historiales.titulo','historiales.Checkno','historiales.id', 'historiales.idlibros','historiales.archivo','historiales.fechaLlegada','historiales.fechaAsignacion','historiales.fechaAjustes','historiales.fechaAprobacion','historiales.usuario','historiales.contrasenna','historiales.ideditoriales','editoriales.nombre as nombrerevista','historiales.fechaCulminacion','historiales.fechaEnvioPro','historiales.fechaRevisionInterna','historiales.fechaHabilitacion','historiales.fechaEnvio','historiales.fechaAceptacion','historiales.fechaRechazo','status.nombre as nombrestatus',
           'asesors.nombres as nombreasesores', 'asesors.id as idasesor','historiales.created_at','status.id as idstatu')
            ->where('libros.codigo',$sql)
            ->orderBy('historiales.created_at','asc')
            ->get();
            $asesores=DB::table('asesors')
            ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'),'asesors.id')
            ->where('asesors.condicion','=','1')
            ->get(); 
            
            
            return view('historial.index',["historiales"=>$historiales,"clasificaciones"=>$clasificaciones,"status"=>$status,"editoriales"=>$editoriales,"asesores"=>$asesores,"buscarTexto"=>$sql]);

            }else{
            
            $asesores=DB::table('asesors')
            ->select(DB::raw('CONCAT(asesors.num_documento," ",asesors.nombres) AS nombresasesor'),'asesors.id')
            ->where('asesors.condicion','=','1')
            ->get(); 

            $historiales=DB::table('historiales')
            ->join('libros','historiales.idlibros','=','libros.id')
            ->join('asesors','historiales.idasesor','=','asesors.id')
            ->join('status','historiales.idstatu','=','status.id')
            ->join('editoriales','historiales.ideditoriales','=','editoriales.id')
            ->join('clasificaciones','historiales.idclasificacion','=','clasificaciones.id')
            ->select('libros.codigo', 'historiales.id','clasificaciones.id as idclasificacion','clasificaciones.nombre as nombreclasificaciones',
            'historiales.fechaOrden','historiales.titulo','historiales.id', 'historiales.idlibros','historiales.archivo','historiales.fechaLlegada','historiales.fechaAsignacion','historiales.fechaAjustes','historiales.usuario','historiales.contrasenna','historiales.ideditoriales','editoriales.nombre as nombrerevista','historiales.fechaCulminacion','historiales.fechaEnvioPro','historiales.fechaRevisionInterna','historiales.fechaHabilitacion','historiales.fechaEnvio','historiales.fechaAceptacion','historiales.fechaRechazo','status.nombre as nombrestatus',
           'asesors.nombres as nombreasesores','historiales.fechaAprobacion','historiales.Checkno','asesors.id as idasesor','historiales.created_at','status.id as idstatu')
            ->where('libros.codigo','=','null')
            ->orderBy('historiales.created_at','asc')
            ->get();

            return view('historial.index',["historiales"=>$historiales,"clasificaciones"=>$clasificaciones,"status"=>$status,"editoriales"=>$editoriales,"asesores"=>$asesores,"buscarTexto"=>$sql]);

        }
    }

    public function resumen(Request $request)
    {
        //
                $historiales=DB::table('historiales')
                ->join('libros','historiales.idlibros','=','libros.id')
                ->join('asesors','historiales.idasesor','=','asesors.id')
                ->join('status','historiales.idstatu','=','status.id')
                ->join('editoriales','historiales.ideditoriales','=','editoriales.id')
                ->join('clasificaciones','historiales.idclasificacion','=','clasificaciones.id')
                ->select('libros.codigo', 'historiales.id','clasificaciones.id as idclasificacion','clasificaciones.nombre as nombreclasificaciones',
                'historiales.fechaOrden','historiales.titulo','historiales.id', 'historiales.idlibros','historiales.archivo','historiales.fechaLlegada','historiales.fechaAsignacion','historiales.fechaAjustes','historiales.usuario','historiales.contrasenna','historiales.ideditoriales','editoriales.nombre as nombrerevista','historiales.fechaCulminacion','historiales.fechaEnvioPro','historiales.fechaRevisionInterna','historiales.fechaHabilitacion','historiales.fechaEnvio','historiales.fechaAceptacion','historiales.fechaRechazo','status.nombre as nombrestatus',
               'asesors.nombres as nombreasesores', 'asesors.id as idasesor','historiales.created_at','status.id as idstatu')
               ->whereDate('historiales.created_at', '=', Carbon::today()->toDateString())           
               //->whereDate('created_at', Carbon::today())
                ->orderBy('historiales.created_at','asc')
                ->get();
                return view('historial.ultimosmovimientos',["historiales"=>$historiales]);

            }


    public function download($id){
 
        $dl = Historial::find($id);
        return response()->download(storage_path("app/public/libros/".$dl->archivo));

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
        $historial= Historial::findOrFail($request->id_historial);
        $historial->idlibros = $request->id_libros;
        $historial->idasesor  = $request->id_asesor;
        $historial->titulo = $request->titulo;
        $historial->fechaOrden = $request->fechaorden;
        $historial->fechaLlegada = $request->fechallegada;
        $historial->fechaAsignacion = $request->fechaasignacion;
        $historial->fechaCulminacion = $request->fechaculminacion;
        $historial->fechaRevisionInterna = $request->fecharevisioninterna;
        $historial->fechaEnvioPro = $request->fechaenvioproduccion;
        $historial->fechaHabilitacion = $request->fechahabilitacion;
        $historial->fechaEnvio = $request->fechaenvio;
        $historial->fechaAjustes = $request->fechaajustes;
        $historial->fechaAceptacion = $request->fechaaceptacion;
        $historial->fechaRechazo = $request->fecharechazo;
        $historial->idclasificacion = $request->clasificacion;
        $historial->idstatu = $request->status;
        $historial->ideditoriales = $request->editoriales;

        
        if (Input::get('terms') == 1)
        {
            $historial->CheckNo = 1;
        }else{
            $historial->CheckNo = 0;

        }   

        /*dd($historial->CheckNo);*/

        $historial->save();
        return Redirect::back();
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
        $historial = Historial::findOrFail($request->historial_id);
        $historial->delete();
        return back();  
    }
}
