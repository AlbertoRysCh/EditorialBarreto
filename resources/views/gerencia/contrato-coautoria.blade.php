<div class="form-group row">
        <label class="col-md-2 form-control-label" for="codigo_contrato">Código Título</label>
        <div class="col-md-10">
            <input type="text" id="codigo_contrato" name="codigo_contrato" class="form-control" readonly>
            <input type="hidden" id="idgrado" name="idgrado" class="form-control" readonly>
            
        </div>  
    </div>

    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="titulo_contrato">Título Artículo</label>
        <div class="col-md-10">
            <textarea class="form-control" id="titulo_contrato" name="titulo_contrato" rows="3" maxlength="250" readonly></textarea>                       
        </div>
    </div>


    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="tipo_documento_contrato">Tipo Documento</label>
            <div class="col-md-4">
                <input type="text" id="tipo_documento_contrato" name="tipo_documento_contrato" class="form-control" readonly>
            </div>
            <label class="col-md-2 form-control-label" for="num_documento_contrato">Número documento</label>
            <div class="col-md-4">
                <input type="text" id="num_documento_contrato" name="num_documento_contrato" class="form-control" placeholder="Ingrese el número documento" pattern="[0-9]{0,15}" readonly>
            </div>
    </div>


<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombres_contrato">Nombres</label>
            <div class="col-md-4">
                <input type="text" id="nombres_contrato" name="nombres_contrato" class="form-control" placeholder="Ingrese Nombres" readonly>
                
            </div>
            <label class="col-md-2 form-control-label" for="apellidos_contrato">Apellidos</label>
            <div class="col-md-4">
                <input type="text" id="apellidos_contrato" name="apellidos_contrato" class="form-control" placeholder="Ingrese Apellidos" readonly>
                
            </div>
</div>
    <div class="form-group row">
        
        <label class="col-md-2 form-control-label" for="correocontacto_contrato">Correo Contacto</label>
        <div class="col-md-4">
          
        <input type="email" class="form-control" id="correocontacto_contrato" name="correocontacto_contrato" placeholder="Ingrese correo de contacto" maxlength="150">
               
        </div>
        <label class="col-md-2 form-control-label" for="telefono_contrato">Teléfono</label>
        <div class="col-md-4">
        
            <input type="text" id="telefono_contrato" name="telefono_contrato" class="form-control solo_numeros" placeholder="Ingrese el teléfono" pattern="[0-9]{0,15}" maxlength="15">
            
        </div>       
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="domicilio_contrato">Domicilio</label>
        <div class="col-md-10">
        <textarea class="form-control" id="domicilio_contrato" name="domicilio_contrato" rows="3" maxlength="200"></textarea>                       
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="observaciones_contrato">Observación</label>
        <div class="col-md-10">
        <textarea class="form-control" id="observaciones_contrato" name="observaciones_contrato" rows="3" maxlength="255"></textarea>                       
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="monto_total">Monto Total</label>
        <div class="col-md-4">
            <input type="text" id="monto_total" name="monto_total" class="form-control" placeholder="Monto total" required onkeypress="return validarDecimales(event, this)" maxlength="15">
        </div>       
    </div>


    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button class="btn btn-success btn-contrato-coautor"><i class="fa fa-refresh"></i> Generar</button>

    </div>
