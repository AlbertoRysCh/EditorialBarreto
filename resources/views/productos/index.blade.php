@extends('layouts.app')
@section('contenido')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Productos</h4>
                <div class="row">
                <div class="col-xs-6">
                    <a type="button" href="{{route('productos.create')}}" class="btn btn-primary create">
                        <i class="fa fa-plus"></i> Crear
                    </a>
                </div>&nbsp;

                </div>

            </div>
                <div class="row">
                {{-- <div class="col-sm-4" style="margin-left: 15px;margin-top: 15px;">
                <div class="input-group">
                    <span class="input-group-addon"><i class="feather icon-calendar" aria-hidden="true"></i></span>
                    <input type="text" class="form-control form-control-primary" name="filtro-fechas" id="filtro-fechas" >
                    </div>
                </div> --}}
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

                <div class="col-sm-1 display_none" style="margin-left: 15px;margin-top: 15px;">
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
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Unidad</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Unidad</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
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
        "url":      "{{route('productos.indexTable')}}",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token        = "<?= csrf_token() ?>";
        data.estado        = $("#estado").val();
        // data.fecha_ini     = $("#fecha_ini_hide").val();
        // data.fecha_fin     = $("#fecha_fin_hide").val();
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        {"data": "action", "searchable": false, "orderable": false, 'className': 'dropdown', "width": "10%"},
        {"data": "codigo"},
        {"data": "descripcion"},
        {"data": "unidad"},
        {"data": "precio_unitario"},
        {"data": "estado"}
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
    $("#estado").change(function(){
        $("#btn_buscar_info").click();
    });
    </script>
@endsection
