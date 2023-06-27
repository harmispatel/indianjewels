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
                <a href="{{ route('admin.categories') }}" class="btn btn-sm new-categories btn-primary">
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
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Categories Details</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                        <div class="form-group">
                                        <label for="firstname" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ $data->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Name">
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
                                                <option value="">Select Perent Categories  </option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @if($data->parent_category== $category->id) selected='selected' @endif>{{ $category->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                        <label for="image" class="form-label">Image </label>
                                            <input type="file" name="image" class="form-control" placeholder="image">
                                            @if($data->image)
                                            <img src="{{ asset('public/images/category_image/'.$data->image) }}" width="50px" height="50px">
                                            @else
                                            <img src="{{ asset('public/images/category_image/not-found1.png') }}" width="50px" height="50px">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                        <label for="status" class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option {{ ($data->status) == '1' ? 'selected' : '' }} value="1">Active</option>
                                                <option {{ ($data->status) == '0' ? 'selected' : '' }}  value="0">InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>     
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection