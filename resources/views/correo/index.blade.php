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

                       <h3>Reporte Correos a Autores</h3><br/>
                      
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'correo','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="row input-daterange">
                                   
                                <div class="col-md-3 input-group date" id='datetimepicker6'>
                                <input type="text" autocomplete="off" class="form-control datepicker" id="fecha_inicio" placeholder="Fecha Inicio"  name="buscarFechaInicio"  >              
                            </div>
                            <div class="col-md-3 input-group date" id='datetimepicker7'>
                                <input type="text" autocomplete="off" class="form-control datepicker" id="fecha_fin" placeholder="Fecha Final"  name="buscarFechaFinal"  >              
                            </div>

                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>


                            {{Form::close()}}
                            </div>
                        </div>
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                   
                                    <th width="15%">Nombre y Apellidos</th>
                                    <th width="25%">Código - Título</th>
                                    <th width="10%">Fecha</th>
                                    <th>Print</th>
                                    <th>Observacion</th>
                                    @if (Auth::id() == 24 or Auth::id() == 1 or Auth::id() == 46  or Auth::id() == 48 or Auth::id() == 57 or Auth::id() == 59 or Auth::id() == 9) 
                                    <th>Eliminar</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>

                               @foreach($correos as $co)
                               
                                <tr>
                                    
                                    <td>{{$co->nombres}} {{$co->apellidos}}</td>
                                    <td>{{$co->codigo}} - {{$co->titulo}}</td>
                                    <td>{{$co->fecha_correo}}</td>
                                    @if($co->archivo == 'noimagen.jpg')
                                    <td>
                                       -
                                    </td>
                                    @else
                                    <td>
                                    <a href="{{route('downloadcorreo', $co->idhistorial) }}">Descargar</a>        
                                    </a>
                                    </td>
                                    @endif
                                    <td>{{$co->observacion}}</td>
                                    @if (Auth::id() == 24 or Auth::id() == 46 or Auth::id() == 1  or Auth::id() == 48 or Auth::id() == 57 or Auth::id() == 59 or Auth::id() == 9) 

                                    <td>
                                    <button class="btn btn-danger" data-idhiscorre="{{$co->idhistorial}}" data-toggle="modal" data-target="#delete">Eliminar</button>

                                    </td> 
                                    @endif

                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                        {{$correos->appends($data)->links()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        
                <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="myModalLabel">Confirmar su Eliminacion</h4>
                        </div>
                        <form action="{{route('correo.destroy','test')}}" method="post">
                                {{method_field('delete')}}
                                {{csrf_field()}}
                            <div class="modal-body">
                                    <h6 class="text-center">
                                        Seguro que desea eliminar los datos?
                                    </h6>
                                    <input type="hidden" name="idhiscorre" id="idhiscorre" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancelar</button>
                                <button type="submit" class="btn btn-danger">Si, Eliminar</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                            

           
            
        </main>

@endsection
@push('custom-js')
    
<script>
    // Cambiar de estado del prospecto
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });


    
</script>
@endpush
