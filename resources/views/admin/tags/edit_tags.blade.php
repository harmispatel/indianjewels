@extends('admin.layouts.admin-layout')

@section('title', 'Tags')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Tags</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('tags') }}">Tags</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('tags') }}" class="btn btn-sm new-amenity btn-primary">
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

                    <form class="form" action="{{ route('tags.update') }}" method="POST" enctype="multipart/form-data">

                        <div class="card-body">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Tags Details</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" name="id" value="{{ encrypt($data->id) }}">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                placeholder="Enter Name"
                                                value="{{ isset($data->name) ? $data->name : '' }}">
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
