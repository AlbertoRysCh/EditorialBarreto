<div class="modal fade" id="modalCuotas" tabindex="-1" role="dialog" aria-labelledby="defaultModal">

    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form  method="POST" name="formCuotasCoautoria" id="formCuotasCoautoria"  onsubmit="return ValidateCuota();" enctype="multipart/form-data">
                {{csrf_field()}}
                <input class="form-control" type="hidden" name="ordentrabajo_id" value="{{$ordenTrabajo->idordentrabajo}}">                
                <input type="hidden" name="action_asesor_venta" id="action_asesor_venta" value="1"/>
                <div class="modal-header cabeceramodal">
                    <h4 class="modal-title" id="defaultModalLabel">Registrar cuota
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Precio total</label>
                                <input type="text" class="form-control" id="precio_modal_cuota" name="precio" disabled>
                                <input type="hidden" class="form-control" id="contratoss_id" name="contratoss_id" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Total pendiente</label>
                                <input type="text" class="form-control" id="total_pendiente" name="total_pendiente" disabled>
                            </div>
                        </div>
                    </div>
                    <table id="regCuota" style="width:100%;">

                        <tbody class="table_orden_trabajo">
                            <tr>
                            <td style="width: 50%;">
                            <div class="form-group">
                                <label for="fecha_cuota_aux">Fecha de cuota</label>
                                <input type="text" class="form-control datepicker" name="fecha_cuota_aux" id="fecha_cuota_aux" value="{{date('Y-m-d')}}" placeholder="MM/DD/YYYY" maxlength="10">
                            </div>
                            </td>
                            <td style="width: 50%;">
                            <div class="form-group">
                                <label for="monto_aux">Monto</label>
                                <input type="text" class="form-control" name="monto_aux" id="monto_aux" value="" placeholder="Ingrese monto" onkeypress="return validarDecimales(event, this)" maxlength="15">
                            </div>
                            </td>

                            </tr>
                            <tr>
                                <td colspan="3"><p class="max_msg" style="color: red;"></p><hr></td>
                            </tr>
                    </table>

                  
                    <div class="clear"></div>
                <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="descripcion">Capture Pago</label>
                            <div class="col-md-6">
                                <input type="file" id="capturepago" name="capturepago" class="form-control" placeholder="Ingrese la Descripción" >
                            </div>
                </div>
                </div>
      
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" id="btn_Validar" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
