<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('actualizar.llamada',$cliente)}}" method="POST" id="form_gestionar_edit" autocomplete="off">
            {{csrf_field()}}
            <div class="col-md-12">
                <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                <span class="text-center text-info width-100 height-100">Nombre de cliente:</span>
                <p class="form-control-static">{{ strtoupper($cliente->nombres_rz) }}</p>
            </div>

            <label class="col-md-4 form-control-label">Estado de llamada</label>
            <div class="col-md-12">
                <select class="form-control select2" name="estado_llamada">
                    <option value="" disabled>==Seleccione==</option>
                    @foreach($tipoLlamadas as $items)
                        <option {{$cliente->estado_llamada == $items->id ? 'selected' : ''}} value="{{$items->id}}">{{$items->nombre}}</option>
                    @endforeach
                </select>
            </div>
            </div>

    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>
 
