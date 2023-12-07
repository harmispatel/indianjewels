@extends('admin.layouts.admin-layout')
@section('title', 'Impel Jewellers | Create Dealer')
@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>Dealers</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item "><a href="{{ route('dealers') }}">Dealers</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- New Dealer Form Section --}}
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form" action="{{ route('dealers.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Dealer Information</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Name" value="{{ old('name') }}">
                                                @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Email" value="{{ old('email') }}">
                                                @if ($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">
                                                    Mobile
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="Enter Mobile No." value="{{ old('phone') }}">
                                                @if ($errors->has('phone'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ref_name" class="form-label">
                                                    Reference Name
                                                </label>
                                                <input type="text" name="ref_name" id="ref_name" class="form-control {{ $errors->has('ref_name') ? 'is-invalid' : '' }}" placeholder="Enter Reference Name" value="{{ old('ref_name') }}">
                                                @if ($errors->has('ref_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('ref_name') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="address" class="form-label">
                                                    Address
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="address" id="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="2">{{ old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="address" class="form-label">
                                                    Pincode
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="pincode" id="pincode" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" value="{{ old('pincode') }}">
                                                @if ($errors->has('pincode'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('pincode') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="state" class="form-label">
                                                    State
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="state" id="state" class="form-select {{ ($errors->has('state')) ? 'is-invalid' : '' }}">
                                                    <option value="">Choose State</option>
                                                    @if (count($states) > 0)
                                                    @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('state'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('state') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="city" class="form-label">
                                                    City
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="city" id="city" class="form-select {{ ($errors->has('city')) ? 'is-invalid' : '' }}">
                                                    <option value="">Choose City</option>
                                                </select>
                                                @if ($errors->has('city'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('city') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="dealer_code" class="form-label">Dealer Code <span class="text-danger">*</span></label>
                                                <input type="text" name="dealer_code" id="dealer_code" class="form-control {{ ($errors->has('dealer_code')) ? 'is-invalid' : '' }}" value="{{ old('dealer_code') }}">
                                                @if ($errors->has('dealer_code'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('dealer_code') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="discount_type" class="form-label">Discount Type</label>
                                                <select name="discount_type" id="discount_type" class="form-select">
                                                    <option value="percentage">Percentage</option>
                                                    <option value="fixed">Fixed</option>
                                                </select>
                                                @if ($errors->has('discount_type'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('discount_type') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                                                <input type="number" name="discount_value" id="discount_value" class="form-control {{ ($errors->has('discount_value')) ? 'is-invalid' : '' }}" value="{{ old('discount_value') }}">
                                                @if ($errors->has('discount_value'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('discount_value') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Company Information</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="comapany_name" class="form-label">
                                                    Company Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="comapany_name" id="comapany_name" class="form-control {{ $errors->has('comapany_name') ? 'is-invalid' : '' }}" placeholder="Enter Company Name" value="{{ old('comapany_name') }}">
                                                @if ($errors->has('comapany_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('comapany_name') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gst_no" class="form-label">GST No.<span class="text-danger">*</span></label>
                                                <input type="text" name="gst_no" id="gst_no" class="form-control {{ $errors->has('gst_no') ? 'is-invalid' : '' }}" placeholder="Enter GST No." value="{{ old('gst_no') }}">
                                                @if ($errors->has('gst_no'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('gst_no') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" placeholder="Enter Password" value="{{ old('password') }}">
                                                @if ($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="confirm_password" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                                <input type="password" name="confirm_password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" placeholder="Enter Confirm Password" value="{{ old('confirm_password') }}">
                                                @if ($errors->has('confirm_password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('confirm_password') }}
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="whatsapp_no" class="form-label">Specific Whatsapp
                                                    No.</label>
                                                <input type="number" name="whatsapp_no" class="form-control {{ $errors->has('whatsapp_no') ? 'is-invalid' : '' }}" id="whatsapp_no" placeholder="Enter Specific Whatsapp No." value="{{ old('whatsapp_no') }}">
                                                @if ($errors->has('whatsapp_no'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('whatsapp_no') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Dealer Document & Company Logo Information</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="logo" class="form-label">Logo</label>
                                                <input type="file" name="logo" id="logo" class="form-control {{ $errors->has('logo') ? 'is-invalid' : '' }}">
                                                @if ($errors->has('logo'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('logo') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="document" class="form-label">Multiple Docs</label>
                                                <input type="file" name="document[]" id="document" class="form-control {{ $errors->has('document') ? 'is-invalid' : '' }}" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn form_button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-js')
<script type="text/javascript">
    $('#tags').select2({
        placeholder: "-- select tags --"
        , allowClear: true

    });
    $('#company').select2({
        placeholder: "-- select company --"
        , allowClear: true
    });

    // Get Cities When Change State
    $('#state').on('change', function() {
        $.ajax({
            type: "POST"
            , url: "{{ route('states.cities') }}"
            , data: {
                "_token": "{{ csrf_token() }}"
                , "state_id": $(this).val()
            , }
            , dataType: "JSON"
            , success: function(response) {
                if (response.success == 1) {
                    $('#city').html('');
                    $('#city').append(response.cities);
                } else {
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
