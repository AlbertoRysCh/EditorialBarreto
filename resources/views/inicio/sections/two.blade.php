<div class="col-lg-12 col-md-6 col-12">
    @if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 5 || Auth::user()->rol_id == 8)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-end">
            <h4 class="card-title text-success">Ingresos <strong>(Mensuales)</strong></h4>
        </div>
        <div class="card-content">
            <div class="card-body pb-0">
                <div class="d-flex justify-content-start">
                    <div class="mr-2">
                    <p class="mb-50 text-bold-600">Este mes <br>
                            {{Customize::mesActual()}}</p>
                        <h2 class="text-bold-400">
                            <sup class="font-medium-1">/S.</sup>
                        <span class="text-success">{{$data['ingresos']['mesActual'] ?? '0.00'}}</span>
                        </h2>
                    </div>
                    <div>
                        <p class="mb-50 text-bold-600">Mes pasado <br>
                            {{Customize::mesAnterior()}}</p>
                        <h2 class="text-bold-400">
                            <sup class="font-medium-1">/S.</sup>
                            <span>{{$data['ingresos']['mesAnterior'] ?? '0.00'}}</span>
                        </h2>
                    </div>

                </div>
                <div class="divider"><h4 class="text-danger"><strong>Monto total exonerado</strong></h4></div>
                <div class="d-flex justify-content-start">
                    <div class="mr-2">
                        <p class="mb-50 text-bold-600">Este mes <br>
                            {{Customize::mesActual()}}</p>
                        <h2 class="text-bold-400">
                            <sup class="font-medium-1">/S.</sup>
                        <span>{{$data['ingresos']['mesActualExonerado'] ?? '0.00'}}</span>
                        </h2>
                    </div>
                    <div>
                        <p class="mb-50 text-bold-600">Mes pasado <br>
                            {{Customize::mesAnterior()}}</p>
                        <h2 class="text-bold-400">
                            <sup class="font-medium-1">/S.</sup>
                            <span>{{$data['ingresos']['mesAnteriorExonerado'] ?? '0.00'}}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- Últimos clientes --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Últimos 5 posibles clientes registrados</h4>
        </div>
        <div class="card-content">
            <div class="table-responsive mt-1">
                <table class="table table-hover-animation mb-0">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['posiblesClientes'] as $items)
                        <tr>
                            <td>
                            <b>Tipo persona:</b> {{$items->tipo_persona_id == 1 ? 'Jurídica' : 'Natural'}}<br>
                            <b>Nombres:</b> {{$items->nombres_rz}}<br>
                            <b>Tipo documento:</b> {{$items->tipo_documento}}<br>
                            <b>Número documento:</b> {{$items->num_documento }}<br>
                            <b>Correo:</b> {{$items->correo }}<br>
                            <b>Teléfono:</b> {{$items->telefono }}<br>
                            <b>Dirección:</b> {{$items->direccion }}<br>
                            </td>
                            <td>{{date("d-m-Y H:i:s", strtotime($items->created_at))}}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>