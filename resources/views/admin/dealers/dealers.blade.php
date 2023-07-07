@extends('admin.layouts.admin-layout')

@section('title', 'Dealers')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dealers</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dealers</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('dealers.create') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div>


    {{-- Category Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Error Message Section --}}
            {{-- @if (session()->has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif --}}

            {{-- Success Message Section --}}
            {{-- @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif --}}

            {{-- Categories Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="DealersTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Logo</th>
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
        $(function() {

            // Toastr Options
            toastr.options =
            {
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
            
            var table = $('#DealersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('dealers.load') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'logo',
                        name: 'logo'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });

        function changeStatus(status, id) {
            $.ajax({
                type: "POST",
                url: '{{ route('dealers.status') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status,
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
        // Function for Delete Table
        function deleteDealer(dealerId) {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDeleteDealer) => {
                    if (willDeleteDealer) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('dealers.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': dealerId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                    toastr.success(response.message);
                                    $('#DealersTable').DataTable().ajax.reload();
                                } else {
                                    swal(response.message, "", "error");
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        }
    </script>

@endsection
