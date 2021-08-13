@extends('layouts.app')
@section('content')
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h3>Archivos / Actividades</h3><br/>
                      
                        <button class="btn botonagregar btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar
                        </button>
                        @if(Auth::user()->idrol !== '5' )                                           
                        
                        <a href="{{ url('/archivos/exportar')}}">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-arrow-down"></i> Exportar Excel
                                       </button> &nbsp;
                        </a>

                        @endif

                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'archivo','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <table class="table table-responsive table-sm">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th>Fecha Subida</th>
                                    <th>Codigo</th>
                                    <th>Titulo</th>
                                    <th>Archivo</th>
                                    @if (Auth::user()->idrol !=5) 

                                    <th>Avance</th>
                                    @endif

                                    <th>Observacion</th>
                                    @if (Auth::user()->idrol !=5) 

                                    <th>Editar</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>

                               @foreach($archivos as $ar)
                                    
                                <tr>
                                <td>{{$ar->created_at}}</td>

                                    <td>{{$ar->codigo}}</td>
                                    <td>{{$ar->titulo}}</td> 

                                    @if($ar->archivo == 'noimagen.jpg')
                                    <td>
                                       -
                                    </td>
                                    @else
                                    <td>
                                    <a href="{{route('download', $ar->id) }}" id="archivo1">Descargar</a>        
                                    </a>
                                    </td>
                                    @endif
                                    @if (Auth::user()->idrol !=5) 

                                    <td>{{$ar->avance}}</td>
                                    @endif

                                    <td>{{$ar->observacion}}</td>
                                    @if (Auth::user()->idrol !=5) 

                                    <td>
                                    <button type="button" class="btn btn-info btn-md" 
                                    data-id_archivos="{{$ar->id}}" 
                                    data-libros="{{$ar->idlibros}}" 
                                    data-titulo="{{$ar->titulo}}" 
                                    data-user="{{$ar->iduser}}" 
                                    data-archivo1="{{$ar->archivo}}" 
                                    data-avance="{{$ar->avance}}" 
                                    data-observacion="{{$ar->observacion}}" 
                                    data-toggle="modal" 
                                    data-target="#abrirmodalEditar">
                                    <i class="fa fa-edit"></i> Editar
                                    </button> &nbsp;
                                    </td>
                                    @endif

                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                        {{$archivos->appends($data)->links()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Archivo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('archivo.store')}}" id="pruebasubmit" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                <div class="form-group row">
            <label class="col-md-2 form-control-label" for="grado">Libro</label>
            
            <div class="col-md-9">
            
                <select class="form-control selectpicker"  name="id_libros" id="id_libros" data-live-search="true">
                                                
                <option class="special" value="358" >Seleccione</option>
                
                @foreach($libros as $art)
                  
                   <option class="special" value="{{$art->id}}"> {{$art->titulo}}</option>
                        
                @endforeach

                </select>
            
            </div>

            <div class="col-md-3">
                  
                  <input type="hidden" class="form-control" id="user" name="user" value="{{Auth::user()->id}}">
                         
                  </div>
                                       
    </div>

    @if (Auth::user()->idrol !=5) 

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="avance">Avance de Archivo</label>
                <div class="col-md-9">
                  
                <input type="text" class="form-control" id="avance" name="avance" placeholder="Ingrese el Avance">
                       
                </div>

    </div>

    @endif

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="archivo">Archivo</label>
                <div class="col-md-9">
                  
                    <input type="file" id="archivo" name="archivo" accept=".pdf,.docx,.xlsx,.pptx, .rar" class="form-control">
                       
                </div>
    </div>

    <div class="form-group row">
                <div class="col-md-9">
                  
                <label for="exampleFormControlTextarea1">Observación de Archivo</label>
                        <textarea class="form-control" id="observacionarchivo" name="observacionarchivo" rows="3"></textarea>                       
                </div>
    </div>
    <div class="form-group row">
                <div class="col-md-9">
                  
                <h3>Actividades</h3>  
                </div>
    </div>
    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="descripcion">Avance 8:00 am</label>
                <div class="col-md-2">
                    <input type="number" id="avancemanana" name="avancemañana" class="form-control" placeholder="%" >
                </div>


                <label class="col-md-2 form-control-label" for="descripcion">Avance 6:00 pm</label>
                
                <div class="col-md-2">
                    <input type="number" id="avancetarde" name="avancetarde" class="form-control" placeholder="%" >
                </div>

    </div>



    <div class="form-group row">
                <div class="col-md-9">
                  
                <label for="exampleFormControlTextarea1"> Otra Actividad</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>                       
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


             <!--Inicio del modal actualizar-->
             <div class="modal fade" id="abrirmodalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Modificar Avance</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('archivo.update','test')}}" id="prueba" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @method('PUT')

                                {{method_field('patch')}}
                                {{csrf_field()}}
                                <input type="hidden" id="id_archivos" name="id_archivos" value="">

                                <div class="form-group row">
            <label class="col-md-2 form-control-label" for="grado">Libro</label>
            
            <div class="col-md-9">
            
            <input type="hidden" class="form-control" id="id_libros" name="id_libros">
            <input type="text" readonly class="form-control" id="titulos" >

            
            </div>

            <div class="col-md-3">
                  
                  <input type="hidden" class="form-control" id="useredit" name="user" value="{{Auth::user()->id}}">
                         
                  </div>
                                       
    </div>

    @if (Auth::user()->idrol !=5) 

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="avance">Avance de Archivo</label>
                <div class="col-md-9">
                  
                <input type="text" class="form-control" id="avance" name="avance" placeholder="Ingrese el Avance">
                       
                </div>

    </div>

    @endif

    <div class="form-group row">
                <label class="col-md-2 form-control-label" for="archivo">Archivo</label>
                <div class="col-md-9">
                    <input type="file" id="archivo" name="archivo" accept=".pdf,.docx,.xlsx,.pptx, .rar" class="form-control">
                </div>
    </div>

    <div class="form-group row">
                <div class="col-md-9">
                <label for="exampleFormControlTextarea1">Observación de Archivo</label>
                <textarea class="form-control" id="observacionarchivo" name="observacionarchivo" pattern="[A-Za-z0-9!?-]" rows="3"></textarea>                       
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

            
             <!-- Inicio del modal Cambiar Estado del usuario -->
             <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado del Autor    </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST">
                         {{method_field('delete')}}
                         {{csrf_field()}} 

                            <input type="hidden" id="id_usuario" name="id_usuario" value="">

                                <p>Estas seguro de cambiar el estado?</p>
        

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i>Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-lock fa-2x"></i>Aceptar</button>
                            </div>

                         </form>
                    </div>
                    <!-- /.modal-content -->
                   </div>
                <!-- /.modal-dialog -->
             </div>
            <!-- Fin del modal Eliminar -->
        </main>

@section('custom-js')

        <script>
    
     $(document).ready(function(){
    
        $("#pruebasubmit").submit(function(event){
        suma();
         
     });


     $(function () {
     $('select').selectpicker();
     });


     });

    function suma(){
         
    var total=0;
    var manana= $("#avancemanana").val() || 0;
    var  tarde= $("#avancetarde").val() || 0;

     total=  parseFloat(manana) + parseFloat(tarde);

     if(total<=100){
        
        return;

     }else{
        Swal.fire({
                    icon: 'error',
                    text: 'Suma de Avances supera al 100%',
     })
        event.preventDefault();

     }

     }
     /*EDITAR ARCHIVO EN VENTANA MODAL*/
     $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modalarchivos = button.data('id_archivos')
        var modalibros = button.data('libros')
        var modaltitulo = button.data('titulo')
        var modaluser = button.data('user')
        var modaladjunto = button.data('archivo')
        var modalavance = button.data('avance')
        var modalobservacion = button.data('observacion')
        var modal = $(this)
        modal.find('.modal-body #id_archivos').val(modalarchivos);
        modal.find('.modal-body #id_libros').val(modalibros);
        modal.find('.modal-body #titulos').val(modaltitulo);
        modal.find('.modal-body #userth').val(modaluser);
        modal.find('.modal-body #avance').val(modalavance);
        modal.find('.modal-body #observacionarchivo').val(modalobservacion);})
        
    </script>
    
@endsection

@endsection