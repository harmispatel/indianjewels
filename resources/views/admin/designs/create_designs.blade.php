@extends('admin.layouts.admin-layout')

@section('title', 'Designs')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Designs</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('designs') }}">Designs</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
            
        </div>
    </div>
    {{-- New Clients add Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('designs.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>General Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">
                                                        Item Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Item Name" value="{{old('name')}}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="code" class="form-label">
                                                        Item Code
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="code" id="code"
                                                        class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Item Code" value="{{old('code')}}">
                                                    @if ($errors->has('code'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('code') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="category_id" class="form-label">
                                                        Category
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="category_id" id="category_id"
                                                        class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                                                        <option value="">-- Select Category --</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"  @if (old('category_id') == $category->id) {{ 'selected' }} @endif>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('code'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('code') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender_id" class="form-label">
                                                        Gender Types
                                                        <span class="text-danger">*</span></label>
                                                    <select name="gender_id" id="gender_id"
                                                        class="form-control {{ $errors->has('gender_id') ? 'is-invalid' : '' }}">
                                                        <option value="">-- Select Gender --</option>
                                                        @foreach ($genders as $gender)
                                                            <option value="{{ $gender->id }}" @if (old('gender_id') == $gender->id) {{ 'selected' }} @endif>{{ $gender->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('gender_id'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('gender_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="metal_id" class="form-label">
                                                        Metal Types
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="metal_id" id="metal_id"
                                                        class="form-control {{ $errors->has('metal_id') ? 'is-invalid' : '' }}">
                                                        <option value="">-- Select Metal --</option>
                                                        @foreach ($metals as $metal)
                                                            <option value="{{ $metal->id }}"  @if (old('metal_id') == $metal->id) {{ 'selected' }} @endif>{{ $metal->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('metal_id'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('metal_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tags" class="form-label">
                                                        Tags
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="tags[]" id="tags"
                                                        class="select2 form-control form-select {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                                        multiple>
                                                        @if (count($tags) > 0)
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->id }}" {{ in_array($tag->id, (array) old('tags', [])) ? "selected" : "" }}>{{ $tag->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('tags'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('tags') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="description" class="form-label">description</label>
                                                    <textarea name="description" id="description"
                                                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" cols="20" rows="5">{{old('description')}}</textarea>
                                                    @if ($errors->has('description'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('description') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="is_flash">Is Flash Show?</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_flash"
                                                            role="switch" id="is_flash" value="1">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="highest_selling">Top Selling Item</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="highest_selling" role="switch" id="highest_selling"
                                                            value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price" class="form-label">
                                                        Price
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="price" id="price"
                                                        class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Item price" value="{{old('price')}}">
                                                    @if ($errors->has('price'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('price') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Company Selection Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="company" class="form-label">
                                                        Company
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="company[]" id="company"
                                                        class="select2 form-control form-select {{ $errors->has('company') ? 'is-invalid' : '' }}"
                                                        multiple option value="">--Select company--</option>
                                                        @if (count($companies) > 0)
                                                            @foreach ($companies as $company)
                                                            <option value="{{ $company->id }}" {{ in_array($company->id, (array) old('company_id', [])) ? "selected" : "" }}>{{ $company->comapany_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                </div> -->
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Weight & Wastage Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div>
                                            <h5><b>Weight :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 </label>
                                                    <input type="number" name="weight1" class="form-control" step="any" value="{{old('weight1')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" name="weight2" class="form-control" step="any" value="{{old('weight2')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" name="weight3" class="form-control" step="any" value="{{old('weight3')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" name="weight4" class="form-control" step="any" value="{{old('weight4')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5><b>Gross Weight :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" name="gweight1" class="form-control" step="any" value="{{old('gweight1')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" name="gweight2" class="form-control" step="any" value="{{old('gweight2')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" name="gweight3" class="form-control" step="any" value="{{old('gweight3')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" name="gweight4" class="form-control" step="any" value="{{old('gweight4')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5><b>Wastage :</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" name="wastage1" class="form-control" step="any" value="{{old('wastage1')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" name="wastage2" class="form-control" step="any" value="{{old('wastage2')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" name="wastage3" class="form-control" step="any" value="{{old('wastage3')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" name="wastage4" class="form-control" step="any" value="{{old('wastage4')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5><b>IAJ Gross Weight :</b></h5>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14/18/20/22 K</label>
                                                    <input type="number" name="iaj_weight" class="form-control" step="any" value="{{old('iaj_weight')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Item Image Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="image" class="form-label">Main Image<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" name="image" id="image"
                                                        class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('image'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('image') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="images" class="form-label">Multiple Image</label>
                                                    <input type="file" name="multiImage[]" id="images"
                                                        class="form-control" multiple>
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
            placeholder: "-- select tags --",
            allowClear: true

        });
        // $('#company').select2({
        //     placeholder: "-- select company --",
        //     allowClear: true
        // });
    </script>
@endsection
