<!-- Topbar Start -->
<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="{{route('home') }}" class="navbar-brand mr-0 mr-md-2 logo">
            <span class="logo-lg">
                @if(\Cookie::get('theme') == 'dark')
                    <img src="{{('/frontend/assets/images/fulllogo.png')}}" alt="" height="48"/>
                @else
                    <img src="{{('/frontend/assets/images/fulllogo.png')}}" alt="" height="48"/>
                @endif
            </span>
            <span class="logo-sm">
                <img src="/frontend/assets/images/smLogo.svg" alt="" height="24">
            </span>
        </a>

        <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
            <li class="">
                <button class="button-menu-mobile open-left disable-btn">
                    <i data-feather="menu" class="menu-icon"></i>
                    <i data-feather="x" class="close-icon"></i>
                </button>
            </li>
        </ul>

        <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">

            <li class="pointer">

                <div class="media user-profile mt-2 mb-2">
                    <div data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                         aria-expanded="false"
                         style="position:absolute;top:0; width: 100%; height:100%;">
                    </div>
                    <object data="{{ get_profile_picture() }}" type="image/jpg" class="avatar-sm rounded-circle mr-2">
                        <img src="/backend/assets/images/users/default.png" class="avatar-sm rounded-circle mr-2"
                             alt="Profile Picture"/>
                    </object>
                    <div class="media-body">
                        @if(is_store_assistant())

                            <h6 class="pro-user-name mt-0 mb-0">{{Cookie::get('name')}}
                            </h6>
                        @else

                            <h6 class="pro-user-name mt-0 mb-0">
                                {{Cookie::get('first_name') == 'Not set'? '':Cookie::get('first_name')}}
                                {{Cookie::get('last_name')== 'Not set'? '':Cookie::get('last_name')}}
                            </h6>
                        @endif
                        <span class="pro-user-desc">
                            {{format_role_name()}}
                        </span>
                    </div>
                    <div class="dropdown align-self-center profile-dropdown-menu">
                        <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <span data-feather="chevron-down"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown">

                            <a href="{{ route('setting') }}" class="dropdown-item notify-item">
                                <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                                <span>Edit Profile</span>
                            </a>

                            <div class="dropdown-divider"></div>
                            @if(\Cookie::get('theme') == 'dark')
                                <a href="{{route('theme.change','light')}}" class="dropdown-item notify-item">
                                    <i data-feather="sun" class="icon-dual icon-xs mr-2"></i>
                                    <span>Switch to light mode</span>
                                </a>
                            @else
                                <a href="{{route('theme.change','dark')}}" class="dropdown-item notify-item">
                                    <i data-feather="moon" class="icon-dual icon-xs mr-2"></i>
                                    <span>Switch to dark mode</span>
                                </a>
                            @endif

                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item notify-item" id="logout-btn">
                                <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>

</div>