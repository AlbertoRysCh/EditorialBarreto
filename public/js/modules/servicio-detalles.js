 $("#modal-detalles").on("show.bs.modal", function (e) {
    var btn = $(e.relatedTarget);

    // Data
    $("#servicio_id").val(btn.attr('data-id'));
    $('[name="codigo"]').html(btn.attr('data-codigo'));
    $('[name="ticket"]').html(btn.attr('data-ticket'));
    $('[name="codigo_pedido"]').html(btn.attr('data-codigo_pedido'));
    $('[name="hora_estimada_recojo"]').html(btn.attr('data-hora_estimada_recojo'));
    $('[name="is_fragil"]').html(btn.attr('data-is_fragil'));
    $('[name="num_documento"]').html(btn.attr('data-num_documento'));
    $('[name="nombres"]').html(btn.attr('data-nombres'));
    $('[name="direccion"]').html(btn.attr('data-direccion'));
    $('[name="telefono"]').html(btn.attr('data-telefono'));
    $('[name="correo"]').html(btn.attr('data-correo'));
    $('[name="metodo_pago"]').html(btn.attr('data-metodo_pago'));
    $('[name="total_servicio"]').html(btn.attr('data-total_servicio'));
    $('[name="total_delivery"]').html(btn.attr('data-total_delivery'));
    $('[name="efectivo"]').html(btn.attr('data-efectivo'));
    $('[name="vuelto"]').html(btn.attr('data-vuelto'));
    var tipo_servicio = $("#tipo_servicio").val(btn.attr('data-tipo_servicio'));
    var metodo_pago = $('[name="metodo_pago"]').val(btn.attr('data-metodo_pago'));
    if(metodo_pago[0].value == 'Transferencia'){
        $('.section_efectivo').css('display','none');
    }else{
        $('.section_efectivo').css('display','block');
    }
    $('[name="total_venta"]').html(btn.attr('data-total_venta'));

    if(tipo_servicio[0].value == 1){
        $(".servicio_interno").css('display','block');
        $(".servicio_externo").css('display','none');
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $('.data-detalles').DataTable({
    language,
    "pageLength": 5,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url":      "repartidores/servicios-detalles",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data.servicio_id   = $("#servicio_id").val();
        },
    },
    "preDrawCallback": function (settings) {
        $('.dataTables_filter').hide();
        $('.dataTables_length').hide();
        $("#btn_cancel_detalles").css("display", "none");
    },
    "drawCallback": function (settings) {
        $("#btn_cancel_detalles").css("display", "block");
    },
    "columns": [
        // {"data": "codigo", "width": "20%", "searchable": false, "orderable": false},
        // {"data": "unidad", "width": "25%", "searchable": false, "orderable": false},
        {"data": "descripcion", "width": "20%", "searchable": false, "orderable": false},
        {"data": "cantidad", "width": "10%", "searchable": false, "orderable": false},
        {"data": "precio_unitario", "width": "10%", "searchable": false, "orderable": false},
        {"data": "tienda", "width": "10%", "searchable": false, "orderable": false}
    ],
    });
    $.fn.dataTable.ext.errMode = () => console.log('Error en la carga de la tabla. Por favor refrescar página.');
    $("#modal-detalles").on("hidden.bs.modal", function () {
        let clearTable = $('.data-detalles').DataTable();
        clearTable.destroy();
        clearTable.draw();
    });
    }else{
        $(".servicio_interno").css('display','none');
        $(".servicio_externo").css('display','block');

        var servicioId = $("#servicio_id").val();
        var urlSend = $("#formClienteExterno").attr("action");
        var datosPost = {
            'servicio_id': servicioId,
            '_token': $('input[name=_token]').val(),
        }
        $.ajax({
            type : 'POST',
            url : urlSend,
            dataType : 'json', // expected returned data format.
            data : datosPost,
            beforeSend: function () {
                $('.preload_wait').css("display", "block");
            },
            complete: function () {
                $('.loader-externo').css('display','none');
                $('.preload_wait').css('display', 'none');
            },
            success : function(data)
            {

                var itemsJson = data.data.items;
                var obj = JSON.parse(itemsJson);
                $('#servicio_cliente').html(obj.servicio);
                $('#correo_cliente').html(obj.correo_cliente);
                $('#nombre_cliente').html(obj.nombre_cliente);
                $('#telefono_cliente').html(obj.telefono_cliente);
                $('#direccion_cliente').html(obj.direccion_cliente);
                $('#direccion_empresa').html(obj.direccion_empresa);
            },
            error: function () {
                $('.preload_wait').css('display', 'none');
                $("#modal-detalles").hide();
            }
        });
    }

    });


    ////////////////////////////////////////////
