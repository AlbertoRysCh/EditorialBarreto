var id_form = $("#modal-view form").attr("id");
$("#"+id_form).validate({
    ignore: "",
    rules: {
        email: {
            is_email: true
        },
        telefono: {
            is_phone: true
        },
        num_documento: {
            minlength: 8,
            maxlength: 15,
            required: {
            depends: function () {
                var tipo_documento = $('#tipo_documento').val();
                    if(tipo_documento != 'OTRO'){
                        return true;
                    }
            }
        }
        },
        name: {
            required: true
        },
        username: {
            required: true
        },
        password: {
            required: {
                depends: function () {
                    if(id_form == 'form_usuarios_create'){
                        return true;
                    }
                }
            }
        },
    },
    messages: {
        email: {
           is_email: "Formato de correo inválido",
       },
       telefono: {
           is_phone: "Número de teléfono incompleto",
       },
       num_documento: {
           required: "Número es requerido",
           minlength: "Mínimo 8 números",
           maxlength: "Máximo 15 números"
       },
       name: {
           required: "El nombre es requerido",
       },
       username: {
        required: "El nombre de usuario es requerido",
       },
        password: {
            required: "La contraseña del usuario es requerida",
       },

   },
    highlight: function (element) {
        $(element).parent().addClass('error')
    },
    unhighlight: function (element) {
        $(element).parent().removeClass('error')
    }


});
// Select distritos
    var rolId =  $('#rol_id').val();
    $('.distritos_select').css('display','none');
    $('#distrito_ubigeo').removeAttr('required');
    if(rolId == 4){
        $('.distritos_select').css('display','block');
        $('#distrito_ubigeo').prop('required',true);
    }
    $('#rol_id').on('change',function(){
        let rol_id = $(this).val();

        $('.distritos_select').css('display','none');
        $('#distrito_ubigeo').removeAttr('required');

        if(rol_id == 4){
            $('.distritos_select').css('display','block');
            $('#distrito_ubigeo').prop('required',true);
        }

    });