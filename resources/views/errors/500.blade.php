@extends('layouts.app')
@section('content')
<style>
body,
html {
    padding: 0;
    margin: 0;
    overflow: hidden;
}
.custom-error-500 {
  margin: 0 auto;
  text-align: center;
}
.custom-error-500 .error-code {
  bottom: 60%;
  color: #4a86f5;
  font-size: 40px;
  font-weight: bold;
}
.custom-error-500 .error-desc {
  font-size: 18px;
  color: #647788;
}

img.image {
  opacity: 0.3;
  width: 15%;
}

.error-code {
  font-size : 10rem;
}
</style>
<div class="container">
  <div class="row">
      <div class="col-sm-12">  
        <div><img src="{{asset('/images/pages/500.png')}}" alt="error-500" class="image rounded mx-auto d-block img-fluid centrar-imagen"></div>     
      </div>
  </div>
      <div class="row">

      <div class="col-sm-4 offset-md-4">   
          <div class="custom-error-500">
              <div class="error-code m-b-10 m-t-20">500</div>
              <h2 class="font-bold">Error Interno del Servidor.</h2>
          
              <div class="error-desc">
                Disculpamos el incoveniente, por favor intente de nuevo o contacte con soporte
                reportando el incidente con captura completa de su pantalla.
                @if(Auth::user()->email == 'admin@logihouse.pe')
                  {{-- <h3>{{ Str::limit($exception->getMessage(),200,' (...)') }}</h3> --}}
                @endif
                  <div><br>
          
                      <a href="{{ URL::to('inicio')}}" class="btn btn-primary"><i class="fa fa-home"></i> Ir a Inicio</a>
                  </div>
              </div>
          </div>
          
      </div>
  </div>
</div>
@endsection