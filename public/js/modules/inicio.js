
var valueDefault = 'D';
function showFilter(value){
    // console.log(value);
    switch (value) {
        case 'D':
            $('.fecha_search').css('display','block');
            $('#fecha_dia').css('display','block');
            $('.div_fill2').css('display','block');
            $('.div_fill').css('display','none');
            $('#fecha_mes_anio').css('display','none');
            $('#fecha_mes_anio').val("");
            $('#fecha_ini').css('display','none');
            $('#fecha_fin').css('display','none');
            $(".btn_fecha_range").css('display','none');
            $('#fecha_ini').val("");
            $('#fecha_fin').val("");

            $('#fecha_dia').datepicker({
                todayHighlight:true,
                format: 'yyyy-mm-dd',
                autoclose : true
            });

            break;
        case 'M':
            $('.fecha_search').css('display','block');
            $('#fecha_mes_anio').css('display','block');
            $('.div_fill2').css('display','block');
            $('.div_fill').css('display','none');
            $('#fecha_dia').css('display','none');
            $('#fecha_ini').css('display','none');
            $('#fecha_fin').css('display','none');
            $(".btn_fecha_range").css('display','none');
            $('#fecha_dia').val("");
            $('#fecha_ini').val("");
            $('#fecha_fin').val("");


            $('#fecha_mes_anio').datepicker({
                format: "mm/yyyy",
                startView: "year", 
                minViewMode: "months",
                autoclose : true
            });
            break;
        case 'R':
            $('.fecha_search').css('display','block');
            $("#fecha_ini").css('display','block');
            $("#fecha_fin").css('display','block');
            $(".btn_fecha_range").css('display','block');
            $('.div_fill').css('display','none');
            $('.div_fill2').css('display','none');
            $('#fecha_dia').css('display','none');
            $('#fecha_mes_anio').css('display','none');
            $('#fecha_dia').val("");
            $('#fecha_mes_anio').val("");

            $('#fecha_ini,#fecha_fin').datepicker({
                todayHighlight:true,
                format: 'yyyy-mm-dd',
                autoclose : true
            });
            break;
    }
    return value;
}
// showFilter(valueDefault);
$('.letterDate').html('Día '+currentDate());

$("body").delegate("#fecha_dia,#fecha_mes_anio", "change", function () {
    var fechaDia = $("#fecha_dia").val();
    var fechaMesAnio = $("#fecha_mes_anio").val();
    var urlSend = $("#formFilter").attr("action");
    var datosPost = {
        'fecha_dia': fechaDia,
        'fecha_mes_anio': fechaMesAnio,
        '_token': $('input[name=_token]').val(),
      }
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
        }
    });
    $.ajax({
        type : 'POST',
        url : urlSend,
        dataType : 'json', // expected returned data format.
        data : datosPost,

        success : function(data)
        {
            var servicios = data.html;
            var array = Object.values(servicios)

    
            $.each(array, function(i){
                $('#completados').html(array[i].completados);
                $('#en-progeso').html(array[i].enProgreso);
                $('#pendientes').html(array[i].pendientes);
                $('#por-verificar').html(array[i].pagosPorVerificar);
            })

            if(fechaDia.length == 10){
                $('.letterDate').html('Día '+fechaDia.format("DD-MM-YYYY"));
            }else if(fechaMesAnio.length == 7){
                var strMesAnio = fechaMesAnio.split("/");
                $('.letterDate').html('Mes - '+convertirMes(strMesAnio[0]) +' '+strMesAnio[1]);
            }
        },
        beforeSend: function () {
            $('.preload_wait').css("display", "block");
        },
        complete: function () {
            $('.preload_wait').css('display', 'none');
        },
        error: function () {
            $('.preload_wait').css('display', 'none');
        }
    });
});

$("#btn_fecha_range").click(function () {
    var fechaInicio = $("#fecha_ini").val();
    var fechaFin = $("#fecha_fin").val();
    var urlSend = $("#formFilter").attr("action");

    if (fechaFin < fechaInicio){
        mostrarMensajeInfo("La fecha fin no puede ser menor a la fecha de inicio.");
        return false;
    }
    var datosPost = {
        'fecha_ini': fechaInicio,
        'fecha_fin': fechaFin,
        '_token': $('input[name=_token]').val(),
      }
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
        }
    });
    $.ajax({
        type : 'POST',
        url : urlSend,
        dataType : 'json', // expected returned data format.
        data : datosPost,
        beforeSend: function () {
            $('.preload_wait').css("display", "block");
        },
        success : function(data)
        {
            $('.preload_wait').css('display', 'none');
            var servicios = data.html;
            var array = Object.values(servicios)

    
            $.each(array, function(i){
                $('#completados').html(array[i].completados);
                $('#en-progeso').html(array[i].enProgreso);
                $('#pendientes').html(array[i].pendientes);
                $('#por-verificar').html(array[i].pagosPorVerificar);
            })

            $('.letterDate').html('Del '+fechaInicio.format("DD-MM-YYYY")+' - Al '+fechaFin.format("DD-MM-YYYY"));
        },
        error: function () {
            $('.preload_wait').css('display', 'none');

    
        }
    });
});