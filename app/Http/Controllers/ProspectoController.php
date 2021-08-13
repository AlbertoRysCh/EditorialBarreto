<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\AsesorVenta;
use App\Aviso;
use App\Zona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SelectHelper;

class ProspectoController extends Controller
{
    const MENSAJE = 'mensajeSuccess';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($request){
            $data = $request->all();

            $obj=DB::table('clientes')
            ->join('grados','clientes.idgrado','=','grados.id')
            ->join('avisos','clientes.aviso_id','=','avisos.id')
            ->join('asesorventas','clientes.asesor_venta_id','=','asesorventas.id')
            ->join('zonas','clientes.zona_id','=','zonas.id')
            ->select('clientes.id','clientes.tipo_documento','clientes.num_documento',
            'clientes.nombres','clientes.apellidos','clientes.correocontacto',
            'clientes.telefono','clientes.correogmail','clientes.contrasena','clientes.resumen','clientes.universidad','clientes.orcid',
            'grados.nombre as nombregrado', 'clientes.condicion', 'clientes.idgrado','clientes.especialidad',
            'clientes.autor','avisos.nombre as nombre_aviso','clientes.asesor_venta_id','clientes.aviso_id',
            'asesorventas.nombres as nombre_asesor_venta','clientes.autor','clientes.codigo','zonas.descripcion as nombre_zona',
            'clientes.zona_id')
            ->orderBy('clientes.id','desc');

            //Filtros
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
            //COUNT   
            $count = $obj->get();
            $count->count();
            
            //PAGINATE
            $clientes= $obj->paginate(10);

             /*listar los Grados en ventana modal*/
            $grados=DB::table('grados')->where('condicion','=','1')->get(); 
            /*listar Asesores de Ventas*/
            $asesorVentas=AsesorVenta::select('id','nombres','num_documento')->whereCondicion(1)->get();
            $type = new SelectHelper();
            $tipoDocumentos = $type->listTypeDoc();
            $avisos= Aviso::whereEstado(1)->get();
            $zonaVenta = Zona::whereEstado(1)->get();
            return view('cliente.index',["clientes"=>$clientes,"count"=>$count,"data"=>$data,"grados"=>$grados,'avisos'=>$avisos,"asesorVentas"=>$asesorVentas,"tipoDocumentos" => $tipoDocumentos,"buscarTexto"=>$sql,"zonaVenta"=>$zonaVenta]);
        }
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
    public function destroy($id)
    {
        //
    }
}
