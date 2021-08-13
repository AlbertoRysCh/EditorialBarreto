<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('configuraciones.update',$configuracion)}}" method="POST" id="form_configuracion_edit" autocomplete="off">
            {{method_field('patch')}}    
            {{csrf_field()}}
            <div class="form-group row">

                <label class="col-md-2 form-control-label">Código</label>
                <div class="col-md-4">
                    <input type="text" id="code" name="code" class="form-control" value="{{$configuracion->code}}" readonly>
                </div>
                @if($configuracion->code !== 'VERSION_APP')
                <label class="col-md-2 form-control-label">Estado</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="state" id="state">
                        <option disabled value="">== Seleccione ==</option>
                        <option {{$configuracion->state == 1 ? 'selected' : ''}} value="1">Activo</option>
                        <option {{$configuracion->state == 0 ? 'selected' : ''}} value="0">Desactivado</option>
                    </select>
                </div>
                @endif
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Descripción</label>
                <div class="col-md-4">
                    <input type="text" id="description" name="description" class="form-control" value="{{$configuracion->description}}">
                </div>

                <label class="col-md-2 form-control-label">Valor</label>
                <div class="col-md-4">
                    <input type="text" id="value" name="value" class="form-control" value="{{$configuracion->value}}">
                </div>
            </div>

    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>
    <script>
    $('#form_configuracion_edit').validate({
        ignore: "",
        rules: {
            code: {
                required: true,
                maxlength: 30,
            },
            value: {
                required: true,
                maxlength: 50,
            },
            description: {
                maxlength: 200,
            },
            state: {
                required: true
            },
        },
        messages: {
           code: {
               required: "El código es requerido",
               maxlength: "Máximo 30 caracteres"
           },
           value: {
               required: "El valor es requerido",
               maxlength: "Máximo 50 caracteres"
           },
           description: {
               required: "El valor es requerido",
               maxlength: "Máximo 200 caracteres"
           },
           state: {
               required: "El estado es requerido",
           },

       },
        highlight: function (element) {
            $(element).parent().addClass('error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('error')
        }


    });
    </script>