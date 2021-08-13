<div class="form-group row">
        
    <label class="col-md-2 form-control-label">N° de cuotas</label>
    <div class="col-md-4">
        <div class="onoffswitch">
            <input type="checkbox" name="check_cuotas" class="onoffswitch-checkbox" id="check_cuotas" value="0">
            <label class="onoffswitch-label" for="check_cuotas">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
    <input type="hidden" class="form-control" id="num_cuotas" name="num_cuotas" value="">
           
    </div>
</div>
<div class="div_agregar_cuotas" style="display:none;">
            <table id="regCuota" style="width:100%;">

                <tbody class="table_orden_trabajo">
                    <tr>
                    <td style="width: 50%;">
                    <div class="form-group ">
                        <label for="fecha_cuota_aux">Día</label>
                        <input type="text" class="form-control" name="fecha_cuota_aux" id="fecha_cuota_aux" value="" placeholder="Ingrese el día de la cuota" maxlength="3">
                    </div>
                    </td>
                    <td style="width: 50%;">
                    <div class="form-group ">
                        <label for="monto">Monto</label>
                        <input type="text" class="form-control" name="monto_aux" id="monto_aux" value="" placeholder="Ingrese monto" onkeypress="return validarDecimales(event, this)" maxlength="15">
                    </div>
                    </td>
                    <td>
                        <a type="button" style="margin-top: 12px;color: #fff;" class="btn btn-primary agregar_cuota" title="Agregar Cuota"> <span class="fa fa-plus"></span></a>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="3"><p class="max_msg" style="color: red;"></p></td>
                    </tr>
            </table>
            <div class="clear"></div>
</div>
