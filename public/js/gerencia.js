$(document).ready(function(){
    //Cuotas
    $("#modalContrato").on("hidden.bs.modal", function () {
    $(".max_msg").hide();
    $("#fecha_cuota_aux").val('');
    $('#monto_aux').val('0.00');
    $("#check_cuotas").prop('checked', false); 
    $('.div_agregar_cuotas').css('display','none');
    $('#monto_aux').val('0.00');
    x = 1;
        var lengthRows = $('.cuotaFila', $("#regCuota")).length;
        if(lengthRows > 0){
            for (var i = 0; i <= lengthRows; i++) {
            $(".cuotaFila").each(function() {
                $(".cuotaFila").remove();
            });
            }
        }
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
            $(".max_msg").html("Ingrese el día de la cuota");
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
        var precio_total_pendiente = $('#precio_cuotas').val();
        var resultado = 0;
        if(monto !== '' && x <= maxField){
            resultado = precio_total_pendiente - monto;
            if(resultado < 0){
                $('#monto_aux').val('0.00');
                Swal.fire({
                    icon: 'info',
                    text: 'Monto ingresado supera el monto para subir el artículo en una revista indexada.',
                    })
                    // event.preventDefault();
                    return false;
            }else{
                value = parseFloat(resultado).toFixed(2);
                $('#precio_cuotas').val(value);
            }
        }
        var fieldHTML = '<tr class="cuotaFila"><td style="width: 50%;"><div class="form-group"><input type="text" class="form-control datepicker" id="fecha_cuota' + x + '"name="fecha_cuota[]" value="' + fecha_cuota + '" readonly="true"></div></td>'
                + '<td style="width: 50%;"><div class="form-group"><input type="text" class="form-control" id="monto' + x + '"name="monto[]" value="' + monto + '" readonly="true"></div></td>'
                + '<td><a style="margin-top:-20px;" class="remove_button btn btn-danger" href="javascript:void(0)" id="' + x + '" title="Eliminar"><i class="fa fa-minus"></i></a></td>'
                + '</tr>';
        if (x <= maxField) {
            x++;
            $(wrapper).append(fieldHTML);
            $('#monto_aux').val("0.00");
            $('#fecha_cuota_aux').val('');
        } else {
            $(".max_msg").html("Usted ha excedido el máximo de cuotas permitidas (5)");
            $(".agregar_cuota").hide();
            $('#monto_aux').val("0.00");
            $('#fecha_cuota_aux').val('');
            $(".max_msg").show();
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
        var precio_total_pendiente_remove = $('#precio_cuotas').val();
        var monto = $("#monto" + fila).val();
        var resultado = parseFloat(precio_total_pendiente_remove) + parseFloat(monto);
        value = parseFloat(resultado).toFixed(2);
        $('#precio_cuotas').val(value);
        $(this).parent().parent().remove();
        $(".max_msg").hide();
        // var lengthRows = $('.cuotaFila', $("#regCuota")).length;
        // if(lengthRows > 0){
            // for (var r = 1; r < lengthRows + 1; r++) {
            // $(".cuotaFila").each(function() {
                // $("#monto"+fila).prop('id', 'monto'+r);
                // $("#fecha_cuota"+fila).prop('id', 'fecha_cuota'+r);
            // });
            // }
        // }
    });


});
function ValidateCuota() {
    var lengthRows = $('.cuotaFila', $("#regCuota")).length;
    var check_cuotas = $('#check_cuotas').val();
    var mensaje = "Debe ingresar al menos una fecha y monto de la cuota";
    if(lengthRows == 0 && check_cuotas == 1){
        mostrarMensajeInfo(mensaje);
        return false;
    }
}
$('#check_cuotas').on('click',function(){     
    var check = $('#check_cuotas').is(":checked") ? 1:0;
    // console.log(check);
    $('#check_cuotas').val(check);  
    if(check == 1){
        $("#monto_inicial").prop('readonly', true);
        $("#monto_total").prop('readonly', true);
        $('.div_agregar_cuotas').css('display','block');
        $(".agregar_cuota").show();
    }else{
        $("#monto_inicial").prop("readonly",false);
        $("#monto_total").prop("readonly",false);
        $('.div_agregar_cuotas').css('display','none');
        $('#monto_aux').val('0.00');
        $('#fecha_cuota').val('');
        var lengthRows = $('.cuotaFila', $("#regCuota")).length;
        if(lengthRows > 0){
            for (var i = 0; i <= lengthRows; i++) {
            $(".cuotaFila").each(function() {
                $(".cuotaFila").remove();
            });
            }
        }
        var monto_total = $('#monto_total').val();
        var monto_inicial = $('#monto_inicial').val();
        var monto_restante = $('#precio_cuotas').val();
        if(monto_restante != '' && parseFloat(monto_total) > '0.00' && parseFloat(monto_inicial) > '0.00'){
            var resultado = parseFloat(monto_total) - parseFloat(monto_inicial);
            value = parseFloat(resultado).toFixed(2);
            $('#precio_cuotas').val(value);
        }

    }        
});
//Fin de agregar cuotas
// // // // // // // // // // // // // // // // // // //

