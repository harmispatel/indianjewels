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
                <a href="{{ route('categories.add-category') }}" class="btn btn-sm new-category edit_bt">
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
                                            <tr>
                                                <?php
                                                $dash = '';
                                                $status = $category->status;
                                                $checked = $status == 1 ? 'checked' : '';
                                                $checkVal = $status == 1 ? 0 : 1;
                                                $category_id = isset($category->id) ? $category->id : '';
                                                ?>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                @if ($category->image)
                                                    <td><img src="{{ asset('public/images/category_image/' . $category->image) }}"
                                                            alt="" width="100" height="100"></td>
                                                @else
                                                    <td><img src="{{ asset('public/images/category_image/not-found1.png') }}"
                                                            alt="" width="100" height="100"></td>
                                                @endif
                                                <td>
                                                    <div class="form-check form-switch"><input class="form-check-input"
                                                            type="checkbox" role="switch"
                                                            onchange="changeStatus('{{ $checkVal }}','{{ $category->id }}')"
                                                            id="statusBtn" {{ $checked }}></div>
                                                </td>
                                                <td><a href="{{ route('categories.edit-category', encrypt($category_id)) }}"
                                                        class="btn btn-sm edit_bt me-1"><i class="bi bi-pencil"></i></a>
                                                    <a onclick="deleteCategories('{{ encrypt($category_id) }}')"
                                                        class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                            @if (count($category->subcategory))
                                                @include('admin.categories.sub-category-list', [
                                                    'subcategories' => $category->subcategory,
                                                ])
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
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
                $(document).ready(function() {
                    $('#categoriesTable').DataTable({
                        "ordering": false,
                    });
                    // Toastr Options
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        timeOut: 10000
                    }
                });

                function changeStatus(status, id) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('categories.status') }}',
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
                function deleteCategories(categoriesID) {
                    swal({
                            title: "Are you sure You want to Delete It ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDeleteCategories) => {
                            if (willDeleteCategories) {
                                $.ajax({
                                    type: "POST",
                                    url: '{{ route('categories.destroy') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        'id': categoriesID,
                                    },
                                    dataType: 'JSON',
                                    success: function(response) {
                                        console.log(response);
                                        if (response.success == 1) {
                                            toastr.success(response.message);
                                            setTimeout(() => {
                                                location.reload();
                                            }, 1300);
                                        } else if(response.success == 2)  {
                                            swal(response.message, "", "error");
                                        } else if(response.success == 3){
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
