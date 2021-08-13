var maxField = 15;
  var addButton = $('.add_cliente');

  var wrapper = $('.tabla_autores');

  $(addButton).click(function (e) {
    var x = $("#cantidadAutoresReales").val();
    var count = parseInt(x) + parseInt(1);
    // console.log(count);
    e.preventDefault();
    var especialidad = $('[name="especialidad_aux"]').val();
    var nombres = $('[name="nombres_aux"]').val();
    var apellidos = $('[name="apellidos_aux"]').val();
    var num_documento = $('[name="num_documento_aux"]').val();
    clear_number = num_documento.replace(/ /g, '');
    var correocontacto = $('[name="correocontacto_aux"]').val();
    var telefono = $('[name="telefono_aux"]').val();
    var tipo_documento = $('[name="tipo_doc_aux"]').val();
    var tipo_grado = $('[name="tipo_grado_aux"]').val();

        if(clear_number == ''){
            $('[name="num_documento_aux"]').focus()
            mostrarMensajeInfo('Ingrese número de documento del cliente');
            return false;
        }
        if(clear_number != '' && tipo_documento == null){
            $('[name="tipo_doc_aux"]').focus();
            mostrarMensajeInfo('Seleccione tipo de documento');
            return false;
        }
        if(clear_number != '' &&  tipo_grado == null){
            $('[name="tipo_grado_aux"]').focus();
            mostrarMensajeInfo('Seleccione tipo de grado');
            return false;
        }
        if(nombres == ''){
            $('[name="nombres_aux"]').focus();
            mostrarMensajeInfo('Ingrese nombres del cliente');
            return false;
        }

        var nombre_grado = '';
        if(tipo_grado == 1){
            nombre_grado = 'Maestria';
        }else if(tipo_grado == 2){
            nombre_grado = 'Doctor';
        }else if(tipo_grado == 3){
            nombre_grado = 'Postdoctor';
        }else if(tipo_grado == 3){
            nombre_grado = 'Bachiller';
        }else{
            nombre_grado = 'No aplica';
        }
    
    var fieldHTML = `
                <tr id="trLinea_${count + 1}">
                <th scope="row" id="numeroOrden_${count + 1}">${count + 1}</th>
                <td>
                <input type="text" class="form-control"
                id="num_documento_${count + 1}" name="num_documento_${count + 1}" value="${clear_number}" readonly="true">
                </td>
                <td><input type="text" name="tipo_doc_${count + 1}"  class="form-control" value="${tipo_documento}" readonly></td>
                <td>
                <input type="text" class="form-control" value="${nombre_grado}" readonly>
                <input type="hidden" name="tipo_grado_${count + 1}"  class="form-control" value="${tipo_grado}" readonly>
                </td>
                <td>
                <input type="text" class="form-control"
                id="nombres_${count + 1}" name="nombres_${count + 1}" value="${nombres}" readonly="true">
                </td>
                <td>
                <input type="text" class="form-control"
                id="apellidos_${count + 1}" name="apellidos_${count + 1}" value="${apellidos}" readonly="true">
                </td>
                <td>
                <input type="hidden" id="nuevoCliente_${count + 1}" name="nuevoCliente_${count + 1}" value="1">
                <input type="text" class="form-control"
                id="especialidad_${count + 1}" name="especialidad_${count + 1}" value="${especialidad}" readonly="true">
                </td>
                <td>
                <input type="text" class="form-control"
                id="correocontacto_${count + 1}" name="correocontacto_${count + 1}" value="${correocontacto}" readonly="true">
                </td>
                <td>
                <input type="text" class="form-control"
                id="telefono_${count + 1}" name="telefono_${count + 1}" value="${telefono}" readonly="true">
                </td>
                <td>
                </td>
                <td>
                <span  class="btn btn-danger btn-outline-danger btn-block remove_button"><i class="fa fa-close"></i></span>
                </td>
                </tr>`;
    if(!validarNumCliente()){          
        if (x < maxField) {
                x++;
                $(wrapper).append(fieldHTML);
                $('[name="especialidad_aux"]').val("");
                $('[name="especialidad_aux"]').removeAttr("readonly");
                $('[name="nombres_aux"]').val("");
                $('[name="nombres_aux"]').removeAttr("readonly");
                $('[name="apellidos_aux"]').val("");
                $('[name="apellidos_aux"]').removeAttr("readonly");
                $('[name="num_documento_aux"]').val("");
                $('[name="num_documento_aux"]').removeAttr("readonly");
                $('[name="correocontacto_aux"]').val("");
                $('[name="correocontacto_aux"]').removeAttr("readonly");
                $('[name="telefono_aux"]').val("");
                $('[name="telefono_aux"]').removeAttr("readonly");
                $('[name="tipo_doc_aux"]').val("");
                $('[name="tipo_doc_aux"]').prop('disabled', false);
                $('[name="tipo_grado_aux"]').val("");
                $('[name="tipo_grado_aux"]').prop('disabled', false);
                $("#cantidadAutoresReales").val(count);
                var num_orden = 0;
                for (var i = 1; i <= count + 1; i++) {
                    if ($("#nuevoCliente_" + i).val() == '1') {
                    num_orden++;
                    $("#cantidadAutoresNuevos").val(num_orden);
                    }
                }
                if($("#cantidadAutoresNuevos").val() >= 1){
                    $('.save_authors').css("display",'block');
                }
        } else {
            mostrarMensajeInfo('Usted ha excedido el máximo de coautores permitidos (15)');
            return false;
        }
    }
});
$(wrapper).on('click', '.remove_button', function (e) {
    e.preventDefault();
    var x = $("#cantidadAutoresReales").val();
    x--;
    $("#cantidadAutoresReales").val(x);
    var cantAutoresReales = $("#cantidadAutoresReales").val(x);
    var cantAutores = $("#cantidadAutores").val();
    $("#cantidadAutoresNuevos").val(cantAutoresReales[0].value - cantAutores);
    if($("#cantidadAutoresNuevos").val() == 0){
        $('.save_authors').css("display",'none');
    }
    $(this).parent().parent().remove();
});

// Validar autor no exista su numero de documento
    function buscarAutor() {
    var num_documento = $("#num_documento_aux").val();
    clear_number = num_documento.replace(/ /g, '');
    var codigo = $('[name="codigo"]').val();
    if(clear_number!=''){
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        }
    });
    $.ajax({
        url: '../../../validar-autor/'+clear_number+'/'+codigo,
        type: "get",
        dataType: "json",
        beforeSend: function () {
            $('.show_wait_load').css('display', 'block');
            $('[name="tipo_doc_aux"]').prop('disabled', 'disabled');
            $('[name="tipo_grado_aux"]').prop('disabled', 'disabled');
        },
        complete: function () {
            $('.show_wait_load').css('display', 'none');
            $('[name="tipo_doc_aux"]').prop('disabled', false);
            $('[name="tipo_grado_aux"]').prop('disabled', false);
        },
        success: function (data) {
            if (data.status == true ) {
                $('[name="num_documento_aux"]').val("");
                $('[name="especialidad_aux"]').val("");
                $('[name="especialidad_aux"]').removeAttr("readonly");
                $('[name="nombres_aux"]').val("");
                $('[name="nombres_aux"]').removeAttr("readonly");
                $('[name="apellidos_aux"]').val("");
                $('[name="apellidos_aux"]').removeAttr("readonly");
                $('[name="correocontacto_aux"]').val("");
                $('[name="correocontacto_aux"]').removeAttr("readonly");
                $('[name="telefono_aux"]').val("");
                $('[name="telefono_aux"]').removeAttr("readonly");
                $('[name="tipo_doc_aux"]').val("");
                $('[name="tipo_doc_aux"]').prop('disabled', false);
                $('[name="tipo_grado_aux"]').val("");
                $('[name="tipo_grado_aux"]').prop('disabled', false);
                $(".btn-add-cliente").addClass('disabled');
                $(".btn-add-cliente").prop('disabled', true);
                mostrarMensajeInfo(data.message);
            }else{
                if(data.data != null){
                    $('[name="tipo_doc_aux"]').val(data.data.tipo_documento);
                    $('[name="tipo_doc_aux"]').prop('disabled', 'disabled');
                    $('[name="tipo_grado_aux"]').val(data.data.idgrado);
                    $('[name="tipo_grado_aux"]').prop('disabled', 'disabled');
                    $('[name="nombres_aux"]').val(data.data.nombres);
                    $('[name="nombres_aux"]').attr("readonly","readonly");
                    $('[name="apellidos_aux"]').val(data.data.apellidos);
                    $('[name="apellidos_aux"]').attr("readonly","readonly");
                    $('[name="especialidad_aux"]').val(data.data.especialidad);
                    $('[name="especialidad_aux"]').attr("readonly","readonly");
                    $('[name="correocontacto_aux"]').val(data.data.correocontacto);
                    $('[name="correocontacto_aux"]').attr("readonly","readonly");
                    $('[name="telefono_aux"]').val(data.data.telefono);
                    $('[name="telefono_aux"]').attr("readonly","readonly");
                }else{
                    $('[name="especialidad_aux"]').val("");
                    $('[name="especialidad_aux"]').removeAttr("readonly");
                    $('[name="nombres_aux"]').val("");
                    $('[name="nombres_aux"]').removeAttr("readonly");
                    $('[name="apellidos_aux"]').val("");
                    $('[name="apellidos_aux"]').removeAttr("readonly");
                    $('[name="correocontacto_aux"]').val("");
                    $('[name="correocontacto_aux"]').removeAttr("readonly");
                    $('[name="telefono_aux"]').val("");
                    $('[name="telefono_aux"]').removeAttr("readonly");
                    $('[name="tipo_doc_aux"]').val("");
                    $('[name="tipo_doc_aux"]').prop('disabled', false);
                    $('[name="tipo_grado_aux"]').val("");
                    $('[name="tipo_grado_aux"]').prop('disabled', false);
                }
                $(".btn-add-cliente").prop('disabled', false);
                $(".btn-add-cliente").removeClass('disabled');
            }
        },
        error: function () {
        }
    });
    }else{
        $(".btn-add-cliente").prop('disabled', false);
        $(".btn-add-cliente").removeClass('disabled');
    }
    }

function validarNumCliente() {
    var nFilas =  $("#cantidadAutoresReales").val();
    var count = parseInt(nFilas) + parseInt(2);
    var lineasError=[];
    num_doc = document.getElementById('num_documento_aux').value;
    // id_autor= datosAutores[0];
    for (var i = 0; i < count; i++) {
    $("#num_documento_" + i).each(function(index, value) {

    // console.log($("#autor_" + i).val());
    var livalue = $(this).attr('value');

    if ($.trim(num_doc) == $.trim(livalue)) {
        $('[name="especialidad_aux"]').val("");
        $('[name="especialidad_aux"]').removeAttr("readonly");
        $('[name="nombres_aux"]').val("");
        $('[name="nombres_aux"]').removeAttr("readonly");
        $('[name="apellidos_aux"]').val("");
        $('[name="apellidos_aux"]').removeAttr("readonly");
        $('[name="correocontacto_aux"]').val("");
        $('[name="correocontacto_aux"]').removeAttr("readonly");
        $('[name="telefono_aux"]').val("");
        $('[name="telefono_aux"]').removeAttr("readonly");
        $('[name="tipo_doc_aux"]').val("");
        $('[name="tipo_doc_aux"]').prop('disabled', false);
        $('[name="tipo_grado_aux"]').val("");
        $('[name="tipo_grado_aux"]').prop('disabled', false);
        lineasError.push({'linea': i ,'item': count , 'error' :'El autor ya se encuentra en la lista.'});
    }
    else{
        $('#trLinea_'+ i).css('background-color', '#C0DEB3');
    }
    });
    }
    mensajeError = `Verificar:<br>
    <ul style="text-align:left">`;

    var iter = 0;
    for(var iter; iter < lineasError.length; iter++){
    $('#trLinea_'+ lineasError[iter].linea).css('background-color', '#F5BEBE');
    mensajeError += `<li>`+ lineasError[iter].error +`</li>`;
    }

    mensajeError += `</ul>`;

    if( lineasError.length > 0){
    mostrarMensajeInfo(mensajeError);
    return true;
    }
    else{
    return false;
    }
}