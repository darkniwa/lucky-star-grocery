<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <a href="/manager"><img src="{{ asset('assets/admin/images/logo/logo.png') }}" alt="Logo" srcset=""></a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ \Request::route()->getName() == 'admin.index' ? 'active' : '' }} ">
                        <a href="{{ route('admin.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    <li class="sidebar-item {{ \Request::route()->getName() == 'admin.user_management' ? 'active' : '' }}">
                        <a class='sidebar-link' href="{{ route('admin.user_management') }}">
                            <i class="bi bi-card-checklist"></i>
                            <span>User Management</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Settings</li>

                    <li class="sidebar-item {{ \Request::route()->getName() == 'admin.account.profile' ? 'active' : '' }} ">
                        <a href="{{ route('admin.account.profile') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li class="sidebar-item  ">
                        <a href="{{ route('logout') }}" class='sidebar-link' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-door-closed-fill"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
