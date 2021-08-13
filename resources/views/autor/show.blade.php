@extends('layouts.app')
@section('content')
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                        @foreach($obj as $o)
                            <h2>Articulos correspondientes de {{$o->nombres}} {{$o->apellidos}}</h2><br/>
                        @endforeach
                        <p>
                        
                        <p>
                       <a href="{{ url('/autor')}}">
                                       <button type="button" class="btn btn-danger btn-sm">
                                         <i class="fa fa-arrow-left"></i> Regresar
                                       </button> &nbsp;
                        </a>
                        {{-- <a href="{{ url('/__')}}">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-arrow-down"></i> Exportar Excel
                                       </button> &nbsp;
                        </a> --}}
                            <button id="exportarExcelid" type="button" class="btn btn-success btn-sm">
                                <i class="fa fa-arrow-down"></i> Exportar Excel
                            </button> &nbsp; 
                        <a href="{{url('pdfAutor',$autores->id)}}">
                                       <button type="button" class="btn btn-primary btn-sm">
                                       <i class="fa fa-file-pdf-o"></i> Descargar Reporte
                                       </button> &nbsp;
                        </a>
                        <a href="{{url('pdfAutorStatus',$autores->id)}}">
                                       <button type="button" class="btn btn-dark btn-sm">
                                       <i class="fa fa-file-pdf-o"></i> Reporte por Estados
                                       </button> &nbsp;
                        </a>
                        <a href="{{URL::action('CorreoController@show',$autores->id)}}">
                                       <button type="button" class="btn btn-info btn-sm">
                                       <i class="fa fa-file-pdf-o"></i> Correos enviados
                                       </button> &nbsp;
                        </a>
                    </div>
                    <form id="formExportarExcelAutor" action="" method="post" target="_self"> 
                                {{csrf_field()}}  
                            </form>

                            <div class="col-md-2">
                                <input type="hidden" class="form-control" id="autorid" value="{{$id}}" >              
                            </div>
                    
                    <div class="card-body">
                           <div class="row">
                             <div class="col-2">
                                <p style="margin-bottom: -10px;">
                                <strong>Total Artículos:</strong>
                                {{count($detalles)}}
                                </p> 
                           </div>
                          
                          </div>
                        </div>     
            <div class="form-group row">
                        </div>
                        <table class="table table-bordered table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                <th>N°</th>
                                <th>Código</th>
                                <th>Título</th>
                                <th>Autores</th>
                                <th>Nivel Index</th>
                                <th>Fecha Orden</th>
                                <th>Fecha Culminacion</th>
                                <th>Fecha Envío</th>
                                <th>Asesor</th>
                                <th>Revista</th>
                                <th>Clasificacion</th>
                                <th>Estado Artículo</th>
                                @if (Auth::id() == 24 or Auth::id() == 1 or Auth::id() == 46 or Auth::id() == 48 or Auth::id() == 50  or Auth::id() == 57 or Auth::id() == 59 or Auth::id() == 9) 
                                <th>Adjuntar</th> 
                                @endif
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($detalles as $arc)
                               <tr>

                               <td>{{$loop->iteration}}</td>

                                   <td>{{$arc->codigo}}</td>
                                   <td>{{$arc->titulo}}</td>
                                   <td>
                                   @foreach($listautores as $list)
                                   @if ($arc->codigo == $list->codigo )
                                   <p>{{$list->nombres}} {{$list->apellidos}}</p>
                                   @endif
                                   @endforeach
                                   </td>
                                   <td>{{$arc->nombreindex}}</td>
                                   <td>{{$arc->fechaOrden}}</td>
                                   <td>{{$arc->fechaCulminacion}}</td>
                                   <td>{{$arc->fechaEnvio}}</td>
                                   <td>{{$arc->asesoresnombres}}</td>
                                   <td>{{$arc->nombrerevistas}} ({{$arc->revistapais}})</td>
                                   <td>{{$arc->nombreclasificacion}}</td>
                                   <td>{{$arc->nombrestatus}}</td>
                                   @if (Auth::id() == 24 or Auth::id() == 1 or Auth::id() == 46 or Auth::id() == 48 or Auth::id() == 50  or Auth::id() == 57 or Auth::id() == 59 or Auth::id() == 9) 

                                    <td>
                                    <button class="btn btn-success btn-md" type="button" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                                    data-target="#abrirmodal" data-id="{{$arc->idarticulos}}">
                                    <i class="fa fa-envelope-open-o"></i>&nbsp;&nbsp;Correo
                                    </button>
                                    </td> 
                                    @endif


                               </tr>

                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </main>

                    <!--Inicio del modal agregar-->
                    <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Correo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="{{route('correo.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                               
                                {{csrf_field()}}
                                
                                @include('autor.correo')

                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

        @push('scripts')
        <script>

         $(document).ready(function(){
     
    $(function () {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",

    }

    
    );

});

});

//exportar excel clasificacion
$('#exportarExcelid').click(function (e){
    e.preventDefault();

    var autorid = $("#autorid").val();

    var url = "exportarexcel/exportarexcel__" + autorid;
    $('#formExportarExcelAutor').attr('action',url);
    $('#formExportarExcelAutor').submit();

});

        </script>
@endpush
@endsection