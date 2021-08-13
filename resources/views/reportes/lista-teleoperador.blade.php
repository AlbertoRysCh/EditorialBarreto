@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h4 class="card-title">Reporte de teleoperador</h4>
                <div class="row">
                </div>

            </div>
            @include('locations.filtros')

        <div class="row">
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

                <div class="col-sm-2 ajuste-filto">
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control select2"  name="estado_pago" id="estado_pago">
                            <option value="T">Estado</option>
                            <option value="0">Pendiente</option>
                            <option value="1">Cancelado</option>
                            <option value="3">Donación</option>
                        </select>
                    </div>
                </div>
                </div>

            </div>

            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Direccion inicio</th>
                                    <th>Direccion final</th>
                                    <th>Nombre del cliente</th>
                                    <th>Nro. Celular</th>
                                    <th>Motorizado</th>
                                    <th>Total a pagar</th>
                                    <th>Estado</th>
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
<script src="{{asset('js/reportes/teleoperador.js')}}"></script>
@endsection