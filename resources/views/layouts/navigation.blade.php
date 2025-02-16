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

                <li class="nav-item {{ request()->is('budget_entries') ? 'active' : '' }}">
                    <a href="{{ route('budget_entries') }}">
                        <i class="fas fa-money-bill-alt"></i>
                        <p>Budget Management</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('expense_entries') ? 'active' : '' }}">
                    <a href="{{ route('expense_entries') }}">
                        <i class="fas fa-coins"></i>
                        <p>Expense Management</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms">
                        <i class="fas fa-layer-group"></i>
                        <p>Reports</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="forms/forms.html">
                                    <span class="sub-item">Budget Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="forms/forms.html">
                                    <span class="sub-item">Expense Report</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if(Auth()->user()->is_admin === 1)
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
