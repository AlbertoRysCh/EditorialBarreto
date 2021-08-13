@extends('layouts.app')
@section('content')
<style>
    textarea {
        resize: none;
    }
.onoffswitch {
    position: relative; width: 73px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "ON";
    padding-left: 10px;
    background-color: #34A7C1; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "OFF";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 39px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
</style>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            </ol>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                       <h3>Foráneos</h3><br/>
                      
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'gerencia','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                               <strong>Total registros:</strong>
                               {{count($count)}}
                               </p> 
                            </div>
                            <div class="col">
      
                            </div>
                           </div>
                         </div>
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                   
                                    <th style="width: 20%">Info. Artículo</th>
                                    <th style="width: 10%">Info. Cliente</th>
                                    <th style="width: 10%">Asesor Responsable</th>
                                    <th style="width: 10%">Revisado por</th>
                                    <th style="width: 15%">Estado</th>
                                   @if(auth()->user()->id != 40) 
                                    <th>Editar</th>
                                    @endif
                                    <th>Contrato</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $load_file=0;
                                $estado_revision=0;
                                @endphp
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
                                    <td>
                                        @if($rev->revision_contrato_id=="0")
                                        <span class="text-warning"><i class="fa fa-user"></i> Pendiente</span>
                                        {{-- @elseif($rev->autor=="2")
                                        <span class="text-primary"><i class="fa fa-user"></i> En revisión técnica</span> --}}
                                        {{-- @elseif($rev->autor=="3")
                                        <span class="text-info"><i class="fa fa-user"></i> En Gerencia</span> --}}
                                        @elseif($rev->autor=="4" && $rev->revision_contrato_id!="0")
                                        <span class="text-success"><i class="fa fa-user"></i> Con contrato</span>
                                        @elseif($rev->autor=="1")
                                        <span class="text-success"><i class="fa fa-user"></i> Cliente</span>
                                        @else
                                        <span class="text-warning"><i class="fa fa-user"></i> Pendiente</span>
                                        @endif
                                        <br>
                                        {{$rev->tipo_documento}} 
                                        {{$rev->num_documento == null ? 'N° 0' : "N° ".$rev->num_documento }}<br>
                                        {{$rev->clientesnombres ?? '-'}} {{$rev->apellidos ?? ''}} <br>
                                        {!!"<b>Correo:</b> ".$rev->correocontacto!!} <br>
                                        {!!"<b>Télefono:</b> ".$rev->telefono!!}<br>
                                        {!!"<b>Contrato:</b>" !!}<br>
                                        @if($rev->contrato_id == 0)
                                        Sin contrato
                                        @else
                                            <a type="button" href="{{ route('gerencia.download.contrato',['id'=>$rev->contrato_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-file-pdf-o"></i> Descargar</a>
                                        @endif<br>
                                    </td>
                                    <td>{{$rev->asesornombres}}</td>
                                    <td>{{$rev->revisor}}</td>


                                    <td>
                                        @if($rev->condicion=="1")
                                        <span class="text-success"><i class="fa fa-check"></i> Activo</span>
                                        @else
                                        <span class="text-danger"><i class="fa fa-close"></i> Desactivado</span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->id != 40) 

                                    <td>
                                        <button type="button" class="btn btn-info btn-md"
                                          data-id="{{$rev->id}}" data-codigo="{{$rev->codigo}}" 
                                          data-titulo="{{$rev->titulo}}" data-clientesid="{{$rev->clientesid}}"
                                          data-observaciones="{{$rev->observaciones}}"  
                                          data-idnivelarticulo="{{$rev->idnivelibros}}"  
                                          data-puntaje="{{$rev->puntaje}}"  
                                          data-archivoevaluador="{{$rev->archivoevaluador}}"  
                                          data-estado_revision="{{$rev->estado_revision}}"  
                                          data-toggle="modal" data-target="#modalRegistroGerencia">
                                          <i class="fa fa-edit"></i> Editar
                                        </button> &nbsp;
                                        @endif
                                        @php 
                                        $load_file=$rev->archivoevaluador == null || $rev->archivoevaluador == "noimagen.jpg" ? 1 : $load_file;
                                        $estado_revision=$rev->estado_revision == 1 ? 1 : $estado_revision;
                                        @endphp
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-md"
                                          data-id="{{$rev->id}}" data-contrato_id="{{$rev->contrato_id}}"  
                                          data-codigo="{{$rev->codigo}}" 
                                          data-idgrado="{{$rev->idgrado}}"
                                          data-titulo="{{$rev->titulo}}" data-clientesid="{{$rev->clientesid}}"
                                          data-num_documento="{{$rev->num_documento}}"
                                          data-nombres="{{$rev->clientesnombres}}" data-apellidos="{{$rev->apellidos}}" 
                                          data-correo="{{$rev->correocontacto}}" data-telefono="{{$rev->telefono}}" 
                                          data-tipo_documento="{{$rev->tipo_documento}}"
                                          data-monto_inicial="{{$rev->monto_inicial}}"
                                          data-monto_total="{{$rev->monto_total}}"
                                          data-check_cuotas="{{$rev->check_cuotas}}"
                                          data-num_cuotas="{{$rev->num_cuotas}}"
                                          data-precio_cuotas="{{$rev->precio_cuotas}}"
                                          data-asesor_venta_id="{{$rev->asesor_venta_id}}"
                                          data-observacion_contrato="{{$rev->observacion_contrato}}"
                                          data-domicilio="{{$rev->domicilio == "null" ? '' : $rev->domicilio}}"
                                          data-toggle="modal" data-target="#modalContrato">
                                          <i class="fa fa-file-pdf-o"></i> Generar
                                        </button> &nbsp;
                                    </td>
                                    <td>
                                        <button class="btn btn-{{$rev->condicion == 1 ? 'danger' : 'success'}} btn-md" data-id="{{$rev->id}}" data-toggle="modal" data-target="#cambiarEstado" data-keyboard="false" data-backdrop="static">
                                        <i class="fa fa-{{$rev->condicion == 1 ? 'times': 'lock'}}"></i> {{$rev->condicion == 1 ? 'Desactivar' : 'Activar'}}
                                        </button>
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
                        <input type="hidden" id="file_evaluador_hidden" value="{{$load_file}}">
                        <input type="hidden" id="estado_revision_hidden" value="{{$estado_revision}}">
                        {{$revisiones->appends($data)->links()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

             <!--Inicio del modal actualizar registro-->
             <div class="modal fade" id="modalRegistroGerencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Actualizar Registro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="" class="form-horizontal" id="formUpdateRegistro" method="POST" role="form" enctype="multipart/form-data" >
                                <input type="hidden" name="_method" value="PUT" id="PUTMETHOD"/>
                                <input type="hidden" name="editando" value="0" id="editando"/>
                                <input type="hidden" id="clientesid" name="clientesid" value="">
                                <input type="hidden" id="registro_update_id" name="revision_id" value="">
                                <input type="hidden" name="type" value="Gerencia">
                                {{csrf_field()}}
                                @include('revision.form')
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal generar contrato-->
             <div class="modal fade" id="modalContrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Generar contrato</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                                <form action="" method="POST" name="formGenerarContrato" id="formGenerarContrato" enctype="multipart/form-data" onsubmit="return ValidateCuota();">
                                <input type="hidden" name="clientesid" value="">
                                <input type="hidden" name="revision_id" value="">
                                <input type="hidden" id="contrato_id" name="contrato_id" value="">
                                {{csrf_field()}}
                                @include('gerencia.contrato')
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
                            <h4 class="modal-title">Cambiar estado del registro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="formRegistro">
                            {{csrf_field()}}
                            @method('DELETE')

                            <input type="hidden" id="registro_delete_id" name="revision_id" value="">
                            <input type="hidden" name="type" value="Gerencia">

                                <p>Estás seguro de cambiar el estado?</p>
        
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
             </div>
            <!-- Fin del modal Eliminar -->
           

           
            
        </main>

@endsection
@push('custom-js')
    
<script>
    $('.table_orden_trabajo').on('click', '.remove_button2', function (e) {
    e.preventDefault();
    x = $(this).attr('id');
    // console.log(x);
    var fila = x;
    var precio_total_pendiente_remove = $('#precio_cuotas').val();
    var monto = $("#monto" + fila).val();
    console.log(monto);
    var resultado = parseFloat(precio_total_pendiente_remove) + parseFloat(monto);
    value = parseFloat(resultado).toFixed(2);
    $('#precio_cuotas').val(value);
    $(this).parent().parent().remove();
    $(".max_msg").hide();

});
// Cambiar de estado del prospecto
$("#cambiarEstado").on("show.bs.modal", function (e) {
    var btn = $(e.relatedTarget);
    var id = btn.data('id');
    $("#registro_delete_id").val(btn.attr('data-id'));
    if (id > 0) {
        var action = '{{route('revision.destroy',"@id")}}';
        action = action.replace("@id", id);
        $("#formRegistro").prop("action", action);
    }
});
 // Actualizar registro
 $("#modalRegistroGerencia").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          var action = '{{route('revision.update',"@id")}}';
          action = action.replace("@id", id);
          $("#editando").val(1);
          $("#formUpdateRegistro").prop("action", action);
          $("#PUTMETHOD").val('PUT');
          $("#registro_update_id").val(btn.attr('data-id'));
          $("#clientesid").val(btn.attr('data-clientesid'));
          $("#codigo").val(btn.attr('data-codigo'));
          $("#titulo").val(btn.attr('data-titulo'));
          $("#puntaje").val(btn.attr('data-puntaje'));
          $("#observaciones").val(btn.attr('data-observaciones'));
          $("#idnivelarticulo").val(btn.attr('data-idnivelarticulo'));
          $("#estado_revision").val(btn.attr('data-estado_revision'));
          $("#file_value_hidden").val(btn.attr('data-archivoevaluador'));

          if ($('#file_evaluador_hidden').val() == 1 && (btn.attr('data-archivoevaluador') == null || btn.attr('data-archivoevaluador') == "noimagen.jpg")) {
          $("#block-file").css('display', $('#file_evaluador_hidden').val() == 1 ? 'block' : 'none');
          }else{
          $("#block-file").css('display', 'none');
          }

          if ($('#estado_revision_hidden').val() == 1 && (btn.attr('data-estado_revision') == 1)) {
          $("#block-estado_revision").css('display', $('#estado_revision_hidden').val() == 1 ? 'none' : 'block');
          }else{
          $("#block-estado_revision").css('display', 'block');
          }

        }
      });
 // Generar contrato
 $("#modalContrato").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          $("#contrato_id").val(btn.attr('data-contrato_id'));
            // if(contrato[0].value > 0) {
            //     $('input[name="_method"]').val('PUT');
            //     action = action.replace("@id", contrato[0].value);
            //     $('input[name="editando"]').val(1);
            //     $("#formGenerarContrato").prop("action", action);
            // }else{
            var action = '{{route('gerencia.contrato')}}';
            $("#formGenerarContrato").prop("action", action);
            // }
          $('input[name="revision_id"]').val(btn.attr('data-id'));
          $('input[name="clientesid"]').val(btn.attr('data-clientesid'));
          $("#codigo_contrato").val(btn.attr('data-codigo'));
          $("#idgrado").val(btn.attr('data-idgrado'));
          $("#titulo_contrato").val(btn.attr('data-titulo'));
          $("#tipo_documento_contrato").val(btn.attr('data-tipo_documento'));
          $("#num_documento_contrato").val(btn.attr('data-num_documento'));
          $("#nombres_contrato").val(btn.attr('data-nombres'));
          $("#apellidos_contrato").val(btn.attr('data-apellidos'));
          $("#correocontacto_contrato").val(btn.attr('data-correo'));
          $("#telefono_contrato").val(btn.attr('data-telefono'));
          $("#monto_inicial").val(btn.attr('data-monto_inicial'));
          $("#monto_total").val(btn.attr('data-monto_total'));
          $("#observaciones_contrato").val(btn.attr('data-observacion_contrato'));
          $("#domicilio_contrato").val(btn.attr('data-domicilio'));
            var num_cuotas = $("#num_cuotas").val(btn.attr('data-num_cuotas'));
            var check_cuotas = $("#check_cuotas").val(btn.attr('data-check_cuotas'));
            // console.log(num_cuotas[0].value);
            if(check_cuotas[0].value == 1){
                var data = JSON.parse(num_cuotas[0].value);
                $("#monto_inicial").prop('readonly', true);
                $("#monto_total").prop('readonly', true);
                $("#check_cuotas").prop('checked', true); 
                $('.div_agregar_cuotas').css('display','block');
                $('#monto_aux').val('0.00');
                $.each(data, function(i, item) {
                    var fieldHTML = '<tr class="cuotaFila"><td style="width: 50%;"><div class="form-group"><input type="text" class="form-control datepicker" id="fecha_cuota' + data[i].id + '"name="fecha_cuota[]" value="' + data[i].fecha_cuota + '" readonly="true"></div></td>'
                    + '<td style="width: 50%;"><div class="form-group"><input type="text" class="form-control" id="monto' + data[i].id + '"name="monto[]" value="' + data[i].monto + '" readonly="true"></div></td>'
                    + '<td><a style="margin-top:-20px;color:#fff;" class="remove_button2 btn btn-danger" id="' + data[i].id + '" title="Eliminar"><i class="fa fa-minus"></i></a></td>'
                    + '</tr>';
                    $('.table_orden_trabajo').append(fieldHTML);
                });
            }else{
                $("#monto_inicial").prop("readonly",false);
                $("#monto_total").prop("readonly",false);
                $("#check_cuotas").prop('checked', false); 
                $('.div_agregar_cuotas').css('display','none');
                $('#monto_aux').val('0.00');
                    var lengthRows = $('.cuotaFila', $("#regCuota")).length;
                    if(lengthRows > 0){
                        for (var i = 0; i <= lengthRows; i++) {
                        $(".cuotaFila").each(function(index ,value) {
                            $(".cuotaFila").remove();
                        });
                        }
                    }
            }





          $("#precio_cuotas").val(btn.attr('data-precio_cuotas'));
          $("#asesor_venta_id").val(btn.attr('data-asesor_venta_id'));


        }
      });
      $('#monto_total').bind('blur',function(e){
        var monto_total = $('#monto_total').val();
        var monto_inicial = $('#monto_inicial').val();
        if(monto_total != ''){
            if(monto_total <= 0.00 ){
                $('#monto_total').val('0.00');
                $('#precio_cuotas').val('');
                $("#guardar_contrato").addClass('disabled');
                $("#guardar_contrato").prop('disabled', true);
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
<script src="{!! asset('js/gerencia.js') !!}"></script>
@endpush
