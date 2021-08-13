@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Logs del sistema</h4>
            </div>
            @include('locations.filtros')
                <div class="row">
                <div class="col-sm-2 ajuste-filto">
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control select2" name="error" id="error">
                                <option value="T">Estado</option>
                                <option value="0">Error</option>
                                <option value="1">Correcto</option>
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
                                    <th>Descripción</th>
                                    <th>Ip</th>
                                    <th>Explorador</th>
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Error</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Ip</th>
                                    <th>Explorador</th>
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Error</th>
                                    <th>Fecha</th>
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
        "url":      "{{route('log-systems.indexTable')}}",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token        = "<?= csrf_token() ?>";
        data.error        = $("#error").val();
        data.anio        = $("#anio").val();
        data.fecha_ini     = $("#fecha_ini_hide").val();
        data.fecha_fin     = $("#fecha_fin_hide").val();
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        { "data" : function(row, type, val, meta) {
            var html = '';
            if(row.description.length > 255){
                html = "<a href='#' onclick='swal.fire({title:`Log System`,html:`{"+ row.description.replace("'", '*').replace("'","*") +"`});'>Ver Detalle</a>";
            }else{
                html = row.description;
            }
            return html;
        }, "title":"Descripción", "searchable": false, "orderable": false, "width": "20%"}, 
        {"data": "ip", "searchable": false, "orderable": false, "width": "5%"},
        {"data": "agent", "searchable": false, "orderable": false, "width": "20%"},
        {"data": "usuario", "searchable": false, "orderable": false, "width": "10%"},
        {"data": "user_email", "searchable": false, "orderable": false, "width": "15%"},
        {"data": "error", "searchable": false, "orderable": false, "width": "10%"},
        {"data": "created_at", "searchable": false, "orderable": false, "width": "15%"}
    ],
    "columnDefs": [ {
    "targets": 0,
    "orderable": false
    }],

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
        var estado = $('#error').val();
        var search = $('div.dataTables_filter input').val();
        let anio = $("#anio").val();
        if(search == '')
          search = 'T';
        var url = "log-systems/exportar-excel/" + fecha_inicio + "/" + fecha_fin + "/" + estado + "/" + anio + "/" + search;
        $('#formExportarLogSystem').attr('action',url);
        $('#formExportarLogSystem').submit();

    });

    $("#error").change(function(){
        $("#btn_buscar_info").click();
    });

    </script>
@endsection
