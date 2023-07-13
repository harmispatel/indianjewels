@extends('admin.layouts.admin-layout')

@section('title', 'New Westage Discount')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Westage Discount</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('westage.discount') }}">Westage Discount</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- New Category add Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('westage.discount.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Westage Discount Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="dealers" class="form-label">Dealers<span class="text-danger">*</span></label>
                                                    <select name="dealers[]" id="dealers"
                                                        class="select2 form-control form-select {{ $errors->has('dealers') ? 'is-invalid' : '' }}"
                                                        multiple>
                                                        @if (count($dealers) > 0)
                                                            @foreach ($dealers as $dealer)
                                                                <option value="{{ $dealer->id }}" >{{ $dealer->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('dealers'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('dealers') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for = "code" class="form-label">Code<span class="text-danger">*</span></label>
                                                    <input type="text" name="code" id="code" value="{{old('code')}}" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" placeholder="Enter Code">
                                                    @if ($errors->has('code'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('code') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="start_date" class="form-label">Start Date<span class="text-danger">*</span></label>
                                                    <input type="date" name="start_date" id="start_date" value="{{old('start_date')}}" class="form-control {{$errors->has('start_date') ? 'is-invalid' : ''}}">
                                                    @if ($errors->has('start_date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('start_date') }}
                                                    </div>
                                                @endif
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date" class="form-label">End Date<span class="text-danger">*</span></label>
                                                    <input type="date" name="end_date" id="end_date" value="{{old('end_date')}}" class="form-control {{$errors->has('end_date') ? 'is-invalid' : ''}}" placeholder="Enter Mobile Number">
                                                    @if ($errors->has('end_date'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('end_date') }}
                                                        </div>
                                                    @endif

                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="discount_type" class="form-label">Discount Type<span class="text-danger">*</span></label>
                                                    <select name="discount_type" id="discount_type" value="{{old('discount_type')}}" class="form-control form-select {{ $errors->has('discount_type') ? 'is-invalid' : '' }}" >
                                                        <option value="">--Select Discount Type--</option>
                                                        <option value="1">percentage</option>
                                                        <option value="2">Fix</option>
                                                    </select>
                                                    @if ($errors->has('discount_type'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('discount_type') }}
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="value" class="form-label">Value<span class="text-danger">*</span></label>
                                                    <input type="number" name="value" id="value" value="{{old('value')}}" class="form-control {{ $errors->has('value') ? 'is-invalid' : ''}}" placeholder="Enter Value">
                                                    @if ($errors->has('value'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('value') }}
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="area" class="form-label">Area<span class="text-danger">*</span></label>
                                                <input type="text" name="area" id="area" value="{{old('area')}}" class="form-control {{$errors->has('area') ? 'is-invalid' : ''}}" placeholder="Enter Area">
                                                @if ($errors->has('area'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('area') }}
                                                        </div>
                                                    @endif
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
        $('#dealers').select2({
            placeholder: "-- select dealer --",
            allowClear: true

        });

        
        
    </script>
@endsection