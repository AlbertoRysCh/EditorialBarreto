@extends('layouts.app')
@section('content')
<style>
body,
html {
    padding: 0;
    margin: 0;
    overflow: hidden;
}
.custom-error-404 {
  margin: 0 auto;
  text-align: center;
}
.custom-error-404 .error-code {
  bottom: 60%;
  color: #4a86f5;
  font-size: 40px;
  line-height: 100px;
  font-weight: bold;
}
.custom-error-404 .error-desc {
  font-size: 18px;
  color: #647788;
}

img.image {
  opacity: 0.3;
}
.error-code {
  font-size : 10rem;
}
</style>
<div class="container">
  <div class="row">
      <div class="col-sm-12">  
        <div><img src="{{asset('/images/pages/404.png')}}" alt="error-404" class="image rounded mx-auto d-block img-fluid centrar-imagen"></div>     
      </div>
  </div>
      <div class="row">

      <div class="col-sm-4 offset-md-4">   
          <div class="custom-error-404">
              <div class="error-code m-b-10 m-t-20">404</div>
              <h2 class="font-bold">Página no encontrada.</h2>
          
              <div class="error-desc">
                  <div><br>
          
                      <a href="{{ URL::to('inicio')}}" class="btn btn-primary"><i class="fa fa-home"></i> Ir a Inicio</a>
                  </div>
              </div>
          </div>
          
      </div>
  </div>
</div>
@endsection