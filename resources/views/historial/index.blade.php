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

                       <h3>Movimientos Artículos</h3><br/>
                    
                    </div>
                    <div class="card-header">

                      <a href="/resumenmovimientos">
                        
                      <a href="{{ url()->previous() }}">
                        <button type="button" class="btn btn-danger btn-sm">
                         <i class="fa fa-arrow-left"></i> Regresar
                        </button> &nbsp;


                       <button class="btn botonreporte btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-file-archive-o"></i>&nbsp;&nbsp;Ver movimientos recientes
                        </button>

                      </a>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'historial','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            @foreach($historiales as $his)
                            @if ($loop->last)
                            <h6>Código: {{$his->codigo}}</h6>
                            <h6>Título: {{$his->titulo}}</h6>
                            @endif
                            @endforeach
                            </div>
                        </div> 
                        <table class="table table-responsive text-nowrap">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th>Asesores</th>
                                    <th class="guiaarriba">Clasificación : Status</th>
                                    <th>Revistas</th>
                                    @if (Auth::user()->idrol == 1)
                                    <th>Usuario</th>
                                    <th>Contraseña</th>
                                    @endif
                                    <th>Fecha de Movimiento</th>
                                    <th>Fecha Orden</th>
                                    <th>Fecha Llegada</th>
                                    <th>Fecha Asignacion</th>
                                    <th>Fecha Culminacion</th>
                                    <th>Fecha Revisión Interna</th>
<!--                                     <th>Fecha Aprobación Interna</th>
 -->                                <th>Fecha fin de Producción</th>
                                    <th>Fecha Habilitacion</th>
                                    <th>Fecha Envío</th>
                                    <th>Fecha Ajustes de Árbitros</th>
                                    <th>Fecha Aceptación</th>
                                    <th>Fecha Rechazo</th>
                                    <th>Archivo</th>
                                    @if (Auth::id() == 9 or Auth::id() == 1 )   
                                    <th>Eliminar</th>
                                    @endif
                                    @if (Auth::id() == 9 or Auth::id() == 1 )   
                                    <th>Editar</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($historiales as $his)
                               
                                <tr>
                                    <td class="guia">{{$his->nombreasesores}}</td>
                                    <td class="guia">{{$his->nombreclasificaciones}} : {{$his->nombrestatus}}</td>
                                    <td>{{$his->nombrerevista}}</td>
                                    @if (Auth::user()->idrol == 1)
                                    <td>{{$his->usuario}}</td>
                                    <td>{{$his->contrasenna}}</td>
                                    @endif
                                    <td>{{$his->created_at}}</td>                      
                                    <td>{{$his->fechaOrden}}</td>                      
                                    <td>{{$his->fechaLlegada}}</td>                      
                                    <td>{{$his->fechaAsignacion}}</td>                      
                                    <td>{{$his->fechaCulminacion}}</td>      
                                    <td>{{$his->fechaRevisionInterna}}</td> 
<!--                                     <td>{{$his->fechaAprobacion}}</td>                                           
 -->                                    <td>{{$his->fechaEnvioPro}}</td>                      
                                    <td>{{$his->fechaHabilitacion}}</td>                      
                                    <td>{{$his->fechaEnvio}}</td>     
                                    <td>{{$his->fechaAjustes}}</td>
                                    <td>{{$his->fechaAceptacion}}</td>                      
                                    <td>{{$his->fechaRechazo}}</td>    
                                    @if($his->archivo == 'noimagen.jpg')
                                    <td>
                                       -
                                    </td>
                                    @else
                                    <td>
                                    <a href="{{route('downloadhistorial', $his->id) }}" id="archivo1">Descargar</a>        
                                    </a>
                                    </td>
                                    @endif       
                                    @if (Auth::id() == 9 or Auth::id() == 1 )   
                                    <td>
                                    <button class="btn btn-danger" data-hisdelete="{{$his->id}}" data-toggle="modal" data-target="#delete">Eliminar</button>

                                    </td>      
                                    @endif
                                    @if (Auth::id() == 9 or Auth::id() == 1 )   
                                    <td>
                                    <button type="button" class="btn btn-info btn-md" data-id_historial="{{$his->id}}" data-id_articulo="{{$his->idarticulo}}" data-codigo="{{$his->codigo}}"  data-titulo="{{$his->titulo}}" data-id_asesor="{{$his->idasesor}}"  data-fechamovimiento="{{$his->created_at}}" data-fechaajustes="{{$his->fechaAjustes}}" data-fecharevisioninterna="{{$his->fechaRevisionInterna}}"   data-fechaorden="{{$his->fechaOrden}}" data-fechallegada="{{$his->fechaLlegada}}" data-fechaasignacion="{{$his->fechaAsignacion}}" data-fechaculminacion="{{$his->fechaCulminacion}}" data-fechaenviopro="{{$his->fechaEnvioPro}}" data-fechahabilitacion="{{$his->fechaHabilitacion}}" data-fechaenvio="{{$his->fechaEnvio}}" data-fechaaceptacion="{{$his->fechaAceptacion}}" data-fecharechazo="{{$his->fechaRechazo}}" data-idclasificaciones="{{$his->idclasificacion}}" data-idstatu="{{$his->idstatu}}" data-idrevista="{{$his->idrevista}}" data-archivo="{{$his->archivo}}" data-toggle="modal" data-target="#abrirmodalEditar">
                                          <i class="fa fa-edit"></i> Editar
                                        </button> &nbsp;
                                    </td>      

                                    @endif

                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">Confirmar su Eliminacion</h4>
                    </div>
                    <form action="{{route('historial.destroy','test')}}" method="post">
                            {{method_field('delete')}}
                            {{csrf_field()}}
                        <div class="modal-body">
                                <h6 class="text-center">
                                    Seguro que desea eliminar los datos?
                                </h6>
                                <input type="hidden" name="historial_id" id="historial_id" value="">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancelar</button>
                            <button type="submit" class="btn btn-danger">Si, Eliminar</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>

                <div class="modal fade bd-example-modal-lg" id="abrirmodalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Actualizar Movimiento Historial</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('historial.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @method('PUT')

                                {{method_field('patch')}}
                                {{csrf_field()}}
                                <input type="hidden" id="id_historial" name="id_historial" value="">

                                @include('historial.form')

                            </form>
                        </div>

            </div>
           
            



        </main>
        @section('custom-js')

        <script>
$(document).ready(function(){
     
    
     $(function () {
     $('select').selectpicker();
     $('.datepicker').datepicker({
         format: 'yyyy-mm-dd'
     }
     
     
     );
 
 });
 $('.datepicker').on("show", function(e){
        e.preventDefault();
        e.stopPropagation();
        }).on("hide", function(e){
                e.preventDefault();
                e.stopPropagation();
    });
});
        </script>

        @endsection


@endsection