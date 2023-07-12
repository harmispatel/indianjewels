@extends('admin.layouts.admin-layout')

@section('title', 'Categories')

@section('content')

@php
$role = Auth::guard('admin')->user()->user_type;
$cat_add = Spatie\Permission\Models\Permission::where('name','categories.add')->first();
$cat_edit = Spatie\Permission\Models\Permission::where('name','categories.edit')->first();
$cat_delete = Spatie\Permission\Models\Permission::where('name','categories.destroy')->first();
$permissions = App\Models\RoleHasPermissions::where('role_id',$role)->pluck('permission_id');  
    foreach ($permissions as $permission) {
        $permission_ids[] = $permission;
    }
@endphp

{{-- Modal for Add New Tag & Edit Tag --}}
<div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog desktop_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form" id="CategoryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>Category Details</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name">
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for = "parent_category" class="form-label">Perent Category</label>
                                            <select name="parent_category" id="parent_category" class="form-select">
                                                <option value="">Select Perent Category</option>
                                                @if(count($categories) > 0)
                                                    @foreach($categories as $category)
                                                        @php
                                                            $quote = "";
                                                        @endphp
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @if(count($category->subcategories) > 0)
                                                            @include('admin.categories.child_categories',['subcategories' => $category->subcategories])
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>Category Image</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form_group">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                            <div class="form-group mt-2" id="catImage" style="display: none;">
                                            </div>
                                            @if ($errors->has('image'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('image') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a onclick="saveUpdateCategory('add')" class="btn form_button" id="saveupdatebtn">Save</a>
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
                @if((in_array($cat_add->id, $permission_ids))) 
                <a data-bs-toggle="modal" data-bs-target="#categoryModal" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
                @else
                <a data-bs-toggle="modal" data-bs-target="#categoryModal" class="btn btn-sm new-category custom-btn disabled" >
                    <i class="bi bi-plus-lg"></i>
                </a>
                 @endif
            </div>
        </div>
    </div>
    {{-- Category Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
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
                                                        <img src="{{ asset('public/images/uploads/category_images/no_image.jpg') }}" width="60">
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('{{ $checkVal }}','{{ encrypt($category->id) }}')" id="statusBtn" {{ $checked }}>
                                                    </div>
                                                </td>
                                                <td>
                                                @if((in_array($cat_edit->id, $permission_ids))) 
                                                    <a onclick="editCategory('{{ encrypt($category->id) }}')" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>
                                                    @else
                                                    <a onclick="editCategory('{{ encrypt($category->id) }}')" class="btn btn-sm custom-btn me-1 disabled"><i class="bi bi-pencil"></i></a>
                                                    @endif
                                                    @if((in_array($cat_delete->id, $permission_ids)))
                                                    <a onclick="deleteCategory('{{ encrypt($category->id) }}')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>
                                                    @else
                                                    <a onclick="deleteCategory('{{ encrypt($category->id) }}')" class="btn btn-sm btn-danger me-1 disabled"><i class="bi bi-trash"></i></a>
                                                    
                                                    @endif
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

         // Reset Coupon Modal
         $('.new-category').on('click', function()
        {
            // Reset CouponForm
            $('#CategoryForm').trigger('reset');

            

            // Empty Coupon ID
            $('#id').val('');

            // Remove Validation Class
            $('#name').removeClass('is-invalid');
            
            $('#image').removeClass('is-invalid');

            $('#catImage').html('');
            $('#catImage').hide();
            

            // Clear all Toastr Messages
            toastr.clear();

            // Change Modal Title
            $('#categoryModalLabel').html('');
            $('#categoryModalLabel').append('New Category');

            // Chage Button Name
            $('#saveupdatebtn').html('');
            $('#saveupdatebtn').append('Save');

            // Remove old Selected Options Value
            $('#parent_category option:selected').removeAttr('selected');
            

            // Change Button Value
            $('#saveupdatebtn').attr('onclick', "saveUpdateCategory('add')");
        });


        // Function for Save & Update Category
        function saveUpdateCategory(type)
        {
            // Data Type (Save/Update)
            var dType = type;
            if (dType == 'add')
            {
                var redirectUrl = "{{ route('categories.store') }}";
            }
            else
            {
                var redirectUrl = "{{ route('categories.update') }}";
            }

            // Get all form data from CouponForm
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
                    
                    if (response.success)
                    {
                        $('#CategoryForm').trigger('reset');
                        $('#categoryModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                                    location.reload();
                                }, 1200);
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
                        var imageError = (validationErrors.image) ? validationErrors.image : '';
                        if (imageError != '')
                        {
                            $('#image').addClass('is-invalid');
                            toastr.error(imageError);
                        }

                    }
                }
            });
        }


        // Function for Get Edit Coupon Data's
        function editCategory(categoryID)
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
                url: "{{ route('categories.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': categoryID,
                },
                success: function(response)
                {
                    
                    if (response.success)
                    {
                        // Category Data's
                        const category = response.data;
                        var default_image = "no_image.jpg";
                        var category_image = (category.image) ? category.image : default_image;

                        
                        // Add values in CouponForm
                        $('#name').val(category.name);
                        $('#id').val(category.id);
                        $("#parent_category option[value='" + category.parent_category + "']").attr("selected", "selected");
                        
                        // Show Image in CategoryForm
                        $('#catImage').html('');
                        $('#catImage').append('<img src="{{ asset('public/images/uploads/category_images') }}'+'/'+category_image+'" width="70">');
                        $('#catImage').show();

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



                        // Remove old Selected Options Value
                        

                        // Add New Selected Option
                        
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });
        }



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
