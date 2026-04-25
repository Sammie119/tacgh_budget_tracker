<style>
    /* ── Alert bell ── */
    .alert-bell-wrap {
        position: relative;
        margin-right: 8px;
    }
    .alert-bell-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        border: none;
        background: transparent;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px;
        color: #6c757d;
        cursor: pointer;
        transition: background 0.15s;
        position: relative;
    }
    .alert-bell-btn:hover { background: rgba(0,0,0,0.06); }
    .alert-badge {
        position: absolute;
        top: 3px; right: 3px;
        min-width: 17px; height: 17px;
        border-radius: 9px;
        background: #dc3545;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        padding: 0 4px;
        line-height: 1;
        border: 2px solid #fff;
    }
    .alert-badge.warning { background: #f59e0b; }

    .alert-dropdown {
        width: 340px;
        max-height: 420px;
        overflow-y: auto;
        border-radius: 14px !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 8px 28px rgba(0,0,0,0.12) !important;
        padding: 0 !important;
        margin-top: 6px !important;
    }
    .alert-dropdown-header {
        padding: 14px 16px 10px;
        border-bottom: 1px solid #f1f3f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .alert-dropdown-header .title {
        font-size: 13px;
        font-weight: 700;
        color: #1a1a3e;
    }
    .alert-dropdown-header .subtitle {
        font-size: 11px;
        color: #6c757d;
    }
    .alert-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 16px;
        border-bottom: 1px solid #f8f9fa;
        text-decoration: none !important;
        transition: background 0.12s;
    }
    .alert-item:last-child { border-bottom: none; }
    .alert-item:hover { background: #f8f9fa; }
    .alert-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .alert-dot.danger  { background: #dc3545; }
    .alert-dot.warning { background: #f59e0b; }
    .alert-body { flex: 1; min-width: 0; }
    .alert-name {
        font-size: 12px;
        font-weight: 600;
        color: #1a1a3e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .alert-meta {
        font-size: 11px;
        color: #6c757d;
        margin-top: 1px;
    }
    .alert-pct {
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .alert-pct.danger  { color: #dc3545; }
    .alert-pct.warning { color: #f59e0b; }
    .alert-empty {
        padding: 24px 16px;
        text-align: center;
        color: #6c757d;
        font-size: 13px;
    }
    .alert-empty i { font-size: 24px; color: #198754; display: block; margin-bottom: 8px; }
    .alert-footer {
        padding: 10px 16px;
        border-top: 1px solid #f1f3f5;
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        color: #6c5ce7;
        cursor: pointer;
    }
    .alert-footer:hover { background: #f8f9fa; }
</style>

<div class="main-header">
    <div class="main-header-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="assets/img/kaiadmin/icon.svg" alt="navbar brand" class="navbar-brand" height="40" />
                <span style="font-size:35px;font-weight:bolder;color:white;margin-left:10px">TAC-GH</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <span class="fw-bold">Home</span>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                {{-- ── Budget Alert Bell ── --}}
                @php
                    $dangerCount  = isset($budgetAlerts) ? $budgetAlerts->where('level','danger')->count()  : 0;
                    $warningCount = isset($budgetAlerts) ? $budgetAlerts->where('level','warning')->count() : 0;
                    $totalAlerts  = isset($budgetAlerts) ? $budgetAlerts->count() : 0;
                    $badgeLevel   = $dangerCount > 0 ? 'danger' : 'warning';
                @endphp

                <li class="nav-item alert-bell-wrap dropdown hidden-caret">
                    <a href="#" class="alert-bell-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Budget Alerts">
                        <i class="fas fa-bell"></i>
                        @if($totalAlerts > 0)
                            <span class="alert-badge {{ $badgeLevel }}">{{ $totalAlerts > 9 ? '9+' : $totalAlerts }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu alert-dropdown animated fadeIn">
                        <div class="alert-dropdown-header">
                            <div>
                                <div class="title">Budget Alerts</div>
                                <div class="subtitle">
                                    @if($totalAlerts > 0)
                                        {{ $totalAlerts }} line{{ $totalAlerts != 1 ? 's' : '' }} need attention
                                    @else
                                        All budget lines are healthy
                                    @endif
                                </div>
                            </div>
                            @if($dangerCount > 0)
                                <span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;background:#fef2f2;color:#b91c1c">
                                    {{ $dangerCount }} over budget
                                </span>
                            @endif
                        </div>

                        @forelse(isset($budgetAlerts) ? $budgetAlerts->take(8) : collect() as $alert)
                            <div class="alert-item">
                                <span class="alert-dot {{ $alert['level'] }}"></span>
                                <div class="alert-body">
                                    <div class="alert-name" title="{{ $alert['name'] }}">{{ $alert['name'] }}</div>
                                    <div class="alert-meta">
                                        {{ $alert['department'] }}
                                        &nbsp;&bull;&nbsp;
                                        {{ $alert['level'] === 'danger' ? 'Over budget' : 'Near limit' }}
                                    </div>
                                </div>
                                <span class="alert-pct {{ $alert['level'] }}">{{ $alert['pct'] }}%</span>
                            </div>
                        @empty
                            <div class="alert-empty">
                                <i class="fas fa-check-circle"></i>
                                All budget lines are within safe limits
                            </div>
                        @endforelse

                        @if($totalAlerts > 8)
                            <div class="alert-footer">
                                + {{ $totalAlerts - 8 }} more — view full report
                            </div>
                        @endif
                    </div>
                </li>

                {{-- ── User dropdown ── --}}
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ Auth()->user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </div>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</div>
