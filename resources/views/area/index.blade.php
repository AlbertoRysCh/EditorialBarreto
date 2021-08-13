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

                       <h3>Áreas</h3><br/>
                      
                        <button class="btn botonagregar btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar área
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'area','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <table class="table table-bordered table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                   
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($areas as $are)
                               
                                <tr>
                                    
                                    <td>{{$are->codigo}}</td>
                                    <td>{{$are->nombre}}</td>
                                    <td>{{$are->descripcion}}</td>

                                    <td>
                                      
                                      @if($are->condicion=="1")
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
                                        <button type="button" class="btn btn-info btn-md" 
                                        data-id_area="{{$are->id}}" 
                                        data-codigo="{{$are->codigo}}"  
                                        data-nombre="{{$are->nombre}}" 
                                        data-descripcion="{{$are->descripcion}}" 
                                        data-toggle="modal" 
                                        data-target="#abrirmodalEditar">
                                          <i class="fa fa-edit"></i> Editar
                                        </button> &nbsp;
                                    </td>

                                    
                                    <td>
                                        <button class="btn btn-{{$are->condicion == 1 ? 'danger' : 'success'}} btn-md" data-id="{{$are->id}}" data-toggle="modal" data-target="#cambiarEstado" data-keyboard="false" data-backdrop="static">
                                        <i class="fa fa-{{$are->condicion == 1 ? 'times': 'lock'}}"></i> {{$are->condicion == 1 ? 'Desactivar' : 'Activar'}}
                                        </button>
                                    </td>

                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{-- {{$areas->render()}} --}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar área</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('area.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                @include('area.form')

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
                            <h4 class="modal-title">Actualizar área</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('area.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                
                                {{method_field('patch')}}
                                {{csrf_field()}}

                                <input type="hidden" id="id_area" name="id_area" value="">
                                
                                @include('area.form')

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
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Cambiar Estado del área</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="formArea">
                            {{csrf_field()}}
                            @method('DELETE')

                            <input type="hidden" id="area_id_delete" name="area_id_delete" value="">

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

@endsection
@section('custom-js')
    
<script>
    // Cambiar de estado del prospecto
    $("#cambiarEstado").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        $("#area_id_delete").val(btn.attr('data-id'));
        if (id > 0) {
          var action = '{{route('area.destroy',"@id")}}';
          action = action.replace("@id", id);
          $("#formArea").prop("action", action);
        }
    });

        /*EDITAR CATEGORIA EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget)
        var modal_codigo = button.data('codigo')
        var nombre_modal_editar = button.data('nombre')
        var descripcion_modal_editar = button.data('descripcion')
        var id_area = button.data('id_area')
        var modal = $(this)
        modal.find('.modal-body #codigo').val(modal_codigo);
        modal.find('.modal-body #nombre').val(nombre_modal_editar);
        modal.find('.modal-body #descripcion').val(descripcion_modal_editar);
        modal.find('.modal-body #id_area').val(id_area);
        })
</script>
@endsection