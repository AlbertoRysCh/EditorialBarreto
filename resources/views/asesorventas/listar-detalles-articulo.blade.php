@extends('layouts.app')
@section('content')

<main class="main">

 <div class="card-body">

    <a href="{{ url('/libros/lista')}}">
    <button type="button" class="btn btn-danger btn-sm">
        <i class="fa fa-arrow-left"></i> Regresar
    </button>
    </a>
    <br><br><br>
    <form action="{{route('guardar.autores')}}" method="POST" id="formAutores">
        {{csrf_field()}}
            {{-- <input class="form-control" type="text" name="ordentrabajo_id" value="{{$ordenTrabajo->id}}"> --}}
            <div class="form-group row">

                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="codigo">Código de título</label>
                    <input type="text" id="codigo" name="codigo" readonly class="form-control" value="{{$ordenTrabajo->codigo}}">

                 </div>

                 <div class="col-md-4">
                    <label class="form-control-label labeldetalles" for="titulo">Título del Libro</label>
                    <input  readonly class="form-control" id="titulo" name="titulo" value="{{$ordenTrabajo->titulo_coautoria}}">
                </div>



            </div> 
            <div class="form-group row">
                <div class="col-md-4">
                    <label class="form-control-label labeldetalles">Cantidad coautores actuales</label>
                    <input  readonly class="form-control" id="cantidadAutores" name="cantidadAutores" value="{{count($clientes)}}">
                </div>
                <div class="col-md-4">
                    <label class="form-control-label labeldetalles">Cantidad coautores nuevos</label>
                    <input  type="hidden" readonly class="form-control" id="cantidadAutoresReales" name="cantidadAutoresReales" value="{{count($clientes)}}">
                    <input  type="text" readonly class="form-control" id="cantidadAutoresNuevos" name="cantidadAutoresNuevos" value="0">
                </div>

            </div> 

            <div class="form-group row border">


                <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bordearriba">
                        <th style="width:5%">Nº</th>
                        <th style="width: 15%">DNI/C.C</th>
                        <th style="width: 10%">Tip.Doc</th>
                        <th style="width: 10%">Tip.Grado</th>
                        <th style="width: 20%">Nombres</th>
                        <th style="width: 20%">Apellidos</th>
                        <th style="width: 10%">Especialidad</th>
                        <th style="width: 15%">Correo</th>
                        <th style="width: 10%">Teléfono</th>
                        <th style="width: 5%">Agregar</th>
                        <th style="width: 5%">Eliminar</th>

                    </tr>
                </thead>

                <tbody class="tabla_autores">
                @php $i=0; $i++;@endphp

                <tr id='trLinea_{{$i}}'>
                    <th scope="row" id="numeroOrden_{{$i}}">{{$i}}</th>
                    <td><input name="num_documento_aux" id="num_documento_aux" type="text" class="form-control solo_numeros" value="" maxlength="15" onblur="buscarAutor({{$i}})"> </td>
                    <td>
                        <select class="form-control" name="tipo_doc_aux" id="tipo_doc_aux">
                            <option disabled value="" selected>== Seleccione ==</option>
                            @foreach($tipoDocumentos as $items)
                            <option value="{{$items->id}}">{{$items->nombre}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="tipo_grado_aux" id="tipo_grado_aux">
                            <option disabled value="" selected>== Seleccione ==</option>
                            @foreach($grados as $items)
                               <option value="{{$items->id}}">{{$items->nombre}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input name="nombres_aux" id="nombres_aux" type="text" class="form-control solo_letras" value="" maxlength="100"></td>
                    <td><input name="apellidos_aux" id="apellidos_aux" type="text" class="form-control solo_letras" value="" maxlength="100"></td>
                    <td><input name="especialidad_aux" id="especialidad_aux" type="text" class="form-control solo_letras" value="" maxlength="50"></td>
                    <td><input name="correocontacto_aux" id="correocontacto_aux" type="text" class="form-control" value="" maxlength="100"></td>
                    <td><input name="telefono_aux" id="telefono_aux" type="text" class="form-control solo_numeros" value="" maxlength="9"></td>
                    <td>
                        <span class="btn btn-success btn-outline-success btn-block add_cliente"><i class="fa fa-plus"></i></span>
                    </td>
                    <td>
                        <span class="show_wait_load" style="font-size: small;display: none">
                            <div class="text-center">
                                        <button class="btn btn-success" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                            </div> 
                
                        </span>
                        {{-- <span onclick="quitarLinea({{$i}})" class="btn btn-danger btn-outline-danger btn-block"><i class="fa fa-close"></i></span> --}}
                    </td>
                </tr>
                @foreach($clientes as $aut)
                @php $i++;@endphp
                <tr id='trLinea_{{$i}}'>
                <th scope="row" id="numeroOrden_{{$i}}">{{$i}}</th>
                <td>
                    <input type="text" name="num_documento_{{$i}}" class="form-control" value="{{$aut->num_documento}}" readonly> 
                </td>
                <td><input type="text" name="tipo_doc_{{$i}}"  class="form-control" value="{{$aut->tipo_documento}}" readonly></td>
                <td><input type="text" name="tipo_grado_{{$i}}"  class="form-control" value="{{$aut->nombre}}" readonly></td>
                <td><input type="text" name="nombres_{{$i}}"  class="form-control" value="{{$aut->nombres}}" readonly></td>
                <td><input type="text" name="apellidos_{{$i}}"  class="form-control" value="{{$aut->apellidos}}" readonly></td>
                <td>
                    <input type="hidden" name="nuevoCliente_{{$i}}" id="nuevoCliente_{{$i}}" value="0">
                    <input type="text" name="especialidad_{{$i}}" class="form-control" value="{{$aut->especialidad}}" readonly>
                </td>
                <td><input type="text" name="correocontacto_{{$i}}" class="form-control" value="{{$aut->correocontacto}}" readonly></td>
                <td><input type="text" name="telefono_{{$i}}" class="form-control" value="{{$aut->telefono}}" readonly></td>
                <td>
                    {{-- <span class="btn btn-outline-info btn-block"><i class="fa fa-check"></i></span> --}}
                </td>
                <td>
                    {{-- <span onclick="quitarLinea({{$i}})" class="btn btn-danger btn-outline-danger btn-block"><i class="fa fa-close"></i></span> --}}
                </td>
                </tr>
                @endforeach
                <div class="row">
                    <div class="col-sm-10">
                        <h5>Coautores en el Libro</h5>
    
                    </div>
                    <div class="col-sm-2 save_authors" style="display:none;">
                        <button type="submit" class="btn btn-success btn-add-cliente"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>
                <br>
                </tbody>

                </table>
                </div>

                </div>
            </form>
            <div class="form-group row border">


                <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th style="width:10%">Nº</th>
                        <th style="width: 20%">Info.Cliente</th>
                        <th style="width: 10%">Asesor de venta</th>
                        <th style="width: 10%">Estado</th>
                        <th style="width: 20%">Contrato</th>
                        <th style="width: 30%">Adjuntar Pago</th>
                    </tr>
                </thead>
        
                <tbody>
                @forelse($coautoresPendientes as $coautor)
                @php
                $cliente = json_decode($coautor->cliente)
                @endphp
                <th scope="row">{{$loop->iteration}}</th>
                <td>
                    {!!"<b>Especialidad:</b> ".$cliente->especialidad !!} <br>
                    {!!"<b>Grado:</b> ". $coautor->nombre !!}<br>
                    {!!"<b>Nombres:</b> ". $cliente->nombres !!}<br>
                    {!!"<b>Apellidos:</b> ". $cliente->apellidos !!}<br>
                    {!!"<b>Tipo Doc.</b> ". $cliente->tipo_documento !!}<br>
                    {!!"<b>Número:</b> ". $cliente->num_documento !!}<br>
                    {!!"<b>Correo:</b> ". $cliente->correocontacto !!}<br>
                    {!!"<b>Teléfono:</b> ". $cliente->telefono !!}<br>
                
                </td>
                <td>{{$cliente->asesor_venta_nombre ?? '-'}}</td>
                <td>
                    <span class="text-{{$coautor->contrato_id=="0" ? 'warning' : 'success'}}">@if($coautor->contrato_id=="0")
                    Pendiente
                    @elseif($coautor->contrato_id!=="0" && $coautor->estado_pago == "0")
                    Con contrato
                    @elseif($coautor->contrato_id!=="0" && $coautor->estado_pago == 3)
                    Pago inicial aprobado
                    @endif
                    </span>

                </td>
                <td>
                        @if($coautor->contrato_id == 0)
                        <button type="button" class="btn btn-primary btn-md"
                        data-id="{{$coautor->id}}" 
                        data-tipodocu="{{$cliente->tipo_documento}}"
                        data-numdocu="{{$cliente->num_documento}}"
                        data-nombres="{{$cliente->nombres}}"
                        data-apellidos="{{$cliente->apellidos}}" 
                        data-toggle="modal" data-target="#modalContratoCoautor">
                        <i class="fa fa-file-pdf-o"></i> Generar Contrato
                      </button>
                        @else
                        <a type="button" href="{{ route('gerencia.download.contratocoautoria',['id'=>$coautor->contrato_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-file-pdf-o"></i> Descargar</a>
                        @endif
                       &nbsp;
                    
                </td>
                <td>
                    @if($coautor->contrato_id != 0 && $coautor->estado_pago == 0)
                    <button class="btn btn-info btn-md"
                    data-id="{{$coautor->id}}"
                    data-uuid="{{$coautor->uuid}}"
                    data-montototal="{{$coautor->monto_total}}"
                    data-codigo_contrato="{{$coautor->codigo_contrato}}"
                    data-titulo="{{$coautor->titulo_contrato}}"
                    data-monto_total="{{$coautor->monto_total}}"
                    data-toggle="modal" data-target="#modalPago">
                    <i class="fa fa-credit-card"></i> Pago
                    </button>
                    @elseif($coautor->contrato_id != 0 && $coautor->estado_pago == 1)
                    <span class="text-warning"><i class="fa fa-clock-o"></i> <b>Pendiente por aprobar</b></span>
                    @elseif($coautor->contrato_id != 0 && $coautor->estado_pago == 2)
                    <span class="text-danger"><i class="fa fa-close"></i> Pago Inicial Rechazado</span><br>
                        @foreach($cuotas as $key => $value)
                        @if($coautor->contrato_id == $value->contrato_id)
                            <button class="btn btn-success btn-md"
                            data-idcuota="{{$value->id}}"
                            data-idcoautor="{{$coautor->id}}"
                            data-idordentrabajo="{{$value->idordentrabajo}}"
                            data-observaciones="{{$value->observaciones}}"
                            data-fecha_cuota="{{$value->fecha_cuota}}"
                            data-toggle="modal" data-target="#modalActualizarPagoCoautoria">
                            <i class="fa fa-refresh"></i> Actualizar pago
                            </button>
                        @endif
                        @endforeach
                    @elseif($coautor->contrato_id != 0 && $coautor->estado_pago == 3)
                    <button type="button" id="nuevacuota" class="btn btn-success btn-sm" data-toggle="modal"
                    data-target="#modalCuotas" data-backdrop="static" data-keyboard="false"
                    
                    data-idcoautor="{{$coautor->id}}"
                    data-contrato_id="{{$coautor->contrato_id}}" 
                    data-montototal="{{$coautor->monto_total}}"
                    ><i class="fa fa-credit-card"></i> Ingresar nueva cuota
                    </button>
                    <a href="{{URL::action('AsesorventaController@historialCuotas',$coautor->contrato_id)}}">
                                      <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-eye"></i> Gestión de Cuotas
                    </button> 
                    @endif
                </td>
                </tr>
                @empty
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="4" class="font-weight-bold text-danger"><h5>No hay coautores pendientes por aprobación.</h5></td>
                </tr>
                @endforelse
                <div class="row">
                    <div class="col-sm-10">
                        <h5>Coautores por aprobación</h5>
        
                    </div>
                </div>
                <br>
                </tbody>
        
                </table>
                {{$coautoresPendientes->appends($data)->links()}}
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
                            <form action="" class="form-horizontal" id="formPagoCoautor" method="POST" role="form" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                <input type="hidden" id="contrato_id" name="contrato_id" class="form-control" readonly>
                                <input type="hidden" class="form-control" name="coautor_id" readonly>                       
                                <input type="hidden" class="form-control" name="codigo" value="{{$ordenTrabajo->codigo}}" readonly>                       
                                <input type="hidden" id="ordentrabajo" name="ordentrabajo" readonly class="form-control" value="{{$ordenTrabajo->idordentrabajo}}">
                                @include('asesorventas.form-pago-coautoria')
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Inicio del modal actualizar pago de coautoria-->
            <div class="modal fade" id="modalActualizarPagoCoautoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Actualizar pago</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            <form action="" class="form-horizontal" id="formActualizarPagoCoautoria" method="POST" role="form" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                <input type="hidden" class="form-control" name="coautor_id" readonly>                       
                                <input type="hidden" id="cuota_id" name="cuota_id" class="form-control" readonly>
                                <input type="hidden" class="form-control" id="orden_trabajo_id" name="orden_trabajo_id" readonly>                       

                                @include('asesorventas.pago-coautoria-actualizar')
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                
            </div>

                    <!--Inicio del modal generar contrato de coautoría-->
        <div class="modal fade" id="modalContratoCoautor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header cabeceramodal">
                        <h4 class="modal-title">Generar contrato</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                    </div>
                   
                    <div class="modal-body">
                            <form action="" method="POST" name="formGenerarContratoCo" id="formGenerarContratoCo" enctype="multipart/form-data" onsubmit="return ValidatePrice();">
                            <input type="hidden" id="coautor_id" name="coautor_id" value="">
                            <input  type="hidden" class="form-control" id="titulo_contrato" name="titulo_contrato" value="{{$ordenTrabajo->titulo_coautoria}}">

                            {{csrf_field()}}
                            @include('asesorventas.contrato_coautoria')
                        </form>
                    </div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal fade " id="historialCuotas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header cabeceramodal">
                    <input type="hidden" class="form-control" id="contra" name="contra" >

                        <h4 class="modal-title">Historial Cuotas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <table class="table table-lg" id="historialTable">
                            <thead>
                                <tr class="bg bordearriba">
                                    
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
     
                            </tbody>
                            </table>

                    </div>

                    </div>
                </div>
    </div>

  </main>
  @include('asesorventas.partials.cargar-cuota-coautoria')

@section('custom-js')
<script src="{!! asset('js/gestionar-coautores.js') !!}"></script>

<script>

         // Generar contrato
        $("#modalContratoCoautor").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          $("#coautor_id").val(btn.attr('data-id'));
          var action = '{{route('contrato.coautoria')}}';
          $("#formGenerarContratoCo").prop("action", action);
          var contrato_id = $("#contrato_id").val(btn.attr('data-contrato_id'));
          $("#codigo_contrato").val(btn.attr('data-codigo'));
          $("#tipo_documentos").val(btn.attr('data-tipodocu'));
          $("#num_documento").val(btn.attr('data-numdocu'));
          $("#nombres_contrato").val(btn.attr('data-nombres'));
          $("#apellidos_contrato").val(btn.attr('data-apellidos'));
          $("#asesor_venta_id").val(btn.attr('data-asesor_venta_id'));
          if(contrato_id[0].value == 0){
            $("#monto_total").val('0.00');
          }else{
            $("#monto_total").val(btn.attr('data-monto_total'));
          }
          $(".btn-contrato-coautor").removeClass('disabled');
          $(".btn-contrato-coautor").prop('disabled', false);
          

        }
      });
    // Cierre de Modal  


     $("#modalPago").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          var action = '{{route('store.pago.coautor')}}';
          $("#formPagoCoautor").prop("action", action);
          $('[name="coautor_id"]').val(btn.attr('data-id'));
          $("#contrato_id").val(btn.attr('data-uuid'));
          $("#codigo_data").val(btn.attr('data-codigo_contrato'));
          $("#monto_total").val(btn.attr('data-montototal'));

          $("#titulo_data").val(btn.attr('data-titulo'));

        }
      });
      $("#modalActualizarPagoCoautoria").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('idcuota');
        if (id > 0) {

          var action = '{{route('update.pago.coautor')}}';
          $("#formActualizarPagoCoautoria").prop("action", action);
          $("#cuota_id").val(btn.attr('data-idcuota'));
          $('[name="coautor_id"]').val(btn.attr('data-idcoautor'));
          $("#orden_trabajo_id").val(btn.attr('data-idordentrabajo'));
          $("#observaciones_update").val(btn.attr('data-observaciones'));
          $("#fecha_cuota_update").val(btn.attr('data-fecha_cuota'));
        }
      });

      $("#modalCuotas").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('idcuota');

        var action = '{{route('guardarcuotacoautoria')}}';
          $("#formCuotasCoautoria").prop("action", action);
          $("#cuota_id").val(btn.attr('data-idcuota'));
          $('[name="coautor_id"]').val(btn.attr('data-idcoautor'));

          $("#contratoss_id").val(btn.attr('data-contrato_id'));

          $("#precio_modal_cuota").val(btn.attr('data-montototal'));

          
        var contrato_id = $("#contratoss_id").val();
         $.ajax({  //create an ajax request to display.php
          type: "GET",
          url: "../../getpagopendiente/"+contrato_id,  
          dataType: "json",
          beforeSend: function () {
          },     
          success: function (data) {
            $('#total_pendiente').val(data);

          }
        });

      });

      $("#historialCuotas").on("show.bs.modal", function (e) {

        var btn = $(e.relatedTarget);
        var id = btn.data('idcuota');

          $("#contra").val(btn.attr('data-contrato_id'));

        var contrate = $("#contra").val();
         $.ajax({  //create an ajax request to display.php
          type: "GET",
          url: "../../gethistorialcuotas/"+contrate,  
          dataType: "json",
          beforeSend: function () {
          },     
          success: function(response) {
            var trHTML = '';

            $.each(response, function (i, item) {
            trHTML += '<tr>' +
                "<td align='center'>" + item.fecha_cuota + "</td>" +
                "<td align='center'>" + item.monto + "</td>" +
                "<td align='center'>" + item.statu + "</td>" +
              '</tr>';
            });
            $('#historialTable').append(trHTML);

          }
        });

      });

        $("#nuevacuota").click(function(e) { 
        e.preventDefault();
        
      });

      $('#total_pendiente').on('keyup',function(){
        var val = $('#total_pendiente').val();
        if (val === 0) {
            $("#btn_Validar").attr("disabled","disabled");
        }else{
            $("#btn_Validar").removeAttr("disabled","disabled");
        }
    });

    $(document).ready(function(){

        var val = $('#total_pendiente').val();
        console.log(val)
        if (val == 0) {
            $("#btn_Validar").removeAttr("disabled","disabled");

        }else{
            $("#btn_Validar").attr("disabled","disabled");

        }
        
});



</script>
@endsection
@endsection

