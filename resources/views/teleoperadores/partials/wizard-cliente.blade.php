<div class="form-group" style="display: none">
    <label>Ticket #: </label>
    <input type="text" id="ticket" name="ticket" class="form-control" readonly>
</div>
<div class="row">
<div class="col-md-6">
    <div class="form-group">
        <label for="cliente_id">
            Clientes:
        </label>
        <select class="form-control required select2"  name="cliente_id" id="cliente_id">
            <option value="" selected>== Seleccione ==</option>
            @forelse($clientes as $items)
                <option value="{{$items->id}}">{{$items->num_documento}} - {{$items->nombres_rz}} - {{$items->empresa}}</option>
            @empty
                Registre sus clientes
            @endforelse
        </select>
    </div>
</div>

<div class="col-md-1">
    <span class="show_wait_load display_none" style="font-size: xxx-large;">
        <div class="text-center">
                    <button class="btn btn-success" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
        </div>
    </span>
</div>
<div class="col-md-2">
    <div class="form-group">
        <mark>Estado cliente</mark>
        <p class="text-uppercase text-bold-600" id="estado_cliente" name="estado_cliente"></p>
        {{-- <input type="text" class="form-control" id="estado_cliente" name="estado_cliente" readonly> --}}
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <mark>Empleado</mark>
        <p class="text-uppercase text-bold-600" id="is_empleado" name="is_empleado"></p>
    </div>
</div>
</div>
<mark>Empresa:</mark>
<p class="text-uppercase text-bold-600" id="getEmpresa" name="getEmpresa"></p>
<div class="row">
<div class="col-md-6">
    <div class="form-group">
        <label for="tipo_documento">
            Tipo documento
        </label>
        <input type="text" class="form-control" id="tipo_documento" name="tipo_documento" readonly>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="num_documento">
            Número documento
        </label>
        <input type="hidden" class="num_documento_hidden" readonly>
        <input type="text" class="form-control solo_numeros validar_num_documento" id="num_documento" name="num_documento">
    </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
    <div class="form-group">
        <label for="nombres">
            Nombres
        </label>
        <input type="text" class="form-control" id="nombres" name="nombres">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="direccion">
            Dirección
        </label>
        <input type="text" class="form-control" id="direccion" name="direccion">
    </div>
</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="correo">
                Correo
            </label>
            <input type="text" class="form-control" id="correo" name="correo">
        </div>
    </div>

<div class="col-md-6">
    <div class="form-group">
        <label for="telefono">
            Teléfono
        </label>
        <input type="text" class="form-control" id="telefono" name="telefono">
    </div>
</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">
                Estado
            </label>
            <input type="text" class="form-control" id="estado" name="estado" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">
                Persona de contacto
            </label>
            <input type="text" class="form-control" id="persona_contacto" name="persona_contacto" maxlength="100">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">
                Código de pedido
            </label>
            <input type="text" class="form-control" id="codigo_pedido" name="codigo_pedido" maxlength="50">
        </div>
    </div>
</div>
