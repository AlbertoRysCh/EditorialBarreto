@extends('layouts.app-login')
@section('login')
<div class="content-body">
    <section class="row flexbox-container">
    <div class="col-xl-7 col-md-9 col-10 d-flex justify-content-center px-0">
    <div class="card bg-authentication rounded-0 mb-0">
        <div class="row m-0">
            <div class="col-lg-6 d-lg-block d-none text-center align-self-center">
                <img src="{{asset('images/pages/forgot-password.png')}}" alt="forgot-password">
            </div>
            <div class="col-lg-6 col-12 p-0">
                <div class="card rounded-0 mb-0 px-2 py-1">
                    @include('auth.messages')
                    <div class="card-header pb-1">
                        <div class="card-title">
                            <h4 class="mb-0">Recuperar contraseña</h4>
                        </div>
                    </div>
                    <p class="px-2 mb-0">Por favor ingrese su correo electrónico y le enviaremos instrucciones sobre cómo reestablecer su contraseña.</p>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{route('password.email')}}" method="POST">
                                {{csrf_field()}}
                                <div class="form-label-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Correo" required value="{{old('email')}}">
                                    <label for="email">Correo</label>
                                </div>
                            <div class="float-md-left d-block mb-1">
                                <a href="{{route('login.principal')}}" class="btn btn-outline-primary btn-block px-75">Regresar al login</a>
                            </div>
                            <div class="float-md-right d-block mb-1">
                                <button type="submit" class="btn btn-primary btn-block px-75">Recuperar</button>
                            </div>
                            </form>

                        </div>
                    </div>
                    <div class="login-footer">
                        <div class="divider">
                            <div class="divider-text">Un producto de:</div>
                        </div>
                            <div><img class="centrar-imagen" src="{{asset('images/innova.jpeg')}}" alt="Innova"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
    </div>
@endsection
