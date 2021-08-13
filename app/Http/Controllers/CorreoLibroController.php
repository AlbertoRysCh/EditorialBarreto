<?php

namespace App\Http\Controllers;
use App\CorreoLibro;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CorreoLibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $correo= new CorreoLibro();
        $correo->idcliente = $request->id_autor;
        $correo->codigolib = $request->codigo;
        $correo->correo = $request->correo;
        $correo->contrasena = $request->contrasena;
        $correo->celularrelacionado = $request->celular;
        //inicio registrar archivos   
        if($request->hasFile('archivos')){
        $filenamewithExt = $request->file('archivos')->getClientOriginalName();
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        $extension = $request->file('archivos')->guessClientExtension();
        $fileNameToStore = time().'.'.$extension;
        $path = $request->file('archivos')->storeAs('public/firmalibros',$fileNameToStore);
         } else{
         $fileNameToStore="noimagen.jpg";
            }
        $correo->firma=$fileNameToStore; 
        $correo->save();
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
        $correo= CorreoLibro::findOrFail($request->id);
        $correo->idcliente = $request->id_autor;
        $correo->codigolib = $request->codigo_art;
        $correo->correo = $request->correo;
        $correo->contrasena = $request->contrasena;
        
        $correo->celularrelacionado = $request->celular;
        if($request->hasFile('archivos')){
            /*si la imagen que subes es distinta a la que está por defecto 
            entonces eliminaría la imagen anterior, eso es para evitar 
            acumular imagenes en el servidor*/ 
        if($correo->firma != 'noimagen.jpg'){ 
            Storage::delete('public/firmalibros'.$correo->firma);
        }
        $filenamewithExt = $request->file('archivos')->getClientOriginalName();
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        $extension = $request->file('archivos')->getClientOriginalExtension();
        $fileNameToStore = time().'.'.$extension;
        $path = $request->file('archivos')->storeAs('public/firmalibros',$fileNameToStore);
               
    } else {
        $fileNameToStore = $correo->firma; 
    }
        
       $correo->firma=$fileNameToStore;
        $correo->save();
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

    public function downloadfirma($id){
        $dl = CorreoLibro::find($id);
        return response()->download(storage_path("app/public/firmalibros/".$dl->firma));
     }
}
