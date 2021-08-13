<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\DetallesArticulos;
use App\Libro;

use App\Exports\AutoresExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;
use App;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $obj=DB::table('clientes')
            ->join('grados','clientes.idgrado','=','grados.id')
            ->select('clientes.id','clientes.tipo_documento','clientes.num_documento',
            'clientes.nombres','clientes.apellidos','clientes.correocontacto',(DB::raw("CONCAT('clientes.nombres','','clientes.apellidos') AS algo")),
            'clientes.telefono','clientes.correogmail','clientes.autor','clientes.contrasena','clientes.resumen','clientes.universidad','clientes.orcid',
            'grados.nombre as nombregrado', 'clientes.condicion', 'clientes.idgrado','clientes.especialidad')
            ->whereIn('clientes.condicion',array('1','0'))
            ->whereIn('clientes.autor',array('1'))
            ->orderBy('clientes.id','desc');
            $data = $request->all();
            // FILTROS
            if ($request) {
            $sql=trim($request->get('buscarTexto'));
                $obj = $obj->where(function ($query) use ($sql) {
                    $query->orwhere('clientes.num_documento','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.nombres','LIKE','%'.$sql.'%');
                    $query->orwhere('clientes.apellidos','LIKE','%'.$sql.'%');
                    $query->orWhereRaw("concat(clientes.nombres, ' ', clientes.apellidos) like '%$sql%' ");
                });

            //COUNT
            $count = $obj->get();
            $count->count();
        
            //PAGINATE
            $clientes= $obj->paginate(15);

             /*listar los Grados en ventana modal*/
            $grados=DB::table('grados')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get(); 
            return view('autor.index',["clientes"=>$clientes,"grados"=>$grados,"buscarTexto"=>$sql,"count"=>$count,"data"=>$data,]);
        
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
        $autores= Cliente::findOrFail($id);
        $detalles = Libro::join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'orden_autores.idcliente', '=', 'autores.id')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('niveles','editoriales.idnivelindex','=','niveles.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->select('orden_autores.id as idclientes','autores.especialidad','clasificaciones.nombre as nombreclasificacion','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','status.nombre as nombrestatus', 'niveles.nombre as nombreindex','editoriales.nombre as nombreeditoriales','editoriales.pais as revistapais','asesors.nombres as asesoresnombres','autores.telefono','autores.orcid','autores.correogmail'
        ,'autores.contrasena','libros.id as idlibros','libros.idstatu','libros.fechaLlegada','libros.titulo','libros.codigo','libros.fechaOrden','libros.fechaLlegada','libros.idclasificacion'
        ,'libros.fechaEnvio','libros.fechaCulminacion','orden_autores.idcliente as idclientespru')
        ->where('orden_autores.idcliente','=',$id)
        ->where('libros.condicion','=','1')
        ->orderBy('libros.fechaOrden', 'asc')
        ->get();

        $listautores=DB::table('libros')
        ->leftjoin('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->leftjoin('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->leftjoin('autores', 'orden_autores.idcliente', '=', 'autores.id')
        ->select('libros.codigo','autores.especialidad','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','autores.telefono','autores.orcid','autores.correogmail','autores.contrasena')
        ->get();

        $obj=DB::table('clientes')
        ->join('grados','clientes.idgrado','=','grados.id')
        ->select('clientes.id','clientes.tipo_documento','clientes.num_documento',
        'clientes.nombres','clientes.apellidos','clientes.correocontacto',(DB::raw("CONCAT('clientes.nombres','','clientes.apellidos') AS algo")),
        'clientes.telefono','clientes.correogmail','clientes.contrasena','clientes.resumen','clientes.universidad','clientes.orcid',
        'grados.nombre as nombregrado', 'clientes.condicion', 'clientes.idgrado','clientes.especialidad')
        ->where('clientes.id', $id)
        ->get();

        $enviado = Libro::join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'orden_autores.idcliente', '=', 'autores.id')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('niveles','editoriales.idnivelindex','=','niveles.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->select('orden_autores.id as idclientes','autores.especialidad','clasificaciones.nombre as nombreclasificacion','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','status.nombre as nombrestatus', 'niveles.nombre as nombreindex','editoriales.nombre as nombreeditoriales','asesors.nombres as asesoresnombres','autores.telefono','autores.orcid','autores.correogmail'
        ,'autores.contrasena','libros.id as idlibros','libros.idstatu','libros.fechaLlegada','libros.titulo','libros.codigo','libros.fechaOrden','libros.fechaLlegada','libros.idclasificacion'
        ,'libros.fechaEnvio','libros.fechaCulminacion','orden_autores.idcliente as idclientespru')
        ->where('orden_autores.idcliente','=',$id)
        ->where('libros.idstatu','=','1')
        ->where('libros.condicion','=','1')
        ->orderBy('libros.fechaOrden', 'asc')
        ->get();

        $porredi = Libro::join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'orden_autores.idcliente', '=', 'autores.id')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('niveles','editoriales.idnivelindex','=','niveles.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->select('orden_autores.id as idclientes','autores.especialidad','clasificaciones.nombre as nombreclasificacion','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','status.nombre as nombrestatus', 'niveles.nombre as nombreindex','editoriales.nombre as nombreeditoriales','asesors.nombres as asesoresnombres','autores.telefono','autores.orcid','autores.correogmail'
        ,'autores.contrasena','libros.id as idlibros','libros.idstatu','libros.fechaLlegada','libros.titulo','libros.codigo','libros.fechaOrden','libros.fechaLlegada','libros.idclasificacion'
        ,'libros.fechaEnvio','libros.fechaCulminacion','orden_autores.idcliente as idclientespru')
        ->where('orden_autores.idcliente','=',$id)
        ->where('libros.idstatu','=','3')
        ->where('libros.condicion','=','1')
        ->orderBy('libros.fechaOrden', 'asc')
        ->get();

        $aceptado = Libro::join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'orden_autores.idcliente', '=', 'autores.id')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('niveles','editoriales.idnivelindex','=','niveles.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->select('orden_autores.id as idclientes','autores.especialidad','clasificaciones.nombre as nombreclasificacion','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','status.nombre as nombrestatus', 'niveles.nombre as nombreindex','editoriales.nombre as nombreeditoriales','asesors.nombres as asesoresnombres','autores.telefono','autores.orcid','autores.correogmail'
        ,'autores.contrasena','libros.id as idlibros','libros.idstatu','libros.fechaLlegada','libros.titulo','libros.codigo','libros.fechaOrden','libros.fechaLlegada','libros.idclasificacion'
        ,'libros.fechaEnvio','libros.fechaCulminacion','orden_autores.idcliente as idclientespru')
        ->where('orden_autores.idcliente','=',$id)
        ->where('libros.idstatu','=','4')
        ->where('libros.condicion','=','1')
        ->orderBy('libros.fechaOrden', 'asc')
        ->get();

        $publicado = Libro::join('ordentrabajo', 'libros.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'orden_autores.idcliente', '=', 'autores.id')
        ->join('editoriales','libros.ideditorial','=','editoriales.id')
        ->join('niveles','editoriales.idnivelindex','=','niveles.id')
        ->join('asesors','libros.idasesor','=','asesors.id')
        ->join('status','libros.idstatu','=','status.id')
        ->join('modalidades','libros.idmodalidad','=','modalidades.id')
        ->join('clasificaciones','libros.idclasificacion','=','clasificaciones.id')
        ->select('orden_autores.id as idclientes','autores.especialidad','clasificaciones.nombre as nombreclasificacion','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','status.nombre as nombrestatus', 'niveles.nombre as nombreindex','editoriales.nombre as nombreeditoriales','asesors.nombres as asesoresnombres','autores.telefono','autores.orcid','autores.correogmail'
        ,'autores.contrasena','libros.id as idlibros','libros.idstatu','libros.fechaLlegada','libros.titulo','libros.codigo','libros.fechaOrden','libros.fechaLlegada','libros.idclasificacion'
        ,'libros.fechaEnvio','libros.fechaCulminacion','orden_autores.idcliente as idclientespru')
        ->where('orden_autores.idcliente','=',$id)
        ->where('libros.idstatu','=','5')
        ->where('libros.condicion','=','1')
        ->orderBy('libros.fechaOrden', 'asc')
        ->get();
        
        return view('autor.show',['detalles' => $detalles,'autores' => $autores,'enviado' => $enviado,'porredi' => $porredi,
        'aceptado' => $aceptado,
        'obj' => $obj,
        'listautores' => $listautores,
        'id' => $id,
        'publicado' => $publicado]);


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
    public function destroy(Request $request)
    {
        //
        $autor= Cliente::findOrFail($request->id);
         
         if($autor->condicion=="1"){

                $autor->condicion= '0';
                $autor->save();
                return Redirect::to("autor");

           }else{

                $autor->condicion= '1';
                $autor->save();
                return Redirect::to("autor");

            }
    }

    public function exportarExcelAutores($id){
        
        $autores= cliente::findOrFail($id);
        $detalles = libro::join('ordentrabajo', 'articulos.codigo', '=', 'ordentrabajo.codigo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'orden_autores.idautor', '=', 'autores.id')
        ->join('revistas','articulos.idrevista','=','revistas.id')
        ->join('niveles','revistas.idnivelindex','=','niveles.id')
        ->join('asesors','articulos.idasesor','=','asesors.id')
        ->join('status','articulos.idstatu','=','status.id')
        ->join('modalidades','articulos.idmodalidad','=','modalidades.id')
        ->join('clasificaciones','articulos.idclasificacion','=','clasificaciones.id')
        ->select('orden_autores.id as idautors','autores.especialidad','clasificaciones.nombre as nombreclasificacion','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','status.nombre as nombrestatus', 'niveles.nombre as nombreindex','revistas.nombre as nombrerevistas','asesors.nombres as asesoresnombres','autores.telefono','autores.orcid','autores.correogmail'
        ,'autores.contrasena','articulos.id as idarticulos','articulos.idstatu','articulos.fechaLlegada','articulos.titulo','articulos.codigo','articulos.fechaOrden','articulos.fechaLlegada','articulos.idclasificacion'
        ,'articulos.fechaEnvio','articulos.fechaCulminacion','orden_autores.idautor as idautorespru')
        ->where('orden_autores.idautor','=',$id)
        ->where('articulos.condicion','=','1')
        ->orderBy('articulos.fechaOrden', 'asc')
        ->get();

        $listautores=DB::table('libros')
        ->leftjoin('ordentrabajo', 'articulos.codigo', '=', 'ordentrabajo.codigo')
        ->leftjoin('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->leftjoin('autores', 'orden_autores.idautor', '=', 'autores.id')
        ->select('articulos.codigo','autores.especialidad','autores.idgrado as nombregrados','autores.nombres','autores.apellidos','autores.num_documento','autores.universidad'
        ,'autores.correocontacto','autores.telefono','autores.orcid','autores.correogmail','autores.contrasena')
        ->get();

        $obj=DB::table('clientes')
        ->join('grados','autores.idgrado','=','grados.id')
        ->select('autores.id','autores.tipo_documento','autores.num_documento',
        'autores.nombres','autores.apellidos','autores.correocontacto',(DB::raw("CONCAT('autores.nombres','','autores.apellidos') AS algo")),
        'autores.telefono','autores.correogmail','autores.contrasena','autores.resumen','autores.universidad','autores.orcid',
        'grados.nombre as nombregrado', 'autores.condicion', 'autores.idgrado','autores.especialidad')
        ->where('autores.id', $id)
        ->get();

        $export = new AutoresExport($autores,$detalles,$listautores,$obj);
        return Excel::download($export, 'Autor.xlsx');
    
    }
}
