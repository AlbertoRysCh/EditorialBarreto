<div id="codigo_prospecto" class="form-group row" style="display: none">
    <label class="col-md-2 form-control-label" for="codigo_cliente">Código</label>
    <div class="col-md-10">
        <input type="text" id="codigo_cliente" name="codigo_cliente" class="form-control" readonly>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 form-control-label" for="tipo_documento_cliente">Tipo Documento</label>
    <div class="col-md-4">
        <select class="form-control" name="tipo_documento_cliente" id="tipo_documento_cliente" required>
            <option disabled value="">== Seleccione ==</option>
            @foreach($tipoDocumentos as $items)
            <option value="{{$items->id}}">{{$items->nombre}}</option>
            @endforeach
        </select>
    
    </div>
    <label class="col-md-2 form-control-label" for="num_documento_cliente">Número documento</label>
    <div class="col-md-4">
        <input type="hidden" class="num_documento_hidden" readonly>
        <input type="text" id="num_documento_cliente" name="num_documento_cliente" class="form-control solo_numeros validar_num_documento" placeholder="Ingrese el número documento"  minlength="8" maxlength="15">
    </div>
</div>


<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombre_cliente">Nombres</label>
            <div class="col-md-4">
                <input type="text" id="nombres_cliente" name="nombres_cliente" class="form-control solo_letras" placeholder="Ingrese Nombres" required maxlength="70">
                
            </div>
            <label class="col-md-2 form-control-label" for="apellidos_cliente">Apellidos</label>
            <div class="col-md-4">
                <input type="text" id="apellidos_cliente" name="apellidos_cliente" class="form-control solo_letras" placeholder="Ingrese Apellidos" maxlength="70">
                
            </div>
</div>


<div class="form-group row">
            <label class="col-md-2 form-control-label" for="telefono_cliente">Teléfono</label>
            <div class="col-md-4">
              
                <input type="text" id="telefono_cliente" name="telefono_cliente" class="form-control solo_numeros" placeholder="Ingrese el teléfono" maxlength="15">
                   
            </div>
            <label class="col-md-2 form-control-label" for="correocontacto_cliente">Correo</label>
            <div class="col-md-4">
                <input type="email" id="correocontacto_cliente" name="correocontacto_cliente" class="form-control" placeholder="Ingrese Correo">
                
            </div>
</div>



<div class="form-group row">
        <label class="col-md-2 form-control-label" for="grado_id_cliente">Grado</label>
        
        <div class="col-md-10">
        
            <select class="form-control" name="grado_id_cliente" id="grado_id_cliente" required>

            <option disabled value="">== Seleccione ==</option>
            
            @foreach($grados as $items)
              
               <option value="{{$items->id}}">{{$items->nombre}}</option>
                    
            @endforeach

            </select>
        
        </div>
                                   
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button type="submit" class="btn btn-success btn_cliente"><i class="fa fa-save"></i> Guardar</button>
    
</div>
