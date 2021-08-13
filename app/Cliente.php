<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table='clientes';

    protected $fillable = [
        'id','tipo_documento','codigo','num_documento','nombres','apellidos','correocontacto','telefono', 'correogmail', 'contrasena', 'resumen','orcid', 'universidad','idgrado','especialidad','condicion','autor','aviso_id','productos_id','asesor_venta_id','zona_id'];


        public function grados(){

            return $this->belongsTo('App\Grado');
        }

        public function revisiones(){

            return $this->hasMany('App\Revision');
        }

        public function productos(){
            return $this->belongsToMany('App\TipoProductos');
        }
    
        public function clientesproductos(){
            return $this->belongsToMany('App\ClientesProductos');
        }

        public function getProductos($idcliente){

            $productos = Cliente::select('tipoeditoriales.id','tipoeditoriales.codigo','tipoeditoriales.nombre','tipoeditoriales.descripcion')
            ->join('clientes_productos', 'clientes.id', '=', 'clientes_productos.idclientes')
            ->join('tipoeditoriales', 'clientes_productos.idtipoeditoriales', '=', 'tipoeditoriales.id')
            ->whereIn('tipoeditoriales.condicion',array('1'))
            ->orderBy('tipoeditoriales.id','desc');
    
            $productos  = $idcliente != NULL ? $productos->where('clientes_productos.idclientes',$idcliente): $productos;
    
            $productos  = $productos->get();
    
            return $productos; 
        }
}
