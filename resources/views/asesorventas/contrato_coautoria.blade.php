<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombre_contrato">Tipo Documento</label>
            <div class="col-md-4">
                <input type="text" id="tipo_documentos"  name="tipo_documentos" class="form-control" placeholder="Ingrese Nombres" readonly>
            </div>
            <label class="col-md-2 form-control-label" for="apellidos_contrato">Numero Documento</label>
            <div class="col-md-4">
                <input type="text" id="num_documento" name="num_documento" class="form-control" placeholder="Ingrese Apellidos" readonly>
                
            </div>
</div>

<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombre_contrato">Nombres</label>
            <div class="col-md-4">
                <input type="text" id="nombres_contrato"  name="nombres_contrato" class="form-control" placeholder="Ingrese Nombres" readonly>
                <input type="hidden" id="nombres_contrato"  name="id_cliente" class="form-control">

            </div>
            <label class="col-md-2 form-control-label" for="apellidos_contrato">Apellidos</label>
            <div class="col-md-4">
                <input type="text" id="apellidos_contrato" name="apellidos_contrato" class="form-control" placeholder="Ingrese Apellidos" readonly>
                
            </div>
</div>
    
    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="contrato">Adjuntar Contrato</label>
        <div class="col-md-6">
            <input type="file" id="archivo_contrato" name="archivo_contrato" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="monto_total">Monto Total</label>
        <div class="col-md-4">
        
            <input type="text" id="monto_total" name="monto_total" class="form-control" placeholder="Monto total" required onkeypress="return validarDecimales(event, this)" maxlength="15">
            
        </div>   
   
    </div>

    

<!-- -->

    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button class="btn btn-success" id="guardar_contrato"><i class="fa fa-refresh"></i> Generar</button>

    </div>