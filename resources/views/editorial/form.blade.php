<style>

</style>
<div class="form-group row">
                <label class="col-md-2 form-control-label"  for="codigo">Codigo</label>
                <div class="col-md-4">
                    <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Ingrese el Codigo">
                    
                </div>  
                <label class="col-md-1 form-control-label" for="nombre">Nombre</label>
                <div class="col-md-4">
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el Nombre">
                    
                </div>
</div> 
    
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="descripcion">Descripcion</label>
                <div class="col-md-9">
                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingrese la Descripción" >
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="linea">Linea Investigación</label>
                <div class="col-md-9">
                    <input type="text" id="linea" name="linea" class="form-control" placeholder="Ingrese la Linea Investigación" >
                </div>
    </div>  

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Idioma</label>
                <div class="col-md-4">
                    <input type="text" id="idioma" name="idioma" class="form-control" placeholder="Ingrese el idioma">
                </div>
                <label class="col-md-1 form-control-label" for="nombre">País</label>
                <div class="col-md-4">
                    <input type="text" id="pais" name="pais" class="form-control" placeholder="Ingrese el País">
                    
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Enlace</label>
                <div class="col-md-4">
                    <input type="text" id="enlace" name="enlace" class="form-control" placeholder="Ingrese el enlace">
                </div>
                <label class="col-md-1 form-control-label" for="Periocidad">Periocidad</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="id_periodo" id="id_periodo">
                                                
                <option value="0">Seleccione</option>
                
                @foreach($periocidades as $pe)
                  
                   <option value="{{$pe->id}}">{{$pe->nombre}}</option>
                        
                @endforeach

                </select>
            
            </div>
    </div>
    
    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="Nivel">Nivel Index</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="id_nivel" id="id_nivel">
                                                
                <option value="0">Seleccione</option>
                
                @foreach($niveles as $ni)
                  
                   <option value="{{$ni->id}}">{{$ni->nombre}}</option>
                        
                @endforeach

                </select>
            
            </div>
            <label class="col-md-1 form-control-label" for="nombre">SJR</label>
                <div class="col-md-4">
                    <input type="text" id="sjr" name="sjr" class="form-control" placeholder="Ingrese el SJR">
                </div>
                                       
    </div>
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="codigo">CiteScore</label>
                <div class="col-md-4">
                    <input type="text" id="cites" name="cites" class="form-control" placeholder="Ingrese CiteScore">
                    
                </div>  
                <label class="col-md-1 form-control-label" for="nombre">Art. por número</label>
                <div class="col-md-4">
                    <input type="text" id="numero" name="numero" class="form-control" placeholder="Ingrese el número de articulo">
                    
                </div>
    </div>
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="codigo">%Review</label>
                <div class="col-md-4">
                    <input type="text" id="review" name="review" class="form-control" placeholder="Ingrese %review">
                    
                </div>  
                <label class="col-md-1 form-control-label" for="nombre">Tiempo respuesta</label>
                <div class="col-md-4">
                    <input type="text" id="tiempo" name="tiempo" class="form-control" placeholder="Ingrese el tiempo de respuesta">
                    
                </div>
    </div>
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="codigo">N° de Referencias</label>
                <div class="col-md-4">
                    <input type="text" id="referencias" name="referencias" class="form-control" placeholder="Ingrese %review">
                    
                </div>  
                <label class="col-md-1 form-control-label" for="nombre">%citados</label>
                <div class="col-md-4">
                    <input type="text" id="citados" name="citados" class="form-control" placeholder="Ingrese el %citados">
                    
                </div>
    </div>
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="codigo">Open Access</label>
                <div class="col-md-4">
                    <input type="text" id="open" name="open" class="form-control" placeholder="Ingresar Open Access">
                    
                </div>  
                <label class="col-md-1 form-control-label" for="nombre">Nivel Rechazo</label>
                <div class="col-md-4">
                    <input type="text" id="rechazo" name="rechazo" class="form-control" placeholder="Ingrese Nivel Rechazo">
                    
                </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
    </div>