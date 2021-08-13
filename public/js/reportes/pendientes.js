var table = $('.data-table').DataTable({
    language,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url":      'indexTable',
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token        = $("meta[name='csrf-token']").attr("content");
        data.clientes_select        = $("#clientes_select").val();
        data.anio        = $("#anio").val();
        data.fecha_ini     = $("#fecha_ini_hide").val();
        data.fecha_fin     = $("#fecha_fin_hide").val();
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        {"data": "action", "searchable": false, "orderable": false, 'className': 'dropdown', "width": "10%"},
        {"data": "datos_cliente", "width": "35%", "searchable": false, "orderable": false},
        {"data": "datos_servicio", "width": "25%", "searchable": false, "orderable": false},
        {"data": "repartidor", "width": "25%", "searchable": false, "orderable": false},
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
  

  $("#clientes_select").change(function(){
      $("#btn_buscar_info").click();
  });
  // Al seleccionar
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
      let cliente = $("#clientes_select").val();
      let anio = $("#anio").val();
      let search = $('div.dataTables_filter input').val();
      let tipoPago = 1;
      if(search == '')
          search = 'T';
  
      let url = 'excel/'+ fecha_inicio + "/" + fecha_fin + "/" +tipoPago + "/" + cliente+ "/" +anio+ "/" +search;
      $('#formPendientes').attr('action',url);
      $('#formPendientes').submit();
  
  });