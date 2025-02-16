{{--{{ dd($budget) }}--}}
<div class="card">
    <div class="card-header">
        <div class="card-title">{{ $budget->name }} ({{ \App\Models\BudgetHeader::find($budget->header_id)->name }})</div>
    </div>
    <div class="card-body">
        <table class="table table-head-bg-success">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item</th>
                    <th scope="col">Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Name</td>
                    <td>{{ $budget->name }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Description</td>
                    <td>{{ $budget->description }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Department</td>
                    <td>{{ \App\Models\Department::find($budget->department_id)->name }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Category</td>
                    <td>{{ \App\Models\Category::find($budget->category_id)->name }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Budget Header</td>
                    <td>{{ \App\Models\BudgetHeader::find($budget->header_id)->name }}</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Budgeted Amount</td>
                    <td>{{ number_format($budget->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Status</td>
                    <td>{{ ($budget->status === 1) ? 'Active' : (($budget->status === 2) ? 'Completed' : 'Inactive') }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-head-bg-primary mt-4">
            <div style="text-align: center">
                <h3>Expenses on this Budget Allocation</h3>
            </div>

            <thead>
                <tr>
                    <th scope="col" style="width: 5px;">#</th>
                    <th scope="col" style="text-align: left">Name</th>
                    <th scope="col" style="text-align: right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @forelse($expenses as $key => $expense)
                    @php
                        $total += $expense->amount_requested;
                    @endphp
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td style="text-align: left">{{ $expense->name }}</td>
                        <td style="text-align: right">{{ number_format($expense->amount_requested, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No Data Found</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th style="text-align: right">{{ number_format($total, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="2">Amount Remaining</th>
                    <th colspan="2" style="text-align: right">{{ number_format(($budget->amount - $total), 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
