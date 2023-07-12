@extends('admin.layouts.admin-layout')

@section('title', 'Designs')

@section('content')

@php
$role = Auth::guard('admin')->user()->user_type;
$design_add = Spatie\Permission\Models\Permission::where('name','designs.create')->first();

$permissions = App\Models\RoleHasPermissions::where('role_id',$role)->pluck('permission_id');  
    foreach ($permissions as $permission) {
        $permission_ids[] = $permission;
    }
@endphp

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Designs</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Designs</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                @if((in_array($design_add->id, $permission_ids))) 
                <a href="{{ route('designs.create') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                    @else
                    <a href="{{ route('designs.create') }}" class="btn btn-sm new-category custom-btn disabled">
                        <i class="bi bi-plus-lg"></i>
                    @endif
                </a>
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
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="DesignTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Item Name</th>
                                        <th>Item Code</th>
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

            var table = $('#DesignTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('designs.load') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'changestatus',
                        name: 'changestatus',
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
                url: '{{ route('designs.status') }}',
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
        function deleteDesign(designId) {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDeleteDesigns) => {
                    if (willDeleteDesigns) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('designs.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': designId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                    toastr.success(response.message);
                                    $('#DesignTable').DataTable().ajax.reload();
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
