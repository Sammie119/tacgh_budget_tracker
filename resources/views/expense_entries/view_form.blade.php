{{--{{ dd($expenses) }}--}}
<div class="card">
    <div class="card-header">
        <div class="card-title">{{ $expenses->name }}</div>
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
                    <td>{{ $expenses->name }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Description</td>
                    <td>{{ $expenses->description }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Department</td>
                    <td>{{ \App\Models\Department::find($expenses->department_id)->name }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Category</td>
                    <td>{{ \App\Models\Category::find($expenses->category_id)->name }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Budget Header</td>
                    <td>{{ \App\Models\BudgetHeader::find($expenses->header_id)->name }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Budget Header</td>
                    <td>{{ \App\Models\BudgetEntry::find($expenses->budget_entry_id)->name }}</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Budgeted Amount</td>
                    <td>{{ number_format($expenses->amount_budgeted, 2) }}</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Amount Requested</td>
                    <td>{{ number_format($expenses->amount_requested, 2) }}</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Status</td>
                    <td>{{ ($expenses->status === 1) ? 'Active' : (($expenses->status === 2) ? 'Completed' : 'Inactive') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
