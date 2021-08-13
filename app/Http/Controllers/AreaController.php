<?php

namespace App\Http\Controllers;
use App\Area;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AreaController extends Controller
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
        $areas=DB::table('areas')
        ->where('nombre','LIKE','%'.$sql.'%')
        ->orwhere('codigo','LIKE','%'.$sql.'%')
        ->orderBy('id','desc')
        ->paginate(8);
        //dd($areas);
        return view('area.index',["areas"=>$areas,"buscarTexto"=>$sql]);

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
        $areas= new Area();
        $areas->codigo = $request->codigo;
        $areas->nombre = $request->nombre;
        $areas->descripcion = $request->descripcion;
        $areas->condicion = '1';

        $areas->save();
        return Redirect::to("area"); 
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
        $areas= Area::findOrFail($request->id_area);
        $areas->codigo = $request->codigo;
        $areas->nombre = $request->nombre;
        $areas->descripcion = $request->descripcion;
        // $areas->condicion = '1';
        $areas->save();
        return Redirect::to("area"); 
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
        $area= Area::findOrFail($request->area_id_delete);
         
        if($area->condicion=="1"){

               $area->condicion= '0';
               $area->save();
               return Redirect::to("area");

          }else{

               $area->condicion= '1';
               $area->save();
               return Redirect::to("area");

           }
    }
}
