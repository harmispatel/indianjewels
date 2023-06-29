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
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('designs') }}" class="btn btn-sm new-amenity btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    {{-- New Clients add Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('designs.update') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>General Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <input type="hidden" name="id" value="{{ encrypt($data->id) }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Item Name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Item Name"
                                                        value="{{ isset($data->name) ? $data->name : old('name') }}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="code" class="form-label">Item Code<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="code" id="code"
                                                        class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Item Code"
                                                        value="{{ isset($data->code) ? $data->code : old('code') }}">
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
                                                            <option value="{{ $category->id }}"
                                                                @if ($data->category_id == $category->id) selected='selected' @endif>
                                                                {{ $category->name }}</option>
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
                                                <label for="gender_id" class="form-label">Gender Types<span
                                                        class="text-danger">*</span></label>
                                                <select name="gender_id" id="gender_id"
                                                    class="form-control {{ $errors->has('gender_id') ? 'is-invalid' : '' }}">
                                                    <option value="">-- Select Gender --</option>
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender->id }}"
                                                            @if ($data->gender_id == $gender->id) selected='selected' @endif>
                                                            {{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('gender_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('gender_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="metal_id" class="form-label">Metal Types<span
                                                        class="text-danger">*</span></label>
                                                <select name="metal_id" id="metal_id"
                                                    class="form-control {{ $errors->has('metal_id') ? 'is-invalid' : '' }}">
                                                    <option value="">-- Select Metal --</option>
                                                    @foreach ($metals as $metal)
                                                        <option value="{{ $metal->id }}"
                                                            @if ($data->metal_id == $metal->id) selected='selected' @endif>
                                                            {{ $metal->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('metal_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('metal_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            @php
                                                $tagselected = isset($data->tags) ? json_decode($data->tags) : '';
                                            @endphp
                                            <div class="col-md-6">
                                                <label for="tags" class="form-label">Tags</label>
                                                <select name="tags[]" id="tags"
                                                    class="select2 form-select {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                                    multiple>
                                                    @if (count($tags) > 0)
                                                        @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                @if ($tagselected) {{ in_array($tag->id, $tagselected) ? 'selected' : '' }} @endif>
                                                                {{ $tag->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('tags'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('tags') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="description" class="form-label">description</label>
                                                <textarea name="description" id="description"
                                                    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" cols="20" rows="5">{{ isset($data->description) ? $data->description : old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="is_flash">Is Flash Show?</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_flash"
                                                        role="switch" id="is_flash" value="1"
                                                        {{ $data->is_flash == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="highest_selling">Highest Selling Item</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="highest_selling" role="switch" id="highest_selling"
                                                        value="1" {{ $data->highest_selling == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Company Selection Information</h2>
                                    </div>
                                    @php
                                        $companyselected = isset($data->company) ? json_decode($data->company) : '';
                                    @endphp
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="company" class="form-label">
                                                    Company
    
                                                </label>
                                                <select name="company[]" id="company" class="select2 form-select" multiple>
                                                    <option value="">--Select company--</option>
                                                    <option value="1"
                                                        @if ($companyselected) {{ in_array(1, $companyselected) ? 'selected' : '' }} @endif>
                                                        Indian Jewelcast Pvt. Ltd.</option>
                                                    <option value="2"
                                                        @if ($companyselected) {{ in_array(2, $companyselected) ? 'selected' : '' }} @endif>
                                                        Indian Art Cating</option>
                                                    <option value="3"
                                                        @if ($companyselected) {{ in_array(3, $companyselected) ? 'selected' : '' }} @endif>
                                                        Impel Jewelley</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Weight & Wastage Information</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div>
                                            <h5>Weight :</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" name="weight1" class="form-control" step="any"
                                                        value="{{ isset($data->weight1) ? $data->weight1 : old('weight1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" name="weight2" class="form-control" step="any"
                                                        value="{{ isset($data->weight2) ? $data->weight2 : old('weight2') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" name="weight3" class="form-control" step="any"
                                                        value="{{ isset($data->weight3) ? $data->weight3 : old('weight3') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" name="weight4" class="form-control" step="any"
                                                        value="{{ isset($data->weight4) ? $data->weight4 : old('weight4') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5>Gross Weight :</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" name="gweight1" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->gweight1) ? $data->gweight1 : old('gweight1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" name="gweight2" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->gweight2) ? $data->gweight2 : old('gweight2') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" name="gweight3" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->gweight3) ? $data->gweight3 : old('gweight3') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" name="gweight4" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->gweight4) ? $data->gweight4 : old('gweight4') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5>Wastage :</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14 K / 68 Touch</label>
                                                    <input type="number" name="wastage1" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->wastage1) ? $data->wastage1 : old('wastage1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">18 K / 75 Touch</label>
                                                    <input type="number" name="wastage2" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->wastage2) ? $data->wastage2 : old('wastage2') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">20 K / 83 Touch</label>
                                                    <input type="number" name="wastage3" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->wastage3) ? $data->wastage3 : old('wastage3') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">22 K / 92 Touch</label>
                                                    <input type="number" name="wastage4" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->wastage4) ? $data->wastage4 : old('wastage4') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5>IAJ Gross Weight :</h5>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="form-label">14/18/20/22 K</label>
                                                    <input type="number" name="iaj_weight" class="form-control"
                                                        step="any"
                                                        value="{{ isset($data->iaj_weight) ? $data->iaj_weight : old('iaj_weight') }}">
    
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
                                                <label for="image" class="form-label">Main Image<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="image" id="image"
                                                    class="form-control">
                                                <div class="mt-2">
                                                    <img src="{{ asset('public/images/item_image/' . $data->image) }}"
                                                        alt="" width="100" height="100">
                                                </div>
                                            </div>

                                            @php
                                                $multiImg = isset($data->designImages) ? $data->designImages : '';
                                            @endphp
                                            <div class="col-md-6">
                                                <label for="images" class="form-label">Multiple Images</label>
                                                <input type="file" name="multiImage[]" id="images"
                                                    class="form-control" multiple>
                                                @if ($multiImg)
                                                    <div class="mt-2">
                                                        <div class="d-flex aline-item-center flex-wrap">
                                                            @foreach ($multiImg as $img)
                                                                <div class="mult-img-box">
                                                                    <a href="#"
                                                                        onclick="Imgdelete('{{ encrypt($img->id) }}')"
                                                                        class="img-delete"><i
                                                                            class="bi bi-trash text-danger"></i></a>
                                                                    <img class="ml-2"
                                                                        src="{{ asset('public/images/item_image/' . $img->image) }}"
                                                                        alt="" width="100" height="100">
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
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-success">Update</button>
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
        });
        $('#company').select2({
            placeholder: "-- select company --"
        });

        function Imgdelete(id) {
            $.ajax({
                url: "{{ route('designs-image.destroy') }}",
                type: 'post',
                dataType: 'JSON',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1300);

                }
            });

        }
    </script>
@endsection
