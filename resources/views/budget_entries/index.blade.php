@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="page-header">
                <h3 class="fw-bold mb-3">Budget Management</h3>
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
                        <a href="#">Budget Management</a>
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
                                    <h4 class="card-title">Budget Entries</h4>
                                </div>
                                <div class="col-3">
                                    @if(in_array(Auth()->user()->is_admin, perm_arrays('management')))
                                        <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Add New Budget Entry" data-bs-url="form_create/createBudgetEntry" data-bs-size="modal-lg"><span class="btn-label"><i class="fas fa-plus"></i> New Entry</span></button>
                                    @endif
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
                                            <th>Ref</th>
                                            <th style="width: 140px" class="no-sort">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($budget_entries as $key => $budget)
                                            @php
                                                $ref = "TBT".sprintf("%06d", $budget->id);
                                            @endphp
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $budget->name }}</td>
                                                <td>{{ \App\Models\Department::find($budget->department_id)->name }}</td>
                                                <td>{{ \App\Models\Category::find($budget->category_id)->name }}</td>
                                                <td>{{ \App\Models\BudgetHeader::find($budget->header_id)->name }}</td>
                                                <td>{{ number_format($budget->amount, 2) }}</td>
                                                <td>{{ $ref }}</td>
                                                <td nowrap>
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="View Budget Details" data-bs-url="form_view/viewBudgetEntry/{{ $budget->id }}" data-bs-size="modal-lg"><span class="btn-label"><i class="fas fa-table"></i></span></button>
                                                    @if(in_array(Auth()->user()->is_admin, perm_arrays('management')))
                                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Edit Budget Details" data-bs-url="form_edit/editBudgetEntry/{{ $budget->id }}" data-bs-size="modal-lg"><span class="btn-label"><i class="far fa-edit"></i></span></button>
                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Confirm Deletion" data-bs-url="form_delete/deleteBudgetEntry/{{ $budget->id }}" data-bs-size=""><span class="btn-label"><i class="fas fa-trash-alt"></i></span></button>
                                                    @endif
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
