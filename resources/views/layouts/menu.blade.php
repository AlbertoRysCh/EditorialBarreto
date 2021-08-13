    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('inicio')}}">
                        <img src="{{asset('images/pages/cropped-E.png')}}" alt="Logo"  class="size_logo_menu">
                        <h2 class="brand-text mb-0"></h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item {{ request()->is('inicio') ? 'active' : '' }}"><a href="{{route('inicio')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Inicio">Inicio</span></a>
                </li>
                @if($rol_id == 1 || $rol_id == 2 || $rol_id == 3 || $rol_id == 4)
                <li class="navigation-header"><span> </span>
                </li>
                <li class="nav-item request()->is('posibles-clientes')  ? 'has-sub open' : '' }}"><a href="#"><i class="feather icon-bar-chart-2"></i><span class="menu-title" data-i18n="Ventas">Ventas</span></a>
                    
                    <ul class="menu-content">

                        <!--@if($rol_id == 1 || $rol_id == 3)
                        <li class="{{ request()->is('clientes') ? 'active' : '' }}"><a href="{{route('posibles.clientes')}}"><i class="feather icon-user-check"></i><span class="menu-item" data-i18n="Clientes">Posibles clientes</span></a>
                        </li>
                        @endif-->
                    </ul>
                    <ul class="menu-content">
                        <li class="{{ request()->is('cliente') ? 'active' : '' }}"><a href="{{route('cliente.index')}}"><i class="fa fa-user-o"></i><span class="menu-item" data-i18n="prospecto">Prospecto/Clientes</span></a>
                        </li>
                    </ul>
                    
                   
            </li>
                @endif


                <!--<li class="navigation-header"><span>Reportes:</span>
                </li>

                @if($rol_id == 1 || $rol_id == 3 || $rol_id == 4 || $rol_id == 8)
                <li class="nav-item {{ request()->is('reportes/vendedores') ? 'active' : '' }}"><a href="{{route('reportes.vendedores')}}"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Vendedores">Vendedores</span></a>
                <ul class="menu-content">

                        @if($rol_id == 1 || $rol_id == 3)
                        <li class="{{ request()->is('clientes') ? 'active' : '' }}"><a href="{{route('posibles.clientes')}}"><i class="feather icon-user-check"></i><span class="menu-item" data-i18n="Clientes">Posibles clientes</span></a>
                        </li>
                        @endif
                    </ul>  
                </li>
                @endif-->

                <li class="navigation-header"><span> </span>
                </li>
                <li class="nav-item"><a href=""><i class="feather icon-users"></i><span class="menu-title" data-i18n="Vendedores">Producción</span></a>
                    
                    <ul class="menu-content">
                        <li class="{{ request()->is('autor') ? 'active' : '' }}"><a href="{{url('autor')}}"><i class="fa fa-address-book-o"></i><span class="menu-item" data-i18n="Clientes">Autores</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li class="{{ request()->is('editoriales') ? 'active' : '' }}"><a href="{{url('editoriales')}}"><i class="fa fa-newspaper-o"></i><span class="menu-item" data-i18n="Clientes">Editorial</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li class="{{ request()->is('area') ? 'active' : '' }}"><a href="{{url('area')}}"><i class="fa fa-bookmark-o"></i><span class="menu-item" data-i18n="Clientes">Áreas</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li class=""><a href=""><i class="fa fa-book"></i><span class="menu-title" data-i18n="Clientes">Libros</span></a>
                        
                        <ul class="menu-content">
                            <li class="{{ request()->is('') ? 'active' : '' }}"><a href="{{url('')}}"><i class="fa fa-graduation-cap"></i><span class="menu-item" data-i18n="Clientes">Libros Academicos</span></a>
                            </li>
                        </ul>
                        <ul class="menu-content">
                            <li class="{{ request()->is('librosinvestigacion') ? 'active' : '' }}"><a href="{{url('librosinvestigacion')}}"><i class="fa fa-pencil"></i><span class="menu-item" data-i18n="Clientes">Libros Investigación</span></a>
                            </li>
                        </ul>
                        <ul class="menu-content">
                            <li class="{{ request()->is('') ? 'active' : '' }}"><a href="{{url('')}}"><i class="fa fa-file-text"></i><span class="menu-item" data-i18n="Clientes">Artículos Científicos</span></a>
                            </li>
                        </ul>
                        </li><!---->
                    </ul>

                    <ul class="menu-content">
                        <li class="{{ request()->is('historial') ? 'active' : '' }}"><a href="{{url('historial')}}"><i class="fa fa-bar-chart"></i><span class="menu-item" data-i18n="Clientes">Historial</span></a>
                        </li>
                    </ul>

                    <ul class="menu-content">
                        <li class="{{ request()->is('archivo') ? 'active' : '' }}"><a href="{{url('archivo')}}"><i class="fa fa-folder-open-o"></i><span class="menu-item" data-i18n="Clientes">Archivos</span></a>
                        </li>
                    </ul>

                    <ul class="menu-content">
                        <li class="{{ request()->is('actividad') ? 'active' : '' }}"><a href="{{url('actividad')}}"><i class="fa fa-pencil-square-o"></i><span class="menu-item" data-i18n="Clientes">Actividades</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li class="{{ request()->is('material') ? 'active' : '' }}"><a href="{{url('material')}}"><i class="fa fa-briefcase"></i><span class="menu-item" data-i18n="Clientes">Materiales</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li class="{{ request()->is('revision') ? 'active' : '' }}"><a href="{{route('revision.index')}}"><i class="fa fa-search"></i><span class="menu-item" data-i18n="Clientes">Revisiones Técnicas</span></a>
                        </li>
                    </ul>
                    
                </li>
                <li class="navigation-header"><span> </span>
                <li class="nav-item {{ request()->is('usuarios') || request()->is('productos') ? 'has-sub open' : '' }}"><a href="#"><i class="fa fa-file-text-o"></i><span class="menu-title" data-i18n="Mantenimientos">Revisiones</span></a>
                <ul class="menu-content list">
                        <li class="{{ request()->is('ordentrabajo') ? 'active' : '' }}"><a href="{{url('ordentrabajo')}}"><i class="fa fa-book"></i><span class="menu-item" data-i18n="Usuarios">Libros</span></a>
                        </li>
                    </ul>
                </li>
                <li class="navigation-header"><span> </span>
                <li class="nav-item {{ request()->is('usuarios') || request()->is('productos') ? 'has-sub open' : '' }}"><a href="#"><i class="fa fa-eye"></i><span class="menu-title" data-i18n="Mantenimientos">Gerencia</span></a>
                  
                    <ul class="menu-content list">
                        <li class="{{ request()->is('gerencia_pendientes') ? 'active' : '' }}"><a href="{{url('gerencia_pendientes')}}"><i class="fa fa-clock-o"></i><span class="menu-item" data-i18n="Usuarios">Pagos por aprobar</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content list">
                        <li class="{{ request()->is('gerencia_aprobados') ? 'active' : '' }}"><a href="{{url('gerencia_aprobados')}}"><i class="fa fa-check-circle-o"></i><span class="menu-item" data-i18n="Usuarios">Pagos aprobados</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content list">
                        <li class="{{ request()->is('coautorias') ? 'active' : '' }}"><a href="{{route('coautorias')}}"><i class="fa fa-address-card-o"></i><span class="menu-item" data-i18n="Usuarios">Coautoria</span></a>
                        </li>
                    </ul>
                </li>

                @if($rol_id == 1)
                <li class="navigation-header"><span> </span>
                <li class="nav-item {{ request()->is('usuarios') || request()->is('productos') ? 'has-sub open' : '' }}"><a href="#"><i class="feather icon-edit-1"></i><span class="menu-title" data-i18n="Mantenimientos">Mantenimientos</span></a>
                    <ul class="menu-content list">
                        <li class="{{ request()->is('usuarios') ? 'active' : '' }}"><a href="{{route('usuarios.index')}}"><i class="feather icon-users"></i><span class="menu-item" data-i18n="Usuarios">Usuarios</span></a>
                        </li>

                    </ul>
                    <ul class="menu-content list">
                        <li class="{{ request()->is('asesorventas') ? 'active' : '' }}"><a href="{{route('asesorventas.index')}}"><i class="feather icon-users"></i><span class="menu-item" data-i18n="Usuarios">Asesores de Ventas</span></a>
                        </li>
                    </ul>
                    <ul class="menu-content list">
                        <li class="{{ request()->is('asesor') ? 'active' : '' }}"><a href="{{route('asesor.index')}}"><i class="feather icon-users"></i><span class="menu-item" data-i18n="Usuarios">Asesores editorial</span></a>
                        </li>
                    </ul>
                </li>
                <li class="navigation-header"><span>Otros</span>
                <li class="nav-item {{ request()->is('log-systems') || request()->is('configuraciones')  || request()->is('cargar-manual') || request()->is('mantenimiento') ? 'has-sub open' : '' }}"><a href="#"><i class="feather icon-settings"></i><span class="menu-title" data-i18n="Configuraciones">Configuraciones</span></a>
                <ul class="menu-content list">
                    <li class="{{ request()->is('log-systems') ? 'active' : '' }}"><a href="{{route('log-systems.index')}}"><i class="feather icon-activity"></i><span class="menu-item" data-i18n="Log Systems">Log Systems</span></a>
                    </li>
                    <li class="{{ request()->is('configuraciones') ? 'active' : '' }}"><a href="{{route('configuraciones.index')}}"><i class="feather icon-settings"></i><span class="menu-item" data-i18n="Configuraciones">Configuraciones</span></a>
                    </li>
                    {{-- <li class="{{ request()->is('cargar-manual') ? 'active' : '' }}"><a href=""><i class="feather icon-upload"></i><span class="menu-item" data-i18n="Cargar manual">Cargar manual</span></a>
                    </li> --}}
                </ul>
                </li>
                <a href="{{route('configuraciones.mantenimiento-show')}}" class="btn btn-success display" style="margin-left: 15px;"><i class="feather icon-alert-octagon"></i><span class="menu-item" data-i18n="Mantenimiento"> Mantenimiento</span></a>
                @endif

                <li class=" navigation-header"><span>Editorial</span>
                </li>
            </ul>
        </div>
    </div>
    {{-- @include('layouts.modals.cargar-manual') --}}
    <!-- END: Main Menu-->
