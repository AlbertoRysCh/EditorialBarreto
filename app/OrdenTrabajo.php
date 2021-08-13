<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class OrdenTrabajo extends Model
{
    //
    protected $primaryKey = 'idordentrabajo';
    protected $table='ordentrabajo';
    protected $fillable=['codigo','condicion','precio','idrevision','fechaorden','fecha_inicio','fecha_conclusion','zonaventa','inde','observaciones','asesorventas','idtipoeditoriales','aprobado_por','titulo_coautoria','tipo_contrato'];

    public function getOrdenTrabajoCuotas($type)
    {
    
        $obj = OrdenTrabajo::join('revisiones', 'ordentrabajo.idrevision', '=', 'revisiones.id')
        ->join('cuotas', 'ordentrabajo.idordentrabajo', '=', 'cuotas.idordentrabajo')
        ->join('contratos', 'cuotas.contrato_id', '=', 'contratos.id')
        ->join('users', 'contratos.cliente->asesor_venta_id', '=', 'users.id')
        ->join('cuentas_por_cobrar', 'ordentrabajo.idordentrabajo', '=', 'cuentas_por_cobrar.idordentrabajo')
        ->select('ordentrabajo.idordentrabajo', 'ordentrabajo.codigo',
                'users.nombre', 'ordentrabajo.precio', 'ordentrabajo.fechaorden',
                 'ordentrabajo.zonaventa', 'ordentrabajo.asesorventas',
                'ordentrabajo.condicion', 'revisiones.titulo','ordentrabajo.tipo_contrato',
                'ordentrabajo.titulo_coautoria','cuotas.statu','cuotas.is_fee_init',
                'cuotas.fecha_cuota','cuotas.monto as monto_cuota',
                'contratos.cliente->nombres as nombre_cliente',
                'contratos.cliente->apellidos as apellido_cliente',
                'contratos.cliente->num_documento as num_documento_cliente',
                'contratos.cliente->asesor_venta_id','cuotas.contrato_id',
                'cuentas_por_cobrar.precio as monto_restante',
                DB::raw('CASE
                WHEN ordentrabajo.tipo_contrato = 1 THEN "Coautoría"
                WHEN ordentrabajo.tipo_contrato = 0 THEN "Foráneo"
                END as tipo_contrato_nombre'))
        ->whereNotIn('users.id',array(Config::get('params.global.asesor_venta_default')));
        
        $obj  = $type == 1 ? $obj->where('cuotas.statu',1): $obj;

        return $obj;
    }
    public function busqueda($search,$obj)
    {
        
        if($search == 'foraneo' || $search == 'coautoria'){
            switch ($search) {
                case 'coautoria':
                    $search_number = 1;
                    break;
                case 'foraneo':
                    $search_number = 0;
                    break;

            }
            $obj    = $obj->where(function ($query) use ($search,$search_number) {
                $query->where('ordentrabajo.tipo_contrato', 'LIKE', '%' . $search_number . '%');
                $query->orWhere('ordentrabajo.codigo', 'like', "%{$search}%");
                $query->orWhereRaw('LOWER(json_unquote(json_extract(contratos.cliente, "$.nombres"))) like "%'. strtolower($search). '%"');
                $query->orWhereRaw('LOWER(json_unquote(json_extract(contratos.cliente, "$.apellidos"))) like "%'. strtolower($search). '%"');
                $query->orWhereRaw('LOWER(ordentrabajo.zonaventa) like "%'. strtolower($search). '%"');
                $query->orWhere('ordentrabajo.precio', 'like', "%{$search}%");
                $query->orWhere('cuotas.monto', 'like', "%{$search}%");
                $query->orWhere('cuentas_por_cobrar.precio', 'like', "%{$search}%");
            });
        }else{
            $obj    = $obj->where(function ($query) use ($search) {
                $query->orWhere('ordentrabajo.codigo', 'like', "%{$search}%");
                $query->orWhereRaw('LOWER(json_unquote(json_extract(contratos.cliente, "$.nombres"))) like "%'. strtolower($search). '%"');
                $query->orWhereRaw('LOWER(json_unquote(json_extract(contratos.cliente, "$.apellidos"))) like "%'. strtolower($search). '%"');
                $query->orWhereRaw('LOWER(ordentrabajo.zonaventa) like "%'. strtolower($search). '%"');
                $query->orWhere('ordentrabajo.precio', 'like', "%{$search}%");
                $query->orWhere('cuotas.monto', 'like', "%{$search}%");
                $query->orWhere('cuentas_por_cobrar.precio', 'like', "%{$search}%");
            });
        }
        return $obj;
    }
    

    public function getAutores($idordentrabajo){

        $autores = OrdenTrabajo::select('autores.id','autores.nombres','autores.apellidos','orden_autores.idordentrabajo')
        ->join('orden_autores', 'ordentrabajo.idordentrabajo', '=', 'orden_autores.idordentrabajo')
        ->join('autores', 'autores.id', '=', 'orden_autores.idautor')
        ->whereIn('autores.condicion',array('1','0'))
        ->orderBy('autores.id','desc');

        $autores  = $idordentrabajo != NULL ? $autores->where('orden_autores.idordentrabajo',$idordentrabajo): $autores;

        $autores  = $autores->get();

        return $autores; 
    }
}
