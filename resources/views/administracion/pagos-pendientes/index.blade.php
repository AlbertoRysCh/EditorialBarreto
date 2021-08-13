@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pagos pendientes por aprobar</h4>
                <div class="row">
                </div>

            </div>
            @include('locations.filtros')
            <div class="row">
                <div class="col-sm-2 ajuste-filto">
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control select2"  name="clientes_select" id="clientes_select">
                            <option value="T">Clientes</option>
                            @forelse($clientes as $items)
                            <option value="{{ $items->id }}">{{$items->nombres_rz  }} - {{ $items->num_documento }}</option>
                            @empty
                            Registre clientes
                            @endforelse
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
                                    <th>Acciones</th>
                                    <th>Datos del cliente</th>
                                    <th>Datos del servicio</th>
                                    <th>Repartidor</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Datos del cliente</th>
                                    <th>Datos del servicio</th>
                                    <th>Repartidor</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="{{asset('js/reportes/pendientes.js')}}"></script>
@endsection
