<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('index') }}"><img src="{{ asset('assets/seller/images/logo/logo.png') }}"
                            alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ \Request::route()->getName() == 'index' ? 'active' : '' }} ">
                    <a href="{{ route('index') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @can('manage_products')
                    <li
                        class="sidebar-item has-sub {{ \Request::route()->getName() == 'products.create' || \Request::route()->getName() == 'products.index' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-basket2-fill"></i>
                            <span>Products</span>
                            @if (isset($unseenNotificationsCount) && $unseenNotificationsCount > 0)
                                <span class="badge bg-danger">{{ $unseenNotificationsCount }}</span>
                            @endif
                        </a>
                        <ul
                            class="submenu {{ \Request::route()->getName() == 'products.create' || \Request::route()->getName() == 'products.index' ? 'active' : '' }}">
                            <li class="submenu-item {{ \Request::route()->getName() == 'products.index' ? 'active' : '' }}">
                                <a href="{{ route('products.index') }}">Product List @if (isset($unseenNotificationsCount) && $unseenNotificationsCount > 0)
                                        <span class="badge bg-danger">{{ $unseenNotificationsCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li
                                class="submenu-item {{ \Request::route()->getName() == 'products.create' ? 'active' : '' }}">
                                <a href="{{ route('products.create') }}">Add Product</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('process_orders')
                    <li
                        class="sidebar-item  has-sub {{ \Request::route()->getName() == 'orders' || \Request::route()->getName() == 'order.scan' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-card-checklist"></i>
                            <span>Orders</span>
                        </a>
                        <ul
                            class="submenu {{ \Request::route()->getName() == 'orders' || \Request::route()->getName() == 'order.scan' ? 'active' : '' }}">
                            <li class="submenu-item {{ \Request::route()->getName() == 'orders' ? 'active' : '' }}">
                                <a href="{{ route('orders') }}">Manage Orders</a>
                            </li>
                            <li class="submenu-item {{ \Request::route()->getName() == 'order.scan' ? 'active' : '' }}">
                                <a href="{{ route('order.scan') }}">Scan Pickup</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('manage_shipping')
                    <li class="sidebar-item {{ \Request::route()->getName() == 'delivery' ? 'active' : '' }} ">
                        <a href="{{ route('delivery') }}" class='sidebar-link'>
                            <i class="bi bi-truck"></i>
                            <span>Delivery</span>
                        </a>
                    </li>
                @endcan

                @can('manage_billing')
                    {{-- <li class="sidebar-item {{ \Request::route()->getName() == 'remittance' ? 'active' : '' }}">
                        <a href="{{ route('remittance') }}" class='sidebar-link'>
                            <i class="bi bi-cash-stack"></i>
                            <span>Remittance</span>
                        </a>
                    </li> --}}

                    <li class="sidebar-item has-sub {{ \Request::route()->getName() == 'remittance' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-cash-stack"></i>
                            <span>Remittance</span>
                        </a>
                        <ul
                            class="submenu {{ \Request::route()->getName() == 'remittance' || \Request::route()->getName() == 'remittance.report' ? 'active' : '' }}">
                            <li class="submenu-item {{ \Request::route()->getName() == 'remittance' ? 'active' : '' }}">
                                <a href="{{ route('remittance') }}">Manage Remittance</a>
                            </li>
                            <li
                                class="submenu-item {{ \Request::route()->getName() == 'remittance.report' ? 'active' : '' }}">
                                <a href="{{ route('remittance.report') }}">Remittance Report</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('manage_sales_report')
                    {{-- <li class="sidebar-item {{ \Request::route()->getName() == 'sales' ? 'active' : '' }}">
                        <a href="{{ route('sales') }}" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span>Sales Report</span>
                        </a>
                    </li> --}}

                    <li
                        class="sidebar-item has-sub {{ \Request::route()->getName() == 'sales.history' || \Request::route()->getName() == 'sales.overview' || \Request::route()->getName() == 'sales.products_and_performance' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span>Sales</span>
                        </a>
                        <ul
                            class="submenu {{ \Request::route()->getName() == 'sales.history' || \Request::route()->getName() == 'sales.overview' || \Request::route()->getName() == 'sales.products_and_performance' ? 'active' : '' }}">
                            <li
                                class="submenu-item {{ \Request::route()->getName() == 'sales.overview' ? 'active' : '' }}">
                                <a href="{{ route('sales.overview') }}">Overview</a>
                            </li>
                            <li class="submenu-item {{ \Request::route()->getName() == 'sales.history' ? 'active' : '' }}">
                                <a href="{{ route('sales.history') }}">Sales History</a>
                            </li>
                            {{-- <li
                                class="submenu-item {{ \Request::route()->getName() == 'sales.products_and_performance' ? 'active' : '' }}">
                                <a href="{{ route('sales.products_and_performance') }}">Products and Performance</a>
                            </li> --}}
                        </ul>
                    </li>
                @endcan

                @can('manage_promotions')
                    <li class="sidebar-item {{ \Request::route()->getName() == 'mail.promotions' ? 'active' : '' }}">
                        <a href="{{ route('mail.promotions') }}" class='sidebar-link'>
                            <i class="bi bi-envelope-fill"></i>
                            <span>Promotions</span>
                        </a>
                    </li>
                @endcan

                @can('manage_wallet')
                    <li class="sidebar-item {{ \Request::route()->getName() == 'wallet' }} ">
                        <a href="{{ route('wallet') }}" class='sidebar-link'>
                            <i class="bi bi-wallet2"></i>
                            <span>Wallet</span>
                        </a>
                    </li>
                @endcan

                <li class="sidebar-title">Settings</li>

                <li class="sidebar-item {{ \Request::route()->getName() == 'account.profile' ? 'active' : '' }} ">
                    <a href="{{ route('account.profile') }}" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                @can('manage_content')
                    <li
                        class="sidebar-item  has-sub {{ \Request::route()->getName() == 'content-management.create' || \Request::route()->getName() == 'content-management.index' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-globe"></i>
                            <span>Website Content</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item ">
                                <a href="{{ route('carousel.view') }}">Carousel</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="#">Special Offer</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('manage_staff')
                    <li
                        class="sidebar-item  has-sub {{ \Request::route()->getName() == 'staff.create' || \Request::route()->getName() == 'staff.index' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-people"></i>
                            <span>Staff Management</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item ">
                                <a href="{{ route('staff.index') }}">Staff List</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('roles-permissions') }}">Roles and Permissions</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <li class="sidebar-item  ">
                    <a href="{{ route('logout') }}" class='sidebar-link'
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
