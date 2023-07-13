@extends('admin.layouts.admin-layout')

@section('title', 'Dashboard')

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
            {{-- Errors Message --}}
            @if (session()->has('errors'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="row">
                    <!-- Categories Card -->
                    <div class="col-md-3">
                        <div class="info_card">
                            <div class="info_card_inr">
                                <h5> Total Categories </h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <!-- <i class="bi bi-layout-text-window-reverse"></i> -->
                                        <i class="fa-solid fa-list-alt"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h4><b> {{ $total_categories }} </b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Designs Card -->
                    <div class="col-md-3">
                        <div class="info_card">
                            <div class="info_card_inr">
                                <h5> Total Designs</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-pencil-ruler"></i>
                                    </div>
                                    <div class="ps-3">
                                    <h4><b> {{ $total_sliders }} </b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delers Card -->
                    <div class="col-md-3">
                        <div class="info_card">
                            <div class="info_card_inr">
                                <h5 > Total Dealers</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <div class="ps-3">
                                    <h4><b> {{ $total_dealers }} </b></h4>
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

        toastr.options = 
        {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            timeOut: 10000
        }

        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif

        // @if (Session::has('error'))
        //     toastr.error('{{ Session::get('error') }}')
        // @endif

    </script>

@endsection
