@extends('admin.layouts.admin-layout')

@section('title', __('Sliders'))

@section('content')

{{-- Page Title --}}
    <div class="pagetitle">
        <h1>Sliders</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sliders</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('sliders.add-slider') }}" class="btn btn-sm new-slider custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Slider Section --}}
    <section class="section dashboard">
        <div class="row">
           
     
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                
                <div class="table-responsive custom_dt_table">
                    <table class="table w-100" id="slidersTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Banner Text</th>
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
            toastr.options = 
            {
                "closeButton": true,
                "progressBar": true,
                timeOut: 10000
            }
        });

         // Load all Sliders Records
         loadSliders();
        // Function for get all Sliders Records.
        function loadSliders()
        {
            // Assign Sliders Table to Variable;
            var slidersTable = $('#slidersTable').DataTable();

            // Destroy old Data
            slidersTable.destroy();

            // ReGenerate Amenties Table
            slidersTable = $('#slidersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('sliders.load-sliders') }}",
                // order: [0, 'desc'],
                columns: [
                    {
                        data: 'id', 
                        name: 'id'
                    },
                    {
                        data: 'image', 
                        name: 'image', 
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'banner_text', 
                        name: 'banner_text',
                        orderable: false,
                        searchable: false
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

        function changeStatus(status, id) 
        {
            $.ajax(
            {
                type: "POST",
                url: '{{ route('sliders.status') }}',
                data: 
                {
                    "_token": "{{ csrf_token() }}",
                    "status": status,
                    "id": id
                },
                dataType: 'JSON',
                success: function(response) 
                {
                    if (response.success == 1) 
                    {
                        toastr.success(response.message);
                    } 
                    else 
                    {
                        toastr.error(response.message);
                    }
                }
            })
        }

        // Function for Delete Table
        function deleteSliders(slidersID) 
        {
            swal(
            {
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteSliders) => 
            {
                if (willDeleteSliders) 
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: '{{ route('sliders.destroy') }}',
                        data: 
                        {
                            "_token": "{{ csrf_token() }}",
                            'id': slidersID,
                        },
                        dataType: 'JSON',
                        success: function(response) 
                        {
                            if (response.success == 1) 
                            {
                                toastr.success(response.message);
                                $('#slidersTable').DataTable().ajax.reload();
                            } 
                            else 
                            {
                                swal(response.message, "", "error");
                            }
                        }
                    });
                } 
                else 
                {
                    swal("Cancelled", "", "error");
                }
            });
        }

    </script>

@endsection