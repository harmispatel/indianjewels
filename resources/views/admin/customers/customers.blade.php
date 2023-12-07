@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers | Customers')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Customers</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- Customers Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select name="verification_filter" id="verification_filter" class="form-select">
                                    <option value="">Filter By Verification</option>
                                    <option value="2">Verified</option>
                                    <option value="1">Unverified</option>
                                    <option value="3">Registerd</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="customersTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Verification</th>
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
        </div>
    </section>

@endsection


{{-- Custom Script --}}
@section('page-js')

    <script type="text/javascript">

        // Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": 10000
        }
        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}')
        @endif

        $(document).ready(function () {
            getCustomers($('#verification_filter :selected').val());
        });

        // Filter Records by Verification
        $('#verification_filter').on('change', function(){
            getCustomers($(this).val());
        });

        // Function for get all Customers
        function getCustomers(verificationFilter)
        {
            var customerTable = $('#customersTable').DataTable();
            customerTable.destroy();
            customerTable = $('#customersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                "ajax" : {
                    "url":"{{ route('customers.load') }}",
                    "dataType": "json",
                    "type" :"POST",
                    "data" :{
                        '_token' : "{{ csrf_token() }}",
                        'verification_filter':verificationFilter,
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        orderable: false,
                    },
                    {
                        data: 'verification',
                        name: 'verification',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }

        // Function for change status of Customer
        function changeStatus(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('customers.status') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == 1) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        }

    </script>

@endsection
