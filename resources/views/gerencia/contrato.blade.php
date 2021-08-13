<div class="form-group row">
        <label class="col-md-2 form-control-label" for="codigo_revision_contrato">Código Revisión</label>
        <div class="col-md-10">
            <input type="text" id="codigo_contrato" name="codigo_revision_contrato" class="form-control" readonly>
            <input type="hidden" id="idgrado" name="idgrado" class="form-control" readonly>
        </div>  
    </div>

    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="titulo_contrato">Título Libro</label>
        <div class="col-md-10">
            <textarea class="form-control" id="titulo_contrato" name="titulo_contrato" rows="3" maxlength="250" readonly></textarea>                       
        </div>
    </div>


    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="tipo_documento_contrato">Tipo Documento</label>
                
            <div class="col-md-4">
                {{-- <select class="form-control" name="tipo_documento_contrato" id="tipo_documento_contrato" readonly>
                    <option disabled value="">== Seleccione ==</option>
                    @foreach($tipoDocumentos as $items)
                    <option value="{{$items->id}}">{{$items->nombre}}</option>
                    @endforeach
                </select> --}}
                <input type="text" id="tipo_documento_contrato" name="tipo_documento_contrato" class="form-control" readonly>
            </div>
            <label class="col-md-2 form-control-label" for="num_documento_contrato">Número documento</label>
            <div class="col-md-4">
                <input type="text" id="num_documento_contrato" name="num_documento_contrato" class="form-control" placeholder="Ingrese el número documento" pattern="[0-9]{0,15}" readonly>
            </div>

    </div>





<div class="form-group row">
            <label class="col-md-2 form-control-label" for="nombre_contrato">Nombres</label>
            <div class="col-md-4">
                <input type="text" id="nombres_contrato" name="nombres_contrato" class="form-control" placeholder="Ingrese Nombres" readonly>
                
            </div>
            <label class="col-md-2 form-control-label" for="apellidos_contrato">Apellidos</label>
            <div class="col-md-4">
                <input type="text" id="apellidos_contrato" name="apellidos_contrato" class="form-control" placeholder="Ingrese Apellidos" readonly>
                
            </div>
</div>
    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="correocontacto_contrato">Adjuntar Contrato</label>
        <div class="col-md-6">
            <input type="file" id="contrato" name="nombrecontrato" class="form-control">
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
            <label class="col-md-2 form-control-label" for="tipo_documento_contrato">Asesor de Ventas</label>
                
            <div class="col-md-4">
                 <select class="form-control" name="id_asesor" id="id_asesor">
                    <option disabled value="">== Seleccione ==</option>
                    @foreach($asesorventas as $asesor)
                    <option value="{{$asesor->usuario_id}}">{{$asesor->nombres}}</option>
                    @endforeach
                </select> 
            </div>

    </div>

    <div class="form-group row">
    
        {{-- <label class="col-md-2 form-control-label" for="precio_cuotas">De:</label> --}}
        <label class="col-md-12 form-control-label" for="precio_cuotas">Monto para subir el artículo científico en una revista indexada</label>
        <div class="col-md-4">
          
        <input type="text" class="form-control" id="precio_cuotas" name="precio_cuotas" placeholder="Monto" required value="0" onkeypress="return validarDecimales(event, this)" readonly>
               
        </div>
          
    </div>
    @include('gerencia.partials.cuotas')





    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button class="btn btn-success" id="guardar_contrato"><i class="fa fa-refresh"></i> Generar</button>

    </div>
