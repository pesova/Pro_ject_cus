<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">

                @if(is_store_admin())
                    <li class="menu-title">Switch Store</li>
                    <li>
                        <a href="javascript: void(0);">
                            <span class='seventh'> {{ Cookie::get('store_name') }}</span>
                            <span class="menu-arrow"></span>
                        </a>
                    
                        <ul class="nav-second-level" aria-expanded="false" id="store_lists">
                           
                        <div class="d-flex align-items-center invisible" id="store_list_spinner">
                                <strong>Getting Stores...</strong>
                            <div  class="spinner-border spinner-border-sm text-primary"
                            role="status">
                            <span class="sr-only">Loading...</span>
                            </div>
                            </div>
                        </ul>
                    </li>
                 @endif

                




                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span> Dashboard</span>
                    </a>
                </li>

                @if(is_super_admin())
                    {{-- super admin protected routes here --}}
                    @include('partials.menus_items.super_admin')
                @endif

                @if(is_store_admin())
                    {{--super admin protected routes here--}}
                    @include('partials.menus_items.store_admin')
                @endif

                @if(is_store_assistant())
                    {{-- super admin protected routes here --}}
                    @include('partials.menus_items.store_assistant')
                @endif

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
