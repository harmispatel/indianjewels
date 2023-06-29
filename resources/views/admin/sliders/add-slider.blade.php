@extends('admin.layouts.admin-layout')

@section('title', __('Sliders'))

@section('content')


{{-- Page Title --}}
    <div class="pagetitle">
        <h1>Sliders</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('sliders') }}">Sliders</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('sliders') }}" class="btn btn-sm new-sliders btn-primary">
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
            <form action="{{ route('sliders.store-slider') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Sliders Details</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image <span
                                        class="text-danger">*</span></label>
                                    <input type="file" name="image" id= "image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
                                    @if ($errors->has('image'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('image') }}
                                        </div>
                                    @endif<br>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="banner_text" class="form-label">Banner Text </label>
                                    <textarea name="banner_text" id="banner_text" class="form-control" placeholder="Enter Banner Text"></textarea>
                                </div>
                            </div>
                            <!-- <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror"
                                    id="status-select">
                                    <option value="1">Active</option>
                                    <option value="2">InActive</option>
                                </select>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection