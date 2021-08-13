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

                       <h3>Prospectos/Clientes</h3><br/>
                        
                    </div>
                    <div class="card-body">
                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modalProspecto">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar prospecto
                        </button>

                        <a href="{{ url('/ordentrabajo/create')}}">
                        <button class="btn btn-dark btn-sm" type="button">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Coautoría
                        </button>
                        </a>

                        <a href="{{ url('/libros/lista')}}">
                        <button class="btn btn-info btn-sm" type="button">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Ver Coautorías
                        </button>
                        </a>

                        <a href="{{ url('/estadogeneralorden')}}">
                        <button class="btn btn-danger btn-sm" type="button">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Ver Estado General OT
                        </button>
                        </a>

                        <a href="{{ url('/clientes/exportarexcel')}}">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-arrow-down"></i> Exportar Excel
                                       </button> &nbsp;
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'cliente','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                               <strong>Total Prospectos:</strong>
                               {{count($count)}}
                               </p> 
                            </div>
                            <div class="col">
      
                            </div>
                           </div>
                         </div>
                        <table class="table table-responsive table-sm">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th>Ver Detalle</th>
                                    <th style="width: 10%">Código</th>
                                    <th style="width: 15%">Prospecto</th>
                                    <th style="width: 10%">Asesor Venta</th>
                                    <th style="width: 10%">Aviso</th>
                                    <th style="width: 15%">Tipo de Cliente</th>
                                    <th style="width: 10%">Estado</th>
                                    @if(Auth::id() !=34)
                                    <th style="width: 10%">Editar</th>
                                    <th style="width: 10%">Cambiar Estado</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                               @forelse($clientes as $au)
                               
                                <tr>
                                    <td>
                                    <a href="{{URL::action('ClienteController@show',$au->id)}}">
                                        <button type="button" class="btn btn-warning btn-sm">
                                            <i class="fa fa-eye"></i> Ver detalle
                                        </button> &nbsp;

                                    </a>
                                    </td>
                                    <td>{{$au->codigo}}</td>
                                    <td>
                                        {{$au->tipo_documento}} 
                                        {{$au->num_documento == null ? 'N° 0' : "N° ".$au->num_documento }}<br>
                                        {{$au->nombres ?? '-'}} {{$au->apellidos ?? '-'}} <br>
                                        {!!"<b>Zona:</b> ".$au->nombre_zona!!} <br>
                                        {!!"<b>Correo:</b> ".$au->correocontacto!!} <br>
                                        {!!"<b>Télefono:</b> ".$au->telefono!!}
                                    </td>
                                    <td>{{$au->nombre_asesor_venta}}</td>   
                                    <td>{{$au->nombre_aviso}}</td>   
                                    <td>
                                        @if($au->autor=="1")
                                        <span class="text-success"><i class="fa fa-user"></i> Cliente</span>
                                        @elseif($au->autor=="2")
                                        <span class="text-primary"><i class="fa fa-user"></i> En revisión técnica</span>
                                        @elseif($au->autor=="3")
                                        <span class="text-info"><i class="fa fa-user"></i> En Gerencia</span>
                                        @elseif($au->autor=="4")
                                        <span class="text-success"><i class="fa fa-user"></i> Con contrato</span>
                                        @else
                                        <span class="text-warning"><i class="fa fa-user"></i> Prospecto</span>
                                        @endif
                                      </td>
                                    <td>
                                      
                                      @if($au->condicion=="1")
                                      <span class="text-success"><i class="fa fa-check"></i> Activo</span>
                                      @else
                                      <span class="text-danger"><i class="fa fa-close"></i> Desactivado</span>
                                      @endif
                                       
                                    </td>
                                    @if(Auth::id() !=34)
                                    <td>
                                    <button class="btn btn-info btn-md" data-id="{{$au->id}}" data-num_documento="{{$au->num_documento}}"
                                         data-nombres="{{$au->nombres}}" data-apellidos="{{$au->apellidos}}" data-correo="{{$au->correocontacto}}" data-telefono="{{$au->telefono}}" 
                                         data-correo_gmail="{{$au->correogmail}}" data-contrasena="{{$au->contrasena}}" data-resumen="{{$au->resumen}}" data-orcid="{{$au->orcid}}" 
                                         data-universidad="{{$au->universidad}}" data-id_grado="{{$au->idgrado}}" data-especialidad="{{$au->especialidad}}"
                                         data-asesor_venta_id="{{$au->asesor_venta_id}}"
                                         data-tipo_documento="{{$au->tipo_documento}}"
                                         data-aviso_id="{{$au->aviso_id}}"
                                         data-correocontacto="{{$au->correocontacto}}"
                                         data-correogmail="{{$au->correogmail}}"
                                         data-codigo="{{$au->codigo}}"
                                         data-zona_id="{{$au->zona_id}}"
                                         data-toggle="modal" data-target="#modalProspecto">
                                    <i class="fa fa-edit"></i> Editar
                                    </button> &nbsp;
                                    </td>

                                    
                                    <td>
                                        <button class="btn btn-{{$au->condicion == 1 ? 'danger' : 'success'}} btn-md" data-id="{{$au->id}}" data-toggle="modal" data-target="#cambiarEstado" data-keyboard="false" data-backdrop="static">
                                        <i class="fa fa-{{$au->condicion == 1 ? 'times': 'lock'}}"></i> {{$au->condicion == 1 ? 'Desactivar' : 'Activar'}}
                                        </button>
                                    </td>
                                    @endif

                                    
                                </tr>
                                @empty

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforelse


                            </tbody>
                        </table>
                        {{$clientes->appends($data)->links()}}
                            

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title"></h4>
                            <span class="show_wait_load" style="font-size: small;display: none">
                                <div class="text-center">
                                <button class="btn btn-success" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                                </div> 
                    
                            </span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            
                            <form action="" method="post" class="form-horizontal" id="formCreateUpdate">
                                <input type="hidden" name="_method" value="PUT" id="PUTMETHOD"/>
                                <input type="hidden" name="editando" value="0" id="editando"/>
                                <input type="hidden" id="cliente_update_id" name="cliente_id" value="">
                                <input type="hidden" name="location" value="0">
                                {{csrf_field()}}
                                @include('cliente.form')
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
                            <h4 class="modal-title">Cambiar Estado del Prospecto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="formProspectos">
                           
                            {{csrf_field()}}
                            @method('DELETE')

                            <input type="hidden" id="cliente_delete_id" name="cliente_id" value="">

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
            <!-- Fin del modal Eliminar -->

            
        </main>



@endsection
@section('custom-js')
    
<script>
    // Cambiar de estado del prospecto
    $("#cambiarEstado").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        $("#cliente_delete_id").val(btn.attr('data-id'));
        if (id > 0) {
          var action = '{{route('cliente.destroy',"@id")}}';
          action = action.replace("@id", id);
          $("#formProspectos").prop("action", action);
          $(".modal-title").text('Cambiar estado prospecto');
        }
    });
    // Crear o actualizar prospecto 
    $("#modalProspecto").on("show.bs.modal", function (e) {
       
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          $(".btn_cliente").prop('disabled', false);
          $(".btn_cliente").removeClass('disabled');
          var action = '{{route('cliente.update',"@id")}}';
          action = action.replace("@id", id);
          $("#editando").val(1);
          $("#formCreateUpdate").prop("action", action);
          $("#PUTMETHOD").val();
          $("#cliente_update_id").val(btn.attr('data-id'));
          $("#asesor_venta_id").val(btn.attr('data-asesor_venta_id'));
          $("#tipo_documento").val(btn.attr('data-tipo_documento'));
          $("#num_documento").val(btn.attr('data-num_documento'));
          $(".num_documento_hidden").val(btn.attr('data-num_documento'));
          $("#nombres").val(btn.attr('data-nombres'));
          $("#apellidos").val(btn.attr('data-apellidos'));
          $("#aviso_id").val(btn.attr('data-aviso_id'));
          $("#correocontacto").val(btn.attr('data-correocontacto'));
          $("#telefono").val(btn.attr('data-telefono'));
          $("#correogmail").val(btn.attr('data-correogmail'));
          $("#contrasena").val(btn.attr('data-contrasena'));
          $("#universidad").val(btn.attr('data-universidad'));
          $("#zona_id").val(btn.attr('data-zona_id'));
          $("#orcid").val(btn.attr('data-orcid'));
          $("#especialidad").val(btn.attr('data-especialidad'));
          $("#id_grado").val(btn.attr('data-id_grado'));
          $("#codigo").val(btn.attr('data-codigo'));
          $("#codigo_prospecto").css('display','flex');
        
          $(".modal-title").text('Actualizar prospecto');
          var cliente_id = $("#cliente_update_id").val(btn.attr('data-id'));
        //   $.ajax({
        //     beforeSend: function () {
        //     $('.show_wait_load').css('display', 'block');
        //     $('[name="asesor_venta_id"]').prop('disabled', 'disabled');
        //     },
        //     complete: function () {
        //     $('.show_wait_load').css('display', 'none');
        //     $('[name="asesor_venta_id"]').prop('disabled', false);
        //     },
        //     type: "GET",
        //     url: 'verificar-estado-cliente/'+cliente_id[0].value,
        //     dataType: "json",
        //     success: function (data) {
        //         if (data.status == true) {
        //         $(".asignar_asesor").css('display', 'flex');
        //         }else{
        //         $(".asignar_asesor").css('display', 'none');
        //         }
        //     },
        //     error: function () {
        //         $('.show_wait_load').css('display', 'none');
        //         mostrarMensajeInfo('Ocurrio un error al intentar realizar operación refresque la página por favor');
        //     }
        // });
        } else {
        //   $(".asignar_asesor").css('display', 'flex');
        //   $('[name="asesor_venta_id"]').prop('disabled', false);
          $(".btn_cliente").prop('disabled', false);
          $(".btn_cliente").removeClass('disabled');
          var action = '{{route('cliente.store')}}';
          $("#formCreateUpdate").prop("action", action);
          $(".modal-title").text('Agregar prospecto');
          $("#PUTMETHOD").val('POST');
          $("#cliente_update_id").val('');
          $("#asesor_venta_id").val(1);
          $("#tipo_documento").val('');
          $("#num_documento").val('');
          $(".num_documento_hidden").val('');
          $("#nombres").val('');
          $("#apellidos").val('');
          $("#aviso_id").val('');
          $("#correocontacto").val('');
          $("#telefono").val('');
          $("#correogmail").val('');
          $("#contrasena").val('');
          $("#universidad").val('');
          $("#orcid").val('');
          $("#especialidad").val('');
          $("#id_grado").val('');
          $("#codigo").val('');
          $("#zona_id").val('');
          $("#codigo_prospecto").css('display','none');
        }
      });
    // Cierre de Modal   
      $("#modalProspecto").on("hidden.bs.modal", function (e) {
          $("#codigo_prospecto").css('display','none');
      });
</script>
@endsection