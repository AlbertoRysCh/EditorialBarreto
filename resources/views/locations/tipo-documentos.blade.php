@foreach($tipoDocumentos as $k => $v)
    @if($tipoPersona == "1" && $k == "RUC")
        <option value="RUC">RUC</option>
    @endif

    @if($tipoPersona == "2" && $k != "RUC")
        @if($cliente != null && $cliente->tipo_documento == $k)
            <option value="{{ $k }}" selected>{{ $v }}</option>
        @else
            <option value="{{ $k }}">{{ $v }}</option>
        @endif
    @endif
@endforeach