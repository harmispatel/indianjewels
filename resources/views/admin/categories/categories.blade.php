@extends('admin.layouts.admin-layout')

@section('title', 'Categories')

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
                <a href="{{ route('categories.add') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div>


    {{-- Category Section --}}
    <section class="section dashboard">
        <div class="row">
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
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($categories))
                                        @foreach ($categories as $category)
                                            @php
                                                $status = $category->status;
                                                $checked = $status == 1 ? 'checked' : '';
                                                $checkVal = $status == 1 ? 0 : 1;
                                                $quote = "";
                                            @endphp
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    @if(!empty($category->image) && file_exists('public/images/uploads/category_images/'.$category->image))
                                                        <img src="{{ asset('public/images/uploads/category_images/'.$category->image) }}" width="60">
                                                    @else
                                                        <img src="{{ asset('public/images/demo_others/no_image_2.png') }}" width="60">
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('{{ $checkVal }}','{{ encrypt($category->id) }}')" id="statusBtn" {{ $checked }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('categories.edit', encrypt( $category->id)) }}" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>

                                                    <a onclick="deleteCategory('{{ encrypt($category->id) }}')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                            @if (count($category->subcategories))
                                                @include('admin.categories.sub_categories', ['subcategories' => $category->subcategories,])
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
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

        $(document).ready(function()
        {
            $('#categoriesTable').DataTable({
                "ordering": false,
            });

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

        });


        // Function for Change Status of Category
        function changeStatus(status, catId)
        {
            $.ajax({
                type: "POST",
                url: "{{ route('categories.status') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status,
                    "id": catId
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
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }


        // Function for Delete Category
        function deleteCategory(catId)
        {
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((deleteCategory) =>
            {
                if (deleteCategory)
                {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('categories.destroy') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': catId,
                        },
                        dataType: 'JSON',
                        success: function(response)
                        {
                            if (response.success == 1)
                            {
                                swal(response.message, "", "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 1300);
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
