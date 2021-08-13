

<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombre_contrato">Tipo Documento</label>
            <div class="col-md-4">
                <input type="text" value="{{$cliente->tipo_documento}}" name="tipodocumento" id="tipodocumento" class="form-control" placeholder="Ingrese Nombres"readonly>

            </div>
            <label class="col-md-2 form-control-label" for="apellidos_contrato">Numero Documento</label>
            <div class="col-md-4">
                <input type="text" id="numdocumento" value="{{$cliente->num_documento}}" name="numdocumento" class="form-control" placeholder="Ingrese Apellidos"readonly>
                
            </div>
</div>
<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombre_contrato">Nombres</label>
            <div class="col-md-4">
                <input type="text" id="nombres_contrato" value="{{$cliente->nombres}}" name="nombres_contrato" class="form-control" placeholder="Ingrese Nombres" readonly>
                <input type="hidden" id="nombres_contrato" value="{{$cliente->id}}" name="id_cliente" class="form-control">

            </div>
            <label class="col-md-2 form-control-label" for="apellidos_contrato">Apellidos</label>
            <div class="col-md-4">
                <input type="text" id="apellidos_contrato" value="{{$cliente->apellidos}}" name="apellidos_contrato" class="form-control" placeholder="Ingrese Apellidos" readonly>
                
            </div>
</div>
    
    
    <div class="form-group row">
        <label class="col-md-4 form-control-label" for="titulo_contrato">¿Es una OT que se le hizo Revisión Técnica?</label>
        <div class="col-md-2">
        <Select id="selectrevision" name="selectrevision">
            <option  value="">Seleccionar</option>
            <option value="si">Si</option>
            <option value="no">No</option>
        </Select>
        </div>
    </div> 
    
    <div class="form-group row muestra si" id="si" style="display:none">
        <label class="col-md-2 form-control-label" for="titulo_contrato">Título Artículo</label>
        <div class="col-md-10">
            <select class="form-control selectpicker" name="titulo_revision" id="titulo_contrato">
                        <option  value="">== Seleccione ==</option>
                        @foreach($listarevisiones as $list)
                        <option value="{{$list->id}}">{{$list->titulo}}</option>
                        @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row muestra no" id="no" style="display:none">
        <label class="col-md-2 form-control-label" for="titulo_contrato">Título Artículo</label>
        <div class="col-md-10">
        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ingrese el título">                
        </div>
    </div>


    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="contrato">Adjuntar Contrato</label>
        <div class="col-md-6">
            <input type="file" id="archivo" name="archivo" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="monto_total">Monto Total</label>
        <div class="col-md-4">
        
            <input type="text" id="monto_total" name="monto_total" class="form-control" placeholder="Monto total" required onkeypress="return validarDecimales(event, this)" maxlength="15">
            
        </div>   
        <label class="col-md-2 form-control-label" for="monto_inicial">Monto Inicial</label>
        <div class="col-md-4">
          
        <input type="text" class="form-control" id="monto_inicial" name="monto_inicial" placeholder="Monto inicial" required onkeypress="return validarDecimales(event, this)" maxlength="15">
               
        </div>    
    </div>

    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="Asesor_ventas">Asesor de Ventas</label>
                
            <div class="col-md-4">
                 <select class="form-control" name="id_asesor" id="id_asesor">
                    <option value="">== Seleccione ==</option>
                    @foreach($asesorventas as $asesor)
                    <option value="{{$asesor->usuario_id}}">{{$asesor->nombres}}</option>
                    @endforeach
                </select> 
            </div>

    </div>

    
    <div class="form-group muestra no" id="no" style="display:none">
            <label class="col-md-2 form-control-label" for="Productos">Producto</label>
                
            <div class="col-md-4">
                 <select class="form-control" name="idtipoeditoriales" id="idtipoeditoriales">
                    <option value="">== Seleccione ==</option>
                    @foreach($productos as $produ)
                    <option value="{{$produ->id}}">{{$produ->nombre}}</option>
                    @endforeach
                </select> 
            </div>

    </div>
    

    
    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button class="btn btn-success" id="guardar_contrato"><i class="fa fa-refresh"></i> Generar</button>

    </div>