<form action="{{route('servicio.externo')}}" id="formClienteExterno" type="POST">
    {{csrf_field()}}
<div class="form-group row">
    <div class="col-md-6">
        {{-- Origen --}}
        <p class="text-justify text-bold-400">
            <strong>Información de origen:</strong> <br>
            N° Ticket <mark name="ticket"></mark><br>
            Nombres : <small id="nombres" name="nombres"></small><br>
            Documento: <small id="num_documento" name="num_documento"></small><br>
            Código de pedido: <mark name="codigo_pedido"></mark><br>

        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            Teléfono : <small id="telefono" name="telefono"></small><br>
            Correo : <small id="correo" name="correo"></small><br>
            Dirección : <small id="direccion_empresa" name="direccion_empresa"></small><br>
        </p>
    </div>
    {{-- Destino --}}
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            <strong>Información de destino:</strong> <br>
            Nombres : <small id="nombre_cliente" name="nombre_cliente"></small><br>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            Teléfono : <small id="telefono_cliente" name="telefono_cliente"></small><br>
            Correo : <small id="correo_cliente" name="correo_cliente"></small><br>
            Dirección : <small id="direccion_cliente" name="direccion_cliente"></small><br>
        </p>
    </div>
    {{-- Servicio --}}
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            <strong>Información del servicio:</strong><br>
            Servicio: <small id="servicio_cliente" name="servicio_cliente"></small><br>
            <strong>Contiene producto frágil?</strong><br>
            <small id="is_fragil" name="is_fragil"></small>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">
            Método: <small id="metodo_pago" name="metodo_pago"></small><br>
            Total de servicio : <small id="total_servicio" name="total_servicio"></small><br>
            <strong>Total delivery :</strong> <small class="text-success" id="total_delivery" name="total_delivery"></small>
            <hr>
            Efectivo : <small id="efectivo" name="efectivo"></small><br>
            Vuelto : <small id="vuelto" name="vuelto"></small><br>
        </p>
    </div>
    <div class="col-md-6">
        <p class="text-justify text-bold-400">Tiempo estimado para el recojo del producto:
            <strong name="hora_estimada_recojo"></strong></p>
    </div>
</div>
</form>
<div class="loader-externo">
    <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
        Cargando Información...
    </button>
</div>