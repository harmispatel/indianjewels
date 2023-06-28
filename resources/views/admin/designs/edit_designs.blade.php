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
                    <form class="form" action="{{ route('designs.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="container">
                                <div>
                                    <h3>General Information</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Item Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                    placeholder="Enter Item Name">
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
                                                    placeholder="Enter Item Code">
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
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
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
                                                    <option value="{{ $metal->id }}">{{ $metal->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('metal_id'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('metal_id') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tags" class="form-label">Tags<span
                                                    class="text-danger">*</span></label>
                                            <select name="tags[]" id="tags"
                                                class="select2 form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                                multiple>
                                                @if (count($tags) > 0)
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
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
                                                class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" cols="20" rows="5"></textarea>
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
                                                    role="switch" id="is_flash" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="highest_selling">Highest Selling Item</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="highest_selling" role="switch" id="highest_selling" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                    <h3>Company Selection Information</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="company" class="form-label">
                                                Company
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="company[]" id="company" class="select2 form-control" multiple>
                                                <option value="">--Select company--</option>
                                                <option value="1">Indian Jewelcast Pvt. Ltd.</option>
                                                <option value="2">Indian Art Cating</option>
                                                <option value="3">Impel Jewelley</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr> 
                                    <h3>Item Image Information</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">Main Image<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="images" class="form-label">Image<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="multiImage[]" id="images" class="form-control"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">{{ __('Save') }}</button>
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
    </script>
@endsection
