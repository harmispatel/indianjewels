@extends('admin.layouts.admin-layout')

@section('title', __('Sliders'))

@section('content')

{{-- Modal for Add New Slider & Edit Slider --}}
    <div class="modal fade" id="sliderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sliderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sliderModalLabel">New Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="javascript:void(0)" class="form" id="SliderForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>Slider</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Image <span
                                                class="text-danger">*</span></label>
                                            <input type="file" name="image" id= "image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
                                            <div class="form-group" id="sliderimage" style="display: none;"></div>
                                            @if ($errors->has('image'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('image') }}
                                                </div>
                                            @endif<br>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="banner_text" class="form-label">Banner Text </label>
                                            <textarea name="banner_text" id="banner_text" class="form-control" placeholder="Enter Banner Text"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a onclick="saveUpdateSlider('add')" class="btn btn-success" id="saveupdatebtn">Save</a>
                </div>
            </div>
        </div>
    </div>

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
                <a data-bs-toggle="modal" data-bs-target="#sliderModal" class="btn btn-sm new-slider custom-btn">
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
    </section>    

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

    // Reset Slider Modal
    $('.new-slider').on('click', function()
    {
        // Reset SliderForm
        $('#SliderForm').trigger('reset');

        // Empty Slider ID
        $('#id').val('');

        // Remove Validation Class
        $('#image').removeClass('is-invalid');

        $('#sliderimage').html('')
        $('#sliderimage').hide();

        // Clear all Toastr Messages
        toastr.clear();

        // Change Modal Title
        $('#sliderModalLabel').html('');
        $('#sliderModalLabel').append('New Slider');

        // Chage Button Name
        $('#saveupdatebtn').html('');
        $('#saveupdatebtn').addClass('custom-btn');
        $('#saveupdatebtn').append('Save');

        // Change Button Value
        $('#saveupdatebtn').attr('onclick', "saveUpdateSlider('add')");
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
        slidersTable = $('#slidersTable').DataTable(
        {
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: "{{ route('sliders.load-sliders') }}",
            columns: 
            [
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


    // Function for Save & Update Sliders
    function saveUpdateSlider(type)
    {
        // Data Type (Save/Update)
        var dType = type;
        if (dType == 'add')
        {
            var redirectUrl = "{{ route('sliders.store-slider') }}";
        }
        else
        {
            var redirectUrl = "{{ route('sliders.update-slider') }}";
        }

        // Get all form data from SliderForm
        myFormData = new FormData(document.getElementById('SliderForm'));

        // Remove Validation Class
        $('#image').removeClass('is-invalid');

        // Clear all Toastr Messages
        toastr.clear();
        $.ajax(
        {
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
                    $('#SliderForm').trigger('reset');
                    $('#sliderModal').modal('hide');
                    toastr.success(response.message);
                    loadSliders();
                }
                else
                {
                    $('#SliderForm').trigger('reset');
                    $('#sliderModal').modal('hide');
                    toastr.error(response.message);
                }
            },
            error: function(response)
            {
                // All Validation Errors
                const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';
                if (validationErrors != '')
                {
                    // image Error
                    var ImageError = (validationErrors.image) ? validationErrors.image : '';
                    if (ImageError != '')
                    {
                        $('#image').addClass('is-invalid');
                        toastr.error(ImageError);
                    }
                }
            }
        });
    }


    // Function for Get Edit Sliders Data's
    function editSlider(slidersID)
    {
        // Reset SliderForm
        $('#SliderForm').trigger('reset');

        // Remove Validation Class
        $('#image').removeClass('is-invalid');

        // Clear all Toastr Messages
        toastr.clear();

        $.ajax(
        {
            type: "POST",
            url: "{{ route('sliders.edit-slider') }}",
            dataType: "JSON",
            data: 
            {
                '_token': "{{ csrf_token() }}",
                'id': slidersID,
            },
            success: function(response)
            {
                if (response.success)
                {
                    // Sliders Data's
                    const sliders = response.data;
                    const default_image = "public/images/uploads/slider_image/no_image.jpg";
                    const Simage = (sliders.image) ? sliders.image : default_image;

                    // Add values in SliderForm
                    $('#banner_text').val(sliders.banner_text);
                    $('#id').val(sliders.id);

                    $('#sliderimage').html('')
                    $('#sliderimage').append('<img src="{{ asset('public/images/uploads/slider_image') }}/'+Simage+'" width="70" height="70">');
                    $('#sliderimage').show();

                    // Change Modal Title
                    $('#sliderModalLabel').html('');
                    $('#sliderModalLabel').append('Edit Slider');

                    // Chage Button Name
                    $('#saveupdatebtn').html('');
                    $('#saveupdatebtn').append('Update');

                    // Show Modal
                    $('#sliderModal').modal('show');

                    // Change Button Value
                    $('#saveupdatebtn').attr('onclick', "saveUpdateSlider('edit')");
                }
                else
                {
                    toastr.error(response.message);
                }
            }
        });
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

</script>

@endsection