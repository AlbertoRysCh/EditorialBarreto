<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Configuracion;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        View::composer('*', function($view)
        {   
            $user = Auth::user();
            if(!is_null($user)){
                $this->user_name=Auth::user()->nombre;
                $this->rol=Auth::user()->rol->nombre;
                
                $this->image=Auth::user()->photo;
                $this->rol_id=Auth::user()->idrol;

                $view->with(array(
                'user_name' =>$this->user_name,
                'rol'=>$this->rol,'image'=>$this->image,
                'rol_id' =>$this->rol_id,
                'perfil'=>true));

            }else{
                $view->with(array('user_name' => '','rol'=>'','image'=>false,'rol_id' =>'0','perfil'=>false));

            }
            // CONFIGURACIONES

            $this->get_version=Configuracion::listVersion();
            isset($this->get_version) ? $view->with('get_version', $this->get_version) :  $view->with('get_version', '');

            $this->get_mantenimiento=Configuracion::listMantenimiento();
            isset($this->get_mantenimiento) ? $view->with('get_mantenimiento', $this->get_mantenimiento) :  $view->with('get_mantenimiento', 0);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
