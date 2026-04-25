<style>
    .util-bar-wrap { background: #e9ecef; border-radius: 999px; height: 8px; min-width: 90px; overflow: hidden; }
    .util-bar      { height: 8px; border-radius: 999px; transition: width .3s ease; }
    .badge-on-track  { background: #d1fae5; color: #065f46; font-size: 11px; padding: 3px 9px; border-radius: 999px; font-weight: 600; }
    .badge-near-limit{ background: #fef3c7; color: #92400e; font-size: 11px; padding: 3px 9px; border-radius: 999px; font-weight: 600; }
    .badge-over-budget{ background: #fee2e2; color: #991b1b; font-size: 11px; padding: 3px 9px; border-radius: 999px; font-weight: 600; }
</style>

@php
    $total_amount      = 0;
    $total_spent       = 0;
    $export_cache_key  = 'utilisation_report';
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="card-title mb-0">{{ $header['header_name'] }}</h4>
                        @if(isset($header['threshold']) && $header['threshold'] > 0)
                            <small class="text-muted">Showing lines at ≥ {{ $header['threshold'] }}% utilisation</small>
                        @endif
                    </div>
                    <div class="col-3 text-end">
                        <a href="{{ route('export', ['utilisationReport', $header['header_name']]) }}"
                           class="btn btn-success btn-sm me-1">
                            <i class="fas fa-file-excel"></i> EXCEL
                        </a>
                        <a href="{{ route('export_pdf', ['utilisationReport', $header['header_name']]) }}"
                           class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="no-sort" style="width:30px">#</th>
                                <th>Category</th>
                                <th>Budget Entry</th>
                                <th>Department</th>
                                <th>Amt. Allocated</th>
                                <th>Amt. Spent</th>
                                <th>Remaining</th>
                                <th>Utilisation</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($results as $key => $entry)
                            @php
                                $pct       = $entry->utilisation_pct;
                                $total_amount += $entry->amount;
                                $total_spent  += $entry->amount_used;
                                $remaining     = $entry->amount - $entry->amount_used;
                                $barColor      = $pct >= 100 ? '#ef4444'
                                               : ($pct >= 80  ? '#f59e0b'
                                               : '#22c55e');
                                $statusBadge   = $pct >= 100 ? 'badge-over-budget'
                                               : ($pct >= 80  ? 'badge-near-limit'
                                               : 'badge-on-track');
                                $statusLabel   = $pct >= 100 ? 'Over Budget'
                                               : ($pct >= 80  ? 'Near Limit'
                                               : 'On Track');
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $entry->category->name ?? 'N/A' }}</td>
                                <td>{{ $entry->name }}</td>
                                <td>{{ $entry->department->name ?? 'N/A' }}</td>
                                <td>{{ number_format($entry->amount, 2) }}</td>
                                <td>{{ number_format($entry->amount_used, 2) }}</td>
                                <td class="{{ $remaining < 0 ? 'text-danger fw-bold' : '' }}">
                                    {{ number_format($remaining, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="util-bar-wrap flex-grow-1">
                                            <div class="util-bar" style="width:{{ min($pct, 100) }}%;background:{{ $barColor }}"></div>
                                        </div>
                                        <span style="font-size:12px;font-weight:700;color:{{ $barColor }};min-width:42px">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td><span class="{{ $statusBadge }}">{{ $statusLabel }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No budget lines found.</td></tr>
                        @endforelse
                        </tbody>
                        @if($results->count() > 0)
                        @php
                            $overall_pct = $total_amount > 0 ? round(($total_spent / $total_amount) * 100, 2) : 0;
                        @endphp
                        <tfoot>
                            <tr class="fw-bold">
                                <th colspan="4">Total ({{ $results->count() }} lines)</th>
                                <th>{{ number_format($total_amount, 2) }}</th>
                                <th>{{ number_format($total_spent, 2) }}</th>
                                <th>{{ number_format($total_amount - $total_spent, 2) }}</th>
                                <th>{{ $overall_pct }}% overall</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
