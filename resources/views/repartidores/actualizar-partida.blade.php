<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('actualizar.partida')}}" method="POST" id="form_actualizar_partida" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="servicio_id" value="{{$servicio->id}}">
            <label class="col-md-2 form-control-label">Tiendas</label>
            <div class="col-md-12">
                <select class="form-control select2" name="tienda_id" id="tienda_id" required>
                    <option disabled value="">== Seleccione ==</option>
                    @forelse($tiendas as $items)
                        <option value="{{$items->id}}">{{$items->descripcion}}</option>
                    @empty
                        Registre las tiendas
                    @endforelse
                </select>
            </div>
            </div>

    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>

