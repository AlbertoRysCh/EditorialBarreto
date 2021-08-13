<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exports\ActividadExport;
use Illuminate\Support\Facades\Input;

use App\Actividad;
use App\DetallesArticulos;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $usuario = auth()->user()->id;

        if($request){
            $sql=trim($request->get('buscarTexto'));

      //      $statu=trim($request->get('buscarStatu'));
            $actividades=DB::table('actividades')
            ->join('libros','actividades.idlibros','=','libros.id')
            ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
            ->join('users','actividades.usuario_id','=','users.id')
            ->select('actividades.id as idactividad','actividades.idlibros as idactividadeslibros','actividades.avancemañana','actividades.avancetarde','actividades.observacion',
            'actividades.created_at','libros.id as idlibros','libros.titulo','users.id as usuario_id','clasificaciones.nombre as clasificacionesnombre','users.nombre as nombreusuario')
            ->where('actividades.id','LIKE','%'.$sql.'%')
            ->where('actividades.usuario_id',$usuario)
            ->orderBy('actividades.id','desc')
            ->paginate(10);

            $libros=DB::table('libros')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->select('libros.id','asesors.usuario_id','libros.titulo')
            ->where('libros.condicion','=','1')

            ->where('asesors.usuario_id',$usuario)
            ->get(); 

            $status=DB::table('status')
            ->select('id','nombre')
            ->where('condicion','=','1')
            ->get();

        }

     //   return view('actividad.index');
        return view('actividad.index',["actividades"=>$actividades,"libros"=>$libros,"status"=>$status,"buscarTexto"=>$sql]);

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
        $actividad= new Actividad();
        $actividad->usuario_id = \Auth::user()->id;
        $actividad->idlibros = $request->id_libros;
        $actividad->avancemañana = $request->avancemañana;
        $actividad->avancetarde = $request->avancetarde;
        $actividad->observacion = $request->observacion;
        $actividad->save();
        return Redirect::to("actividad"); 
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
        $actividad= Actividad::findOrFail($request->id_actividad);
        $actividad->usuario_id = \Auth::user()->id;
        $actividad->idlibros = $request->id_libros;
        $actividad->avancemañana = $request->avancemañana;
        $actividad->avancetarde = $request->avancetarde;
        $actividad->observacion = $request->observacion;
        $actividad->save();
        return Redirect::to("actividad"); 
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

    public function resumen(Request $request)
    {
        //
        if($request){
        $fechainicio=trim($request->get('buscarFechaInicio'));
        $fechafinal=trim($request->get('buscarFechaFinal'));

        $actividades=DB::table('actividades')
        ->join('libros','actividades.idlibros','=','libros.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->join('users','actividades.usuario_id','=','users.id')

        ->select('actividades.id as idactividad','actividades.avancemañana','libros.codigo','actividades.avancetarde','actividades.observacion','users.nombre as nombreusuario',
        'actividades.created_at','libros.id as idlibros','libros.titulo','clasificaciones.nombre as clasificacionesnombre', DB::raw(' (actividades.avancemañana + actividades.avancetarde) AS suma'))
        ->whereBetween('actividades.created_at', [$fechainicio, $fechafinal])
        ->orderBy('actividades.created_at','desc')
        ->get();
        
    

        $detalles=DB::table('libros')
        ->leftjoin('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->leftjoin('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->leftjoin('autores', 'orden_autores.idautor', '=', 'autores.id')
        ->select('libros.codigo','autores.especialidad','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','autores.telefono','autores.orcid','autores.correogmail','autores.contrasena')
        ->where('libros.condicion','=','1')
        ->get();

    }
        return view('actividad.resumen',["actividades"=>$actividades,"detalles"=>$detalles,"buscarFechaInicio"=>$fechainicio,"buscarFechaFinal"=>$fechafinal]);


    }

 /*   public function exportarExcel(){

        
        return Excel::download(new ActividadExport, 'resumenproduccion.xlsx');

   }*/

   public function exportarExcel(Request $request){

 //   $StartDate  =  Input::get('buscarFechaInicio');
  //  $EndDate = Input::get('buscarFechaFinal');
  //  $StartDate = date('Y-m-d H:i:s', strtotime(strtr($request->get('buscarFechaInicio'), '/', '-')));
  //  $EndDate = date('Y-m-d H:i:s', strtotime(strtr($request->get('buscarFechaFinal'), '/', '-')));
  $StartDate=trim($request->get('buscarFechaInicio'));
  $EndDate=trim($request->get('buscarFechaFinal'));
    
    return Excel::download(new ActividadExport($StartDate,$EndDate), 'resumenproduccion.xlsx');

}
}
