<div class="form-group row">
        <label class="col-md-2 form-control-label" for="idnivelarticulo_create">Clientes</label>
    
        <div class="col-md-9">
    
            <select class="form-control selectpicker" name="cliente_create" id="cliente_create" data-live-search="true" required>
                                            
            <option value="">===Seleccione===</option>
            
            @foreach($clientes as $cli)
            <option value="{{$cli->id}}"> {{$cli->num_documento}} {{$cli->nombres}} {{$cli->apellidos}}</option>
            @endforeach
    
            </select>
    
        </div>
                                
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="titulo_create">Título</label>
        <div class="col-md-9">
            <textarea class="form-control" id="titulo_create" name="titulo_create" rows="3" maxlength="250" required></textarea>                       
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="idnivelibros_create">Nivel Artículo</label>
    
        <div class="col-md-9">
    
            <select class="form-control" name="idnivelibros_create" id="idnivelibros_create" required>
                                            
            <option value="">===Seleccione===</option>
            
            @foreach($niveleslibros as $niv)
            
            <option value="{{$niv->id}}"> {{$niv->nombre}} - {{$niv->descripcion}}</option>
                    
            @endforeach
    
            </select>
    
        </div>
                                
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="idtipoeditoriales_create">Tipo de libro</label>
    
        <div class="col-md-9">
    
            <select class="form-control" name="idtipoeditoriales_create" id="idtipoeditoriales_create" required>
            <option value="">===Seleccione===</option>
            
            @foreach($tipoeditoriales as $edito)
            
            <option value="{{$edito->id}}"> {{$edito->nombre}}</option>
                    
            @endforeach
    
            </select>
    
        </div>
                                
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="puntaje_create">Puntaje</label>
        <div class="col-md-9">
            <input type="text" id="puntaje_create" name="puntaje_create" class="form-control solo_numeros" placeholder="Ingrese el Puntaje" maxlength="3" required>
            
        </div>  
    </div>

    
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="archivoresumen_create">Archivo Resumen</label>
        <div class="col-md-9">
            <input id="archivoresumen_create" type="file" class="form-control" name="archivoresumen_create" onchange="ValidateDoc(this);" required>
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="archivoevaluador_create">Archivo Evaluador</label>
        <div class="col-md-9">
            <input id="archivoevaluador_create" type="file" class="form-control" name="archivoevaluador_create" onchange="ValidateDoc(this);">
        </div>  
    </div>
    <input id="file_value_hidden_create" type="hidden" class="form-control" name="file_value_hidden_create" value="noimagen.jpg">

    
                                


    <div class="form-group row">
    <label class="col-md-2 form-control-label" for="observaciones_create">Observación</label>
        <div class="col-md-9">
            <textarea class="form-control" id="observaciones_create" name="observaciones_create" rows="3" maxlength="250"></textarea>                       
        </div>
    </div>



    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button type="submit" class="btn btn-success" id="guardar_create_revision"><i class="fa fa-save"></i> Guardar</button>

    </div>
