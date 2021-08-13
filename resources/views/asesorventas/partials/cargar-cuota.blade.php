<div class="modal fade" id="modalCuotas" tabindex="-1" role="dialog" aria-labelledby="defaultModal">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{route('guardarcuota')}}" method="POST" name="defaultModalForm" id="defaultModalForm" onsubmit="return ValidateCuota();" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="idordentrabajo" id="idordentrabajo"/>
                <input type="hidden" name="action_asesor_venta" id="action_asesor_venta" value="1"/>
                <div class="modal-header cabeceramodal">
                    <h4 class="modal-title" id="defaultModalLabel">Registrar cuota
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Precio total</label>
                                <input type="text" name="precio" readonly class="form-control-plaintext" value="{{$ordentrabajo->precio}}">
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

                        <!--Inicio del modal agregar-->
        <div class="modal fade" id="abrirmodalfirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Adjuntar Firma</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            <form action="{{route('guardar.firma')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="imagen">Adjuntar</label>
                                    <div class="col-md-9">
                                        <input type="file" id="firma" name="firma" class="form-control">
                                        <input type="text" id="id_clientes" name="id_clientes" class="form-control">       
                                        <input type="hidden" id="idordentrabajo" name="idordentrabajo" class="form-control-plaintext" value="{{$ordentrabajo->idordentrabajo}}">

                                    </div>
                                 </div>  
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
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