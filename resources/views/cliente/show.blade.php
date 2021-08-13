@extends('layouts.app')
@section('content')
<style>
    textarea {
        resize: none;
    }
</style>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            </ol>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                       <h3>Detalle del Cliente</h3>
                    </div>
                    <div class="card-header">
                    <p>
                       <b>{{$cliente->tipo_documento}}</b>
                       {{$cliente->num_documento == null ? 'N° 0' : "N° ".$cliente->num_documento }}<br>
                       {{$cliente->nombres ?? '-'}} {{$cliente->apellidos ?? ''}} <br>
                       {!!"<b>Correo:</b> ".$cliente->correocontacto!!} <br>
                       {!!"<b>Télefono:</b> ".$cliente->telefono!!}<br>
                    </div>
                    
                    <div class="card-body">
                            <a href="{{ url('/cliente')}}">
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="fa fa-arrow-left"></i> Regresar
                            </button>
                            </a>
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modalAddContrato">
                                <i class="fa fa-plus"></i> Agregar Contrato
                            </button>
                            <button class="btn btn-info  btn-sm" type="button" data-toggle="modal" data-target="#modalAddAuthor">
                                <i class="fa fa-plus"></i> Agregar autor
                            </button>
                        <br><br><br>
                        <div class="card-body">
                            <div class="row">
                              <div class="col">

                            </div>
                            <div class="col">   
                            </div>
                           </div>
                         </div>
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th style="width: 20%">Info. Producto</th>
                                    <th style="width: 20%">Contrato</th>
                                    <th style="width: 20%">Asesor Responsable</th>
                                    <th style="width: 20%">Orden de Trabajo</th>
                                    <th style="width: 20%">Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                            @forelse($revisiones as $rev)
                            <tr>
                            <td>
                                        {!!"<b>Código Rev:</b> ".$rev->codigo !!} <br>
                                        {!!"<b>Título:</b> ". $rev->titulo !!}<br>
                                        <b>Observación:</b><br>
                                        {{$rev->observaciones == null  ? '-' : $rev->observaciones}}<br>
                                        {!!"<b>Archivo Evaluador:</b>" !!}<br>
                                        @if($rev->archivoevaluador == null || $rev->archivoevaluador == "noimagen.jpg")
                                        Sin archivo evaluador
                                        @else
                                            <a download type="button" href="{{ route('download.revision',['idclientes'=>$rev->idclientes,'id'=>$rev->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>
                                        @endif<br>
                                        {!!"<b>Nivel:</b>" !!} <br>
                                        {{$rev->nombre_revision}} - {{$rev->descripcion}}<br>
                                        {!!"<b>Puntaje:</b> "!!} <br>
                                        {{$rev->puntaje}}<br>

                            </td>
                            @if($rev->archivo_contrato == 'noimagen.jpg')
                                    <td>
                                       No adjuntó Contrato
                                    </td>
                            @else
                                    <td>
                                    <a type="button" href="{{ route('cliente.download.contrato',['id'=>$rev->contrato_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-file-pdf-o"></i> Descargar</a><br><br>
                                        {!!"<b>Monto Inicial:</b> ".$rev->monto_inicial !!} <br>
                                        {!!"<b>Monto Total:</b> ". $rev->monto_total !!}<br>
                                        {!!"<b>Producto:</b> ". $rev->nombreproductos !!}<br>

                                    </a>
                                    </td>
                            @endif
                            <td>
                            {{$rev->revisor}}
                            </td>
                            
                            <td>

                                    @if($rev->has_ot == 0)
                                    <a href="{{URL::action('OrdenTrabajoController@generarOrdenTrabajo',$rev->idrevision)}}">
                                      <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> Crear OT
                                      </button> &nbsp;

                                    </a>
                                    @else
                                    <a  href="{{ route('gestionar.ot',['id'=>$rev->contrato_id]) }}">
                                    <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye"></i> Gestionar
                                      </button> &nbsp;
                                    </a>
                                    @endif
 
                            </td>
                            <td>

                                    @if($rev->has_ot == "0" )
                                    <div class="alert alert-danger" role="alert">
                                    No se ha generado OT
                                    </div>           
                                    @elseif($rev->has_ot == "1" && $rev->verificar_condicion_ot == "0")
                                    <div class="alert alert-warning" role="alert">
                                    Orden de Trabajo Creado sin adjuntar pago
                                    </div>
                                    @elseif($rev->condicion == "1" and $rev->has_ot == "1")
                                    <div class="alert alert-success" role="alert">
                                    En Producción
                                    </div>
                                    @endif
                                    <!--@if($rev->has_ot == "0")
                                    <div class="alert alert-danger" role="alert">
                                    No se ha generado OT
                                    </div>                                    
                                    @elseif($rev->has_ot == "1")
                                    <div class="alert alert-warning" role="alert">
                                    Orden de Trabajo Creado sin adjuntar pago
                                    </div>
                                    @else 
                                    <div class="alert alert-success" role="alert">
                                    Orden de Trabajo en Producción
                                    </div>
                                    @endif-->

                            </td>  

                            </tr>
                            @empty
                            <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!--Inicio del modal adjuntar pago-->
             <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Adjuntar pago</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            <form action="" class="form-horizontal" id="formPago" method="POST" role="form" enctype="multipart/form-data" >
                                <input type="hidden" id="contrato_id" name="contrato_id" class="form-control" readonly>
                                <input type="hidden" class="form-control" id="monto_total_data" name="monto_total_data" readonly>                       
                                <input type="hidden" class="form-control" id="revision_id" name="revision_id" readonly>                       
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
                        <!-- Modal agregar nuevo autor -->
            <div class="modal fade" id="modalAddAuthor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar autor</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                        <form action="{{route('add.autor')}}" class="form-horizontal" id="formCreateClient" method="POST" role="form">
                                <input type="hidden" name="detalle_cliente_id" value="{{$id}}">
                                {{csrf_field()}}
                                @include('cliente.form_create_author')
                        </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- Modal agregar nuevo Contrato -->
            <div class="modal fade" id="modalAddContrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Agregar Contrato</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                        <form action="{{route('agregar.contrato')}}" class="form-horizontal" id="formCreateClient" method="POST" role="form" enctype="multipart/form-data" >
                        {{csrf_field()}}

                        @include('cliente.formcontrato')

                        </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            {{-- Modal para agregar couatores de manera temporal --}}
            <div class="modal fade" id="modalCoautores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Coautores</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            <form action="" class="form-horizontal" id="formCoautores" method="POST" role="form">
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
           
            
        </main>

@endsection
@section('custom-js')
    
<script>


$(function() {
        $('#selectrevision').change(function(){
            $('.muestra').hide();
            $('.' + $(this).val()).show();
        });
    });

    $('#monto_total').bind('blur',function(e){
        var monto_total = $('#monto_total').val();
        var monto_inicial = $('#monto_inicial').val();
        if(monto_total != ''){
            if(monto_total <= 0.00 ){
                $('#monto_total').val('0.00');
                $('#precio_cuotas').val('');

                mostrarMensajeInfo('El monto total debe ser mayor a 0.00');
            }else{
                if(parseFloat(monto_total) < parseFloat(monto_inicial)) {
                $('#precio_cuotas').val('');
                $("#guardar_contrato").addClass('disabled');
                $("#guardar_contrato").prop('disabled', true);
                mostrarMensajeInfo('El monto total no debe ser menor al monto inicial');
                }else{
                $("#guardar_contrato").removeClass('disabled');
                $("#guardar_contrato").prop('disabled', false);
                var total = parseFloat($("#monto_total").val());
                $("#monto_total").val(total.toFixed(2));
                    if(parseFloat(monto_inicial) > 0.00){
                        var resultado = 0;
                        var resultado = parseFloat(monto_total) - parseFloat(monto_inicial);
                        $('#precio_cuotas').val(resultado.toFixed(2));
                    }

                }
            }
        }else{
            $("#monto_total").val("0.00");
        }
        });
      $('#monto_inicial').bind('blur',function(e){
        var monto_inicial = $('#monto_inicial').val();
        var monto_total = $('#monto_total').val();
        if(monto_inicial != ''){
            if(monto_inicial <= 0.00 ){
                $('#monto_inicial').val('0.00');
                $('#precio_cuotas').val('');
                $("#guardar_contrato").addClass('disabled');
                $("#guardar_contrato").prop('disabled', true);
                mostrarMensajeInfo('El monto inicial debe ser mayor a 0.00');
            }else{
                if(parseFloat(monto_inicial) > parseFloat(monto_total)) {
                $('#monto_inicial').val('0.00');
                $('#precio_cuotas').val('');
                $("#guardar_contrato").addClass('disabled');
                $("#guardar_contrato").prop('disabled', true);
                mostrarMensajeInfo('El monto inicial no debe ser mayor al monto total');
                }else{
                $("#guardar_contrato").removeClass('disabled');
                $("#guardar_contrato").prop('disabled', false);
                var total = parseFloat($("#monto_inicial").val());
                $("#monto_inicial").val(total.toFixed(2));
                var resultado = 0;
                var resultado = parseFloat(monto_total) - parseFloat(monto_inicial);
                $('#precio_cuotas').val(resultado.toFixed(2));
                }

            }
        }else{
            $("#monto_inicial").val("0.00");
        }
    });

</script>
@endsection