<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password','username','tipo_documento','num_documento','direccion',
        'telefono','estado','idrol','photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){

        return $this->belongsTo('App\Models\Rol','idrol');
    }

    public function distritos(){
        return $this->belongsToMany('App\Models\Ubigeo', 'distritos_vendedores', 'user_id', 'distrito_ubigeo');
    }

    // public function distrito()
    // {
    //     return $this->hasOne('App\Models\Ubigeo','ubigeo', 'distrito_ubigeo');
    // }
    /* Obtener nombre de zona.
    */
    public function zonas()
    {
        return $this->hasOne('App\Zona','id', 'zona_id');
    }
    public function asesor(){

        return $this->belongsTo('App\Asesor');
    }

    public function archivos(){

        return $this->hasMany('App\Archivo');
    }

    public function actividades(){

        return $this->hasMany('App\Actividad');
    }
}
