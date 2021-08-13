<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Zona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
            $usuarios=DB::table('users')
            ->join('roles','users.idrol','=','roles.id')
            ->join('zonas','users.zona_id','=','zonas.id')
            ->select('users.id','users.nombre','users.tipo_documento',
            'users.num_documento','users.direccion','users.telefono',
            'users.email','users.username','users.password',
            'users.condicion','users.idrol','roles.nombre as rol','zonas.descripcion as nombre_zona',
            'users.zona_id')
            ->where('users.nombre','LIKE','%'.$sql.'%')
            ->orwhere('users.num_documento','LIKE','%'.$sql.'%')
            ->orderBy('users.id','desc')
            ->paginate(5);

             /*listar los roles en ventana modal*/
            $roles=DB::table('roles')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get(); 
            $zonaVenta = Zona::whereEstado(1)->get();
            return view('user.index',["usuarios"=>$usuarios,"roles"=>$roles,"buscarTexto"=>$sql,"zonaVenta"=>$zonaVenta]);
        
            //return $usuarios;
        }      
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
        //dd($request->username);
        $user= new User();
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->username = $request->username;
        $user->password = bcrypt( $request->password);
        $user->condicion = '1';
        $user->idrol = $request->id_rol; 
        $user->zona_id = $request->zona_id; 
       // dd($user);
            //fin registrar imagen
            $user->save();
            return Redirect::to("usuarios");
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
        $user= User::findOrFail($request->id_usuario);
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->id_rol;
        $user->zona_id = $request->zona_id; 
           
           //Editar imagen

         //fin editar imagen

          $user->save();
          return Redirect::to("usuarios");
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
        $user= User::findOrFail($request->id_usuario);
         
         if($user->condicion=="1"){

                $user->condicion= '0';
                $user->save();
                return Redirect::to("usuarios");

           }else{

                $user->condicion= '1';
                $user->save();
                return Redirect::to("usuarios");

            }
    }
}
