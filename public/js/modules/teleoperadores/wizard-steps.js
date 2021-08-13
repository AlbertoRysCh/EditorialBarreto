// Validate steps wizard

// Show form
var form = $(".steps-validation").show();

$(".steps-validation").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Enviar",
        next: "Siguiente",
        previous: "Atrás",
        cancel: "Cancelar"
    },
    onInit :function () {
        $('.actions a[href="#finish"]').attr('id', 'registrar-servicio');
     },
    onStepChanging: function (event, currentIndex, newIndex) {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex) {
            return true;
        }

        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex) {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        // Validar si es persona juridica o natural
        var tipoSer = $('#tipo_servicio').val();
        var total = $('#total').val();
        var precio_base = $('#precio_base').val();
        var num_km = parseFloat($("#num_km").val());
        var descuentoServicio = $("#descuento_servicio").val();
        if(tipoSer == 1){
            switch (currentIndex) {
                case 1:
                    var cantidadProductos = $('#cant_lineas').val();
                    if (cantidadProductos == 0 ) {
                        mostrarMensajeInfo("Debe seleccionar un producto o servicio de la lista antes de continuar");
                        return false;
                    }
                    // $('#total_servicio').val(total);
                break;
            }
        }
        if(tipoSer == 0){
            var lengthRows = $('.productoFila', $("#tablaProductos")).length;
            if(lengthRows > 0){
                for (var i = 0; i <= lengthRows; i++) {
                $(".productoFila").each(function() {
                    $(".productoFila").remove();
                });
                }
            }
            $("#cant_lineas").val(0);
        }else{
            // $('#origen').val('');
            // $('#destino').val('');
            $('#direccion_cliente').val('');
            $('#nombre_cliente').val('');
            $('#correo_cliente').val('');
            $('#telefono_cliente').val('');
            $('#servicio').val('');
            // $('#total_delivery').val('0.00');
        }

        
        var calcularTotal = parseFloat(precio_base) + parseFloat(total) + calculateKm(num_km);
        var desT = calcularTotal - parseFloat(descuentoServicio);
        $('#total_servicio').val(desT.toFixed(2));
        $('#total_servicio_hide').val(calcularTotal.toFixed(2));
        $('#total_venta').val(total);

        var calcularDelivery = parseFloat(precio_base) + calculateKm(num_km);
        var desD = calcularDelivery - parseFloat(descuentoServicio);
        $('#total_delivery').val(desD.toFixed(2));
        $('#total_delivery_hide').val(calcularDelivery.toFixed(2));

        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex) {
        form.validate().settings.ignore = ":disabled";
        validateForm = true;
        var tipoSer = $('#tipo_servicio').val();
        if(tipoSer == 0){
            var lengthRows = $('.productoFila', $("#tablaProductos")).length;
            if(lengthRows > 0){
                for (var i = 0; i <= lengthRows; i++) {
                $(".productoFila").each(function() {
                    $(".productoFila").remove();
                });
                }
            }
            $("#cant_lineas").val(0);
            form.validate({
                unhighlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                }
            }).settings.ignore = ":disabled,:hidden";
        }else{
            // $('#origen').val('');
            // $('#destino').val('');
            $('#direccion_cliente').val('');
            $('#nombre_cliente').val('');
            $('#correo_cliente').val('');
            $('#telefono_cliente').val('');
            $('#servicio').val('');
            // $('#total_delivery').val('0.00');
            form.validate({
                unhighlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                }
            }).settings.ignore = ":disabled,:hidden";
        }
        /* Validacion monto si es efectivo */
        var metodoPago = $("#payment_id").val();
        var file_capture = $("#baucher-transferencia").val();

        if(metodoPago == 2){
            var efectivo = $('#efectivo').val();
            if(efectivo == 0.00 || efectivo == ''){
                mostrarMensajeInfo("El efectivo debe ser mayor a 0.00");
                validateForm = false;
            }
        }else if(metodoPago == 1){
            if(file_capture == null || file_capture == ''){
                mostrarMensajeInfo("El capture de pago es requerido");
                validateForm = false;
            }
        }

        if (!form.valid()) {
            validateForm = false;
        }

        return  validateForm;
    },
    onFinished: function (event, currentIndex) {
        /* Envio de registro de servicio */

        // var urlForm = $("#form_servicios").attr("action");
        // var dataForm = $("#form_servicios").serialize();

        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=_token]').attr('content')
            }
        });
        $.ajax({
            url: formURL,
            type: "POST",
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                if(data.status == true){
                    var href = '../servicios-pendientes/lista';
                    // var href = '../teleoperadores/lista';
                    mostrarMensajeSuccessRedirect(data.message,href);
                }else{
                    mostrarMensajeInfo(data.message);
                }
            },
            beforeSend: function () {
                $('.preload_wait').css("display", "block");
            },
            complete: function () {
                $('.preload_wait').css('display', 'none');
            }
        });
        return false;
    }
});
$("#registrar-servicio").css('display','none');

$.validator.addMethod("min_val_km", function (value, element) {
    if ($('#num_km').val() == 0) {
        return false;
    } else {
        return true;
    }
}, "El kilómetro debe ser mayor a 0 km");

// Initialize validation
$(".steps-validation").validate({
    ignore: 'input[type=hidden]', // ignore hidden fields
    errorClass: 'danger',
    successClass: 'success',
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    },
    rules: {
        // origen: {
        //     required: true
        // },
        // destino: {
        //     required: true
        // },
        direccion_empresa: {
            required: true,
            maxlength: 200
        },
        direccion_cliente: {
            required: true,
            maxlength: 200
        },
        nombre_cliente: {
            required: true,
            maxlength: 150
        },
        correo_cliente: {
            is_email: true,
            maxlength: 150
        },
        servicio: {
            required: true,
            maxlength: 255
        },
        num_km: {
            required: true,
            min_val_km: true,
        },
        precio_base: {
            required: true
        },
    },
    messages: {
        direccion_empresa: {
            required: "La dirección de origen es requerida.",
            maxlength: 'Máximo 200 caracteres'
        },
        direccion_cliente: {
            required: "La dirección de destino es requerida.",
            maxlength: 'Máximo 200 caracteres'
        },
        nombre_cliente: {
            required: "El nombre del cliente consumidor es requerido.",
            maxlength: 'Máximo 150 caracteres'
        },
        correo_cliente: {
            is_email: "Formato de correo inválido",
            maxlength: 'Máximo 150 caracteres'
        },
        servicio: {
            required: "El servicio a ofrecer es requerido.",
            maxlength: 'Máximo 255 caracteres'
        },
        num_km: {
            required: "El kilómetro es requerido.",
        },
        precio_base: {
            required: "El precio base es requerido.",
        },

   },
});

function calculateKm(num_km){
    var metros = num_km * 1000;
    var sum_km = 0.00;
    if(metros > 4000){
        var restarMetros = metros - 4000;
        sum_km = restarMetros * 0.10 / 100;
    }
    return sum_km;
}
