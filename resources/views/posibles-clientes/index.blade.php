@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Posibles clientes</h4>
                <div class="row">
                <div class="col-xs-6">
                    <a type="button" href="{{route('posibles.clientes.create')}}" class="btn btn-primary create">
                        <i class="fa fa-plus"></i> Registrar
                    </a>
                </div>
                </div>

            </div>
            @include('locations.filtros')
                <div class="row">
                <div class="col-sm-2" style="margin-left: 15px;margin-top: 15px;">
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control select2" name="estado" id="estado">
                                <option value="T">Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Desactivado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2" style="margin-left: 15px;margin-top: 15px;">
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control select2" name="estado_cliente" id="estado_cliente">
                                <option value="T">Estado cliente</option>
                                <option value="1">Cliente</option>
                                <option value="0">Posible cliente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2" style="margin-left: 15px;margin-top: 15px;">
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control select2" name="estado_llamada" id="estado_llamada">
                                <option value="T">Estado llamada</option>
                                @foreach($tipoLlamadas as $items)
                                <option value="{{$items->id}}">{{$items->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                </div>




            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Vendedor</th>
                                    <th>Estado llamada</th>
                                    <th>Datos de registro</th>
                                    <th>Datos del cliente</th>
                                    <th>Estado cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Vendedor</th>
                                    <th>Estado llamada</th>
                                    <th>Datos de registro</th>
                                    <th>Datos del cliente</th>
                                    <th>Estado cliente</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
    <script>

    $.fn.dataTable.ext.search.push(
      function (settings, data, dataIndex) {
        return true;
      }
    );

    var table = $('.data-table').DataTable({
    language,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url":      "{{route('posibles.clientes.indexTable')}}",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token        = $("meta[name='csrf-token']").attr("content");
        data.estado        = $("#estado").val();
        data.estado_cliente        = $("#estado_cliente").val();
        data.estado_llamada        = $("#estado_llamada").val();
        data.fecha_ini     = $("#fecha_ini_hide").val();
        data.fecha_fin     = $("#fecha_fin_hide").val();
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        {"data": "action", "searchable": false, "orderable": false, 'className': 'dropdown', "width": "10%"},
        {"data": "vendedor"},
        {"data": "estado_llamada"},
        {"data": "datos_registro", "searchable": false, "orderable": false,},
        {"data": "datos_contacto", "searchable": false, "orderable": false,},
        {"data": "estado_cliente", "searchable": false, "orderable": false,}
    ]

    });
    $.fn.dataTable.ext.errMode = () => console.log('Error en la carga de la tabla. Por favor refrescar página.');

    $('#btn_buscar_info').click(function (e) {
        e.preventDefault();
        table.search($('div.dataTables_filter input').val()).draw();
    });
  // Filtro por mes
  $(".filter-mes .btn").click(function(){
      // var d = new Date();
      var y = $('#anio').val();
      var m = $(this).data('mes');

      var firstDay = (new Date(y, parseInt(m)  , 1)).toISOString().substring(0, 10);
      var lastDay = (new Date(y, parseInt(m) + 1 , 0)).toISOString().substring(0, 10);

      $("#fecha_ini_hide").val(firstDay);
      $("#fecha_fin_hide").val(lastDay);
      //change the selected date range of that picker
      $('#filtro-fechas').data('daterangepicker').setStartDate( moment(firstDay) );
      $('#filtro-fechas').data('daterangepicker').setEndDate( moment(lastDay) );
      $("#btn_buscar_info").click();
  });
  // Al seleccionar
  $("#anio").change(function(){
      var d = new Date();
      var y = $('#anio').val();

      var firstDay = new Date(y, d.getMonth(), 1).toISOString().substring(0, 10);
      var lastDay = new Date(y, d.getMonth() + 1, 0).toISOString().substring(0, 10);

      $("#fecha_ini_hide").val(firstDay);
      $("#fecha_fin_hide").val(lastDay);
      //change the selected date range of that picker
      $('#filtro-fechas').data('daterangepicker').setStartDate( moment(firstDay) );
      $('#filtro-fechas').data('daterangepicker').setEndDate( moment(lastDay) );
      $("#btn_buscar_info").click();
  });

    //exportar excel posible clientes
    $('.btn-exportar').click(function (e){
        e.preventDefault();

        var fecha_inicio = $("#fecha_ini_hide").val();
        var fecha_fin = $("#fecha_fin_hide").val();
        var estado = $('#estado').val();
        var estado_cliente = $('#estado_cliente').val();
        var search = $('div.dataTables_filter input').val();

        var url = "posibles-clientes/exportar-excel/" + fecha_inicio + "/" + fecha_fin + "/" + estado+ "/" + estado_cliente;
        $('#formExportarPosiblesClientes').attr('action',url);
        $('#formExportarPosiblesClientes').submit();

    });
    $("#estado_cliente,#estado,#estado_llamada").change(function(){
        $("#btn_buscar_info").click();
    });
    </script>
@endsection
