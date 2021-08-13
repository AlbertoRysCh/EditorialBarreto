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

                       <h3>Editoriales</h3><br/>
                      
                        <button class="btn botonagregar btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Editorial
                        </button>
                        <a href="{{ url('/editoriales/exportarexcel')}}">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-arrow-down"></i> Exportar Excel
                                       </button> &nbsp;
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'editoriales','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                   
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Linea Investigación</th>
                                    <th>Idioma</th>
                                    <th>País</th>
                                    <th>Enlace</th>
                                    <th>Periocidad</th>
                                    <th>Nivel Index</th>                          
                                    <th>Editar</th>
                                    <th>Estado</th>
                                    <th>Cambiar estado</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($editorial as $rev)
                               
                                <tr>
                                    
                                    <td>{{$rev->codigo}}</td>
                                    <td>{{$rev->nombre}}</td>
                                    <td>{{$rev->descripcion}}</td>
                                    <td>{{$rev->lineaInvestigacion}}</td>
                                    <td>{{$rev->idioma}}</td>
                                    <td>{{$rev->pais}}</td>
                                    <td>{{$rev->enlace}}</td>
                                    <td>{{$rev->nombreperiocidad}}</td>                      
                                    <td>{{$rev->nivelesnombre}}</td>                      
                                      
                                       
                            
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" 
                                        data-id_editorial="{{$rev->ideditoriales}}" 
                                        data-codigo="{{$rev->codigo}}"  
                                        data-nombre="{{$rev->nombre}}" 
                                        data-descripcion="{{$rev->descripcion}}" 
                                        data-linea="{{$rev->lineaInvestigacion}}" 
                                        data-idioma="{{$rev->idioma}}" 
                                        data-pais="{{$rev->pais}}" 
                                        data-enlace="{{$rev->enlace}}" 
                                        data-id_periodo="{{$rev->idperiodo}}" 
                                        data-id_nivel="{{$rev->idnivelindex}}"
                                        data-sjr="{{$rev->sjr}}"
                                        data-cites="{{$rev->citescore}}"
                                        data-numero="{{$rev->articulo_numero}}"
                                        data-review="{{$rev->review}}"
                                        data-tiempo="{{$rev->tiempo_respuesta}}"
                                        data-referencias="{{$rev->referencias}}"
                                        data-citados="{{$rev->citados}}"
                                        data-open="{{$rev->open_access}}"
                                        data-rechazo="{{$rev->nivel_rechazo}}"
                                        data-toggle="modal" 
                                        data-target="#abrirmodalEditar">
                                          <i class="fa fa-edit"></i> Editar
                                        </button> &nbsp;
                                    </td>

                                    <td>
                                      
                                      @if($rev->condicion=="1")
                                        <button type="button" class="btn btn-success btn-md">
                                    
                                          <i class="fa fa-check"></i> Activo
                                        </button>

                                      @else

                                        <button type="button" class="btn btn-danger btn-md">
                                    
                                          <i class="fa fa-check"></i> Desactivado
                                        </button>

                                       @endif
                                       
                                    </td>

                                    <td>

                                       @if($rev->condicion)

                                        <button type="button" class="btn btn-danger btn-sm" data-id_editorial="{{$rev->ideditoriales}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-times"></i> Desactivar
                                        </button>

                                        @else

                                         <button type="button" class="btn btn-success btn-sm" data-id_editorial="{{$rev->ideditoriales}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-lock"></i> Activar
                                        </button>

                                        @endif
                                       
                                    </td>
                                    
                                    <td>
                                    <button class="btn btn-danger" data-hisdelete="{{$rev->ideditoriales}}" data-toggle="modal" data-target="#delete">Eliminar</button>

                                    </td>  

                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{$editorial->render()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Editorial</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                @include('editorial.form')

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
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Actualizar Editorial</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('editoriales.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                
                                {{method_field('patch')}}
                                {{csrf_field()}}

                                <input type="hidden" id="ideditoriales" name="ideditoriales" value="">
                                
                                @include('editorial.form')

                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
            <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">Confirmar su Eliminacion</h4>
                    </div>
                    <form action="{{route('editoriales.destroy','test')}}" method="post">
                            {{method_field('delete')}}
                            {{csrf_field()}}
                            
                        <div class="modal-body">
                                <h6 class="text-center">
                                    Seguro que desea eliminar los datos?
                                </h6>
                                <input type="text" id="ideditorial" name="ideditoriales" value="">

                        </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Si, Eliminar</button>
                                </div>
                    </form>
                    </div>
                </div>
                </div>


                      
             <!-- Inicio del modal Cambiar Estado del usuario -->
             <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado de la Revista</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                        <form action="{{route('editoriales.desactivar','test')}}" method="POST">
                         {{csrf_field()}} 

                            <input type="hidden" id="ideditorial" name="ideditorial" value="">

                                <p>Estas seguro de cambiar el estado?</p>
        

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i>Aceptar</button>
                            </div>

                         </form>
                    </div>
                    <!-- /.modal-content -->
                   </div>
                <!-- /.modal-dialog -->
             </div>
            <!-- Fin del modal Eliminar -->
           
            
        </main>

@endsection
@section('custom-js')
    
<script>
    // Cambiar de estado del prospecto
    /*$("#delete").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        $("#revista_id").val(btn.attr('data-id'));
        if (id > 0) {
          var action = '{{route('editoriales.destroy',"@id")}}';
          action = action.replace("@id", id);
          $("#formRevista").prop("action", action);
        }
    });*/
    //Eliminar editorial
    $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modaleliminarrevi = button.data('hisdelete')
      var modal = $(this)
      modal.find('.modal-body #ideditorial').val(modaleliminarrevi);
})

        /*INICIO ventana modal para cambiar estado de Revista*/
        $('#cambiarEstado').on('show.bs.modal', function (event) {       
        var button = $(event.relatedTarget)
        var id_editorial = button.data('id_editorial')
        var modal = $(this)
        modal.find('.modal-body #ideditorial').val(id_editorial);
        })
        /*EDITAR EDITORIAL EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modalideditorial = button.data('id_editorial')
        var modalcodigo = button.data('codigo')
        var modalnombre = button.data('nombre')
        var modaldescripcion = button.data('descripcion')
        var modallinea = button.data('linea')
        var modalidioma = button.data('idioma')
        var modalpais = button.data('pais')
        var modalenlace = button.data('enlace')
        var modalperiodo = button.data('id_periodo')
        var modalnivel = button.data('id_nivel')
        var modalsjr = button.data('sjr')
        var modalcites = button.data('cites')
        var modalnumero = button.data('numero')
        var modalreview = button.data('review')
        var modaltiempo = button.data('tiempo')
        var modalreferencias = button.data('referencias')
        var modalcitados = button.data('citados')
        var modalopen = button.data('open')
        var modalrechazo = button.data('rechazo')                               
        var modal = $(this)
        modal.find('.modal-body #ideditoriales').val(modalideditorial);
        modal.find('.modal-body #codigo').val(modalcodigo);
        modal.find('.modal-body #nombre').val(modalnombre);
        modal.find('.modal-body #descripcion').val(modaldescripcion);
        modal.find('.modal-body #linea').val(modallinea);
        modal.find('.modal-body #idioma').val(modalidioma);
        modal.find('.modal-body #pais').val(modalpais);
        modal.find('.modal-body #enlace').val(modalenlace);
        modal.find('.modal-body #id_periodo').val(modalperiodo);
        modal.find('.modal-body #id_nivel').val(modalnivel);
        modal.find('.modal-body #sjr').val(modalsjr);
        modal.find('.modal-body #cites').val(modalcites);
        modal.find('.modal-body #numero').val(modalnumero);
        modal.find('.modal-body #review').val(modalreview);
        modal.find('.modal-body #tiempo').val(modaltiempo);
        modal.find('.modal-body #referencias').val(modalreferencias);
        modal.find('.modal-body #citados').val(modalcitados);
        modal.find('.modal-body #open').val(modalopen);
        modal.find('.modal-body #rechazo').val(modalrechazo);

        })
            
</script>
@endsection
