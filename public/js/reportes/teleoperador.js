var table = $('.data-table').DataTable({
    language,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url":      "teleoperadoresAjax",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token        = $("meta[name='csrf-token']").attr("content");
        data.repartidores_select        = $("#repartidores_select").val();
        data.estado_pago        = $("#estado_pago").val();
        data.anio        = $("#anio").val();
        data.fecha_ini     = $("#fecha_ini_hide").val();
        data.fecha_fin     = $("#fecha_fin_hide").val();
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        {"data": "fecha"},
        {"data": "cliente"},
        {"data": "direccion_inicio"},
        {"data": "direccion_final"},
        {"data": "nombre_cliente"},
        {"data": "nro_celular"},
        {"data": "repartidor"},
        // {"data": "hora_fecha"},
        // {"data": "hora_entrega"},
        // {"data": "total_km"},
        // {"data": "km_adicional"},
        // {"data": "costo_basico"},
        // {"data": "km_adicional_soles"},
        {"data": "total_a_pagar"},
        {"data": "estado"}
    ],
    "columnDefs": [ {
    "targets": 0,
    "orderable": false
    }],
    
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
    
    
    $("#repartidores_select,#estado_pago").change(function(){
        $("#btn_buscar_info").click();
    });
    
    $.fn.dataTable.ext.errMode = () => console.log('Error en la carga de la tabla. Por favor refrescar página.');
    
    $('#btn_buscar_info').click(function (e) {
        e.preventDefault();
        table.search($('div.dataTables_filter input').val()).draw();
    });
    
    // Exportar excel
    $('.btn-exportar').click(function (e){
        e.preventDefault();
    
        let fecha_inicio = $("#fecha_ini_hide").val();
        let fecha_fin = $("#fecha_fin_hide").val();
        let repartidor = $("#repartidores_select").val();
        let estado_pago = $("#estado_pago").val();
        let anio = $("#anio").val();
        let search = $('div.dataTables_filter input').val();
    
        if(search == '')
            search = 'T';
    
        let url = 'teleoperadores/excel/'+ fecha_inicio + "/" + fecha_fin + "/" + repartidor+ "/"+ estado_pago+ "/" +anio+ "/" +search;
        $('#formTeleoperador').attr('action',url);
        $('#formTeleoperador').submit();
    
    });