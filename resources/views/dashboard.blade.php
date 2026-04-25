@extends('layouts.app')

@section('content')
    <style>
        /* ── KPI Cards ── */
        .kpi-card {
            border: none;
            border-radius: 16px;
            padding: 24px 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            transition: transform 0.18s, box-shadow 0.18s;
            height: 100%;
        }
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.11);
        }
        .kpi-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .kpi-icon.blue   { background: rgba(13,110,253,0.12);  color: #0d6efd; }
        .kpi-icon.green  { background: rgba(25,135,84,0.12);   color: #198754; }
        .kpi-icon.amber  { background: rgba(255,193,7,0.15);   color: #d4a000; }
        .kpi-icon.red    { background: rgba(220,53,69,0.12);   color: #dc3545; }
        .kpi-icon.purple { background: rgba(108,92,231,0.12);  color: #6c5ce7; }
        .kpi-icon.teal   { background: rgba(13,202,240,0.12);  color: #0dcaf0; }

        .kpi-body { flex: 1; min-width: 0; }
        .kpi-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #6c757d;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a3e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .kpi-sub {
            font-size: 12px;
            color: #adb5bd;
            margin-top: 2px;
        }

        /* ── Section headers ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a3e;
        }
        .section-badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ── Chart card ── */
        .chart-wrapper {
            position: relative;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chart-center-label {
            position: absolute;
            text-align: center;
            pointer-events: none;
        }
        .chart-center-label .pct {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a3e;
            line-height: 1;
        }
        .chart-center-label .pct-label {
            font-size: 11px;
            color: #adb5bd;
            margin-top: 2px;
        }
        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
            padding-left: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }
        .legend-dot {
            width: 12px; height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .legend-val { font-weight: 700; color: #1a1a3e; }
        .legend-lbl { color: #6c757d; font-size: 12px; }

        /* ── Table improvements ── */
        .dash-table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #6c757d;
            border-bottom: 2px solid #f1f3f5;
            padding: 10px 12px;
        }
        .dash-table td {
            font-size: 13px;
            vertical-align: middle;
            padding: 10px 12px;
            color: #343a40;
            border-bottom: 1px solid #f8f9fa;
        }
        .dash-table tr:last-child td { border-bottom: none; }

        .util-bar-wrap {
            width: 100px;
            background: #f1f3f5;
            border-radius: 4px;
            height: 6px;
            overflow: hidden;
        }
        .util-bar {
            height: 100%;
            border-radius: 4px;
            background: #0d6efd;
        }
        .util-bar.warning { background: #ffc107; }
        .util-bar.danger  { background: #dc3545; }

        .overspend-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            background: #fff3cd;
            color: #856404;
        }
        .overspend-badge.danger {
            background: #f8d7da;
            color: #842029;
        }
    </style>

    <div class="container">
        <div class="page-inner">

            {{-- ── Page header ── --}}
            <div class="d-flex align-items-center justify-content-between pt-2 pb-4 flex-wrap gap-2">
                <div>
                    <h3 class="fw-bold mb-1">Dashboard</h3>
                    <p class="text-muted mb-0" style="font-size:13px">
                        <i class="fas fa-layer-group me-1"></i>
                        Active Budget: <strong>{{ $header_name }}</strong>
                    </p>
                </div>
                <a href="{{ route('reports') }}" class="btn btn-primary btn-sm">
                    <i class="far fa-chart-bar me-1"></i> View Reports
                </a>
            </div>

            {{-- ── KPI Cards ── --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-4">
                    <div class="kpi-card bg-white">
                        <div class="kpi-icon blue"><i class="fas fa-wallet"></i></div>
                        <div class="kpi-body">
                            <div class="kpi-label">Total Budget</div>
                            <div class="kpi-value" title="GHS {{ number_format($total_allocation, 2) }}">
                                GHS {{ number_format($total_allocation, 0) }}
                            </div>
                            <div class="kpi-sub">Allocated</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="kpi-card bg-white">
                        <div class="kpi-icon green"><i class="fas fa-coins"></i></div>
                        <div class="kpi-body">
                            <div class="kpi-label">Total Spent</div>
                            <div class="kpi-value" title="GHS {{ number_format($amount_used, 2) }}">
                                GHS {{ number_format($amount_used, 0) }}
                            </div>
                            <div class="kpi-sub">{{ $percentage }}% utilised</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="kpi-card bg-white">
                        <div class="kpi-icon {{ $total_remaining >= 0 ? 'teal' : 'red' }}">
                            <i class="fas fa-{{ $total_remaining >= 0 ? 'piggy-bank' : 'exclamation-triangle' }}"></i>
                        </div>
                        <div class="kpi-body">
                            <div class="kpi-label">Remaining</div>
                            <div class="kpi-value {{ $total_remaining < 0 ? 'text-danger' : '' }}" title="GHS {{ number_format($total_remaining, 2) }}">
                                GHS {{ number_format($total_remaining, 0) }}
                            </div>
                            <div class="kpi-sub">{{ $total_remaining >= 0 ? 'Available' : 'Overspent' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="kpi-card bg-white">
                        <div class="kpi-icon amber"><i class="fas fa-file-invoice"></i></div>
                        <div class="kpi-body">
                            <div class="kpi-label">Amt. Requested</div>
                            <div class="kpi-value" title="GHS {{ number_format($amount_requested, 2) }}">
                                GHS {{ number_format($amount_requested, 0) }}
                            </div>
                            <div class="kpi-sub">Total requests</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="kpi-card bg-white">
                        <div class="kpi-icon purple"><i class="fas fa-list-check"></i></div>
                        <div class="kpi-body">
                            <div class="kpi-label">Budget Lines</div>
                            <div class="kpi-value">{{ number_format($total_entries) }}</div>
                            <div class="kpi-sub">Active entries</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="kpi-card bg-white">
                        <div class="kpi-icon red"><i class="fas fa-triangle-exclamation"></i></div>
                        <div class="kpi-body">
                            <div class="kpi-label">Over Budget</div>
                            <div class="kpi-value {{ $overspend_count > 0 ? 'text-danger' : '' }}">{{ $overspend_count }}</div>
                            <div class="kpi-sub">Lines overspent</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Chart + Top 5 ── --}}
            <div class="row g-3 mb-3">

                {{-- Donut chart --}}
                <div class="col-md-4">
                    <div class="card h-100" style="border-radius:16px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07)">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div class="section-header mb-3">
                                <span class="section-title">Budget Utilisation</span>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <div class="chart-wrapper">
                                        <canvas id="utilizationChart" height="200"></canvas>
                                        <div class="chart-center-label">
                                            <div class="pct">{{ $percentage }}%</div>
                                            <div class="pct-label">Spent</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="chart-legend">
                                        <div class="legend-item">
                                            <div class="legend-dot" style="background:#0d6efd"></div>
                                            <div>
                                                <div class="legend-val">{{ $percentage }}%</div>
                                                <div class="legend-lbl">Spent</div>
                                            </div>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-dot" style="background:#e9ecef"></div>
                                            <div>
                                                <div class="legend-val">{{ round(100 - $percentage, 2) }}%</div>
                                                <div class="legend-lbl">Remaining</div>
                                            </div>
                                        </div>
                                        @if($overspend_count > 0)
                                            <div class="legend-item">
                                                <div class="legend-dot" style="background:#dc3545"></div>
                                                <div>
                                                    <div class="legend-val">{{ $overspend_count }}</div>
                                                    <div class="legend-lbl">Lines over</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- mini progress bars --}}
                            <hr class="my-3">
                            <div style="font-size:12px; color:#6c757d; margin-bottom:6px">Spending Breakdown</div>
                            <div class="d-flex justify-content-between mb-1" style="font-size:12px">
                                <span>Requested</span>
                                <span class="fw-bold">GHS {{ number_format($amount_requested, 0) }}</span>
                            </div>
                            <div class="progress mb-2" style="height:6px; border-radius:4px">
                                @php $reqPct = $total_allocation > 0 ? min(($amount_requested/$total_allocation)*100, 100) : 0; @endphp
                                <div class="progress-bar bg-warning" style="width:{{ $reqPct }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mb-1" style="font-size:12px">
                                <span>Spent</span>
                                <span class="fw-bold">GHS {{ number_format($amount_used, 0) }}</span>
                            </div>
                            <div class="progress" style="height:6px; border-radius:4px">
                                <div class="progress-bar bg-primary" style="width:{{ min($percentage,100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top 5 by allocation --}}
                <div class="col-md-8">
                    <div class="card h-100" style="border-radius:16px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07)">
                        <div class="card-body">
                            <div class="section-header mb-3">
                                <span class="section-title">Top 5 Budget Lines &mdash; {{ $header_name }}</span>
                                <span class="section-badge badge bg-primary-subtle text-primary">By Allocation</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table dash-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Budget Entry</th>
                                        <th>Department</th>
                                        <th>Category</th>
                                        <th>Allocated</th>
                                        <th>Spent</th>
                                        <th>Utilisation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($top10budgets as $key => $budget)
                                        @php
                                            $util = $budget->amount > 0 ? round(($budget->amount_used / $budget->amount) * 100, 1) : 0;
                                            $barClass = $util >= 100 ? 'danger' : ($util >= 80 ? 'warning' : '');
                                        @endphp
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td><span class="fw-semibold">{{ $budget->name }}</span></td>
                                            <td>{{ $budget->department->name ?? 'N/A' }}</td>
                                            <td>{{ $budget->category->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($budget->amount, 2) }}</td>
                                            <td>{{ number_format($budget->amount_used, 2) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="util-bar-wrap">
                                                        <div class="util-bar {{ $barClass }}" style="width:{{ min($util, 100) }}%"></div>
                                                    </div>
                                                    <span style="font-size:11px; color:#6c757d">{{ $util }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Overspending table ── --}}
            <div class="card" style="border-radius:16px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.07); margin-bottom: 30px;">
                <div class="card-body">
                    <div class="section-header mb-3">
                    <span class="section-title">
                        <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                        Over-Budget Lines &mdash; {{ $header_name }}
                    </span>
                        @if($overspend_count > 0)
                            <span class="section-badge badge bg-danger-subtle text-danger">{{ $overspend_count }} line{{ $overspend_count != 1 ? 's' : '' }}</span>
                        @else
                            <span class="section-badge badge bg-success-subtle text-success">All within budget</span>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dash-table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Budget Entry</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Allocated</th>
                                <th>Spent</th>
                                <th>Overrun</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($top5overspending as $key => $budget)
                                @php
                                    $overrun   = abs($budget->amount_remaining);
                                    $overrunPct = $budget->amount > 0 ? round(($overrun / $budget->amount) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><span class="fw-semibold">{{ $budget->name }}</span></td>
                                    <td>{{ $budget->department->name ?? 'N/A' }}</td>
                                    <td>{{ $budget->category->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($budget->amount, 2) }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($budget->amount_used, 2) }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($overrun, 2) }}</td>
                                    <td>
                                    <span class="overspend-badge {{ $overrunPct > 20 ? 'danger' : '' }}">
                                        +{{ $overrunPct }}% over
                                    </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-muted">No over-budget lines — great work!</span>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script>
        (function () {
            const spent     = {{ $percentage }};
            const remaining = Math.max(0, 100 - spent);
            const ctx       = document.getElementById('utilizationChart').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [spent, remaining],
                        backgroundColor: [
                            spent >= 100 ? '#dc3545' : (spent >= 80 ? '#ffc107' : '#0d6efd'),
                            '#e9ecef'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4,
                    }]
                },
                options: {
                    cutout: '72%',
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    animation: { animateRotate: true, duration: 900 }
                }
            });
        })();
    </script>
@endsection
