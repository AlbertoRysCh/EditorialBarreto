@include('layouts.header')
@include('layouts.navbar')
@include('layouts.menu')

@if (Session::has('mensajeSuccess'))
    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static" data-open="click" onload="mostrarMensajeSuccess('{{ Customize::messageSuccess() }}');" data-menu="vertical-menu-modern" data-col="2-columns">
@elseif(Session::has('mensajeInfo'))
    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static" data-open="click" onload="mostrarMensajeInfo('{{ Customize::messageInfo() }}');" data-menu="vertical-menu-modern" data-col="2-columns">
@else
    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@endif

    <!-- BEGIN: Content-->
    <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        @if($get_mantenimiento == 1 && !Auth::user()->email == 'admin@logihouse.pe')
            @include('layouts.mantenimiento')
        @else
            @yield('content')
        @endif
    </div>
    </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    @include('layouts.modals.view')
    @include('layouts.modals.show')
    @include('layouts.modals.loading-centered')
    @include('layouts.modals.loading-wait')
    @include('layouts.footer')
    <div class="preload_wait">
        <img src="{{asset('/images/giphy.gif')}}" alt="preload_wait">
        <p class="mb-0 text-uppercase text-muted"><strong>Espere por favor...</strong></p>
    </div>