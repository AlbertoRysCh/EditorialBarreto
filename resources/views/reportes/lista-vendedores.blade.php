@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h4 class="card-title">Reporte de {{Auth::user()->rol_id == 3 || Auth::user()->rol_id == 1 ? 'vendedores' : 'vendedor'}}</h4>
                <div class="row">
                </div>

            </div>
            @include('locations.filtros')

        <div class="row">
                @if(Auth::user()->rol_id != 4)
                <div class="col-sm-2 ajuste-filto">
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control select2"  name="vendedores_select" id="vendedores_select">
                            <option value="T">Vendedores</option>
                            @forelse($vendedores as $items)
                            <option value="{{ $items->id }}">{{$items->name  }} - {{ $items->num_documento }}</option>
                            @empty
                            Registre vendedores
                            @endforelse
                        </select>
                    </div>
                </div>
                </div>
                @else
                <input type="hidden" name="vendedores_select" id="vendedores_select" value="{{Auth::id()}}">
                @endif
            </div>

            <div class="row">
                @if(Auth::user()->rol_id != 4)
                <div class="col-sm-2 ajuste-filto">
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control select2"  name="vendedores_select" id="vendedores_select">
                            <option value="T">Editar</option>
                            @forelse($vendedores as $items)
                            <option value="{{ $items->id }}">{{$items->name  }} - {{ $items->num_documento }}</option>
                            @empty
                            Registre vendedores
                            @endforelse
                        </select>
                    </div>
                </div>
                </div>
                @else
                <input type="hidden" name="vendedores_select" id="vendedores_select" value="{{Auth::id()}}">
                @endif

            </div>

            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Vendedor</th>
                                    <th>Mes</th>
                                    <th>Semana</th>
                                    <th>Programadas</th>
                                    <th>Realizadas</th>
                                    <th>Pendientes</th>
                                    <th>Clientes RS</th>
                                    <th>Clientes Foráneos</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Vendedor</th>
                                    <th>Mes</th>
                                    <th>Semana</th>
                                    <th>Programadas</th>
                                    <th>Realizadas</th>
                                    <th>Pendientes</th>
                                    <th>Clientes RS</th>
                                    <th>Clientes Foráneos</th>
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
<script src="{{asset('js/reportes/vendedores.js')}}"></script>
@endsection
