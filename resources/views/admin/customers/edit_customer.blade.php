@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers | Edit Customer')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Customers</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('customers') }}">Customers</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- New Customer Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('customers.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Customer Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <input type="hidden" name="customer_id" id="customer_id" value="{{ encrypt($customer->id) }}">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Name" value="{{ isset($customer->name) ? $customer->name : '' }}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Enter Email" value="{{ isset($customer->email) ? $customer->email : '' }}">
                                                    @if ($errors->has('email'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('email') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">Phone No. <span class="text-danger">*</span></label>
                                                    <input type="number" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="Enter Phone No." value="{{ isset($customer->phone) ? $customer->phone : '' }}">
                                                    @if ($errors->has('phone'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('phone') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="gst_no" class="form-label">GST No.</label>
                                                    <input type="text" name="gst_no" id="gst_no" class="form-control {{ $errors->has('gst_no') ? 'is-invalid' : '' }}" placeholder="Enter GST No." value="{{ isset($customer->gst_no) ? $customer->gst_no : '' }}" maxlength="15">
                                                    @if ($errors->has('gst_no'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('gst_no') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="pan_no" class="form-label">PAN No.</label>
                                                    <input type="text" name="pan_no" id="pan_no" class="form-control {{ $errors->has('pan_no') ? 'is-invalid' : '' }}" placeholder="Enter Pan No." value="{{ isset($customer->pan_no) ? $customer->pan_no : '' }}" maxlength="10">
                                                    @if ($errors->has('pan_no'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('pan_no') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="pincode" class="form-label">Pincode</label>
                                                    <input type="text" name="pincode" id="pincode" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" placeholder="Enter Pincode" value="{{ isset($customer->pincode) ? $customer->pincode : '' }}">
                                                    @if ($errors->has('pincode'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('pincode') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter Address">{{ isset($customer->address) ? $customer->address : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="state" class="form-label">State</label>
                                                    <select name="state" id="state" class="form-select">
                                                        <option value="">Choose State</option>
                                                        @if(count($states) > 0)
                                                            @foreach ($states as $state)
                                                                <option value="{{ $state['id'] }}" {{ ($state['id'] == $customer->state) ? 'selected' : '' }}>{{ $state['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="city" class="form-label">City</label>
                                                    <select name="city" id="city" class="form-select">
                                                        <option value="">Choose City</option>
                                                        @if(count($cities) > 0)
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city['id'] }}" {{ ($city['id'] == $customer->city) ? 'selected' : '' }}>{{ $city['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button class="btn form_button">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
    <script type="text/javascript">

        // Get Cities When Change State
        $('#state').on('change', function(){
            $.ajax({
                type: "POST",
                url: "{{ route('states.cities') }}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "state_id" : $(this).val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.success == 1){
                        $('#city').html('');
                        $('#city').append(response.cities);
                    }else{
                        toastr.error(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1200);
                    }
                }
            });
        });

    </script>
@endsection
