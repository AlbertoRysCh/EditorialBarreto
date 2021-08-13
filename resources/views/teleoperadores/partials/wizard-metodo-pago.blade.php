<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            <label for="num_km">
                KM
            </label>
            <div class="controls">
                <input type="text" name="num_km" id="num_km" class="form-control" 
                placeholder="Kilómetros" onkeypress="return isNumberKey(this, event)" value="0">
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-1">
        <button type="button"
            class="btn btn-icon btn-flat-info mr-1 mb-1 waves-effect waves-light"
            data-toggle="popover"
            data-content="Se cobrará S/0.10 adicional por cada 100 metros.La longitud debe ser expresa en KM."
            data-trigger="hover"
            data-original-title="Kilómetro">
            <i class="feather icon-alert-circle"></i>
        </button>
    </div>
    <div class="col-sm-5">
        <div class="form-group">
            <label for="precio_base">
                Monto Base por KM
            </label>
            <div class="controls">
                <input type="text" name="precio_base" id="precio_base" class="form-control"
                placeholder="Precio base" value="6.00" readonly>
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-1">
        <button type="button"
            class="btn btn-icon btn-flat-info mr-1 mb-1 waves-effect waves-light"
            data-toggle="popover"
            data-content="Precio base son S/ 6.00 que corresponden a un recorrido entre 0.1 y 4 km."
            data-trigger="hover"
            data-original-title="Precio base">
            <i class="feather icon-alert-circle"></i>
        </button>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="payment_id">
                Método de pago
            </label>
            <select class="form-control select2" name="payment_id" id="payment_id" required>
                <option disabled value="" selected>== Seleccione ==</option>
                @forelse($metodoPago as $items)
                    <option value="{{$items->id}}">{{$items->nombre}}</option>
                @empty
                    Registre sus métodos de pago
                @endforelse
            </select>
        </div>
    </div>
    <div class="col-md-5 offset-md-1">
        <div class="form-group">
            <label for="total_servicio text-success">
                Total de servicio
            </label>
            <input type="text" class="form-control" id="total_servicio" name="total_servicio" readonly value="0.00">
            <input type="hidden" class="form-control" id="total_servicio_hide" readonly value="0.00">
        </div>

    </div>

    <div class="col-md-5 offset-md-6">
        <div class="form-group">
            <label for="total_delivery text-success">
                Total delivery
            </label>
            <input type="text" class="form-control" id="total_delivery" name="total_delivery" readonly value="0.00">
            <input type="hidden" class="form-control" id="total_delivery_hide" readonly value="0.00">
        </div>

    </div>
    <div class="col-md-5 offset-md-6">
        <div class="form-group">
            <label for="total_delivery text-success">
                Descuento delivery
            </label>
            <input type="text" class="form-control" id="descuento_servicio" name="descuento_servicio" value="0.00" onkeypress="return validarDecimales(event, this)">
        </div>

    </div>
    <div class="col-md-5 offset-md-6 mostrar_total_venta display_none">
        <div class="form-group">
            <label for="total_venta">
                Total de venta
            </label>
            <input type="text" class="form-control" id="total_venta" name="total_venta" readonly value="0.00">
        </div>

    </div>
    <div class="col-md-5 offset-md-6">
        <div class="form-group">
            <label for="observacion">
                Observaciones
            </label>
            <textarea class="form-control" name="observacion" rows="4" cols="50"></textarea>
        </div>
    </div>
</div>
<div class="row mostrar_efectivo display_none">
    <div class="col-md-5">
        <div class="form-group">
            <label for="efectivo">
                Efectivo:
            </label>
            <input type="text" class="form-control" id="efectivo" name="efectivo" value="0.00" onkeypress="return validarDecimales(event, this)">
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="vuelto">
                Vuelto:
            </label>
            <input type="text" class="form-control" id="vuelto" name="vuelto" value="0.00" readonly>
        </div>

    </div>
</div>
<div class="row mostrar_transferencia display_none">
<br>
    <p class="text-muted" style="font-size: 16px;">Formatos permitidos: JPG,PNG. Tamaño máximo: 1MB. Máximo de ancho de la imagen:700px</p>
    <input id="baucher-transferencia" name="baucher-transferencia" type="file" class="file">
<br>
<br>
</div>

