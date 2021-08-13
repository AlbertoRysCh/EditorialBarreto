<div class="form-group row">
            <label class="col-md-2 form-control-label" for="documento">Tipo Documento</label>
            
            <div class="col-md-9">
            
                <select class="form-control" name="tipo_documento" id="tipo_documento">
                                                
                    <option value="0">Seleccione</option>
                    <option value="DNI">DNI</option>
                    <option value="CARNET DE EXTRANJERÍA">CARNET DE EXTRANJERÍA</option>
                    <option value="OTRO">OTRO</option>

                </select>
            
            </div>
                                       
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="num_documento">Número documento</label>
                <div class="col-md-9">
                    <input type="text" id="num_documento" name="num_documento" class="form-control" placeholder="Ingrese el número documento" pattern="[0-9]{0,15}">
                </div>
    </div>


    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Nombres</label>
                <div class="col-md-9">
                    <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Ingrese Nombres" >
                    
                </div>
    </div>
    
    
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Apellidos</label>
                <div class="col-md-9">
                    <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Ingrese Apellidos" >
                    
                </div>
    </div>


 
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="correocontacto">Correo Contacto</label>
                <div class="col-md-9">
                  
                <input type="email" class="form-control" id="correocontacto" name="correocontacto" placeholder="Ingrese el correo">
                       
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="telefono">Teléfono</label>
                <div class="col-md-9">
                  
                    <input type="text" id="telefono" name="telefono" class="form-control solo_numeros" placeholder="Ingrese el teléfono" maxlength="15">
                       
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="correogmail">Correo Gmail</label>
                <div class="col-md-9">
                    <input type="email" id="correogmail" name="correogmail" class="form-control" placeholder="Ingrese Correo Gmail">
                    
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="contrasena">Contraseña</label>
                <div class="col-md-9">
                    <input type="text" id="contrasena" name="contrasena" class="form-control" placeholder="Ingrese Contraseña">
                    
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="universidad">Universidad</label>
                <div class="col-md-9">
                  
                    <input type="text" id="universidad" name="universidad" class="form-control" placeholder="Ingrese la Universidad">
                       
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="orcid">ORCID</label>
                <div class="col-md-9">
                  
                    <input type="text" id="orcid" name="orcid" class="form-control" placeholder="Ingrese ORCID">
                       
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="especialidad">Especialidad</label>
                <div class="col-md-9">
                    <input type="text" id="especialidad" name="especialidad" class="form-control" placeholder="Ingrese Especialidad">
                    
                </div>
    </div>

    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="grado">Grado</label>
            
            <div class="col-md-9">
            
                <select class="form-control" name="id_grado" id="id_grado">
                                                
                <option value="0" >Seleccione</option>
                
                @foreach($grados as $gra)
                  
                   <option value="{{$gra->id}}">{{$gra->nombre}}</option>
                        
                @endforeach

                </select>
            
            </div>
                                       
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="imagen">Resumen</label>
                <div class="col-md-9">
                  
                    <input type="file" id="resumen" name="resumen" class="form-control">
                       
                </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        
    </div>