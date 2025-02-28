@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="page-header">
                <h3 class="fw-bold mb-3">Reports</h3>
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
                        <a href="#">Reports</a>
                    </li>
                </ul>
            </div>

            <x-notifications :messages="$errors->all()"/>

            <div class="row">
                <div class="col-md-4">
                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Reports" data-bs-url="form_create/createCategoryReport" data-bs-size="">
                        <div class="card card-secondary">
                            <div class="card-body skew-shadow">
                                <h1>Budget</h1>
                                <h5 class="op-8">Category Report</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary bg-secondary-gradient">
                        <div class="card-body bubble-shadow">
                            <h1>188</h1>
                            <h5 class="op-8">Total Sales</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary bg-secondary-gradient">
                        <div class="card-body curves-shadow">
                            <h1>12</h1>
                            <h5 class="op-8">New Users</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <x-call-modal />
@endsection
