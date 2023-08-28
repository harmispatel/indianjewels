@extends('admin.layouts.admin-layout')

@section('title', 'Dealers')

@section('content')

@php
$role = Auth::guard('admin')->user()->user_type;
$dealer_add = Spatie\Permission\Models\Permission::where('name','dealers.create')->first();

$permissions = App\Models\RoleHasPermissions::where('role_id',$role)->pluck('permission_id');  
    foreach ($permissions as $permission) {
        $permission_ids[] = $permission;
    }
@endphp
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
                @if((in_array($dealer_add->id, $permission_ids))) 
                <a href="{{ route('dealers.create') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
                @else
                {{-- <a href="{{ route('dealers.create') }}" class="btn btn-sm new-category custom-btn disabled">
                    <i class="bi bi-plus-lg"></i>
                </a> --}}
                @endif
            </div>
        </div>
    </div>


    {{-- Category Section --}}
    <section class="section dashboard">
        <div class="row">
            

            {{-- Categories Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                        </div>
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="DealersTable">
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
                        name: 'status',
                        orderable: false,
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
