@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="page-header">
                <h3 class="fw-bold mb-3">Budget Headers</h3>
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
                        <a href="#">Budget Headers</a>
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
                                    <h4 class="card-title">Budget Headers List</h4>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Add Budget Header" data-bs-url="form_create/createBudgetHeader" data-bs-size="modal-lg"><span class="btn-label"><i class="fas fa-plus"></i> New Budget Header</span></button>
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
                                            <th>Description</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th style="width: 100px" class="no-sort">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($budget_headers as $key => $budget_header)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $budget_header->name }}</td>
                                                <td>{{ $budget_header->description }}</td>
                                                <td>{{ date_format(date_create($budget_header->start_date),'d-M-Y') }}</td>
                                                <td>{{ date_format(date_create($budget_header->end_date),'d-M-Y') }}</td>
                                                <td>{{ ($budget_header->status === 1) ? 'Active' : (($budget_header->status === 2) ? 'Completed' : 'Inactive') }}</td>
                                                <td nowrap>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Edit Budget Header Details" data-bs-url="form_edit/editBudgetHeader/{{ $budget_header->id }}" data-bs-size="modal-lg"><span class="btn-label"><i class="far fa-edit"></i></span></button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Confirm Deletion" data-bs-url="form_delete/deleteBudgetHeader/{{ $budget_header->id }}" data-bs-size=""><span class="btn-label"><i class="fas fa-trash-alt"></i></span></button>
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
