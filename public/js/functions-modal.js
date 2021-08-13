$(document).ready(function(){
$(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%',
    language: {
        noResults: function() {
          return "No se encontraron resultados.";        
        },
        searching: function() {
          return "Buscando..";
        }
    }
});
$(".solo_numeros").bind('keypress', function(event) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });
//Solo permitir letras y espacios
  $(".solo_letras").bind('keypress', function(event) {
  var regex = new RegExp("^[a-zA-ZäÄëËïÏöÖüÜáéíóúÁÉÍÓÚñÑ ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});
  /*Validar formato telefono*/
$(".mask-telefono").inputmask({ mask: "999-999-999"});

/*Validar formato de telefono*/
$.validator.addMethod("is_phone", function (phone_number, element) {
    if ((phone_number.length > 7) && (phone_number.length < 12)) {
        return this.optional(element) || phone_number.match(/^(\+?[1-9]{1,4})?([0-9-]{7,13})$/);
    } else {
        return true;
    }
});
  /*Validar formato de correo*/
$.validator.addMethod("is_email", function (value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z0-9._-]+[a-zA-Z0-9]@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
});
// // Validar cliente unico
$('.validar_num_documento').bind('blur',function(){
    var num_documento_hidden = $('.num_documento_hidden').val();
    var num_documento = $('.validar_num_documento').val();
    var tipo_documento = $('#tipo_documento').val();
    if(num_documento != '' && num_documento_hidden != num_documento && tipo_documento != 'OTRO'){
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        }
    });
    $.ajax({
        url: 'posibles-clientes/search_client/'+num_documento,
        type: "get",
        dataType: "json",
        beforeSend: function () {
        },
        success: function (data) {
            if (data.status == true ) {
                $("#btn-send-success").addClass('disabled');
                $("#btn-send-success").prop('disabled', true);
                mostrarMensajeInfo(data.message);
            }else{
                $("#btn-send-success").prop('disabled', false);
                $("#btn-send-success").removeClass('disabled');
            }
        },
        error: function () {
        }
    });
    }else{
        $("#btn-send-success").prop('disabled', false);
        $("#btn-send-success").removeClass('disabled');
    }
});
    var urlActualModal = jQuery(location).attr('href');
    if (urlActualModal.includes("posibles-clientes") || urlActualModal.includes("clientes")) {
        // Funcion si es juridica o persona narutal
        var value_load = $(".check_class").attr("checked") ? 1 : 2;
        var cliente_id = $("#cliente_id").val();
        if(value_load == 1){
            $.get( "clientes/tipo-documento/" + value_load +'/'+ cliente_id, function(data) {
                $("#tipo_documento").html(data).trigger("change");
            });
        }else{
            $.get( "clientes/tipo-documento/" + value_load +'/'+ cliente_id, function(data) {
                $("#tipo_documento").html(data).trigger("change");
            });
        }
        $(".check_class").change(function() {
            if( $(this).is(':checked') ){
                var value = $(this).val();
                $.get( "clientes/tipo-documento/" + value +'/'+ cliente_id, function(data) {
                    $("#tipo_documento").html(data).trigger("change");
                });
            }
            
        });
    }

});
