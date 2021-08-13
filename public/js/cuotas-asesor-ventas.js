
$(document).ready(function(){

    //Agregar cuotas
    $("#modalCuotas").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        // var action = "{{route('guardarcuota')}}";
        var action = "/ordentrabajo/guardarcuota";
        $("#defaultModalForm").prop("action", action);
        $("#idordentrabajo").val(btn.attr('data-id'));
        $("#precio").val(btn.attr('data-precios'));
        $("#total_pendiente").val(btn.attr('data-total_por_cobrar'));
        // $("#fecha_cuota_aux").val();
        $('#monto_aux').val('0.00');
        var lengthRows = $('.cuotaFila', $("#regCuota")).length;
        if(lengthRows > 0){
            for (var i = 0; i <= lengthRows; i++) {
            $(".cuotaFila").each(function(index ,value) {
                $(".cuotaFila").remove();
            });
            }
        }
    });
    $('#abrirmodalfirma').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget)
        var modalfirma = button.data('clientes_id')
        var modal = $(this)
        modal.find('.modal-body #id_clientes').val(modalfirma);
        });
    $("#modalCuotas").on("hidden.bs.modal", function (e) {
      x = 1;
      $(".max_msg").hide();
      $("#idordentrabajo").val('');
      $("#statu").val(0);
      $("#fecha_cuota_aux").val(currentDate());
      $('#monto_aux').val('0.00');
    });

    $('.selectpicker').selectpicker({
        noneResultsText: 'No se encontraron resultados.'
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose : true
    });
    $('.datepicker').on("show", function(e){
        e.preventDefault();
        e.stopPropagation();
        }).on("hide", function(e){
                e.preventDefault();
                e.stopPropagation();
    });

      $(".max_msg").hide();
      var maxField = 5;
      var addButton = $('.agregar_cuota');

      var wrapper = $('.table_orden_trabajo');
      var x = 1; //Initial field counter is 1

      $(addButton).click(function (e) {
          e.preventDefault();
          $(".max_msg").hide();
          var fecha_cuota = $('#fecha_cuota_aux').val();
          var monto = $('#monto_aux').val();
        //   console.log(fecha_cuota+'-'+monto+'-'+x);
            if(fecha_cuota == ''){
                $(".max_msg").html("Ingrese fecha de cuota");
                $(".max_msg").show();
                return false;
            }
            if(monto == ''){
                $(".max_msg").html("Ingrese monto de la cuota");
                $(".max_msg").show();
                return false;
            }
            if(monto == '0' || monto == '0.00'){
                $(".max_msg").html("El monto de la cuota debe ser mayor a 0");
                $(".max_msg").show();
                return false;
            }
            var precio_total_pendiente = $('#total_pendiente').val();
            var resultado = 0;
            if(monto !== '' && x <= maxField){
                resultado = precio_total_pendiente - monto;
                if(resultado < 0){
                    $('#monto_aux').val('0.00');
                    Swal.fire({
                        icon: 'info',
                        text: 'Monto ingresado supera el precio total pendiente.',
                        })
                        event.preventDefault();
                        return false;
                }else{
                    value = parseFloat(resultado).toFixed(2);
                    $('#total_pendiente').val(value);
                }
            }
          var fieldHTML = '<tr class="cuotaFila"><td style="width: 50%;"><div class="form-group"><input type="text" class="form-control datepicker" id="fecha_cuota' + x + '"name="fecha_cuota[]" value="' + fecha_cuota + '" readonly="true"></div></td>'
                  + '<td style="width: 50%;"><div class="form-group"><input type="text" class="form-control" id="monto' + x + '"name="monto[]" value="' + monto + '" readonly="true"></div></td>'
                  + '<td><a style="margin-top:-20px;" class="remove_button btn btn-danger" href="javascript:void(0)" id="' + x + '" title="Eliminar"><i class="fa fa-minus"></i></a></td>'
                  + '</tr>';

          if (x <= maxField) {
              x++;
              $(wrapper).append(fieldHTML);
            //   $('#fecha_cuota_aux').val("");
              $('#monto_aux').val("0.00");
          } else {
              $(".max_msg").html("Usted ha excedido el máximo de cuotas permitidas (5)");
              $(".max_msg").show();
              $(".agregar_cuota").hide();
              return false;
          }
      });
      $(wrapper).on('click', '.remove_button', function (e) {
          e.preventDefault();
          x--;
          if (x <= maxField) {
              $(".agregar_cuota").show();
          }
          fila_id = $(this).attr('id');
          var fila = fila_id;
          var precio_total_pendiente_remove = $('#total_pendiente').val();
          var monto = $("#monto" + fila).val();
          var resultado = parseFloat(precio_total_pendiente_remove) + parseFloat(monto);
          value = parseFloat(resultado).toFixed(2);
          $('#total_pendiente').val(value);
          $(this).parent().parent().remove();
          $(".max_msg").hide();
      });

    });
    //Fin de agregar cuotas
    // // // // // // // // // // // // // // // // // // //

    $(".actualizar").click(function(){
    location.reload();


    });
