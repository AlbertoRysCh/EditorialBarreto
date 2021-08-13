@extends('layouts.app')
@section('content')


<main class="main">

 <div class="card-body">

                                    <a href="{{ url('/librosinvestigacion')}}">
                                       <button type="button" class="btn btn-danger btn-sm">
                                         <i class="fa fa-arrow-left"></i> Regresar
                                       </button> &nbsp;
                                    </a>

                                     <a  href="{{ URL::to('librosinvestigacion/'.$libros->idlibros .'/edit') }}">
                                       <button type="button" class="btn btn-warning btn-sm">
                                         <i class="fa fa-eye"></i> Editar
                                       </button> &nbsp;

                                     </a>

                                     <a href="">
                                       <button type="button" class="btn btn-info btn-sm">
                                         <i class="fa fa-eye-left"></i> Observaciones
                                       </button> &nbsp;

                                     </a>
                                     
                                     <a href="">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-download"></i> Archivo para enviar
                                       </button> &nbsp;
                                     </a>
                                     
                                     <a href="{{ route('ot_pdf',['id'=>$libros->contrato_id]) }}">
                                    <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-pdf-o"></i> Generar PDF OT
                                    </button>
                                    </a>
                                    @if (Auth::id() == 9 or Auth::id() == 17 or Auth::id() == 1 or  Auth::id() == 40 or  Auth::id() == 57 or Auth::id() == 48 or Auth::id() == 50 or Auth::id() == 59)
                                    <button class="btn botonagregar btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Correo
                                     </button>   
                                     @endif
                                

                                     <br><br><br>
             {{csrf_field()}}
            
            <div class="form-group row">

                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles" for="codigo">Codigo</label>
                        <input type="text" id="codigo" name="codigo" readonly class="form-control-plaintext" value="{{$libros->codigo}}">                
                        <input type="hidden" id="id" name="id" readonly class="form-control-plaintext" value="{{$libros->idlibros}}">                

                 </div>

                 <div class="col-md-6">  

                        <label class="form-control-label labeldetalles" for="titulo">Título</label>
                        <textarea  readonly class="form-control observacion" id="observacion" name="observacion" rows="5">{{$libros->titulo}}</textarea>

                </div>

                <div class="col-md-2">  
                        <label class="form-control-label labeldetalles" for="area">Área</label>
                        <input type="text" id="area" name="area" readonly class="form-control-plaintext" value="{{$libros->nombrearea}}">                


                </div>


                
                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles " for="tipo_libros">Tipo Libro</label>
                        <input type="text" id="tipo_libros" name="tipo_libros" readonly class="form-control-plaintext" value="{{$libros->nombretipos}}">                

                </div>

            </div>

            <div class="form-group row">

                
                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles" for="tipo_libros">Nivel Libro</label>
                        <input type="text" id="nivellibros" name="nivellibros" readonly class="form-control-plaintext" value="{{$libros->nombreniveles}}">                

                </div>

                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles" for="revista">Editorial</label>
                        <input type="text" id="revistas" name="revistas" readonly class="form-control-plaintext" value="{{$libros->nombreeditoriales}}">                

                </div>

                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles" for="tipo_libros">Asesor</label>
                        <input type="text" id="asesor" name="asesor" readonly class="form-control-plaintext" value="{{$libros->nombresasesor}}">                

                </div>     
                
                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles" for="fechaorden">Fecha Orden</label>
                    <input type="text" id="fechaorden" name="fechaorden" readonly class="form-control-plaintext" value="{{$libros->fechaOrden}}">                

                </div>      

                <div class="col-md-2">  
                <label class="form-control-label labeldetalles" for="fechallegada">Fecha Llegada</label>
                <input type="text" id="fechallegada" name="fechallegada" readonly class="form-control-plaintext" value="{{$libros->fechaLlegada}}">                

                </div>

                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles" for="fechaasignacion">Fecha Asignación</label>
                    <input type="text" id="fechaasignacion" name="fechaasignacion" readonly class="form-control-plaintext" value="{{$libros->fechaAsignacion}}">                


                </div>
            </div>

            <div class="form-group row">


                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles" for="fechallegada">Fecha Culminación</label>
                    <input type="text" id="fechaculminacion" name="fechaculminacion" readonly class="form-control-plaintext" value="{{$libros->fechaCulminacion}}">                
                </div>

                <div class="col-md-2">  
                <label class="form-control-label labeldetalles" for="fechaenviopro">Fecha fin Producción</label>
                <input type="text" id="fechaenviopro" name="fechaenviopro" readonly autocomplete="off" class="form-control-plaintext" value="{{$libros->fechaEnvioPro}}">                
                </div>

                <div class="col-md-2">  
                <label class="form-control-label labeldetalles" for="fechallegada">Fecha Habilitación</label>
                <input type="text" id="fechahabilitacion" name="fechahabilitacion" readonly class="form-control-plaintext" value="{{$libros->fechaHabilitacion}}">
                </div>

                <div class="col-md-2">  
                    <label class="form-control-label" for="fechainicorre">Fecha de Inicio C.E</label>
                    <input type="text" id="fechainicorre" name="fechainicorre" readonly class="form-control-plaintext" value="{{$libros->fechaIniCorre}}">
                </div>
            
                <div class="col-md-2">  
                    <label class="form-control-label" for="fechafincorre">Fecha de Fin C.E</label>
                    <input type="text" id="fechafincorre" name="fechafincorre" readonly class="form-control-plaintext" value="{{$libros->fechaFinCorre}}" >
                </div>
                
                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles" for="fecharevision interna">Fecha Revision Int.</label>
                    <input type="text" class="form-control-plaintext" readonly  autocomplete="off" id="fecharevisioninterna" value="{{$libros->fechaRevisionInterna}}" name="fecharevisioninterna" >
                </div>

                
            </div>

            <div class="form-group row">
                
                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles" for="fechallegada">Fecha Envío</label>
                    <input type="text" id="fechaenvio" name="fechaenvio" readonly class="form-control-plaintext" value="{{$libros->fechaEnvio}}">                
                </div>
                
                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles" for="fechallegada">Fecha Aceptación</label>
                    <input type="text" id="fechaaceptacion" name="fechaaceptacion" readonly class="form-control-plaintext" value="{{$libros->fechaAceptacion}}">
                </div>

                <div class="col-md-2">  
                <label class="form-control-label labeldetalles" for="fecharechazo">Fecha Rechazo</label>
                <input type="text" id="fecharechazo" name="fecharechazo" readonly class="form-control-plaintext" value="{{$libros->fechaRechazo}}">
                </div>

                <div class="col-md-2">  
                    <label class="form-control-label labeldetalles " for="fechallegada">Fecha Ajustes</label>
                    <input type="text"  readonly autocomplete="off" class="form-control-plaintext" value="{{$libros->fechaAjustes}}" id="fechaajustes"  name="fechaajustes" >
                </div>

                <div class="col-md-2">  
                        <label class="form-control-label labeldetalles " for="modalidad">Clasificacion</label>
                        <input type="text" id="clasificacion" name="clasificacion" readonly class="form-control-plaintext" value="{{$libros->nombreclasificacion}}">                
                </div>
                
                <div class="col-md-2">  
                        <label class="form-control-label labeldetalles" for="statu">Statu</label>
                        <input type="text" id="statu" name="statu" readonly class="form-control-plaintext" value="{{$libros->nombrestatus}}">                
                </div>
            </div>
          
            <div class="form-group row">
                
                                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles " for="modalidad">Modalidad</label>
                        <input type="text" id="modalidad" name="modalidad" readonly class="form-control-plaintext" value="{{$libros->nombresmodalidades}}">                

                </div>
                @if (Auth::id() == 9 or Auth::id() == 17 or Auth::id() == 1 or  Auth::id() == 40 or  Auth::id() == 57 or Auth::id() == 59 or Auth::id() == 48 or Auth::id() == 50)

                  <div class="col-md-2">  

                        <label class="form-control-label labeldetalles" for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" readonly class="form-control-plaintext" value="{{$libros->usuario}}">                

                </div>

                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles" for="usuario">Contraseña</label>
                        <input type="text" id="contrasenna" name="contrasenna" readonly class="form-control-plaintext" value="{{$libros->contrasenna}}">                

                </div>
                @endif
        
                <div class="col-md-2">  

                        <label class="form-control-label labeldetalles " for="pais">País</label>
                        <input type="text" id="pais" name="pais" readonly class="form-control-plaintext" value="{{$libros->pais}}">                
                </div>
                <div class="col-md-2">  
                        <label class="form-control-label labeldetalles" for="carta">Carta</label>
                        <input type="text" id="carta" name="carta" readonly class="form-control-plaintext" value="{{$libros->carta}}">                
                </div>
                </div>

                <div class="form-group row">
                <div class="col-md-4">
                        <label for="exampleFormControlTextarea1" class="labeldetalles">Observación</label>
                        <textarea  readonly class="form-control observacion" id="observacion" name="observacion" rows="3">{{$libros->observacion}}</textarea>
                 </div>
            </div> 
                        
            @if (Auth::id() == 3 or Auth::id() == 56  or Auth::id() == 3 )

             <div class="form-group row border">

              <h5 style="margin-left: 20px">Autores en Libros</h5>

              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead >
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
            @if (Auth::id() == 9 or Auth::id() == 17 or Auth::id() == 27 or Auth::id() == 45 or Auth::id() == 1 or  Auth::id() == 40 or  Auth::id() == 57 or Auth::id() == 59 or Auth::id() == 48 or Auth::id() == 50)

           <div class="form-group row border">

              <h5 style="margin-left: 20px">Autores en libros</h5>

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


<div class="form-group row border">

 <h5 style="margin-left: 20px">Listado de Correos creados</h5>
 
 <div class="table-responsive col-md-12">
   <table id="detalles" class="table table-bordered table-striped table-sm">
   <thead class="tablas">
       <tr class=" bordearriba">
           <th>Nombres y apellidos</th>
           <th>Correo Creado</th>
           <th>Contraseña</th>
           <th>Celular vinculado</th>

       </tr>
   </thead>
   <tbody>
   @foreach($correosviejos as $cov)
   <tr>
   <td>{{$cov->nombres}} {{$cov->apellidos}}</td>
   <td>{{$cov->correo}}</td>
   <td>{{$cov->contrasena}}</td>
   <td>{{$cov->celularrelacionado}}</td>
   </tr> 
   @endforeach
   </tbody>
   
   </table>
 </div>
</div> 

</div><!--fin del div card body-->


             <div class="form-group row border">

              <h5 style="margin-left: 20px">Correos creados a clientes</h5>

              
              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead class="tablas">
                    <tr class=" bordearriba">
                        <th>Nombres y apellidos</th>
                        <th>Correo Creado</th>
                        <th>Contraseña</th>
                        <th>Celular vinculado</th>
                        <th>Firma</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($correoscreados as $co)
                <tr>
                <td>{{$co->nombres}} {{$co->apellidos}}</td>
                <td>{{$co->correo}}</td>
                <td>{{$co->contrasena}}</td>
                <td>{{$co->celularrelacionado}}</td>
                <td>
                @if($co->firma === 'noimagen.jpg') 
                -
                @else
                <button class="btn btn-sm btn-warning" type="button">
                <a href="{{route('descargar.firma.libro', $co->idcorreoslibros) }}" class="download">Descargar</a>        
                </button>
                @endif
                </td>

                <td>
                  <button type="button" class="btn btn-info btn-md" 
                  data-id_correo="{{$co->idcorreoslibros}}" 
                  data-nombre_autor="{{$co->nombres}} {{$co->apellidos}}" 
                  data-id_autor="{{$co->idcliente}}"  
                  data-codigo_art="{{$co->codigolib}}" 
                  data-correo="{{$co->correo}}" 
                  data-contrasena="{{$co->contrasena}}" 
                  data-celular="{{$co->celularrelacionado}}" 
                  data-toggle="modal" 
                  data-target="#abrirmodalEditar">
                  <i class="fa fa-edit"></i> Editar
                  </button> &nbsp;
                </td>
                </tr> 
                @endforeach
                </tbody>
                
                </table>
              </div>
            </div> 

    </div><!--fin del div card body-->
    @endif

              <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Correos a clientes</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

    <form action="{{route('correolibro.store')}}" id="pruebasubmit" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
    {{csrf_field()}}
                                
        <div class="form-group row">
        <input type="hidden" id="id" name="id_articulo" class="form-control-plaintext" value="{{$libros->idlibros}}">                

            <label class="col-md-2 form-control-label" for="grado">Cliente/Autor</label>
            <input type="hidden" id="codigo" name="codigo" readonly class="form-control-plaintext" value="{{$libros->codigo}}">                

            <div class="col-md-9">
            
                <select class="form-control selectpicker"  name="id_autor" id="id_autor" data-live-search="true">
                                                
                <option class="special" value="358" >Seleccione</option>
                
                @foreach($detalles as $det)
                  
                   <option class="special" value="{{$det->idcliente}}"> {{$det->nombres}} {{$det->apellidos}}</option>
                        
                @endforeach

                </select>
            
            </div>
                                       
    </div>
   
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="nombre">Correo Creado</label>
                <div class="col-md-9">
                    <input type="text" id="correo" name="correo" class="form-control" placeholder="Ingrese el Correo">
                    
                </div>
    </div>
    
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="descripcion">Contraseña</label>
                <div class="col-md-9">
                    <input type="text" id="contrasena" name="contrasena" class="form-control" placeholder="Ingrese la Contraseña del Correo" >
                </div>
    </div>

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="linea">Celular vinculado</label>
                <div class="col-md-9">
                    <input type="text" id="celular" name="celular" class="form-control" placeholder="Ingrese Celular Vinculado" >
                </div>
    </div>  

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="linea">Adjuntar Firma</label>
                <div class="col-md-9">
                    <input type="file" id="archivos" name="archivos" class="form-control" placeholder="Ingrese firma" >
                </div>
    </div>  



    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" id="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>

    </div>
    </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->


                          <!--Inicio del modal agregar-->
                          <div class="modal fade" id="abrirmodalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Modificar Correos a clientes</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('correolibro.update','test')}}" id="pruebasubmitmo" method="post" class="form-horizontal" enctype="multipart/form-data" >
                            {{ method_field('PUT') }}

                            {{csrf_field()}}
                                                    
                            <div class="form-group row">
                            <input type="hidden" id="id" name="id" value="">
                                <label class="col-md-2 form-control-label" for="grado">Cliente/Autor</label>

                                <div class="col-md-9">
                                
                                    <div class="col-md-9">
                                        <input type="text" readonly  id="nombreautor" class="form-control" >
                                        <input type="hidden" name="id_autor" id="id_autormo" class="form-control" >
                                        <input type="hidden" name="codigo_art" id="codigo_art" class="form-control" >

                                    </div>
                                </div>
                                                          
                        </div>
                      
                        <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="nombre">Correo Creado</label>
                                    <div class="col-md-9">
                                        <input type="text" id="correomo" name="correo" class="form-control" placeholder="Ingrese el Correo">
                                        
                                    </div>
                        </div>
                        
                        <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="descripcion">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" id="contrasenamo" name="contrasena" class="form-control" placeholder="Ingrese la Contraseña del Correo" >
                                    </div>
                        </div>

                        <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="linea">Celular vinculado</label>
                                    <div class="col-md-9">
                                        <input type="text" id="celularmo" name="celular" class="form-control" placeholder="Ingrese Celular Vinculado" >
                                    </div>
                        </div>  

                        <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="linea">Adjuntar Firma</label>
                        <div class="col-md-9">
                            <input type="file" id="archivos" name="archivos" class="form-control" placeholder="Ingrese firma" >
                        </div>
                        </div>  

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="submit" id="pruebasubmitmo" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>

                        </div>
                        </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

  </main>

@endsection


@section('custom-js')
<script>
/*EDITAR CORREO ARTICULO EN VENTANA MODAL*/
         $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modalidcorreo = button.data('id_correo')
        var modalidautor = button.data('id_autor')
        var modalcodigoart = button.data('codigo_art')
        var modalnombresautor = button.data('nombre_autor')
        var modalcorreocreado = button.data('correo')
        var modalcontrasena = button.data('contrasena')
        var modalcelular = button.data('celular')
        var modal = $(this)
        modal.find('.modal-body #id').val(modalidcorreo);
        modal.find('.modal-body #nombreautor').val(modalnombresautor);
        modal.find('.modal-body #id_autormo').val(modalidautor);
        modal.find('.modal-body #codigo_art').val(modalcodigoart);
        modal.find('.modal-body #correomo').val(modalcorreocreado);
        modal.find('.modal-body #contrasenamo').val(modalcontrasena);
        modal.find('.modal-body #celularmo').val(modalcelular);

        })
</script>
@endsection