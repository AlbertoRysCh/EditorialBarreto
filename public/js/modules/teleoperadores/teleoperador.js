$('#cliente_id').on('change',function(){
  var cliente_id = $(this).val();
  if($.trim(cliente_id) != ''){
      $.ajax({
          type: "GET",
          url: 'get-cliente/'+cliente_id,
          dataType: "json",
          beforeSend: function () {
              $('.show_wait_load').css('display', 'block');
          },
          complete: function () {
              $('.show_wait_load').css('display', 'none');
          },
          success: function (data) {
              $("#tipo_documento").val(data.data.tipo_documento);
              $("#num_documento").val(data.data.num_documento);
              $(".num_documento_hidden").val(data.data.num_documento);
              $("#nombres").val(data.data.nombres_rz);
              $("#estado").val(data.data.estado);
              $("#estado_cliente").html(data.data.estado_cliente);
              $("#correo").val(data.data.correo);
              $("#telefono").val(data.data.telefono);
              $("#direccion").val(data.data.direccion);
              $("#direccion_empresa").val(data.data.direccion);
              $("#getEmpresa").html(data.data.empresa);
              if(data.data.estado_cliente == 'Cliente'){
                $("#estado_cliente").addClass('text-success');
                $("#estado_cliente").removeClass('text-warning');
              }else{
                $("#estado_cliente").addClass('text-warning');
                $("#estado_cliente").removeClass('text-success');
              }
              $("#is_empleado").html(data.data.is_empleado);
          },
          error: function () {
              $('.show_wait_load').css('display', 'none');
              mostrarMensajeInfo("Ocurrió un error durante la consulta del cliente presione F5 para refrescar la página.");
          }
      });
  }
});
  // Loading remote data
  $(".select2-data-ajax").select2({
      dropdownAutoWidth: true,
      width: '100%',
      ajax: {
      url: $('#get-products-ajax').val(),
      dataType: 'json',
      delay: 250,
      language: "es-ES",
      data: function (params) {
      var tiendaId = $('#punto_recojo').val();
        return {
          q: params.term, // search term
          tienda_id : `${tiendaId}`,
          page: params.page
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;

        return {
          results: data.items,
          pagination: {
            more: (params.page * 30) < data.total_count
          }
        };
      },
      cache: true
    },
    placeholder: 'Seleccione producto',
    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 2,
      language: {
      inputTooShort: function () {
          return 'Introduzca mínimo 2 letras';
      },
        "noResults": function(){
          return "No se encontraron resultados.";
        },
      searching: function() {
          return "Buscando...";
      }
      },
    templateResult: formatRepo,
    templateSelection: formatRepoSelection
});


function formatRepo (repo) {
  if (repo.loading) return repo.text;

  var markup = "<div class='select2-result-repository__title' id='code-producto-" + repo.id + "'>" + repo.codigo + "<b> - </b>" + repo.text + " <b> - </b> " + 'S/.' + " " + repo.precio + "</div>";

  if (repo.description) {
    markup += "<div class='select2-result-repository__description'></div>";
  }

  markup += "</div></div>";

  return markup;
}

function formatRepoSelection (repo) {
  return repo.full_name || repo.text;
}

$('body').on('change', '.select2-data-ajax', () => {
  getProducto($('.select2-data-ajax').val(),$("#get-producto").val())
});

let table = $("#lista_producto").DataTable({
  language,
  searching: false,
  ordering: false,
  paging: false,
  rowCallback: (row, data, index) => {
    row.cells[1].style.display = "none";
    row.cells[5].style.display = "none";
  }
});
$('.dataTables_info').css('display','none');

$.fn.dataTable.ext.errMode = () => console.log('Error en la carga de la tabla. Por favor refrescar página.');


function getProducto(id,route) {
    // console.log(id,route);
  $.ajax({
    url: route,
    type: 'get',
    data: {'id': id,'_token': $('input[name=csrf-token]').val()},
    success: function (data) {

      let array = [];
      if(data!=''){
      for (let i = 0; i < data.length; i++) {
        array = [];
        array['producto_id']      = data[i].id;
        array['descripcion']      = data[i].producto;
        array['codigo']           = data[i].codigo;
        array['unidad']           = data[i].code;
        array['precio_unitario']  = data[i].precio;
        array['stock']            = data[i].stock;
        array['nombre_tienda']    = data[i].nombre_tienda;
        $('#cod_producto_validar').val(data[i].codigo);
        agregarProducto(array);
        $('select[name="select_product"]').empty();
      }
      }

    },
    error: function () {
      console.log("error");
    },
  });
}

function agregarProducto(array)
{
  var _producto_id        = array['producto_id'];
  var _codigo             = array['codigo'];
  var _descripcion        = array['descripcion'];
  var _precio_unitario    = array['precio_unitario'];
  var _stock              = array['stock'];
  var _unidad             = array['unidad'];
  var _tienda_nombre     = array['nombre_tienda'];

  let objColums        = {
    _producto_id,
    _codigo,
    _descripcion,
    _unidad,
    _precio_unitario,
    _stock,
    _tienda_nombre,
  };
  objColums.readOnlyCodigo =true;
  objColums.readOnlyDescripcion =true;
  objColums.readOnlyUnidad =true;
  objColums.readOnlyPrecioUnitario =true;
  objColums.readOnlyStock =true;
  objColums.readOnlyTiendaId =true;

  const numRow = table.rows().count() + 1;
  $('#cant_lineas').val(numRow);
  table.row.add(itemRow(objColums, numRow)).draw(false);
  calcImporte(numRow);

}

const itemRow = (obj, numRow) => {
  return [
    numRow,
    `<input type="hidden" name="producto_id_${numRow}" value="${obj._producto_id}">`,
    `<input class="form-control" name="codigo_${numRow}" style="width: 100px;" type="text" value="${obj._codigo}" ${obj.readOnlyCodigo == true ? 'readonly' : ''}>`,
    `<textarea class="form-control resize" name="descripcion_${numRow}" maxlength="1000" rows="1" style="width:100%;" ${obj.readOnlyDescripcion == true ? 'readonly' : ''}>${obj._descripcion} </textarea>`,
    `<textarea class="form-control resize" name="tienda_${numRow}" rows="1" style="width:100%;" ${obj.readOnlyTiendaId == true ? 'readonly' : ''}>${obj._tienda_nombre} </textarea>`,
    `<input type="text" name="unidad_${numRow}" class="form-control" value="${obj._unidad}" style="width: 100px;" ${obj.readOnlyUnidad == true ? 'readonly' : ''}>`,
    `<input type="text" name="stock_${numRow}" class="form-control text-right" value="${obj._stock}" readonly/>`,
    `<input type="text" name="cantidad_${numRow}" class="form-control text-right" onkeypress="calcImporte(${numRow});return isNumberKey(this, event)" value="${obj._unidad == 'kilogramos' ? '1000' : '1'}" maxlength="12"/>`,
    `<input type="text" name="precio_unitario_${numRow}" class="form-control text-right" onkeypress="calcImporte(${numRow});return isNumberKey(this, event)" value="${obj._precio_unitario}" maxlength="12"/>`,
    `<div class="text-right">S/.<span id="importe_${numRow}" name="importe_${numRow}" class="importeTotal">0.00</span></div>`,
    `<button type="button" onclick=deleteRow(this) class="btn btn-danger btn-sm">Eliminar</button>`,
  ];
};

function isNumberKey(txt, evt) {
  let charCode = evt.which ? evt.which : evt.keyCode;
  if (charCode == 46) {
    //Check if the text already contains the . character
    if (txt.value.indexOf(".") === -1) {
      return true;
    } else {
      return false;
    }
  } else {
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
  }
  return true;
}

function deleteRow(t) {
  const numRow = table.rows().count();
  $('#cant_lineas').val(numRow - 1);
  calcImporte(numRow);
  table
    .row(t.parentNode.parentNode)
    .remove()
    .draw();
  if (table.rows().count() !== 0) {
    $("#lista_producto tbody tr").map((k, e) => {
      let n = k + 1;
      e.children[0].innerText = n;


      e.children[1].children[0].name = `producto_id_${n}`;
      e.children[2].children[0].name = `codigo_${n}`;
      e.children[3].children[0].name = `descripcion_${n}`;
      e.children[4].children[0].name = `tienda_${n}`;
      e.children[5].children[0].name = `unidad_${n}`;
      e.children[6].children[0].name = `stock_${n}`;

      e.children[7].children[0].setAttribute("onkeypress", `calcImporte(${n})`);
      e.children[7].children[0].name = `cantidad_${n}`;

      e.children[8].children[0].setAttribute("onkeypress", `calcImporte(${n})`);
      e.children[8].children[0].name = `precio_unitario_${n}`;
      e.children[9].children[0].children[0].id = `importe_${n}`;
    });
  }
}
function calcImporte(id, valorDescuento = 0) {
  setTimeout(() => {
    let cantidad = parseFloat($(`[name=cantidad_${id}]`).val());
    let stock = parseFloat($(`[name=stock_${id}]`).val());
    let unidad = $(`[name=unidad_${id}]`).val();
    let precio = parseFloat($(`[name=precio_unitario_${id}]`).val());

    if (unidad == 'Unidad' && (cantidad > stock)) {
      calcImporte(id,valorDescuento);
      mostrarMensajeInfo('La cantidad ingresada supera al stock del producto');
      $(`[name=cantidad_${id}]`).val(1);
      return false;

    }

    // Convertir el stock del producto en kilogramos
    var resultado = stock * (1000);

    if (unidad == 'Kilogramos' && (cantidad > resultado)) {
      calcImporte(id,valorDescuento);
      mostrarMensajeInfo('La cantidad ingresada supera al stock del producto');
      $(`[name=cantidad_${id}]`).val(1000);
      return false;
    }

    let importe = '0.00';
    if (unidad == 'Kilogramos'){
      importe = (cantidad / 1000) * precio;
    }else{
      importe = cantidad * precio;
    }

    $(`#importe_${id}`).html(importe.toFixed(2));

    let importeTotal = 0;
    $(".importeTotal").map((_k, e) => (importeTotal += parseFloat(e.innerText)));
    importeTotal = parseFloat(importeTotal.toFixed(2));


    let subTotal = importeTotal / 1.18;
    let igv = importeTotal - subTotal;

    $("#sub_total").text(subTotal.toFixed(2));
    $("#igv").text(igv.toFixed(2));
    $("#totalText").text(importeTotal.toFixed(2));
    $("#total").val(importeTotal.toFixed(2));

  }, 10);
}

//  METODO DE PAGO
$("#payment_id").change(function(){
  var value = $('option:selected',this).attr('value');
  if(value == 2){
      $('.mostrar_efectivo').css('display','block');
      $('.mostrar_transferencia').css('display','none');
      $('#efectivo').val('0.00');
      $('#vuelto').val('0.00');
      $("#registrar-servicio").css('display','block');
      $('#baucher-transferencia').fileinput('clear');
  }else if(value == 1){
    $('.mostrar_transferencia').css('display','block');
    $('.mostrar_efectivo').css('display','none');
    $("#registrar-servicio").css('display','none');
  }else{
      $('.mostrar_efectivo').css('display','none');
      $('.mostrar_transferencia').css('display','none');
      $("#registrar-servicio").css('display','block');
      $('#efectivo').val('');
      $('#vuelto').val('');
      $('#baucher-transferencia').fileinput('clear');
      
  }
});
$('#efectivo').keyup(function(){
  var efectivo = $('#efectivo').val();
  var monto_total;
  monto_total = $('#total_servicio').val();

  if(efectivo != ''){
      if(efectivo <= 0.00 ){
          $('#efectivo').val('0.00');
          mostrarMensajeInfo('El monto del efectivo debe ser mayor a 0.00');
      }else{
          if(parseFloat(efectivo) < parseFloat(monto_total)) {
          $('#efectivo').val('0.00');
          $('#vuelto').val('0.00');
          mostrarMensajeInfo('El monto del efectivo no debe ser MENOR al monto total del servicio');
          }else{
          var total = parseFloat($("#efectivo").val());
          $("#efectivo").val(total.toFixed(2));
          var resultado = 0;
          var resultado =  parseFloat(efectivo) - parseFloat(monto_total);
          $('#vuelto').val(resultado.toFixed(2));
          }

      }
  }
});
// Carga de pago
var btnBrowse = '<button type="button" class="btn btn-primary">' +
'<i class="fa fa-folder-open"></i>' +' Buscar archivo'+
'</button>';



$("#baucher-transferencia").fileinput({
rtl: true,
language: "es",
maxFileCount: 1,
required: true,
dropZoneEnabled: true,
removeIcon: '<i class="fa fa-trash"></i>',
removeClass: 'btn btn-danger btn-remove',
removeLabel: ' Quitar pago',
showCaption: false,
showCancel: false,
showClose: false,
showBrowse: false,
showUpload: false,
allowedFileTypes: ['image'],
allowedFileExtensions: ["jpg", "png"],
maxImageWidth: 700,
maxFileSize: 1000,
browseOnZoneClick :true,
fileActionSettings: {showZoom: false},
defaultPreviewContent: '<img src="/../images/upload_dropzone.png">  <br><br>  Arrastre y suelte el archivo aquí<br><br>  o <br><br> '+ btnBrowse,

});

$('#baucher-transferencia').on('fileselect', function(event, numFiles, label) {

  if(numFiles == 0){
    $("#registrar-servicio").css('display','none');
  }else{
    $("#registrar-servicio").css('display','block');
  }

});

// CAMBIO DE SERVICIO
$("#tipo_servicio").val(0);
$('.seccion_interna').css('display','none');
$('.seccion_externa').css('display','block');
$('.punto_recojo').css('display','none');
$('#punto_recojo').val('');
$('.mostrar_total_venta').css('display','none');

// SI TIENE ALGUN PRODUCTO FRAGIL
$("#is_fragil").change(function(){
  if (this.checked) {
    $("#is_fragil").val("Sí");
  }else{
    $("#is_fragil").val("No");
  }
});

$("#tipo_servicio").change(function(){
  if (this.checked) {
    $("#tipo_servicio").attr("checked",true);
    $("#tipo_servicio").val(1);
    $('.seccion_interna').css('display','block');
    $('.seccion_externa').css('display','none');
    var lengthRows = $('.productoFila', $("#lista_producto")).length;
    if(lengthRows > 0){
        for (var i = 0; i <= lengthRows; i++) {
        $(".productoFila").each(function() {
            $(".productoFila").remove();
        });
        }
    }
    $("#cant_lineas").val(0);
    $('#efectivo').val('0.00');
    $('#vuelto').val('0.00');
    $('.punto_recojo').css('display','block');
    $('#punto_recojo').val('');
    $('.mostrar_total_venta').css('display','block');
  }else{
    $("#tipo_servicio").removeAttr("checked");
    $("#tipo_servicio").val(0);
    $('.seccion_interna').css('display','none');
    $('.seccion_externa').css('display','block');
    $('#efectivo').val('0.00');
    $('#vuelto').val('0.00');
    $('#total').val('0.00');
    $('.punto_recojo').css('display','none');
    $('#punto_recojo').val('');
    $('.mostrar_total_venta').css('display','none');

  }
});

$('#num_km').keyup(function(){
var num_km = parseFloat($("#num_km").val());
var monto_servicio = $('#total').val();
var precio_base = $('#precio_base').val();
var descuento =  $('#descuento_servicio').val();
$('#efectivo').val('0.00');
$('#vuelto').val('0.00');
  if(num_km <= 0.00 || isNaN(num_km)){
    $('#num_km').val(0);
    var recalcular = parseFloat(precio_base) + parseFloat(monto_servicio);
    $('#total_servicio').val(recalcular.toFixed(2) - parseFloat(descuento));
    $('#total_servicio_hide').val(recalcular.toFixed(2));
    // mostrarMensajeInfo('El kilómetro debe ser mayor a 0 km');
    return false;
  }else{

    var resultado =  parseFloat(precio_base) + parseFloat(monto_servicio) + calculateKm(num_km);
    var desT = resultado - parseFloat(descuento);
    $('#total_servicio').val(desT.toFixed(2));
    $('#total_servicio_hide').val(resultado.toFixed(2));

    var calcularDelivery = parseFloat(precio_base) + calculateKm(num_km);
    var desD = calcularDelivery - parseFloat(descuento);
    $('#total_delivery').val(desD.toFixed(2));
    $('#total_delivery_hide').val(calcularDelivery.toFixed(2));
  }
});
$('#descuento_servicio').keyup(function(){

var totalServicio =  $('#total_servicio_hide').val();
var descuento =  $('#descuento_servicio').val();
var TotalDelivery =  $('#total_delivery_hide').val();
var TotalDeliveryResultado =  $('#total_delivery').val();
var monto_servicio = $('#total').val();
var precio_base = $('#precio_base').val();

var recalcularDelivery = parseFloat(precio_base) + calculateKm(num_km);
var recalcular = parseFloat(precio_base) + parseFloat(monto_servicio);

if(descuento > TotalDelivery){
  $('#descuento_servicio').val('0.00');
  $('#total_servicio').val(recalcular.toFixed(2));
  $('#total_delivery').val(recalcularDelivery.toFixed(2));
  mostrarMensajeInfo('El descuento no puede ser mayor al total del delivery');
  return false;
}

if(TotalDeliveryResultado <= 0.00){
  $('#descuento_servicio').val('0.00');
  $('#total_servicio').val(recalcular.toFixed(2));
  $('#total_delivery').val(recalcularDelivery.toFixed(2));
  mostrarMensajeInfo('El descuento no puede ser mayor al total del delivery');
  return false;

}else{
  if(descuento <= 0.00 || isNaN(descuento)){
    $('#total_servicio').val(recalcular.toFixed(2));
    $('#total_delivery').val(recalcularDelivery.toFixed(2));

    return false;
  }else{
    var totalDFormat = parseFloat($("#descuento_servicio").val());
    $("#descuento_servicio").val(totalDFormat.toFixed(2));

    var descuentoTotal =  parseFloat(totalServicio) - parseFloat(descuento);
    var descuentoDelivery =  parseFloat(TotalDelivery) - parseFloat(descuento);

    $('#total_servicio').val(descuentoTotal.toFixed(2));
    $('#total_delivery').val(descuentoDelivery.toFixed(2));
    
  }
}


});
