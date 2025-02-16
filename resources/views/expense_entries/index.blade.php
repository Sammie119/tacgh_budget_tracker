@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="page-header">
                <h3 class="fw-bold mb-3">Expense Management</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Expense Management</a>
                    </li>
                </ul>
            </div>

            <x-notifications :messages="$errors->all()"/>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9">
                                    <h4 class="card-title">Expense Entries</h4>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Add New Expense Entry" data-bs-url="form_create/createExpenseEntry" data-bs-size="modal-lg"><span class="btn-label"><i class="fas fa-plus"></i> New Entry</span></button>
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
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Category</th>
                                            <th>B. Header</th>
                                            <th>Amount</th>
                                            <th style="width: 140px" class="no-sort">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($expense_entries as $key => $expense)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $expense->name }}</td>
                                                <td>{{ \App\Models\Department::find($expense->department_id)->name }}</td>
                                                <td>{{ \App\Models\Category::find($expense->category_id)->name }}</td>
                                                <td>{{ \App\Models\BudgetEntry::find($expense->budget_entry_id)->name }}</td>
                                                <td>{{ number_format($expense->amount_requested, 2) }}</td>
                                                <td nowrap>
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="View Expense Details" data-bs-url="form_view/viewExpenseEntry/{{ $expense->id }}" data-bs-size="modal-lg"><span class="btn-label"><i class="fas fa-table"></i></span></button>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Edit Expense Details" data-bs-url="form_edit/editExpenseEntry/{{ $expense->id }}" data-bs-size="modal-lg"><span class="btn-label"><i class="far fa-edit"></i></span></button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Confirm Deletion" data-bs-url="form_delete/deleteExpenseEntry/{{ $expense->id }}" data-bs-size=""><span class="btn-label"><i class="fas fa-trash-alt"></i></span></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="50">No Data Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-call-modal />
@endsection

@section('script')
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#basic-datatables").DataTable({
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                    "searchable": false,
                } ]
            });
        });
    </script>
@endsection
