<div class="modal fade" id="cobrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <h5 class="modal-title" id="exampleModalLabel">Cobrar multiples pagos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('multiplespagos.store')}}" method="POST" autocomplete="off" id="form_multiple_pagos">
                    {{csrf_field()}}
                    <div class="form-group">
                        <strong><label>Total: </label></strong>
                        <span class="total_a_cobrar text-success"></span>
                    </div>
                    <input type="hidden" name="total_a_cobrar" value="" readonly>
                  
                    <div class="form-group row">
                        <label class="col-md-12 form-control-label">N° de ticket de servicio(s) a cobrar</label>
                        <div class="col-md-12">
                            <textarea name="ticket_servicios" id="ticket_servicios" cols="60" rows="3" readonly></textarea>
                        </div>
                    </div>
             
        
            </form>
        </div>
        <div class="modal-footer">
            @include('layouts.partials.gif_loading')
            <div class="actions" style="display: block">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success" id="btn-send-multiple">Aceptar</button>
            </div>
        </div>
      </div>
    </div>
  </div>

