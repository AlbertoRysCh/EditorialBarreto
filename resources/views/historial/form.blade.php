<div class="form-group row">
                <div class="col-md-9">
                    <input type="hidden" id="prueba" readonly name="id_articulo" class="form-control" pattern="[0-9]{0,15}">
                </div>
</div>

<div class="form-group row">
                <label class="col-md-2 form-control-label" for="num_documento">Código</label>
                <div class="col-md-9">
                    <input type="text" id="codigo" readonly name="codigo" class="form-control" placeholder="Ingrese el codigo" pattern="[0-9]{0,15}">
                </div>
</div>
<div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Título</label>
                <div class="col-md-9">
                    <input type="text" id="titulo" readonly name="titulo" class="form-control" placeholder="Ingrese Título" >
                    
                </div>
</div>
<div class="form-group row">
            <label class="col-md-2 form-control-label" for="asesor">Asesores</label>
            
            <div class="col-md-9">
            
                <select class="form-control" name="id_asesor" id="id_asesor" data-live-search="true">
                                                
                <option value="0" >Seleccione</option>
                
                @foreach($asesores as $ase)
                   <option value="{{$ase->id}}">{{$ase->nombresasesor}}</option>
                @endforeach

                </select>
            
            </div>
                                       
    </div>
    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="grado">Status</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="status" id="status" data-live-search="true">
                                                
                <option value="0" >Seleccione</option>
                
                @foreach($status as $sta)
                  
                   <option value="{{$sta->id}}">{{$sta->nombre}}</option>
                        
                @endforeach

                </select>
            
            </div>

            <label class="col-md-2 form-control-label" for="grado">Clasificaciones</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="clasificacion" id="clasificacion" data-live-search="true">
                                                
                <option value="0" >Seleccione</option>
                
                @foreach($clasificaciones as $cla)
                  
                   <option value="{{$cla->id}}">{{$cla->nombre}}</option>
                        
                @endforeach

                </select>
            
            </div>
                                       
    </div>
    <div class="form-group row">
            <label class="col-md-2 form-control-label" for="grado">Revistas</label>
            
            <div class="col-md-4">
            
                <select class="form-control" name="revistas" id="revistas" data-live-search="true">
                                                
                <option value="0" >Seleccione</option>
                
                @foreach($editoriales as $re)
                  
                   <option value="{{$re->id}}" >{{$re->nombreseditoriales}}</option>
                        
                @endforeach

                </select>
            
            </div>

                                       
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="fechamovimiento">Fecha Movimiento</label>
                <div class="col-md-3">
                    <input type="text" id="fechamovimiento"  name="fechamovimiento" class="form-control" readonly>
                    
                </div>
                <label class="col-md-2 form-control-label" for="fechaorden">Fecha Orden</label>
                <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechaorden" id="fechaorden" placeholder="YYYY/MM/DD">
                    
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="fechallegada">Fecha Llegada</label>
                <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechallegada" id="fechallegada" placeholder="YYYY/MM/DD">
                    
                </div>
                <label class="col-md-2 form-control-label" for="fechaasignacion">Fecha Asignación</label>
                <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechaasignacion" id="fechaasignacion" placeholder="YYYY/MM/DD">
                    
                </div>
    </div>

    <div class="form-group row">
                 <label class="col-md-2 form-control-label" for="fechaculminacion">Fecha Culminación</label>
                <div class="col-md-3">
                    <input type="text" class="form-control datepicker" autocomplete="off" name="fechaculminacion" id="fechaculminacion" placeholder="YYYY/MM/DD">
                        
                </div>
                    <label class="col-md-2 form-control-label" for="fecharevisioninterna">Fecha Revisión Interna</label>
                <div class="col-md-3">
                    <input type="text" class="form-control datepicker" autocomplete="off" name="fecharevisioninterna" id="fecharevisioninterna" placeholder="YYYY/MM/DD">
                        
                </div>
    </div>



    <div class="form-group row">

                <label class="col-md-2 form-control-label" for="fechaenvioprodu">Fecha fin de Producción</label>
                <div class="col-md-3">
                    <input type="text" class="form-control datepicker" autocomplete="off" name="fechaenvioproduccion" id="fechaenvioproduccion" placeholder="YYYY/MM/DD">
                        
                </div>
                <label class="col-md-2 form-control-label" for="fechahabilitacion">Fecha Habilitacion</label>
                <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechahabilitacion" id="fechahabilitacion" placeholder="YYYY/MM/DD">
                    
                </div>

    </div>


    <div class="form-group row">

                <label class="col-md-2 form-control-label" for="fechaenvio">Fecha Envio </label>
                <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechaenvio" id="fechaenvio" placeholder="YYYY/MM/DD">
                    
                </div>
                <label class="col-md-2 form-control-label" for="fechaajustes">Fecha Ajustes de Árbitro</label>
                <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechaajustes" id="fechaajustes" placeholder="YYYY/MM/DD">
                    
                </div>
   
    </div>

    <div class="form-group row">

        <label class="col-md-2 form-control-label" for="nombre">Fecha Aceptacion</label>
            <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fechaaceptacion" id="fechaaceptacion" placeholder="YYYY/MM/DD">    
            </div>
        <label class="col-md-2 form-control-label" for="nombre">Fecha Rechazo </label>
            <div class="col-md-3">
                <input type="text" class="form-control datepicker" autocomplete="off" name="fecharechazo" id="fecharechazo" placeholder="YYYY/MM/DD">
                
            </div>
    </div>

<!--     <div class="form-group row">

    <div class="col-md-6">
    <label class="form-check-label" for="flexCheckDefault">
    Desea enviar cambios al Módulo Artículos
    </label>
            <select class="form-control" name="revistas" id="revistas" data-live-search="true">                              
            |<option value="0" >NO</option>
               <option value="1" >SI</option>  
            </select>
        </div>
    </div> -->

     <div class="form-check">
    <input class="form-check-input" name="terms" type="checkbox" value="1" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
    Desea enviar cambios al Módulo Artículos
    </label>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        
    </div>
    