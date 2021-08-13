@extends('layouts.app')
@section('content')

@include('inicio.sections.filtros')


<section>
    <h4 class="mb-1">Resumen de servicios</h4>
    <div class="row">
        @include('inicio.sections.one')
    </div>
    <div class="row">
    </div>
    <div class="row">
    </div>

</section>
@endsection
@section('custom-js')
    <script src="{{asset('js/modules/inicio.js')}}"> </script>
@endsection
