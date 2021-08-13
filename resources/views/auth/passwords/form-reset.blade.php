@extends('layouts.app-login')
@section('login')
<div class="content-body">
    <section class="row flexbox-container">
    <div class="col-xl-7 col-10 d-flex justify-content-center">
    <div class="card bg-authentication rounded-0 mb-0 w-100">
    <div class="row m-0">
        <div class="col-lg-6 d-lg-block d-none text-center align-self-center p-0">
            <img src="{{asset('images/pages/reset-password.png')}}" alt="reset-password">
        </div>
        <div class="col-lg-6 col-12 p-0">
            <div class="card rounded-0 mb-0 px-2">
                <div class="card-header pb-1">
                    @include('auth.messages')
                    <div class="card-title">
                        <h4 class="mb-0">Resetear contraseña</h4>
                    </div>
                </div>
                <p class="px-2 text-primary">Por favor ingresa tu contraseña.</p>
                <div class="card-content">
                    <div class="card-body pt-1">
                        <form action="{{route('resetpassword')}}" method="POST">
                            {{csrf_field()}}
                            <div class="display_none">
                                <input type="text" class="form-control" name="token" id="token" value="{{$resetPassword->token ?? null}}" readonly>
                                <input type="text" class="form-control" name="email" id="email" value="{{$resetPassword->email ?? null}}" readonly>
                            </div>


                            <fieldset class="form-label-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                <label for="password">Contraseña</label>
                            </fieldset>

                            <fieldset class="form-label-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                                <label for="confirm-password">Confirmar Contraseña</label>
                            </fieldset>
                            <div class="float-md-left d-block mb-1">
                                <a href="{{route('login.principal')}}" class="btn btn-outline-primary btn-block px-75">Regresar al login</a>
                            </div>
                            <div class="float-md-right d-block mb-1">
                                <button type="submit" class="btn btn-success btn-block px-75">Actualizar</button>
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
