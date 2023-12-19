@extends('admin.layouts.admin-layout')

@section('title', 'Impel Jewellers | Edit Dealer')

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
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Edit Dealer Form Section --}}
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form" action="{{ route('dealers.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Dealer Information</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id" value="{{ encrypt($data->id) }}">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">
                                                    Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Name" value="{{ isset($data->name) ? $data->name : '' }}">
                                                @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    Email
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Enter Dealer Email" value="{{ isset($data->email) ? $data->email : '' }}">
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
                                                <input type="number" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="Enter Mobile No." value="{{ isset($data->phone) ? $data->phone : '' }}">
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
                                                <input type="text" name="ref_name" id="ref_name" class="form-control {{ $errors->has('ref_name') ? 'is-invalid' : '' }}" placeholder="Enter Reference Name" value="{{ isset($data->ref_name) ? $data->ref_name : '' }}">
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
                                                <textarea name="address" id="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="2">{{ isset($data->address) ? $data->address : '' }}</textarea>
                                                @if ($errors->has('address'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pincode" class="form-label">Pincode<span class="text-danger">*</span></label>
                                                <input type="text" name="pincode" id="pincode" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" placeholder="Enter Pincode" value="{{ isset($data->pincode) ? $data->pincode : '' }}">
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
                                                    <option value="{{ $state->id }}" {{ ($state['id'] == $data->state) ? 'selected' : '' }}>{{ $state->name }}
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
                                                    @if(count($cities) > 0)
                                                    @foreach ($cities as $city)
                                                    <option value="{{ $city['id'] }}" {{ ($city['id'] == $data->city) ? 'selected' : '' }}>{{ $city['name'] }}</option>
                                                    @endforeach
                                                    @endif
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
                                                <input type="text" name="dealer_code" id="dealer_code" class="form-control {{ ($errors->has('dealer_code')) ? 'is-invalid' : '' }}" value="{{ $data['dealer_code'] }}">
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
                                                    <option value="percentage" {{ ($data['discount_type'] == 'percentage') ? 'selected' : '' }}>Percentage</option>
                                                    <option value="fixed" {{ ($data['discount_type'] == 'fixed') ? 'selected' : '' }}>Fixed</option>
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
                                                <input type="number" name="discount_value" id="discount_value" class="form-control {{ ($errors->has('discount_value')) ? 'is-invalid' : '' }}" value="{{ $data['discount_value'] }}">
                                                @if ($errors->has('discount_value'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('discount_value') }}
                                                    </div>
                                                @endif
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
                                                    <input type="text" name="comapany_name" id="comapany_name" class="form-control {{ $errors->has('comapany_name') ? 'is-invalid' : '' }}" placeholder="Enter Company Name" value="{{ isset($data->comapany_name) ? $data->comapany_name : '' }}">
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
                                                    <input type="text" name="gst_no" id="gst_no" class="form-control {{ $errors->has('gst_no') ? 'is-invalid' : '' }}" placeholder="Enter GST No." value="{{ isset($data->gst_no) ? $data->gst_no : '' }}">
                                                    @if ($errors->has('gst_no'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('gst_no') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" name="password"
                                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            id="password" placeholder="Enter Password"
                                            value="{{ old('password') }}">
                                            @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" name="confirm_password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" placeholder="Enter Confirm Password" value="{{ old('confirm_password') }}">
                                            @if ($errors->has('confirm_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                            @endif
                                        </div>

                                    </div> --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="whatsapp_no" class="form-label">Specific Whatsapp
                                                No.</label>
                                            <input type="number" name="whatsapp_no" class="form-control {{ $errors->has('whatsapp_no') ? 'is-invalid' : '' }}" id="whatsapp_no" placeholder="Enter Specific Whatsapp No." value="{{ isset($data->whatsapp_no) ? $data->whatsapp_no : '' }}">
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
                                <h2>Dealer Documents, Image & Company Logo Information</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="profile_picture" class="form-label">Profile Picture</label>
                                            <input type="file" name="profile_picture" id="profile_picture" class="form-control {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}">
                                            <div class="mt-2">
                                                @if (isset($data->profile) && !empty($data->profile) && file_exists('public/images/uploads/user_images/' . $data->profile))
                                                <img src="{{ asset('public/images/uploads/user_images/' . $data->profile) }}" alt="" width="100" height="100">
                                                @else
                                                <img src="{{ asset('public/images/default_images/profiles/profile1.jpg') }}" alt="" width="100" height="100">
                                                @endif

                                            </div>
                                            @if ($errors->has('profile_picture'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('profile_picture') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="company_logo" class="form-label">Company Logo</label>
                                            <input type="file" name="company_logo" id="company_logo" class="form-control {{ $errors->has('company_logo') ? 'is-invalid' : '' }}">
                                            <div class="mt-2">
                                                @if (isset($data->company_logo) && !empty($data->company_logo) && file_exists('public/images/uploads/companies_logos/' . $data->company_logo))
                                                <img src="{{ asset('public/images/uploads/companies_logos/' . $data->company_logo) }}" alt="" width="100" height="100">
                                                @else
                                                <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" alt="" width="100" height="100">
                                                @endif

                                            </div>
                                            @if ($errors->has('company_logo'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('company_logo') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document" class="form-label">Multiple Docs</label>
                                            <input type="file" name="document[]" id="document" class="form-control {{ $errors->has('document') ? 'is-invalid' : '' }}" multiple>
                                            @if ($errors->has('document'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('document') }}
                                            </div>
                                            @endif
                                            @if ($documents)
                                            <div class="mt-2">
                                                <div class="row">
                                                    @foreach ($documents as $document)
                                                    @php
                                                    $name = $document->document;
                                                    @endphp
                                                    <div class="col-md-6">
                                                        <a style="border: 2px solid #636363; padding:2px" href="{{ asset('public/images/uploads/documents/' . $name) }}" target="_blank" class="d-block text-dark">{{ $name }}</a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">Update</button>
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

</script>
@endsection
