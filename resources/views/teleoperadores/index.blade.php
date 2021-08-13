@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Teleoperadores</h4>
                <div class="row">
                <div class="col-xs-6">
                    <a type="button" href="{{route('servicios.create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Registrar
                    </a>
                </div>&nbsp;
                {{-- <div class="col-xs-6">
                    <a id="exportar-btn" type="button" href="" class="btn btn-success disabled">
                        <i class="feather icon-download"></i> Exportar
                    </a>
                </div> --}}
                <form id="formExportarPosiblesClientes" action="" method="post" target="_self" class="display_none">
                    {{csrf_field()}}
                </form>
                </div>

            </div>
                <div class="row">
                <div class="col-sm-4" style="margin-left: 15px;margin-top: 15px;">
                <div class="input-group">
                    <span class="input-group-addon"><i class="feather icon-calendar" aria-hidden="true"></i></span>
                    <input type="text" class="form-control form-control-primary" name="filtro-fechas" id="filtro-fechas" >
                    </div>
                </div>
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
                            <select class="form-control select2" name="estado_servicio" id="estado_servicio">
                                <option value="T">Servicio</option>
                                <option value="1">No asignado</option>
                                <option value="2">Asignado</option>
                                <option value="0">Finalizado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row display_none">
                    <input type="text" class="form-control form-control-primary" name="fecha_ini_hide" id="fecha_ini_hide" value={{ date('Y-m-d') }}>
                    <input type="text" class="form-control form-control-primary" name="fecha_fin_hide" id="fecha_fin_hide" value={{ Customize::dateAddDay() }}>
                </div>
                <div class="col-sm-1" style="margin-left: 15px;margin-top: 15px;">
                    <button class="btn btn-info " data-filter="search" id="btn_buscar_info"><i class="fa fa-search"></i></button>
                </div>
                </div>




            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Datos del cliente</th>
                                    <th>Método de pago</th>
                                    <th>Total del servicio</th>
                                    <th>Contiene producto frágil?</th>
                                    <th>Estado del servicio</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Datos del cliente</th>
                                    <th>Método de pago</th>
                                    <th>Total del servicio</th>
                                    <th>Contiene producto frágil?</th>
                                    <th>Estado del servicio</th>
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
        "url":      "{{route('teleoperadores.indexTable')}}",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token        = "<?= csrf_token() ?>";
        data.estado        = $("#estado").val();
        data.estado_servicio        = $("#estado_servicio").val();
        data.fecha_ini     = $("#fecha_ini_hide").val();
        data.fecha_fin     = $("#fecha_fin_hide").val();
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        {"data": "action", "searchable": false, "orderable": false, 'className': 'dropdown', "width": "10%"},
        {"data": "datos_cliente", "width": "35%"},
        {"data": "metodo_pago", "width": "15%"},
        {"data": "total_servicio", "width": "15%"},
        {"data": "is_fragil", "width": "15%", "searchable": false, "orderable": false},
        {"data": "estado_servicio", "width": "25%", "searchable": false, "orderable": false},
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
    // Al seleccionar
    $("#estado").change(function(){
        $("#btn_buscar_info").click();
    });
    $("#estado_servicio").change(function(){
        $("#btn_buscar_info").click();
    });
    // Al seleccionar
    </script>
@endsection
