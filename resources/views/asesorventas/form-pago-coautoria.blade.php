<div class="form-group row">
        <label class="col-md-2 form-control-label" for="codigo_data">Código contrato</label>
        <div class="col-md-3">
            <input type="text" id="codigo_data" name="codigo_data" class="form-control" readonly>
            
        </div>  
        <label class="col-md-2 form-control-label" for="codigo_data">Monto Total</label>
        <div class="col-md-3">
            <input type="text" id="monto_total" name="monto_total" class="form-control" readonly>
            
        </div>  
    </div>

    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="titulo_data">Título</label>
        <div class="col-md-9">
            <textarea class="form-control" id="titulo_data" name="titulo_data" rows="3" maxlength="250" readonly></textarea>                       
        </div>
    </div>


    <div class="form-group row">

        
        <label class="col-md-2 form-control-label" for="monto_total_data">Monto Inicial</label>
        <div class="col-md-4">
            <input type="text" class="form-control" id="monto_total_data" name="monto_total_data" onkeypress="return validarDecimales(event, this)" required>                       
        </div>

    </div>


    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="capturepago">Adjuntar pago</label>
        <div class="col-md-4">
            <input id="capturepago" type="file" class="form-control" name="capturepago" onchange="ValidateImage(this);" required>
        </div> 
        <label class="col-md-2 form-control-label" for="fecha_cuota">Fecha de cuota</label>
        <div class="col-md-3">
            <input type="text" class="form-control datepicker" name="fecha_cuota" id="fecha_cuota" placeholder="MM/DD/YYYY" value="{{date('Y-m-d')}}" required>
        </div> 
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="observaciones">Observaciones</label>
        <div class="col-md-9">
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" maxlength="250"></textarea>                       
        </div>
        </div>
    </div>

    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>

    </div>
