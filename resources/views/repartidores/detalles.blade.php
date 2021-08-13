<div id="modal-detalles" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title" id="myModalLabel160">Detalle servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="tipo_servicio" id="tipo_servicio">
                <section class="servicio_interno">
                    @include('repartidores.partials.interno')
                </section>
                <section class="servicio_externo">
                    @include('repartidores.partials.externo')
                </section>
            </div>
            <div class="modal-footer">
                <button id="btn_cancel_detalles" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
