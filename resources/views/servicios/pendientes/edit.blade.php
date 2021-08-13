<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('servicios-pendientes.asignar')}}" method="POST" id="form_servicio_store" autocomplete="off">
            {{csrf_field()}}


            <input type="hidden" name="servicio_id" value="{{$consultaServicio->id}}">
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Registro</label>
                <div class="col-md-4">

                    <span class="text-center bg-info colors-container rounded text-white width-100 height-100">Ticket servicio:</span>
                    <p class="form-control-static" id="codigo" name="codigo">{{$consultaServicio->ticket}}</p>

                    <span class="text-center bg-info colors-container rounded text-white width-100 height-100">Código cliente:</span>
                    <p class="form-control-static" id="codigo" name="codigo">{{$cliente->codigo}}</p>


                </div>

                <label class="col-md-2 form-control-label">Cliente:</label>
                <div class="col-md-4">
                    {{-- <input type="hidden" class="num_documento_hidden" readonly> --}}
                    <span class="text-center bg-info colors-container rounded text-white width-100 height-100">Num. Documento:</span>
                    <p class="form-control-static" id="codigo" name="codigo">{{$cliente->num_documento}}</p>

                    <span class="text-center bg-info colors-container rounded text-white width-100 height-100">Nombres:</span>
                    <p class="form-control-static" id="codigo" name="codigo">{{$cliente->nombres_rz}}</p>


                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-12 form-control-label">Hora estimada para el recojo del producto</label>
                <div class="col-md-12">
                    <input type="text" id="hora_estimada_recojo_aux" name="hora_estimada_recojo_aux" class="form-control hora_estimada_recojo" placeholder="Ingrese Duración" required>
                    <input type="hidden" id="hora_estimada_recojo" name="hora_estimada_recojo" class="form-control" val="">
                </div>

                <label class="col-md-12 form-control-label">Tiempo programado</label>
                <div class="col-md-12">
                    <input type="text" id="tiempo_programado_aux" name="tiempo_programado_aux" class="form-control tiempo_programado" required>
                    <input type="hidden" id="tiempo_programado" name="tiempo_programado" class="form-control" val="">
                </div>

                <label class="col-md-12 form-control-label">Repartidores</label>
                <div class="col-md-12">
                    <select class="form-control select2 required"  name="usuario_id" id="usuario_id">
                        <option value="" selected>== Seleccione ==</option>
                        @forelse($usuariosRepartidores as $items)
                                <option value="{{$items->id}}">{{$items->num_documento}} - {{$items->name}} 
                                    @foreach ($totalServicios as $key => $value)
                                        @if ($items->id == $value->usuario_id) {{ 'Servicios asignados: '.'('.$value->count_servicios.')' }}
                                        @endif
                                    @endforeach
    
                                </option>
                        @empty
                            Registre los repartidores
                        @endforelse
                    </select>
                </div>
            </div>

    </form>
    <script>
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });

        $('.hora_estimada_recojo').durationPicker({
        showDays:false,
            showHours:true,
            showMins:true,
            hoursLabel:'Hora(s)',
            minsLabel:'Minuto(s)'
        }).on("change", function(){
            $('input[name=hora_estimada_recojo]').val(secondsToString($(this).val()));
            // console.log(secondsToString($(this).val()));
        });

        $('.tiempo_programado').durationPicker({
        showDays:false,
            showHours:true,
            showMins:true,
            hoursLabel:'Hora(s)',
            minsLabel:'Minuto(s)'
        }).on("change", function(){
            $('input[name=tiempo_programado]').val(secondsToString($(this).val()));
            // console.log(secondsToString($(this).val()));
        });

        $('#form_servicio_store').validate({
        ignore: "",
        rules: {
            hora_estimada_recojo: {
                required: true,
                number: {
                    depends: function () {
                        var duracion = $('input[name=hora_estimada_recojo_aux]').val();
                        var separarTiempo = duracion.split(":");
                        var value = separarTiempo[0];
                            if(value == 0){
                                return true;
                            }
                    }
                }
            },
            tiempo_programado: {
                required: true,
                number: {
                    depends: function () {
                        var duracion = $('input[name=tiempo_programado_aux]').val();
                        var separarTiempo = duracion.split(":");
                        var value = separarTiempo[0];
                            if(value == 0){
                                return true;
                            }
                    }
                }
            },

        },
        messages: {
            hora_estimada_recojo: {
               required: "Ingrese el tiempo de recojo del producto.",
               number: "Ingrese el tiempo de recojo del producto."
           },
           tiempo_programado: {
               required: "Ingrese el tiempo programado.",
               number: "Ingrese el tiempo programado."
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
