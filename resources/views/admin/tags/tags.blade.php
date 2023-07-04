@extends('admin.layouts.admin-layout')

@section('title', 'Tags')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Tags</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tags</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a class="btn btn-sm btn-primary" id="addTags">
                    <i class="bi bi-plus-lg"></i>
                </a>
                <a class="btn btn-sm btn-danger" id="removeTags" style="display:none">
                    <i class="bi bi-x"></i>
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
                        <div class="card-title">                        
                            </div>
                            <form method="POST" action="{{ route('tags.update') }}" enctype="multipart/form-data" id="edit-form" style="display:none;">
                        <form method="POST" action="{{ route('tags.store') }}" enctype="multipart/form-data" id="store-form">                
                                @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="row" style="display: none;" id="tags">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Name <span
                                        class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Name" value="{{ isset($data->name) ? $data->name : '' }}" required>
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>                                    
                                </div>
                                <div class="col-md-3">
                                <button class="btn btn-success" id="saveupdatebtn">{{ __('Save') }}</button>
                                </div>
                            </div>
                            </form>
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="TagsTable">
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

        $(document).ready(function() 
        {
            $('#store-form').submit(function(e) 
            {
                e.preventDefault();
                var name = $('#name').val();
                $(".error").remove();

                if (name.length < 1) 
                {
                    $('#name').after('<span class="error">This Name field is required</span>');
                }
            });
        });        

        $('#addTags').on('click',function()
        {
            $('#tags').show();
            $('#removeTags').show();
            $('#addTags').hide();
            $('editTags').hide();
            $('#saveupdatebtn').html('');
            $('#saveupdatebtn').append('Save');
            $('#store-form').show();
            $('#edit-form').show();
        });
        
        $('#removeTags').on('click',function()
        {
            $('#tags').hide();
            $('#removeTags').hide();
            $('#addTags').show();
        });


        $(function() 
        {
            var table = $('#TagsTable').DataTable(
            {
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('tags.load') }}",
                columns: 
                [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
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

        function changeStatus(status, id) 
        {
            $.ajax(
            {
                type: "POST",
                url: '{{ route('tags.status') }}',
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

        // function editTag(tagId)
        // {
        //     $('#tags').show();
        //     $('#removeTags').show();
        //     $('#saveupdatebtn').html('');
        //     $('#saveupdatebtn').append('Update');
        //     $('#store-form').hide();
        //     $('#edit-form').show();
        //     $('#addTags').hide();
        //     $.ajax(
        //     {
        //         type: "POST",
        //         url :"{{ route('tags.edit') }}",
        //         dataType: 'JSON',
        //         data: 
        //         {
        //             "_token": "{{ csrf_token() }}",
        //             'id': tagId,
        //         },
        //         success: function(response) 
        //         {
        //             if (response.success == 1) 
        //             {
        //                 // console.log(response.data.name);
        //                 $('#id').val(response.data.id);
        //                 $('#name').val(response.data.name);
        //                 // toastr.success(response.message);
        //             } 
        //             else 
        //             {
        //                 swal(response.message, "", "error");
        //             }
        //         }
        //     });
        // }

        // Function for Get Edit Vendor Data's
        function editTag(tagId)
        {
            // $('#edit-form').trigger('reset');
            $('#tags').show();
            $('#removeTags').show();
            $('#saveupdatebtn').html('');
            $('#saveupdatebtn').append('Update');
            $('#store-form').hide();
            $('#edit-form').show();
            $('#addTags').hide();

            $.ajax({
                type: "POST",
                url: "{{ route('tags.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': tagId,
                },
                success: function(response)
                {
                    if (response.success == 1) 
                    {
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                    }
                    else 
                    {
                        swal(response.message, "", "error");
                    }
                }
            });
        }
        
        // Function for Delete Tags
        function deleteTag(tagId) 
        {
            swal(
            {
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteTags) => 
            {
                if (willDeleteTags) 
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: '{{ route('tags.destroy') }}',
                        data: 
                        {
                            "_token": "{{ csrf_token() }}",
                            'id': tagId,
                        },
                        dataType: 'JSON',
                        success: function(response) 
                        {
                            if (response.success == 1) 
                            {
                                toastr.success(response.message);
                                $('#TagsTable').DataTable().ajax.reload();
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
