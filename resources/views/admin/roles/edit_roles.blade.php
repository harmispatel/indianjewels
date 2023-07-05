@extends('admin.layouts.admin-layout')

@section('title', 'Roles')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>User Type</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('roles') }}">User Type</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('roles') }}" class="btn btn-sm new-amenity form_button">
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

                    <form class="form" action="{{ route('roles.update') }}" method="POST" enctype="multipart/form-data">

                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>User Type Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <input type="hidden" name="id" value="{{encrypt($role->id)}}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="firstname" class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Name" value="{{isset($role->name) ? $role->name : ''}}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prmission_box">
                                            <h3>Permission<span
                                                class="text-danger">*</span></h3>
                                            <div class="row">
                                                @foreach($permission as $value) 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" name="permission[]" value="{{$value->id}}" class="mr-3"  {{in_array($value->id,$rolePermissions) ? 'checked' : ''}}>
                                                            {{$value->name}}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            {{-- <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Roles Details</h3>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{encrypt($role->id)}}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                placeholder="Enter Name" value="{{isset($role->name) ? $role->name : ''}}">
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="" class="">Permission</label>
                                            </div>
                                            @foreach($permission as $value) 
                                                 <label><input type="checkbox" name="permission[]" value="{{$value->id}}" {{in_array($value->id,$rolePermissions) ? 'checked' : ''}}>{{$value->name}}</label>
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-footer text-center">
                                <button class="btn form_button">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
