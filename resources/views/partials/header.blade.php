<!-- Header start -->
<header>
    <nav>
        <div class="container nav">
            <div class="nav__brand">
                <a href="{{route('home') }}" class="nav__brand__logo"><img
                        src="{{ ('/frontend/assets/images/fulllogo.png') }}" alt="" height="auto" /></a>
            </div>
            <div class="nav__menu">
                <div class="menu__container">
                    <ul class="menu__list">
                        {{-- <li class="menu__list__item"><a href="{{ route('home') }}"
                        class="menu__list__link">Home</a>
                        </li>
                        <li class="menu__list__item"><a href="{{ route('about') }}" class="menu__list__link">About</a>
                        </li> --}}
                        {{-- <li class="menu__list__item"><a href="{{ route('faq') }}" class="menu__list__link">FAQ</a>
                        </li> --}}
                        {{-- <li class="menu__list__item"><a href="{{ route('contact') }}"
                        class="menu__list__link">Contact
                        Us</a></li> --}}
                        {{-- <li class="menu__list__item"><a href="{{ route('privacy') }}"
                        class="menu__list__link">Privacy
                        Policy</a></li> --}}
                        {{-- <li class="menu__list__item"><a href="{{ route('blog') }}"
                        class="menu__list__link">Blog</a></li> --}}
                    </ul>
                </div>
            </div>
            <div class="nav__button__container">
                @if(!isset($_COOKIE['api_token']))
                <button class="nav__button "><a href="{{ route('login') }}" class="nav__button__link">Log
                        In</a></button>
                <a href="{{ route('signup') }}" class="nav__button btn-nav-active">Sign Up</a>
                @elseif(isset($_COOKIE['api_token']))
                {{-- <button class="nav__button btn-nav-active"> --}}
                <a href="{{ route('dashboard') }}"
                    class="nav__button btn-nav-active nav__button__link__active">Dashboard</a>
                {{-- </button> --}}
                {{-- <button class=""> --}}
                <a href="{{ route('logout') }}" class="nav__button btn-nav-active nav__button__link__active">Logout
                </a>
                {{-- </button> --}}
                @endif
            </div>

            <div class="hamburger-container">
                <div class="hamburger__menu">
                    <div class="menubar menu-bar-one"></div>
                    <div class="menubar menu-bar-two"></div>
                    <div class="menubar menu-bar-three"></div>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="mobile-menu">
            <div class="close-mobile-menu">
                <i class="fas fa-times"></i>
            </div>
            <div class="mobile__nav__menu">
                {{-- <a href="{{route('home') }}" class="nav__brand__logo"><img
                    src="{{ ('/frontend/assets/images/fulllogo.png') }}" alt="" height="auto" /></a> --}}

                {{-- <hr class="hr-mobile"> --}}
                <div class=" h1-group-vertical mobile__nav__h1__container">
                    @if(!isset($_COOKIE['api_token']))
                    <h1 class="mobile__nav__h1">
                        <a href="{{ route('login') }}" class="mobile__nav__h1__link">
                            {{-- <img src="{{ ('/frontend/assets/images/Vector 3.png') }}" /> --}}
                            Log In</a>
                    </h1>
                    <h1 class="mobile__nav__h1">
                        <a href="{{ route('signup') }}" class="mobile__nav__h1__link">
                            {{-- <img src="{{ ('/frontend/assets/images/Vector 3.png') }}" /> --}}
                            Sign Up
                        </a>
                    </h1>
                    @elseif(isset($_COOKIE['api_token']))
                    <div class="mobile__nav__h1">
                        <a href="{{ route('dashboard') }}" class="mobile__nav__h1__link">
                            {{-- <img src="{{ ('/frontend/assets/images/Vector 3.png') }}" /> --}}
                            Dashboard
                        </a>

                        <a href="{{ route('logout') }}" class="mobile__nav__h1__link">
                            {{-- <img src="{{ ('/frontend/assets/images/Vector 3.png') }}" /> --}}
                            Logout
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

</header>
<!-- header end -->