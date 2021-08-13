@extends('layouts.app')
@section('content')
<style>
    textarea {
        resize: none;
    }
</style>
<main class="main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">

               <h2>Coautorías</h2><br/>

            </div>

        <div class="card-body">

            <div class="form-group row">
                <div class="col-md-6">
                    {!!Form::open(array('url'=>'coautorias','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
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
                   <strong>Total de coautores:</strong>
                   {{count($count)}}
                   </p>
                </div>
               </div>
             </div>
             <table class="table table-responsive table-xl">
                 <thead>
                     <tr class="bg bordearriba">
                        <th style="width: 15%">Inf. Artículo</th>
                        <th style="width: 15%">Inf. Cliente</th>
                        <th style="width: 15%">Asesor de Venta</th>
                        <th style="width: 15%">Estado</th>
                        <th style="width: 15%">Contrato</th>


                     </tr>
                 </thead>
                 <tbody>

                    @forelse($coautores as $coautor)
                    @php
                    $cliente = json_decode($coautor->cliente)
                    @endphp
                    <tr>
                    <td>
                        {!!"<b>Código:</b> ".$coautor->codigo_articulo !!} <br>
                        {!!"<b>Título:</b> ". $coautor->titulo_coautoria !!}<br>
                    </td>
                    <td>
                        {!!"<b>Especialidad:</b> ".$cliente->especialidad !!} <br>
                        {!!"<b>Nombres:</b> ". $cliente->nombres !!}<br>
                        {!!"<b>Apellidos:</b> ". $cliente->apellidos !!}<br>
                        {!!"<b>Número Doc.:</b> ". $cliente->num_documento !!}<br>
                        {!!"<b>Correo:</b> ". $cliente->correocontacto !!}<br>
                        {!!"<b>Teléfono:</b> ". $cliente->telefono !!}<br>
                        <b>Contrato:</b><br>
                        @if($coautor->contrato_id == 0)
                        Sin contrato
                        @else
                            <a type="button" href="{{ route('gerencia.download.contrato',['id'=>$coautor->contrato_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-file-pdf-o"></i> Descargar</a>
                        @endif<br>
                    </td>
                    <td>{{$cliente->asesor_venta_nombre ?? '-'}}</td>
                    <td>
                        <span class="text-{{$coautor->contrato_id=="0" ? 'warning' : 'success'}}">{{$coautor->contrato_id=="0" ? 'Pendiente' : 'Con contrato'}}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-md"
                        data-id="{{$coautor->id}}" 
                        data-contrato_id="{{$coautor->contrato_id}}" 
                        data-codigo="{{$coautor->codigo_articulo}}" 
                        data-titulo="{{$coautor->titulo_coautoria}}"
                        data-nombres="{{$cliente->nombres}}"
                        data-apellidos="{{$cliente->apellidos}}" 
                        data-num_documento="{{$cliente->num_documento}}"
                        data-correo="{{$cliente->correocontacto}}" 
                        data-tipo_documento="{{$cliente->tipo_documento}}" 
                        data-idgrado="{{$cliente->idgrado}}" 
                        data-telefono="{{$cliente->telefono}}" 
                        data-monto_total="{{$coautor->monto_total}}" 
                        data-asesor_venta_id="{{$cliente->asesor_venta_id ?? '-'}}"
                        data-domicilio="{{$coautor->domicilio == "null" ? '' : $coautor->domicilio}}"
                        data-observacion_contrato="{{$coautor->observacion_contrato}}"
                        data-toggle="modal" data-target="#modalContratoCoautor">
                        <i class="fa fa-file-pdf-o"></i> Generar
                      </button> &nbsp;
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td></td>
                        <td colspan="2" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
                    </tr>
                    @endforelse
                 </tbody>
             </table>
             {{$coautores->appends($data)->links()}}
            </div>
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
                            <form action="" method="POST" name="formGenerarContratoCoautor" id="formGenerarContratoCoautor" onsubmit="return ValidatePrice();">
                            <input type="hidden" id="contrato_id" name="contrato_id" value=""> 
                            <input type="hidden" id="coautor_id" name="coautor_id" value="">
                            <input type="hidden" id="asesor_venta_id" name="asesor_venta_id" value="">
                            {{csrf_field()}}
                            @include('gerencia.contrato-coautoria')
                        </form>
                    </div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
  </main>
@push('scripts')
<script>
     // Generar contrato
 $("#modalContratoCoautor").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        if (id > 0) {
          $("#coautor_id").val(btn.attr('data-id'));
          var action = '{{route('contrato.coautoria')}}';
          $("#formGenerarContratoCoautor").prop("action", action);
          var contrato_id = $("#contrato_id").val(btn.attr('data-contrato_id'));
          $("#codigo_contrato").val(btn.attr('data-codigo'));
          $("#titulo_contrato").val(btn.attr('data-titulo'));
          $("#tipo_documento_contrato").val(btn.attr('data-tipo_documento'));
          $("#idgrado").val(btn.attr('data-idgrado'));
          $("#num_documento_contrato").val(btn.attr('data-num_documento'));
          $("#nombres_contrato").val(btn.attr('data-nombres'));
          $("#apellidos_contrato").val(btn.attr('data-apellidos'));
          $("#correocontacto_contrato").val(btn.attr('data-correo'));
          $("#telefono_contrato").val(btn.attr('data-telefono'));
          $("#asesor_venta_id").val(btn.attr('data-asesor_venta_id'));
          $("#observaciones_contrato").val(btn.attr('data-observacion_contrato'));
          $("#domicilio_contrato").val(btn.attr('data-domicilio'));
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
    $("#modalContratoCoautor").on("hidden.bs.modal", function (e) {
        // $("#domicilio_contrato").val('');
      });
    $('#monto_total').bind('blur',function(e){
        var monto = $('#monto_total').val();
        if(monto != ''){
            if(monto <= 0.00 ){
                $('#monto_total').val('0.00');
                $(".btn-contrato-coautor").addClass('disabled');
                $(".btn-contrato-coautor").prop('disabled', true);
                mostrarMensajeInfo('El monto total debe ser mayor a 0.00');
            }else{
                $(".btn-contrato-coautor").removeClass('disabled');
                $(".btn-contrato-coautor").prop('disabled', false);
                var total = parseFloat($("#monto_total").val());
                $("#monto_total").val(total.toFixed(2));
            }
        }
    });
    function ValidatePrice() {
        var monto_validar = $('#monto_total').val();
        if(monto_validar <= 0.00){
            $('#monto_total').val('0.00');
            $(".btn-contrato-coautor").addClass('disabled');
            $(".btn-contrato-coautor").prop('disabled', true);
            mostrarMensajeInfo('El monto total debe ser mayor a 0.00');
            return false;
        }
    }
</script>
@endpush
@endsection

