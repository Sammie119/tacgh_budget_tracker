<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9">
                        <h4 class="card-title">{{ $header['header_name'] }}</h4>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('export',['categoryReport', $header['header_name']]) }}" class="btn btn-success btn-sm float-end" style="margin-left: 5px; margin-right: 5px"><span><i class="fas fa-file-excel"></i> EXCEL</span></a>
                        <a href="{{ route('export_pdf',['categoryReport', $header['header_name']]) }}" class="btn btn-danger btn-sm float-end" style="margin-left: 5px; margin-right: 5px"><span><i class="fas fa-file-pdf"></i> PDF</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                    >
                        <thead>
                        <tr>
                            <th style="width: 20px" class="no-sort">#</th>
                            <th>Date</th>
                            <th>Budget Entry</th>
                            <th>Department</th>
                            <th>Amt. Allocated</th>
                            <th>Amt. Requested</th>
                            <th>Amt. Spent</th>
                            <th>Variance</th>
                            <th>%</th>
                        </tr>
                        </thead>
                        @php
                            $total_amount = 0;
                            $total_amount_requested = 0;
                            $total_amount_spent = 0;
                            $total_variance = 0;
                            $total_percentage = 0;
                            $data_array = [];
                        @endphp
                        <tbody>
                        @forelse($results as $key => $result)
                            @php
                                $total_amount += $result->amount;
                                $total_amount_requested += $result->amount_requested;
                                $total_amount_spent += $result->amount_used;
                                $total_variance += $result->amount - $result->amount_used;
                                $total_percentage += 0;

                                $data_array[] = [
                                    'date' => $result->created_at->format('d-M-Y'),
                                    'budget_entry' => $result->name,
                                    'department' => \App\Models\Department::find($result->department_id)->name,
                                    'amount' => $result->amount,
                                    'amount_requested' => $result->amount_requested,
                                    'amount_used' => $result->amount_used,
                                    'variance' => $result->amount - $result->amount_used,
                                    'percentage' => ($result->amount > 0) ? (($result->amount_used/$result->amount) * 100)."%" : '0%'
                                ];
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td nowrap>{{ $result->created_at->format('d-M-Y') }}</td>
                                <td>{{ $result->name }}</td>
                                <td>{{ \App\Models\Department::find($result->department_id)->name }}</td>
                                <td>{{ number_format($result->amount, 2) }}</td>
                                <td>{{ number_format($result->amount_requested, 2) }}</td>
                                <td>{{ number_format($result->amount_used, 2) }}</td>
                                <td>{{ number_format(($result->amount - $result->amount_used), 2) }}</td>
                                <td>{{ ($result->amount > 0) ? round(($result->amount_used/$result->amount) * 100, 2) : 0 }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="50">No Data Found</td>
                            </tr>
                        @endforelse
                        @php
                            Illuminate\Support\Facades\Cache::put('category_report', collect($data_array), now()->addHours(3));
                        @endphp
                        <tr>
                            <th colspan="4">Total</th>
                            <th>{{ number_format($total_amount, 2) }}</th>
                            <th>{{ number_format($total_amount_requested, 2) }}</th>
                            <th>{{ number_format($total_amount_spent, 2) }}</th>
                            <th>{{ number_format($total_variance, 2) }}</th>
                            <th>{{ ($result->amount > 0) ? round(($total_amount_spent/$total_amount) * 100, 2) : 0 }}%</th>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
