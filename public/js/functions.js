    // var dom = "<'row topCustomCar'<'col-sm-3'li><'col-sm-3'f><'col-sm-6'p>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>";
    var language = {"decimal": "","emptyTable": "No hay información","info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    };
   // MENSAJES MODALES
   function mostrarMensajeSuccess(mensaje) {
        Swal.fire({
        title: '',
        type: "success",
        html: mensaje,
        allowOutsideClick: "false",
        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Ok'
    })


    }

    function mostrarMensajeError(mensaje) {
        Swal.fire({
        title: '',
        type: 'error',
        html: mensaje,
        allowOutsideClick: "false",
        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Ok'
        })
    }
    function mostrarMensajeInfo(mensaje) {
        Swal.fire({
        title: '',
        type: "info",
        html: mensaje,
        allowOutsideClick: "false",
        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Ok'
        })
    }
       // MENSAJES MODALES
   function mostrarMensajeSuccessRedirect(mensaje,ruta) {
    Swal.fire({
    title: '',
    type: "success",
    html: mensaje,
    allowOutsideClick: "false",
    confirmButtonText:'<i class="fa fa-thumbs-up"></i> Ok'
    }).then(function() {
        window.location = ruta;
    });


    }
    function SuccessRedirect(mensaje) {
      Swal.fire({
      title: '',
      type: "success",
      html: mensaje,
      allowOutsideClick: "false",
      confirmButtonText:'<i class="fa fa-thumbs-up"></i> Ok'
      }).then(function() {
        location.href = location.href;
      });


    }

    function mostrarModal(){
      $("#modal_loading").modal({'show': true, backdrop: 'static', keyboard: false});

    }
    function ocultarModal(){
      $('#modal_loading').modal('hide');
    }

    function mostrarModalWait(){
      $("#modal_loading_wait").modal({'show': true, backdrop: 'static', keyboard: false});
    }

    function ocultarModalWait(){
      $('#modal_loading_wait').modal('hide');
    }
    function validarDecimales(e, field) {

        key = e.keyCode ? e.keyCode : e.which
        // backspace getValor.slice(4,12)
        if (key == 8) return true
        // 0-9
        if (key > 47 && key < 58) {
          if (field.value == "") return true
          var existePto = (/[.]/).test(field.value);
          if (existePto === false) {
            regexp = /.[0-9]{8}$/;
          }
          else {
            regexp = /.[0-9]{7}$/;
          }
          return !(regexp.test(field.value))
        }
        // .
        if (key == 46) {
          if (field.value == "") return false
          regexp = /^[0-9]+$/
          return regexp.test(field.value)
        }
        // other key
        return false
      }
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

    $(".reloadPage").click(function(){
        location.reload();
    });
    function ValidateImage(oInput) {
        var _validFileExtensions = [".jpg", ".jpeg",".png"];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
             if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Archivo inválido',
                        text: 'Archivos permitidos deben ser tipo: '+ _validFileExtensions.join(", ")
                      })
                      $("input:file").val(null);
                    return false;
                }
            }
        }
        return true;
    }
    function ValidateDoc(oInput) {
        var validFileDoc = [".docx",".pdf",'.doc'];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
             if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < validFileDoc.length; j++) {
                    var sCurExtension = validFileDoc[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo inválido',
                        text: 'Archivos permitidos deben ser tipo: '+ validFileDoc.join(", ")
                      })
                      $("input:file").val(null);
                    return false;
                }
                var tam =(oInput.files[0].size/1024/1024).toFixed(2);
                var tam_max = 6;
                if(tam > tam_max){
                    Swal.fire({
                        icon: 'error',
                        title: 'Tamaño máx.',
                        text: 'El tamaño supera el limite permitido.Máx: '+ tam_max
                        })
                        $("input:file").val(null);
                        return false;
                }
            }
        }
        return true;
    }
    function ValidateDocPdf(oInput) {
        var validFileDoc = [".pdf"];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
             if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < validFileDoc.length; j++) {
                    var sCurExtension = validFileDoc[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Archivo inválido',
                        text: 'Archivos permitido debe ser tipo: '+ validFileDoc.join(", ")
                      })
                      $("input:file").val(null);
                    return false;
                }
            }
        }
        return true;
    }

    function ValidateFile(oForm) {
        var arrInputs = oForm.getElementsByTagName("input");
        for (var i = 0; i < arrInputs.length; i++) {
            var oInput = arrInputs[i];
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length == 0) {
                    Swal.fire({
                        type: 'info',
                        title: 'No se ha cargado ningún archivo',
                        text: 'Debe cargar un archivo para subir',
                        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Ok'
                      })

                    return false;
                }
            }
        }

        return true;
    }

    function currentDate(){
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var currentDate = d.getFullYear() + '-' +
            ((''+month).length<2 ? '0' : '') + month + '-' +
            ((''+day).length<2 ? '0' : '') + day;
        return currentDate;
    }

    function secondsToString(seconds) {
        var hour = Math.floor(seconds / 3600);
        hour = (hour < 10)? '0' + hour : hour;
        var minute = Math.floor((seconds / 60) % 60);
        minute = (minute < 10)? '0' + minute : minute;
        var second = seconds % 60;
        second = (second < 10)? '0' + second : second;
        return hour + ':' + minute + ':' + second;
    }
    var mesesArray = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    function convertirMes(mes) {
      if(! isNaN(mes) && mes >= 01  && mes <= 12 ) {
        return mes.value = mesesArray[mes - 1];
      }
    }


    // $('.datepicker').datepicker({
    //     format: 'yyyy-mm-dd',
    //     autoclose : true
    // });
    // $('.datepicker').on("show", function(e){
    //     e.preventDefault();
    //     e.stopPropagation();
    //     }).on("hide", function(e){
    //             e.preventDefault();
    //             e.stopPropagation();
    // });
// Convertir cualquier texto en mayuscula
function convertirMayuscula(e) {
    e.value = e.value.toUpperCase();
}
// Solo permitir numeros
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
// Cuando es una petición Ajax y su sesión expira
$( document ).ajaxError(
    function(e, x, settings, exception ) {
     var status = x.status;
     switch(status){
      case 401:
      case 419:
        let timerInterval
        Swal.fire({
          title: 'Su sesión ha expirado.',
          html:
          'Redireccionando en <b></b> segundos.',
          timer: 5000,
          timerProgressBar: true,
          onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
              const content = Swal.getContent()
              if (content) {
                const b = content.querySelector('b')
                if (b) {
                  b.textContent =  (Swal.getTimerLeft() / 1000).toFixed(0)
                }
              }
            }, 50)
          },
          onClose: () => {
            var url = "/";
            $(location).attr('href',url);
            clearInterval(timerInterval)
          }
        }).then((result) => {
          /* Read more about handling dismissals below */
        //   if (result.dismiss === Swal.DismissReason.timer) {
        //     console.log('I was closed by the timer')
        //   }
        })
        break;
     }
  });
    /* DATERANGE PICKER */
    $('#filtro-fechas').daterangepicker({
        format: 'YYYY-MM-DD',
        "locale": {
          customRangeLabel: 'Rango personalizado',
          "format": "DD-MM-YYYY",
          "separator": " - ",
          "fromLabel": "Desde",
          "toLabel": "Hasta",
          "customRangeLabel": "Personalizar",
          "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
          ],
          "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Setiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
          ],
          "firstDay": 1
        },
        ranges: {
          Hoy: [moment(), moment()],
          Ayer: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'últimos 7 días': [moment().subtract(6, 'days'), moment()],
          'últimos 30 días': [moment().subtract(29, 'days'), moment()],
        //   'últimos 3 meses': [moment().subtract(29, 'days'), moment()],
          'Este mes': [moment().startOf('month'), moment().endOf('month')],
        },
        startDate: moment(),
        endDate: moment().add(1, 'days'),
        autoApply: true,
        opens: 'right'
      },
      function (start, end, label) {
        var fecha_ini = start.format('YYYY-MM-DD');
        var fecha_fin = end.format('YYYY-MM-DD');

        $('#fecha_ini_hide').val(fecha_ini);
        $('#fecha_fin_hide').val(fecha_fin);


      }
    );
/*=========================================================================================
    File Name: popover.js
    Description: Popovers are an updated version, which don’t rely on images,
                use CSS3 for animations, and data-attributes for local title storage.
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
  'use strict';
      $('[data-toggle="popover"]').popover();
  
  
      /******************/
      // Popover events //
      /******************/
  
      // onShow event
      $('#show-popover').popover({
          title: 'Popover Show Event',
          content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
          trigger: 'click',
          placement: 'right'
          }).on('show.bs.popover', function() {
              alert('Show event fired.');
      });
  
      // onShown event
      $('#shown-popover').popover({
          title: 'Popover Shown Event',
          content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
          trigger: 'click',
          placement: 'bottom'
      }).on('shown.bs.popover', function() {
          alert('Shown event fired.');
      });
  
      // onHide event
      $('#hide-popover').popover({
          title: 'Popover Hide Event',
          content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
          trigger: 'click',
          placement: 'bottom'
      }).on('hide.bs.popover', function() {
          alert('Hide event fired.');
      });
  
      // onHidden event
      $('#hidden-popover').popover({
          title: 'Popover Hidden Event',
          content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
          trigger: 'click',
          placement: 'left'
      }).on('hidden.bs.popover', function() {
          alert('Hidden event fired.');
      });
  
      /*******************/
      // Tooltip methods //
      /*******************/
  
      // Show method
      $('#show-method').on('click', function() {
          $(this).popover('show');
      });
      // Hide method
      $('#hide-method').on('mouseenter', function() {
          $(this).popover('show');
      });
      $('#hide-method').on('click', function() {
          $(this).popover('hide');
      });
      // Toggle method
      $('#toggle-method').on('click', function() {
          $(this).popover('toggle');
      });
      // Dispose method
      $('#dispose').on('click', function() {
          $('#dispose-method').popover('dispose');
      });
  
  
      /* Trigger*/
      $('.manual').on('click', function() {
          $(this).popover('show');
      });
      $('.manual').on('mouseout', function() {
          $(this).popover('hide');
      });
  
      /****************/
      // Custom color //
      /****************/
      $('[data-popup=popover-color]').popover({
          template: '<div class="popover"><div class="bg-teal"><div class="popover-arrow"></div><div class="popover-inner"></div></div></div>'
      });
  
      /**********************/
      // Custom borer color //
      /**********************/
      $('[data-popup=popover-border]').popover({
          template: '<div class="popover"><div class="border-orange"><div class="popover-arrow"></div><div class="popover-inner"></div></div></div>'
      });
  
  })(window, document, jQuery);

  var url_ = jQuery(location).attr('href');
  if(url_.includes("servicios/create")){

    $('.validar_num_documento').bind('blur',function(){
      var num_documento_hidden = $('.num_documento_hidden').val();
      var num_documento = $('.validar_num_documento').val();

      if(num_documento != '' && num_documento_hidden != num_documento){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=_token]').attr('content')
            }
        });
        $.ajax({
            url: '../posibles-clientes/search_client/'+num_documento,
            type: "get",
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                if (data.status == true ){
                  $("#num_documento").val('');
                  mostrarMensajeInfo(data.message);
                }

            },
            error: function () {
            }
        });
      }
    });
  }