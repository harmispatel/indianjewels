@extends('admin.layouts.admin-layout')

@section('title', 'Categories')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Categories</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('categories') }}">Categories</a></li>
                        <li class="breadcrumb-item ">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Category Edit Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('categories.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Category Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <input type="hidden" name="category_id" id="category_id" value="{{ encrypt($category_details->id) }}">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" value="{{ $category_details->name }}" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Category Name">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="parent_category" class="form-label">Perent Category</label>
                                                    <select name="parent_category" id="parent_category" class="form-select">
                                                        <option value="0">Select Perent Category </option>
                                                        @if(count($categories) > 0)
                                                            @foreach($categories as $category)
                                                                @php
                                                                    $quote = "";
                                                                @endphp
                                                                <option value="{{ $category->id }}" {{ ($category_details->parent_category == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                @if(count($category->subcategories) > 0)
                                                                    @include('admin.categories.edit_child_categories',['sub_categories' => $category->subcategories])
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
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                                    <div class="mt-2">
                                                        @if(!empty($category_details->image) && file_exists('public/images/uploads/category_images/'.$category_details->image))
                                                            <img src="{{ asset('public/images/uploads/category_images/'.$category_details->image) }}" width="100">
                                                        @else
                                                            <img src="{{ asset('public/images/demo_others/no_image_2.png') }}" width="100">
                                                        @endif
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
