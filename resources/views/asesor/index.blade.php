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

                       <h3>Asesores Editorial</h3><br/>
                    
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'asesor','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <table class="table table-responsive table-lg">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th>Ver</th>
                                    <th>Departamento</th>
                                    <th>Documento</th>
                                    <th>nombres</th>
                                    <th>Teléfono</th>
                                    <th>correo</th>
                                    <th>Estado</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($asesores as $ase)
                               
                                <tr>
                                <td>
                                    <a href="{{URL::action('AsesorController@show',$ase->usuario_id)}}">
                                      <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye"></i> Ver detalle
                                      </button> &nbsp;

                                    </a>
                                  </td>
                                  <td>{{$ase->nombreproducto}}</td>
                                    <td>{{$ase->num_documento}}</td>
                                    <td>{{$ase->nombres}}</td>
                                    <td>{{$ase->telefono}}</td>
                                    <td>{{$ase->correo}}</td>                      
                                    <td>
                                      
                                      @if($ase->condicion=="1")
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

                                       @if($ase->condicion)

                                        <button type="button" class="btn btn-danger btn-sm" data-id_usuario="{{$ase->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-times fa-2x"></i> Desactivar
                                        </button>

                                        @else

                                         <button type="button" class="btn btn-success btn-sm" data-id_usuario="{{$ase->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-lock fa-2x"></i> Activar
                                        </button>

                                        @endif
                                       
                                    </td>

                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{$asesores->render()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

             <!-- Inicio del modal Cambiar Estado del usuario -->
             <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado del Asesor</h4>
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
        @endsection
        @push('scripts')
        <script>
        /*INICIO ventana modal para cambiar el estado del usuario*/

        // Cambiar de estado del prospecto
    $("#cambiarEstado").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        $("#id_usuario").val(btn.attr('data-id'));
        if (id > 0) {
          var action = '{{route('cliente.destroy',"@id")}}';
          action = action.replace("@id", id);
          $("#formProid_usuarioid_usuariospectos").prop("action", action);
          $(".modal-title").text('Cambiar estado prospecto');
        }
    });
        /*FIN ventana modal para cambiar estado del usuario*/
        </script>


 @endpush