<div id="codigo_prospecto" class="form-group row" style="display: none">
            <label class="col-md-2 form-control-label" for="codigo">Código</label>
            <div class="col-md-10">
                <input type="text" id="codigo" name="codigo" class="form-control" readonly>
            </div>
        </div>
        <input type="hidden" name="asesor_venta_id" id="asesor_venta_id" readonly>


        <div class="form-group row">
                <label class="col-md-2 form-control-label" for="tipo_documento">Tipo Documento</label>
                    
                <div class="col-md-4">
                    <select class="form-control" name="tipo_documento" id="tipo_documento" required>
                        <option disabled value="">== Seleccione ==</option>
                        @foreach($tipoDocumentos as $items)
                        <option value="{{$items->id}}">{{$items->nombre}}</option>
                        @endforeach
                    </select>
                
                </div>
                <label class="col-md-2 form-control-label" for="num_documento">Número documento</label>
                <div class="col-md-4">
                    <input type="hidden" class="num_documento_hidden" readonly>
                    <input type="text" id="num_documento" name="num_documento" class="form-control validar_num_documento solo_numeros" placeholder="Ingrese el número documento" required minlength="8" maxlength="15">
                </div>

        </div>


  
    
    
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Nombres</label>
                <div class="col-md-4">
                    <input type="text" id="nombres" name="nombres" class="form-control solo_letras" placeholder="Ingrese Nombres" required maxlength="70">
                    
                </div>
                <label class="col-md-2 form-control-label" for="nombre">Apellidos</label>
                <div class="col-md-4">
                    <input type="text" id="apellidos" name="apellidos" class="form-control solo_letras" placeholder="Ingrese Apellidos" maxlength="70">
                    
                </div>
    </div>
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="aviso_id">Aviso</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="aviso_id" id="aviso_id" required>
                    <option disabled value="">== Seleccione ==</option>
                        @foreach($avisos as $items)
                        @if($items->estado == 1)
                        <option value="{{$items->id}}">{{$items->codigo}} - {{$items->nombre}}</option>
                        @endif
                        @endforeach
                </select>
            
            </div>
            <label class="col-md-2 form-control-label" for="correocontacto">Correo Contacto</label>
            <div class="col-md-4">
              
            <input type="email" class="form-control" id="correocontacto" name="correocontacto" placeholder="Ingrese el correo">
                   
            </div>                     
        </div>

 


        <div class="form-group row">
                    <label class="col-md-2 form-control-label" for="telefono">Teléfono</label>
                    <div class="col-md-4">
                    
                        <input type="text" id="telefono" name="telefono" class="form-control solo_numeros" placeholder="Ingrese el teléfono" maxlength="15">
                        
                    </div>
                    <label class="col-md-2 form-control-label" for="correogmail">Correo Gmail</label>
                    <div class="col-md-4">
                        <input type="email" id="correogmail" name="correogmail" class="form-control" placeholder="Ingrese Correo Gmail">
                        
                    </div>
        </div>



        <div class="form-group row">
                    <label class="col-md-2 form-control-label" for="contrasena">Contraseña</label>
                    <div class="col-md-4">
                        <input type="text" id="contrasena" name="contrasena" class="form-control" placeholder="Ingrese Contraseña">
                    </div>
                    <label class="col-md-2 form-control-label" for="universidad">Universidad</label>
                    <div class="col-md-4">
                    
                        <input type="text" id="universidad" name="universidad" class="form-control" placeholder="Ingrese la Universidad">
                        
                    </div>
        </div>



        <div class="form-group row">
                    <label class="col-md-2 form-control-label" for="orcid">ORCID</label>
                    <div class="col-md-4">
                    
                        <input type="text" id="orcid" name="orcid" class="form-control" placeholder="Ingrese ORCID">
                        
                    </div>
                    <label class="col-md-2 form-control-label" for="especialidad">Especialidad</label>
                    <div class="col-md-4">
                        <input type="text" id="especialidad" name="especialidad" class="form-control" placeholder="Ingrese Especialidad">
                        
                    </div>
        </div>

 

    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="idgrado">Grado</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="idgrado" id="idgrado" required>

                <option disabled value="">== Seleccione ==</option>
                @foreach($grados as $items)
                  
                  <option value="{{$items->id}}">{{$items->nombre}}</option>
                       
               @endforeach
                </select>
            
            </div>
            <label class="col-md-2 form-control-label" for="zona_id">Zona venta</label>
            <div class="col-md-4">
                <select class="form-control" name="zona_id" id="zona_id" required>
                <option disabled value="">== Seleccione ==</option>
                @foreach($zonaVenta as $items)
                <option value="{{$items->id}}">{{$items->descripcion}}</option>
                @endforeach
                </select>
            
            </div>
                                       
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="submit" class="btn btn-success btn_cliente"><i class="fa fa-save"></i> Guardar</button>
        
    </div>
