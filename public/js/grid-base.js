    /* Create Item */
    $('.create').click(function (e) {
    e.preventDefault();
    $.ajaxPrefilter(function( options ) {
    options.async = true;
    });
    var url = $(this).attr('href');
    $.ajax({
    type: "GET",
    url: url,
    beforeSend: function () {
        $('.preload_wait').css("display", "block");
        $(".create").addClass('disabled');
        $(".create").prop('disabled', true);
    },
    complete: function () {
        $(".create").prop('disabled', false);
        $(".create").removeClass('disabled');
    },
    success: function (data) {
        $('.preload_wait').css('display', 'none');
        $("#modal-view .modal-body").html(data);
        var title = $("#modal-view .modal-body .title").text();
        $("#modal-view .modal-title").html(title);
        $("#modal-view .modal-body").scrollTop(0);
        $("#modal-view").modal({'show': true, backdrop: 'static', keyboard: false});
    },
    error: function (jqXHR, textStatus, errorThrown) {

        $('.preload_wait').css('display', 'none');
        if ((jqXHR.responseText).length > 200) {
            $("#modal-exception").modal("show");
        } else {
            $("#modal-message .modal-body").html(jqXHR.responseText);
            $("#modal-message").modal("show");
        }

    }
    });
    });
    /* Show Item */
    $(document).on("click",".display",function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
    url: url,
    type: "GET",
    success: function (data) {
        $('.preload_wait').css('display', 'none');
        $("#modal-show .modal-body").html(data);
        $("#modal-show").modal({'show': true, backdrop: 'static', keyboard: false});
        $("#modal-show .modal-footer").show();
        var title = $("#modal-show .modal-body .title").text();
        $("#modal-show .modal-title").html(title);
    },
    beforeSend: function () {
        $('.preload_wait').css("display", "block");
        $(".display").addClass('disabled');
        $(".display").prop('disabled', true);

    },
    complete: function () {
        $(".display").prop('disabled', false);
        $(".display").removeClass('disabled');
    },
    error: function () {
        $('.preload_wait').css('display', 'none');
    }
    });

    return false;
    });
    /* Edit Item */
    $(document).on("click",".edit",function(e) {
    e.preventDefault();
    $.ajaxPrefilter(function( options) {
    options.async = true;
    });
    $.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
    }
    });

    var url = $(this).attr('href');
    $.ajax({
    type: "GET",
    url: url,
    beforeSend: function () {
        $('.preload_wait').css("display", "block");
        $(".edit").addClass('disabled');
        $(".edit").prop('disabled', true);
        $("#btn-send-success").prop('disabled', false);
        $("#btn-send-success").removeClass('disabled');
    },
    complete: function () {
        $(".edit").prop('disabled', false);
        $(".edit").removeClass('disabled');

    },
    success: function (data) {
        $('.preload_wait').css('display', 'none');
        $("#modal-view .modal-body").html(data);
        var title = $("#modal-view .modal-body .title").text();
        $("#modal-view .modal-title").html(title);
        $("#modal-view .modal-body").scrollTop(0);
        $("#modal-view").modal({'show': true, backdrop: 'static', keyboard: false});
    },
    error: function (jqXHR, textStatus, errorThrown) {
        $('.preload_wait').css('display', 'none');
        if ((jqXHR.responseText).length > 200) {
            $("#modal-exception").modal("show");
        } else {
            $("#modal-message .modal-body").html(jqXHR.responseText);
            $("#modal-message").modal("show");
        }

    }
    });
    });

    /* Save Item */
    $("#btn-send-success").click(function () {
        var dataFrom = $("#modal-view form").serialize();
        var urlSend = $("#modal-view form").attr("action");

        var id_form = $("#modal-view form").attr("id");
        if( !$("#"+id_form).valid()){
            return true;
        }


        $.ajax({
            url: urlSend,
            type: "POST",
            data: dataFrom,
            cache: false,
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
                if (data.status == true) {
                    mostrarMensajeSuccess(data.message);
                    $("#modal-view").modal("hide");
                    if(id_form == 'form_reg_llamadas'){
                        table.ajax.reload();
                    }else{
                        $('#modal-view').delay(1600).fadeOut('slow').promise().done(function(){
                            location.reload();
                        });
                    }

                    } else {
                        mostrarMensajeInfo(data.message);
                        $("#modal-view").modal("hide");
                        $('#modal-view').delay(1600).fadeOut('slow').promise().done(function(){
                        location.reload();
                        });
                    }
            },
            error: function () {
                        mostrarMensajeInfo("Ocurrio un error mientras se realizaba el proceso intente más tarde.");
                        $("#modal-view").modal("hide");
                        // $('#modal-view').delay(1600).fadeOut('slow').promise().done(function(){
                        // location.reload();
                        // });
            }
        });
        return false;
    });
    /* Desactivar/Activar Item */
    $(document).on("click",".activar_desactivar",function(e) {
    e.preventDefault();

    Swal.fire({
    title: 'Logi House',
    text: "Estás seguro de realizar esta operación?",
    type: 'warning',
    reverseButtons : true,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar!'
    }).then((result) => {
    if (result.value) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
        }
    });
    urlActDesac = $(this).attr('href');
    $.ajax({
            type: "GET",
            url: urlActDesac,
            cache: false,
            dataType: "json",
            success: function (data) {
            if (data.status == true) {
                mostrarMensajeSuccess(data.message);
                table.ajax.reload();
            }else{
                mostrarMensajeInfo(data.message);
            }
            },
            error: function (error) {
            }
        });
        return false;
    }
    })
    });
    /* Delete Item */
    $(document).on("click",".delete",function(e) {

    e.preventDefault();

    Swal.fire({
    title: 'Estás seguro de eliminar este registro?',
    text: "No podrás revertir esto!",
    icon: 'warning',
    reverseButtons : true,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
    if (result.value) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
        }
    });

    urlDelete = $(this).attr('href');

    $.ajax({
            type: "GET",
            url: urlDelete,
            cache: false,
            dataType: "json",
            beforeSend: function () {
                $('.preload_wait').css("display", "block");
            },
            success: function (data) {
                        if (data.status == true) {
                            mostrarMensajeSuccess(data.message);
                            $('.preload_wait').css("display", "none");
                            $('.preload_wait').delay(1600).fadeOut('slow').promise().done(function(){
                                location.reload();
                                });
                        }else{
                            mostrarMensajeInfo(data.message);
                        }
                      },
                      error: function (error) {
                      }
        });
        return false;
    }
    })
    });
