<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                    </ul>
                    {{-- <ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon feather icon-star warning"></i></a>
                            <div class="bookmark-input search-input">
                                <div class="bookmark-input-icon"><i class="feather icon-search primary"></i></div>
                                <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="0" data-search="template-list">
                                <ul class="search-list search-list-bookmark"></ul>
                            </div>
                        </li>
                    </ul> --}}
                    <button type="button" class="btn btn-icon rounded-circle btn-outline-success waves-effect waves-light reloadPage"><i class="feather icon-refresh-cw"></i></button>

                </div>
                <ul class="nav navbar-nav float-right">

                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>

                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{ $user_name }}</span>
                            <span class="user-status">{{ $rol }}</span>
                            {{-- <span class="text-danger">
                                {!!Auth::user()->rol_id == 4 ? '('.Auth::user()->distrito->distrito.')' : ''!!}
                            </span> --}}
                            </div>

                            <span>
                                @if($image)
                                    <img class="round" src="{{asset('/images/perfiles/'.$image)}}" alt="perfil" height="40" width="40">
                                @else
                                    <img class="round" src="{{asset('/images/perfiles/user1.png')}}" alt="user" height="40" width="40">
                                @endif
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if($perfil)
                            <a class="dropdown-item" href="{{route('edit.profile',Crypt::encrypt(Auth::id()))}}">
                            <i class="feather icon-user"></i> Editar Perfil
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('logout')}}"><i class="feather icon-power"></i> Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
