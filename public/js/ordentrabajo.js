$(document).ready(function(){
    //Agregar cuotas
    
    $("#modalCuotas").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        // var action = "{{route('guardarcuota')}}";
        var action = "/ordentrabajo/guardarcuota";
        $("#defaultModalForm").prop("action", action);
        $("#idordentrabajo").val(btn.attr('data-id'));
        $("#codigo").val(btn.attr('data-codigo'));
        $("#precio").val(btn.attr('data-precio'));
        $("#titulo").val(btn.attr('data-titulo'));
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
    $('#abrirmodalfirma').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
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

    var cont=0;
    var url_ = jQuery(location).attr('href');
    if(url_.includes("create")){
       $("#guardar").hide();
    }
    // Agregar autores
    $("#agregar").click(function(){
        agregar();
    });
    function agregar(){
        var mensaje = "Seleccione un autor";
        datosAutores = document.getElementById('id_autor').value.split('_');
        id_autor= datosAutores[0];
        autor= $("#id_autor option:selected").text();
            if(!validarAutor()){
                if(id_autor == 0){
                    mostrarMensajeInfo(mensaje);
                    return false;
                }else{
                    var fila= `
                    <tr class="selected" id="fila${cont}">
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar(${cont});">
                    <i class="fa fa-times"></i></button></td>
                    <td><input type="hidden" name="id_autor[]" id="autor_${cont}" value="${id_autor}">${autor}</td>
                    </tr>`;
                    cont++;
                    var cantLineas = cont;
                    $("#lineas").val(cantLineas);
                    $('#detalles').append(fila);
                    evaluar();

                }
                $(".autor_select").val(0).change();
            }

    }

    function evaluar(){
        var nFilas = $("#detalles > tr").length;
         if(nFilas == 0){
           $("#guardar").hide();
         } else{
           $("#guardar").show();
         }
    }

    function eliminar(index){
        $("#fila" + index).remove();
        var lineas = $("#lineas").val();
        $("#lineas").val(lineas - 1)
        // console.log(lineas);
        if(lineas == 1){
            cont = 0;
            evaluar();
        }
    }

    function validarAutor() {
        var nFilas =  $("#lineas").val();
        // console.log(nFilas);
        var lineasError=[];
        datosAutores = document.getElementById('id_autor').value.split('_');
        id_autor= datosAutores[0];
        for (var i = 0; i < nFilas; i++) {
        $("#autor_" + i).each(function(index, value) {

        // console.log($("#autor_" + i).val());
        var livalue = $(this).attr('value');

        if (id_autor == livalue) {
            lineasError.push({'linea': i ,'item': nFilas , 'error' :'El autor ya se encuentra en la lista.'});
        }
        else{
            $('#fila'+ i).css('background-color', '#C0DEB3');
        }
        });
        }
        mensajeError = `Verificar:<br>
        <ul style="text-align:left">`;

        var iter = 0;
        for(var iter; iter < lineasError.length; iter++){
        $('#fila'+ lineasError[iter].linea).css('background-color', '#F5BEBE');
        mensajeError += `<li>`+ lineasError[iter].error +`</li>`;
        }

        mensajeError += `</ul>`;

        if( lineasError.length > 0){
        mostrarMensajeError(mensajeError);
        return true;
        }
        else{
        return false;
        }
    }
    // fin agregar autores

    $(".actualizar").click(function(){
    location.reload();
    });
    $("#modalAprobarOt").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        $('input[name=orden_trabajo_id]').val(btn.attr('data-id'));
    });
    $("#modalAprobarOtCoautoria").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        $('input[name=orden_trabajo_id]').val(btn.attr('data-id'));
    });
    // Aprobar una orden de trabajo
    $("#btn-aprobar-ot").on("click",function(e) {
    e.preventDefault();
    var urlVerificar = $("#formAprobarOt").attr("action");
    var datosPost = {
        'orden_trabajo_id': $('input[name=orden_trabajo_id]').val(),
        '_token': $('input[name=_token]').val()
      }
    $.ajax({
        url: urlVerificar,
        type: "POST",
        data: datosPost,
        dataType: 'json',
        beforeSend: function () {
            $('.show_wait_load').css('display', 'block');
            $('.actions').hide();
        },
        complete: function () {
            $('.show_wait_load').css('display', 'none');
            $('.actions').show();
        },
        success: function (data) {
            if(data.confirm == 1){
                // e.preventDefault();

                Swal.fire({
                title: 'Estás seguro de APROBAR la OT aun no supera el 50 %?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                reverseButtons : true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, aprobar!'
                }).then((result) => {
                if (result.value) {
                    $("#modalAprobarOt").modal("hide");
                    $.ajax({
                        url: 'ordentrabajo/aprobar',
                        type: "POST",
                        data: datosPost,
                        dataType: 'json',
                        success: function (data) {
                            mostrarMensajeSuccess(data.message);
                            $("#modalAprobarOt").modal("hide");
                            $('#modalAprobarOt').delay(1600).fadeOut('slow').promise().done(function(){
                                location.reload();
                                });
                                
                        },
                        error: function () {
                        }
                    });

                    }else{
                        $("#modalAprobarOt").modal("hide");
                    }
                })
    
                }else{
                mostrarMensajeSuccess(data.message);
                $("#modalAprobarOt").modal("hide");
                $('#modalAprobarOt').delay(1600).fadeOut('slow').promise().done(function(){
                    location.reload();
                    });
                }
                
        },
        error: function () {
        }
    });
        return false;
    });