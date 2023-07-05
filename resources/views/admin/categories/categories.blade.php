@extends('admin.layouts.admin-layout')

@section('title', __('Categories'))

@section('content')

{{-- Modal for Add New Category & Edit Category --}}
    <div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form" id="CategoryForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Category Name">
                                </div>
                            </div>
                            {{-- Categories --}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="parent_category" class="form-label">Categories</label>
                                    <select name="parent_category" id="parent_category" class="form-control">
                                    <option value="0">Select Perent Categories </option>
                                        @if(count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- Image --}}
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div><br>
                                <div class="form-group" id="categoryimage" style="display: none;"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a onclick="saveUpdateCategory('add')" class="btn btn-success" id="saveupdatebtn">Save</a>
                </div>
            </div>
        </div>
    </div>

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
                <a data-bs-toggle="modal" data-bs-target="#categoryModal" class="btn btn-sm new-category btn-primary">
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


           // Reset Category Modal
           $('.new-category').on('click', function()
        {
            // Reset CategoryForm
            $('#CategoryForm').trigger('reset');

            // Empty Category ID
            $('#id').val('');
            
            // Remove Validation Class
            $('#name').removeClass('is-invalid');
            $('#image').removeClass('is-invalid');
            
            // Clear all Toastr Messages
            toastr.clear();
            
            // Remove image Section
            $('#categoryimage').html('')
            $('#categoryimage').hide();
            
            // Change Modal Title
            $('#categoryModalLabel').html('');
            $('#categoryModalLabel').append('New Category');
            
            // Chage Button Name
            $('#saveupdatebtn').html('');
            $('#saveupdatebtn').append('Save');
            
            // Change Button Value
            $('#saveupdatebtn').attr('onclick', "saveUpdateCategory('add')");
            
            // Intialized Categories SelectBox
            $('#parent_category option:selected').removeAttr('selected').trigger('reset');
            $("#parent_category").select({
                dropdown: $("#categoryModal"),
                placeholder: "Select Perent Categories",
            });
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
                pageLength: 100,
                ajax: "{{ route('categories.load-categories') }}",
                // order: [0, 'desc'],
                columns: [
                    {
                        data: 'id', 
                        name: 'id'
                    },
                    {
                        data: 'name', 
                        name: 'name'
                    },
                    {
                        data: 'image', 
                        name: 'image', 
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

        // Function for Save & Update Categories
        function saveUpdateCategory(type)
        {
            // Data Type (Save/Update)
            var dType = type;
            if (dType == 'add')
            {
                var redirectUrl = "{{ route('categories.store-category') }}";
            }
            else
            {
                var redirectUrl = "{{ route('categories.update-category') }}";
            }

            // Get all form data from CategoryForm
            myFormData = new FormData(document.getElementById('CategoryForm'));

            // Remove Validation Class
            $('#name').removeClass('is-invalid');
            $('#image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: redirectUrl,
                data: myFormData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#CategoryForm').trigger('reset');
                        $('#categoryModal').modal('hide');
                        toastr.success(response.message);
                        loadCategories();
                    }
                    else
                    {
                        $('#CategoryForm').trigger('reset');
                        $('#categoryModal').modal('hide');
                        toastr.error(response.message);
                    }
                },
                error: function(response)
                {
                    // All Validation Errors
                    const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                    if (validationErrors != '')
                    {
                        // Name Error
                        var nameError = (validationErrors.name) ? validationErrors.name : '';
                        if (nameError != '')
                        {
                            $('#name').addClass('is-invalid');
                            toastr.error(nameError);
                        }

                        // Image Error
                        var imageError = (validationErrors.icon) ? validationErrors.icon : '';
                        if (imageError != '')
                        {
                            $('#image').addClass('is-invalid');
                            toastr.error(imageError);
                        }
                    }
                }
            });
        }

        // Function for Get Edit Categories Data's
        function editCategory(categoriesID)
        {
            // Reset CategoryForm
            $('#CategoryForm').trigger('reset');

            // Remove Validation Class
            $('#name').removeClass('is-invalid');
            $('#image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('categories.edit-category') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': categoriesID,
                },
                success: function(response)
                {
                    if (response.success)
                    {
                        // categories Data's
                        const categories = response.data;

                        // Images
                        const default_image = "public/images/category_image/not-found1.png";
                        const categories_image = (categories.image) ? categories.image : default_image;
                        
                        // Add values in CategoryForm
                        $('#name').val(categories.name);
                        $('#id').val(categories.id);
                        $('#parent_category').val(categories.parent_category);
                        
                        // Show image in VendorForm
                        $('#categoryimage').html('')
                        $('#categoryimage').append('<img src="{{ asset('/') }}'+ categories_image +'" width="50">');
                        $('#categoryimage').show();

                        // Change Modal Title
                        $('#categoryModalLabel').html('');
                        $('#categoryModalLabel').append('Edit Category');

                        // Chage Button Name
                        $('#saveupdatebtn').html('');
                        $('#saveupdatebtn').append('Update');

                        // Show Modal
                        $('#categoryModal').modal('show');

                        // Change Button Value
                        $('#saveupdatebtn').attr('onclick', "saveUpdateCategory('edit')");

                        $('#parent_category option:selected').removeAttr('selected');
                        $("#parent_category option[value='" + categories.perent_category + "']").prop("selected", "selected");
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });
        }


        // Function for Delete Table
        function deleteCategories(categoriesID) 
        {
            swal(
            {
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteCategories) => 
            {
                if (willDeleteCategories) 
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: '{{ route('categories.destroy') }}',
                        data: 
                        {
                            "_token": "{{ csrf_token() }}",
                            'id': categoriesID,
                        },
                        dataType: 'JSON',
                        success: function(response) 
                        {
                            if (response.success == 1) 
                            {
                                toastr.success(response.message);
                                $('#categoriesTable').DataTable().ajax.reload();
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

        function changeStatus(status, id) 
        {
            $.ajax(
            {
                type: "POST",
                url: '{{ route('categories.status') }}',
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

    </script>

@endsection