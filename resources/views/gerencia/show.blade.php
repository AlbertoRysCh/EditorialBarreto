<div class="title" style="display: none">{{$title}}</div>
<form action="{{ route('gerencia.update',['gerencium'=>$cuotas]) }}"  id="form_cuotas" method="post" role="form" autocomplete="off">
<input type="hidden" name="tipo_contrato" value="{{$cuotas->tipo_contrato}}">
<input type="hidden" name="contrato_id" value="{{$cuotas->contrato_id}}">
    {{method_field('patch')}}
    {{csrf_field()}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                <label>Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="{{$ordentrabajo->codigo}}" readonly>
                <input type="hidden" class="form-control" id="id_ordentrabajo" name="id_ordentrabajo" value="{{$ordentrabajo->idordentrabajo}}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Título</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" value="{{$ordentrabajo->tipo_contrato == 0 ? $ordentrabajo->titulo : $ordentrabajo->titulo_coautoria }}" disabled>
                </div>
            </div>
        </div>
    <div class="row" style="display: {{$cuotas->tipo_contrato == 0 ? 'flex' : 'none'}}">
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio" value="{{$ordentrabajo->precio}}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Fecha de orden</label>
                    <input type="text" class="form-control" name="fecha" id="fecha" value="{{date("d-m-Y", strtotime($ordentrabajo->fechaorden))}}" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Monto aprobar</label>
                    <input type="text" class="form-control" id="monto" name="monto" value="{{$cuotas->monto}}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Estado</label>
                    <select class="form-control" name="statu" id="statu" required>
                        <option value="" selected> == Seleccione == </option>
                        <option value="1" {{$cuotas->statu == 1 ? 'selected' : ''}}> Aprobado </option>
                        <option value="2" {{$cuotas->statu == 2 ? 'selected' : ''}}> Rechazado </option>
                      </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="form-group ">
            <label>Observación</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3" maxlength="250">{{$cuotas->observaciones}}</textarea>                       
            </div>
            </div>
        </div>
</form>
<script>
        $('#form_cuotas').validate({
        rules: {
            statu: {
                required: true
            },
            observaciones: {
                required: {
                    depends: function () {
                        var estado = $('#statu').val();
                            if(estado == 2){
                                return true;
                            }
                    }
                }
            },
        },
        messages: {
            statu: {
               required: "El estado es requerido"
           },
           observaciones: {
               required: "Agregue una observación del rechazo de la cuota."
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