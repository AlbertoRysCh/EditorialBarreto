@extends('layouts.app')
@section('content')
<main class="main">
 

 <div class="card-body">
    <input type="hidden" id="idusuario" readonly class="form-control" value="{{$usuario}}">                

    <form action="{{route('librosinvestigacion.update',$libros)}}" id="formularioarticulo" method="POST" enctype="multipart/form-data">
    {{method_field('patch')}}
    {{csrf_field()}}
<a href="{{ url('/librosinvestigacion')}}">
                                       <button type="button" class="btn btn-danger btn-sm">
                                         <i class="fa fa-arrow-left"></i> Regresar
                                       </button> &nbsp;
                                    </a>

                                    
            <br>
            <br>
            <h5>Modificar Libros</h5>
            <br>
            <br>
                <div class="col-md-2">  
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$listalibros->idlibros}}">                
                        <input type="hidden" id="idusuario" name="idusuario" class="form-control" value="{{$usuario}}">                

                 </div>
            <div class="form-group row">

                <div class="col-md-2">  

                        <label class="form-control-label" for="codigo">Codigo</label>
                        <input type="text" id="codigo" readonly name="codigo" class="form-control" placeholder="Ingrese Código de Orden" value="{{$listalibros->codigo}}">                

                 </div>

                 <div class="col-md-6">  

                        <label class="form-control-label" for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ingrese el título" value="{{$listalibros->titulo}}" required>                

                </div>

                <div class="col-md-2">  
                        <label class="form-control-label" for="area">Área</label>
                        <select class="form-control selectpicker" name="area" id="area" data-live-search="true" required>                                                      
                            <option value="0" disabled>Seleccione</option>
                            @foreach($areas as $area)
                            <option value="{{$area->id}}" {{$area->id == $listalibros->idareas ? 'selected' : '' }} >{{$area->nombresareas}}</option>
                            @endforeach    
                        </select>

                </div>

                
                <div class="col-md-2">  

                        <label class="form-control-label  " for="tipo_libros">Tipo de Libro</label>
                        
                        <select class="form-control selectpicker" name="tipo_articulo"  id="tipo_articulo" value="{{$listalibros->nombretipos}}"  data-live-search="true">
                            @foreach($tipolibros as $tipo)
                            <option value="{{$tipo->id}}" {{$tipo->id == $listalibros->idtipos ? 'selected' : '' }}>{{$tipo->nombre}}</option>
                            @endforeach    
                        </select>
                </div>

            </div>

            <div class="form-group row">

                
                <div class="col-md-2">  

                        <label class="form-control-label" for="tipo_articulos">Nivel Libro</label>
                        
                        <select class="form-control selectpicker" name="nivel_articulo" id="nivel_articulo" value="{{$listalibros->nombreniveles}}" data-live-search="true">
                            @foreach($niveleslibros as $nivel)
                            <option value="{{$nivel->id}}" {{$nivel->id == $listalibros->idniveles ? 'selected' : '' }}>{{$nivel->nombre}}</option>
                            @endforeach    
                        </select>
                </div>

                <div class="col-md-2">  

                        <label class="form-control-label" for="editorial">Editorial</label>
                        
                        <select class="form-control selectpicker" name="editorial" id="editorial"  value="{{$listalibros->nombreeditoriales}}" data-live-search="true">
                            @foreach($editoriales as $rev)
                            <option value="{{$rev->id}}" {{$rev->id == $listalibros->ideditoriales ? 'selected' : '' }} >{{$rev->nombreseditoriales}}</option>
                            @endforeach
                        </select>
                </div>

                <div class="col-md-2">  

                        <label class="form-control-label" for="tipo_articulos">Asesor</label>
                        
                        <select class="form-control selectpicker" name="asesor" id="asesor" value="{{$listalibros->nombresasesor}}" data-live-search="true">
                            @foreach($asesores as $ase)
                            <option value="{{$ase->id}}" {{$ase->id == $listalibros->idsasesor ? 'selected' : '' }}>{{$ase->nombresasesor}}</option>
                            @endforeach    
                        </select>
                        <input type="hidden" readonly id="asesorselect" name="asesorselect" class="form-control" value="{{$listalibros->idsasesor}}">                

                </div>     
                
                <div class="col-md-2">  
                    <label class="form-control-label" for="fechaorden">Fecha Orden</label>
                    <input type="text" readonly class="form-control" name="fechaorden" autocomplete="off" value="{{$listalibros->fechaOrden}}" id="fechaorden" placeholder="YYYY/MM/DD">

                </div>      

                <div class="col-md-2">  
                <label class="form-control-label" for="fechallegada">Fecha Llegada</label>
                <input type="text" readonly class="form-control" name="fechallegada" autocomplete="off" value="{{$listalibros->fechaLlegada}}" id="fechallegada" placeholder="YYYY/MM/DD">

                </div>

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechallegada">Fecha Asignación</label>
                    <input type="text" class="form-control datepicker" name="fechaasignacion" autocomplete="off" value="{{$listalibros->fechaAsignacion}}" id="fechaasignacion" placeholder="YYYY/MM/DD">


                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechallegada">Fecha Culminación</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" id="fechaculminacion" value="{{$listalibros->fechaCulminacion}}" name="fechaculminacion" placeholder="YYYY/MM/DD">
                </div>

                <div class="col-md-2">  
                <label class="form-control-label" for="fechaEnvioPro">Fecha fin Producción</label>
                <input type="text" class="form-control datepicker" id="fechaenviopro" autocomplete="off" name="fechaenviopro" value="{{$listalibros->fechaEnvioPro}}" placeholder="YYYY/MM/DD">
                </div>

                <div class="col-md-2">  
                <label class="form-control-label" for="fechallegada">Fecha Habilitación</label>
                <input type="text" class="form-control datepicker" id="fechahabilitacion" autocomplete="off" value="{{$listalibros->fechaHabilitacion}}" name="fechahabilitacion" placeholder="YYYY/MM/DD">
                </div>

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechainicorre">Fecha de Inicio C.E</label>
                    <input type="text" class="form-control datepicker" id="fechainicorre" autocomplete="off" value="{{$listalibros->fechaIniCorre}}" name="fechainicorre" placeholder="YYYY/MM/DD">
                </div>

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechafincorre">Fecha de Fin C.E</label>
                    <input type="text" class="form-control datepicker" id="fechafincorre" autocomplete="off" value="{{$listalibros->fechaFinCorre}}" name="fechafincorre" placeholder="YYYY/MM/DD">
                </div>

                <div class="col-md-2">  
                    <label class="form-control-label" for="fecharevision interna">Fecha Revisión</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" id="fecharevisioninterna" value="{{$listalibros->fechaRevisionInterna}}" name="fecharevisioninterna" placeholder="YYYY/MM/DD">
                </div> 

            </div>

            <div class="form-group row">
                
                <div class="col-md-2">  
                    <label class="form-control-label" for="fechallegada">Fecha Envío</label>
                    <input type="text" class="form-control datepicker" name="fechaenvio" autocomplete="off" value="{{$listalibros->fechaEnvio}}" id="fechaenvio" placeholder="YYYY/MM/DD">
                </div>
            

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechallegada">Fecha Aceptación</label>
                    <input type="text" class="form-control datepicker" id="fechaaceptacion" autocomplete="off" value="{{$listalibros->fechaAceptacion}}" name="fechaaceptacion" placeholder="YYYY/MM/DD">
                </div>
            
                <div class="col-md-2">  
                    <label class="form-control-label" for="fecharechazo">Fecha Rechazo</label>
                    <input type="text" class="form-control datepicker" id="fecharechazo" autocomplete="off" value="{{$listalibros->fechaRechazo}}" name="fecharechazo" placeholder="YYYY/MM/DD">
                </div>

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechaajustes">Fecha Ajustes</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" value="{{$listalibros->fechaAjustes}}" id="fechaajustes"  name="fechaajustes" placeholder="YYYY/MM/DD">
                </div>

                
                
                <div class="col-md-2">  
                    <label class="form-control-label " for="clasificacion">Actividad</label>
                    <select class="form-control selectpicker" name="clasificacion" autocomplete="off"  value="{{$listalibros->nombreclasificaciones}}" id="clasificacion" data-live-search="true">
                        @foreach($clasificaciones as $cla)
                        <option value="{{$cla->id}}" {{$cla->id == $listalibros->idclasificacion ? 'selected' : '' }}>{{$cla->nombre}}</option>
                        @endforeach    
                    </select>
                    <input type="hidden" readonly id="clasificacionselect" name="clasificacionselect" class="form-control" value="{{$listalibros->idclasificacion}}">                

                </div>

                <div class="col-md-2">  
                        <label class="form-control-label" for="statu">Estado</label>                        
                        <select class="form-control selectpicker" name="statu" autocomplete="off" value="{{$listalibros->nombrestatus}}"  id="statu" data-live-search="true">
                            @foreach($status as $sta)
                            <option value="{{$sta->id}}" {{$sta->id == $listalibros->idstatus ? 'selected' : '' }}>{{$sta->nombre}}</option>
                            @endforeach    
                        </select>
                </div>

                
                <input type="hidden" readonly id="statusselect" name="statusselect" class="form-control" value="{{$listalibros->idstatus}}">                
                
               
            </div>
          
            <div class="form-group row">

            <div class="col-md-2">  
                        <label class="form-control-label" for="carta">Carta</label>
                        <input type="text" id="carta" name="carta" class="form-control" value="{{$listalibros->carta}}" placeholder="Ingrese Carta" >                
                </div>
                                            
                <div class="col-md-2">  

                        <label class="form-control-label " for="modalidad">Modalidad</label>
                        
                        <select class="form-control selectpicker" name="modalidad"  value="{{$listalibros->nombresmodalidades}}" id="modalidad" data-live-search="true">
                            @foreach($modalidades as $moda)
                            <option value="{{$moda->id}}" {{$moda->id == $listalibros->idmodalidades ? 'selected' : '' }}>{{$moda->nombre}}</option>
                            @endforeach    
                        </select>
                </div>
                @if (Auth::id() == 9 or Auth::id() == 17 or Auth::id() == 1 or  Auth::id() == 40 or  Auth::id() == 57 or Auth::id() == 59)
            <div class="col-md-2">  
                <label class="form-control-label" for="user">Usuario</label>
                <input type="text" id="user" name="user" class="form-control" value="{{$listalibros->usuario}}" placeholder="Ingrese el Usuario" >                
            </div>

            <div class="col-md-2">  
                <label class="form-control-label" for="usuario">Contraseña</label>
                <input type="text" id="contrasenna" name="contrasenna" class="form-control"  value="{{$listalibros->contrasenna}}" placeholder="Ingrese la Contraseña" >                
            </div>
                @endif
                <div class="col-md-2">  
                    <label class="form-control-label " for="pais">País</label>
                        <select class="form-control selectpicker" name="pais"value="{{$listalibros->pais}}"  id="pais" data-live-search="true">
                            <option value="">Seleccione</option>
                            <option value="Perú" {{$listalibros->pais == "Perú" ? 'selected' : '' }}>Perú</option>
                            <option value="Colombia" {{$listalibros->pais == "Colombia" ? 'selected' : '' }}>Colombia</option>
                        </select>
                </div>

                <div class="col-md-2" id="print">
                    <label class="form-control-label " for="modalidad">Print</label>
                    <input type="file" id="archivo" name="archivo" class="form-control">     
                </div>
    
            </div>

          <div class="form-group row">

            <div class="col-md-4">  
                <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observación</label>
                        <textarea class="form-control" id="observacion"  name="observacion" rows="3">{{$listalibros->observacion}}</textarea>
                </div>
                
                <div class="form-check">
                 <input class="form-check-input" type="checkbox" value="1" id="checkbox" onchange="javascript:showContent()">
                 <label class="form-check-label" for="flexCheckDefault">
                    <b>Agregar Estadistica</b>
                 </label>
                </div> 
            </div>

          </div>

          <div id="estadistica" class="form-group row border" style="display: none;">
          
          <div class="table-responsive col-md-11">
          <table id="detalles" class="table table-bordered table-striped table-sm">
                <tbody>
                  @foreach($detalles as $det)
                  <tr>
                  <h5 style="margin-left: 18px">Estadística</h5>
                  <td>
                  <div class="col-md-12">  
                    <label class="form-control-label" for="fechaasignacion">Fecha Asignación</label>
                    <input type="text" class="form-control datepicker" name="fechaenvio" autocomplete="off" value="{{$listalibros->fechaEnvio}}" id="fechaenvio" placeholder="YYYY/MM/DD">
                  </div>
                  </td>
                  <td>
                  <div class="col-md-12">  
                    <label class="form-control-label" for="fechaculminacion">Fecha Culminación</label>
                    <input type="text" class="form-control datepicker" name="fechaenvio" autocomplete="off" value="{{$listalibros->fechaEnvio}}" id="fechaenvio" placeholder="YYYY/MM/DD">
                  </div>
                  </td>
                  <td>
                  <div class="col-md-12">  
                        <label class="form-control-label" for="clasificacion">Clasificación</label>                        
                        <select class="form-control selectpicker" name="clasificacion" autocomplete="off" value="{{$listalibros->nombrestatus}}"  id="clasificacion" data-live-search="true">
                            @foreach($status as $sta)
                            <option value="{{$sta->id}}" {{$sta->id == $listalibros->idstatus ? 'selected' : '' }}>{{$sta->nombre}}</option>
                            @endforeach    
                        </select>
                  </div>
                  </td>
                  <td>
                   <div class="col-md-12">  
                        <label class="form-control-label" for="statu">Status</label>                        
                        <select class="form-control selectpicker" name="statu" autocomplete="off" value="{{$listalibros->nombrestatus}}"  id="statu" data-live-search="true">
                            @foreach($status as $sta)
                            <option value="{{$sta->id}}" {{$sta->id == $listalibros->idstatus ? 'selected' : '' }}>{{$sta->nombre}}</option>
                            @endforeach    
                        </select>
                   </div>
                  </td>
                  </tr> 
                  @endforeach
                </tbody>
          </table>
          </div>
          </div>

            @if (Auth::id() == 3 or Auth::id() == 56  or Auth::id() == 3)

             <div class="form-group row border">

              <h5 style="margin-left: 20px">Autoresaa en Libros</h5>

              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class=" bordearriba">
                        <th>Especialidad</th>
                        <th>Apellidos Nombres</th>
                        <th>DNI/C.C</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($detalles as $det)
                <tr>
                <td>{{$det->especialidad}}</td>
                <td>{{$det->nombres}} {{$det->apellidos}}</td>
                <td>{{$det->num_documento}}</td>
                </tr> 
                @endforeach
                </tbody>
                </table>
              </div>
            </div> 
            @endif

            @if (Auth::id() == 9 or Auth::id() == 17 or Auth::id() == 27 or Auth::id() == 45  or Auth::id() == 1 or  Auth::id() == 40 or  Auth::id() == 57 or Auth::id() == 59)

            <div class="form-group row border">

              <h5 style="margin-left: 20px">Autores en Libros</h5>

              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead class="tablas">
                    <tr class=" bordearriba">
                        <th>Especialidad</th>
                        <th>Apellidos Nombres</th>
                        <th>DNI/C.C</th>
                        <th>Afiliación</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Orcid ID</th>
                        <th>Correo Gmail</th>
                        <th>Contraseña</th>

                    </tr>
                </thead>
                
                <tbody>
                @foreach($detalles as $det)

                <tr>
                <td>{{$det->especialidad}}</td>
                <td>{{$det->nombres}} {{$det->apellidos}}</td>
                <td>{{$det->num_documento}}</td>
                <td>{{$det->universidad}}</td>
                <td>{{$det->correocontacto}}</td>
                <td>{{$det->telefono}}</td>
                <td>{{$det->orcid}}</td>
                <td>{{$det->correogmail}}</td>
                <td>{{$det->contrasena}}</td>


                </tr> 
                @endforeach
                </tbody>
                
                </table>
              </div>
            
            </div>
            @endif
                        <div class="modal-footer form-group row" id="guardar">
            
            <div class="col-md">
               <input type="hidden" name="_token" value="{{csrf_token()}}">
              
                <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Registrar</button>
            
            </div>

            </div>

         </form>

    </div><!--fin del div card body-->
  </main>

  @section('custom-js')
 <script>
     
        

  $(document).ready(function(){
    
    $("#formularioarticulo").submit(function(event){
            
          var  statu= $("#statu").val();
          var  statuseleccionado= $("#statusselect").val();
          var  fechaculminacion = $("#fechaculminacion").val();
          var  fechaasignacion = $("#fechaasignacion").val();
          var  fecharevisioninterna = $("#fecharevisioninterna").val();
          var  fechafinproduccion = $("#fechaenviopro").val();
          
          var  fechahabilitacion = $("#fechahabilitacion").val();
          var  fechaenvio = $("#fechaenvio").val();
          var  fechaaceptacion = $("#fechaaceptacion").val();
          var  fechaajustes = $("#fechaajustes").val();
          var  fechainicorre = $ ("#fechainicorre").val();
          var  fechafincorre = $ ("#fechafincorre").val();
          var  actividad = $("#clasificacion").val();
          var  fecharechazo = $("#fecharechazo").val();
          var  asesor = $("#asesor").val();
          var  asesorseleccionado= $("#asesorselect").val();
          var  editorial = $("#editorial").val();
          var  print = $("#archivo").val();
          var  usuario = $("#idusuario").val();
          var  clasificacionseleccionado = $("#clasificacionselect").val();
 
        if(print == '' && statu == 11 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Adjuntar Print',
          })
          event.preventDefault();
        }
        
        if(fechaaceptacion == '' && statu == 11 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Fecha de Aceptación',
          })
          event.preventDefault();
        }

           if(print == '' && statu == 12 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Adjuntar Print',
          })
          event.preventDefault();
        }
           if(asesorseleccionado == asesor &&  statu == 12 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Asesor ',
          })
          event.preventDefault();
        }
        if(fechaajustes == ''  && actividad == 5 && statu == 12  ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Fecha de Ajustes',
          })
          event.preventDefault();
        }

           if(print == ''  && statu == 10 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Adjuntar Print',
          })
          event.preventDefault();
        }
           if(fecharechazo == '' &&  actividad == 4  && statu == 12 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Fecha de Rechazo',
          })
          event.preventDefault();
        }
           if(print == '' && statu == 9 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Adjuntar Print',
          })
          event.preventDefault();
        }

           if(asesorseleccionado == asesor && statu == 9 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Asesor ',
          })
          event.preventDefault();
        }
          
           if(fechaenvio == '' && statu == 9 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Fecha de Envio ',
          })
          event.preventDefault();
        }

           if(asesorseleccionado == asesor && statu == 8 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Asesor ',
          })
          event.preventDefault();
        }
          
           if(fecharevisioninterna == '' && statu == 8 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar fecha de revisión interna ',
          })
          event.preventDefault();
        }

           
           if(asesorseleccionado == asesor && statu == 7 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar asesor ',
          })
          event.preventDefault();
        }

          
           if(fechafincorre == '' && statu == 7 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar fecha fin de Corrección de estilo ',
          })
          event.preventDefault();
        }
        if(asesorseleccionado == asesor && statu == 6 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar Asesor corrector de estilo',
          })
          event.preventDefault();
        } 
        

           if(fechainicorre == '' && statu == 6 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar fecha inicio de Corrección de estilo',
          })
          event.preventDefault();
        }

        
           if(print == '' && statu == 5 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Adjuntar Print',
          })
          event.preventDefault();
        }

           if(fechahabilitacion == '' && statu == 5 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar la fecha de habilitación',
          })
          event.preventDefault();
        }

           if(asesorseleccionado == asesor && statu == 4 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar asesor',
          })
          event.preventDefault();
        }

           if(fechafinproduccion == ''  && statu == 4 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar fecha fin de produccion',
          })
          event.preventDefault();
        }

           if(fechaculminacion == ''  && statu == 3 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Agregar fecha de culminación',
          })
          event.preventDefault();
        }
        if(asesorseleccionado == asesor  && statu == 2 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor asignar asesor',
          })
          event.preventDefault();
        }

          if(asesor == 1  && statu == 2 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor asignar asesor',
          })
          event.preventDefault();
        }
          if(print == ''  && statu == 2 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor Adjuntar Print',
          })
          event.preventDefault();
        }
         
          if(fechaasignacion == '' && statu == 2 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor ingresar la fecha de Asignación',
          })
          event.preventDefault();
          }

          if(editorial == 1  && statu == 2 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor ingresar la editorial',
          })
          event.preventDefault();
        }
        
        if(editorial == 1  && statu == 1 ){
            Swal.fire({
                         type: 'error',
                         text: 'Por favor ingresar la editorial',
          })
          event.preventDefault();
        }
        
        if( clasificacionseleccionado == '2' && actividad == '4' && statu == 11){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Redireccionamiento en esta instancia no puede estar en "Aceptado"',
           })
           event.preventDefault();
 
           }
           if( clasificacionseleccionado == '2' && actividad == '4' && statu == 10){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Ajustes en esta instancia no puede estar en "Revision por Pares"',
           })
           event.preventDefault();
 
           }
           if( clasificacionseleccionado == '2' && actividad == '5' && statu == 11){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Ajustes en esta instancia no puede estar en "Aceptado"',
           })
           event.preventDefault();
 
           }
           if( clasificacionseleccionado == '2' && actividad == '5' && statu == 10){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Ajustes  en esta instancia no puede estar en "Revision por Pares"',
           })
           event.preventDefault();
 
           }
     
           if( clasificacionseleccionado == '2' && actividad == '2' && statu == 12){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro Nuevo en esta instancia no puede estar en "No Asignado"',
           })
           event.preventDefault();
 
           }
           if( clasificacionseleccionado == '4' && actividad == '5' && statu == 11){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Ajustes en esta instancia no puede estar en "Aceptado"',
           })
           event.preventDefault();
           }
           
           if( clasificacionseleccionado == '4' && actividad == '5' && statu == 10){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Ajustes en esta instancia no puede estar en "Revision por Pares"',
           })
           event.preventDefault();
           }
           if(clasificacionseleccionado == '4' && actividad == '5' && statu == 2){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Redireccionamiento en esta instancia no puede estar en "Proceso"',
           })
           event.preventDefault();
           }
           if(clasificacionseleccionado == '4' && actividad == '5' && statu == 3){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Redireccionamiento en esta instancia no puede estar en "Proceso"',
           })
           event.preventDefault();
           }
           if(clasificacionseleccionado == '4' && actividad == '5' && statu == 4){
             Swal.fire({
                          type: 'error',
                          text: 'Un Libro en Redireccionamiento en esta instancia no puede estar en "Proceso"',
           })
           event.preventDefault();
           }
           if(clasificacionseleccionado == '4' && actividad == '3' && statu == 11){
             Swal.fire({
                          type: 'success',
                          text: 'Proceso Finalizado Libro de investigacion Publicado',
           })
           event.preventDefault();
           }
           if(clasificacionseleccionado == '2' && actividad == '3' && statu == 11){
             Swal.fire({
                          type: 'success',
                          text: 'Proceso Finalizado Libro de investigacion Publicado',
           })
           event.preventDefault();
           }
           if(clasificacionseleccionado == '5' && actividad == '3' && statu == 11){
             Swal.fire({
                          type: 'success',
                          text: 'Proceso Finalizado Libro de investigacion Publicado',
           })
           event.preventDefault();
           }

       
          else{

     
          }

    });

    $(function () {
    $('select').selectpicker();
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    }

    );


    $(function() {
    $('#print').show(); 
    $('#statu').change(function(){
        if($('#statu').val() == 2 ||  $('#statu').val() == 12 || $('#statu').val() == 7 || $('#statu').val() == 11 || $('#statu').val() == 5 || $('#statu').val() == 4 || $('#statu').val() == 3 || $('#statu').val() == 1 || $('#statu').val() == 10 ) {
            $('#print').show(); 
            } else {
            $('#print').hide(); 
            } 
        });
    });

    });

  });
  
    function showContent() {
        element = document.getElementById("estadistica");
        check = document.getElementById("checkbox");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }

  
  function mostrarValores(){

  var car = $('#statu').val();

    if(car==1){
        $('#print').hide(); 
    }else{
        $('#print').hide(); 

    }
}
 </script>

@endsection

@endsection