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
                <x-report-cards
                    url="createCategoryReport"
                    color="card-secondary"
                    name="Category"
                />

                <x-report-cards
                    url="createDepartmentalReport"
                    color="card-secondary bg-secondary-gradient"
                    name="Directorate/Unit"
                />

                <x-report-cards
                    url="createCategoryReport"
                    color="card-secondary bg-secondary-gradient"
                    name="N/A"
                />
            </div>

        </div>
    </div>

    <x-call-modal />
@endsection
