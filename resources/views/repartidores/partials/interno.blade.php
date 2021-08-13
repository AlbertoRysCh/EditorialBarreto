{{-- Datos --}}
<div class="form-group row">
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            <strong>Información de registro:</strong> <br>
            N° Ticket <mark id="ticket" name="ticket"></mark><br>
            Código del cliente : <small id="codigo" name="codigo"></small><br>
            Documento: <small id="num_documento" name="num_documento"></small><br>
            Nombres : <small id="nombres" name="nombres"></small><br>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            <strong>Información de contacto:</strong><br>
            Dirección : <small id="direccion" name="direccion"></small><br>
            Teléfono : <small id="telefono" name="telefono"></small><br>
            Correo : <small id="correo" name="correo"></small><br>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            <strong>Información de pago:</strong><br>
            <strong>Método:</strong> <small id="metodo_pago" name="metodo_pago"></small><br>
            Total de servicio : <small class="text-success" id="total_servicio" name="total_servicio"></small><br>
            Total delivery : <small id="total_delivery" name="total_delivery"></small><br>
            <div class="section_efectivo">
            <strong>Efectivo</strong> : <small id="efectivo" name="efectivo"></small><br>
            Vuelto : <small class="text-danger" id="vuelto" name="vuelto"></small><br>
            </div>
            <hr>
            Total venta (Solo productos) : <small id="total_venta" name="total_venta"></small><br>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            <strong>Contiene producto frágil?</strong><br>
            <small id="is_fragil" name="is_fragil"></small>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">Tiempo estimado para el recojo del producto:
            <strong name="hora_estimada_recojo"></strong></p>
    </div>
</div>
{{-- Datos --}}
<hr>
<p class="text-primary text-uppercase text-center">Productos</p>
<div class="table-responsive">
    <table class="table data-detalles table-striped table-bordered nowrap">
        <input type="hidden" name="servicio_id" id="servicio_id">
        <thead>
            <tr>
                {{-- <th>Código</th>
                <th>Unidad</th> --}}
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Tienda</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                {{-- <th>Código</th>
                <th>Unidad</th> --}}
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Tienda</th>
            </tr>
        </tfoot>
    </table>
</div>
