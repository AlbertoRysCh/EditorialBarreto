<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    //
    protected $table='autores';

    protected $fillable = [
        'id','tipo_documento','num_documento','nombres','apellidos','correocontacto','telefono', 'correogmail', 'contrasena', 'resumen','orcid', 'universidad','orcid','idgrado','especialidad','condicion'];
}
