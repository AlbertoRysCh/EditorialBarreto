@extends('layouts.app')
@section('content')
@section('custom-css')

@endsection


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Registrar servicio</h4>
            </div>
            <div class="card-content px-2">

            <div class="content-body">
                <input type="hidden" name="get-products-ajax" id="get-products-ajax" value="{{route('productos.get-ajax')}}">
                <input type="hidden" name="get-producto" id="get-producto" value="{{route('get.producto')}}">
                <form action="{{route('servicios.store')}}" class="steps-validation wizard-circle" method="POST" autocomplete="off" id="form_servicios">
                {{csrf_field()}}
                <!-- Step 1 -->
                <h6><i class="step-icon feather icon-user"></i> Cliente</h6>
                <fieldset>
                    @include('teleoperadores.partials.wizard-cliente')
                </fieldset>

                <!-- Step 2 -->
                <h6><i class="step-icon feather icon-briefcase"></i> Servicios</h6>
                <fieldset>
                    @include('teleoperadores.partials.wizard-productos')
                </fieldset>

                <!-- Step 3 -->
                <h6><i class="step-icon feather icon-credit-card"></i> Condiciones de pago</h6>
                <fieldset>
                    @include('teleoperadores.partials.wizard-metodo-pago')
                </fieldset>
                </form>
            </div>
            </div>
            </div>
        </div>
    </div>

    @endsection
    @section('custom-js')
    <script src="{{asset('js/functions.js')}}"></script>
    <script src="{{asset('js/modules/teleoperadores/teleoperador.js')}}"></script>
    @endsection
