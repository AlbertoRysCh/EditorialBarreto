<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $guarded =  [];

    public function getClients()
    {
        $clientes = Cliente::select('clientes.*',
        DB::raw('CASE
        WHEN clientes.estado = 1 THEN "Activo"
        WHEN clientes.estado = 0 THEN "Desactivado"
        END as estado'),
        DB::raw('CASE
        WHEN clientes.estado_cliente = 1 THEN "Cliente"
        WHEN clientes.estado_cliente = 0 THEN "Posible Cliente"
        END as estado_cliente')
        )
        ->join('users','clientes.user_id','=','users.id')
        ->leftJoin('users as u2','clientes.vendedor_id','=','u2.id')
        ->where('clientes.estado',1)
        ->orderBy('clientes.nombres_rz', 'desc')
        ->orderBy('clientes.num_documento', 'desc')->get();

        return $clientes;

    }
    public function getClientsHasSeller($user_id)
    {
        $clientesVendedor = Cliente::select('clientes.*',
        'users.name as usuario',
        'u2.name as nombre_vendedor',
        DB::raw('CASE
        WHEN clientes.estado = 1 THEN "Activo"
        WHEN clientes.estado = 0 THEN "Desactivado"
        END as estado'),
        DB::raw('CASE
        WHEN clientes.estado_cliente = 1 THEN "Cliente"
        WHEN clientes.estado_cliente = 0 THEN "Posible Cliente"
        END as estado_cliente'),
        DB::raw('CASE
        WHEN clientes.estado_llamada = 1 THEN "Pendiente"
        WHEN clientes.estado_llamada = 2 THEN "Realizada"
        WHEN clientes.estado_llamada = 3 THEN "LLamar luego"
        END as estado_llamada_nombre'),
        DB::raw('CASE
        WHEN clientes.tipo_persona_id = 1 THEN "Jurídica"
        WHEN clientes.tipo_persona_id = 2 THEN "Natural"
        END as tipo_persona')
        )
        ->join('users','clientes.user_id','=','users.id')
        ->leftJoin('users as u2','clientes.vendedor_id','=','u2.id')
        ->orderBy('clientes.nombres_rz', 'desc')
        ->orderBy('clientes.num_documento', 'desc')
        ->where('clientes.is_empleado',0);
        $clientesVendedor  = Auth::user()->rol_id == 4 ? $clientesVendedor->where('clientes.vendedor_id', $user_id): $clientesVendedor;

        return $clientesVendedor;

    }

    public function getClientDetail($id)
    {
        $id =Crypt::decrypt($id);
        $clienteDetalle = Cliente::select('clientes.*',
        DB::raw('CASE
        WHEN clientes.estado = 1 THEN "Activo"
        WHEN clientes.estado = 0 THEN "Desactivado"
        END as estado'),
        DB::raw('CASE
        WHEN clientes.estado_cliente = 1 THEN "Cliente"
        WHEN clientes.estado_cliente = 0 THEN "Posible Cliente"
        END as estado_cliente'),
        DB::raw('CASE
        WHEN clientes.is_empleado = 0 THEN "No"
        WHEN clientes.is_empleado = 1 THEN "Sí"
        END as is_empleado')
        )
        ->join('users','clientes.user_id','=','users.id')
        ->leftJoin('users as u2','clientes.vendedor_id','=','u2.id')
        ->where('clientes.id', $id)
        ->where('clientes.estado',1)
        ->orderBy('clientes.nombres_rz', 'desc')
        ->orderBy('clientes.num_documento', 'desc')->first();

        return $clienteDetalle;

    }

}
