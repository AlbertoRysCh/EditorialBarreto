<div class="modal fade" id="modalCuotas" tabindex="-1" role="dialog" aria-labelledby="defaultModal">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{route('guardarcuota')}}" method="POST" name="defaultModalForm" id="defaultModalForm" onsubmit="return ValidateCuota();">
                {{csrf_field()}}
                <input type="hidden" name="idordentrabajo" id="idordentrabajo"/>
                <div class="modal-header cabeceramodal">
                    <h4 class="modal-title" id="defaultModalLabel">Registrar cuota
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group ">
                            <label>Código</label>
                            <input class="form-control" type="text" id="codigo" name="codigo" disabled ></h4>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" disabled>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Precio total</label>
                                <input type="text" class="form-control" id="precio" name="precio" disabled>
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
                            <div class="form-group ">
                                <label for="fecha_cuota_aux">Fecha de cuota</label>
                                <input type="text" class="form-control datepicker" name="fecha_cuota_aux" id="fecha_cuota_aux" value="{{date('Y-m-d')}}" placeholder="MM/DD/YYYY" maxlength="10">
                            </div>
                            </td>
                            <td style="width: 50%;">
                            <div class="form-group ">
                                <label for="monto">Monto</label>
                                <input type="text" class="form-control" name="monto_aux" id="monto_aux" value="" placeholder="Ingrese monto" onkeypress="return validarDecimales(event, this)" maxlength="15">
                            </div>
                            </td>
                            <td>
                                <button style="margin-top: 12px;" class="btn btn-primary agregar_cuota" title="Agregar Cuota"> <span class="fa fa-plus"></span></button>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="3"><p class="max_msg" style="color: red;"></p><hr></td>
                            </tr>
                    </table>
                    <div class="clear"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function ValidateCuota() {
        var lengthRows = $('.cuotaFila', $("#regCuota")).length;
        var mensaje = "Debe ingresar al menos una fecha y monto de la cuota";
        if(lengthRows == 0){
            mostrarMensajeInfo(mensaje);
            return false;
        }
    }
</script>
