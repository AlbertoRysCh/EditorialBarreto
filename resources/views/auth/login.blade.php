@extends('layouts.app-login')
@section('login')
<section class="row flexbox-container">
    <div class="content-body card">
    {{-- <div class="card rounded-0 mb-0"> --}}
    <div class="row m-0">
    <div class="col-lg-7 d-lg-block d-none text-center align-self-center px-1 py-0">
    <img src="{{asset('images/pages/Editorial.png')}}" alt="iniciar_sesion">
    </div>
    <div class="col-lg-5 col-12 p-0">
    <div class="card rounded-0 mb-0 px-2 py-1">
    @include('auth.messages')
    <div class="card-header pb-1">
        <div class="card-title">
            <h4 class="mb-0">Editorial Barreto</h4>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body pt-1">
            <form method="POST" action="{{route('login')}}" id="logForm">
                {{ csrf_field() }}
                <fieldset class="form-label-group form-group position-relative has-icon-left">
                    <input type="text" value="{{old('username')}}" class="form-control" name="username" placeholder="Usuario">
                    <div class="form-control-position">
                        <i class="feather icon-user"></i>
                    </div>
                    <label>Usuario</label>
                    @if ($errors->has('username'))
                        <span class="error">{{ $errors->first('username') }}</span>
                    @endif
                </fieldset>

                <fieldset class="form-label-group position-relative has-icon-left">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" autocomplete="on">
                    <div class="form-control-position">
                        <i class="feather icon-lock"></i>
                    </div>
                    <label>Contraseña</label>
                    @if ($errors->has('password'))
                        <span class="error">{{ $errors->first('password') }}</span>
                    @endif
                </fieldset>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="text-right"><a href="{{route('password.reset')}}" class="card-link">Olvidaste tu contraseña?</a></div>
                </div>
                <button type="submit" class="btn btn-primary float-right btn-inline">Iniciar</button>
            </form>
        </div>
    </div>
    {{-- <hr>
    Un producto de:
    <img class="centrar-imagen" src="{{asset('images/innova.jpeg')}}" alt="logo_innova"> --}}
    </div>
    </div>
    </div>
    {{-- </div> --}}


    </div>
</section>

@endsection
