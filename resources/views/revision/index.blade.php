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
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h3>Revisiones Técnicas</h3><br/>
                         @if(Auth::user()->id == 13 || Auth::user()->id == 50 ||  Auth::user()->idrol == 1)
                         <button class="btn botonagregar btn-sm" type="button" data-toggle="modal" data-target="#modalCrearRevision">
                            <i class="fa fa-plus"></i> Agregar revisión
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'revision','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                               <strong>Total revisiones:</strong>
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
                                   
                                    <th style="width: 20%">Artículo</th>
                                    <th style="width: 10%">Asesor Responsable</th>
                                    <th style="width: 10%">Info. Cliente</th>
                                    <th style="width: 30%">Archivo Evaluador</th>
                                    <th style="width: 15%">Estado</th>
                                    <th>Editar</th>
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
                                        {!!"<b>Código:</b> ".$rev->codigo !!} <br>
                                        {!!"<b>Título:</b> ". $rev->titulo !!}<br>
                                        <b>Observación:</b><br>
                                        {{$rev->observaciones == null  ? '-' : $rev->observaciones}}<br>
                                        {!!"<b>Nivel:</b>" !!} <br>
                                        {{$rev->nombre_revision}} - {{$rev->descripcion}}<br>
                                        {!!"<b>Puntaje:</b> "!!} {{$rev->puntaje}}<br>
                                        {!!"<b>Tipo de libro:</b> "!!} <br>
                                        {{$rev->nombreeditoriales}}
                                    </td>
                                    <td>{{$rev->asesornombres}}</td>
                                    <td>
                                        @if($rev->autor=="1" && $rev->contrato_id!="0")
                                        <span class="text-success"><i class="fa fa-user"></i> Cliente</span>
                                        @elseif($rev->autor=="2" && $rev->archivoevaluador!="noimagen.jpg" && $rev->estado_revision=="1") 
                                        <span class="text-primary"><i class="fa fa-user"></i> En revisión técnica</span>
                                        @elseif($rev->autor=="3" && $rev->estado_revision=="1")
                                        <span class="text-info"><i class="fa fa-user"></i> En Ventas</span>
                                        @elseif($rev->autor=="4" && $rev->contrato_id!="0")
                                        <span class="text-success"><i class="fa fa-user"></i> Con contrato</span>
                                        @elseif($rev->estado_revision=="1" && $rev->archivoevaluador!="noimagen.jpg")
                                        <span class="text-info"><i class="fa fa-user"></i> En Ventas</span>
                                        @else
                                        <span class="text-warning"><i class="fa fa-user"></i> Pendiente</span>
                                        @endif
                                        <br>
                                        {{$rev->tipo_documento}} 
                                        {{$rev->num_documento == null ? 'N° 0' : "N° ".$rev->num_documento }}<br>
                                        {{$rev->clientesnombres ?? '-'}} {{$rev->apellidos ?? ''}} <br>
                                        {!!"<b>Correo:</b> ".$rev->correocontacto!!} <br>
                                        {!!"<b>Télefono:</b> ".$rev->telefono!!}<br>
                                        {!!"<b>Resumen Cliente:</b>" !!}<br>
                                        @if($rev->archivo == null || $rev->archivo == 'noimagen.jpg')
                                            Sin archivo adjunto
                                        @else
                                            <a download type="button" href="{{ route('download.resumen.revision',['idclientes'=>$rev->idclientes,'id'=>$rev->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>
                                        @endif   
                                    </td>

                                    <td>
                                        @if($rev->archivoevaluador == null || $rev->archivoevaluador == "noimagen.jpg")
                                            Sin archivo evaluador
                                        @else
                                            <a download type="button" href="{{ route('download.revision',['idclientes'=>$rev->idclientes,'id'=>$rev->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($rev->condicion=="1")
                                        <span class="text-success"><i class="fa fa-check"></i> Activo</span>
                                        @else
                                        <span class="text-danger"><i class="fa fa-close"></i> Desactivado</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- @if($rev->estado_revision=="1") --}}
                                        <button type="button" class="btn btn-info btn-md"
                                          data-id="{{$rev->id}}" data-codigo="{{$rev->codigo}}"
                                          data-titulo="{{$rev->titulo}}"
                                          data-observaciones="{{$rev->observaciones}}"
                                          data-idnivelibros="{{$rev->idnivelibros}}"
                                          data-puntaje="{{$rev->puntaje}}"
                                          data-toggle="modal" data-target="#modalRevision">
                                          <i class="fa fa-edit"></i> Editar
                                        </button>
                                        {{-- @endif --}}
                                        @php
                                        $load_file=$rev->archivoevaluador == null || $rev->archivoevaluador == "noimagen.jpg" ? 1 : $load_file;
                                        $estado_revision=$rev->estado_revision == 1 ? 1 : $estado_revision;
                                        @endphp
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
                                    <td colspan="2" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
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
             <!--Inicio del modal crear-->
             <div class="modal fade" id="modalCrearRevision" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Crear Revisión Técnica</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            <form action="{{route('revision.store')}}" class="form-horizontal" id="formCreateRevision" method="POST" role="form" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                @include('revision.form_create_revision')
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
             <!--Inicio del modal actualizar-->
             <div class="modal fade" id="modalRevision" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title">Actualizar Revisión Técnica</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             

                            <form action="" class="form-horizontal" id="formUpdateRevision" method="POST" role="form" enctype="multipart/form-data" >
                                <input type="hidden" name="_method" value="PUT" id="PUTMETHOD"/>
                                <input type="hidden" name="editando" value="0" id="editando"/>
                                <input type="hidden" id="clientesid" name="clientesid" value="">
                                <input type="hidden" id="revision_update_id" name="revision_id" value="">
                                <input type="hidden" name="type" value="Revision">
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

            
             <!-- Inicio del modal Cambiar Estado de la revision -->
             <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar estado de la revisión</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="formRevision">
                            {{csrf_field()}}
                            @method('DELETE')

                            <input type="hidden" id="revision_delete_id" name="revision_id" value="">
                            <input type="hidden" name="type" value="Revision">

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
@section('custom-js') 
<script>
// Cambiar de estado de la revision
$("#cambiarEstado").on("show.bs.modal", function (e) {
    var btn = $(e.relatedTarget);
    var id = btn.data('id');
    $("#revision_delete_id").val(btn.attr('data-id'));
    if (id > 0) {
        var action = '{{route('revision.destroy',"@id")}}';
        action = action.replace("@id", id);
        $("#formRevision").prop("action", action);
    }
});
// Actualizar revision 
$("#modalRevision").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          var action = '{{route('revision.update',"@id")}}';
          action = action.replace("@id", id);
          $("#editando").val(1);
          $("#formUpdateRevision").prop("action", action);
          $("#PUTMETHOD").val('PUT');
          $("#revision_update_id").val(btn.attr('data-id'));
          $("#clientesid").val(btn.attr('data-clientesid'));
          $("#codigo").val(btn.attr('data-codigo'));
          $("#titulo").val(btn.attr('data-titulo'));
          $("#puntaje").val(btn.attr('data-puntaje'));
          $("#observaciones").val(btn.attr('data-observaciones'));
          $("#idnivelibros").val(btn.attr('data-idnivelibros'));
          $("#estado_revision").val(btn.attr('data-estado_revision'));
          $("#file_value_hidden").val(btn.attr('data-archivoevaluador'));

          if ($('#file_evaluador_hidden').val() == 1 && btn.attr('data-archivoevaluador') == "noimagen.jpg") {
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

      $("#guardar_revision").click(function() {
          if( $("#estado_revision").val() == 1 && $("#file_value_hidden").val() == 'noimagen.jpg' && $("#archivoevaluador").val() == '') {
            $("input:file").focus();
            mostrarMensajeInfo("Debe seleccionar un archivo antes de enviar a la gerencia.");
            return false;
            }
        });
        $("#guardar_create_revision").click(function() {
          if( $("#estado_revision_create").val() == 1 && $("#file_value_hidden_create").val() == 'noimagen.jpg' && $("#archivoevaluador_create").val() == '') {
            $("input:file").focus();
            mostrarMensajeInfo("Debe seleccionar un archivo antes de enviar a la gerencia.");
            return false;
            }
        });
         // Modal crear nueva revision 
        $("#modalCrearRevision").on("hidden.bs.modal", function (e) {
            $("#titulo_create").val('');
            $("#idnivelibros_create").val('');
            $("#puntaje_create").val('');
            $("#archivoresumen_create").val('');
            $("#archivoevaluador_create").val('');
            $("#estado_revision_create").val('');
            $("#observaciones_create").val('');
        });

        $(function() {
            $('#asesor_venta_id_create').on('change',function(){
                var asesor_id = $(this).val();
                if($.trim(asesor_id) != ''){
                    $.ajax({
                        type: "GET",
                        url: 'get_clientes',
                        data: {'asesor_id': asesor_id},
                        beforeSend: function () {
                            $('.show_wait_load').css('display', 'block');
                            $('.divclientes').css('display','none');
                        },
                        complete: function () {
                            $('.show_wait_load').css('display', 'none');
                            $('.divclientes').css('display','flex');
                        },
                        success: function (data) {
                            $("#cliente_create").empty();
                            $.each(data, function (index,value){
                                $("#cliente_create").append("<option value='" + index + "'>"+ value +"</option>").selectpicker('refresh');
                            })
                        },
                        error: function () {
                            $('.show_wait_load').css('display', 'none');
                            mostrarMensajeInfo("Ocurrió un error durante la búsqueda de los clientes cierre sesión o presione F5 para refrescar la página.");
                        }
                    });
                    // $.get('get_clientes',{asesor_id:asesor_id},function(data){
                    //     $("#cliente_create").empty();
                    //     $.each(data, function (index,value){
                    //         $("#cliente_create").append("<option value='" + index + "'>"+ value +"</option>").selectpicker('refresh');
                    //     })
                    // });
                }
            });
        });
</script>
@endsection
