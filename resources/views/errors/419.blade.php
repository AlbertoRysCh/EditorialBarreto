@extends('layouts.app')
@section('content')
<style>
body,
html {
    padding: 0;
    margin: 0;
    overflow: hidden;
}
.custom-error-419 {
  margin: 0 auto;
  text-align: center;
}
.custom-error-419 .error-code {
  bottom: 60%;
  color: #4a86f5;
  font-size: 40px;
  font-weight: bold;
}
.custom-error-419 .error-desc {
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
        <div><img src="{{asset('/images/pages/500.png')}}" alt="error-419" class="image rounded mx-auto d-block img-fluid centrar-imagen"></div>     
      </div>
  </div>
      <div class="row">

      <div class="col-sm-4 offset-md-4">   
          <div class="custom-error-419">
              <div class="error-code m-b-10 m-t-20">419</div>
              <h2 class="font-bold">Su sesión ha expirado.</h2>
          
              <div class="error-desc">
                Disculpamos el incoveniente, Su sessión ha expirado
                  <div><br>
          
                      <a href="/" class="btn btn-primary"><i class="fa fa-user"></i> Iniciar sesión</a>
                  </div>
              </div>
          </div>
          
      </div>
  </div>
</div>
@endsection