<div class="form-group row">
                <div class="col-md-9">
                    <input type="hidden" id="autor" name="autor" class="form-control" value="{{$autores->id}}" pattern="[0-9]{0,15}">
                </div>
    </div>


    <div class="form-group row">
                <div class="col-md-9">
                  
                    <input type="hidden" id="idarticulos" name="idarticulos" class="form-control" placeholder="Ingrese el telefono" pattern="[0-9]{0,15}">
                       
                </div>
    </div>


    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="imagen">Print</label>
                <div class="col-md-9">
                  
                    <input type="file" id="print" required name="print" class="form-control">
                       
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="fechamovimiento">Fecha de envío correo</label>
                <div class="col-md-9">
                <input type="text" class="form-control datepicker" required autocomplete="off" name="fechacorreo" id="fechacorreo" placeholder="YYYY/MM/DD">  
                </div>
                
    </div>

    <div class="form-group row">
                <div class="col-md-9">
                <label for="exampleFormControlTextarea1">Observación</label>
                    <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>                       
                </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        
    </div>