<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Editorial;
// use App\Articulo;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
// use App\User;
use Illuminate\Support\Facades\Auth;
use App\Exports\EditorialExport;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class EditorialController extends Controller
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
            $editorial=DB::table('editoriales')
            ->join('periocidades','editoriales.idperiodo','=','periocidades.id')
            ->join('niveles','editoriales.idnivelindex','=','niveles.id')
            ->select('editoriales.id as ideditoriales','editoriales.codigo','editoriales.lineaInvestigacion','editoriales.nombre','editoriales.descripcion',
            'editoriales.condicion','editoriales.idperiodo','editoriales.idnivelindex','niveles.nombre as nivelesnombre','periocidades.nombre as nombreperiocidad','editoriales.idioma','editoriales.pais','editoriales.enlace','editoriales.sjr','editoriales.citescore','editoriales.articulo_numero','editoriales.review','editoriales.tiempo_respuesta','editoriales.referencias','editoriales.citados','editoriales.open_access','editoriales.nivel_rechazo')
            ->where('editoriales.nombre','LIKE','%'.$sql.'%')
            ->orwhere('editoriales.codigo','LIKE','%'.$sql.'%')
            ->orderBy('editoriales.id','desc')
            ->paginate(6);
            $periocidades=DB::table('periocidades')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get(); 

            $niveles=DB::table('niveles')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get(); 
            
            return view('editorial.index',["editorial"=>$editorial,"periocidades"=>$periocidades,"niveles"=>$niveles,"buscarTexto"=>$sql]);
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
        $rev= new Editorial();
        $rev->codigo = $request->codigo;
        $rev->nombre = $request->nombre;
        $rev->descripcion = $request->descripcion;
        $rev->lineaInvestigacion = $request->linea;
        $rev->idioma = $request->idioma;
        $rev->pais = $request->pais;
        $rev->enlace = $request->enlace;
        $rev->idperiodo = $request->id_periodo;
        $rev->idnivelindex = $request->id_nivel;
        $rev->sjr = $request->sjr;
        $rev->citescore = $request->cites;
        $rev->articulo_numero = $request->numero;
        $rev->review = $request->review;
        $rev->tiempo_respuesta = $request->tiempo;
        $rev->referencias = $request-> referencias;
        $rev->citados = $request-> citados;
        $rev->open_access = $request->open;
        $rev->nivel_rechazo = $request->rechazo;
        /*'editoriales.sjr',
        'editoriales.citescore',
        'editoriales.articulo_numero',
        'editoriales.review',
        'editoriales.tiempo_respuesta',
        'editoriales.referencias',
        'editoriales.citados',
        'editoriales.open_access',
        'editoriales.nivel_rechazo'*/
        $rev->condicion = '1';

            //fin registrar imagen
            $rev->save();
            return Redirect::to("editoriales"); 

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
    public function update(Request $request)
    {
        //
        $rev= Editorial::findOrFail($request->ideditoriales);
        $rev->codigo = $request->codigo;
        $rev->nombre = $request->nombre;
        $rev->descripcion = $request->descripcion;
        $rev->lineaInvestigacion = $request->linea;
        $rev->idioma = $request->idioma;
        $rev->pais = $request->pais;
        $rev->enlace = $request->enlace;
        $rev->idperiodo = $request->id_periodo;
        $rev->idnivelindex = $request->id_nivel;
        $rev->sjr = $request->sjr;
        $rev->citescore = $request->cites;
        $rev->articulo_numero = $request->numero;
        $rev->review = $request->review;
        $rev->tiempo_respuesta = $request->tiempo;
        $rev->referencias = $request-> referencias;
        $rev->citados = $request-> citados;
        $rev->open_access = $request->open;
        $rev->nivel_rechazo = $request->rechazo;
        $rev->save();
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       // dd($request->ideditoriales);
        $editorial = Editorial::findOrFail($request->ideditoriales);
        //dd($editorial);
        $editorial->delete();
        return back(); 
    }
    public function exportarExcel() 
    {
        return Excel::download(new EditorialExport, 'invoices.xlsx');
    }

    public function desactivar(Request $request)
        {
            //
            $editorial = Editorial::findOrFail($request->ideditorial);
            
            if($editorial->condicion=="1"){

                    $editorial->condicion= '0';
                    $editorial->save();
                    return Redirect::to("editoriales");

            }else{

                    $editorial->condicion= '1';
                    $editorial->save();
                    return Redirect::to("editoriales");

                }
        }
}
