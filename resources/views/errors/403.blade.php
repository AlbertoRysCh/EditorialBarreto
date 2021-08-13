@extends('layouts.app')
@section('content')
<style>
body,
html {
    padding: 0;
    margin: 0;
    overflow: hidden;
}
.custom-error-403 {
  margin: 0 auto;
  text-align: center;
}
.custom-error-403 .error-code {
  bottom: 60%;
  color: #4a86f5;
  font-size: 96px;
  line-height: 100px;
  font-weight: bold;
}
.custom-error-403 .error-desc {
  font-size: 18px;
  color: #647788;
}
.custom-error-403 .m-b-10 {
  margin-bottom: 10px!important;
}
.custom-error-403 .m-b-20 {
  margin-bottom: 20px!important;
}
.custom-error-403 .m-t-20 {
  margin-top: 20px!important;
}
img {
  opacity: 0.3;
}

.error-code {
  font-size : 10rem;
}
</style>
<div class="container">
  <div class="row">
      <div class="col-sm-12">  
        <div><img src="{{asset('/images/pages/not-authorized.png')}}" alt="403-forbidden" class="rounded mx-auto d-block img-fluid centrar-imagen"></div>     
      </div>
  </div>
      <div class="row">

      <div class="col-sm-4 offset-md-4">   
          <div class="custom-error-403">
              <div class="error-code m-b-10 m-t-20">403</div>
              <h2 class="font-bold">Prohibido.</h2>
          
              <div class="error-desc">
                No tiene los suficientes privilegios.
                  <div><br>
          
                      <a href="{{ URL::to('inicio')}}" class="btn btn-primary"><i class="fa fa-home"></i> Ir a inicio</a>
                  </div>
              </div>
          </div>
          
      </div>
  </div>
</div>
@endsection