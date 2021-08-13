<div class="row">
    <div class="custom-control custom-switch switch-lg custom-switch-success mr-2 mb-1">
        <p class="mb-0 text-uppercase text-muted"><strong>Tipo de servicio</strong></p>
        <input type="checkbox" class="custom-control-input" id="tipo_servicio" name="tipo_servicio" value="0">
        <label class="custom-control-label" for="tipo_servicio">
            <span class="switch-text-left">Interno</span>
            <span class="switch-text-right">Externo</span>
        </label>
    </div>
    <div class="custom-control custom-switch switch-lg custom-switch-success mr-2 mb-1">
        <p class="mb-0 text-uppercase text-muted"><strong>Contiene algún producto frágil?</strong></p>
        <input type="checkbox" class="custom-control-input" id="is_fragil" name="is_fragil" checked="checked" value="Sí">
        <label class="custom-control-label" for="is_fragil">
            <span class="switch-text-left">Sí</span>
            <span class="switch-text-right">No</span>
        </label>
    </div>
</div>
<div class="row">
    <div class="mr-2 mb-1 punto_recojo col-lg-12">
        <p class="mb-0 text-uppercase text-muted"><strong>Punto de recojo</strong></p>
        <select class="form-control select2" name="punto_recojo" id="punto_recojo">
            <option value="" selected>==Seleccione==</option>
            @foreach($tiendas as $item)
                <option value="{{$item->id}}">{{$item->descripcion}}</option>
            @endforeach
        </select>
    </div>

</div>

<section class="seccion_interna">

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="select_product">
                Productos:
            </label>
            <select class="select2-data-ajax" name="select_product" id="select_product">
                <option value="" selected></option>
            </select>
        </div>
    </div>
</div>
<hr>
<div class="table-responsive" style="border-radius: 3px">
    <input type="hidden" name="cant_lineas" id="cant_lineas" value=""> 
    <h4>Listas de Productos</h4>
    <table id="lista_producto" class="table table-hover table-striped" style="width:100%;">
        <thead>
            <tr class="bg-primary text-white">
                <th style="width: 10px;">Nº</th>
                <th style="display:none">Código</th>
                <th style="width: 50px;">Código</th>
                <th style="width: 100px;">Descripción</th>
                <th style="width: 50px;">Tienda</th>
                <th style="display:none;">Unidad</th>
                <th style="width: 50px;">Stock</th>
                <th style="width: 50px;">Cantidad</th>
                <th style="width: 50px;">Precio</th>
                <th style="width: 50px;">Importe</th>
                <th>Quitar</th>
            </tr>
        </thead>
            <tbody></tbody>

    </table>

</div>
@include('teleoperadores.partials.totales')
</section>
<section class="seccion_externa">
    <p class="mb-0 text-uppercase text-muted"><strong>Información de entrega</strong></p>
    <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <input type="text" name="direccion_empresa" id="direccion_empresa" class="form-control"
                placeholder="Dirección de origen">
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <input type="text" name="direccion_cliente" id="direccion_cliente" class="form-control"
                placeholder="Dirección de destino">
            <div class="help-block"></div></div>
        </div>
    </div>
    </div>
    <hr>
    <p class="mb-0 text-uppercase text-muted"><strong>Información cliente consumidor</strong></p>
    <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control solo_letras"
                placeholder="Nombre del cliente">
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <input type="text" name="correo_cliente" id="correo_cliente" class="form-control"
                placeholder="Correo del cliente">
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control mask-telefono"
                placeholder="Teléfono del cliente">
            <div class="help-block"></div></div>
        </div>
    </div>

    </div>
    <hr>
    <p class="mb-0 text-uppercase text-muted"><strong>Servicio</strong></p>
    <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <input type="text" name="servicio" id="servicio" class="form-control"
                placeholder="Servicio/Producto">
            <div class="help-block"></div></div>
        </div>
    </div>

    </div>
</section>
