<?php

namespace App\Http\Controllers;
use App\Correo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CorreoController extends Controller
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
            $data = $request->all();
            $fechainicio=trim($request->get('buscarFechaInicio'));
            $fechafinal=trim($request->get('buscarFechaFinal'));        
            $sql=trim($request->get('buscarTexto'));
            $correos=DB::table('historialcorreos')
            ->join('autores','historialcorreos.idcliente','=','autores.id')
            ->join('libros','historialcorreos.idlibros','=','libros.id')
            ->select('historialcorreos.id as idhistorial','historialcorreos.fecha_correo','libros.codigo','historialcorreos.observacion','historialcorreos.archivo','autores.nombres','autores.apellidos',
            'libros.titulo')
            ->whereBetween('historialcorreos.fecha_correo', [$fechainicio, $fechafinal])
            ->orderBy('historialcorreos.id','asc')
            ->paginate(8);
            return view('correo.index',["correos"=>$correos,"data"=>$data,"buscarTexto"=>$sql,"buscarFechaFinal"=>$fechafinal,"buscarFechaInicio"=>$fechainicio]);
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
        $correo= new Correo();
        $correo->idlibros = $request->idlibros;
        $correo->idcliente = $request->autor;
        if($request->hasFile('print')){

            //Get filename with the extension
            $filenamewithExt = $request->file('print')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('print')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('print')->storeAs('public/printcorreo/',$fileNameToStore);
        
       } else{

        $fileNameToStore="noimagen.jpg";
    }
        
        $correo->archivo=$fileNameToStore; 
        $correo->fecha_correo = $request->fechacorreo;
        $correo->observacion = $request->observacion;
        $correo->save();
        return Redirect::to("autor/$correo->idcliente");
    }
    public function download($id){
 
        $dl = Correo::find($id);
        return response()->download(storage_path("app/public/printcorreo/".$dl->archivo));

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
        $correos=DB::table('historialcorreos')
        ->join('autores','historialcorreos.idcliente','=','autores.id')
        ->join('libros','historialcorreos.idlibros','=','libros.id')
        ->select('historialcorreos.id as idhistorial','historialcorreos.fecha_correo','libros.codigo','historialcorreos.observacion','historialcorreos.archivo','autores.nombres','autores.apellidos',
        'libros.titulo')
        ->where('autores.id', $id)
        ->orderBy('historialcorreos.id','asc')
        ->paginate(8);

        $obj=DB::table('autores')
        ->join('grados','autores.idgrado','=','grados.id')
        ->select('autores.id','autores.tipo_documento','autores.num_documento',
        'autores.nombres','autores.apellidos','autores.correocontacto',(DB::raw("CONCAT('autores.nombres','','autores.apellidos') AS algo")),
        'autores.telefono','autores.correogmail','autores.contrasena','autores.resumen','autores.universidad','autores.orcid',
        'grados.nombre as nombregrado', 'autores.condicion', 'autores.idgrado','autores.especialidad')
        ->where('autores.id', $id)
        ->get();

        return view('correo.show',["correos"=>$correos,"obj"=>$obj]);

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
        $correo = Correo::findOrFail($request->idhiscorre);
        $correo->delete();
        return back();
    }
}
