@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers - Pages')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Pages</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pages</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- Pages Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                <a href="{{ route('pages.create') }}" class="btn btn-sm custom-btn"><i class="bi bi-plus"></i></a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <table class="table w-100" id="pagesTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
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

        getPages();

        // Function for get all Pages
        function getPages(){

            var customerTable = $('#pagesTable').DataTable();
            customerTable.destroy();
            customerTable = $('#pagesTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                "ajax" : {
                    "url":"{{ route('pages.load') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name',
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
        }

        // Function for change status of Page
        function changeStatus(id) {
            toastr.clear();
            $.ajax({
                type: "POST",
                url: "{{ route('pages.status') }}",
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

        // Function for Delete Page
        function deletePage(id){
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeletePage) =>
            {
                if (willDeletePage){
                    $.ajax(
                    {
                        type: "POST",
                        url: "{{ route('pages.destroy') }}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        dataType: 'JSON',
                        success: function(response)
                        {
                            if (response.success == 1){
                                swal(response.message, "", "success");
                                $('#pagesTable').DataTable().ajax.reload();
                            }else{
                                swal(response.message, "", "error");
                            }
                        }
                    });
                }else{
                    swal("Cancelled", "", "error");
                }
            });
        }

    </script>

@endsection
