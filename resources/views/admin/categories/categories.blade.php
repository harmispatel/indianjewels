@extends('admin.layouts.admin-layout')

@section('title', __('Categories'))

@section('content')

{{-- Page Title --}}
    <div class="pagetitle">
        <h1>Categories</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('categories.add-category') }}" class="btn btn-sm new-category btn-primary">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Category Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Error Message Section --}}
            @if (session()->has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Success Message Section --}}
            @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
     
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Image</th>
                                <!-- <th>Parent Category</th> -->
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
@endsection

{{-- Custom Script --}}
@section('page-js')

    <script type="text/javascript">
        // Dcoument
        $(document).ready(function()
        {
            // Toastr Options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                timeOut: 10000
            }
        });

         // Load all Categories Records
         loadCategories();
        // Function for get all Categories Records.
        function loadCategories()
        {
            // Assign Categories Table to Variable;
            var categoriesTable = $('#categoriesTable').DataTable();

            // Destroy old Data
            categoriesTable.destroy();

            // ReGenerate Amenties Table
            categoriesTable = $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.load-categories') }}",
                order: [0, 'desc'],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions'},
                ]
            });
        }
    </script>

@endsection