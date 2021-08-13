var table = $('.data-table').DataTable({
language,
"processing": true,
"serverSide": true,
"ajax": {
    "url":      "vendedoresAjax",
    "dataType": "json",
    "type":     "POST",
    "data":     function (data) {
    data._token        = $("meta[name='csrf-token']").attr("content");
    data.vendedores_select        = $("#vendedores_select").val();
    data.anio        = $("#anio").val();
    data.fecha_ini     = $("#fecha_ini_hide").val();
    data.fecha_fin     = $("#fecha_fin_hide").val();
    },
}, "preDrawCallback": function (settings) {
},
"drawCallback": function (settings) {
},
"columns": [
    {"data": "vendedor"},
    {"data": "mes"},
    {"data": "num_semana"},
    {"data": "num_programadas"},
    {"data": "num_realizadas"},
    {"data": "num_pendientes"},
    {"data": "clientes_rs"},
    {"data": "clientes_foraneos"},
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


$("#vendedores_select").change(function(){
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
    let vendedor = $("#vendedores_select").val();
    let anio = $("#anio").val();
    let search = $('div.dataTables_filter input').val();

    if(search == '')
        search = 'T';

    let url = 'vendedores/excel/'+ fecha_inicio + "/" + fecha_fin + "/" + vendedor+ "/" +anio+ "/" +search;
    $('#formVendedores').attr('action',url);
    $('#formVendedores').submit();

});