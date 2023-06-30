@extends('admin.layouts.admin-layout')

@section('title', __('Categories'))

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Categories</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.categories') }}">Categories</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('admin.categories') }}" class="btn btn-sm new-categories form_button">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- New Clients add Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Error Message Section --}}
            @if (session()->has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Success Message Section --}}
            @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
    
            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('categories.update-category') }}" method="POST" enctype="multipart/form-data"> 
                        <div class="card-body">
                        @csrf
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Categories Details</h2> 
                                </div>
                                <div class="form_box_info">
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{encrypt($data->id)}}">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="firstname" class="form-label">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $data->name }}" id="name"
                                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                    placeholder="Enter Name">
                                                @if ($errors->has('name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for = "parent_category" class="form-label">Perent Category</label>
                                                <select name="parent_category" id="parent_category" class="form-control">
                                                    <option value="0">Select Perent Categories </option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @if($data->parent_category== $category->id) selected='selected' @endif>{{ $category->name }}</option>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Categories Image</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form_group">
                                                    <label for="image" class="form-label">Image</label>
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
                                                    <div class="mt-2">
                                                        @if($data->image)
                                                            <img src="{{ asset('public/images/category_image/'.$data->image) }}" width="100" height="100">
                                                        @else
                                                            <img src="{{ asset('public/images/category_image/not-found1.png') }}" width="100" height="100">
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
                            <button class="btn form_button">Udpate</button>
                        </div>
                        </div>     
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection