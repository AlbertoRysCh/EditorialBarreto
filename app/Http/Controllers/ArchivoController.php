<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Archivo;
// use App\Articulo;
use App\Actividad;
use App\Exports\ArchivoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
// use App\User;
use Illuminate\Support\Facades\Auth;
use App\Exports\ArchivosExport;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $usuario = auth()->user()->id;
        $rol = auth()->user()->idrol;
        if($rol !=5 ){
            $sql=trim($request->get('buscarTexto'));
            $archivos=DB::table('archivos')
            ->join('libros','archivos.idlibros','=','libros.id')
            ->join('users','archivos.iduser','=','users.id')
            ->select('archivos.id','libros.titulo','libros.codigo','archivos.archivo','archivos.idlibros',
            'archivos.avance','archivos.observacion','archivos.iduser','archivos.created_at')
            ->where('libros.id','!=',358)
            ->where('libros.codigo','LIKE','%'.$sql.'%')
            ->orwhere('libros.titulo','LIKE','%'.$sql.'%')
            ->orwhere('users.nombre','LIKE','%'.$sql.'%')
            ->orderBy('archivos.id','desc')
            ->paginate(5);
          //  dd($archivos);
            $libros=DB::table('libros')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->select('libros.id','asesors.usuario_id','libros.titulo')
        //    ->where('asesors.usuario_id',$usuario)
            ->get(); 
            
        }else{
            $sql=trim($request->get('buscarTexto'));
            $archivos=DB::table('archivos')
            ->join('libros','archivos.idlibros','=','libros.id')
            ->join('users','archivos.iduser','=','users.id')
            ->select('archivos.id','libros.titulo','libros.codigo','archivos.archivo','archivos.idlibros',
            'archivos.avance','archivos.observacion','archivos.iduser','archivos.created_at')
            ->where('libros.id','!=',358)

            ->where('archivos.iduser',$usuario)
            ->where('libros.codigo','LIKE','%'.$sql.'%')
            ->orderBy('archivos.id','desc')
            ->paginate(10);

            $libros=DB::table('libros')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->select('libros.id','asesors.usuario_id','libros.titulo','libros.codigo')
            ->where('asesors.usuario_id',$usuario)
            ->where('libros.condicion','=','1')
            ->whereIn('libros.idstatu', [12])
            ->get(); 
        }

        

        return view('archivo.index',["archivos"=>$archivos,"data"=>$data,"libros"=>$libros,"buscarTexto"=>$sql]);

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
        $archivo= new Archivo();
        $archivo->idlibros = $request->id_libros;
        $archivo->iduser = $request->user;

        if(Auth::user()->idrol == 3){
            $archivo->avance = '0';

        }else{
            $archivo->avance = $request->avance;

        }

        //inicio registrar archivos

        if($request->hasFile('archivo')){

            //Get filename with the extension
            $filenamewithExt = $request->file('archivo')->getClientOriginalName();
            
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            
            //Get just ext
            $extension = $request->file('archivo')->getClientOriginalExtension();
            
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            
            //Upload Image
            $path = $request->file('archivo')->storeAs('public/asesores',$fileNameToStore);

        
       } else{

        $fileNameToStore="noimagen.jpg";
    }
        
       $archivo->archivo=$fileNameToStore; 
       $archivo->observacion = $request->observacionarchivo;
       $archivo->save();


       $actividad= new Actividad();
       $actividad->usuario_id = $request->user;
       $actividad->idlibros = $request->id_libros;
       $actividad->avancemañana = $request->avancemañana;
       $actividad->avancetarde = $request->avancetarde;
       $actividad->observacion = $request->observacion;
       
       $actividad->save();
       

       return Redirect::to("archivo");     
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
        $archivo= Archivo::findOrFail($request->id_archivos);
       
        $archivo->idlibros = $request->id_libros;
        $archivo->iduser = $request->user;
        $archivo->avance = $request->avance;
        if($request->hasFile('archivo')){

            /*si la imagen que subes es distinta a la que está por defecto 
            entonces eliminaría la imagen anterior, eso es para evitar 
            acumular imagenes en el servidor*/ 
        if($archivo->archivo != 'noimagen.jpg'){ 
            Storage::delete('public/asesores'.$archivo->archivo);
        }

        
            //Get filename with the extension
        $filenamewithExt = $request->file('archivo')->getClientOriginalName();
        
        //Get just filename
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        
        //Get just ext
        $extension = $request->file('archivo')->guessClientExtension();
        
        //FileName to store
        $fileNameToStore = time().'.'.$extension;
        
        //Upload Image
        $path = $request->file('archivo')->storeAs('public/asesores',$fileNameToStore);
        
        
        
    } else {
        
        $fileNameToStore = $archivo->archivo; 
    }

       $archivo->archivo=$fileNameToStore;
    $archivo->observacion = $request->observacionarchivo;

    
    $archivo->save();
    return  back();  

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
    public function download($id){
 
        $dl = Archivo::find($id);
        return response()->download(storage_path("app/public/asesores/".$dl->archivo));

     }
     public function exportarExcel(){

        return Excel::download(new ArchivosExport, 'archivos.xlsx');

   }
   public function material(Request $request)
    {
        //
            $usuario = auth()->user()->id;

            if(auth()->user()->idrol == 1 || auth()->user()->idrol == 3 ) {
            $sql=trim($request->get('buscarTexto'));
            $historiales=DB::table('historiales')
            ->join('libros','historiales.idlibros','=','libros.id')
            ->join('editoriales','libros.ideditorial','=','editoriales.id')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->select('libros.id as idlibros','historiales.id as idhistorial','libros.codigo','libros.titulo','historiales.archivo','historiales.fechaAsignacion',
            'editoriales.nombre as nombreeditoriales','asesors.nombres as nombreasesores','historiales.idstatu','asesors.nombres','historiales.idasesor')
             ->where('historiales.idstatu','=',12)
             ->where('historiales.fechaAsignacion','>','2020-11-29')
             ->where('libros.codigo','LIKE','%'.$sql.'%')
             ->orderBy('historiales.fechaAsignacion','desc')
             ->paginate(15); 
            return view('archivo.material',["historiales"=>$historiales,"buscarTexto"=>$sql]);
        }else{
            $libros=DB::table('libros')
            ->join('editoriales','libros.ideditorial','=','editoriales.id')
            ->join('niveles','editoriales.idnivelindex','=','niveles.id')
            ->join('asesors','libros.idasesor','=','asesors.id')
            ->join('status','libros.idstatu','=','status.id')
            ->select('libros.id as idlibros','libros.codigo','libros.archivo','libros.archivo','libros.condicion','libros.titulo',
            'libros.fechaOrden','libros.fechaCulminacion','niveles.nombre as nombreindex','status.nombre as nombrestatus',
            'editoriales.nombre as nombreeditoriales','asesors.nombres as nombreasesores','status.nombre','asesors.usuario_id')
          //  ->where('articulos.codigo','!=','00000001')
            ->where('asesors.usuario_id','=',$usuario)
            ->where('libros.idstatu','=',12)
            ->orderBy('libros.id','desc')
            ->paginate(15); 
            return view('archivo.material',["libros"=>$libros]);
        }
    }
}
