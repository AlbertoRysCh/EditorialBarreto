<div class="form-group row">
        <label class="col-md-2 form-control-label" for="codigo">Código</label>
        <div class="col-md-9">
            <input type="text" id="codigo" name="codigo" class="form-control" readonly>
            
        </div>  
    </div>

    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="titulo">Título</label>
        <div class="col-md-9">
            <textarea class="form-control" id="titulo" name="titulo" rows="3" maxlength="250" required></textarea>                       
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="nivel">Nivel Artículo</label>
    
        <div class="col-md-9">
    
            <select class="form-control" name="idnivelarticulo" id="idnivelarticulo" required>
                                            
            <option value="">Seleccione</option>
            
            @foreach($niveleslibros as $niv)
            
            <option value="{{$niv->id}}"> {{$niv->nombre}} - {{$niv->descripcion}}</option>
                    
            @endforeach
    
            </select>
    
        </div>
                                
    </div>
    
    <div class="form-group row">
        <label class="col-md-2 form-control-label" for="puntaje">Puntaje</label>
        <div class="col-md-9">
            <input type="text" id="puntaje" name="puntaje" class="form-control solo_numeros" placeholder="Ingrese el Puntaje" maxlength="3" required>
            
        </div>  
    </div>

    {{-- @if (Auth::user()->idrol ==7) 

    <div class="form-group row">
    <label class="col-md-2 form-control-label" for="nivel">Nivel Articulos</label>

    <div class="col-md-9">

        <select class="form-control" name="id_nivel" id="id_nivel">
                                        
        <option value="4">Seleccione</option>
        
        @foreach($niveleslibros as $niv)
        
        <option value="{{$niv->id}}"> {{$niv->nombre}}</option>
                
        @endforeach

        </select>

    </div>
                            
    </div>
    @endif --}}

    <div class="form-group row">
    <label class="col-md-2 form-control-label" for="observaciones">Observación</label>
        <div class="col-md-9">
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" maxlength="250"></textarea>                       
        </div>
    </div>



    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    <button type="submit" class="btn btn-success" id="guardar_revision"><i class="fa fa-save"></i> Guardar</button>

    </div>
