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

                       <h2>Usuarios</h2><br/>
                      
                        <button class="btn botonagregar btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'usuarios','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                   
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Número</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($usuarios as $user)
                               
                                <tr>
                                    
                                    <td>
                                        {{$user->nombre}} <br>
                                        {!!"<b>Zona:</b> ".$user->nombre_zona!!}
                                    </td>
                                    <td>{{$user->tipo_documento}}</td>
                                    <td>{{$user->num_documento}}</td>
                                    <td>{{$user->direccion}}</td>
                                    <td>{{$user->telefono}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->rol}}</td>
                        

                                    <td>
                                      
                                      @if($user->condicion=="1")
                                        <button type="button" class="btn btn-success btn-md btn-acti">
                                    
                                          <i class="fa fa-check"></i> Activo
                                        </button>

                                      @else

                                        <button type="button" class="btn btn-danger btn-md">
                                    
                                          <i class="fa fa-check"></i> Desactivado
                                        </button>

                                       @endif
                                       
                                    </td>
                            
                                    <td>
                                        <button type="button" class="btn btn-info btn-md" data-id_usuario="{{$user->id}}"
                                             data-nombre="{{$user->nombre}}" data-tipo_documento="{{$user->tipo_documento}}"
                                             data-num_documento="{{$user->num_documento}}" data-direccion="{{$user->direccion}}"
                                             data-telefono="{{$user->telefono}}" data-email="{{$user->email}}"
                                             data-id_rol="{{$user->idrol}}" data-usuario="{{$user->username}}"
                                             data-zona_id="{{$user->zona_id}}"
                                             
                                             data-toggle="modal" data-target="#abrirmodalEditar">
                                          <i class="fa fa-edit"></i> Editar
                                        </button> &nbsp;
                                    </td>

                                    
                                    <td>

                                       @if($user->condicion)

                                        <button type="button" class="btn btn-danger btn-sm" data-id_usuario="{{$user->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-times"></i> Desactivar
                                        </button>

                                        @else

                                         <button type="button" class="btn btn-success btn-sm btn-acti" data-id_usuario="{{$user->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-lock"></i> Activar
                                        </button>

                                        @endif
                                       
                                    </td>

                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{$usuarios->render()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                @include('user.form')

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
                            <h4 class="modal-title">Actualizar usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('usuarios.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                
                                {{method_field('patch')}}
                                {{csrf_field()}}

                                <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                
                                @include('user.form')

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
                            <h4 class="modal-title">Cambiar Estado del Usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="{{route('usuarios.destroy','test')}}" method="POST">
                         {{method_field('delete')}}
                         {{csrf_field()}} 

                            <input type="hidden" id="id_usuario" name="id_usuario" value="">

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


         /*EDITAR USUARIO EN VENTANA MODAL*/
         $('#abrirmodalEditar').on('show.bs.modal', function (event) {

        //console.log('modal abierto');
        /*el button.data es lo que está en el button de editar*/
        var button = $(event.relatedTarget)

        var nombre_modal_editar = button.data('nombre')
        var tipo_documento_modal_editar = button.data('tipo_documento')
        var num_documento_modal_editar = button.data('num_documento')
        var direccion_modal_editar = button.data('direccion')
        var telefono_modal_editar = button.data('telefono')
        var email_modal_editar = button.data('email')
        /*este id_rol_modal_editar selecciona la categoria*/
        var id_rol_modal_editar = button.data('id_rol')
        var usuario_modal_editar = button.data('usuario')
        var password_modal_editar = button.data('password')
        var id_usuario = button.data('id_usuario')
        var zona_id = button.data('zona_id')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        /*los # son los id que se encuentran en el formulario*/
        modal.find('.modal-body #nombre').val(nombre_modal_editar);
        modal.find('.modal-body #tipo_documento').val(tipo_documento_modal_editar);
        modal.find('.modal-body #num_documento').val(num_documento_modal_editar);
        modal.find('.modal-body #direccion').val(direccion_modal_editar);
        modal.find('.modal-body #telefono').val(telefono_modal_editar);
        modal.find('.modal-body #email').val(email_modal_editar);
        modal.find('.modal-body #id_rol').val(id_rol_modal_editar);
        modal.find('.modal-body #usuario').val(usuario_modal_editar);
        modal.find('.modal-body #password').val(password_modal_editar);
        modal.find('.modal-body #id_usuario').val(id_usuario);
        modal.find('.modal-body #zona_id').val(zona_id);
        })

        /*INICIO ventana modal para cambiar el estado del usuario*/

        $('#cambiarEstado').on('show.bs.modal', function (event) {

        //console.log('modal abierto');

        var button = $(event.relatedTarget)
        var id_usuario = button.data('id_usuario')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)

        modal.find('.modal-body #id_usuario').val(id_usuario);
        })

        /*FIN ventana modal para cambiar estado del usuario*/

        </script>
@endsection