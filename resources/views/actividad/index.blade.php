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

                       <h3>Actividades</h3><br/>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'actividad','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                                   
                                    <th>Asesor</th>
                                    <th>Actividad</th>
                                    <th>Avance 8:00am</th>
                                    <th>Avance 6:00pm</th>
                                    <th>Acumulado %</th>

                                    <th>Fecha</th>

                                    <!-- <th>Editar</th>-->
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($actividades as $act)
                               
                                <tr>
                                    
                                    <td>{{$act->nombreusuario}}</td>
                                    @if($act->idactividadeslibros != 2)
                                    <td>{{$act->clasificacionesnombre}} : {{$act->titulo}}</td>
                                    @else
                                    <td> {{$act->observacion}}</td>
                                    @endif
                                    <td>{{$act->avancemañana}}%</td>
                                    @if($act->avancetarde !=0)
                                    <td>{{$act->avancetarde}}%</td>
                                    @else
                                    <td>0%</td>
                                    @endif

                                    <td>{{$act->avancemañana + $act->avancetarde}}%</td>  


                                    <td>{{$act->created_at}}</td>

                            
                               
                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{$actividades->render()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Actividad</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('actividad.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                @include('actividad.form')

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
                            <h4 class="modal-title">Actualizar Actividad</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('actividad.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                
                                {{method_field('patch')}}
                                {{csrf_field()}}

                                <input type="text" id="id_actividad" name="id_actividad" value="">
                                
                                @include('actividad.form')

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