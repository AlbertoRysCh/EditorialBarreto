<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Observacion;
use Illuminate\Support\Facades\DB;

class ObservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $observaciones=DB::table('observaciones')
        ->where('idarticulo',$id)
        ->paginate(10);
    //    $observaciones = App\Observacion::find($id);

        return view('observacion.index',["observaciones"=>$observaciones]);
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
        $observacion= new Observacion();
        $observacion->idarticulo = $request->id_articulo;
        $observacion->descripcion = $request->observacion;
        if($request->hasFile('capture')){

            //Get filename with the extension
            $filenamewithExt = $request->file('capture')->getClientOriginalName();
            
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            
            //Get just ext
            $extension = $request->file('capture')->guessClientExtension();
            
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            
            //Upload Image
            $path = $request->file('capture')->storeAs('public/observacion',$fileNameToStore);

        
       } else{

        $fileNameToStore="noimagen.jpg";
    }
        
       $observacion->archivo=$fileNameToStore; 

        //fin registrar imagen
        $observacion->save();
        return redirect()->back();
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
        $libros=DB::table('libros')
        ->select('id as idlibros')
        ->where('codigo',$id)
        ->first();

        $idlibros= $libros->idlibros;
      //  dd($idarticulo);

        $observaciones=DB::table('observaciones')
        ->where('idlibros',$idlibros)
        ->paginate(10); 
        

     //   dd($observaciones);


        return view('observacion.show',[ "observaciones"=>$observaciones,"articulos"=>$articulos])->with('id',$id);

    }
    public function download($id){
 
        $dl = Observacion::find($id);
        return response()->download(storage_path("app/public/observacion/".$dl->archivo));

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
                $observacion= Observacion::findOrFail($request->id_observacion);
                $observacion->idarticulo = $request->id_articulo;
                $observacion->descripcion = $request->observacion;
                if($request->hasFile('capture')){
        
                    /*si la imagen que subes es distinta a la que está por defecto 
                    entonces eliminaría la imagen anterior, eso es para evitar 
                    acumular imagenes en el servidor*/ 
                if($observacion->archivo != 'noimagen.jpg'){ 
                    Storage::delete('public/documento/autor'.$observacion->archivo);
                }
        
                
                    //Get filename with the extension
                $filenamewithExt = $request->file('capture')->getClientOriginalName();
                
                //Get just filename
                $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
                
                //Get just ext
                $extension = $request->file('capture')->guessClientExtension();
                
                //FileName to store
                $fileNameToStore = time().'.'.$extension;
                
                //Upload Image
                $path = $request->file('capture')->storeAs('public/observacion',$fileNameToStore);
                
                
                
            } else {
                
                $fileNameToStore = $observacion->capture; 
            }
        
               $observacion->archivo=$fileNameToStore;
               $observacion->save();
            return redirect()->back();
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
