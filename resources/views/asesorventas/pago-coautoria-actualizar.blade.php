<div class="form-group row">
    <label class="col-md-2 form-control-label" for="observaciones_update">Observaciones</label>
    <div class="col-md-10">
        <textarea class="form-control" id="observaciones_update" name="observaciones_update" rows="3" readonly></textarea>                       
    </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="capturepago_update">Pago</label>
        <div class="col-md-4">
            <input id="capturepago_update" type="file" class="form-control" name="capturepago_update" onchange="ValidateImage(this);" required>
        </div> 
        <label class="col-md-2 form-control-label" for="fecha_cuota_update">Fecha</label>
        <div class="col-md-3">
            <input type="text" class="form-control datepicker" name="fecha_cuota_update" id="fecha_cuota_update" placeholder="MM/DD/YYYY" value="{{date('Y-m-d')}}" required>
        </div> 
    </div>


    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>

    </div>
