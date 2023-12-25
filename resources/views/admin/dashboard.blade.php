@extends('admin.layouts.admin-layout')
@section('title', 'DASHBOARD - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- Dashboard Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('categories.index') }}">Categories</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-list"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_categories + $inactive_categories }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_categories }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_categories }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('tags.index') }}">Tags</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-tags"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_tags + $inactive_tags }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_tags }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_tags }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('designs.index') }}">Designs</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-pencil"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_designs + $inactive_designs }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_designs }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_designs }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('pages.index') }}">Pages</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-file-text"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_pages + $inactive_pages }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_pages }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_pages }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;">Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_orders + $inactive_orders }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_orders }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_orders }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('users.index') }}">Users</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_users + $inactive_users }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_users }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_users }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('dealers.index') }}">Dealers</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_dealers + $inactive_dealers }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_dealers }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_dealers }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title" style="padding: 5px; margin: 5px;"><a href="{{ route('customers.index') }}">Customers</a></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $active_customers + $inactive_customers }} </h6>
                                        <span class="text-success small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Active</span> ({{ $active_customers }})</span> <br>
                                        <span class="text-danger small pt-1 fw-bold"><span class="text-muted small pt-2 ps-1">Inactive</span> ({{ $inactive_customers }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">
    </script>

@endsection
