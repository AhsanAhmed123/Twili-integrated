<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.php"> <img alt="image" src="{{ asset('admin/assets/img/logo.png')}} " class="header-logo" /> <span
                    class="logo-name">Gold Star Manor</span>
            </a>
        </div>
        <div class="sidebar-user">
            <div class="sidebar-user-picture">
                {{-- <img alt="image" src="{{ asset('admin/assets/img/user.png')}}"> --}}
            </div>
            <div class="sidebar-user-details">
                <div class="user-name">{{ Auth::user()->name }}</div>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>

              <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Day & Time</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('dashboard.index') }}">Day passes</a></li>
                                 <li><a class="nav-link" href="{{ route('dashboard.night') }}">Night passes</a></li>
                            </ul>
                        </li>
        </ul>
        
    </aside>
</div>
