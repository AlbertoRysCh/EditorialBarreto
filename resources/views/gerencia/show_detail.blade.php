<div class="title" style="display: none">{{$title}}</div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                <label>Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="{{$ordentrabajo->codigo}}" disabled>
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
                    <label>Estado</label>
                    <input type="text" class="form-control"  value="{{$cuotas->statu == 1 ? 'Aprobado' : 'Rechazado'}}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label>Monto aprobado</label>
                    <input type="text" class="form-control"  value="{{$cuotas->monto}}" disabled>
                </div>
            </div>
        </div>
</form>
