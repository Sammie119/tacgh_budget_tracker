@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div
                class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5><b>Total Allocation</b></h5>
                                    <p class="text-muted">Total Budget Allocation</p>
                                </div>
                                <h3 class="text-info fw-bold">GHS {{ number_format($total_allocation, 2) }}</h3>
                            </div>
                            <div class="progress progress-sm" role="progressbar" aria-label="Default striped example" aria-valuenow="{{ 100 - $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped bg-info" style="width: {{ 100 - $percentage }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <p class="text-muted mb-0">Percentage</p>
                                <p class="text-muted mb-0">{{ 100 - $percentage }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5><b>Total Request</b></h5>
                                    <p class="text-muted">Total Amt. Request</p>
                                </div>
                                <h3 class="text-success fw-bold">GHS {{ number_format($amount_used, 2) }}</h3>
                            </div>
                            <div class="progress progress-sm" role="progressbar" aria-label="Default striped example" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped bg-success" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <p class="text-muted mb-0">Percentage</p>
                                <p class="text-muted mb-0">{{ $percentage }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Top 10 Budget Allocation for {{ \App\Models\BudgetHeader::find($header_id)->name }}</div>
                </div>
                <div class="card-body">
                    <table class="table table-head-bg-success">
                        <thead>
                            <tr>
                                <th style="width: 20px" class="no-sort">#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Amt. Allocated</th>
                                <th>Amt. Requested</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top10budgets as $key => $budget)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $budget->name }}</td>
                                    <td>{{ \App\Models\Department::find($budget->department_id)->name }}</td>
                                    <td>{{ \App\Models\Category::find($budget->category_id)->name }}</td>
                                    <td>{{ number_format($budget->amount, 2) }}</td>
                                    <td>{{ number_format($budget->amount_used, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
