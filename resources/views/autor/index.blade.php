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

                       <h3>Autores</h3><br/>

                      <a href="correo">
                            <button class="btn botonreporte btn-sm">
                            <i class="fa fa-file-archive-o"></i>&nbsp;&nbsp;Ver envíos de Correos
                            </button>
                      </a>

                    </div>

                    
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'autor','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                              <div class="col">
                              <p style="margin-bottom: -10px;">
                               <strong>Total autores:</strong>
                               {{count($count)}}
                               </p>
                            </div>
                           </div>
                         </div>
                        <table class="table table-responsive table-sm">
                            <thead>
                                <tr class="bg bordearriba">
                                <th>Ver</th>

                                    <th>Número</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Correo Gmail</th>
                                    <th>Contrasena</th>
                                    <th>Universidad</th>
                                    <th>ORCID ID</th>
                                    <th>Grado</th>
                                    <th>Especialidad</th>
                                    @if(Auth::user()->idrol != 9 )

                                    <th>Estado</th>
                                    <th>Cambiar Estado</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>

                               @foreach($clientes as $au)
                               
                                <tr>
                                <td>             <a href="{{URL::action('AutorController@show',$au->id)}}">
                                      <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye"></i> Ver detalle
                                      </button> &nbsp;

                                    </a></td>

                                    <td>{{$au->num_documento}}</td>
                                    <td>{{$au->nombres}}</td>
                                    <td>{{$au->apellidos}}</td>
                                    <td>{{$au->correocontacto}}</td>
                                    <td>{{$au->telefono}}</td>
                                    <td>{{$au->correogmail}}</td>
                                    <td>{{$au->contrasena}}</td>
                                    <td>{{$au->universidad}}</td>
                                    <td>{{$au->orcid}}</td>
                                    <td>{{$au->nombregrado}}</td>   
                                    <td>{{$au->especialidad}}</td>   
                                    @if(Auth::user()->idrol != 9 )

                                    <td>
                                        @if($au->condicion=="1")
                                        <span class="text-success"><i class="fa fa-check"></i> Activo</span>
                                        @else
                                        <span class="text-danger"><i class="fa fa-close"></i> Desactivado</span>
                                        @endif
                                    </td>
                            
     

                                    
                                    <td>

                                       @if($au->condicion)

                                        <button type="button" class="btn btn-danger btn-sm" data-id_autores="{{$au->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-times"></i> Desactivar
                                        </button>

                                        @else

                                         <button type="button" class="btn btn-success btn-sm" data-id_autores="{{$au->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-lock"></i> Activar
                                        </button>

                                        @endif
                                       
                                    </td>
                                    @endif


                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{$clientes->appends($data)->links()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Autores</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('autor.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                @include('autor.form')

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
                            <h4 class="modal-title">Actualizar Autor</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('autor.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @method('PUT')

                                {{method_field('patch')}}
                                {{csrf_field()}}
                                <input type="hidden" id="id_autores" name="id_autores" value="">

                                @include('autor.form')

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
                        <form action="{{route('autor.destroy','test')}}" method="POST">
                         {{method_field('delete')}}
                         {{csrf_field()}} 

                            <input type="hidden" id="id" name="id" value="">

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