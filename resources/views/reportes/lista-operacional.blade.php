@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h4 class="card-title">Reporte de repartidor</h4>
                <div class="row">
                </div>

            </div>
            @include('locations.filtros')

        <div class="row">
                @if(Auth::user()->rol_id != 6)
                <div class="col-sm-2 ajuste-filto">
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control select2"  name="repartidores_select" id="repartidores_select">
                            <option value="T">Repartidores</option>
                            @forelse($repartidores as $items)
                            <option value="{{ $items->id }}">{{$items->name  }} - {{ $items->num_documento }}</option>
                            @empty
                            Registre repartidores
                            @endforelse
                        </select>
                    </div>
                </div>
                </div>
                @else
                <input type="hidden" name="repartidores_select" id="repartidores_select" value="{{Auth::id()}}">
                @endif

            </div>

            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Repartidor</th>
                                    <th>Orden de servicio</th>
                                    <th>Cliente</th>
                                    <th>Persona contacto</th>
                                    <th>Punto recojo</th>
                                    <th>Punto Partida</th>
                                    <th>Punto Entrega</th>
                                    <th>Hora de notificación OS</th>
                                    <th>Hora de recojo</th>
                                    <th>Hora de entrega</th>
                                    <th>KM Estimado</th>
                                    <th>Monto cobrado delivery</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="{{asset('js/reportes/operacional.js')}}"></script>
@endsection