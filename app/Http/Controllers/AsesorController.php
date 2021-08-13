<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asesor;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request){

            $sql=trim($request->get('buscarTexto'));
            $asesores=DB::table('asesors')
            ->join('tipoeditoriales','asesors.idtipoeditoriales','tipoeditoriales.id')
            ->select('asesors.id','asesors.usuario_id','asesors.num_documento',
            'asesors.nombres','asesors.telefono','asesors.correo','asesors.condicion',
            'tipoeditoriales.nombre as nombreproducto')
            ->where('asesors.nombres','LIKE','%'.$sql.'%')
            ->orwhere('asesors.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('asesors.id','desc')
            ->paginate(10);
        }

        return view('asesor.index',["asesores"=>$asesores,"buscarTexto"=>$sql]);
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
        {
            //    $fechainicio=trim($request->get('buscarFechaInicio'));
              //  $fechafinal=trim($request->get('buscarFechaFinal'));
               // $statu=trim($request->get('buscarStatu'));
                $archivos=DB::table('archivos')
                ->join('articulos','archivos.idarticulo','=','articulos.id')
                ->join('users','archivos.iduser','=','users.id')
                ->join('status','articulos.idstatu', '=','status.id')
                ->select('archivos.id','articulos.titulo','articulos.codigo','archivos.idarticulo',
                'archivos.avance','archivos.observacion','users.nombre','archivos.created_at','status.nombre as nombrestatus')
                ->where('users.id',$id)
           //     ->whereBetween('archivos.created_at', [$fechainicio, $fechafinal])
                ->orderBy('archivos.id','desc')
                ->get();
            
            }
                return view('asesor.resumen',["archivos"=>$archivos]);
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
