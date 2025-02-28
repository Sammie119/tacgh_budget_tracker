<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <img
                    src="assets/img/kaiadmin/icon.svg"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="40"
                /> <span style="font-size: 35px; font-weight: bolder; color: white; margin-left: 10px">TAC-GH</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(in_array(Auth()->user()->is_admin, perm_arrays('users')))
                    <li class="nav-item {{ request()->is('budget_entries') ? 'active' : '' }}">
                        <a href="{{ route('budget_entries') }}">
                            <i class="fas fa-money-bill-alt"></i>
                            <p>Budget Management</p>
                        </a>
                    </li>
                @endif

                @if(in_array(Auth()->user()->is_admin, perm_arrays('users')) || Auth()->user()->is_admin == 3)
                    <li class="nav-item {{ request()->is('request_entries') ? 'active' : '' }}">
                        <a href="{{ route('request_entries') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <p>Request Management</p>
                        </a>
                    </li>
                @endif

                @if(in_array(Auth()->user()->is_admin, perm_arrays('users')) || Auth()->user()->is_admin == 4)
                    <li class="nav-item {{ request()->is('expense_entries') ? 'active' : '' }}">
                        <a href="{{ route('expense_entries') }}">
                            <i class="fas fa-coins"></i>
                            <p>Expense Management</p>
                        </a>
                    </li>
                @endif

{{--                @if(in_array(Auth()->user()->is_admin, perm_arrays('users')))--}}
                    <li class="nav-item {{ request()->is('reports') ? 'active' : '' }} {{ request()->is('reports_output') ? 'active' : '' }}">
                        <a href="{{ route('reports') }}">
                            <i class="far fa-chart-bar"></i>
                            <p>Reports</p>
                        </a>
                    </li>
{{--                @endif--}}

                @if(Auth()->user()->is_admin === 1 || Auth()->user()->is_admin === 0)
                    <li class="nav-item
                     {{ request()->is('categories') ? 'active' : '' }}
                     {{ request()->is('departments') ? 'active' : '' }}
                     {{ request()->is('budget_headers') ? 'active' : '' }}
                    ">
                        <a data-bs-toggle="collapse" href="#settings">
                            <i class="fas fa-cogs"></i>
                            <p>Settings</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
                            {{ request()->is('categories') ? 'show' : '' }}
                            {{ request()->is('departments') ? 'show' : '' }}
                            {{ request()->is('budget_headers') ? 'show' : '' }}
                            " id="settings">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('categories') }}">
                                        <span class="sub-item">Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('departments') }}">
                                        <span class="sub-item">Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('budget_headers') }}">
                                        <span class="sub-item">Budget Headers</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if(Auth()->user()->is_admin === 1)
                    <li class="nav-item {{ request()->is('users') ? 'active' : '' }}">
                        <a href="{{ route('users') }}">
                            <i class="fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
